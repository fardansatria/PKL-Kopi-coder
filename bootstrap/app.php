<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

<<<<<<< HEAD
=======

>>>>>>> 5c32dd7 (second commit)
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
<<<<<<< HEAD
        //
=======

>>>>>>> 5c32dd7 (second commit)
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
<<<<<<< HEAD
=======

>>>>>>> 5c32dd7 (second commit)
