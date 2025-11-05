const modal = document.getElementById('modal-editar');
    const botaoAbrir = document.getElementById('abrir-modal-btn');
    const botaoSalvar = document.getElementById('btn-salvar');
    const botaoCancelar = document.getElementById('btn-cancelar');

    // abrir e fechar
    const abrirModal = () => {
        modal.classList.remove('hidden'); // remove a classe "hidden"
    };

    const fecharModal = () => {
        modal.classList.add('hidden'); // adiciona a classe "hidden"
    };

    botaoAbrir.addEventListener('click', abrirModal);
    botaoSalvar.addEventListener('click', fecharModal);
    botaoCancelar.addEventListener('click', fecharModal);