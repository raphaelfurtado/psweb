<?php
function renderMenu($role)
{
    ?>
    <header class="bg-primary text-white shadow-md relative">
        <div class="container mx-auto flex items-center justify-between p-4">
            <!-- Logo -->
            <h1 class="text-2xl font-bold">Sistema Porta do Sol</h1>

            <!-- Botão Hamburguer -->
            <button id="menu-toggle" class="lg:hidden text-white focus:outline-none transition-transform transform"
                aria-label="Abrir Menu">
                <svg xmlns="http://www.w3.org/2000/svg" id="menu-icon" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>

            <!-- Navegação -->
            <nav id="menu"
                class="hidden flex-col lg:flex lg:flex-row items-start lg:items-center absolute lg:static top-full left-0 w-full lg:w-auto bg-primary lg:bg-transparent z-10 shadow-lg lg:shadow-none transition-all duration-300"
                role="menu">
                <a href="<?php echo base_url('/'); ?>"
                    class="block text-gray-200 font-medium hover:text-white px-4 py-2 lg:py-0" role="menuitem">
                    Dashboard
                </a>
                <?php if ($role === 'admin'): ?>
                    <a href="<?php echo base_url('/users'); ?>"
                        class="block text-gray-200 hover:text-white font-medium px-4 py-2 lg:py-0" role="menuitem">
                        Moradores
                    </a>
                    <a href="<?php echo base_url('/recebedores'); ?>"
                        class="block text-gray-200 hover:text-white font-medium px-4 py-2 lg:py-0" role="menuitem">
                        Recebedores
                    </a>
                    <a href="<?php echo base_url('/pagamentos'); ?>"
                        class="block text-gray-200 hover:text-white font-medium px-4 py-2 lg:py-0" role="menuitem">
                        Pagamentos
                    </a>
                    <a href="<?php echo base_url('/saidas'); ?>"
                        class="block text-gray-200 hover:text-white font-medium px-4 py-2 lg:py-0" role="menuitem">
                        Saídas
                    </a>
                    <a href="<?php echo base_url('/formasPagamento'); ?>"
                        class="block text-gray-200 hover:text-white font-medium px-4 py-2 lg:py-0" role="menuitem">
                        Formas de Pagamento
                    </a>
                    <a href="<?php echo base_url('/tiposPagamento'); ?>"
                        class="block text-gray-200 hover:text-white font-medium px-4 py-2 lg:py-0" role="menuitem">
                        Tipos de Pagamento
                    </a>
                    <a href="<?php echo base_url('/gerarPagamentos'); ?>"
                        class="block text-gray-200 hover:text-white font-medium px-4 py-2 lg:py-0" role="menuitem">
                        Gerar Pagamentos
                    </a>
                <?php endif; ?>
                <a href="<?php echo base_url('/anexos'); ?>"
                    class="block text-gray-200 hover:text-white font-medium px-4 py-2 lg:py-0" role="menuitem">
                    anexos
                </a>
                <a href="<?php echo base_url('/logout'); ?>"
                    class="block text-red-700 hover:text-red-500 font-medium px-4 py-2 lg:py-0" role="menuitem">
                    Sair
                </a>
            </nav>
        </div>
    </header>
    <?php
}
?>