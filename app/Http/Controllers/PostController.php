<?php

namespace MixCode\Http\Controllers;

use Illuminate\Http\Request;
use MixCode\Post;
use Carbon\Carbon;

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

    public function show(Post $post)
    {
        return $post;
    }
}
