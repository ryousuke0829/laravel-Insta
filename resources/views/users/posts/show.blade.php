@extends('layouts.app')

@section('title', 'Show Post')
    
@section('content')
<style>
    .col-4{
        overflow-y: scroll;
    }
    .card-body{
        position: absolute;
        top:65px;
    }
</style>
    <div class="row border shadow">
        <div class="col">
            <div class="col p-0 border-end">
                <img src="{{$post->image}}" alt="{{$post->id}}" class="w-100">
            </div>
        </div>
            <div class="col-4 px-0 bg-white">
                <div class="card border-0">
                    <div class="card-header bg-white py-3">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <a href="{{route('profile.show',$post->user->id)}}">
                                @if ($post->user->avatar)
                                <img src="{{$post->user->avatar}}" alt="{{$post->user->name}}" class="rounded-circle avatar-sm">
                                @else  
                                <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                                </a>
                            </div>
                            <div class="col ps-0">
                                <a href="{{route('profile.show',$post->user->id)}}" class="text-decoration-none text-dark">{{$post->user->name}}</a>
                            </div>
                            <div class="col-auto">
                                <div class="dropdown">
                                    <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                    {{-- If the logged in user (AUTH)user is the owner of the post, then the user can Edit and Delete the post --}}
                                    @if (Auth::user()->id === $post->user->id)
                                        <div class="dropdown-menu">
                                            <a href="{{route('post.edit',$post->id)}}" class="dropdown-item">
                                                <i class="fa-regular fa-pen-to-square"></i> Edit
                                            </a>
                                            <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-post-{{$post->id}}">
                                                <i class="fa-regular fa-trash-can"> Delete</i>
                                            </button>
                                        </div>
                                        {{-- Include modalhere --}}
                                        @include('users.posts.contents.modals.delete')
                                    @else
                                        {{-- If the logged user (AUTH user) is Not The Ownwer of the post, show unfollow button --}}
                                        <div class="dropdown-menu">
                                            @if ($post->user->isFollowed())
                                                <form action="{{route('follow.destroy',$post->user->id)}}" method="post" class="d-inline">
                                                    @csrf   
                                                    @method('DELETE')
                                                    <button type="submit" class="text-secondary border-0 bg-transparent p-0 ms-2 ">Following</button>
                                                </form> 
                                            @else
                                                <form action="{{route('follow.store',$post->user->id)}}" method="post">
                                                    @csrf   
                                                    <button type="submit" class="text-primary border-0 bg-transparent p-0 ">Follow</button>
                                                </form>
                                            @endif

                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- heart button(icon) ;no of likes + categories --}}
                        <div class="row align-items-center">

                            <div class="col-auto">
                                @if ($post->isLiked())
                                <form action="{{route('like.delete',$post->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm shadow-none p-0">
                                        <i class="fa-solid text-danger fa-heart"></i>
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
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#wholike-post-{{$post->id}}">
                                    <span class="fw-bold">{{$post->likes->count()}}</span>
                                </button>
                                @include('users.posts.contents.modals.wholike')
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
                            {{--  Comment--}}

                            {{-- {{Clickable image}} --}}
        {{-- @include('users.posts.contents.comments')    --}}
        {{-- Comments section --}}
        <div class="mt-3 comment-scroll-bar">

            <form action="{{ route('comment.store', $post->id) }}" method="post">
                @csrf
        
                <div class="input-group">
                    <textarea name="comment_body{{ $post->id }}" cols="30" rows="1" class="form-control form-control-sm" placeholder="Add a comment...">{{old('comment_body' . $post->id)}}</textarea>
                    <button type="submit" class="btn btn-outline-secondary btn-sm" title="Post"><i class="fa-regular fa-paper-plane"></i></button>
                </div>
                @error('comment_body' . $post->id)
                    <p class="text-danger small">{{$message}}</p>
                @enderror
        
            </form>
            {{-- Show all comments here --}}

            @if ($post->comments->isNotEmpty())
                <ul class="list-group mt-2">
                    @foreach ($post->comments as $comment)
                        <li class="list-group-item border-0 p-0 mb-2">
                            <a href="{{route('profile.show',$post->user->id)}}" class="text-decoration-none text-dark fw-bold">{{ $comment->user->name }}</a>
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
    </div>
</div>
@endsection