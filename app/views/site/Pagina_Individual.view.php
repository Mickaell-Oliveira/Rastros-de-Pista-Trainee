<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../../public/css/Pagina_Individual.css">
    <link rel="shortcut icon" href="/public/assets/img/favicon.png" type="image/x-icon">
    <title><?= $post->titulo ?></title> 
</head>

<body>

    <?php require 'app/views/site/navbar.view.php'; ?>

    <main class="ContainerPostagem">

        <div class="Cabecalho">
            <a href="/postspage"><button class="BotaoVoltar"><i class="fa-solid fa-arrow-left"></i></button></a>
            <div class="IconeContainer">
                <img src="<?= (strpos($post->foto_autor, 'public') !== false) ? '/' . $post->foto_autor : '/public/assets/imagemUsuario/' . ($post->foto_autor ?? 'default.png') ?>" alt="">
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
                <i class="<?= ($votoUsuario == 1) ? 'fa-solid' : 'fa-regular' ?> fa-thumbs-up" 
                   id="icon-like" 
                   style="<?= ($votoUsuario == 1) ? 'color: #FFFFFF;' : '' ?>"></i> 
                <span id="contador-like"><?= $post->likes_count ?? 0 ?></span>
            </button>

            <button id="btn-dislike" onclick="votar(<?= $post->id ?>, 'dislike')">
                <i class="<?= ($votoUsuario == 2) ? 'fa-solid' : 'fa-regular' ?> fa-thumbs-down" 
                   id="icon-dislike"
                   style="<?= ($votoUsuario == 2) ? 'color: #FFFFFF;' : '' ?>"></i> 
                <span id="contador-dislike"><?= $post->dislikes_count ?? 0 ?></span>
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
                        <img src="<?= (strpos($comentario->foto_usuario, 'public') !== false) ? '/' . $comentario->foto_usuario : '/public/assets/imagemUsuario/' . ($comentario->foto_usuario ?? 'default.png') ?>" alt="" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                    </div>
                    <div class="InfoUsuarioComentario">
                        <span class="NomeUsuarioComentario"><?= $comentario->nome_usuario ?> #<?= $comentario->id_usuario ?></span>
                        <span class="DataComentario"><?= date('d/m/Y', strtotime($comentario->data)) ?></span>
                    </div>
                </div>
                <p class="TextoComentario">
                    <?= $comentario->comentario ?>
                </p>
                
                <div class="InteracoesComentario">
                    <button onclick="votarComentario(<?= $comentario->id ?>, 'like')">
                        <i class="<?= ($comentario->meu_voto == 1) ? 'fa-solid' : 'fa-regular' ?> fa-thumbs-up"
                           id="icon-like-comentario-<?= $comentario->id ?>"
                           style="<?= ($comentario->meu_voto == 1) ? 'color: #FFFFFF;' : '' ?>"></i>
                        <span id="contador-like-comentario-<?= $comentario->id ?>"><?= $comentario->likes_count ?? 0 ?></span>
                    </button>

                    <button onclick="votarComentario(<?= $comentario->id ?>, 'dislike')">
                        <i class="<?= ($comentario->meu_voto == 2) ? 'fa-solid' : 'fa-regular' ?> fa-thumbs-down"
                           id="icon-dislike-comentario-<?= $comentario->id ?>"
                           style="<?= ($comentario->meu_voto == 2) ? 'color: #FFFFFF;' : '' ?>"></i>
                        <span id="contador-dislike-comentario-<?= $comentario->id ?>"><?= $comentario->dislikes_count ?? 0 ?></span>
                    </button>
                </div>
            </div>
        <?php endforeach ?>

    </section>

    <?php require 'app/views/site/footer.view.php'; ?>

    <script src="/public/js/Pagina_Individual.js" defer></script>
</body>
</html>