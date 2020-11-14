<?php require 'init.php';
$_SESSION['page']  = 'users';
$title = 'إضافة مستخدم';
$link = ['title' => 'عرض المستخدمين', 'url' => 'users.php', 'icon' => 'primary'];
if ($_SERVER['REQUEST_METHOD'] === "POST") {
	$username = param('username');
    $password = param('password');
    $confirm = param('confirm');
	// $user = userBy(['username' => $username], null, 1)[0];
	// die(var_dump($user['active']));
    if($password === $confirm && !empty($password)) {
    	if (addUser(['username' => $username, 'password' => filterPW($password)])) {
	        flash("alert-success", "تمت إضافة المستخدم بنجاح.");
	        header("Location: users.php");
	        exit;
    	}else {
	        flash("alert-danger", "حدث خطأ اثناء حفظ التعديلات يرجى المحاولة مرة اخرى.");
	        header("Location: add-user.php?fullname=" . param('fullname') . "&username=" . param('username'));
	        exit;    	
        }
    }else{
        flash("alert-danger", "كلمتي المرور غير متتطابقتين يرجى المحاولة مرة اخرى");
        header("Location: add-user.php?fullname=" . param('fullname') . "&username=" . param('username'));
        exit;
    }
}
include "includes/layout/header.php"; ?>
<form action="" method="post">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">بيانات المستخدم</h4>
            <div class="form-group row">
                <div class="col-lg-4">
                    <label for="username">إسم المستخدم:</label>
                </div>
                <div class="col-lg-8">
                    <input id="username" name="username" class="form-control border-input" type="text" required placeholder="المستخدم">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>كلمة المرور الجديدة:</label>
                </div>
                <div class="col-lg-8">
                    <input name="password" required id="password" class="form-control border-input" type="password" placeholder="كلمة المرور الجديدة">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>تأكيد كلمة المرور:</label>
                </div>
                <div class="col-lg-8">
                    <input name="confirm" required id="confirm" class="form-control border-input" data-parsley-equalto="#password" type="password" placeholder="كلمة المرور مرة اخرى">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-4"></div>
                <div class="col-lg-8">
                    <button type="submit" class="btn btn-gradient-primary btn-block">حفظ</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php include "includes/layout/footer.php"; ?>	