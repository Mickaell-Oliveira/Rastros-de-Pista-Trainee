<?php
$host = "localhost";
$db = "rastros_de_pista_db";
$user = "root";
$pass = "";

$mysqli = new mysqli($host, $user, $pass, $db);

if($mysqli->connect_errno) {
    die("Falha na conexão do banco de dados");
}


$busca = $_GET['busca'] ?? "";
$filtroTipo = $_GET['tipo'] ?? "";
$filtroAno = $_GET['ano'] ?? "";
$filtroTags = $_GET['tags'] ?? ""; 


if (!empty($busca) || !empty($filtroTipo) || !empty($filtroAno) || !empty($filtroTags)) {
    
    $sql = "SELECT * FROM posts WHERE 1=1";
    $types = "";
    $params = [];

    // Busca Texto
    if (!empty($busca)) {
        $sql .= " AND (titulo LIKE ? OR autor LIKE ? OR veiculo LIKE ? OR descricao LIKE ?)";
        $search_term = "%" . $busca . "%";
        $types .= "ssss";
        array_push($params, $search_term, $search_term, $search_term, $search_term);
    }

    // Filtro Tipo
    if (!empty($filtroTipo)) {
        $sql .= " AND categoria = ?";
        $types .= "s";
        $params[] = $filtroTipo;
    }

    // Filtro Ano
    if (!empty($filtroAno)) {
        $sql .= " AND ano_veiculo = ?";
        $types .= "s";
        $params[] = $filtroAno;
    }

    // Filtro Tags
    if (!empty($filtroTags)) {
        $tagsArray = explode(',', $filtroTags);
        $tagClauses = [];
        foreach ($tagsArray as $tag) {
            $tagClauses[] = "(descricao LIKE ? OR titulo LIKE ?)";
            $types .= "ss";
            $params[] = "%" . trim($tag) . "%";
            $params[] = "%" . trim($tag) . "%";
        }
        if (!empty($tagClauses)) {
            $sql .= " AND (" . implode(" OR ", $tagClauses) . ")";
        }
    }

    $sql .= " ORDER BY data DESC";

    $stmt = $mysqli->prepare($sql);
    if ($stmt) {
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        $posts = [];    
        if ($result) {
            while ($row = $result->fetch_object()) {
                $posts[] = $row;
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela de Posts - Admin</title>
    <link rel="stylesheet" href="../../../public/css/PostPage.css">
    <link rel="stylesheet" href="../../../public/css/Filtro.css">
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

        <div class="toolbar">
            
            <form class="search-container" action="" method="GET">
                <i class="fas fa-search search-icon"></i>
                <input id="searchInput" type="text" class="search-bar" name="busca" value="<?= htmlspecialchars($busca); ?>">
                <input type="hidden" name="tipo" value="<?= htmlspecialchars($filtroTipo) ?>">
                <input type="hidden" name="ano" value="<?= htmlspecialchars($filtroAno) ?>">
                <input type="hidden" name="tags" value="<?= htmlspecialchars($filtroTags) ?>">
            </form>

            <div class="actions-container">
                <button class="filter-btn" type="button" onclick="abrirModal('modalFiltro')">
                    <i class="fas fa-filter"></i> <span>Filtro</span>
                </button>

                <button class="new-post-btn" type="button" onclick="abrirModal('modalCriarPost')">
                    <i class="fas fa-plus-circle"></i> <span>Nova Publicação</span>
                </button>
            </div>
        </div>

        <main class="posts-content">
            <table class="tabela">
                 <tr class="posts-table-header">
                    <th class="header-col">Post ID</th>
                    <th class="header-col">Data</th>
                    <th class="header-col">Título</th> 
                    <th class="header-col">Autor</th>
                    <th class="header-col">Veículo</th>
                    <th class="header-col">Ano do Veículo</th>
                    <th class="header-col">Tipo do post</th>
                    <th class="header-col">Interações</th>
                    <th class="header-col">Ações</th>
                </tr>

                <?php if(!empty($posts)): ?>
                    <?php foreach($posts as $post): ?>
                    <tr class="post-item" data-title="<?= htmlspecialchars($post->titulo) ?>">
                        <td class="post-data post-id" data-label="Post ID"><?= $post->id ?></td>
                        <td class="post-data post-date"><?= date('d/m/Y', strtotime($post->data)) ?></td>
                        <td class="post-data post-title" data-label="Título"><?= $post->titulo ?></td>
                        <td class="post-data post-date" data-label="Autor"><?= $post->autor ?></td>
                        <td class="post-data post-veiculo" data-label="Veículo"><?= $post->veiculo ?></td>
                        <td class="post-data post-date" data-label="Ano do Veículo"><?= $post->ano_veiculo ?></td>
                        <td class="post-data post-tipo" data-label="Tipo do post"><?= $post->categoria ?></td>
                        <td class="post-data post-stats">
                            <span class="stat">270 <i class="fas fa-eye"></i></span>
                            <span class="stat">100 <i class="fas fa-thumbs-up"></i></span>
                            <span class="stat">250 <i class="fas fa-comments"></i></span>
                        </td>
                        <td class="post-data post-actions">
                            <button class="action-btn comentarios"><i class="bi bi-chat-left-dots-fill" onclick="abrirModal('modalVerComentarios-<?= $post->id ?>')"></i></button>
                            <button class="action-btn view"><i class="fas fa-eye" onclick="abrirModal('modalVisualizarPost-<?= $post->id ?>')"></i></button>
                            <button class="action-btn edit"><i class="fas fa-pencil-alt" onclick="abrirModal('modalEditarPost-<?= $post->id ?>')"></i></button>
                            <button class="action-btn delete"><i class="fas fa-trash" onclick="abrirModal('modalExcluirPost-<?= $post->id ?>')"></i></button>
                        </td>
                    </tr> 
                    <?php endforeach ?>
                <?php else: ?>
                    <tr><td colspan="9" style="text-align: center; padding: 20px;">Nenhum post encontrado.</td></tr>
                <?php endif; ?>
                
            </table>
        </main>

        <?php if(!empty($posts)): ?>
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
                    <button class="btn-card btn-view" type="button" onclick="abrirModal('modalVisualizarPost-<?= $post->id ?>')">VISUALIZAR </button>
                    <button class="btn-card btn-edit" type="button" onclick="abrirModal('modalEditarPost-<?= $post->id ?>')">EDITAR POST</button>
                    <button class="btn-card btn-delete" type="button" onclick="abrirModal('modalExcluirPost-<?= $post->id; ?>')">DELETAR POST</button>
                    <button class="btn-card btn-comentarios" type="button" onclick="abrirModal('modalVerComentarios-<?= $post->id ?>')">VER COMENTÁRIOS</button>
                </div>
            </li>
          </ul> 
        <?php endforeach ?>
        <?php endif; ?>

        <button class="fab-btn" onclick="abrirModal('modalCriarPost')">
            <i class="fas fa-plus"></i> 
        </button>

        <?php require(__DIR__  . '/../admin/componentes/paginacao.php') ?>
  
    </section>

    <?php foreach($posts as $post): ?>
        <div class="modal-overlay" id="modalVisualizarPost-<?= $post->id ?>" style="display: none;">
            <section class="container"> 
            <div class="ladoEsquerdo">
                <div id="imgPost">
                    <img src="<?= $post->foto ?>" alt="">
                </div>
                <p id="idPost">ID: <?=$post->id;?></p>
                <h2 class="texto-infos">Veiculo</h2>
                <div class="info-veiculo"><p><?=$post->veiculo;?></p></div>
                <h2 class="texto-infos">Ano</h2>
                <div class="info-ano"><p><?=$post->ano_veiculo;?></p></div>
                <h2 class="texto-infos">Tipo de post</h2>
                <select name="post-tipo" id="tipo" disabled>
                    <option value=""> <?=$post->categoria?></option>
                </select>
            </div>
            <div class="ladoDireito">
                <h2 class="textos-info-visualizar">Autor</h2>
                <div class="infos"><p><?=$post->autor;?></p></div>
                <h2 class="textos-info-visualizar">Titulo</h2>
                <div class="infos"><p><?=$post->titulo;?></p></div>
                <h2 class="textos-info-visualizar">Descrição</h2>
                <div class="infos" id="descricao-info"><p><?=$post->descricao;?></p></div>
                <p id="dataPost">Data de criação: <?= date('d/m/Y', strtotime($post->data)) ?></p>
                <div class="buttons">
                    <button id="btn-cancelar" onclick="fecharModal('modalVisualizarPost-<?= $post->id ?>')">Cancelar</button>
                    <button onclick="fecharModal('modalVisualizarPost-<?= $post->id ?>')" id="btn-salvar">Sair</button>
                </div>
            </div>
            </section>
        </div>
    
        <form action="/editarPost" method="POST" enctype="multipart/form-data">
        <div class="modal-overlay" id="modalEditarPost-<?= $post->id ?>" style="display: none;">
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
                    <button id="btn-cancelar" onclick="fecharModal('modalEditarPost-<?= $post->id ?>')" type="button">Cancelar</button>
                    <button id="btn-salvar" type="submit">Publicar</button>
                </div>
            </div>
            </section>
        </div>
        </form>

        <form action="/excluirPost" method="POST">
            <div class="modal-overlay" id="modalExcluirPost-<?= $post->id ?>" style="display: none;">
                <input type="hidden" name="id" value="<?= $post->id ?>">
                <section class="container">
                    <div class="borda">
                        <div class="caixa-texto"><h1>Deseja excluir o Post?</h1></div>
                        <img src="../../public/assets/RATAO-STOP.PNG">
                        <div class="botoes">
                            <h1>Você não poderá reverter essa alteração</h1>
                            <button class="sim" id="btn-sim" type="submit">Sim</button>
                            <button class="nao" type="button" id="btn-nao" onclick="fecharModal('modalExcluirPost-<?= $post->id ?>')">Cancelar</button>
                        </div>
                    </div>
                </section>
            </div>
        </form>

        <form action="/tabelaposts/verComentarios" method="POST">
        <div class="modal-overlay" id="modalVerComentarios-<?= $post->id ?>" style="display: none;">
            <div class="container">            
                <h2>Comentários</h2>
                <div class="comments-list">
                    <div class="comment-item">
                        <div class="comment-content">
                            <img src="#" alt="Avatar" class="comment-avatar">
                            <div class="comment-text">
                                <span class="comment-username">Mickael #3333</span>
                                <p>Exemplo de comentário...</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="caixa-btn">
                    <button class="btn-fechar" type="button" onclick="fecharModal('modalVerComentarios-<?= $post->id ?>')">Fechar</button>
                </div>
            </div>
        </div>
        </form>
    <?php endforeach ?>

    <div class="modal-overlay" id="modalCriarPost" style="display: none;">
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
            <select name="post-tipo" id="tipo" required>
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
                <button id="btn-cancelar" type="button" onclick="fecharModal('modalCriarPost')">Cancelar</button>
                <button id="btn-salvar" type="submit">Publicar</button>
            </div>
        </div>
        </section>
    </form>
    </div>


    <div class="modal-overlay" id="modalFiltro" style="display: none;">
    <section class="container-filtro">
        <div class="formulario-filtro">
            
            <div class="coluna-esquerda">
                <div class="grupo-campo">
                    <label class="rotulo">Tipo</label>
                    <select id="filtro-tipo" class="input-estilo">
                        <option value="" <?= empty($filtroTipo) ? 'selected' : '' ?>>Selecione uma Opção</option>
                        <option value="passeio" <?= $filtroTipo == 'passeio' ? 'selected' : '' ?>>Passeio</option>
                        <option value="trackday" <?= $filtroTipo == 'trackday' ? 'selected' : '' ?>>Track day</option>
                        <option value="viagem" <?= $filtroTipo == 'viagem' ? 'selected' : '' ?>>Viagem</option>
                        <option value="encontro" <?= $filtroTipo == 'encontro' ? 'selected' : '' ?>>Encontro</option> 
                        <option value="momentos" <?= $filtroTipo == 'momentos' ? 'selected' : '' ?>>Momentos</option>
                    </select>
                </div>

                <div class="grupo-campo">
                    <label class="rotulo">Ano do Veículo</label>
                    <input 
                        class="input-estilo" 
                        id="filtro-ano" 
                        type="text" 
                        maxlength="4" 
                        placeholder="Ex: 2024" 
                        value="<?= htmlspecialchars($filtroAno) ?>"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    >
                </div>
            </div>

            <div class="coluna-direita">
                <div class="area-filtros-tags">
                    <label class="rotulo">Tags Rápidas</label>
                    <div class="container-tags" id="lista-tags">
                        </div>
                    <input type="hidden" id="filtro-tags-hidden" value="<?= htmlspecialchars($filtroTags) ?>">
                </div>

                <div class="SearchFiltro">
                    <div class="input-busca-container">

                        <input type="text" id="input-tag-busca" placeholder="Buscar / Adicionar Tag:" class="input-busca" onkeypress="criarTagAoDigitar(event)">
                    </div>

                    <div class="grupo-botoes">
                        <button type="button" class="btn btn-limpar-filtro" onclick="fecharModal('modalFiltro')">Cancelar</button>
                        <button type="button" class="btn btn-aplicar-filtro" onclick="aplicarFiltros()">Buscar</button>
                    </div>
                </div>
            </div>

        </div>
    </section>
    </div>

    <script src="/public/js/Modal.js"></script>
    <script src="/public/js/BarraPesquisa.js"></script>
    <script src="../../../public/js/PostPage.js"></script>
    <script src="../../../public/js/Filtro.js"></script>


</body>
</html>