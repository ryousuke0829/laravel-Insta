@extends('layouts.app')

@section('title','Home')

@section('content')

    <div class="row gx-5">
        <div class="col-8">
            @forelse ($home_posts as $post)
            <div class="card mb-4">
                {{-- title.blade.php --}}
                @include('users.posts.contents.title')
                {{-- body.blade.php --}}
                @include('users.posts.contents.body')
            </div>
            @empty
            {{-- Show this if the site doesn't have any post yet.--}}
            <div class="text-center">
                <h2>Share Photos</h2>   
                <p class="text-secondary">When you share photos, they'll appear on your profile.</p>
                <a href="{{route('post.create')}}" class="text-decoration-none">Share your first photo</a>
            </div>               
            @endforelse
        </div>

        <div class="col-4 bg-light px-1">
            {{-- PROFILE OVERVIEW + SUGGESTIONS --}}
            <div class="row align-items-center mb-5 bg-white shadow-sm rounded-5 py-3 mx-auto">
                <div class="col-auto d-flex justify-content-center">
                    <a href="{{route('profile.show',Auth::user()->id)}}" class="">
                        @if (Auth::user()->avatar)
                            <img src="{{Auth::user()->avatar}}" alt="{{Auth::user()->name}}" class="rounded-circle avatar-md">
                        @else
                            <i class="fa-solid fa-circle-user text-secondary icon-md "></i>
                        @endif
                    </a>
                </div>
                <div class="col-auto ps-0">
                    <a href="{{route('profile.show',Auth::user()->id)}}" class="text-decoration-none text-dark fw-bold ms-3">{{Auth::user()->name}}</a>
                    <p class="text-muted mb-0 ms-3">{{Auth::user()->email}}</p>
                </div>
            </div>


            {{-- User Suggestiions --}}
            <div class="row">
                <div class="col-auto">
                    <p class="fw-bold text-secondary">Suggestions For You</p>
                </div>
                <div class="col text-end">
                    <a href="{{route('seeAll')}}" class="text-decoration-none fw-bold text-dark">See All</a>
                </div>
            </div>
            
            @foreach ($suggested_users as $user)
            @if ($user->isFollowing())
                <div class="row align-items-center mb-3">
                    <div class="col-auto">
                        <a href="{{route('profile.show',$user->id)}}">
                            @if ($user->avatar) 
                                <img src="{{$user->avatar}}" alt="{{$user->name}}" class="rounded-circle avatar-sm">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                            @endif
                        </a>
                    </div>
                    <div class="col py-3 text-truncate">
                        <a href="{{route('profile.show',$user->id)}}" class="text-decoration-none text-dark fw-bold position-relative">
                            {{$user->name}}
                            <span class="badge rounded-pill text-bg-secondary text-sm">{{$user->followers->count()}}</span>
                            <span class="badge rounded-pill text-bg-secondary text-sm">YourFollower</span>
                        </a>                                           
                    </div>
                    <div class="col-auto">
                        <form action="{{route('follow.store',$user->id)}}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary p-1 btn-sm">Follow</button>
                        </form>
                    </div>
                </div>
                @else
                @endif
            @endforeach
            
            @foreach ($suggested_users as $user)
            @if (!$user->isFollowing())
                <div class="row align-items-center mb-3">
                    <div class="col-auto">
                        <a href="{{route('profile.show',$user->id)}}">
                            @if ($user->avatar) 
                                <img src="{{$user->avatar}}" alt="{{$user->name}}" class="rounded-circle avatar-sm">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                            @endif
                        </a>
                    </div>
                    <div class="col p-3 text-truncate">
                        <a href="{{route('profile.show',$user->id)}}" class="text-decoration-none text-dark fw-bold position-relative">
                            {{$user->name}}
                            <span class="badge rounded-pill text-bg-secondary">{{$user->followers->count()}}</span>
                        </a>                        
                    </div>
                    <div class="col-auto">
                        <form action="{{route('follow.store',$user->id)}}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary p-1 btn-sm">Follow</button>
                        </form>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
