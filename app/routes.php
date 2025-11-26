<?php

namespace App\Controllers;
use App\Controllers\ExampleController;
use App\Core\Router;
$router->get('admin/PostChart', 'AdminController@index');
$router->get('tabelaposts', 'AdminController@index');
$router->post('tabelaposts/criar', 'AdminController@create');
$router->post('excluirPost', 'AdminController@delete');
$router->post('editarPost', 'AdminController@edit');
$router->post('tabelaposts/atualizarComentario', 'AdminController@updateComment');
$router->post('tabelaposts/deletarComentario', 'AdminController@deleteComment');
?>