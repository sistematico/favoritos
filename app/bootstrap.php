<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Utils\Database;
use App\Utils\View;

use App\Http\Middleware\Queue as MiddlewareQueue;
use App\Http\Middleware\Api;
use App\Http\Middleware\Cache;
use App\Http\Middleware\JwtAuth;
use App\Http\Middleware\Login;
use App\Http\Middleware\Logout;

$config = parse_ini_file(dirname(__DIR__) . '/.env');
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
    'logout'   => Logout::class,
    'login'    => Login::class,
    'api'      => Api::class,
    'jwt-auth' => JwtAuth::class,
    'cache'    => Cache::class
]);

MiddlewareQueue::setDefault(['api']);