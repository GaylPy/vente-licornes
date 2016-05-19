<?php

// Home page
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
})->bind('home');

// Connection
$app->get('/connection', function () use ($app) {
    return $app['twig']->render('connection.html.twig');
})->bind('connection');

// Account
$app->get('/account', function () use ($app) {
    return $app['twig']->render('account.html.twig');
})->bind('account');

// ShoppingCart
$app->get('/shoppingCart', function () use ($app) {
    return $app['twig']->render('shoppingCart.html.twig');
})->bind('shoppingCart');

// ShoppingCartHisto
$app->get('/shoppingCartHisto', function () use ($app) {
    return $app['twig']->render('shoppingCartHisto.html.twig');
})->bind('shoppingCartHisto');