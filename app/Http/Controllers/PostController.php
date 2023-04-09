<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->search)) {
            $posts = Post::with('user')->where('user_id', Auth::user()->id)->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%')->where('user_id', Auth::user()->id)->orderBy('published_at', 'DESC')->paginate(9);
        } else {
            $posts = Post::with('user')->where('user_id', Auth::user()->id)->orderBy('published_at', 'DESC')->paginate(9);
        }
        return view('posts.index', ['posts' => $posts]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(StorePostRequest $request)
    {
        $input = $request->only(['title', 'description']);
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(storage_path('app/public/images/posts'), $imageName);

        $post = new Post();
        $post->title = $input['title'];
        $post->image = $imageName;
        $post->description = $input['description'];
        $post->user_id = Auth::user()->id;
        // $post->user_id = $request->author;
        $post->save();

        return redirect()->route('posts.index');
    }

    public function show($post)
    {
        $post = Post::where('slug', $post)->firstOrFail();
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
        if (Storage::exists("public/images/posts/{$post->image}")) {
            Storage::delete("public/images/posts/{$post->image}");
        }
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(storage_path('app/public/images/posts'), $imageName);

        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = Auth::user()->id;
        $post->image = $imageName;
        $post->save();
        return redirect()->route('posts.show', $post->slug);
    }

    public function destroy(Request $request)
    {
        DB::transaction(function () use ($request) {
            $comments = Comment::where(['commentable_id' => $request->post_id, 'commentable_type' => 'App\Models\Post'])->get();
            foreach ($comments as $comment) {
                $comment->delete();
            }
            $post = Post::where('user_id', Auth::user()->id)->findOrFail($request->post_id);
            $post->delete();
        });


        return redirect()->route('posts.index');
    }

    public function deleted()
    {
        $posts = Post::where('user_id', Auth::user()->id)->onlyTrashed()->paginate(9);
        return view('posts.deleted', ['posts' => $posts]);
    }

    public function restore($post)
    {
        DB::transaction(function () use ($post) {
            $post = Post::where('user_id', Auth::user()->id)->onlyTrashed()->where('slug', $post)->firstOrFail();
            $comments = Comment::onlyTrashed()->where(['commentable_id' => $post->id, 'commentable_type' => 'App\Models\Post'])->get();
            $post->restore();
            foreach ($comments as $comment) {
                $comment->restore();
            }
        });

        return redirect()->route('posts.show', $post);
    }
}
