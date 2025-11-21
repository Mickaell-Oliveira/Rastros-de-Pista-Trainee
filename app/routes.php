<?php

namespace App\Controllers;
use App\Controllers\ExampleController;
use App\Core\Router;

$router->get('tabelaposts', 'AdminController@index');
$router->get('postindividual', 'PostIndividualController@PostIndividual');
$router->post('postindividual/criarcomentar', 'PostIndividualController@createComentario');
$router->post('tabelaposts/criar', 'AdminController@create');
$router->post('excluirPost', 'AdminController@delete');
$router->post('editarPost', 'AdminController@edit');

?>