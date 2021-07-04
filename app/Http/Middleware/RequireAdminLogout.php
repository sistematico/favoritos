<?php

namespace App\Http\Middleware;

use \App\Session\Login as SessionAdminLogin;

class RequireAdminLogout
{
    public function handle($request, $next) {
        if (SessionAdminLogin::isLogged()) {
            $request->getRouter()->redirect('/admin');
        }

        return $next($request);
    }
}