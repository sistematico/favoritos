<?php

use App\Http\Middleware;
use App\Utils\Database;

$config = parse_ini_file(dirname(__DIR__) . '/.env');
$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];

foreach ($config as $key => $value) {
    define('"' . $key . '"', '"' . $value . '"');
}

Database::config(dirname(__DIR__) . '/db/database.sqlite');

Middleware\Queue::setMap([
    'maintenance'          => Middleware\Maintenance::class,
    'require-admin-logout' => Middleware\RequireAdminLogout::class,
    'require-admin-login'  => Middleware\RequireAdminLogin::class,
    'require-user-login'   => Middleware\RequireUserLogin::class,
    'require-user-logout'  => Middleware\RequireUserLogout::class,
    'api'                  => Middleware\Api::class,
    'user-basic-auth'      => Middleware\UserBasicAuth::class,
    'jwt-auth'             => Middleware\JwtAuth::class,
    'cache'                => Middleware\Cache::class
]);

Middleware\Queue::setDefault(['maintenance']);