<div class="mt-3">
    <form action="{{route('comment.store',$post->id)}}" method="post">
        @csrf
        <div class="input-group">
            <textarea name="comment_body{{$post->id}}" cols="30" rows="1" class="form-control form-control-sm" placeholder="Add a comment...">{{old('comment_body'.$post->id)}}</textarea>
            <button class="btn btn-outline secondary btn-sm" title="Post"><i class="fa-regular fa-paper-plane"></i></button>
        </div>
        @error('comment_body'.$post->id)
            <p class="text-danger small">{{$message}}</p>
        @enderror
    </form>

    {{-- Show all comments --}}
    @if ($post->comments->isNotEmpty())
    <ul class="list-group mt-2">
        @foreach ($post->comments->take(3) as $comment)
            <li class="list-group-item border-0 p-0 mb-2">
                <a href="{{route('profile.show',$comment->user->id)}}" class="text-decoration-none text-dark fw-bold">{{ $comment->user->name }}</a>
                &nbsp;
                <p class="d-inline fw-light">{{ $comment->body }}</p>

                <form action="{{route('comment.destroy',$comment->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <span class="text-uppercase text-muted small">{{ date('M d, Y', strtotime($comment->created_at)) }}</span>

                    {{-- If the Auth user is the owner of the comment, show a delete button --}}
                    @if (Auth::user()->id === $comment->user->id)
                        &middot;
                        <button type="submit" class="border-0 bg-transparent text-danger p-0 small">Delete</button>
                    @endif
                </form>
            </li>
        @endforeach
    </ul>
    @endif  


</div>