@extends('layouts.app')
@section('title')
    Deleted Posts
@endsection

@section('content')
    <div class="row my-3">
        @if ($posts->isNotEmpty())
            @foreach ($posts as $post)
                <div class="col-4 my-3">
                    <div class="card">
                        <img src="{{ asset('storage/images/posts/' . $post->image) }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ Str::limit($post->description, 50) }}</p>
                            <form action="{{ route('posts.restore', $post['slug']) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning">Restore Post</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12 my-3">
                <h2>
                    No deleted posts found.
                </h2>
            </div>
        @endif
    </div>
    <div class="d-flex justify-content-center my-3">
        {{ $posts->appends(request()->input())->links() }}
    </div>
@endsection
