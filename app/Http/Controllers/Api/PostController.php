<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (isset($request->search)) {
            $posts = Post::with('user')->where('user_id', auth('sanctum')->user()->id)->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%')->where('user_id', auth('sanctum')->user()->id)->orderBy('published_at', 'DESC')->paginate(9);
        } else {
            $posts = Post::with('user')->where('user_id', auth('sanctum')->user()->id)->orderBy('published_at', 'DESC')->paginate(9);
        }
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $input = $request->only(['title', 'description']);
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(storage_path('app/public/images/posts'), $imageName);

        $post = new Post();
        $post->title = $input['title'];
        $post->image = $imageName;
        $post->description = $input['description'];
        $post->user_id = auth('sanctum')->user()->id;
        // $post->user_id = $request->author;
        $post->save();

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show($post)
    {
        $post = Post::where('slug', $post)->firstOrFail();
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
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
        $post->user_id = auth('sanctum')->user()->id;
        $post->image = $imageName;
        $post->save();
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        DB::transaction(function () use ($request) {
            $comments = Comment::where(['commentable_id' => $request->post_id, 'commentable_type' => 'App\Models\Post'])->get();
            foreach ($comments as $comment) {
                $comment->delete();
            }
            $post = Post::where('user_id', auth('sanctum')->user()->id)->findOrFail($request->post_id);
            $post->delete();
        });

        return 'Post Deleted Successfully.';
    }
}
