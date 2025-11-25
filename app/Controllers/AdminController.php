<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class AdminController
{
    public function index()
    { 
        $page = 1; 
        if(isset($_GET['paginacaoNumero']) && !empty($_GET['paginacaoNumero'])){
        $page = intval($_GET['paginacaoNumero']);
        if($page <= 0){
            return redirect('admin/PostChart');
        }
        }
        $itensPage = 5;
        $inicio = $itensPage * $page - $itensPage;

        $rows_count = App::get('database')->countAll('posts');

        if($inicio > $rows_count){
            return redirect('admin/PostChart');
        }
        $posts = App::get('database')->selectAll('posts',$inicio,$itensPage);
        $total_pages = ceil($rows_count/$itensPage);
        return view('admin/PostChart', compact('posts', 'page', 'total_pages'));
    }

    public function create()
    {
        $caminhoNoBanco = 'public/assets/imagemPosts/default.jpg';
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
      header('Location: /tabelaposts');

    $caminhodaimagem = $post->imagem;
    if(file_exists($caminhodaimagem)){
                unlink($caminhodaimagem);
            }
    App::get('database')->delete('posts', $id);
    header('Location: /tabelaposts');

    }
      
    public function edit()
    {
        $id = $_POST['id'];
        $nomeimagem = $_POST['foto_atual'] ?? 'default.png';
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

?>