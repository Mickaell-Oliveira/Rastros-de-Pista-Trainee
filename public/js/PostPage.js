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

   
    document.body.addEventListener('click', function(event) {
        
  
        const btnEditar = event.target.closest('.btn-editar-comentario');
        if (btnEditar) {
            const id = btnEditar.getAttribute('data-id');
            alternarModoEdicao(id, true); 
        }

        const btnCancelar = event.target.closest('.btn-cancelar-edicao');
        if (btnCancelar) {
            const id = btnCancelar.getAttribute('data-id');
            alternarModoEdicao(id, false); 
        }
    });

    
    document.body.addEventListener('submit', function(event) {
        
        if (event.target && event.target.id.startsWith('edit-comentario-')) {
            
            event.preventDefault();
            
            const form = event.target;
            const formData = new FormData(form);
            const id = formData.get('id_comentario');
            const novoTexto = formData.get('novo_texto');
            const botaoSalvar = form.querySelector('button[type="submit"]');

            const textoOriginalBotao = botaoSalvar.innerText;
            botaoSalvar.innerText = "Salvando...";
            botaoSalvar.disabled = true;

            fetch('/tabelaposts/atualizarComentario', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {

                    const paragrafoTexto = document.querySelector(`#view-comentario-${id} p`);
                    if (paragrafoTexto) {
                        paragrafoTexto.innerText = novoTexto;
                    }

                  
                    alternarModoEdicao(id, false);
                    console.log("Salvo com sucesso!");
                } else {
                    alert("Erro ao salvar. Tente novamente.");
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert("Erro de conexão.");
            })
            .finally(() => {
                
                botaoSalvar.innerText = textoOriginalBotao;
                botaoSalvar.disabled = false;
            });
        }
    });

});

function alternarModoEdicao(id, ativado) {
    const viewDiv = document.getElementById('view-comentario-' + id);
    const editForm = document.getElementById('edit-comentario-' + id);
    const actionDiv = document.getElementById('actions-comentario-' + id);
    const modalContainer = viewDiv.closest('.container');
    const botoesPrincipais = modalContainer.querySelector('.caixa-btn');

    if (ativado) {
        if(viewDiv) viewDiv.style.display = 'none';
        if(actionDiv) actionDiv.style.display = 'none';

        if(botoesPrincipais) botoesPrincipais.style.display = 'none';
        
        if(editForm) {
            editForm.style.display = 'block';
            const textarea = editForm.querySelector('textarea');
            if(textarea) {
                textarea.focus();
                const val = textarea.value;
                textarea.value = '';
                textarea.value = val;
            }
        }
    } else {
        if(editForm) editForm.style.display = 'none';
        if(viewDiv) viewDiv.style.display = 'block';
        if(actionDiv) actionDiv.style.display = 'flex';
        if(botoesPrincipais) botoesPrincipais.style.display = 'flex'; 
    }
}


function exibirPreview(inputElement, previewId, imgPadraoId, labelId) {
    const previewElement = document.getElementById(previewId);
    const imgPadraoElement = document.getElementById(imgPadraoId);
    const arquivo = inputElement.files[0];    
    
    if (arquivo) {
        const reader = new FileReader();
        reader.onload = function(e){
            previewElement.src = e.target.result;
            previewElement.style.display = 'block';
            imgPadraoElement.style.display = 'none';
        };
        reader.readAsDataURL(arquivo);
    } else {
        previewElement.style.display = 'none';
        previewElement.src = '';
        imgPadraoElement.style.display = 'block';
    }
}

function chamarConfirmacao(id) {
    document.getElementById('view-comentario-' + id).style.display = 'none';
    document.getElementById('actions-comentario-' + id).style.display = 'none';
    document.getElementById('delete-confirm-' + id).style.display = 'block';

    const modalContainer = document.getElementById('view-comentario-' + id).closest('.container');
    const botoesPrincipais = modalContainer.querySelector('.caixa-btn');
    if(botoesPrincipais) botoesPrincipais.style.display = 'none';
}

function cancelarExclusao(id) {
    document.getElementById('delete-confirm-' + id).style.display = 'none';
    document.getElementById('view-comentario-' + id).style.display = 'block';
    document.getElementById('actions-comentario-' + id).style.display = 'flex';

    const modalContainer = document.getElementById('view-comentario-' + id).closest('.container');
    const botoesPrincipais = modalContainer.querySelector('.caixa-btn');
    if(botoesPrincipais) botoesPrincipais.style.display = 'flex';
}

function confirmarExclusaoAJAX(id) {
    const formData = new FormData();
    formData.append('id', id);

    fetch('/tabelaposts/deletarComentario', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            const confirmDiv = document.getElementById('delete-confirm-' + id);
            const modalContainer = confirmDiv.closest('.container');
            const botoesPrincipais = modalContainer.querySelector('.caixa-btn');
            
            if(botoesPrincipais) botoesPrincipais.style.display = 'flex'; 

            const itemInteiro = confirmDiv.closest('.comment-item');
            
            if (itemInteiro) {
                itemInteiro.style.opacity = '0';
                setTimeout(() => itemInteiro.remove(), 300); 
            }
            console.log("Excluído com sucesso!");
        } else {
            alert("Erro ao excluir.");
        }
    })
    .catch(error => {
        console.error('Erro:', error);
    });
}