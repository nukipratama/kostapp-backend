<?php

namespace App\Http\Middleware;

use App\Exceptions\ForbiddenPermissionException;
use App\Exceptions\UnauthorizedException;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class AuthenticatedUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()->id) {
            throw new UnauthorizedException('Unauthorized');
        }
        $user = User::where('id', $request->user()->id)->with('role.detail')->first();
        if ($user->role->detail->prefix !== 'regular_user' && $user->role->detail->prefix !== 'premium_user') {
            throw new ForbiddenPermissionException('User doesnt have permission to access this resource.');
        }
        return $next($request);
    }
}
