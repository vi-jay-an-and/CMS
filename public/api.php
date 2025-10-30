<?php

declare(strict_types=1);

use App\Core\Request;
use App\Core\Router;

$container = require __DIR__ . '/../src/bootstrap.php';
$request = Request::capture();
$router = new Router();

$registerRoutes = require __DIR__ . '/../config/routes.php';
$registerRoutes($router, $container);

$response = $router->dispatch($request);
$response->send();
