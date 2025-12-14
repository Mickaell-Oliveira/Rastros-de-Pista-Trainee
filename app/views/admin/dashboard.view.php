<?php
    session_start();

    if(!isset($_SESSION['id'])){
        header('Location: /login');
    }
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css"> 
</head>



<body>
    <div class="caixa-principal">
    <div class="caixa-preta">

            <div id="botaoHome">
                <a href="/home" class="home"><svg xmlns="http://www.w3.org/2000/svg" class= "casinha" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z"/></svg></a>
            </div>

            <div class="barra-logo">
                <div class="conteudo-logo">
                    <img src="../../../public/assets/LogoRatoBandeira.png" alt="Logo Rato com Bandeira" class="rato-bandeira">
                    <img src="../../../public/assets/LogoTextoBranca.png" alt="Logo Rastros de Pista" class="logo-texto">
                </div>
            </div>
            <div class="caixa-botoes centralizar-botoes">
                <form action="/tabelaposts" method="GET">
                <a href="PostChart.view.php" id="caminhoPost"><button class="botao-motor">
                    <div class="imagem-botao">
                        <img src="../../../public/assets/fotomotor.png" alt="Ícone Motor">
                    </div>
                    <span>Posts</span>
                </button>
                </a>
                </form>

                <form action="/usuarios" method="GET">
                <a href="/userlist.view.php" id="caminhoUser">
                <button class="botao-garagem">
                    <div class="imagem-botao">
                        <img src="../../../public/assets/garegem.png" alt="Ícone Garagem">
                    </div>
                    <span>Usuários</span>
                </button>
                </a>
                </form>

                <form action="/logout" method="POST">
                <button class="botao-sair">
                    <div class="imagem-botao">
                        <img src="../../../public/assets/loggoutbotao.png" alt="Ícone Sair">
                    </div>
                    <span>Logout</span>
                </button>
                </form>
            </div>
        </div>
    <div class="barra-vertical direita"></div>
    <div class="linha-divisoria fora-baixo"></div>
    </div>
</body>

</html>