<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

//Buat Route baru untuk mengakses detail
$routes->get('/komik/(:segment)', 'Komik::detail/$1');