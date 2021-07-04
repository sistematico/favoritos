<?php

namespace App\Http\Middleware;

use \App\Session\Login as SessionAdminLogin;

class RequireAdminLogin
{
    public function handle($request, $next) {
        if (!SessionAdminLogin::isLogged()) {
            $request->getRouter()->redirect('/admin/login');
        }

        return $next($request);
    }
}