<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Enregistrer les middlewares par alias
        $middleware->alias([
            'admin'       => \App\Http\Middleware\AdminMiddleware::class,
            // register several common keys for the regisseur middleware so routes using
            // 'isRegisseur', 'IsRegisseur' or 'regisseur' all resolve to the same class
            'isRegisseur' => \App\Http\Middleware\IsRegisseur::class,
            'IsRegisseur' => \App\Http\Middleware\IsRegisseur::class,
            'agent'       => \App\Http\Middleware\AgentMiddleware::class,
        ]);

        // Exemple de groupe si tu veux protéger des routes spécifiques
        $middleware->group('admin', [
            \App\Http\Middleware\AdminMiddleware::class,
        ]);

        $middleware->group('regisseur', [
            \App\Http\Middleware\IsRegisseur::class,
        ]);

        $middleware->group('agent', [
            \App\Http\Middleware\ClientMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
