<?php

//require_once '../app/bootstrap.php';
require dirname(__DIR__) . '/vendor/autoload.php';

use App\Http\Router;
use App\Http\Response;
use App\Controller;

use App\Utils\Database;
use App\Utils\View;

use App\Http\Middleware\Queue as MiddlewareQueue;

use App\Http\Middleware\Api;
use App\Http\Middleware\Cache;
use App\Http\Middleware\JwtAuth;
use App\Http\Middleware\Maintenance;
use App\Http\Middleware\RequireAdminLogin;
use App\Http\Middleware\RequireAdminLogout;
use App\Http\Middleware\RequireUserLogin;
use App\Http\Middleware\RequireUserLogout;
use App\Http\Middleware\UserBasicAuth;

$config = parse_ini_file(dirname(__DIR__) . '/.env');
$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];

define('SITENAME', $config['SITENAME'] ?? 'PrivateHub');
define('URL', $config['URL'] ?? 'https://privatehub');
define('MAINTENANCE', $config['MAINTENANCE'] ?? false);
define('JWT_KEY', $config['JWT_KEY'] ?? '123456789');
define('CACHE_TIME', $config['CACHE_TIME'] ?? 0);
define('CACHE_DIR', $config['CACHE_DIR'] ?? '/tmp/privatehub/cache');
define('PER_PAGE', $config['PER_PAGE'] ?? 10);
define('PAGINATION_LIMIT', $config['PAGINATION_LIMIT'] ?? 10);
define('UPLOAD_DIR', $config['UPLOAD_DIR'] ?? '/var/www/privatehub.com.br/public/uploads');
define('UPLOAD_URL', $config['UPLOAD_URL'] ?? URL . '/uploads');

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

MiddlewareQueue::setDefault(['maintenance']);

$router = new Router(URL);

$router->post('/api/v1/auth', [
    'middlewares' => ['api'],
    function($request) {
        return new Response(201, Auth::generateToken($request), 'application/json');
    }
]);

$router->get('/api/v1/users', [
    'middlewares' => ['api','jwt-auth'],
    function($request) {
        return new Response(200, Controller\User::getUsers($request), 'application/json');
    }
]);

$router->get('/api/v1/users/me', [
    'middlewares' => ['api','jwt-auth'],
    function($request) {
        return new Response(200, Controller\User::getCurrentUser($request), 'application/json');
    }
]);

$router->get('/api/v1/users/{id}', [
    'middlewares' => ['api','jwt-auth'],
    function($request, $id) {
        return new Response(200, Controller\User::getUser($request, $id), 'application/json');
    }
]);

$router->post('/api/v1/users', [
    'middlewares' => ['api','jwt-auth'],
    function($request) {
        return new Response(201, Controller\User::setNewUser($request), 'application/json');
    }
]);

$router->put('/api/v1/users/{id}', [
    'middlewares' => ['api','jwt-auth'],
    function($request, $id) {
        return new Response(200, Controller\User::setEditUser($request, $id), 'application/json');
    }
]);

$router->delete('/api/v1/users/{id}', [
    'middlewares' => ['api','jwt-auth'],
    function($request, $id) {
        return new Response(200, Controller\User::setDeleteUser($request, $id), 'application/json');
    }
]);

// Posts
$router->get('/api/v1/posts', [
    'middlewares' => ['api','cache'],
    function($request) {
        return new Response(200, Controller\Post::getPosts($request), 'application/json');
    }
]);

$router->get('/api/v1/posts/{id}', [
    'middlewares' => ['api'],
    function($request, $id) {
        return new Response(200, Controller\Post::getPost($request, $id), 'application/json');
    }
]);

$router->post('/api/v1/posts', [
    'middlewares' => ['api'],
    function($request) {
        return new Response(201, Controller\Post::setNewPost($request), 'application/json');
    }
]);

$router->put('/api/v1/posts/{id}', [
    'middlewares' => ['api'],
    function($request, $id) {
        return new Response(200, Controller\Post::setEditPost($request, $id), 'application/json');
    }
]);

$router->delete('/api/v1/posts/{id}', [
    'middlewares' => ['api'],
    function($request, $id) {
        return new Response(200, Controller\Post::setDeletePost($request, $id), 'application/json');
    }
]);

$router->run()->sendResponse();