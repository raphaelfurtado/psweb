<?php
// Inclua o componente de menu
include 'menu.php';

$role = session('user_role');

?>

<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PSWEB | <?php echo $titulo ?></title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?php echo base_url('admin'); ?>/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url('admin'); ?>/vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="<?php echo base_url('admin'); ?>/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?php echo base_url('admin'); ?>/css/style.css">
    <!-- endinject -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.0/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.css">

    <link rel="shortcut icon" href="<?php echo base_url('admin'); ?>/images/favicon.png" />

    <style>
        .buttons-container {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
            margin-top: 10px;
            /* Espaço entre botões e paginação */
        }

        .pagination-container {
            display: flex;
            justify-content: right;
        }
    </style>
</head>

<body>
    <div class="container-scroller">

        <?php echo $this->include('template/header', ['titulo' => $titulo]); ?>
        <?php echo $this->include('template/topbar'); ?>

        <?php renderMenu($role); ?>