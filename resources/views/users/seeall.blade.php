@extends('layouts.app')

@section('title','Home')

@section('content')
@if ($suggested_users->currentPage() == 1)  
    <p class="text-center h3">Special Recommend Users</p>
@endif
<div class="mb-4">
@foreach ($suggested_users as $user)
    @if ($user->isFollowing())
        <div class="card my-3 w-75 mx-auto border-primary  mb-3">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <a href="{{route('profile.show',$user->id)}}">
                            @if ($user->avatar) 
                            <img src="{{$user->avatar}}" alt="{{$user->name}}" class="rounded-circle avatar-sm">
                            @else
                            <i class="fa-solid fa-circle-user text-prymary icon-sm"></i>
                            @endif
                        </a>
                    </div>
                    <div class="col ps-0 text-truncate">
                        <a href="{{route('profile.show',$user->id)}}" class="text-decoration-none text-dark fw-bold">
                            {{$user->name}}
                            <span class="badge rounded-pill text-bg-primary">{{$user->followers->count()}}</span>
                        </a>
                        <span class="text-muted ms-5 text-sm">You have been followed by this person.</span>                      
                    </div>
                    <div class="col-auto">
                        <form action="{{route('follow.store',$user->id)}}" method="post">
                            @csrf
                            <button type="submit" class="border-0 bg-transparent p-0 text-primary btn-sm">Follow</button>
                        </form>
                    </div>
                </div>
            </div>      
        </div>                
    @else
    @endif
@endforeach
</div>

@if ($suggested_users->currentPage() == 1)  
<p class="text-center h3">Try to Follow them!</p>
@endif
@foreach ($suggested_users as $user)
    @if (!$user->isFollowing())
    <div class="card my-3 w-75 mx-auto">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-auto">
                    <a href="{{route('profile.show',$user->id)}}">
                        @if ($user->avatar) 
                        <img src="{{$user->avatar}}" alt="{{$user->name}}" class="rounded-circle avatar-sm">
                        @else
                        <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                        @endif
                    </a>
                </div>
                <div class="col ps-0 text-truncate">
                    <a href="{{route('profile.show',$user->id)}}" class="text-decoration-none text-dark">
                        {{$user->name}}
                        <span class="badge rounded-pill text-bg-secondary">{{$user->followers->count()}}</span>
                    </a>                    
                </div>
                <div class="col-auto">
                    <form action="{{route('follow.store',$user->id)}}" method="post">
                        @csrf
                        <button type="submit" class="border-0 bg-transparent p-0 text-primary btn-sm">Follow</button>
                    </form>
                </div>
            </div>
        </div> 
    </div>  
    @endif
@endforeach
<div class="d-flex justify-content-center">
    {{ $suggested_users->links() }}
</div>
@endsection
