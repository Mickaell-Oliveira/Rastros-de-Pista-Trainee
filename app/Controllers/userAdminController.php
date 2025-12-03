<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class userAdminController
{


public function index()
    { 
        

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
        $usuarios = App::get('database')->selectAll('usuarios', $inicio, $itensPage); 

        $total_pages = ceil($rows_count / $itensPage);

        if($inicio > $rows_count){
            return redirect('admin/userlist');
        }
        $posts = App::get('database')->selectAll('usuarios',$inicio,$itensPage);
        $total_pages = ceil($rows_count/$itensPage);
        return view('admin/userlist', compact('usuarios', 'page', 'total_pages'));
    
        


        
        $usuarios = App::get('database')->selectAll('usuarios');
        return view('admin/userlist', ['usuarios' => $usuarios]);
    }




    public function create()
    {


      if ($_POST['senha'] !== $_POST['senhaConfirmar']) {
        $_SESSION['form_error'] = 'As senhas não conferem.';
        $_SESSION['open_modal'] = 'modal-criar'; 

        header('Location: /usuarios');
        exit;
    }


         $nomeimagem = 'default.png'; 

      
            $caminhoNoBanco = 'public/assets/imagemUsuario/default.jpg';
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
    
        if ($_POST['senha'] !== $_POST['senhaConfirmar']) {
        $_SESSION['form_error'] = 'As senhas não conferem.';
        $_SESSION['open_modal'] = 'modal-criar'; 

        header('Location: /usuarios');
        exit;
    }


             $nomeimagem = 'default.png'; 

      
            $caminhoNoBanco = 'public/assets/imagemUsuario/default.jpg';
            if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK){
            $temporario = $_FILES['foto']['tmp_name'];
            $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            
            $nomeimagem = sha1(uniqid($_FILES['foto']['name'], true)) . "." . $extensao;

            $caminhodaimagem = "public/assets/imagemUsuario/" . $nomeimagem;

            move_uploaded_file($temporario, $caminhodaimagem);
 
            }





        $parameters = [
            'id'    => $_POST['id'] ?? '',
            'nome'  => $_POST['name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'senha' => $_POST['senha'] ?? '',
            'data'  => date('Y-m-d H:i:s'),
            'foto' => $nomeimagem
        ];

        $id = $_POST['id'] ?? '';

        App::get('database')->update('usuarios', $id, $parameters);
        header('Location: /usuarios');

        
    }

    public function delete()
    {
        $id = $_POST['id'];  

        App::get('database')->delete('usuarios', $id);
        header('Location: /usuarios');

    }
}