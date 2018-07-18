<?php

namespace MixCode\Http\Controllers;

use Illuminate\Http\Request;
use MixCode\Post;
use Carbon\Carbon;
use MixCode\Notifications\NewPost;
use Rap2hpoutre\FastExcel\FastExcel;

class PostController extends Controller
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
        $post = Post::create(request(['title', 'body']));
        
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
}
