<?php

namespace App\Controllers;
use App\Controllers\ExampleController;
use App\Core\Router;

$router->get('usuarios', 'AdminController@index');
$router->post('user/create', 'AdminController@create');
$router->post('user/edit', 'AdminController@edit');
$router->post('user/delete', 'AdminController@delete');

?>