<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#postModal{{ $post->id }}">
        Show Post
    </button>
    <!-- Modal -->
    <div class="modal fade" id="postModal{{ $post->id }}" tabindex="-1" role="dialog"
        aria-labelledby="postModalLabel{{ $post->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postModalLabel{{ $post->id }}">View Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3>{{ $post->title }}</h3>
                    <img src="{{ $post->image }}" class="img-fluid rounded-top" alt="">
                    <p>
                        {{ Str::limit($post->description, 50) }}
                    </p>
                    <small>Published: {{ $post->published_at }}</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a href="{{ route('posts.show', $post['slug']) }}" class="btn btn-primary">View Full Post</a>
                </div>
            </div>
        </div>
    </div>
</div>
