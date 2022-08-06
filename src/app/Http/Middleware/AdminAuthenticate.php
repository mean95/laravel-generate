<?php

namespace Core\app\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     */
    public function handle($request, \Closure $next, ...$guards)
    {
        $adminUser = Auth::guard('admin')->user();
        if (!$adminUser) {
            session(['prefer' => $request->fullUrl()]);
            return redirect()->route(getPrefix() . '.login');
        }
        $route = $request->route();
        $permission = $route->uri . '/' . $route->methods[0];
        if ($permission && !$adminUser->hasAnyPermission($permission)) {
            if (!$request->ajax()) {
                $request->session()->flash('error', trans('core::admin.403'));
                return back();
            }
            abort(403, trans('core::admin.403'));
        }
        return $next($request);
    }
}
