<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use PHPUnit\TextUI\Configuration\Constant;

class PostController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->search)) {
            $posts = Post::where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%')->paginate(9);
        } else {
            $posts = Post::paginate(9);
        }
        return view('posts.index', ['posts' => $posts]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $post = new Post();

        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = $request->author;

        $post->save();

        return redirect()->route('posts.index');
    }

    public function show($post)
    {
        $post = Post::findOrFail($post);

        return view('posts.show', ["post" => $post]);
    }

    public function edit($post)
    {
        $post = Post::findOrFail($post);

        return view('posts.edit', ["post" => $post]);
    }

    public function update(Request $request)
    {
        $post = Post::findOrFail($request->post_id);

        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = $request->author;

        $post->save();
        return redirect()->route('posts.show', $post->id);
    }

    public function destroy(Request $request)
    {
        $post = Post::findOrFail($request->post_id);
        $post->delete();

        return redirect()->route('posts.index');
    }

    public function deleted()
    {
        $posts = Post::onlyTrashed()->paginate(9);
        return view('posts.deleted', ['posts' => $posts]);
    }

    public function restore($post)
    {
        $post = Post::onlyTrashed()->findOrFail($post);
        $post->restore();

        return redirect()->route('posts.show', $post);
    }
}
