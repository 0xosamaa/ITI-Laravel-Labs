@extends('layouts.app')
@section('title')
    Edit Post
@endsection

@section('content')
    <form action="{{ route('posts.update', $post['slug']) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" value="{{ $post->title }}" id="" placeholder="">
            <small class="form-text text-muted">Enter Post Title</small>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Description</label>
            <div class="mb-3">
                <label for="description" class="form-label"></label>
                <textarea class="form-control" name="description" id="" rows="5">{{ $post->description }}</textarea>
            </div>
            <small class="form-text text-muted">Enter Post Description</small>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Author</label>
            <select class="form-select form-select-lg" name="author" id="">
                @foreach (\App\Models\User::all() as $user)
                    @if ($post->user->id === $user->id)
                        <option selected value="{{ $user->id }}">{{ $user->name }}</option>
                    @else
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Image</label>
            <input type="file" name="image" class="form-control">
            <img class="my-3" src="{{ asset('storage/images/posts/' . $post->image) }}" width="128" alt="">
            <small class="form-text text-muted">Choose Post Image</small>
        </div>
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
