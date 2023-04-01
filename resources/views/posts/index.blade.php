@extends('layouts.app')
@section('title')
    Posts
@endsection

@section('content')
    <div class="table-responsive">
        <table
            class="table table-striped
        table-hover
        table-borderless
        table-primary
        align-middle">
            <thead class="table-light">
                <caption>Posts</caption>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Author</th>
                    <th>published_at</th>
                    <th>created_at</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($posts as $post)
                    <tr class="table-primary">
                        <td scope="row">{{ $post['id'] }}</td>
                        <td>{{ $post['title'] }}</td>
                        <td>{{ $post['description'] }}</td>
                        <td>{{ $post['author'] }}</td>
                        <td>{{ $post['published_at'] }}</td>
                        <td>{{ $post['created_at'] }}</td>
                        <td><a href="{{ route('posts.show', $post['id']) }}" class="btn btn-success">View</a></td>
                        <td>
                            <a href="{{ route('posts.edit', $post['id']) }}" class="btn btn-warning">Update</a>
                        </td>
                        <td>
                            <form action="{{ route('posts.destroy', $post['id']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>

            </tfoot>
        </table>
    </div>
@endsection
