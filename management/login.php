<?php 
require 'includes/config.php';
$title = 'تسجيل الدخول';
if (userLogedIn() !== true) {
	if ($_SERVER['REQUEST_METHOD'] === "POST") {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$user = userBy(['username' => $username], null, 1)[0];
		// die(var_dump($user['active']));
        if ($user) {
            if($user['password'] === filterPW($password)) {
                flash("alert-success", "مرحبا بك " . $user['username'] . " تم تسجيل دخولك بنجاح :)", "success");
                $_SESSION['username'] = $user['username'];
                $_SESSION['id'] = $user['id'];
                $_SESSION['type'] = $user['type'];
                header("Location: index.php");
                exit;
            }else{
                flash("alert-danger", "كلمة المرور غير صحيحة يرجى المحاولة مرة اخرى");
                header("Location: login.php");
                exit;
            }
        }else{
            flash("alert-danger", "إسم المستخدم غير صحيح يرجى المحاولة مرة اخرى");
            header("Location: login.php");
            exit;

        }
	}?>
<!doctype html>
<html lang="ar" class="fullscreen-bg">

<head>
    <title>تسجيل الدخول | <?= APP_NAME ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="<?= source('node_modules/@mdi/font/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= source('dashboard/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= source('node_modules/@fortawesome/fontawesome-free/css/all.min.css') ?>" />
    <link rel="stylesheet" href="<?= source('node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') ?>">
    <link rel="stylesheet" href="<?= source('dashboard/css/style.css') ?>">
    <link rel="apple-touch-icon" href="<?= source('images/favicons/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" href="<?= source('images/favicons/favicon-32x32.png') ?>" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?= source('images/favicons/favicon-16x16.png') ?>" sizes="16x16" />
    <link rel='stylesheet' type='text/css' href='<?= plugin(' sweetalert2/sweetalert2.min.css ') ?>'>
    <link rel='stylesheet' type='text/css' href='<?= plugin(' parsleyjs/parsley.css ') ?>'>

    <style>
        .logo{
            display: block;
            margin: auto;
            max-height: 200px;
        }
    </style>
</head>

<body class="rtl">
    <form action="" method="post">
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-right p-5">
                            <div class="brand-logo">
                                <img class="logo" src="<?= source('images/logo.png') ?>">
                            </div>
                            <h4>مرحبا بك في هيئة سكك حديد السودان</h4>
                            <h6 class="font-weight-light">تسجيل الدخول.</h6>
                            <form class="pt-3">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg" id="username" name="username" required placeholder="إسم المسخدم">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-lg" id="password" name="password" required placeholder="كلمة المرور">
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                                    <span>دخول</span>
                                </button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
    </form>
    <script type='text/javascript' src='src\js\jquery-1.12.3.min.js'></script>
	<script type='text/javascript' src='src\js\bootstrap.min.js'></script>
    <script src="<?= plugin('sweetalert2/sweetalert2.all.min.js') ?>"></script>
	<script src="<?= plugin('parsleyjs/parsley.js') ?>"></script>
	<script src="<?= plugin('parsleyjs/i18n/ar.js') ?>"></script>
    <?php layout('alerts') ?>
    <script>
        $(function(){
			$('form').parsley();
            $(document).on('click', '*[data-toggle=confirm]', function(e){
                e.preventDefault()
                let that = $(this);
                let title = that.data('title') ? that.data('title') : 'حذف';
                let text = that.data('text') ? that.data('text') : 'تأكيد الحذف';
                let icon = that.data('icon') ? that.data('icon') : 'warning';
                Swal.fire({
                    title: title,
                    text: text,
                    icon: icon,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'إلغاء',
                    confirmButtonText: 'تأكيد',
                }).then((result) => {
                    if (result.value) {
                        var href_attr = $(this).attr('href');
                        if(that.prop("tagName").toLowerCase() == 'a' && (typeof href_attr !== typeof undefined && href_attr !== false)){
                            window.location.href = href_attr;
                        }
                        else if(that.data('callback')){
                            executeFunctionByName(that.data('callback'), window)
                        }
                        else if(that.data('form')){
                            $(that.data('form')).submit()
                        }
                        else{
                            that.closest('form').submit()
                        }
                    }	
                })
            })
        })
        function sweet(title, text, icon = 'info'){
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'حسنا',
            })
        }
    </script>
</body>

</html>

<?php }else {
    header("Location: index.php");
    exit;
}
?>