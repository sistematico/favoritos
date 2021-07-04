<?php

namespace App\Session;

class Login
{
    public static function init() {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function login($obUser) {
        self::init();

        $_SESSION['user'] = [
            'id' => $obUser->id,
            'name' => $obUser->name,
            'email' => $obUser->email,
        ];

        return true;
    }

    public static function logout() {
        self::init();
        unset($_SESSION['user']);
        return true;
    }

    public static function isLogged() {
        self::init();

        return isset($_SESSION['user']['id']);
    }
}