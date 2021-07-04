<?php

use \App\Http\Response;
use \App\Controller\Admin;

$obRouter->get('/admin/posts',[
    'middlewares' => [
        'require-admin-login'
    ],
    function($request) {
        return new Response(200, Admin\Post::getPosts($request));
    }
]);

$obRouter->get('/admin/posts/new',[
    'middlewares' => [
        'require-admin-login'
    ],
    function($request) {
        return new Response(200, Admin\Post::getNewPost($request));
    }
]);

$obRouter->post('/admin/posts/new',[
    'middlewares' => [
        'require-admin-login'
    ],
    function($request) {
        return new Response(200, Admin\Post::setNewPost($request));
    }
]);

$obRouter->get('/admin/posts/{id}/edit',[
    'middlewares' => [
        'require-admin-login'
    ],
    function($request, $id) {
        return new Response(200, Admin\Post::getEditPost($request, $id));
    }
]);

$obRouter->post('/admin/posts/{id}/edit',[
    'middlewares' => [
        'require-admin-login'
    ],
    function($request, $id) {
        return new Response(200, Admin\Post::setEditPost($request, $id));
    }
]);

$obRouter->get('/admin/posts/{id}/delete',[
    'middlewares' => [
        'require-admin-login'
    ],
    function($request, $id) {
        return new Response(200, Admin\Post::getDeletePost($request, $id));
    }
]);

$obRouter->post('/admin/posts/{id}/delete',[
    'middlewares' => [
        'require-admin-login'
    ],
    function($request, $id) {
        return new Response(200, Admin\Post::setDeletePost($request, $id));
    }
]);