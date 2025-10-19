document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.querySelector('form');
    const searchInput = document.querySelector('input[type="search"]');
    const tableRows = document.querySelectorAll('tbody tr');

    // Função de busca
    function searchUsers(query) {
        const searchTerm = query.toLowerCase().trim();

        tableRows.forEach(row => {
            const userId = row.cells[0].textContent.toLowerCase();
            const name = row.cells[2].textContent.toLowerCase();
            const email = row.cells[3].textContent.toLowerCase();

            // Verifica se o termo está em algum campo
            if (userId.includes(searchTerm) || 
                name.includes(searchTerm) || 
                email.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Busca ao submeter
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        searchUsers(searchInput.value);
    });
});