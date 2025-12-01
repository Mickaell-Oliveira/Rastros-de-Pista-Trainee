<?php

namespace App\Controllers;
use App\Controllers\ExampleController;
use App\Core\Router;

    $router->get('login', 'LoginController@index');
    $router->get('dashboard', 'LoginController@dashboard');
    $router->post('login', 'LoginController@efetuaLogin');
    $router->POST('logout', 'LoginController@logout');

    $router->get('tabelaposts', 'AdminController@index');
    $router->post('tabelaposts/criar', 'AdminController@create');
    $router->post('excluirPost', 'AdminController@delete');
    $router->post('editarPost', 'AdminController@edit');
?>