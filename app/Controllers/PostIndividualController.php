<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class PostIndividualController
{

    public function PostIndividual()
    {
        if (!isset($_GET['id'])) {
            die('ID do post não fornecido.');
        }

        $id_post = $_GET['id'];

        $post = App::get('database')->selectById('posts', $id_post);

        $comentarios = App::get('database')->selectWhere('comentarios', ['id_post' => $id_post]);

        return view('site/Pagina_Individual', compact('post', 'comentarios'));
    }

    public function createComentario()
    {
        $parameters = [
            'id_usuario' => 1,
            'id_post' => $_POST['id_post'],
            'data' => date('Y-m-d H:i:s'),
            'comentario' => $_POST['comentario'] ?? null
        ];
                
        App::get('database')->insert('comentarios', $parameters);
        
        header('Location: /postindividual?id=' . $_POST['id_post']);
    }
}
?>