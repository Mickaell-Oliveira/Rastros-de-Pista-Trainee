<?php

namespace App\Controllers;

use App\Core\App;

class AdminController
{
    private function verificarSessao()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['id'])) {
            header('Location: /login');
            exit;
        }
        
        return $_SESSION['id'];
    }

    public function index()
    { 
        $idUsuarioLogado = $this->verificarSessao();

        $userQuery = App::get('database')->selectOne('usuarios', $idUsuarioLogado);
        $user = !empty($userQuery) ? $userQuery[0] : null;

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

        if($inicio > $rows_count && $rows_count > 0){
            return redirect('admin/PostChart');
        }
        
        $posts = App::get('database')->selectAll('posts', $inicio, $itensPage);

        if (!empty($posts)) {
            foreach ($posts as $post) {
                $totais = App::get('database')->buscarTotaisInteracao($post->id);
                $post->likes = $totais->likes;
                $post->dislikes = $totais->dislikes;
                
                $post->total_comentarios = App::get('database')->countComentariosPorPost($post->id);
            }
        }

        $total_pages = ceil($rows_count/$itensPage);
        $comentarios = App::get('database')->selectAllComentariosComNomes();

        if (!empty($comentarios)) {
            foreach ($comentarios as $comentario) {
                $totaisComent = App::get('database')->buscarTotaisComentario($comentario->id);
                $comentario->likes_count = $totaisComent->likes;
                $comentario->dislikes_count = $totaisComent->dislikes;
            }
        }
        
        return view('admin/PostChart', compact('posts', 'page', 'total_pages', 'comentarios', 'user'));
    }

    public function create()
    {
        $idUsuarioLogado = $this->verificarSessao();

        $dadosUsuario = App::get('database')->selectOne('usuarios', $idUsuarioLogado);
        
        $nomeAutor = 'Admin';
        if (!empty($dadosUsuario)) {
            $nomeAutor = $dadosUsuario[0]->nome ?? 'Admin'; 
        }

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
            'id_usuario'  => $idUsuarioLogado, 
            'autor'       => $nomeAutor,
            'data'        => date('Y-m-d H:i:s'),
            'foto'        => $caminhodaimagem,
            'marca'       => $_POST['marca'] ?? null
        ];

        App::get('database')->insert('posts', $parameters);
     
        header('Location: /tabelaposts');
    }

    public function delete()
    {
        $idUsuarioLogado = $this->verificarSessao();
        $id = $_POST['id'];

        $postQuery = App::get('database')->selectOne('posts', $id);
        if (empty($postQuery)) {
            header('Location: /tabelaposts');
            exit;
        }
        $post = $postQuery[0];

        $userQuery = App::get('database')->selectOne('usuarios', $idUsuarioLogado);
        $user = $userQuery[0];

        if ($user->admin != 1 && $post->id_usuario != $idUsuarioLogado) {
            header('Location: /tabelaposts');
            exit;
        }
        
        $caminhodaimagem = $post->foto; 
        if(file_exists($caminhodaimagem) && !str_contains($caminhodaimagem, 'default')){
                unlink($caminhodaimagem);
        }
        App::get('database')->delete('posts', $id);
        
        header('Location: /tabelaposts');
    }
      
    public function edit()
    {
        $idUsuarioLogado = $this->verificarSessao();
        $id = $_POST['id'];
        
        $postQuery = App::get('database')->selectOne('posts', $id);
        if (empty($postQuery)) {
            header('Location: /tabelaposts');
            exit;
        }
        $postAtual = $postQuery[0];

        $userQuery = App::get('database')->selectOne('usuarios', $idUsuarioLogado);
        $user = $userQuery[0];

        if ($user->admin != 1 && $postAtual->id_usuario != $idUsuarioLogado) {
            header('Location: /tabelaposts');
            exit;
        }

        $caminhodaimagem = $postAtual->foto; 

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
            'id_usuario'  => $postAtual->id_usuario, 
            'autor'       => $_POST['autor'],
            'data'        => date('Y-m-d H:i:s'),
            'foto'        => $caminhodaimagem,
            'marca'       => $_POST['marca'] ?? null
        ];

        App::get('database')->update('posts', $id, $parameters);
        header('Location: /tabelaposts');
    }

    public function updateComment()
    {
        $this->verificarSessao();
        $idUsuarioLogado = $_SESSION['id'];
        
        $userQuery = App::get('database')->selectOne('usuarios', $idUsuarioLogado);
        $user = $userQuery[0];

        if ($user->admin != 1) {
             header('Location: /tabelaposts');
             exit;
        }

        $id = $_POST['id_comentario'];
        $texto = $_POST['novo_texto'];

        App::get('database')->update('comentarios', $id, [
            'comentario' => $texto
        ]);

        header('Location: /tabelaposts');
    }

    public function deleteComment()
    {   
        $this->verificarSessao();
        $idUsuarioLogado = $_SESSION['id'];

        $userQuery = App::get('database')->selectOne('usuarios', $idUsuarioLogado);
        $user = $userQuery[0];

        $id = $_POST['id'];
        
        if ($user->admin != 1) {
            $comentarioQuery = App::get('database')->selectOne('comentarios', $id);
            if (!empty($comentarioQuery)) {
                $comentario = $comentarioQuery[0];
                
                $postQuery = App::get('database')->selectOne('posts', $comentario->id_post);
                if (!empty($postQuery)) {
                    $post = $postQuery[0];
                    if ($post->id_usuario != $idUsuarioLogado && $comentario->id_usuario != $idUsuarioLogado) {
                        http_response_code(403);
                        exit;
                    }
                }
            }
        }

        App::get('database')->delete('comentarios', $id);
        http_response_code(200);
    }
}