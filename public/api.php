<?php

use App\Http\Router;
use App\Http\Response;
use App\Controller;

require_once '../app/bootstrap.php';

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
    'middlewares' => [
        'api'
    ],
    function($request, $id) {
        return new Response(200, Controller\Post::getPost($request, $id), 'application/json');
    }
]);

$router->post('/api/v1/posts', [
    'middlewares' => [
        'api'
    ],
    function($request) {
        return new Response(201, Controller\Post::setNewPost($request), 'application/json');
    }
]);

$router->put('/api/v1/posts/{id}', [
    'middlewares' => [
        'api'
    ],
    function($request, $id) {
        return new Response(200, Controller\Post::setEditPost($request, $id), 'application/json');
    }
]);

$router->delete('/api/v1/posts/{id}', [
    'middlewares' => [
        'api',
    ],
    function($request, $id) {
        return new Response(200, Controller\Post::setDeletePost($request, $id), 'application/json');
    }
]);

$router->run()->sendResponse();