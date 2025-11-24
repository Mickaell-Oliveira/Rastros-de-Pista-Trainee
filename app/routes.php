<?php

namespace App\Controllers;
use App\Controllers\ExampleController;
use App\Core\Router;

    $router->get('login', 'LoginController@index');
    $router->get('dashboard', 'LoginController@dashboard');
    $router->post('login', 'LoginController@efetuaLogin');
    $router->POST('logout', 'LoginController@logout');

?>