<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\Role;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) abort(401);
        if ($user->isSuperAdmin()) return $next($request);

        if (!empty($roles)) {
            $roleEnums = array_filter(array_map(fn($r) => Role::fromString($r), $roles));
            if (!$user->hasAnyRole($roleEnums)) {
                abort(403, "Accès refusé.");
            }
        }
        return $next($request);
    }
}
