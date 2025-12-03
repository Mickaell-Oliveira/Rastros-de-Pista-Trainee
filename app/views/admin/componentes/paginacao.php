<nav class="pagination" style="display: flex; justify-content: center;">
    <ul class="pagination">
        
        <li class="page-item <?= $page <= 1 ? "disabled" : "" ?>">
            <a href="?paginacaoNumero=<?= $page - 1 ?>" class="arrow prev"><i class="fas fa-chevron-left"></i></a>
        </li>

        <?php 
            
            $max_links = 2; // Define que o limite do raio será 2
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