<nav class="pagination"style="display: flex; justify-content: center;">

<ul class="pagination">
        
    <li class="page-item<?= $page <= 1 ? "disabled" : "" ?>">
        <a href="?paginacaoNumero=<?= $page - 1 ?>" class="arrow prev"><i class="fas fa-chevron-left"></i></a>
        <?php for($pagenumber = 1; $pagenumber <= $total_pages; $pagenumber++): ?>
        </li>
            <li class="page-item"> <a  class="page-number <?= $pagenumber == $page ? 'active' : '' ?>" href="?paginacaoNumero=<?=$pagenumber ?>"><?= $pagenumber ?></a> </li>
        <?php endfor ?>

        <li class="page-item<?= $page <= $total_pages ? "disabled" : ""?>"><a href="?paginacaoNumero=<?= $page + 1 ?>" class="arrow next"><i class="fas fa-chevron-right"></i></a> </li>


        </ul>
    </nav>