<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class ExampleController
{

    public function index()
    {
        $users = App::get('database')->selectAll('users');



        return view('admin/index', compact('users'));
    }

    public function create()
    {
        $parameters = [
            'nome' => $_POST['name'],
            'email' => $_POST['email'],
            'senha' => $_POST['senha']
        ];


        App::get('database')->insert('users', $parameters);

        header('Location: /users');

    }

    public function edit()
    {
    
             $parameters = [
            'nome' => $_POST['name'],
            'email' => $_POST['email'],
            'senha' => $_POST['senha']
        ];

        $id = $_POST['id'];  // pegar o id do calabreso

        App::get('database')->update('users', $id, $parameters);

        header('Location: /users');




        
    }

    public function delete()
    {
        $id = $_POST['id'];  // pegar o id do calabreso

        App::get('database')->delete('users', $id);

        header('Location: /users');

    }



}