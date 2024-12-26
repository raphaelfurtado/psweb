<?php
// Inclua o componente de menu
include 'menu.php';

$role = session('user_role');

?>

<html>

<head>
    <title>
        Login
    </title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1D4ED8',
                        secondary: '#9333EA',
                    },
                },
            },
        }
    </script>

    <style>
        .login {
            /*
    background: url('https://tailwindadmin.netlify.app/dist/images/login-new.jpeg');
  */
            background: url('http://bit.ly/2gPLxZ4');
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body>
    <main>
        <!-- component -->
        <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
            <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">LOGIN</h2>

                <?php if (session()->getFlashdata('error')): ?>
                    <div style="color: red;">
                        <?php echo session()->getFlashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <form method="post" class="space-y-4">
                    <label for="celular" class="block text-sm font-medium text-gray-700 mb-1">Número do Celular:</label>
                    <input type="text" name="telefone" id="telefone"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                        placeholder="91999999999"
                        required>

                    <label for="senha" class="block text-sm font-medium text-gray-700 mb-1">Senha:</label>
                    <input type="password" name="senha" id="senha"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                        required>

                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors">
                        Entrar
                    </button>
                </form>

                <div class="mt-6 text-center text-sm text-gray-600">
                    Não tem conta?
                    <a href="#" class="text-indigo-600 hover:text-indigo-500 font-medium">Entre em contato com a diretoria.</a>
                </div>
            </div>
        </div>
    </main>
</body>

</html>