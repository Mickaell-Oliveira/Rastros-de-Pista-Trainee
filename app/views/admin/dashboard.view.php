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
    <div class="linha-divisoria fora-cima"></div>
    <div class="barra-vertical esquerda"></div>
    <div class="caixa-preta">
            <div class="barra-logo">
                <div class="conteudo-logo">
                    <img src="../../../public/assets/LogoRatoBandeira.png" alt="Logo Rato com Bandeira" class="rato-bandeira">
                    <img src="../../../public/assets/LogoTextoBranca.png" alt="Logo Rastros de Pista" class="logo-texto">
                </div>
            </div>
            <div class="caixa-botoes centralizar-botoes">
                <form action="/tabelaposts" method="POST">
                <button class="botao-motor">
                    <div class="imagem-botao">
                        <img src="../../../public/assets/fotomotor.png" alt="Ícone Motor">
                    </div>
                    <span>Posts</span>
                </button>
                </form>
                <button class="botao-garagem">
                    <div class="imagem-botao">
                        <img src="../../../public/assets/garegem.png" alt="Ícone Garagem">
                    </div>
                    <span>Usuários</span>
                </button>

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