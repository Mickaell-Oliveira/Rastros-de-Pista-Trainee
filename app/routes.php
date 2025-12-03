<?php

namespace App\Controllers;
use App\Controllers\ExampleController;
use App\Core\Router;

$router->get('usuarios', 'userAdminController@index');
$router->post('user/create', 'userAdminController@create');
$router->post('user/edit', 'userAdminController@edit');
$router->post('user/delete', 'userAdminController@delete');

$router->get('admin/userlist', 'userAdminController@index');

?>