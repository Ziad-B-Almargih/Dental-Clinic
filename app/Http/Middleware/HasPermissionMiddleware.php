<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use App\Models\User;
use App\Traits\HasJsonResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasPermissionMiddleware
{
    use HasJsonResponse;

    public function handle(Request $request, Closure $next, $per): Response
    {
        $user = auth()->user();

       if($user['role'] == 'user' && ! $user->permissions()->where('type', $per)->exists()){
           return $this->failed('you do not have authority to da this action');
       }

        return $next($request);
    }
}
