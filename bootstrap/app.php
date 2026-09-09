<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
        ]);

        $middleware->redirectGuestsTo(fn () => route('login'));

        // Zaten giriş yapmış bir kullanıcı /login, /register gibi misafir
        // sayfalarına girmeye çalışırsa rolüne göre yönlendirilir.
        $middleware->redirectUsersTo(
            fn (Request $request) => $request->user()?->isAdmin()
                ? route('admin.dashboard')
                : route('home')
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
