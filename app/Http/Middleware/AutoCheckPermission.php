<?php

namespace App\Http\Middleware;

use Closure;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class AutoCheckPermission
{
    public function handle(Request $request, Closure $next)
    {
        $routeName = $request->route()->getName() ;  // user.create
        $permission = Permission::whereRaw(" FIND_IN_SET ('$routeName' , routes ) ")->get();

        if ($permission) {
            // dd($request->user);
            if (!$request->user()->hasPermissionTo([$permission->name])
            ) {
                abort(400) ;
            }
        } else {
            abort(300) ;
        }



        return $next($request);
    }
}
