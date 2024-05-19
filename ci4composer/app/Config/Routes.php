<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/komik/index', 'Komik::index');
$routes->get('/komik/create', 'Komik::create');
$routes->get('/komik/edit/(:segment)', 'Komik::edit/$1');
$routes->get('/komik/save', 'Komik::save');
$routes->delete('/komik/(:num)', 'Komik::delete/$1');

$routes->get('komik/(:any)', 'Komik::detail/$1');

//Buat Route baru untuk mengakses detail
$routes->get('/komik/(:segment)', 'Komik::detail/$1');