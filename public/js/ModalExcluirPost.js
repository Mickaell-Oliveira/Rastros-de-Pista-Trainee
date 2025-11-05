const modal = document.getElementById('modal-excluir-post');

    const botaoAbrir = document.getElementById('lixeira-post');

    const botaoSim = document.getElementById('btn-sim');

    const botaoNao = document.getElementById('btn-nao');



    // abrir e fechar

    const abrirModal = () => {

        modal.classList.remove('hidden'); // remove a classe "hidden"

    };



    const fecharModal = () => {

        modal.classList.add('hidden'); // adiciona a classe "hidden"

    };



    botaoAbrir.addEventListener('click', abrirModal);

    botaoSim.addEventListener('click', fecharModal);

    botaoNao.addEventListener('click', fecharModal);