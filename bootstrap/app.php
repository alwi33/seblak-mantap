<?php

use App\Http\Middleware\EnsureUserIsAdmin;
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
            'admin' => EnsureUserIsAdmin::class,
        ]);

        // Ada dua halaman login terpisah (admin & pelanggan). Middleware
        // 'auth' bawaan Laravel butuh tahu ke mana harus redirect kalau
        // tamu belum login: ke /admin/login kalau dia sedang mencoba buka
        // halaman admin, atau ke /login (customer) untuk halaman lainnya.
        $middleware->redirectGuestsTo(function (Request $request) {
            return $request->is('admin/*') ? route('login') : route('customer.login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
