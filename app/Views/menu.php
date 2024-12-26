<?php
function renderMenu($role)
{
?>
    <header class="bg-primary text-white p-4">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold">Sistema Porta do Sol</h1>
            <nav class="flex space-x-4">
                <a href="<?php echo base_url('/'); ?>"
                    class="text-gray-200 font-medium hover:text-white">
                    Dashboard
                </a>
                <?php if ($role === 'admin'): ?>
                    <a href="<?php echo base_url('/users'); ?>"
                        class="text-gray-200 hover:text-white font-medium">
                        Moradores
                    </a>
                    <a href="<?php echo base_url('/recebedores'); ?>"
                        class="text-gray-200 hover:text-white font-medium">
                        Recebedores
                    </a>
                    <a href="<?php echo base_url('/pagamentos'); ?>"
                        class="text-gray-200 hover:text-white font-medium">
                        Pagamentos
                    </a>
                <?php endif; ?>
                <a href="<?php echo base_url('/logout'); ?>"
                    class="text-red-900 hover:text-red-700 font-medium">
                    Sair
                </a>
            </nav>
        </div>
    </header>
<?php
}
?>