<?php

namespace App\Http\Middleware;

use App\Models\Menu\Master\MenuPermission;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class AuthGates
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //$userId = session('logged_session_data.id');
        $user = Auth::User();
        //dd($user->role_id);
        if ($user) {
            $permissions = MenuPermission::all();
            foreach ($permissions as $key => $permission) {
                Gate::define($permission->slug, function(User $user) use($permission){
                    //dd($permission->slug);
                    return $user->hasPermission($permission->slug);
                });
            }
        }
        return $next($request);
    }
}
