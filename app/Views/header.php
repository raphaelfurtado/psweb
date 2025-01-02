<?php
// Inclua o componente de menu
include 'menu.php';

$role = session('user_role');

?>

<html>

<head>
    <title>Painel do Usuário</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href=<?= base_url('css/dataTables.tailwindcss.css')?> rel="stylesheet"/>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1D4ED8',
                        secondary: '#9333EA',
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                },
            },
        }
    </script>
</head>

<body class="flex flex-col min-h-screen bg-gray-50 text-gray-800 font-sans">


    <?php renderMenu($role); ?>
    <main class="flex-grow p-4">
        <div class="container mx-auto">