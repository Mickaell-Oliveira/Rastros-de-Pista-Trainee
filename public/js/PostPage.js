document.addEventListener('DOMContentLoaded', function() {
    const paginationLinks = document.querySelectorAll('.pagination a');

    function handlePaginationClick(event) {
        paginationLinks.forEach(link => {
            link.classList.remove('active');
        });
        event.currentTarget.classList.add('active');
  }
  paginationLinks.forEach(link => {
    if (!link.classList.contains('arrow')) {
        link.addEventListener('click', handlePaginationClick);
    }
  });
});

