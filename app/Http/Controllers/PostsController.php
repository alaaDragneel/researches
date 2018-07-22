<?php

namespace MixCode\Http\Controllers;

use Illuminate\Http\Request;
use MixCode\Post;
use Carbon\Carbon;
use MixCode\Notifications\NewPost;
use Rap2hpoutre\FastExcel\FastExcel;
use MixCode\Http\Requests\CsvImportRequest;
use MixCode\CsvData;
use Excel;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        flash('Hallo');
        flash('Hallo')->warning()->success('Welcome');
        flash('Hallo')->error();
        flash('Hallo')->warning()->important();
        flash('Hallo')->important();

        return view('posts', ['posts' => Post::all()]);
    }

    public function search()
    {
        return Post::search(request('search'))->get();
    }

    public function carbon()
    {
        $dt         = Carbon::createFromDate(1998, 2, 04);
        $birthDay   = Carbon::createFromDate(2018, 2, 04);
        $knownDate = Carbon::create(2001, 5, 21, 12);  // create testing date
        
        Carbon::setTestNow($knownDate);                     // set the mock 
        
        $data = [
            'isPast'            => $dt->isPast(),
            'birth-day'         => $dt->isBirthday($birthDay),
            'end-of-month'      => $dt->endOfMonth(),
            'end-of-year'       => $dt->endOfYear(),
            'today'             => Carbon::today(),
            'tomorrow'          => Carbon::tomorrow(),
            'yesterday'         => Carbon::yesterday(),
            'diffForHumans'     => Carbon::now()->subDays(5)->diffForHumans(),
            'now-with-testing'  => Carbon::now(),
        ];

        return $data;
    }

    public function create()
    {
        return view('create');
    }

    public function store()
    {
        $request = request(['title', 'body']) + ['user_id' => auth()->id()];

        $post = Post::create($request);
        
        auth()->user()->notify(new NewPost($post));

        flash('Your Post Created Successfully')->success()->important();

        return redirect()->route('posts.show', $post);
    }

    public function show(Post $post)
    {
        return view('show', compact('post'));
    }

    public function destroy(Post $post)
    {
        $post->delete();

        flash('Your Post Deleted Successfully')->success()->important();

        return redirect()->route('posts.index');
    }

    public function download($type)
    {
        $posts = Post::latest()->limit(10)->get();
        
        (new FastExcel($posts))->download("posts.{$type}");

        return back();
        
    }

    public function archive(Post $post)
    {
        $post->archive();

        return response()->json('Post Archived', 200);
    }

    public function unArchive(Post $post)
    {
        $post->unArchive();

        return response()->json('Post UnArchived', 200);
    }

    public function import()
    {
        return view('import');
    }

    public function importParse(CsvImportRequest $request)
    {
        $path = $request->file('csv_file')->getRealPath();
       
       if ($request->has('header')) {
            $data = Excel::load($path, function($reader) {})->get()->toArray();
        } else {
            $data = array_map('str_getcsv', file($path));
        }

        if (count($data) > 0) {
            if ($request->has('header')) {
                $csv_header_fields = [];
                foreach ($data[0] as $key => $value) {
                    $csv_header_fields[] = $key; 
                }
            }

            // Store The Csv File Data In Table  Because We Return Only Two Records
            $csv_data_file = CsvData::create([
                'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
                'csv_header' => $request->has('header'),
                'csv_data' => json_encode($data)
            ]);


            // I’m doing the slicing of only first two lines cause they are enough to show, 
            // so user would understand which value is in which column. No need to show whole CSV here.
            $csv_data = array_slice($data, 0, 2);
            
        } else {
            return back();
        }


        return view('import_fields', compact('csv_header_fields', 'csv_data', 'csv_data_file'));
    }

    public function importProcess(Request $request)
    {
        $data = CsvData::find($request->csv_data_file_id);
        $csv_data = json_decode($data->csv_data, true);
        
        foreach ($csv_data as $row) {
            $post = new Post();
            foreach (config('app.db_fields') as $index => $field) {
                // if ($field == 'archive') continue;
                // $row is array with 0, 1, 2
                // $reuqest->fields is array that we choosed with 1, 0, 2
                // We get the fiedls index from out config for example we will take the title that will 0 key index in the array
                // get $reuqest->fields[index == 0] then we will get the second element in this array that will equal 0
                // $row[$request->fields[$index === 0] === 0] then we will get the first element in this array that will equal 0
                // same as we has header the difrent we will work with assossiated array insted of indexed array 
                if ($data->csv_header) {
                    $post->$field = $row[$request->fields[$field]];
                } else {
                    $post->$field = $row[$request->fields[$index]];
                }
            }
            $post->user_id = auth()->id();
            $post->save();
        }

        return redirect()->route('posts.index');
    }
}
