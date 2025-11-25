<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela de Posts - Admin</title>
    <link rel="stylesheet" href="../../../public/css/PostPage.css">
    <link rel="stylesheet" href="../../../public/css/modalVisualizarPost.css">
    <link rel="stylesheet" href="../../../public/css/modalEditarPost.css">
    <link rel="stylesheet" href="../../../public/css/ModalExcluirPost.css">
    <link rel="stylesheet" href="../../../public/css/modalCriarPost.css">
    <link rel="stylesheet" href="../../../public/css/modalVerComentarios.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">   
</head>

<body>
    <section class="admin-painel">
        <header class="main-header">
            <h1>TABELA DE POSTS</h1>
        </header>
        <!-- Barra de Pesquisa, Nova Publicação-->
        <div class="toolbar">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-bar" placeholder="">
            </div>
            <div class="actions-container">
                <button class="new-post-btn" onclick="abrirModal('modalCriarPost')">
                    <i class="fas fa-plus-circle"></i> <span>Nova Publicação</span>
                </button>
            </div>
        </div>
        <main class="posts-content">
            <table class="tabela">
                 <tr class="posts-table-header">
                    <th class="header-col">Post ID</th>
                    <th class="header-col">Data</th>
                    <th class="header-col" id="header-titulo">Título</th> 
                    <th class="header-col" id="header-autor">Autor</th>
                    <th class="header-col" id="header-veiculo">Veículo</th>
                    <th class="header-col" id="header-ano">Ano do Veículo</th>
                    <th class="header-col" id="header-tipo">Tipo do post</th>
                    <th class="header-col" id="header-interacao">Interações</th>
                    <th class="header-col" id="header-açao">Ações</th>
                </tr>
                <?php foreach($posts as $post): ?>
                 <tr class="post-item">
                    <td class="post-data post-id" data-label="Post ID"><?= $post->id ?></td>
                    <td class="post-data post-date"><?= date('d/m/Y', strtotime($post->data)) ?></td>
                    <td class="post-data post-title" data-label="Título"><?= $post->titulo ?></td>
                    <td class="post-data post-date" data-label="Autor"><?= $post->autor ?></td>
                    <td class="post-data post-veiculo" data-label="Veículo"><?= $post->veiculo ?></td>
                    <td class="post-data post-date" data-label="Ano do Veículo"><?= $post->ano_veiculo ?></td>
                    <td class="post-data post-tipo" data-label="Tipo do post"><?= $post->categoria ?></td>
                    <td class="post-data post-stats" data-label="Views/Curtidas/Comentários">
                        <span class="stat">270 <i class="fas fa-eye"></i></span>
                        <span class="stat">100 <i class="fas fa-thumbs-up"></i></span>
                        <span class="stat">250 <i class="fas fa-comments"></i></span>
                    </td>
                    <td class="post-data post-actions" data-label="Ações">
                        <button class="action-btn comentarios"><i class="bi bi-chat-left-dots-fill" onclick="abrirModal('modalVerComentarios')"></i></button>
                        <button class="action-btn view"><i class="fas fa-eye" onclick="abrirModal('modalVisualizarPost')"></i></button>
                        <button class="action-btn edit"><i class="fas fa-pencil-alt" onclick="abrirModal('modalEditarPost')"></i></button>
                        <button class="action-btn delete"><i class="fas fa-trash" onclick="abrirModal('modalExcluirPost')"></i></button>
                    </td>
                </tr>
                <?php endforeach ?>
                
            </table>
        </main>


<?php foreach($posts as $post): ?>
  <ul class="user-cards">

    <li class="user-card">
        <h2 class="name"><?=$post->id?></h2>
        <p class="email"><?=$post->autor?></p>
        <p class="email"><?=$post->titulo?></p>
      <p class="meta"><?= $post->data ?></p>
      <span class="stat">270 <i class="fas fa-eye" ></i></span>
      <span class="stat">100 <i class="fas fa-thumbs-up"></i></span>
      <span class="stat">250 <i class="fas fa-comments"></i></span>
      <div class="card-actions">
          <button class="btn-card btn-view" type="button" onclick="abrirModal('modalVisualizarPost')">VISUALIZAR </button>
          <button class="btn-card btn-edit" type="button" onclick="abrirModal('modalEditarPost')">EDITAR POST</button>
          <button class="btn-card btn-delete" type="button" onclick="abrirModal('modalExcluirPost-<?= $post->id; ?>')">DELETAR POST</button>
          <button class="btn-card btn-comentarios" type="button" onclick="abrirModal('modalVerComentarios')">VER COMENTÁRIOS</button>
      </div>
    </li>
  </ul> 
  <?php endforeach ?>
   <button class="fab-btn" onclick="abrirModal('modalCriarPost')">
        <i class="fas fa-plus"></i> 
    </button>
    <nav class="pagination">
        <a href="#" class="arrow prev"><i class="fas fa-chevron-left"></i></a>
        <a href="#" class="page-number active">1</a>
        <a href="#" class="page-number">2</a>
        <a href="#" class="page-number">3</a>
        <a href="#" class="page-number">4</a>
        <a href="#" class="page-number">5</a>
        <a href="#" class="arrow next"><i class="fas fa-chevron-right"></i></a>
    </nav>
    </section>

    <?php foreach($posts as $post): ?>
     <!--Modal Visualizar Post-->
     <div class="modal-overlay hidden" id="modalVisualizarPost">
        <section class="container"> 
      <div class="ladoEsquerdo">
            <div id="imgPost">
                <img src="<?= $post->foto ?>" alt="">
            </div>
            <p id="idPost">ID: <?=$post->id;?></p>
            <h2 class="texto-infos">Veiculo</h2>
            <div class="info-veiculo">
            <p><?=$post->veiculo;?></p>
            </div>
            <h2 class="texto-infos">Ano</h2>
            <div class="info-ano">
                <p><?=$post->ano_veiculo;?></p>
      </div>
            <h2 class="texto-infos">Tipo de post</h2>
            <select name="post-tipo" id="tipo" disabled>
                <option value=""> <?=$post->categoria?></option>
            </select>
        </div>
        <div class="ladoDireito">
        <h2 class="textos-info-visualizar">Autor</h2>
        <div class="infos">
            <p><?=$post->autor;?></p>
        </div>
        <h2 class="textos-info-visualizar">Titulo</h2>
        <div class="infos">
            <p><?=$post->titulo;?></p>
        </div>
        <h2 class="textos-info-visualizar">Descrição</h2>
        <div class="infos" id="descricao-info">
            <p><?=$post->descricao;?></p>
        </div>
        <p id="dataPost">Data de criação: <?= date('d/m/Y', strtotime($post->data)) ?></p>
        
        <div class="buttons">
        <button id="btn-cancelar" onclick="fecharModal('modalVisualizarPost')">Cancelar</button>
        <button onclick="fecharModal('modalVisualizarPost')" id="btn-salvar">Sair</button>
        </div>
        </div>
        </section>
    </div>
    
    <!-- Modal Editar Post-->
    <form action="/editarPost" method="POST" enctype="multipart/form-data">
    <div class="modal-overlay hidden" id="modalEditarPost">
        <input type="hidden" name = "id" value="<?=$post->id;?>">
        <section class="container">
        <div class="ladoEsquerdo">
            <div id="imgPost">
                 <input type="file" name="foto" accept="imagem/*" id="img" >
                 <img src="<?= $post->foto ?>" alt="">
            </div>
            <p id="idPost">ID: <?=$post->id;?></p>
            <h2 class="texto-infos">Veiculo</h2>
            <input class="inputs" name = "veiculo" id="input-veiculo" type="text" value="<?=$post->veiculo;?>">
            <h2 class="texto-infos">Ano</h2>
            <input class="inputs" name = "ano_veiculo" id="input-ano" type="text" value="<?=$post->ano_veiculo;?>">
            <h2 class="texto-infos">Tipo de post</h2>
            <select name="post-tipo" id="tipo">
                <option value="passeio"<?php if($post->categoria == 'passeio') echo 'selected'; ?>>Passeio</option>
                <option value="trackday"<?php if($post->categoria == 'trackday') echo 'selected'; ?>>Track day</option>
                <option value="viagem"<?php if($post->categoria == 'viagem') echo 'selected'; ?>>Viagem</option>
                <option value="encontro"<?php if($post->categoria == 'encontro') echo 'selected'; ?>>Encontro</option> 
                <option value="momentos"<?php if($post->categoria == 'momentos') echo 'selected'; ?>>Momentos</option>
</select>
           
        </div>
        <div class="ladoDireito">
            <h2 class="texto-infos">Autor</h2>
            <div class="info-autor-caixa"><?=$post->autor;?></div>
            <h2 class="texto-infos">Titulo</h2>
            <input class="inputs" name = "titulo" type="text" value="<?=$post->titulo;?>">
            <h2 class="texto-infos">Descrição</h2>
            <textarea class="inputs" name = "descricao" id="inputDesc" type="text" autocomplete="off"><?=$post->descricao;?></textarea>
            <p id="dataPost">Data de criação: <?= date('d/m/Y', strtotime($post->data)) ?></p>
            <div class="buttons">
            <button id="btn-cancelar" onclick="fecharModal('modalEditarPost')" type="button">Cancelar</button>
            <button id="btn-salvar" type="submit">Publicar</button>
        </div>
        </div>
        </section>
    </div>
    </form>

    <!--Modal Excluir Post-->
        <form action="/excluirPost" method="POST">
        <div class="modal-overlay hidden" id="modalExcluirPost">
            <input type="hidden" name="id" value="<?= $post->id ?>">
        
        <section class="container">
            <div class="borda">
                <div class="caixa-texto">
                    <h1>Deseja excluir o Post?</h1>
                </div>
                <img src="../../public/assets/RATAO-STOP.PNG">
                <div class="botoes">
                    <h1>Você não poderá reverter essa alteração</h1>
                    <button class="sim" id="btn-sim" type="submit">Sim</button>
                    
                    <button class="nao" type="button" id="btn-nao" onclick="fecharModal('modalExcluirPost')">Cancelar</button>
                </div>
            </div>
        </section>
</div>
  </form>
    <?php endforeach ?>

    <!--Modal Criar Post-->    
    <div class="modal-overlay hidden" id="modalCriarPost">
    <form action="/tabelaposts/criar" method="POST" enctype="multipart/form-data">
        <section class="container"> 
        <div class="ladoEsquerdo">
            <div id="imgPost">              
               <input type="file" name="foto" accept="image/*" id="img-do-post" style="display: none" onchange="exibirPreview(this, 'previewCriar', 'imagemPadraoCriar', 'labelCriarPost')" required>
                <label for="img-do-post" id="labelCriarPost" class="upload-label">
                <span><i class="fas fa-pencil-alt"></i></span>
                <img src="public/assets/Audi-R8.jpg" id="imagemPadraoCriar" alt="">
                </label>
            
            
                <img src="#" alt="Preview" id="previewCriar" style="display: none;">
            </div>
            <h2 class="texto-infos">Veiculo</h2>
            <input class="campo-editavel" id="input-veiculo" name="veiculo" type="text" placeholder="Digite o veículo" required>
            <h2 class="texto-infos">Ano</h2>
            <input class="campo-editavel" id="input-ano" name="ano_veiculo" type="text" placeholder="Ano" required>
            <h2 class="texto-infos">Marca</h2>
            <input class="campo-editavel" id="input-marca" name="marca" type="text" placeholder="Marca do carro" required>
            <h2 class="texto-infos">Tipo de post</h2>
            <select name="post-tipo" id="tipo" value="categoria"required>
                <option value="">Selecione uma opção</option>
                <option value="passeio">Passeio</option>
                <option value="trackday">Track day</option>
                <option value="viagem">Viagem</option>
                <option value="encontro">Encontro</option> 
                <option value="momentos">Momentos</option>
</select>
           
        </div>
        <div class="ladoDireito">
        <h2 class="textos-info-criar">Autor</h2>
        <div class="info-caixa">Usuario</div>
        <h2 class="textos-info-criar">Titulo</h2>
        <input class="campo-editavel" type="text" name="titulo" placeholder="Digite o título" required>
        <h2 class="textos-info-criar">Descrição</h2>
        <textarea id="descricao-editavel" name="descricao" placeholder="Digite a descrição" required></textarea>
        <div class="buttons">
        <button id="btn-cancelar" onclick="fecharModal('modalCriarPost')">Cancelar</button>
        <button id="btn-salvar" type="submit">Publicar</button>
        </div>
        </div>
        </section>
    </div>
    </form>

    <?php foreach($posts as $post): ?>

    <!--Modal Ver Comentarios-->
    <form action="/tabelaposts/verComentarios" method="POST">
    <div class="modal-overlay hidden" id="modalVerComentarios">
        <div class="container">            
            <h2>Comentários</h2>
            <div class="comments-list">
                <div class="comment-item">
                    <div class="comment-content">
                        <img src="#" alt="Avatar" class="comment-avatar">
                        <div class="comment-text">
                            <span class="comment-username">Mickael #3333</span>
                            <p>Meu UNO é bem melhor que essa ferrari!!</p>
                            <div class="comment-feedback">
                                <span class="feedback-item like-data">
                                    <i class="fas fa-thumbs-up"></i>
                                    <span>12</span>
                                </span>
                                <span class="feedback-item dislike-data">
                                    <i class="fas fa-thumbs-down"></i>
                                    <span>2</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="comment-actions">
                        <button class="icon-btn edit-btn" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                        <button class="icon-btn delete-btn" title="Excluir"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                <div class="comment-item">
                    <div class="comment-content">
                        <img src="#" alt="Avatar" class="comment-avatar">
                        <div class="comment-text">
                            <span class="comment-username">Miguel #8922</span>
                            <p>Que ferrari linda meu Deus</p>
                            <div class="comment-feedback">
                                <span class="feedback-item like-data">
                                    <i class="fas fa-thumbs-up"></i>
                                    <span>42</span>
                                </span>
                                <span class="feedback-item dislike-data">
                                    <i class="fas fa-thumbs-down"></i>
                                    <span>0</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="comment-actions">
                        <button class="icon-btn edit-btn" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                        <button class="icon-btn delete-btn" title="Excluir"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                <div class="comment-item">
                    <div class="comment-content">
                        <img src="#" alt="Avatar" class="comment-avatar">
                        <div class="comment-text">
                            <span class="comment-username">Bruno #4002</span>
                            <p>Achei incrivel, so trocaria a cor, deixaria preta</p>
                            <div class="comment-feedback">
                                <span class="feedback-item like-data">
                                    <i class="fas fa-thumbs-up"></i>
                                    <span>8</span>
                                </span>
                                <span class="feedback-item dislike-data">
                                    <i class="fas fa-thumbs-down"></i>
                                    <span>1</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="comment-actions">
                        <button class="icon-btn edit-btn" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                        <button class="icon-btn delete-btn" title="Excluir"><i class="fas fa-trash"></i></button>
                    </div>
                </div>

                <div class="comment-item">
                    <div class="comment-content">
                        <img src="#" alt="Avatar" class="comment-avatar">
                        <div class="comment-text">
                            <span class="comment-username">Marcos #1111</span>
                            <p>Prefiro os modelos da Lamborghini</p>
                            <div class="comment-feedback">
                                <span class="feedback-item like-data">
                                    <i class="fas fa-thumbs-up"></i>
                                    <span>5</span>
                                </span>
                                <span class="feedback-item dislike-data">
                                    <i class="fas fa-thumbs-down"></i>
                                    <span>7</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="comment-actions">
                        <button class="icon-btn edit-btn" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                        <button class="icon-btn delete-btn" title="Excluir"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                
            </div>
            
            <div class="caixa-btn">
                <button class="btn-fechar" onclick="fecharModal('modalVerComentarios')">Fechar</button>
            </div>
            
        </div>
    </div>
    </form>
     <?php endforeach ?>


    <script src="/public/js/Modal.js"></script>
    <script src="../../../public/js/PostPage.js"></script>
</body>
</html>