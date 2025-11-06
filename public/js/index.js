document.addEventListener('DOMContentLoaded', function() {
    const footerContainer = document.getElementById('footer_container');

    if (footerContainer) {
        footerContainer.addEventListener('click', function() {
            if (window.innerWidth <= 768) {    // se for de celular, vai dar opção de click
                this.classList.toggle('open');
            }
        });
    }
});
