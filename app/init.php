<?php

$config = parse_ini_file(dirname(__DIR__) . '/.env');
$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];

foreach ($config as $key => $value) {
    define($key, $value);
}

\App\Utils\Database::config(dirname(__DIR__) . '/db/database.sqlite');

//View::init(['URL' => URL,'SITENAME' => SITENAME]);

MiddlewareQueue::setMap([
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

MiddlewareQueue::setDefault(['maintenance']);

$router = new Router(URL);

$router->post('/api/v1/auth', [
    'middlewares' => ['api'],
    function($request) {
        return new Response(201, Controller\Auth::generateToken($request), 'application/json');
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