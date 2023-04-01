@extends('layouts.app')
@section('title')
    Edit Post
@endsection

@section('content')
    <form action="{{ route('posts.update', $post['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="" class="form-label">Title</label>
            <input type="text" class="form-control" name="" id="" placeholder="">
            <small class="form-text text-muted">Enter Post Title</small>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Description</label>
            <div class="mb-3">
                <label for="" class="form-label"></label>
                <textarea class="form-control" name="" id="" rows="5"></textarea>
            </div>
            <small class="form-text text-muted">Enter Post Description</small>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
