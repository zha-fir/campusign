<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Http\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
        ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);

        // User yang sudah login dialihkan ke dashboard sesuai rolenya
        $middleware->redirectUsersTo(function (Request $request) {
            return match ($request->user()->role) {
                'admin'        => route('admin.dashboard'),
                'operator'     => route('operator.dashboard'),
                'ketuajurusan' => route('ketua_jurusan.dashboard'),
                'mahasiswa'    => route('mahasiswa.dashboard'),
                default        => abort(403, 'Role akun tidak valid.'),
            };
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn(Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();