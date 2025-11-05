const modal = document.getElementById('modal-excluir');

    const botaoAbrir = document.getElementById('lixeira');
    const botaoSim = document.getElementById('btn-sim');
    const botaoNao = document.getElementById('btn-nao');

    const abrirModal = () => {


        modal.classList.remove('hidden'); 

    };

    const fecharModal = () => {

        modal.classList.add('hidden'); 

    };

    botaoAbrir.addEventListener('click', abrirModal);
    botaoSim.addEventListener('click', fecharModal);
    botaoNao.addEventListener('click', fecharModal);