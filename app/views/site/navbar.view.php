<?php 

if (session_status() === PHP_SESSION_NONE) { session_start(); } 

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../public/css/navbar.css">
    <link rel="shortcut icon" href="/public/assets/img/favicon.png" type="image/x-icon">
    <script src="../../../public/js/navbar.js" defer></script>
    <title>NavBar</title>
</head>
<body>
        <nav class="navbar">
            <div class="navbar-container">
                <a href="/fortuneRat" class="navbar-logo">
                    <img src="../../../public/assets/LogoCarro.png" alt="logo carro e Ratão" class="logo-site">
                </a>

                <!-- Menu de celular -->
                <div class="menu-toggle" id="mobile-menu">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
            
                <ul class="navbar-menu" id="navbar-menu">
                    <!-- Logo do ratão no celular -->
                    <a href="/home><img src="../../../public/assets/LogoCarro.png" alt="logo ratão" class="mobile-logo"></a>
                    
                    <li class="navbar-item">
                        <a href="/home" class="navbar-home">Home</a>
                    </li>
                    <li class="navbar-item">
                        <a href="/postspage" class="navbar-pub">Publicações</a>
                    </li>
                    <li class="navbar-item">
                        <?php if (isset($_SESSION['id'])): ?>
                            <a href="/dashboard" class="navbar-login">Dashboard</a>
                        <?php else: ?>
                            <a href="/login" class="navbar-login">Login</a>
                        <?php endif; ?>
                    </li>
                <!--X para fechar o menu do celular-->
                <li class="close-menu">
                    <span class="close-btn" id="close-menu">&times;</span>
                </li>
                </ul>
            </div>
        </nav>
</body>
</html>