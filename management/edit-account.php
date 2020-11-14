<?php require 'init.php';
$user = $user ? $user : false;
if ($user && !empty($user)) {
$page  = 'users';
$title = 'الحساب'; 
$link = ['title' => 'عرض المستخدمين', 'url' => 'users.php', 'icon' => 'primary'];
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = [];
    $data['username'] = param('username');
    $password   = param('password');
    $confirm    = param('confirm');
    if ($password) {
        $data['password'] = filterPW($password);
    }
    // dd([$data, (($password == $confirm) && ($password && $confirm))]);
    if((($password == $confirm) && ($password && $confirm))) {
        if (updateUser($data, $user['id'])) {
            flash("alert-success", "تم حفظ التعديلات بنجاح.");
            back();
        }else {
            flash("alert-danger", "حدث خطأ اثناء حفظ التعديلات يرجى المحاولة مرة اخرى.");
            back();       
      }
    }else{
        flash("alert-danger", "كلمتي المرور غير متتطابقتين يرجى المحاولة مرة اخرى");
        back();
    }
}
include "includes/layout/header.php"; ?>
<form action="" method="post">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">تعديل</h4>
            <div class="form-group row">
                <div class="col-lg-4">
                    <label for="username">إسم المستخدم:</label>
                </div>
                <div class="col-lg-8">
                    <input id="username" name="username" value="<?= $user['username'] ?>" class="form-control border-input" type="text" required placeholder="المستخدم">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>كلمة المرور الجديدة:</label>
                </div>
                <div class="col-lg-8">
                    <input name="password" id="password" class="form-control border-input" type="password" placeholder="كلمة المرور الجديدة">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>تأكيد كلمة المرور:</label>
                </div>
                <div class="col-lg-8">
                    <input name="confirm" id="confirm" class="form-control border-input" data-parsley-equalto="#password" type="password" placeholder="كلمة المرور مرة اخرى">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-4"></div>
                <div class="col-lg-8">
                    <button type="submit" class="btn btn-gradient-primary btn-block">حفظ التعديلات</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php include "includes/layout/footer.php"; 
}else{redirect('index.php');}
?>  