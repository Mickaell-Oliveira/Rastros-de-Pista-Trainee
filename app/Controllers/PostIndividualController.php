<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class PostIndividualController
{

    public function PostIndividual()
    {
        $posts = App::get('database')->selectAll('posts');
        $comentarios = App::get('database')->selectAll('comentarios');
        return view('site/Pagina_Individual', compact('posts', 'comentarios'));
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
        header('Location: /postindividual');

    }
}
?>