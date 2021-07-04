<?php

use App\Http\Router;
require_once '../app/bootstrap.php';

$router = new Router(URL);

require __DIR__ . '/routes/admin.php';
require __DIR__ . '/routes/api.php';
require __DIR__ . '/routes/main.php';
require __DIR__ . '/routes/users.php';

$router->run()->sendResponse();