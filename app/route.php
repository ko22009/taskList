<?php

$router = new Router();

// Custom 404 Handler
$router->set404(function () {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    $controller = new controller404();
    $controller->index();
});

$router->get('/', 'controllerMain@index');

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

$router->before('GET', '/logout', function() {
    if(Router::is_auth())
    {
        header("Location: http://" . $_SERVER['HTTP_HOST']);
        exit();
    }
});

$router->get('/signout', 'controllerUser@register_index');
$router->post('/signout', 'controllerUser@register_create');
$router->get('/signin', 'controllerUser@login_index');
$router->post('/signin', 'controllerUser@login_in');
$router->get('/logout', 'controllerUser@login_out');

$router->mount('/api', function () use ($router) {
    $router->mount('/user', function () use ($router) {
    });
    $router->mount('/list', function () use ($router) {
        $router->post('/create', 'controllerList@api_create');
        $router->post('/read', 'controllerList@api_read');
        $router->post('/update', 'controllerList@api_update');
        $router->post('/delete', 'controllerList@api_delete');
    });
});

$router->get('/img', 'controllerImage@index');
$router->post('/img', 'controllerImage@load');

$router->before('GET', ['/list', '/task'], function() {
    if(!Router::is_auth())
    {
        header("Location: http://" . $_SERVER['HTTP_HOST']);
        exit();
    }
});

$router->get('/list', 'controllerList@index');
$router->get('/task', 'controllerTask@index');

/**
$router->mount('/user', function () use ($router) {
    $router->get('/', 'controllerUser@index');
    $router->patch('/(\d+)', 'controllerUser@update');
    $router->delete('/(\d+)', 'controllerUser@delete');
});
*/

$router->run();