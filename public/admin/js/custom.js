document.addEventListener('DOMContentLoaded', function () {
    // Função para inicializar um tabpanel específico
    function initializeTabPanel(tabPanelId) {
        const tabPanel = document.getElementById(tabPanelId);
        if (!tabPanel) return;

        // Seleciona as abas e os conteúdos dentro do escopo do tabpanel
        const navLinks = tabPanel.querySelectorAll('.nav-link');
        const tabContents = tabPanel.parentElement.querySelectorAll('.tab-content .tab-pane');

        navLinks.forEach((link) => {
            link.addEventListener('click', function (event) {
                event.preventDefault();

                // Remove a classe 'active' de todas as abas no escopo
                navLinks.forEach((navLink) => {
                    navLink.classList.remove('active');
                });

                // Adiciona a classe 'active' à aba clicada
                link.classList.add('active');

                // Remove a classe 'show active' de todos os conteúdos no escopo
                tabContents.forEach((tabPane) => {
                    tabPane.classList.remove('show', 'active');
                });

                // Mostra o conteúdo da aba clicada
                const targetId = link.getAttribute('href').substring(1);
                const activeTabPane = document.getElementById(targetId);
                if (activeTabPane) {
                    activeTabPane.classList.add('show', 'active');
                }
            });
        });
    }

    // Inicialize todos os tabpanels presentes na página
    const tabPanelIds = ['tab-unique-id-1', 'tab-unique-id-2']; // Adicione mais IDs conforme necessário
    tabPanelIds.forEach((tabPanelId) => {
        initializeTabPanel(tabPanelId);
    });
});