<?php

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Model\User;
use \App\Session\Admin\Login as SessionAdminLogin;

class Login extends Page
{
    public static function getLogin($request, $errorMessage = null) {
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';

        $content = View::render('admin/login', [
            'status' => $status
        ]);
        return parent::getPage('Painel de Admin', $content);
    }
    
    public static function setLogin($request) {
        $postVars = $request->getPostVars();
        $email = $postVars['email'] ?? '';
        $password = $postVars['password'] ?? '';

        $obUser = User::getUserByEmail($email);

        if (!$obUser instanceof User || !password_verify($password, $obUser->password)) {
            return self::getLogin($request, 'E-mail ou senha inválidos.');
        }

        SessionAdminLogin::login($obUser);

        $request->getRouter()->redirect('/admin');
    }

    public static function setLogout($request) {
        SessionAdminLogin::logout();
        $request->getRouter()->redirect('/admin/login');
    }
}