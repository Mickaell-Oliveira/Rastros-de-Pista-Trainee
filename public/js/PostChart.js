    document.addEventListener('DOMContentLoaded', function() {
        const menuButtons = document.querySelectorAll('.options-menu-btn');

        menuButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.stopPropagation();

                const actionsMenu = this.nextElementSibling;

                closeAllMenus(actionsMenu);

                actionsMenu.classList.toggle('active');
            });
        });

        function closeAllMenus(exceptThisMenu = null) {
            document.querySelectorAll('.post-actions.active').forEach(menu => {
                if (menu !== exceptThisMenu) {
                    menu.classList.remove('active');
                }
            });
        }

        window.addEventListener('click', function() {
            closeAllMenus();
        });
    });