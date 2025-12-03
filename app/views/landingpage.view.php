<!DOCTYPE html>


<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Rastros de Pista</title> 
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
    
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  
        <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

            <link rel="stylesheet" href="../../../public/css/landingpage.css">

    </head>

    <body>
   <?php require 'app/views/site/navbar.view.php'; ?>
   <div class="container-imagem">
        <div class="texto-centralizado " >
            <h1>Cada Carro Conta uma História. Qual é a Sua?</h1>
            <p>No Rastros de Pista, não importam os cavalos do motor, mas a paixão de quem dirige. Criamos este espaço para unir gerações de entusiastas — do fã de clássicos ao admirador de modernos — em uma comunidade que valoriza cada história. Junte-se a nós para ir além da ficha técnica: aqui celebramos a liberdade sobre quatro rodas, trocamos experiências e descobrimos juntos que a verdadeira magia da estrada está na conexão entre o motorista, a máquina e o mundo ao redor.</p>
        </div>
    
    </div>

<div class="degrade">     
 <div class="fundo-do-carrossel">
            
     <div class="carousel-container">
        <div class="carousel-track">
                    
                    <?php if(!empty($posts)): ?>
                        <?php foreach($posts as $post): ?>
                            <div class="card">
                                <div class="conteudo-carrossel" 
                                     style="background-image: url('/<?= !empty($post->foto) ? $post->foto : 'public/assets/fotoPost.jpg' ?>');">
                                </div>
                                
                                <div class="info-container">
                                    <h3><?= htmlspecialchars($post->titulo) ?></h3>
                                    
                                    <p>
                                        <?= htmlspecialchars(substr($post->descricao, 0, 150)) . (strlen($post->descricao) > 150 ? '...' : '') ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="card">
                             <div class="conteudo-carrossel"> </div>
                             <div class="info-container">
                                <h3>Sem posts</h3>
                                <p>Nenhuma publicação encontrada no momento.</p>
                             </div>
                        </div>
                    <?php endif; ?>
                    </div>

        <button id="prevBtn" class="carousel-btn prev">&#10094;</button>
        <button id="nextBtn" class="carousel-btn next">&#10095;</button>
    </div>

            </div>
        
          <div class="ver-mais">
            <a href="/postspage">
            <h1><u> Ver Mais </u></h1>
            </a>
          </div>

        <div class="container-sobre-nos">
          <div class="sobre-nos">
            <h1>Sobre Nós</h1>
            <p>Em "Rastros de Pista", acreditamos que carros são guardiões de histórias. Este é um espaço para celebrar a paixão por trás do volante, compartilhando as memórias e as lições que cada jornada nos oferece. Junte-se à nossa comunidade e mostre que a verdadeira aventura acontece a cada quilômetro rodado.
</p>  

          </div>

     <div class="última-imagem">
        <img src="../../../public/assets/img/carro-sobre-nos.jpg.jpg" alt="Foto de carro">

    </div>
</div>

    </div>
    <script src="../../../public/js/landingpage.js"></script>

    <?php require 'app/views/site/footer.view.php'; ?>
    </body>


</html>

