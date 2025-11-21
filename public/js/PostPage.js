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
    const inputArquivo = document.getElementById('img-do-post');
    const imagemPreview = document.getElementById('post-thumbnail');

    // Só executa se os elementos existirem na tela
    if (inputArquivo && imagemPreview) {
        
        inputArquivo.addEventListener('change', function(e) {
            const arquivo = e.target.files[0];

            if (arquivo) {
                const leitor = new FileReader();

                // Quando terminar de ler o arquivo...
                leitor.onload = function(evento) {
                    // ... coloca o resultado no src da imagem
                    imagemPreview.src = evento.target.result;
                    
                    // (Opcional) Garante que a imagem preencha a div corretamente
                    imagemPreview.style.display = 'block'; 
                    imagemPreview.style.width = '100%';
                    imagemPreview.style.height = '100%';
                    imagemPreview.style.objectFit = 'cover';
                }

                leitor.readAsDataURL(arquivo);
            }
        });
    }
  
  
});

