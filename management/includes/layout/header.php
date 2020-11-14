<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= APP_NAME ?> <?= isset($title) ?  ' | ' . $title : "" ?></title>
	<link rel="stylesheet" href="<?= source('node_modules/@mdi/font/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= source('dashboard/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= source('node_modules/@fortawesome/fontawesome-free/css/all.min.css') ?>" />
    <link rel="stylesheet" href="<?= source('node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') ?>">
    <link rel="stylesheet" href="<?= source('dashboard/css/style.css') ?>">
    <link rel="stylesheet" href="<?= source('dashboard/css/custom.css') ?>">
    <link rel="apple-touch-icon" href="<?= source('images/favicons/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" href="<?= source('images/favicons/favicon-32x32.png') ?>" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?= source('images/favicons/favicon-16x16.png') ?>" sizes="16x16" />
    <link rel='stylesheet' type='text/css' href='<?= plugin('sweetalert2/sweetalert2.min.css ') ?>'>
    <link rel='stylesheet' type='text/css' href='<?= plugin('parsleyjs/parsley.css ') ?>'>
    <style>
        .card{width: 100%;}
    </style>
</head>

<body class="rtl">
	<div class="container-scroller">
		<!-- navbar starts here -->
		<?php layout('navbar'); ?>
        <!-- ends here -->
        <div class="container-fluid page-body-wrapper">
		<!-- sidebar starts here -->
		<?php layout('side-menu'); ?>
        <!-- ends here -->
        <div class="main-panel">
            <div class="content-wrapper">
				<div class="page-header">
					<h3 class="page-title"><?= isset($title) ? $title : '' ?></h3>
				</div>
				<div class="page-content">