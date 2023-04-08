@extends('layouts.app')
@section('title')
    New Post
@endsection

@section('content')
    <div class="mt-4"></div>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                <p>{{ $error }}</p>
            </div>
        @endforeach
    @endif
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" id="" placeholder="">
            <small class="form-text text-muted">Enter Post Title</small>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Description</label>
            <div class="mb-3">
                <label for="description" class="form-label"></label>
                <textarea class="form-control" name="description" id="" rows="5"></textarea>
            </div>
            <small class="form-text text-muted">Enter Post Description</small>
        </div>
        <div class="mb-3">
          <label for="" class="form-label">Image</label>
          <input type="file" name="image" class="form-control">
          <small class="form-text text-muted">Choose Post Image</small>
        </div>
        {{-- <div class="mb-3">
            <label for="" class="form-label">Author</label>
            <select class="form-select form-select-lg" name="author" id="">
                @foreach (\App\Models\User::all() as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div> --}}
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
