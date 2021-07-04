<?php

use \App\Http\Response;
use \App\Controller\Api;

$obRouter->get('/api/v1/posts', [
    'middlewares' => [
        'api',
        'cache'
    ],
    function($request) {
        return new Response(200, Api\Post::getPosts($request), 'application/json');
    }
]);

$obRouter->get('/api/v1/posts/{id}', [
    'middlewares' => [
        'api'
    ],
    function($request, $id) {
        return new Response(200, Api\Post::getPost($request, $id), 'application/json');
    }
]);

$obRouter->post('/api/v1/posts', [
    'middlewares' => [
        'api'
    ],
    function($request) {
        return new Response(201, Api\Post::setNewPost($request), 'application/json');
    }
]);

$obRouter->put('/api/v1/posts/{id}', [
    'middlewares' => [
        'api'
    ],
    function($request, $id) {
        return new Response(200, Api\Post::setEditPost($request, $id), 'application/json');
    }
]);

$obRouter->delete('/api/v1/posts/{id}', [
    'middlewares' => [
        'api',
    ],
    function($request, $id) {
        return new Response(200, Api\Post::setDeletePost($request, $id), 'application/json');
    }
]);