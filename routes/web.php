<?php

use Illuminate\Support\Facades\Route;

/**
 * Controllers for admin users
 */
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\CategoriesController;

/**
 * Controller for regular users
 */
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;

Auth::routes();

Route::group(['middleware'=>'auth'], function(){
    Route::get('/', [HomeController::class, 'index'])->name('index'); 
    Route::get('/people', [HomeController::class, 'search'])->name('search'); 

    //Posts
    Route::get('/post/create', [PostController::class,'create'])->name('post.create');      
    Route::post('/post/store', [PostController::class,'store'])->name('post.store');        
    Route::get('/post/{post_id}/show', [PostController::class,'show'])->name('post.show');  
    Route::get('/edit/{post_id}', [PostController::class,'edit'])->name('post.edit');       
    Route::patch('/post/update/{post_id}', [PostController::class,'update'])->name('post.update');  
    Route::delete('/post/delete/{id}', [PostController::class,'destroy'])->name('post.delete');
    
    //Comments
    Route::post('/comment/{post_id}/store', [CommentController::class,'store'])->name('comment.store'); 
    Route::delete('/comment/{comment_id}/destroy', [commentController::class,'destroy'])->name('comment.destroy');

    //Profiles
    Route::get('/profile/{user_id}/show', [ProfileController::class,'show'])->name('profile.show'); 
    Route::get('/profile/{user_id}/follower', [ProfileController::class,'follower'])->name('profile.follower'); 
    Route::get('/profile/{user_id}/following', [ProfileController::class,'following'])->name('profile.following'); 
    Route::get('/profile/edit', [ProfileController::class,'edit'])->name('profile.edit'); 
    Route::patch('/profile/update/{id}', [ProfileController::class,'update'])->name('profile.update'); 

    //Likes
    Route::post('/like/{post_id}/store', [LikeController::class,'store'])->name('like.store'); 
    Route::delete('/like/{post_id}/delete', [LikeController::class,'destroy'])->name('like.delete');

    //Follow / Unfollow
    Route::post('/follow/{user_id}/store', [FollowController::class,'store'])->name('follow.store'); 
    Route::delete('/follow/{user_id}/destroy', [FollowController::class,'destroy'])->name('follow.destroy'); 

    /**
     * Routes related to admin users
     */
    Route::group(['prefix'=>'admin', 'as'=>'admin.', 'middleware'=>'admin'],function(){

        //Users dashboard
        Route::get('/users', [UsersController::class,'index'])->name('users'); 
        Route::delete('/users/{user_id}/deactivate', [UsersController::class,'deactivate'])->name('users.deactivate'); 
        Route::patch('/users/{user_id}/activate', [UsersController::class,'activate'])->name('users.activate'); 

        //Admin dashboard
        Route::get('/posts', [PostsController::class,'index'])->name('posts'); 
        Route::delete('/posts/{post_id}/hide', [PostsController::class,'hide'])->name('posts.hide'); 
        Route::patch('/posts/{post_id}/unhide', [PostsController::class,'unhide'])->name('posts.unhide'); 

        //Admin Categories dashboard
        Route::get('/categories', [CategoriesController::class,'index'])->name('categories'); 
        Route::post('/categories/store', [CategoriesController::class,'store'])->name('categories.store'); 
        Route::patch('/categories/{category_id}/update', [CategoriesController::class,'update'])->name('categories.update'); 
        Route::delete('/categories/{category_id}/destroy', [CategoriesController::class,'destroy'])->name('categories.destroy'); 
    });
});
