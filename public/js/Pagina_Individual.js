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