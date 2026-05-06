<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/auth/login', 'Home::index');           // Menampilkan form login
$routes->post('/auth/loginProcess', 'LoginController::loginProcess'); // Proses login
$routes->get('/auth/logout', 'LoginController::logout');         // Logout
$routes->post('/auth/regist', 'LoginController::regist');         // Regist


// Route untuk dashboard sesuai role
$routes->get('/content/admin/index', 'AdminController::index');
$routes->get('/content/index', 'UsersController::index');

//layout admin
$routes->get('/content/admin/index/dashboard', 'AdminController::index');

//input data gejala
$routes->get('/gejala', 'GejalaController::index');
$routes->post('/gejala/save', 'GejalaController::save');
$routes->post('/gejala/edit', 'GejalaController::edit');
$routes->get('/gejala/delete/(:num)', 'GejalaController::delete/$1');


//input data kerusakan
$routes->get('/kerusakan', 'kerusakanController::index');
$routes->post('/kerusakan/save', 'kerusakanController::save');
$routes->post('/kerusakan/edit', 'kerusakanController::edit');
$routes->get('/kerusakan/delete/(:num)', 'kerusakanController::delete/$1');

//input data training
$routes->get('/content/admin/index', 'TrainingController::index');
$routes->post('/content/admin/index', 'TrainingController::index');
//proses dataSet
$routes->get('/dataSet/lihat/(:num)', 'TrainingController::lihat/$1');

$routes->get('/content/admin/index', 'TestingController::index');

//proses diagnosa
$routes->get('/diagnosa', 'DiagnosaController::index');       // untuk tampilkan form checklist
$routes->post('/diagnosa/proses', 'DiagnosaController::proses'); // untuk proses diagnosa
$routes->post('/diagnosa/check', 'DiagnosaController::check');

//data users
$routes->get('/AdminSet', 'UsersController::back');
$routes->post('AdminSet/save', 'UsersController::save');
$routes->post('AdminSet/edit', 'UsersController::edit');
$routes->get('AdminSet/delete/(:num)', 'UsersController::delete/$1');

$routes->get('/Laporan', 'LaporanController::index');
