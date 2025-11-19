<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tabela de Usuários - Admin</title>
    <link rel="stylesheet" href="../../../public/css/UserList.css">

    <link rel="stylesheet" href="../../../public/css/modalVisualizarUsuario.css">
    <link rel="stylesheet" href="../../../public/css/modalEditarUsuario.css">
    <link rel="stylesheet" href="../../../public/css/ModalExcluirUsuario.css">
    <link rel="stylesheet" href="../../../public/css/modalCriarUsuario.css">
    <link rel="stylesheet" href="../../../public/css/modalComentar.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

    <section class="admin-panel">
        <header class="main-header">
            <h1>TABELA DE USUÁRIO</h1>
        </header>

        <!-- Barra de Pesquisa, Nova Publicação-->
        <div class="toolbar">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-bar" placeholder="">
            </div>
            <div class="actions-container" onclick="abrirModal('modal-criar')">
                <button class="new-post-btn">
                    <i class="fas fa-plus-circle"></i> <span>Novo Usuário</span>
                </button>
            </div>
        </div>

        <main class="posts-content">
            <table class="tabela">

                <!-- -------Header da Tabela----------- -->
                <tr class="posts-table-header">
                    <th class="header-col">User ID</th>
                    <th class="header-col">Data de Cadastro</th>
                    <th class="header-col" id="header-titulo">Nome</th>
                    <th class="header-col" id="header-autor">Email</th>
                    <th class="header-col">Ações</th>
                </tr>




                <!-- ---------Tabela #4567--------------->
                <?php foreach($usuarios as $user): ?>

                <tr class="post-item">
                    <td class="post-data post-id" data-label="Post ID"><?= $usuarios->id ?></td>
                    <td class="post-data post-date" data-label="Data"><?= $usuarios->data ?></td>
                    <td class="post-data post-title" data-label="Título"><?= $usuarios->nome ?></td>
                    <td class="post-data post-date" data-label="Autor"><?= $usuarios->email ?></td>
                    <td class="post-data post-actions" data-label="Ações">
                        <button id="botaoComentar" class="action-btn comentar" onclick="abrirModal('modal-visualizar')"><i class="bi bi-chat-left-text"></i></button>
                        <button id="botaoViewUsuario" class="action-btn view" onclick="abrirModal('modal-visualizar')"><i class="fas fa-eye"></i></button>
                        <button id="botaoEditarUsuario" class="action-btn edit" onclick="abrirModal('modal-editar')"><i class="fas fa-pencil-alt"></i></button>
                        <button id="botaoExcluirUsuario" class="action-btn delete" onclick="abrirModal('modal-excluir')"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>




                
            </table>
        </main>

        <!-- Cards (Mobile) -->

        <ul class="user-cards">
            <li class="user-card">
                <h2 class="name"><?= $usuarios->nome ?></h2>
                <p class="email"><?= $usuarios->email ?></p>
                <p class="meta">Data de cadastro: <?= $usuarios->data ?></p>
                <p class="meta">USER ID: <?= $user->id ?></p>
                <div class="card-actions">
                    <button class="btn-card btn-view" type="button" onclick="abrirModal('modal-visualizar')">VISUALIZAR USUÁRIO</button>
                    <button class="btn-card btn-edit" type="button" onclick="abrirModal('modal-editar')">EDITAR USUÁRIO</button>
                    <button class="btn-card btn-delete" type="button" onclick="abrirModal('modal-excluir')">DELETAR USUÁRIO</button>
                </div>
            </li>

         
            
        </ul>

        <a href="#" class="fab-btn" onclick="abrirModal('modal-criar')">
            <i class="fas fa-plus"></i>
        </a>

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




    <!-- MODAL VISUALIZAR USUÁRIO -->

    <div class="modal-overlay hidden" id="modal-visualizar">
        <section class="container">
            <div class="ladoEsquerdo"></div>
            <div id="imgPost">
                <img src="../../../public/assets/fotoPost.jpg" alt="Foto do usuário">
            </div>

            <div class="ladoDireito">
                <h2>Nome</h2>
                <div class="caixas-input">
                    <input class="inputs" type="text" disabled>
                    <h2>Email</h2>
                    <input class="inputs" type="text" disabled>
                </div>

                <div class="buttons">
                    <button onclick="fecharModal('modal-visualizar')" id="btn-cancelar">Cancelar</button>
                    <button id="btn-salvar">Salvar</button>
                </div>
            </div>
        </section>
    </div>



    <!-- MODAL EDITAR USUÁRIO -->
    <form action="/user/edit" method="post">
    <div class="modal-overlay hidden" id="modal-editar">
        <section class="container">
            <div class="ladoEsquerdo">
                <div id="imgPost">
                    <img src="../../../public/assets/fotoPost.jpg" alt="Foto do usuário">
                </div>
                <img id="img-rato" src="../../../public/assets/ratao-editor.png" alt="">
            </div>

            <div class="ladoDireito">
                <h2>Nome</h2>
                
                <div class="caixas-input">
                    <input class="inputs" type="text" placeholder="Novo nome de usuario">
                    
                    <h2>Email</h2>
                    <input class="inputs" type="email" placeholder="Novo email">
                    
                    <h2>Senha</h2>
                    
                    <div class="input-senha">
                        <input class="inputs" type="password" autocomplete="off" placeholder="Nova senha">
                        <i class="fas fa-eye-slash toggle-password" id="olhoMostrarSenha"></i>
                    </div>

                </div>

                <div class="buttons">
                    <button type="button" onclick="fecharModal('modal-editar')" id="btn-cancelar">Cancelar</button>
                    <button type="submit" id="btn-salvar">Salvar</button>
                </div>
            </div>
        </section>
    </div>
</form>


    <!-- MODAL DELETAR USUÁRIO -->
    <form action="/user/delete" method="get">
    <div class="modal-overlay hidden" id="modal-excluir">
        <section class="container">
            <div class="borda">
                <div class="caixa-texto">
                    <h1>Deseja excluir usuário</h1>
                </div>
                <img src="../../../public/assets/RATO-PARADO.png" class="rato-gordo" alt="">
                <div class="botoes">
                    <h1>Você não poderá reverter essa alteração</h1>
                    <div class="sim" id="btn-sim">
                        <h2>Sim</h2>
                    </div>
                    <div class="nao" id="btn-nao" onclick="fecharModal('modal-excluir')">
                        <h2>Não</h2>
                    </div>
                </div>
            </div>
        </section>
        </form>
    </div>


    
    <!-- MODAL CRIAR USUÁRIO -->
    <form action="/user/create" method="post">
    <div class="modal-overlay hidden" id="modal-criar">
        <section class="container">
            <div class="ladoEsquerdo">
                <div id="imgPost">
                    <img src="../../../public/assets/imagemPerfil.jpg" alt="Foto do usuário">
                </div>
                
            </div>

            <div class="ladoDireito">

        

                <form class="caixas-input" method="POST" action="user/create">
                    <h2>Nome</h2>
                    <input required class="inputs" name ="name" type="text" placeholder="Nome completo do usuário" value="<?= $usuarios->nome ?>">
                    <h2>Email</h2>
                    <input required class="inputs" type="email" name ="email" placeholder="email@exemplo.com" value="<?= $usuarios->email ?>">
                    <h2>Senha</h2>

                    <div class="input-senha">
                        <input class="inputs" type="password" name ="senha" autocomplete="off" placeholder="Nova senha" value="<?= $usuarios->senha ?>">
                        <i class="fas fa-eye-slash toggle-password" id="olhoMostrarSenha"></i>
                    </div>
                </form>

                <div class="buttons">
                    <button onclick="fecharModal('modal-criar')" id="btn-cancelar">Cancelar</button>
                    <button id="btn-salvar">Salvar</button>
                </div>
            </div>
        </section>
        </form>
    </div>

    


    <!-- MODAL COMENTAR -->
    <form action="/comentar" method="get">
    <div class="modal-overlay hidden" id="modal-comentar">
        <section class="container">
            <div class="ladoEsquerdo">
                <div id="imgPost">
                    <img src="../../../public/assets/imagemCarrinho.jpg" alt="Foto do usuário">
                </div>
                <img id="img-rato" src="../../../public/assets/ratao-editor.png" alt="">
            </div>

            <div class="ladoDireito">
                <h2>Nome</h2>
                <div class="caixas-input">
                    <input class="inputs" type="text" placeholder="Nome completo do usuário">
                    <h2>Email</h2>
                    <input class="inputs" type="email" placeholder="email@exemplo.com">
                    <h2>Senha</h2>
                    <input class="inputs" type="password" autocomplete="off" placeholder="Senha forte">
                </div>

                <div class="buttons">
                    <button onclick="fecharModal('modal-comentar')" id="btn-cancelar">Cancelar</button>
                    <button id="btn-salvar">Salvar</button>
                </div>
            </div>
        </section>
        </form>



    </div>


    <?php endforeach; ?>



    <script src="/public\js\Modal.js"></script>
    <script src="/public\js\PostChart.js"></script>
</body>

</html>