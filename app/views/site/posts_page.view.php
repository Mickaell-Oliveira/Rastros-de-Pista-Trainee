<?php  // login
    session_start();

    if(!isset($_SESSION['id'])){
        header('Location: /login');
    }
?>

<?php  // filtro

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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <title>Rastros de Pista | Posts</title>
  <link rel="stylesheet" href="../../../public/css/posts_page.css" />
  <link rel="stylesheet" href="../../../public/css/Filtro.css" />
</head>
<body>

  <?php require 'app/views/site/navbar.view.php'; ?>


  <div id="page-container">

    <div class="search-section">

        <form class="search-bar" action="" method="GET" >

            <button type="submit" class="search-button" aria-label="Buscar"> 
              <i class="fa-solid fa-magnifying-glass"></i>
            </button>
    
            <input id="searchInput" type="text" class="search-bar" name="busca" value="<?= htmlspecialchars($busca); ?>" placeholder="Buscar">
            <input type="hidden" name="tipo" value="<?= htmlspecialchars($filtroTipo) ?>">
            <input type="hidden" name="ano" value="<?= htmlspecialchars($filtroAno) ?>">
            <input type="hidden" name="tags" value="<?= htmlspecialchars($filtroTags) ?>">

        </form>

       <div class="actions-container">
          <button class="filter-btn" type="button" onclick="abrirModal('modalFiltro')">
               <i class="fas fa-filter"></i> <span>Filtro</span>
          </button>
       </div>
      
  </div>

    <main class="posts-grid">

      <?php if(!empty($posts)): ?>
        <?php foreach($posts as $post): ?>
          <article class="card">
            <a href="/postindividual?id=<?= $post->id ?>" style="text-decoration: none; color: inherit; display: block;">
                <img src="/<?= $post->foto ?>" alt="<?= $post->titulo ?>">
                <h3><?= $post->titulo ?></h3>
                <p><?= $post->descricao ?></p>
            </a>
          </article>
        <?php endforeach; ?>
       <?php else:   //esse css ta no meio por praticidade, se precisar deixar mais complexo, lembrar de criar css próprio ?> 
                    <tr><td colspan="9" style="text-align: center; padding: 20px;">Nenhum post encontrado.</td></tr>
        <?php endif; ?>


    </main>

    <nav class="pagination">
      <a href="#" class="arrow">&lt;</a>
      <a href="#" class="active">1</a>
       <a href="#">2</a>
       <a href="#">3</a>
       <a href="#">4</a>
       <a href="#">5</a>
       <a href="#" class="arrow">&gt;</a>
     </nav>
  </div>
 <?php require 'app/views/site/footer.view.php'; ?>



      <!-- Molda do Filtro -->
     <div class="modal-overlay hidden" id="modalFiltro" >
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







 
    <script src="../../../public/js/Modal.js"></script>
    <script src="../../../public/js/Filtro.js"></script>
    <script src="../../../public/js/posts_page.js"></script>
</body>


</html>