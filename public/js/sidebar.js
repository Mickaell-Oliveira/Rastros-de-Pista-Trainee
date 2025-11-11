const sidebar = document.querySelector('.sidebar');
const openButton = document.querySelector('#open');


openButton.addEventListener('click', () => {
    
    sidebar.classList.toggle('closed');
});