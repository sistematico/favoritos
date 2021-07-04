<?php

namespace App\Middleware;

use \App\Session\Admin\Login as SessionLogout;

class Logout
{
    public function handle($request, $next) {
        if (SessionLogout::isLogged()) {
            $request->getRouter()->redirect('/admin');
        }

        return $next($request);
    }
}