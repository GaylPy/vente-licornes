<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

// Home page
$app->get('/', function () use ($app) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'yoannkozlowski.noip.me/api/last/produits');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);

    $lastProducts = json_decode($response);

    return $app['twig']->render('index.html.twig', array('lastProducts' => $lastProducts));
})->bind('home');

// Connection
$app->get('/connection', function () use ($app) {
    return $app['twig']->render('connection.html.twig');
})->bind('connection');

// Session
$app->get('/session', function () use ($app) {
    $app['session']->set('user', array(
        'nom' => 'KOZLOWSKI',
        'prenom' => 'Yoann',
        'email' => 'Yoann_03@hotmail.fr'
    ));

    return $app->redirect('/');
})->bind('session');

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

// Catalog
$app->get('/catalog', function () use ($app) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'yoannkozlowski.noip.me/api/produits');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);

    $data = json_decode($response);

    return $app['twig']->render('catalog.html.twig', array('produits' => $data));
})->bind('catalog');

// Product
$app->get('/product/{id}', function ($id) use ($app) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'yoannkozlowski.noip.me/api/last/produits');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);

    $lastProducts = json_decode($response);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'yoannkozlowski.noip.me/api/produits/get/prix?produit=' . $id . '&ecurie=1');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);

    $produit = json_decode($response);

    return $app['twig']->render('product.html.twig', array('lastProducts' => $lastProducts, 'produit' => $produit));
})->assert('id', '\d+')->bind('product');