<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth'); // all methods and their urls
        $this->middleware('auth')->except(['show', 'init']);
    }

    // espera el User x el route model binding
    public function init(User $user)
    {
        // solo estas queries pueden ser paginables asi de facil
        $posts = Post::where('user_id', $user->id)->latest()->paginate(20);

        return view('dashboard', [
            'user' => $user,
            'posts' => $posts,
            // 'posts' => $user->posts, // <- collections/relations - NO pagining
        ]);
    }

    // create para forms de creacion - GET
    public function create()
    {
        return view('posts.create');
    }

    // atiende a POST y store in DB
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'required'
        ]);

        // // insert record in db
        // 1) Normal way
        // Post::create([
        //     'title' => $request->title,
        //     'description' => $request->description,
        //     'image' => $request->image,
        //     'user_id' => auth()->user()->id,
        // ]);

        // 2) long way
        // $post = new Post();
        // $post->title = $request->title;
        // $post->description = $request->description;
        // $post->image = $request->image;
        // $post->user_id = auth()->user()->id;
        // $post->save();

        // 3) Laravel way <- relations between tables | with it we don't need where sql statements in sql queries - but i lose pagining
        $request->user()->posts()->create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->image,
            'user_id' => auth()->user()->id,
        ]);


        return redirect()->route('posts.index', auth()->user()->username);
    }

    public function show(User $user, Post $post)
    {
        return view('posts.show', [
            'post' => $post,
            'user' => $user,
        ]);
    }

    public function destroy(Post $post)
    {
        // validate with policy
        $this->authorize('delete', $post);

        // delete al q se pasa x route model binding
        $post->delete();

        // delete post image
        $imagePath = public_path('uploads/' . $post->image);
        if (File::exists($imagePath)) {
            unlink($imagePath);
        }

        return redirect()->route('posts.index', auth()->user()->username);
    }
}
