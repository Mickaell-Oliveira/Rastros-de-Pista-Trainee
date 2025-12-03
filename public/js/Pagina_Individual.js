function votar(idPost, tipo) {
    const url = '/post/interacao';

    const dados = {
        id_post: idPost,
        tipo: tipo
    };

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dados)
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => { throw new Error(text) });
        }
        return response.json();
    })
    .then(data => {
        if(data.erro) {
            console.error(data.erro);
            return;
        }
        document.getElementById('contador-like').innerText = data.likes;
        document.getElementById('contador-dislike').innerText = data.dislikes;
        atualizarEstiloBotoes(tipo);
    })
    .catch(error => {
        console.error('Erro no Fetch:', error);
    });
}

function atualizarEstiloBotoes(tipo) {
    const iconLike = document.getElementById('icon-like');
    const iconDislike = document.getElementById('icon-dislike');

    iconLike.classList.remove('fa-solid');
    iconLike.classList.add('fa-regular');
    iconDislike.classList.remove('fa-solid');
    iconDislike.classList.add('fa-regular');
    iconLike.style.color = '';
    iconDislike.style.color = '';

    if (tipo === 'like') {
        iconLike.classList.remove('fa-regular');
        iconLike.classList.add('fa-solid');
        iconLike.style.color = '#FFFFFF';
    } else if (tipo === 'dislike') {
        iconDislike.classList.remove('fa-regular');
        iconDislike.classList.add('fa-solid');
        iconDislike.style.color = '#FFFFFF';
    }
}

function toggleComentario() {
    const area = document.getElementById('area-comentario');
    const textarea = document.getElementById('texto-comentario');

    if (area.classList.contains('hidden')) {
        area.classList.remove('hidden');
        area.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => textarea.focus(), 300);
    } else {
        area.classList.add('hidden');
    }
}