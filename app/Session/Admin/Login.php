<?php

namespace App\Session\Admin;

class Login
{
    public static function init() {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }

    }

    public static function login($obUser) {
        self::init();

        $_SESSION['admin'] = [
            'id' => $obUser->id,
            'nome' => $obUser->nome,
            'email' => $obUser->email,
        ];

        return true;
    }

    public static function logout() {
        self::init();
        unset($_SESSION['admin']);
        return true;
    }

    public static function isLogged() {
        self::init();

        return isset($_SESSION['admin']['id']);
    }
}