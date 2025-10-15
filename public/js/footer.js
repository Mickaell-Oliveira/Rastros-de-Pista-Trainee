document.addEventListener('DOMContentLoaded', function() {

    const primaryFooter = document.getElementById('primary_footer');
    const footerContainer = document.getElementById('footer_container'); 

    
    if (primaryFooter && footerContainer) {
        
    
        primaryFooter.addEventListener('click', function(event) {
            
     
            if (window.innerWidth <= 768) {
                
            
                if (!event.target.closest('a')) {
  
                    footerContainer.classList.toggle('open');
                }
            }
        });
    } else {
        

        console.error("Erro: Verifique se os IDs 'primary_footer' e 'footer_container' existem no seu HTML.");
    }
});

// função pra clicar e aparecer o menu do footer