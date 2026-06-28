<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Prime Parking Authentication">
    <meta name="author" content="">

    <title>Prime Parking - Authentication</title>

    <link href="<?= base_url('vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="<?= base_url('css/sb-admin-2.min.css') ?>" rel="stylesheet">
    
    <style>
        .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
            background-color: #1c1c1c !important;
            border-color: #1c1c1c !important;
        }
        .form-control-user:focus {
            border-color: #1c1c1c !important;
            box-shadow: 0 0 0 0.2rem rgba(28, 28, 28, 0.25) !important;
        }
    </style>
</head>

<body class="bg-dark">

    <?= $this->renderSection('content'); ?>

    <script src="<?= base_url('vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <script src="<?= base_url('vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

    <script src="<?= base_url('js/sb-admin-2.min.js') ?>"></script>
</body>

</html>