<div class="modal fade" id="wholike-post-{{$post->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-dark">
                <h3 class="h5 modal-title">
                    Who liked this Post
                </h3>
            </div>
            <div class="modal-body">
                <div class="mt-3">
                    @if ($post->likes->isEmpty())
                        <p class="mt-1 text-muted">No one liked this post yet.</p>
                    @else
                        <ul>
                            @foreach ($post->likes as $like)
                                <li>{{ $like->user->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
