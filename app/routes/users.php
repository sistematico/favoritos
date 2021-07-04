<?php

use \App\Http\Response;
use \App\Controller\Pages;

$obRouter->get('/user',[
    'middlewares' => ['require-user-login'],
    function($request) {
        return new Response(200, Pages\Profile::getHome($request));
    }
]);

$obRouter->get('/user/login',[
    'middlewares' => ['require-user-logout'],
    function($request) {
        return new Response(200, Pages\Login::getLogin($request));
    }
]);

$obRouter->get('/user/logout',[
    'middlewares' => ['require-user-login'],
    function($request) {
        return new Response(200, Pages\Login::setLogout($request));
    }
]);

$obRouter->post('/user/login',[
    'middlewares' => ['require-user-logout'],
    function($request) {
        return new Response(200, Pages\Login::setLogin($request));
    }
]);
