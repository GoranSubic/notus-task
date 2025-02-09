<?php

// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';

use App\Controller\Api\Provider;

// Create Router instance
$router = new \Bramus\Router\Router();

// Define routes
$router->get('/', function () {
    $template = file_get_contents(__DIR__ . '/templates/home.tpl');
    echo $template;
});

$router->get('/product/{id}', Provider::class . '@getProduct');

$router->get('/products/search', Provider::class . '@searchProducts');

$router->get('/products(/\d+)?(/\d+)?(/[a-z]+)?(/(?:asc|desc))?', Provider::class . '@getProducts');

// Run it!
$router->run();
