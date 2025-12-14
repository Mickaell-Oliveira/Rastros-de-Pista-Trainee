<?php 

$host = "localhost";
$db = "rastros_de_pista_db";
$dbUser = "root";
$pass = "";

$mysqli = new mysqli($host, $dbUser, $pass, $db);

if($mysqli->connect_errno) {
    die("Falha na conexão do banco de dados");
}

$busca = $_GET['busca'] ?? "";

if (!empty($busca)) {
    $sql = "SELECT * FROM usuarios WHERE 1=1"; 
    $types = "";
    $params = [];

    $sql .= " AND (nome LIKE ? OR email LIKE ?)";
    $search_term = "%" . $busca . "%";
    $types .= "ss"; 
    
    array_push($params, $search_term, $search_term);
    
    $sql .= " ORDER BY id DESC"; 
    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        $usuarios = [];    

        if ($result) {
            while ($row = $result->fetch_object()) {
                $usuarios[] = $row;
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
    <title>Tabela de Usuários - Admin</title>
    <link rel="stylesheet" href="/public/css/UserList.css">
    <link rel="stylesheet" href="/public/css/modalVisualizarUsuario.css">
    <link rel="stylesheet" href="/public/css/modalEditarUsuario.css">
    <link rel="stylesheet" href="/public/css/ModalExcluirUsuario.css">
    <link rel="stylesheet" href="/public/css/modalCriarUsuario.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>
    <?php require 'app/views/admin/sidebar.view.php'; ?>
    <main>
        <section class="admin-panel">
            <header class="main-header">
                <h1>Tabela de Usuários</h1>
            </header>

            <div class="toolbar">
                <form class="search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input id="searchInput" type="text" class="search-bar" name="busca" value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>">
                </form>

                <div class="actions-container" onclick="abrirModal('modal-criar')">
                    <button class="new-post-btn">
                        <i class="fas fa-plus-circle"></i> <span>Novo Usuário</span>
                    </button>
                </div>
            </div>

            <main class="posts-content">
                <table class="tabela">
                    <tr class="posts-table-header">
                        <th class="header-col">User ID</th>
                        <th class="header-col">Data de Cadastro</th>
                        <th class="header-col" id="header-titulo">Nome</th>
                        <th class="header-col" id="header-autor">Email</th>
                        <th class="header-col">Ações</th>
                    </tr>

                    <?php if(!empty($usuarios)): ?>
                    <?php foreach($usuarios as $userItem): ?>
                    
                    <?php 
                        $podeGerenciar = false;
                        if(isset($user) && is_object($user)) {
                            if($user->admin == 1 || $user->id == $userItem->id) {
                                $podeGerenciar = true;
                            }
                        }
                    ?>

                    <tr class="post-item">
                        <td class="post-data post-id" data-label="Post ID"><?= $userItem->id ?></td>
                        <td class="post-data post-date" data-label="Data"><?= date('d/m/Y', strtotime($userItem->data)) ?></td>
                        <td class="post-data post-title" data-label="Título"><?= $userItem->nome ?></td>
                        <td class="post-data post-date" data-label="Autor"><?= $userItem->email ?></td>
                        <td class="post-data post-actions" data-label="Ações">
                            <button id="botaoViewUsuario" class="action-btn view" onclick="abrirModal('modal-visualizar-<?= $userItem->id ?>')"><i class="fas fa-eye"></i></button>
                            
                            <?php if($podeGerenciar): ?>
                                <button id="botaoEditarUsuario" class="action-btn edit" onclick="abrirModal('modal-editar-<?= $userItem->id ?>')"><i class="fas fa-pencil-alt"></i></button>
                                <button id="botaoExcluirUsuario" class="action-btn delete" onclick="abrirModal('modal-excluir-<?= $userItem->id ?>')"><i class="fas fa-trash"></i></button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    
                <?php else: ?> 
                    <tr><td colspan="9" style="text-align: center; padding: 20px;">Nenhum usuário encontrado.</td></tr>
                <?php endif; ?>


                </table>
            </main>

            <?php if(!empty($usuarios)): ?>
            <?php foreach($usuarios as $userItem): ?>
                <?php 
                    $podeGerenciar = false;
                    if(isset($user) && is_object($user)) {
                        if($user->admin == 1 || $user->id == $userItem->id) {
                            $podeGerenciar = true;
                        }
                    }
                ?>
                <ul class="user-cards">
                      <li class="user-card">
                        <h2 class="name"><?= $userItem->nome ?></h2>
                        <p class="email"><?= $userItem->email ?></p>
                        <p class="meta">Data de cadastro: <?= date('d/m/Y', strtotime($userItem->data)) ?></p>
                        <p class="meta">USER ID: <?= $userItem->id ?></p>
                        <div class="card-actions">
                            <button class="btn-card btn-view" type="button" onclick="abrirModal('modal-visualizar-<?= $userItem->id ?>')">VISUALIZAR USUÁRIO</button>
                            <?php if($podeGerenciar): ?>
                                <button class="btn-card btn-edit" type="button" onclick="abrirModal('modal-editar-<?= $userItem->id ?>')">EDITAR USUÁRIO</button>
                                <button class="btn-card btn-delete" type="button" onclick="abrirModal('modal-excluir-<?= $userItem->id ?>')">DELETAR USUÁRIO</button>
                            <?php endif; ?>
                        </div>
                    </li> 
                </ul>
            <?php endforeach; ?>
            <?php endif; ?>

            <!--Modal Criar Usuario-->
                
            <a href="#" class="fab-btn" onclick="abrirModal('modal-criar')"><i class="fas fa-plus"></i></a>

            <nav class="pagination" style="display: flex; justify-content: center;">
                <ul class="pagination">
                    <li class="page-item <?= $page <= 1 ? "disabled" : "" ?>">
                        <a href="?paginacaoNumero=<?= $page - 1 ?>" class="arrow prev"><i class="fas fa-chevron-left"></i></a>
                    </li>

                    <?php 
                        $max_links = 2; 
                        $start = max(1, $page - $max_links);
                        $end = min($total_pages, $page + $max_links);
                    ?>

                    <?php for($pagenumber = $start; $pagenumber <= $end; $pagenumber++): ?>
                        <li class="page-item"> 
                            <a class="page-number <?= $pagenumber == $page ? "active" : "" ?>" href="?paginacaoNumero=<?=$pagenumber ?>">
                                <?= $pagenumber ?>
                            </a> 
                        </li>
                    <?php endfor ?>

                    <li class="page-item <?= $page >= $total_pages ? "disabled" : "" ?>">
                        <a href="?paginacaoNumero=<?= $page + 1 ?>" class="arrow next"><i class="fas fa-chevron-right"></i></a>
                    </li>
                </ul>
            </nav>

        </section>

        <!-- Modal Visualizar Usuário -->

        <?php if(!empty($usuarios)): ?>
        <?php foreach($usuarios as $userItem): ?>
            <div class="modal-overlay hidden" id="modal-visualizar-<?= $userItem->id ?>">
                <section class="container">
                    <div class="ladoEsquerdo">
                        <h2 class="nomeFotoPerfil" >Foto de Perfil</h2>
                        <div id="imgPost">
                            <?php 
                                $foto = $userItem->foto ?? 'default.png';
                                $foto = str_replace('\\', '/', $foto);
                                if (strpos($foto, 'public/') === false) {
                                    $foto = 'public/assets/imagemUsuario/' . $foto;
                                }
                                $foto = '/' . ltrim($foto, '/');
                            ?>
                            <img src="<?= $foto ?>" alt="Foto do Usuário">
                            <div class="DataUser"><p>Data de Criação: <?= date('d/m/Y', strtotime($userItem->data)) ?></p></div>
                        </div>
                    </div>
        
                    <div class="ladoDireito">
                        <div class="caixas-input">
                            <h2>Nome</h2> <p class="inputs" type="text" disabled><?= $userItem->nome ?></p>
                            <h2>Email</h2> <p class="inputs" type="text" disabled><?= $userItem->email ?></p>
                        </div>

                        <div class="buttons">
                            <button onclick="fecharModal('modal-visualizar-<?= $userItem->id ?>')" class="btn-cancelar">Fechar</button>
                        </div>
                    </div>
                </section>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>

        <!-- Modal Editar Usuário -->                        

        <?php if(!empty($usuarios)): ?>
        <?php foreach($usuarios as $userItem): ?>
            <div class="modal-overlay hidden modal-editar-custom" id="modal-editar-<?= $userItem->id ?>">
                
                <section class="container">
                    <form action="/user/edit" method="POST" enctype="multipart/form-data" style="width: 100%; display: flex; justify-content: center;">
                        <input type="hidden" name="id" value="<?= $userItem->id ?>">
                          <div class="ladoEsquerdo">
                            <h2 class="nomeFotoPerfil">Foto de Perfil</h2>
                            <div id="imgUser">              
                                <input type="file" name="foto" accept="image/*" id="img-do-user-<?= $userItem->id ?>" style="display: none" onchange="exibirPreview(this, 'previewEditar-<?= $userItem->id ?>', 'imagemPadraoEditar-<?= $userItem->id ?>', 'labelEditarUser-<?= $userItem->id ?>')">
                                
                                <label for="img-do-user-<?= $userItem->id ?>" id="labelCriarUser">
                                    <span><i class="fas fa-pencil-alt"></i><br></span>
                                </label>
                                
                                <?php 
                                    $fotoEdit = $userItem->foto ?? 'default.png';
                                    $fotoEdit = str_replace('\\', '/', $fotoEdit);
                                    if (strpos($fotoEdit, 'public/') === false) {
                                        $fotoEdit = 'public/assets/imagemUsuario/' . $fotoEdit;
                                    }
                                    $fotoEdit = '/' . ltrim($fotoEdit, '/');
                                ?>

                                <img src="<?= $fotoEdit ?>" id="imagemPadraoEditar-<?= $userItem->id ?>" alt="">
                                <img src="#" alt="Preview" id="previewEditar-<?= $userItem->id ?>" style="display: none; position: absolute; top:0; left:0; width:100%; height:100%; object-fit:cover; z-index:2;">
                            </div>
                        </div>
                        <div class="ladoDireito">
                            <h2>Nome</h2>
                            <input class="inputs" name="name" type="text" value="<?= $userItem->nome ?>">
                            
                            <h2>Email</h2>
                            <input class="inputs" name="email" type="email" placeholder="Novo email" value="<?= $userItem->email ?>">
                            
                            <h2>Senha</h2>
                            <div class="input-senha">
                                <input class="inputs" name="senha" type="password" autocomplete="off" placeholder="Nova Senha (Opcional)">
                                <i class="fas fa-eye-slash toggle-password" onclick="toggleSenha(this)"></i>
                            </div>
                            
                            <h2>Confirme sua Senha</h2> 
                            <div class="input-senha">
                                <input class="inputs" type="password" name ="senhaConfirmar" autocomplete="off" placeholder="Confirme a Senha">
                                <i class="fas fa-eye-slash toggle-password" onclick="toggleSenha(this)"></i> 
                            </div>
                        
                            <div class="buttons">   
                                <button type="button" class="btn-cancelar" onclick="fecharModal('modal-editar-<?= $userItem->id ?>')">Cancelar</button>
                                <button type="submit" class="btn-salvar">Salvar</button>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>

        <!-- Modal Excluir Usuário -->

        <?php if(!empty($usuarios)): ?>
        <?php foreach($usuarios as $userItem): ?>
            <form action="/user/delete" method="POST">
                <div class="modal-overlay modal-excluir hidden" id="modal-excluir-<?= $userItem->id ?>">
                    <input type="hidden" name="id" value="<?= $userItem->id ?>">
                    <section class="container">
                        <div class="borda">
                            <div class="caixa-texto"> <h1>Deseja excluir usuário?</h1></div>
                            <img src="/public/assets/RATAO-STOP.PNG" class="rato-gordo" alt="" style="max-width: 150px; margin: 20px auto; display: block;">
                            <div class="botoes">
                                <h1>Você não poderá reverter essa alteração</h1>
                                <button type="submit" class="sim">Sim</button>
                                <button class="nao" type="button" onclick="fecharModal('modal-excluir-<?= $userItem->id ?>')">Não</button>
                            </div>
                        </div>
                    </section>
                </div>
            </form>
        <?php endforeach; ?>
        <?php endif; ?>

        <!-- Modal Criar Usuário -->

        <div class="modal-overlay hidden" id="modal-criar">
            <form action="/user/create" method="POST" enctype="multipart/form-data" style="width: 100%; display: flex; justify-content: center;">
                <section class="container">
                    <div class="ladoEsquerdo">
                        <h2 class="nomeFotoPerfil">Foto de Perfil</h2>
                        <div id="imgUser">              
                            <input type="file" name="foto" accept="image/*" id="img-criar-user" style="display: none" onchange="exibirPreview(this, 'previewCriarNovo', 'imagemPadraoCriarNovo', 'labelCriarNovo')" required>
                            
                            <label for="img-criar-user" id="labelCriarUser">
                                <span><i class="fas fa-pencil-alt"></i></span>
                            </label>
                            
                            <img src="/public/assets/imagemUsuario/DefaultIcon.png" id="imagemPadraoCriarNovo" alt="">
                            <img src="#" alt="Preview" id="previewCriarNovo" style="display: none; position: absolute; top:0; left:0; width:100%; height:100%; object-fit:cover; z-index:2;">
                        </div>
                    </div>

                    <div class="ladoDireito">
                        <h2>Nome</h2> 
                        <input required class="inputs" name ="name" type="text" placeholder="Nome de usuário" required >

                        <h2>Email</h2> 
                        <input required class="inputs" name ="email" type="email" placeholder="email@exemplo.com" required>

                        <h2>Senha</h2> 
                        <div class="input-senha">
                            <input class="inputs" type="password" name ="senha" autocomplete="off" placeholder="Insira sua Senha" required >
                            <i class="fas fa-eye-slash toggle-password" onclick="toggleSenha(this)"></i> 
                        </div>
                    
                        <h2>Confirme sua Senha</h2> 
                        <div class="input-senha">
                            <input class="inputs" type="password" name ="senhaConfirmar" autocomplete="off" placeholder="Insira sua Senha" required>
                            <i class="fas fa-eye-slash toggle-password" onclick="toggleSenha(this)"></i> 
                        </div>
                    
                        <div class="buttons">
                            <button type="button" class="btn-cancelar" onclick="fecharModal('modal-criar')">Cancelar</button>
                            <button type="submit" class="btn-salvar">Salvar</button>
                        </div>
                    </div>
                </section>
            </form>
        </div>

    </main>

    <script src="/public/js/Modal.js"></script>
    <script src="/public/js/PreviewImagemUser.js"></script>
    <script src="/public/js/togglePassword.js"></script>
    
</body>
</html>