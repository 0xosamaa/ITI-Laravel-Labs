@extends('layouts.app')
@section('title')
    Post Details
@endsection

@section('content')
    <div class="row my-3">
        <div class="col-1"></div>
        <div class="post col-10">
            <h1>{{ $post->title }}</h1>
            <img src="{{ $post->image }}" class="img-fluid rounded-top" alt="">
            <p>{{ $post->description }}</p>
            <small>Published: {{ $post->published_at }}</small>
            <br>
            <small> By: {{ $post->user->name }}</small>
            <br>
        </div>
        <div class="col-1"></div>
    </div>
    <div class="row my-3">
        <div class="col-1"></div>
        <div class="col-10">
            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">Edit Post</a>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                Delete Post
            </button>
        </div>
        <div class="col-1"></div>

    </div>
    <div class="row my-3">
        <div class="col-1"></div>
        <div class="col-10">
            @if ($comments->isNotEmpty())
                <h3>Comments</h3>
            @else
                <h4>Post has no comments yet.</h4>
            @endif
            <livewire:comments :comments="$comments" :post_id="$post->id" :user_id="$post->user->id" />
        </div>
        <div class="col-1"></div>
    </div>
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
