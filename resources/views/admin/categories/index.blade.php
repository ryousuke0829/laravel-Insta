@extends('layouts.app')

@section('title','Admin: Categories')

@section('content')

    <form action="{{route('admin.categories.store')}}" method="post">
        @csrf
        <div class="row gx-2 mb-4">
            <div class="col-5">
                <input type="text" name="name" class="form-control" placeholder="Add a category" autofocus>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> Add
                </button>
            </div>
            @error('name')
                <p class="text-danger small">{{$message}}</p>
            @enderror
        </div>
    </form>
    <div class="row">
        <div class="col-7">
            <table class="table table-hover align-center bg-white border table-sm text-secondary text-center">
                <thead class="table-warning text-secondary">
                    <th>#</th>
                    <th>NAME</th>
                    <th>COUNT</th>
                    <th>LAST UPDATE</th>
                    <th></th>
                </thead>
                <tbody>
                    @forelse ($all_categories as $category)
                        <tr>
                            <td>{{$category->id}}</td>
                            <td class="text-dark">{{$category->name}}</td>
                            <td>{{$category->categoryPost->count()}}</td>
                            <td>{{$category->updated_at}}</td>
                            <td>
                                {{-- Edit Button --}}
                                <button class="btn btn-outline-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#edit-category-{{$category->id}}" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                
                                {{-- Delete Button --}}
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-category-{{$category->id}}" title="Delete">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </td>
                        </tr>
                        @include('admin.categories.modal.action')
                    @empty
                        
                    @endforelse
                    <tr>
                        <td></td>
                        <td class="text-dark">
                            Uncategorized
                            <p class="small mb-0 text-muted">Hidden posts are not included</p>
                        </td>

                        <td>{{$uncategorized_count}}</td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            {{$all_categories->links()}}
        </div>
    </div>

@endsection
