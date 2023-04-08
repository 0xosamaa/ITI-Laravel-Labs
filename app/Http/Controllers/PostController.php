<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\TextUI\Configuration\Constant;

class PostController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->search)) {
            $posts = Post::where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%')->orderBy('published_at', 'DESC')->paginate(9);
        } else {
            $posts = Post::orderBy('published_at', 'DESC')->paginate(9);
        }
        return view('posts.index', ['posts' => $posts]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(StorePostRequest $request)
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
        return view('posts.show', ["post" => $post, "comments" => $post->comments]);
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
        DB::transaction(function () use ($request) {
            $comments = Comment::where(['commentable_id' => $request->post_id, 'commentable_type' => 'App\Models\Post'])->get();
            foreach ($comments as $comment) {
                $comment->delete();
            }
            $post = Post::findOrFail($request->post_id);
            $post->delete();
        });


        return redirect()->route('posts.index');
    }

    public function deleted()
    {
        $posts = Post::onlyTrashed()->paginate(9);
        return view('posts.deleted', ['posts' => $posts]);
    }

    public function restore($post)
    {
        DB::transaction(function () use ($post) {
            $post = Post::onlyTrashed()->findOrFail($post);
            $comments = Comment::onlyTrashed()->where(['commentable_id' => $post->id, 'commentable_type' => 'App\Models\Post'])->get();
            $post->restore();
            foreach ($comments as $comment) {
                $comment->restore();
            }
        });

        return redirect()->route('posts.show', $post);
    }
}
