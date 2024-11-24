<?php

require "vendor/autoload.php";
require "init.php";

// Database connection object (from init.php (DatabaseConnection))
global $conn;

try {

    // Create Router instance
    $router = new \Bramus\Router\Router();

    // Define routes
    $router->get('/', '\App\Controllers\HomeController@index');

    $router->get('/register', '\App\Controllers\RegisterController@registrationForm');
    $router->post('/register', '\App\Controllers\RegisterController@register');

    $router->get('/login', '\App\Controllers\LoginController@loginForm');
    $router->post('/login', '\App\Controllers\LoginController@login');

    $router->get('/menu', '\App\Controllers\MenuController@index');
    $router->post('/menu', '\App\Controllers\MenuController@order');

    $router->get('/order', '\App\Controllers\OrderController@index');
    $router->post('/order', '\App\Controllers\OrderController@submitOrder');

    // Run it!
    $router->run();

} catch (Exception $e) {

    echo json_encode([
        'error' => $e->getMessage()
    ]);

}

