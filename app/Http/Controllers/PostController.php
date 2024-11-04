<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;

use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Post::with('tags')->get();
        return view('posts',with(['posts'=> $post]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create',with(['tags'=> Tag::all()]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $post = Post::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        $post->tags()->attach($request->tags);


        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // return Request();
        $post = Post::find($id);
        $post->tags()->detach();
        $post->delete();
        return back();
    }
}
