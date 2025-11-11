document.addEventListener('DOMContentLoaded', function() {
    const mobileMenu = document.getElementById('mobile-menu');
    const navbarMenu = document.getElementById('navbar-menu');
    const closeMenu = document.getElementById('close-menu');
    
    // Verificar se os elementos existem
    if (mobileMenu && navbarMenu && closeMenu) {
        
        // Abrir menu
        mobileMenu.addEventListener('click', function(e) {
            e.preventDefault();
            navbarMenu.classList.add('active');
        });
        
        // Fechar menu
        closeMenu.addEventListener('click', function(e) {
            e.preventDefault();
            navbarMenu.classList.remove('active');
        });
    }
});