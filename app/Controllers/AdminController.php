<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class AdminController
{

    public function index()
    {
        $usuarios = App::get('database')->selectAll('usuarios');



        return view('admin/userlist', compact('usuarios'));
    }

    public function create()
    {
        $parameters = [
            'nome' => $_POST['name'],
            'email' => $_POST['email'],
            'senha' => $_POST['senha']
        ];


        App::get('database')->insert('usuarios', $parameters);

        header('Location: /usuarios');

    }

    public function edit()
    {
    
             $parameters = [
            'nome' => $_POST['name'],
            'email' => $_POST['email'],
            'senha' => $_POST['senha']
        ];

        $id = $_POST['id'];  // pegar o id do calabreso

        App::get('database')->update('usuarios', $id, $parameters);

        header('Location: /usuarios');




        
    }

    public function delete()
    {
        $id = $_POST['id'];  // pegar o id do calabreso

        App::get('database')->delete('usuarios', $id);

        header('Location: /usuarios');

    }



}