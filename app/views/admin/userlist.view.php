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


        <!---------------------------------------->
        <!-- BARRA DE PESQUISA e NOVA PUBLICAÇÃO-->

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

        <!--------------------------------------->
        <!-- ----------- TABELA -------------- -->

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

                <!-------- Informações da Tabela -------->

                <?php foreach($usuarios as $user): ?>

                <tr class="post-item">
                    <td class="post-data post-id" data-label="Post ID"><?= $user->id ?></td>
                    <td class="post-data post-date" data-label="Data"><?= date('d/m/Y', strtotime($user->data)) ?></td>
                    <td class="post-data post-title" data-label="Título"><?= $user->nome ?></td>
                    <td class="post-data post-date" data-label="Autor"><?= $user->email ?></td>
                    <td class="post-data post-actions" data-label="Ações">
                        <button id="botaoViewUsuario" class="action-btn view" onclick="abrirModal('modal-visualizar-<?= $user->id ?>')"><i class="fas fa-eye"></i></button>
                        <button id="botaoEditarUsuario" class="action-btn edit" onclick="abrirModal('modal-editar-<?= $user->id ?>')"><i class="fas fa-pencil-alt"></i></button>
                        <button id="botaoExcluirUsuario" class="action-btn delete" onclick="abrirModal('modal-excluir-<?= $user->id ?>')"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>

                <?php endforeach; ?>
            </table>
        </main>

    
        <!--------------------------------------->
        <!-- ------ TABELA DO CELULAR -------- -->

            <?php foreach($usuarios as $user): ?>

                <ul class="user-cards">
                     <li class="user-card">
                        <h2 class="name"><?= $user->nome ?></h2>
                        <p class="email"><?= $user->email ?></p>
                        <p class="meta">Data de cadastro: <?= date('d/m/Y', strtotime($user->data)) ?></p>
                        <p class="meta">USER ID: <?= $user->id ?></p>
                        <div class="card-actions">
                            <button class="btn-card btn-view" type="button" onclick="abrirModal('modal-visualizar')">VISUALIZAR USUÁRIO</button>
                            <button class="btn-card btn-edit" type="button" onclick="abrirModal('modal-editar')">EDITAR USUÁRIO</button>
                            <button class="btn-card btn-delete" type="button" onclick="abrirModal('modal-excluir')">DELETAR USUÁRIO</button>
                        </div>
                    </li> 
                </ul>
                <!-- Botão de criar Usuário -->
                <a href="#" class="fab-btn" onclick="abrirModal('modal-criar')"><i class="fas fa-plus"></i></a>
              
            <?php endforeach; ?>
   
        <!--------------------------------------->
        <!-- ---------- PAGINAÇÃO ------------ -->


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
    <!------------------------------------------->
    <!------------- FIM DA TABELA --------------->



    <!--------------------------------------->
    <!-- ------- MODAL: VISUALIZAR ------- -->


    <?php foreach($usuarios as $user): ?>
            <div class="modal-overlay hidden" id="modal-visualizar-<?= $user->id ?>" method="get">
                <section class="container">

                    <div class="ladoEsquerdo">
                    <div id="imgPost">
                    <img src="/public/assets/imagemUsuario/<?= !empty($user->foto) ? $user->foto : 'default.png' ?>" alt="Foto do Usuário: <?= $user->nome ?>">
                        <div class="DataUser"><p>Data de Criação: <?= date('d/m/Y', strtotime($user->data)) ?></p></div>
                    </div>
                    </div>
        
                    <div class="ladoDireito">
                        <div class="caixas-input">
                            <h2>Nome</h2> <p class="inputs" type="text" disabled><?= $user->nome ?></p>
                            <h2>Email</h2> <p class="inputs" type="text" disabled><?= $user->email ?></p>
                        </div>

                        <div class="buttons">
                            <button onclick="fecharModal('modal-visualizar-<?= $user->id ?>')" id="btn-cancelar">Fechar</button></div>
                        </div>
                </section>
            </div>
    <?php endforeach; ?>



    <!--------------------------------------->
    <!-- --------- MODAL: EDITAR --------- -->

    <?php foreach($usuarios as $user): ?>
        <form action="/user/edit" method="POST"  >
            <div class="modal-overlay modal-editar hidden" id="modal-editar-<?= $user->id ?>">
                <input type="hidden" name="id" value="<?= $user->id ?>">

                <section class="container">
                    <div id="imgPost">
                    <img src="/public/assets/imagemUsuario/<?= !empty($user->foto) ? $user->foto : 'default.png' ?>" alt="Foto do Usuário: <?= $user->nome ?>">
                        <div class="DataUser"><p>Data de Criação: <?= date('d/m/Y', strtotime($user->data)) ?></p></div>
                    </div>

                    <div class="ladoDireito">
                        <div class="caixas-input">
                            <h2>Nome</h2>
                            <input class="inputs" name="name" type="text"  value="<?= $user->nome ?>">
                            <h2>Email</h2>
                            <input class="inputs" name="email" type="email" placeholder="Novo email"  value="<?= $user->email ?>">
                            <h2>Senha</h2>
                            <div class="input-senha">
                                <input class="inputs" name="senha" type="password" autocomplete="off"  value="<?= $user->senha ?>">
                                <i class="fas fa-eye-slash toggle-password" id="olhoMostrarSenha"></i>
                            </div>
                            <h2>Confirme sua Senha</h2> 
                            <div class="input-senha">
                                <input class="inputs" type="password" name ="senhaConfirmar" autocomplete="off" placeholder="Insira sua Senha" >
                                <i class="fas fa-eye-slash toggle-password" id="olhoMostrarSenha"></i> </div>
                    


                        </div>
                        <div class="buttons">   
                            <button type="button" onclick="fecharModal('modal-editar-<?= $user->id ?>')" id="btn-cancelar">Cancelar</button>
                            <button type="submit" id="btn-salvar">Salvar</button>
                        </div>
                    </div>
                </section>
            </div>
        </form>
    <?php endforeach; ?>


    <!---------------------------------------->
    <!-- --------- MODAL: DELETAR --------- -->


    <?php foreach($usuarios as $user): ?>
        <form action="/user/delete" method="POST">
            <div class="modal-overlay modal-excluir hidden" id="modal-excluir-<?= $user->id ?>">
                <input type="hidden" name="id" value="<?= $user->id ?>">
                <section class="container">
                    <div class="borda">
                        <div class="caixa-texto"> <h1>Deseja excluir usuário</h1></div>
                        <img src="../../../public/assets/RatoPare.png" class="rato-gordo" alt="">
                        <div class="botoes">
                            <h1>Você não poderá reverter essa alteração</h1>
                            <button type="submit" class="sim" id="btn-sim"><h2 class="sim" id="btn-sim">Sim</h2></button>
                            <button class="nao" id="btn-nao" type="button" onclick="fecharModal('modal-excluir-<?= $user->id ?>')"><h2 class="nao" id="btn-nao">Não</h2></button>
                        </div>
                    </div>
                </section>
            </div>
        </form>
    <?php endforeach; ?>



    <!---------------------------------------------->
    <!-- --------- MODAL: CRIAR USUARIO --------- -->

    <form action="/user/create" method="POST" enctype="multipart/form-data">
        <div class="modal-overlay hidden" id="modal-criar">

            <section class="container">

                <div class="ladoEsquerdo">
                    <div id="imgPost"> <input type="file" name="imagem" accept="imagem/*" id="img" required> </div>
                </div>


                <div class="ladoDireito">
                    <form class="caixas-input" method="POST" action="user/create">
                    
                        <h2>Nome</h2> 
                            <input required class="inputs" name ="name" type="text" placeholder="Nome de usuário" >

                        <h2>Email</h2> 
                            <input required class="inputs" name ="email" type="email" placeholder="email@exemplo.com" >

                        <h2>Senha</h2> 
                            <div class="input-senha">
                                <input class="inputs" type="password" name ="senha" autocomplete="off" placeholder="Insira sua Senha" >
                                <i class="fas fa-eye-slash toggle-password" id="olhoMostrarSenha"></i> </div>
                    
                        <h2>Confirme sua Senha</h2> 
                            <div class="input-senha">
                                <input class="inputs" type="password" name ="senhaConfirmar" autocomplete="off" placeholder="Insira sua Senha" >
                                <i class="fas fa-eye-slash toggle-password" id="olhoMostrarSenha"></i> </div>
                    

                    </form>

                    <div class="buttons">
                        <button onclick="fecharModal('modal-criar')" id="btn-cancelar">Cancelar</button>
                        <button type="submit" id="btn-salvar">Salvar</button>
                    </div>

                </div>
            </section>
        </div>
    </form>

    <!---------------------------------------------->
    <!-- ----------- FIM DOS MODAIS ------------- -->



        <script src="/public\js\Modal.js"></script>
        <script src="/public\js\PostChart.js"></script>

    </body>
</html>