<?php

namespace heychum\Http\Controllers;

use heychum\Comment;
use heychum\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $comment = new Comment;
        $comment->body = $request->get('comment_body');
        $comment->user()->associate($request->user());
        $post = Post::find($request->get('post_id'));
        // $comment->comment_id = $post->id;
        // $comment->comment_id = $post->id;
        $post->comments()->save($comment);
        // $comment->comment
        /*dd($comment);*/
        return back();
    }

     public function replyStore(Request $request)
    {
        $reply = new Comment();
        $reply->body = $request->get('comment_body');
        $reply->user()->associate($request->user());
        $reply->parent_id = $request->get('comment_id');
        $post = Post::find($request->get('post_id'));

        $post->comments()->save($reply);

        return back();

    }
}
