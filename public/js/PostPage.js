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

  const inputImagem = document.getElementById('img-do-post');
  const imagemPreview = document.getElementById('image-post');
  const labelTexto = document.querySelector('.upload-label span');

  if (inputImagem && imagemPreview){
    
    inputImagem.addEventListener('change', function(e){
      const file = e.target.files[0];

      if (file){
        const reader = new FileReader();

        reader.onload = function(event){
          imagemPreview.src = event.target.result;

          imagemPreview.style.display = 'block';

          if (labelTexto) labelTexto.innerHTML = "Trocar foto";

          
        }

        reader.readAsDataURL(file);
      }
    });
  }
});

