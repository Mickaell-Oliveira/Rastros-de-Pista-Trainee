<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class AdminController
{
    public function index()
    {

       $page = 1;

        if (isset($_GET['paginacaoNumero']) && !empty($_GET['paginacaoNumero'])) {
            $page = intval($_GET['paginacaoNumero']);
            if ($page <= 0) {
                return redirect('admin/PostChart');
            }
        }

        $itensPage = 5;
        $inicio = ($page - 1) * $itensPage;

        $rows_count = App::get('database')->countAll('posts');

        if ($inicio >= $rows_count && $rows_count > 0 && $page > 1) {
            return redirect('admin/PostChart');
        }

        $posts = App::get('database')->selectAll('posts', $inicio, $itensPage);
        $total_pages = ceil($rows_count / $itensPage);

        $comentarios = App::get('database')->selectAllComentariosComNomes();

        return view('admin/PostChart', compact('posts', 'page', 'total_pages', 'comentarios'));
    }


    




    public function create()
    {
     
        $caminhodaimagem = 'public/assets/imagemPosts/default.jpg';

     
        if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK){
            $temporario = $_FILES['foto']['tmp_name'];
            $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            
            $nomeimagem = sha1(uniqid($_FILES['foto']['name'], true)) . "." . $extensao;


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
            'foto'        => $caminhodaimagem,
            'marca'       => $_POST['marca'] ?? null
        ];

        App::get('database')->insert('posts', $parameters);
        header('Location: /tabelaposts');
    }


    public function delete()
    {
        $id = $_POST['id'];
        $post = App::get('database')->selectOne('posts', $id);

    
        $caminhodaimagem = $post->foto ?? $post->imagem ?? null; 
        
        if($caminhodaimagem && file_exists($caminhodaimagem) && !strpos($caminhodaimagem, 'default')){
            unlink($caminhodaimagem);
        }

        App::get('database')->delete('posts', $id);
        header('Location: /tabelaposts');
    }
      

    public function edit()
    {
        $id = $_POST['id'];
        $caminhodaimagem = $_POST['foto_atual'] ?? 'public/assets/imagemPosts/default.jpg';


        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $temporario = $_FILES['foto']['tmp_name'];
            $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

            $nomeimagem = sha1(uniqid($_FILES['foto']['name'], true)) . "." . $extensao;
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
            'foto'        => $caminhodaimagem,
            'marca'       => $_POST['marca'] ?? null
        ];
        
        App::get('database')->update('posts', $id, $parameters);
        header('Location: /tabelaposts');
    }
}