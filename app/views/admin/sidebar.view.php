<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../../../public/css/sidebar.css">

</head>
<body>
    <nav class="sidebar closed">
        
        <div id="sidebar_content">
     <img src="../../../public/assets/img/Logo-rato-bandeira.jpg.png" id="imagem">
     
     <ul id="side_itens">
        <li class="item">
            <a href="/tabelaposts">
            <i class="fas fa-paper-plane"></i>
            <span class="item-description-sidebar">
                <h1 class="texto-sidebar">Posts </h1>
            </span>
            </a>
        </li\>

        <li class="item">
       <a href="/usuarios">
            <i class="fa-solid fa-users"></i>
            <span class="item-description-sidebar">
                <h1 class="texto-sidebar">Usuários </h1>
            </span>
        </a>
        </li>


        <li class="item">
       <a href="/dashboard">
            <i class="fa-solid fa-chart-line"></i>
            <span class="item-description-sidebar">
                <h1 class="texto-sidebar"> Dashboard</h1>
            </span>
        </a>
        </li>

        <li class="item">
       <a href="/home">
            <i class="fa-solid fa-house"></i>
            <span class="item-description-sidebar">
                <h1 class="texto-sidebar"> Home</h1>
            </span>
        </a>
        </li>

    </ul>

    <button id="open">
        <i id="open_icon" class="fa-solid fa-chevron-right"></i>
    </button>


</div>

<div id="logout">
    <form action="/logout" method="POST">
    <button id="logout_bt">
        <i id="logout_icon" class="fa-solid fa-right-from-bracket"></i>
        <span class="item-description-sidebar">
            <h1 class="texto-sidebar"> Logout </h1>
        </span>
    </button>
    </form>

    </div>
    
</nav>

<script src="../../../public/js/sidebar.js"></script>
</body>
</html>