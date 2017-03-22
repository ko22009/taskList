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
$router->post('/logout', 'controllerUser@login_out');

$router->before('GET', ['/signout', '/signin'], function() use($router) {
    $router->csrf_before();
    $router->is_auth();
});

$router->before('POST', ['/signout', '/signin'], function() use($router) {
    $router->is_auth();
});

$router->get('/user', 'controllerUser@index');
/**
$router->mount('/user', function () use ($router) {
    $router->get('/', 'controllerUser@index');
    $router->patch('/(\d+)', 'controllerUser@update');
    $router->delete('/(\d+)', 'controllerUser@delete');
});
*/

$router->run();