<?php


$router->get('login', 'LoginController@index');
$router->get('dashboard', 'LoginController@dashboard');
$router->post('login', 'LoginController@efetuaLogin');
$router->post('logout', 'LoginController@logout');


$router->get('tabelaposts', 'AdminController@index');
$router->post('tabelaposts/criar', 'AdminController@create');
$router->post('excluirPost', 'AdminController@delete');
$router->post('editarPost', 'AdminController@edit');


$router->get('admin/PostChart', 'AdminController@index');


$router->post('tabelaposts/atualizarComentario', 'AdminController@updateComment');
$router->post('tabelaposts/deletarComentario', 'AdminController@deleteComment');


$router->get('home', 'HomeController@index');

$router->get('usuarios', 'userAdminController@index');
$router->post('user/create', 'userAdminController@create');
$router->post('user/edit', 'userAdminController@edit');
$router->post('user/delete', 'userAdminController@delete');

$router->get('admin/userlist', 'userAdminController@index');

?>