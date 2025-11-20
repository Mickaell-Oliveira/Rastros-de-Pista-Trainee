<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class AdminController
{
    public function index()
    {
        $posts = App::get('database')->selectAll('posts');
        return view('admin/PostChart', compact('posts'));
    }

    public function create()
    {
        
        $nomeimagem = 'default.png'; 

      
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            
            $temporario = $_FILES['imagem']['tmp_name'];
            $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            
            $nomeimagem = sha1(uniqid($_FILES['imagem']['name'], true)) . "." . $extensao;

            $caminhodaimagem = "public/assets/imagemPosts/" . $nomeimagem;

            move_uploaded_file($temporario, $caminhodaimagem);
        }
        
  
        $parameters = [
            'veiculo'     => $_POST['veiculo'] ?? null,
            'ano_veiculo' => $_POST['ano_veiculo'] ?? null,
            'titulo'      => $_POST['titulo'] ?? null,
            'descricao'   => $_POST['descricao'] ?? null,
            'categoria'   => $_POST['post-tipo'] ?? null,
            'id_usuario'  => 1, 
            'autor'       => $_POST['autor'] ?? 'Admin',
            'data'        => date('Y-m-d H:i:s'),
            'foto'        => $nomeimagem,
            'marca'       => $_POST['marca'] ?? null
        ];

        App::get('database')->insert('posts', $parameters);

     
        header('Location: /tabelaposts');

      
    }
  public function delete()
        {
         $id = $_POST['id'];

          App::get('database')->delete('posts', $id);

          header('Location: /tabelaposts');
        }
      
} 

?>