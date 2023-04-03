@extends('layouts.app')
@section('title')
    Post Details
@endsection

@section('content')
    <h1>{{ $post->title }}</h1>
    <img src="{{ $post->image }}" class="img-fluid rounded-top" alt="">
    <p>{{ $post->description }}</p>
    <small>Published at: {{ $post->published_at }}</small>
    <br>
    <small> By: {{ $post->user->name }}</small>
    <br>

    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">Edit Post</a>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
        Delete Post
    </button>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are You sure you want to delete post: {{ $post->title }}?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form class="text-right" action="{{ route('posts.destroy', $post->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
