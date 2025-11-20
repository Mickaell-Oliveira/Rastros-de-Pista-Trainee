<?php

namespace App\Controllers;
use App\Controllers\ExampleController;
use App\Core\Router;

$router->get('usuarios', 'AdminControllerUser@index');
$router->post('user/create', 'AdminControllerUser@create');
$router->post('user/edit', 'AdminControllerUser@edit');
$router->post('user/delete', 'AdminControllerUser@delete');

?>