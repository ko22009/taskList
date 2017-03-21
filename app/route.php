<?php

require_once 'router.php';
require_once 'controllers/controllerMain.php';
require_once 'controllers/controller404.php';
require_once 'controllers/controllerUser.php';

$router = new Router();

// Custom 404 Handler
$router->set404(function () {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    $controller = new controller404();
    $controller->action_index();
});

$router->get('/', function () {
    $controller = new controllerMain();
    $controller->action_index();
});

// Subrouting
$router->mount('/user', function () use ($router) {

// will result in '/movies'
    $router->get('/', function () {
        $controller = new controllerUser();
        $controller->action_index();
    });

// will result in '/movies'
    $router->post('/', function () {
        echo 'add movie';
    });

// will result in '/movies/id'
    $router->get('/readAll', function () {
        $controller = new controllerUser();
        $controller->action_readAll();
    });

// will result in '/movies/id'
    $router->put('/(\d+)', function ($id) {
        echo 'Update movie id ' . htmlentities($id);
    });

});

$router->run();