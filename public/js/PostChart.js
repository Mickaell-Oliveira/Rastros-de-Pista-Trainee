    document.addEventListener('DOMContentLoaded', function() {
        // Seleciona todos os botões de menu
        const menuButtons = document.querySelectorAll('.options-menu-btn');

        menuButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                // Impede que o clique no botão feche o menu imediatamente (veja o listener do window)
                event.stopPropagation();

                // Encontra o menu de ações associado a ESTE botão
                const actionsMenu = this.nextElementSibling;

                // Fecha todos os outros menus que possam estar abertos
                closeAllMenus(actionsMenu);

                // Alterna a classe 'active' para mostrar ou esconder o menu
                actionsMenu.classList.toggle('active');
            });
        });

        // Função para fechar todos os menus, exceto o atual (opcional)
        function closeAllMenus(exceptThisMenu = null) {
            document.querySelectorAll('.post-actions.active').forEach(menu => {
                if (menu !== exceptThisMenu) {
                    menu.classList.remove('active');
                }
            });
        }

        // Adiciona um listener para fechar o menu se o usuário clicar em qualquer outro lugar da tela
        window.addEventListener('click', function() {
            closeAllMenus();
        });
    });