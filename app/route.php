<?php

$router = new Router();

// Custom 404 Handler
$router->set404(function () {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    $controller = new controller404();
    $controller->index();
});

$router->mount('/api', function () use ($router) {
    $router->mount('/user', function () use ($router) {

    });
});

$router->get('/', 'controllerMain@index');

$router->get('/signout', 'controllerUser@register_index');
$router->post('/signout', 'controllerUser@register_create');
$router->get('/signin', 'controllerUser@login_index');
$router->post('/signin', 'controllerUser@login_in');
$router->get('/logout', 'controllerUser@login_out');

$router->get('/img', 'controllerImage@index');
$router->post('/img', 'controllerImage@load');

$router->before('GET', ['/signout', '/signin'], function() {
    Router::csrf_before();
    if(Router::is_auth())
    {
        header("Location: http://" . $_SERVER['HTTP_HOST']);
        exit();
    }
});

$router->before('POST', ['/signout', '/signin'], function() {
    if(Router::is_auth())
    {
        header("Location: http://" . $_SERVER['HTTP_HOST']);
        exit();
    }
    Router::csrf_after();
});
/**
$router->mount('/user', function () use ($router) {
    $router->get('/', 'controllerUser@index');
    $router->patch('/(\d+)', 'controllerUser@update');
    $router->delete('/(\d+)', 'controllerUser@delete');
});
*/

$router->run();