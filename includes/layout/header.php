<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="apple-touch-icon" href="<?= source('images/favicons/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" href="<?= source('images/favicons/favicon-32x32.png') ?>" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?= source('images/favicons/favicon-16x16.png') ?>" sizes="16x16" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= APP_NAME ?> <?= isset($title) ?  ' | ' . $title : "" ?></title>
	<link rel="stylesheet" href="<?= source('node_modules/@mdi/font/css/materialdesignicons.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= source('website/css/bootstrap.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= source('website/fonts/fonts.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= source('website/css/font-awesome.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= source('website/css/app.css') ?>">
	<!-- Start Datepicker required css files -->
    <link rel="stylesheet" type="text/css" href="<?= source('website/css/themes/default.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= source('website/css/themes/default.date.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= source('website/css/themes/default.time.css') ?>">
	<!-- End Datepicker required css files -->
	<style>
		table.table.table-vm th, table.table.table-vm td{
			vertical-align: middle;
		}
		th, td{
			text-align: right;
		}
		.off-white{
			background-color: #f9f9f9;
		}

	</style>
</head>
<body>
	<!-- Start Header -->
	<header id="header">
		<nav>
			<div class="container">
				<div class="col-md-2">
					<a href="<?= page('index') ?>" class="logo">
						<img src="<?= source('images/logo.png') ?>" alt="logo" id="logo">
					</a>
				</div>
				<div class="col-md-10">
					<div class="col-md-12">
						<div class="col-md-4 pull-left">
							<ul class="top-menu">
								<li class="col-md-4 reset"><a href="<?= page('support') ?>">الدعم</a></li>
								<li class="col-md-4 reset dropdown">
									<a id="ticket"  href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
										التذاكر <span class="fa fa-fw fa-caret-down"></span>
									</a>
									<ol class="dropdown-menu" aria-labelledby="ticket">
										<li><a href="<?= page('travels') ?>?operation=add">إضافة تذكرة</a></li>
										<li><a href="<?= page('ticket') ?>">بحث عن تذكرة</a></li>
									</ol>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-md-12">
						<ul class="menu">
							<li><a href="<?= page('index') ?>" class="<?= $_SESSION['page'] == 'index' ? 'selected' : '' ?>"><span class="fa fa-fw fa-home"></span> الرئيسية</a></li>
							<li><a href="<?= page('ticket') ?>" class="<?= $_SESSION['page'] == 'ticket' ? 'selected' : '' ?>"><span class="fa fa-fw fa-check-square-o"></span> التذاكر</a></li>
							<li><a href="<?= page('travels') ?>" class="<?= $_SESSION['page'] == 'travels' ? 'selected' : '' ?>"><span class="fa fa-fw fa-ticket"></span> الرحلات</a></li>
							<!-- <li><a href="<?= page('buses') ?>" class="<?= $_SESSION['page'] == 'buses' ? 'selected' : '' ?>"><span class="fa fa-fw fa-bus"></span> شركات البصات</a></li> -->
						</ul>
					</div>
				</div>
			</div>
		</nav>
	</header>
	<!-- End Header -->
	<!-- Start Content -->
	<section id="content">
		<div class="container">