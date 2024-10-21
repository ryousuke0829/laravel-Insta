@extends('layouts.app')

@section('title','followers')
    
@section('content')

    @include('users.profile.header')

    <div style="margin-top: 100px">
    @if ($user->followers->isNotEmpty()) 
    {{-- userはProfilecontroller follers->userModel --}}
        <div class="row justify-content-center">
            <div class="col-4">
                <h3 class="h1">Followers</h3>
                @foreach ($user->followers as $follower)
                    <div class="row align-items-center mt-3">
                        <div class="col-auto">
                            <a href="{{route('profile.show',$follower->follower->id)}}" class="">
                                @if ($follower->follower->avatar)
                                    <img src="{{$follower->follower->avatar}}" alt="{{$follower->follower->avatar}}" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary ivon-sm"></i>
                                @endif
                            </a>
                        </div>

                        <div class="col ps-0 text-truncate">
                            <a href="{{route('profile.show', $follower->follower->id)}}" class="text-decoration-none text-dark fw-bold">{{$follower->follower->name}}</a>
                        </div>

                        <div class="col-auto text-end">
                            @if ($follower->follower->id != Auth::user()->id)
                                <form action="{{route('follow.destroy', $follower->follower->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="border-0 bg-transparent p-0 text-secondary btn-sm">Followig</button>
                                </form>
                            @else
                                <form action="{{route('follow.store',$follower->follower->id)}}" method="post">
                                    @csrf
                                    <button type="submit" class="border-0 bg-transparent p-0 text-primary btn-sm">Follow</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    </div>
@endsection
{{-- {{$user->followers->follower()}} --}}
