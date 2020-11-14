<?php require 'init.php';
$user = $user ? $user : false;
if ($user && !empty($user)) {
$page  = 'users';
$title = 'تعديل بيانات <span class="text-primary">(' . $user['fullname'] . ')</span>';
$link = ['title' => 'عرض المستخدمين', 'url' => 'users.php', 'icon' => 'primary'];
// die(var_dump($user));
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $operation  = param('operation');
    $fullname   = param('fullname');
    $username   = param('username');
    $id    = (int) param('id');
    $group_id   = (int) param('group_id');
    $password   = param('password');
    // die(var_dump([['fullname' => $fullname, 'username' => $username, 'group_id' => $group_id], $id]));
    $confirm    = param('confirm');
    if ($operation === 'change-password') {
        if($password === $confirm && !empty($password)) {
            if (updateUser(['password' => filterPW($password)], $id)) {
                flash("alert-success", "تم تغيير كلمة المرور بنجاح.");
                back();
            }else {
                flash("alert-danger", "حدث خطأ اثناء حفظ التعديلات يرجى المحاولة مرة اخرى.");
                back();       
          }
        }else{
            flash("alert-danger", "كلمتي المرور غير متتطابقتين يرجى المحاولة مرة اخرى");
            back();
        }
    }elseif ($operation === 'edit-user') {
        if (updateUser(['fullname' => $fullname, 'username' => $username, 'group_id' => $group_id], $id)) {
            flash("alert-success", "تم حفظ التعديلات بنجاح.");
            back();
        }else {
            flash("alert-danger", "حدث خطأ اثناء حفظ التعديلات يرجى المحاولة مرة اخرى.");
            back();       
        }
    }
}
include "includes/layout/header.php"; ?>

<div class="col-md-6">
    <div class="panel">
        <div class="panel-header">
            <h4 class="title">
                <i class="fa fa-key"></i>
                تغيير كلمة السر
            </h4>
        </div>
        <div class="panel-body">
            <form class="box submit-form" action="" style="margin-top: 0px;" method="POST">
                <div class="form-group clearfix">
                    <label>كلمة المرور الجديدة:</label>
                    <input name="password" class="form-control border-input" type="password" placeholder="كلمة المرور الجديدة">
                </div>
                <div class="form-group clearfix">
                    <label>تأكيد كلمة المرور:</label>
                    <input name="confirm" class="form-control border-input" type="password" placeholder="كلمة المرور مرة اخرى">
                </div>
                <div class="form-group">
                    <input type="hidden" name="operation" value="change-password">
                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                    <div class="text-center">
                        <button type="submit" class="btn btn-gradient-primary btn-sm">حفظ التعديلات</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include "includes/layout/footer.php"; 
}else{redirect('index.php');}
?>  