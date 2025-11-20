<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class AdminController
{

    public function index()
    {
        $posts = App::get('database') -> selectAll('posts');
        return view('admin/PostChart', ['posts' => $posts]);
    }

    public function create()
    {
        $parameters = [
            'veiculo' => $_POST['veiculo'] ?? null,
            'ano_veiculo' => $_POST['ano_veiculo'] ?? null,
            'titulo' => $_POST['titulo'] ?? null,
            'descricao' => $_POST['descricao'] ?? null,
            'categoria' => $_POST['post-tipo'] ?? null,
            'id_usuario' => 1,
            'autor' => $_POST['autor'] ?? null,
            'data' => $_POST['data'] ?? null,
            'foto' => $_POST[''] ?? null,
            'marca' => $_POST['marca'] ?? null,
            'id' => $_POST['id'] ?? null
        ];

        App::get('database')->insert('posts',$parameters);

        header('Location: /tabelaposts');
    }
}

?>
