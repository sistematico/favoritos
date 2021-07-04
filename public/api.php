<?php

use App\Http\Router;
use App\Http\Response;
use App\Controller\Api;

require_once '../app/bootstrap.php';

$router = new Router(URL);

$router->post('/api/v1/auth', [
    'middlewares' => ['api'],
    function($request) {
        return new Response(201, Api\Auth::generateToken($request), 'application/json');
    }
]);

$router->get('/api/v1/users', [
    'middlewares' => ['api','jwt-auth'],
    function($request) {
        return new Response(200, Api\User::getUsers($request), 'application/json');
    }
]);

$router->get('/api/v1/users/me', [
    'middlewares' => ['api','jwt-auth'],
    function($request) {
        return new Response(200, Api\User::getCurrentUser($request), 'application/json');
    }
]);

$router->get('/api/v1/users/{id}', [
    'middlewares' => ['api','jwt-auth'],
    function($request, $id) {
        return new Response(200, Api\User::getUser($request, $id), 'application/json');
    }
]);

$router->post('/api/v1/users', [
    'middlewares' => ['api','jwt-auth'],
    function($request) {
        return new Response(201, Api\User::setNewUser($request), 'application/json');
    }
]);

$router->put('/api/v1/users/{id}', [
    'middlewares' => ['api','jwt-auth'],
    function($request, $id) {
        return new Response(200, Api\User::setEditUser($request, $id), 'application/json');
    }
]);

$router->delete('/api/v1/users/{id}', [
    'middlewares' => ['api','jwt-auth'],
    function($request, $id) {
        return new Response(200, Api\User::setDeleteUser($request, $id), 'application/json');
    }
]);


// Posts
$router->get('/api/v1/posts', [
    'middlewares' => [
        'api',
        'cache'
    ],
    function($request) {
        return new Response(200, Api\Post::getPosts($request), 'application/json');
    }
]);

$router->get('/api/v1/posts/{id}', [
    'middlewares' => [
        'api'
    ],
    function($request, $id) {
        return new Response(200, Api\Post::getPost($request, $id), 'application/json');
    }
]);

$router->post('/api/v1/posts', [
    'middlewares' => [
        'api'
    ],
    function($request) {
        return new Response(201, Api\Post::setNewPost($request), 'application/json');
    }
]);

$router->put('/api/v1/posts/{id}', [
    'middlewares' => [
        'api'
    ],
    function($request, $id) {
        return new Response(200, Api\Post::setEditPost($request, $id), 'application/json');
    }
]);

$router->delete('/api/v1/posts/{id}', [
    'middlewares' => [
        'api',
    ],
    function($request, $id) {
        return new Response(200, Api\Post::setDeletePost($request, $id), 'application/json');
    }
]);

$router->run()->sendResponse();