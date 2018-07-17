<?php

namespace MixCode\Http\Controllers;

use Illuminate\Http\Request;
use MixCode\Post;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('posts');
    }

    public function search()
    {
       return Post::search(request('search'))->get();
    }
}
