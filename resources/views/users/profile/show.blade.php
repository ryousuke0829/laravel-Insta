@extends('layouts.app')

@section('title', $user->name)

@section('content')

    @include('users.profile.header')

    {{-- Show all the posts of the user --}}
    <div style="margin-top: 100px">
        @if ($user->posts->isNotEmpty())
            <div class="row">
                @foreach ($user->posts as $post)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="{{route('post.show',$post->id)}}">
                            <img src="{{$post->image}}" alt="post id{{$post->id}}" class="avatar-lg">
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <h3 class="text-muted text-center">No posts yet.</h3>
        @endif

    </div>



    
@endsection