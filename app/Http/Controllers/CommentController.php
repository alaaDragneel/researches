<?php

namespace MixCode\Http\Controllers;

use MixCode\Post;
use MixCode\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        $comments = $post->comments()->with('author')->latest('id')->get();
        return response($comments, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {
        $data = $request->validate([
            'body' => 'required|string'
        ]);

        $comment = $post->comments()->create($data + ['user_id' => auth()->id()]);

        $comment->load('author');

        return response($comment, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \MixCode\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $post, Comment $comment)
    {
        $data = $request->validate([
            'body' => 'required|string'
        ]);

        $comment->update($data);

        $comment->load('author');

        return response($comment, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \MixCode\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response( null,204);
    }
}
