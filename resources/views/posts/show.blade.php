@extends('layouts.app')
@section('title')
    Post Details
@endsection

@section('content')
    <h1>{{ $post['title'] }}</h1>
    <p>{{ $post['description'] }}</p>
@endsection
