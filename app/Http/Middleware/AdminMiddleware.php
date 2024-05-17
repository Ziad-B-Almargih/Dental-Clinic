<?php

namespace App\Http\Middleware;

use App\Traits\HasJsonResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    use HasJsonResponse;
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()['role'] != 'admin')
            return $this->failed('forbidden', 403);

        return $next($request);
    }
}
