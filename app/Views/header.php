<?php
// Inclua o componente de menu
include 'menu.php';

$role = session('user_role');

?>

<html>

<head>
    <title>
        <?php echo $titulo; ?>
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
</head>

<body class="flex flex-col min-h-screen bg-gray-100 text-gray-900">
    
    <?php renderMenu($role); ?>
    <main class="flex-grow p-4">