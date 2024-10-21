@extends('layouts.app')

@section('title',$user->name)

@section('content')

    <div class="row justify-content-center">
        <div class="col-8">
            <form action="{{route('profile.update',$user->id)}}" method="post" class="bg-white shadow rounded-3 p-5" enctype="multipart/form-data">
                @csrf   
                @method('PATCH')
                <h2 class="h3 mb-3 fw-light text-muted">Update Profile</h2>

                <div class="row mb-3">
                    <div class="col-4">
                        @if ($user->avatar)
                        <img src="{{$user->avatar}}" alt="{{$user->name}}" class="img thumbnail rounded-circle d-block mx-auto avatar-lg h-100">
                            
                        @else
                        <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-lg"></i>
                            
                        @endif
                    </div>
                    <div class="col-auto align-center-end">
                        <input type="file" name="avatar" id="avatar" class="form-control form-control-sm mt-1" aria-describedby="avatar-info">
                        Acceptable formats are jpeg, jpg, png, anad gif only. <br>
                        Mac file size is 1048Kb
                    </div>
                    {{-- Error message --}}
                </div>

                <div class="mb-3">
                    <label for="name" class="fw-bold form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{old('name', $user->name) }}" autofocus>
                    {{-- error message --}}
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{old('email', $user->email)}}">
                    {{-- error --}}
                </div>
                
                <div class="mb-3">
                    <label for="introduction" class="form-label fw-bold">Introduction</label>
                    {{-- <textarea type="introduction" name="introduction" id="introduction" rows="5" class="form-control" value="{{old('introduction', $user->introduction)}}" placeholder="Dexcribe yourself"></textarea> --}}
                    <textarea name="introduction" id="introduction" rows="5" class="form-control" placeholder="Describe yourself">{{ old('introduction', $user->introduction) }}</textarea>

                    {{-- error --}}
                </div>

                <button type="submit" class="btn btn-warning px-5">Save</button>
            </form>
        </div>
    </div>
    
@endsection
