// Seleciona os elementos que vamos usar
const track = document.querySelector('.carousel-track');
const cards = Array.from(track.children);
const nextButton = document.querySelector('#nextBtn');
const prevButton = document.querySelector('#prevBtn');

// Pega a largura do primeiro card para saber o quanto mover
const cardWidth = cards[0].getBoundingClientRect().width;

// Variável para controlar qual card está visível
let currentIndex = 0;

// Função que move a trilha
const moveToCard = (targetIndex) => {
    // Move a trilha para a esquerda baseado no índice do card
    track.style.transform = 'translateX(-' + cardWidth * targetIndex + 'px)';
    currentIndex = targetIndex;
}

// Quando o botão "próximo" for clicado
nextButton.addEventListener('click', () => {
    let nextIndex = currentIndex + 1;
    // Se chegar no final, volta para o primeiro
    if (nextIndex >= cards.length) {
        nextIndex = 0;
    }
    moveToCard(nextIndex);
});

// Quando o botão "anterior" for clicado
prevButton.addEventListener('click', () => {
    let prevIndex = currentIndex - 1;
    // Se estiver no primeiro, vai para o último
    if (prevIndex < 0) {
        prevIndex = cards.length - 1;
    }
    moveToCard(prevIndex);
});