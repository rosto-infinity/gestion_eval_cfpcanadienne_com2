<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class InitializeRequestContext
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Injecter le trace_id pour corrélation globale des logs et files d'attente (Laravel 13)
        Context::add('trace_id', Str::uuid()->toString());
        Context::add('ip', $request->ip());
        Context::add('url', $request->fullUrl());

        if ($request->user()) {
            Context::add('user_id', $request->user()->id);
        }

        return $next($request);
    }
}
