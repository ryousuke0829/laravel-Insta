{{-- {{Clickable image}} --}}

<div class="container p-0">
    <a href="{{route('post.show',$post->id)}}">
        <img src="{{$post->image}}" alt="{{$post->id}}" class="w-100">
    </a>
</div>
<div class="card-body bg-white">
    {{-- heart button(icon) ;no of likes + categories --}}
    <div class="row align-items-center">
        <div class="col-auto">
            @if ($post->isLiked())
                <form action="#" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm shadow-none p-0">
                        <i class="fa-solid fa-heart text-danger"></i>
                    </button>
                </form>
            @else
                <form action="{{route('like.store',$post->id)}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-sm shadow-none p-0">
                        <i class="fa-regular fa-heart"></i>
                    </button>
                </form>
            @endif
        </div>
        <div class="col-auto px-0">
            <span>{{$post->likes->count()}}</span>
        </div>
        <div class="col text-end">
            {{-- lists of catefories of specific here --}}
            @forelse ($post->categoryPost as $category_post)
                <div class="badge bg-secondary bg-opacity-50">
                    {{$category_post->category->name}}
                </div>
            @empty
                <div class="badge bg-dark text-wrap">Uncategorize</div>
            @endforelse
        </div>
        </div>
            
        {{-- Owner of the post + Discription of the post --}}
        <a href="{{route('profile.show',$post->user->id)}}" class="text-decoration-none text-dark fw-bold">{{$post->user->name}}</a>
        <p class="d-inline fw-light">{{$post->description}}</p>
        <p class="text-danger small">Post on {{$post->created_at->diffForHumans()}}</p>
        <p class="text-uppercase text-muted small">{{date('M,d,Y',strtotime($post->created_at))}}</p>
        {{-- date(arg1,arg2) --}}
        {{-- arg1-->format-->Month Day Year--}}
        {{-- strtotime(timestamps)-->strtotime('2024-10-10 13:30:30') --}}
        {{--Comments  --}}
        @include('users.posts.contents.comments')
</div>