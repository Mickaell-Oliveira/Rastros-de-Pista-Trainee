<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../../public/css/Pagina_Individual.css">
    <title><?= $post->titulo ?></title> 
</head>

<body>

    <?php require 'app/views/site/navbar.view.php'; ?>

    <main class="ContainerPostagem">

        <div class="Cabecalho">
            <a href="/postspage"><button class="BotaoVoltar"><i class="fa-solid fa-arrow-left"></i></button></a>
            <div class="IconeContainer">
                <img src="/public/assets/imagemUsuario/<?= !empty($user->foto) ? $user->foto : 'default.png' ?>" alt="">
            </div>
            <div class="InfoUsuario">
                <h2 class="NomeUsuario"><?= $post->autor ?></h2>
                <p class="DataPostagem"><?= date('d/m/Y', strtotime($post->data)) ?></p>
            </div>
        </div>

        <div class="Postagem">
            <h1 class="TituloPostagem"><?= $post->titulo ?></h1>
            <img src="/<?= $post->foto ?>" alt="Imagem da Postagem" class="ImagemPostagem">
            <p class="ConteudoPostagem">
                <?= $post->descricao; ?>
            </p>
        </div>

    <div class="ContainerBotoes">
        <div class="Interacoes">
            <button id="btn-like" onclick="votar(<?= $post->id ?>, 'like')">
                <i class="fa-regular fa-thumbs-up" id="icon-like"></i> 
                <span id="contador-like"><?= $post->likes ?? 0 ?></span>
            </button>

            <button id="btn-dislike" onclick="votar(<?= $post->id ?>, 'dislike')">
                <i class="fa-regular fa-thumbs-down" id="icon-dislike"></i> 
                <span id="contador-dislike"><?= $post->dislikes ?? 0 ?></span>
            </button>

            <button onclick="toggleComentario()"><i class="fa-regular fa-comment"></i></button>
            <button><i class="fa-solid fa-share"></i></button>
        </div>
    </div>

    </main>

    <section class="SecaoComentarios">
        <h2 class="TituloSecao">Comentários</h2>

        <div id="area-comentario" class="AreaComentar hidden">
            <form action="/postindividual/criarcomentar" method="POST">
                <input type="hidden" name="id_post" value="<?= $post->id ?>">
                
                <textarea id="texto-comentario" class="input-comentario" name="comentario" placeholder="Digite seu comentário aqui..." required></textarea>
                
                <div class="BotoesComentario">
                    <button type="button" class="btn-cancelar" onclick="toggleComentario()">Cancelar</button>
                    <button type="submit" class="btn-enviar">Enviar</button>
                </div>
            </form>
        </div>

        <?php foreach($comentarios as $comentario): ?>
            <div class="Comentario">
                <div class="CabecalhoComentario">
                    <div class="IconeContainer">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div class="InfoUsuarioComentario">
                        <span class="NomeUsuarioComentario">Usuário</span>
                        <span class="DataComentario"><?= date('d/m/Y', strtotime($comentario->data)) ?></span>
                    </div>
                </div>
                <p class="TextoComentario">
                    <?= $comentario->comentario ?>
                </p>
                <div class="InteracoesComentario">
                    <button><i class="fa-regular fa-thumbs-up"></i></button>
                    <button><i class="fa-regular fa-thumbs-down"></i></button>
                </div>
            </div>
        <?php endforeach ?>

    </section>

    <?php require 'app/views/site/footer.view.php'; ?>

    <script src="/public/js/Pagina_Individual.js" defer></script>
</body>
</html>