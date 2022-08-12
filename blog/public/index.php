<?php

ini_set('display_errors', true);
error_reporting(E_ALL);

session_start();

require __DIR__ . '/../vendor/autoload.php';

$router = new \App\Router();

$router->get('/', [\App\Controllers\PostController::class, 'index']);
$router->post('/posts', [\App\Controllers\PostController::class, 'store']);
$router->post('/posts/rate', [\App\Controllers\PostController::class, 'rate']);
$router->post('/comments', [\App\Controllers\CommentController::class, 'store']);

(new App\App(
    $router,
    $_SERVER['REQUEST_URI'],
    strtolower($_SERVER['REQUEST_METHOD']),
    (new \App\Config())
))->run();

