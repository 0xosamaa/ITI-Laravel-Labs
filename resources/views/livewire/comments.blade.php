<div>
    <div class="mb-3">
        <label for="" class="form-label">New Comment</label>
        <textarea class="form-control" style="resize:none" name="" id="" rows="3" wire:model="newComment"></textarea>
        <button class="btn btn-info mt-3" wire:click="addComment">Submit</button>
    </div>
    @foreach ($comments as $comment)
        <div class="card text-white bg-info mb-3">
            <div class="card-header">{{ $comment->user->name }}</div>
            <div class="card-body">
                <p class="card-text">{{ $comment->body }}</p>
            </div>
        </div>
    @endforeach
</div>
