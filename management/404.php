<?php require 'init.php'; ?>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php if (isset($title)) {echo $title;} else{echo "هيئة سكك حديد السودان | لوحة التحكم";}?></title>
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
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center text-center error-page bg-primary">
          <div class="row flex-grow">
            <div class="col-lg-7 mx-auto text-white">
              <div class="row align-items-center d-flex flex-row">
                <div class="col-lg-6 text-lg-right pr-lg-4">
                  <h1 class="display-1 mb-0">404</h1>
                </div>
                <div class="col-lg-6 error-page-divider text-lg-right pl-lg-4">
                  <h2>عذرا!</h2>
                  <h3 class="font-weight-light"><?= param('message') ? param('message') : 'الصفحة غير موجودة' ?>.</h3>
                </div>
              </div>
              <div class="row mt-5">
                <div class="col-12 text-center mt-xl-2">
                  <button class="btn btn-gradient-primary font-weight-medium goback">
                      <i class="mdi mdi-back"></i>
                      <span>رجوع</span>
                  </button>
                </div>
              </div>
              <div class="row mt-5">
                <div class="col-12 mt-xl-2">
                  <p class="text-white font-weight-medium text-center"></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <script src="<?= source('dashboard/js/vendor.bundle.base.js') ?>"></script>
    <!-- endinject -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <!-- <script src="<?= source('dashboard/js/off-canvas.js') ?>"></script>
    <script src="<?= source('dashboard/js/hoverable-collapse.js') ?>"></script>
    <script src="<?= source('dashboard/js/misc.js') ?>"></script> -->
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- <script src="<?= source('dashboard/js/dashboard.js') ?>"></script> -->
    <script src="<?= source('js/scripts.js') ?>"></script>
    <!-- End custom js for this page -->
</body>
</html>