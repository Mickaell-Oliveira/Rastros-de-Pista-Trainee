function exibirPreview(inputElement, previewId, imgPadraoId, labelId) {
    
    const previewElement = document.getElementById(previewId);
    const imgPadraoElement = document.getElementById(imgPadraoId);
    const labelElement = document.getElementById(labelId);
    const arquivo = inputElement.files[0];    
      if (arquivo) {
        const reader = new FileReader();
        reader.onload = function(e){
          previewElement.src = e.target.result;
          previewElement.style.display = 'block';
          imgPadraoElement.style.display = 'none';
        };

        reader.readAsDataURL(arquivo);
        } 
      else{
          previewElement.style.display = 'none';
          previewElement.src = '';
          imgPadraoElement.style.display = 'block';
        }
} 