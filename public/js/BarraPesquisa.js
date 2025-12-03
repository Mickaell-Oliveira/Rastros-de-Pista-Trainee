function criarDebounce(funcao, atraso) {
    let tempoLimite;
    return function(...argumentos) {
        const contexto = this;
        clearTimeout(tempoLimite);
        tempoLimite = setTimeout(() => funcao.apply(contexto, argumentos), atraso);
    };
}

function filtrarItens(evento) {
    const termoBusca = evento.target.value.toLowerCase();
    const itensPost = document.querySelectorAll('.post-item');

    itensPost.forEach(item => {
        const titulo = item.getAttribute('data-title').toLowerCase();

        if (titulo.includes(termoBusca)) {
            item.classList.remove('hidden');
        } else {
            item.classList.add('hidden');
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const campoBusca = document.getElementById('searchInput');
    
    if (campoBusca) {
        const filtroDebounce = criarDebounce(filtrarItens, 300);
        campoBusca.addEventListener('input', filtroDebounce);
    }
});