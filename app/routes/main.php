<?php

use \App\Http\Response;
use \App\Controller\Pages;

$obRouter->get('/',[
    'middlewares' => [
        'maintenance',
        'cache'
    ],
    function($request) {
        return new Response(200, Pages\Post::getPosts($request));
    }
]);

$obRouter->get('/posts',[
    'middlewares' => [
        'maintenance',
        'require-user-login'
    ],
    function($request) {
        return new Response(200, Pages\Post::getPosts($request));
    }
]);

$obRouter->get('/posts/new',[
    'middlewares' => [
        'maintenance',
        'require-user-login'
    ],
    function($request) {
        return new Response(200, Pages\Post::addPost());
    }
]);

$obRouter->post('/posts/new',[
    'middlewares' => [
        'maintenance',
        'require-user-login'
    ],
    function($request) {
        return new Response(200, Pages\Post::insertPost($request));
    }
]);