<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;//追加

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //Option1
        $middleware->appendToGroup('admin',[AdminMiddleware::class]);  //追加

        //Option2
        //$middleware->appendToGroup('admin','App\Http\Middleware\AdminMiddleware')
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
