<?php


$router->get('login', 'LoginController@index');
$router->get('dashboard', 'LoginController@dashboard');
$router->post('login', 'LoginController@efetuaLogin');
$router->post('logout', 'LoginController@logout');


$router->get('tabelaposts', 'AdminController@index');
$router->get('postindividual', 'PostIndividualController@PostIndividual');
$router->get('postspage', 'ListaPostsController@ListaPosts');
$router->post('postindividual/criarcomentar', 'PostIndividualController@createComentario');
$router->post('tabelaposts/criar', 'AdminController@create');
$router->post('excluirPost', 'AdminController@delete');
$router->post('editarPost', 'AdminController@edit');


$router->get('admin/PostChart', 'AdminController@index');


$router->post('tabelaposts/atualizarComentario', 'AdminController@updateComment');
$router->post('tabelaposts/deletarComentario', 'AdminController@deleteComment');


$router->get('home', 'HomeController@index');

$router->get('usuarios', 'UserAdminController@index');
$router->post('user/create', 'UserAdminController@create');
$router->post('user/edit', 'UserAdminController@edit');
$router->post('user/delete', 'UserAdminController@delete');

$router->get('admin/userlist', 'UserAdminController@index');

?>