<?php

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Railway (dan platform proxy sejenis: Heroku, Render, Fly.io) men-terminate
        // TLS di edge lalu forward plain HTTP ke container. Tanpa ini Laravel tidak
        // tahu request aslinya https, sehingga url()/asset()/Vite men-generate link
        // http:// yang diblokir browser sebagai mixed content saat halaman dimuat
        // lewat https — Inertia/Vue gagal mount, tampil blank.
        //
        // at: '*' aman di sini karena container hanya bisa dijangkau lewat edge
        // proxy platform, tidak pernah langsung dari internet.
        $middleware->trustProxies(at: '*');

        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);

        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
