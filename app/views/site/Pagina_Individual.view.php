<!DOCTYPE html>
<html lang="pt-br">


<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../../public/css/Pagina_Individual.css">
    <link rel="stylesheet" href="../../../public/css/modalComentar.css">
    <title>Post Individual</title>

</head>




<body>
    <?php foreach($posts as $post): ?>
    <main class="ContainerPostagem">


        <div class="Cabecalho">
            <button class="BotaoVoltar"><i class="fa-solid fa-arrow-left"></i></button>
            <div class="IconeContainer">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="InfoUsuario">
                <h2 class="NomeUsuario"><?= $post -> autor?></h2>
                <p class="DataPostagem"><?= date('d/m/Y', strtotime($post->data)) ?></p>
            </div>
        </div>


        <div class="Postagem">
            <h1 class="TituloPostagem"><?=$post-> titulo?></h1>
            <img src="/<?= $post->foto ?>" alt="Imagem da Postagem" class="ImagemPostagem">
            <p class="ConteudoPostagem">
                <?=$post->descricao;?>
            </p>
        </div>



        <div class="ContainerBotoes">
            <div class="Interacoes">
                <button><i class="fa-regular fa-thumbs-up"></i></button>
                <button><i class="fa-regular fa-thumbs-down"></i></button>
                <button onclick="abrirModal('modal-comentar')"><i class="fa-regular fa-comment"></i></button>
                <button><i class="fa-solid fa-share"></i></button>
            </div>
        </div>


    </main>

    <?php endforeach ?>
    <!-- COMENTÁRIOS -->


<section class="SecaoComentarios">
    <h2 class="TituloSecao">Comentários</h2>

    <?php foreach($comentarios as $comentario): ?>
    <?php foreach($posts as $post): ?>
    <div class="Comentario">
        <div class="CabecalhoComentario">
            <div class="IconeContainer">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="InfoUsuarioComentario">
                <span class="NomeUsuarioComentario"><?= $post -> autor?></span>
                <span class="DataComentario"><?= date('d/m/Y', strtotime($comentario -> data)) ?></span>
            </div>
        </div>
        <p class="TextoComentario">
            <?= $comentario -> comentario ?>
        </p>
        <div class="InteracoesComentario">
            <button><i class="fa-regular fa-thumbs-up"></i></button>
            <button><i class="fa-regular fa-thumbs-down"></i></button>
        </div>
    </div>

    </div>

</section>
<?php endforeach ?>
<?php endforeach ?>


    <!-- COMENTAR -->
    <form action="/postindividual/criarcomentar" method="POST">
    <div class="modal-overlay hidden" id="modal-comentar">
        <section class="container">
            <div class="ladoEsquerdo">
                <div id="imgPost">
                    <img src="/<?= $post->foto ?>" alt="Foto do usuário">
                </div>
            </div>

            <div class="ladoDireito">
                <h2>Comente</h2>
                <input type="hidden" name="id_post" value="<?= $post->id ?>">

                <div class="caixas-input">
                    <textarea required class="inputs" type="text" name="comentario" placeholder="Digite seu comentário aqui..."></textarea>
                </div>

                <div class="buttons">
                    <button onclick="fecharModal('modal-comentar')" id="btn-cancelar">Cancelar</button>
                    <button id="btn-salvar" type="submit">Enviar</button>
                </div>
            </div>
        </section>
    </div>
    </form>
 <script src="../../../public/js/Modal.js"></script>




</body>

</html>