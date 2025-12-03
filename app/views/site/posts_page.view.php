<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <title>Rastros de Pista | Posts</title>
  <link rel="stylesheet" href="../../../public/css/posts_page.css" />
</head>
<body>
 
   <div id="page-container">
    <search class="search-section">
      <form class="search-bar">
        <button type="submit" class="search-button" aria-label="Buscar"> 
           <i class="fa-solid fa-magnifying-glass"></i>
        </button>
      <input type="text" placeholder="Buscar">
      </form>
    </search>

    <main class="posts-grid">
        <?php foreach($posts as $post): ?>
          <article class="card">
            <a href="/postindividual?id=<?= $post->id ?>" style="text-decoration: none; color: inherit; display: block;">
                <img src="/<?= $post->foto ?>" alt="<?= $post->titulo ?>">
                <h3><?= $post->titulo ?></h3>
                <p><?= $post->descricao ?></p>
            </a>
          </article>
        <?php endforeach; ?>
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

    <script src="../../../public/js/posts_page.js"></script>
</body>
</html>