@extends('layouts.app')

@section('title',$user->name)

@section('content')

    <div class="row justify-content-center">
        <div class="col-9">
            {{-- Profile Update --}}
            <form action="{{route('profile.update',$user->id)}}" method="post" class="bg-white shadow rounded-3 p-5" enctype="multipart/form-data">
                @csrf   
                @method('PATCH')
                <h2 class="h3 mb-4 fw-light text-muted text-center">Update Profile</h2>

                <div class="row mb-3">
                    <div class="col">
                        <div class="d-flex justify-content-center">
                            @if ($user->avatar)
                                <img src="{{$user->avatar}}" alt="{{$user->name}}" class="img thumbnail rounded-circle avatar-lg h-100 border border-primar">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary d-block icon-lg"></i>
                            @endif
                        </div>
                    </div>
                    <div class="col-auto align-center-end  w-100">
                        <input type="file" name="avatar" id="avatar" class="form-control form-control-sm mt-4" aria-describedby="avatar-info">
                        Acceptable formats are jpeg, jpg, png, and gif only. <br>
                        Mac file size is 1048Kb
                    </div>
                    @error('file')
                        <p class="text-danger small">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="name" class="fw-bold form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{old('name', $user->name) }}" autofocus>
                    @error('name')
                        <p class="text-danger small">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{old('email', $user->email)}}">
                    @error('email')
                        <p class="text-danger small">{{$message}}</p>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="introduction" class="form-label fw-bold">Introduction</label>
                    <textarea name="introduction" id="introduction" rows="5" class="form-control" placeholder="Describe yourself">{{ old('introduction', $user->introduction) }}</textarea>
                    @error('introduction')
                        <p class="text-danger small">{{$message}}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-warning px-5 mt-3">Save</button>
            </form>

            {{-- Password Update --}}
            <form action="{{route('profile.updatepass',$user->id)}}" method="post" class="bg-white shadow rounded-3 p-5 mt-3" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <h2 class="h3 mb-3 fw-light text-muted text-center">Update Password</h2>
                
                <div class="mb-3">
                    <label for="current_password" class="fw-bold form-label">Current Password</label>
                    <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Please enter your current password" required>
                    @error('current_password')
                    <p class="text-danger small">{{$message}}</p>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="new_password" class="text-md-end">New Password</label>
                    <input id="password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" required autocomplete="new-password" placeholder="Please update a new password between 8 and 16 characters long">

                    @error('new_password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="text-md-end">{{ __('Confirm Password') }}</label>
                    <input id="confirm_password" type="password" class="form-control" name="confirm_password" required autocomplete="new-password" placeholder="Confirm your new password">
                    @error('confirm_password')
                        <p class="text-danger small">{{$message}}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-warning px-5 mt-3">Update</button>
                <p class="text-muted text-sm">We will send you an email once your password has been successfully updated.</p>
            </form> 
    </div>

@endsection
