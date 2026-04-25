<?php
namespace App\Http\Middleware;
use Closure;

class AdminMiddleware {
    public function handle($request, Closure $next) {
        if (!auth('api')->user()->isAdmin()) {
            return response()->json(['error' => 'Accès refusé — Admin uniquement'], 403);
        }
        return $next($request);
    }
}
