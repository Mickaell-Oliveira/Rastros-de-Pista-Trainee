<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class LoginController
{

    public function index()
    {
        session_start();

        if(isset($_SESSION['id'])){
            header(header: 'Location: /home');
        }

        return view('site/login');
    }

    public function dashboard()
    {
        return view('admin/dashboard');
    }


    public function efetuaLogin()
    {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $user = App::get('database') -> verificaLogin($email, $senha);

        if($user != false){
            session_start();
            $_SESSION['id'] = $user -> id;
            header('Location: /home');
            exit();
        }
        else{
            session_start();
            $_SESSION['mensagemErro'] = "Usuário e/ou senha incorretos";
            header(header: 'Location: /login');
        } 
                
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /login');
    }
}

?>