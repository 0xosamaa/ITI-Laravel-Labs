@extends('layouts.app')
@section('title')
    Posts
@endsection

@section('content')
    <div class="row my-3">
        @foreach ($posts as $post)
            <div class="col-4 my-3">
                <div class="card">
                    <img src="{{ $post->image }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post['title'] }}</h5>
                        <p class="card-text">{{ Str::limit($post['description'], 50) }}</p>
                        <a href="{{ route('posts.show', $post['id']) }}" class="btn btn-primary">View Post</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center my-3">
        {{ $posts->appends(request()->input())->links() }}
    </div>
@endsection
