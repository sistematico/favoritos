<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Utils\Database;
use App\Utils\View;
use App\Middleware\Queue as MiddlewareQueue;

use App\Middleware\Api;
use App\Middleware\Cache;
use App\Middleware\JwtAuth;
use App\Middleware\RequireAdminLogin;
use App\Middleware\RequireAdminLogout;
use App\Middleware\RequireUserLogin;
use App\Middleware\RequireUserLogout;
use App\Middleware\UserBasicAuth;

$config = parse_ini_file(__DIR__ . '/../.env');
$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];

define('SITENAME', $config['SITENAME'] ?? 'PrivateHub');
define('URL', $config['URL'] ?? 'https://privatehub');
define('JWT_KEY', $config['JWT_KEY'] ?? '123456789');
define('CACHE_TIME', $config['CACHE_TIME'] ?? 0);
define('CACHE_DIR', $config['CACHE_DIR'] ?? '/tmp/privatehub/cache');
define('PER_PAGE', $config['PER_PAGE'] ?? 10);
define('PAGINATION_LIMIT', $config['PAGINATION_LIMIT'] ?? 10);
define('UPLOAD_DIR', $config['UPLOAD_DIR'] ?? '/var/www/privatehub.com.br/public/uploads');

Database::config(dirname(__DIR__) . '/db/database.sqlite');

View::init(['URL' => URL,'SITENAME' => SITENAME]);

MiddlewareQueue::setMap([
    'maintenance'          => Maintenance::class,
    'require-admin-logout' => RequireAdminLogout::class,
    'require-admin-login'  => RequireAdminLogin::class,
    'require-user-login'   => RequireUserLogin::class,
    'require-user-logout'  => RequireUserLogout::class,
    'api'                  => Api::class,
    'user-basic-auth'      => UserBasicAuth::class,
    'jwt-auth'             => JwtAuth::class,
    'cache'                => Cache::class
]);

//MiddlewareQueue::setDefault(['maintenance']);