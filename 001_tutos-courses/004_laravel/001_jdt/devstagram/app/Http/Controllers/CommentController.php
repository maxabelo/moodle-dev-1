<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // user/post vienen x el router model binding - el user es el owner del Post, NO quien comenta. Quien comenta es el Authenticated User
    public function store(Request $request, User $user, Post $post)
    {
        // // validate
        $this->validate($request, [
            'comment' => 'required|max:255'
        ]);

        // // persist
        Comment::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comment' => $request->comment,

        ]);

        // // print message and redirect
        return back()->with('success_message', 'Comment sent successfully');
    }
}
