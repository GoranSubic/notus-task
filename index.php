<?php

// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';

use App\Controller\Api\Provider;

// Create Router instance
$router = new \Bramus\Router\Router();

// Define routes
$router->get('/', function () {
    echo 'Test';
});

$router->get('/product/{id}', Provider::class . '@getProduct');

$router->get('/products(/\d+)?(/\d+)?(/[a-z]+)?(/(?:asc|desc))?', Provider::class . '@getProducts');

// Run it!
$router->run();
