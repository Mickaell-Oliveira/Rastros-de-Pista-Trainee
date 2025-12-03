document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.sidebar');
    const openButton = document.querySelector('#open');

    if (openButton && sidebar) {
        openButton.addEventListener('click', () => {
            sidebar.classList.toggle('closed');
        });
    }
});