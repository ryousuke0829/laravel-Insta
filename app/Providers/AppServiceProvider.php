<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; //追加する
use Illuminate\Pagination\Paginator;  //追加する
use App\MOdels\User;  //追加する

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Gate - simply a closure that determines that if a user is authorized to perform a given actuion.
     * To Make our UI more dynamic,let's create agate that will show certain items to admins only.
     */
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();  //追加する
        Gate::define('admin', function($user){
            return $user->role_id ==User::ADMIN_ROLE_ID;
        });      //追加する
    }
}

