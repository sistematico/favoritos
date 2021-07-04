<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\User;
use \App\Session\Login as SessionUserLogin;
use \App\Controller\Admin\Alert;

class Login extends Page
{
    public static function getLogin($request, $errorMessage = null) {
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';

        $content = View::render('pages/login', [
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

        SessionUserLogin::login($obUser);

        $request->getRouter()->redirect('/user');
    }

    public static function setLogout($request) {
        SessionUserLogin::logout();
        $request->getRouter()->redirect('/');
    }
}