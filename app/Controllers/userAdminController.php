<?php

namespace App\Controllers;

use App\Core\App;

class UserAdminController
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
                return redirect('admin/userlist');
            }
        }
        
        $itensPage = 5;
        $inicio = $itensPage * $page - $itensPage;

        $rows_count = App::get('database')->countAll('usuarios');

        if($inicio > $rows_count && $rows_count > 0){
            return redirect('admin/userlist');
        }

        $usuarios = App::get('database')->selectAll('usuarios', $inicio, $itensPage);
        $total_pages = ceil($rows_count / $itensPage);

        return view('admin/userlist', compact('usuarios', 'page', 'total_pages', 'user'));
    }

    public function create()
    {
        $this->verificarSessao();

        if ($_POST['senha'] !== $_POST['senhaConfirmar']) {
            $_SESSION['form_error'] = 'As senhas não conferem.';
            header('Location: /usuarios');
            exit;
        }

        $nomeimagem = 'default.png'; 

        if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK){
            $temporario = $_FILES['foto']['tmp_name'];
            $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            
            $nomeimagem = sha1(uniqid($_FILES['foto']['name'], true)) . "." . $extensao;
            $caminhodaimagem = "public/assets/imagemUsuario/" . $nomeimagem;

            move_uploaded_file($temporario, $caminhodaimagem);
        }

        $parameters = [
            'nome' => $_POST['name'],
            'email' => $_POST['email'],
            'senha' => $_POST['senha'],
            'data' => date('Y-m-d H:i:s'),
            'foto' => $nomeimagem
        ];

        App::get('database')->insert('usuarios', $parameters);
        header('Location: /usuarios');
    }

    public function edit()
    {
        $idUsuarioLogado = $this->verificarSessao();
        $idAlvo = $_POST['id'];

        $userLogadoQuery = App::get('database')->selectOne('usuarios', $idUsuarioLogado);
        $userLogado = $userLogadoQuery[0];

        if ($userLogado->admin != 1 && $userLogado->id != $idAlvo) {
            header('Location: /usuarios');
            exit;
        }
    
        if (isset($_POST['senha']) && !empty($_POST['senha'])) {
            if ($_POST['senha'] !== $_POST['senhaConfirmar']) {
                $_SESSION['form_error'] = 'As senhas não conferem.';
                header('Location: /usuarios');
                exit;
            }
        }

        $usuarioAtualQuery = App::get('database')->selectOne('usuarios', $idAlvo);
        $usuarioAtual = $usuarioAtualQuery[0];
        $nomeimagem = $usuarioAtual->foto; 

        if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK){
            $temporario = $_FILES['foto']['tmp_name'];
            $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            
            $nomeimagem = sha1(uniqid($_FILES['foto']['name'], true)) . "." . $extensao;
            $caminhodaimagem = "public/assets/imagemUsuario/" . $nomeimagem;

            move_uploaded_file($temporario, $caminhodaimagem);
        }

        $parameters = [
            'nome'  => $_POST['name'] ?? $usuarioAtual->nome,
            'email' => $_POST['email'] ?? $usuarioAtual->email,
            'foto'  => $nomeimagem
        ];

        if (!empty($_POST['senha'])) {
            $parameters['senha'] = $_POST['senha'];
        }

        App::get('database')->update('usuarios', $idAlvo, $parameters);
        header('Location: /usuarios');
    }

    public function delete()
    {
        $idUsuarioLogado = $this->verificarSessao();
        $idAlvo = $_POST['id']; 

        $userLogadoQuery = App::get('database')->selectOne('usuarios', $idUsuarioLogado);
        $userLogado = $userLogadoQuery[0];

        if ($userLogado->admin != 1 && $userLogado->id != $idAlvo) {
            header('Location: /usuarios');
            exit;
        }

        App::get('database')->delete('usuarios', $idAlvo);
        header('Location: /usuarios');
    }
}