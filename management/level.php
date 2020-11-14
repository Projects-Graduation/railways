<?php require 'init.php';
// $addons=['datatables'];
$operation = param('operation') ? param('operation') : 'add';
$level_id = isset($_GET['level_id']) && !empty($_GET['level_id']) && is_numeric($_GET['level_id']) ? $_GET['level_id'] : false;
$operation = $operation == 'add' && $level_id ? 'show' : $operation;

$level = $level_id ? getLevel($level_id) : false;
$_SESSSION['page']   = 'level';
$title  = $level_id ? 'فئة ' . $level['name'] : 'إضافة فئة';
$title = $operation == 'edit' ? 'تعديل فئة ' . $level['name'] : $title;
$link = ['title' => 'فئة', 'url' => 'levels.php', 'icon' => 'success'];
include "includes/layout/header.php"; ?>
<?php if($operation == 'add'):?>
	<form action="levels.php?operation=add-level" method="post" enctype="multipart/form-data">
        <div class="card">
            <h4 class="card-header">
                <span class="fa fa-fw fa-lg fa-list"></span>
                بيانات الفئة
            </h4>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-4">
                        <label   class="boxy boxy-left boxy-sm" for="title">إسم الفئة: </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="name" required class="form-control" id="name" placeholder="اكتب اسم الفئة هنا">
                    </div>
                </div>
                <div class="form-group">
                    <input type="hidden" name="operation" value="add-level">
                    <button type="submit" class="btn btn-gradient-primary">
                        <i class="fa fa-fw fa-plus"></i>
                        <span>إضافة</span> 
                    </button>
                    <button class="btn btn-gradient-secondary goback">إلغاء</button>
                </div>
            </div>
        </div>
	</form>
<?php elseif($operation == 'edit' && $level):?>
    <form action="levels.php?operation=edit-level" method="post">
        <div class="card">
            <h4 class="card-header">
                <span class="fa fa-fw fa-lg fa-list"></span>
                بيانات الفئة
            </h4>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-4">
                        <label   class="boxy boxy-left boxy-sm" for="title">إسم الفئة: </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="name" required class="form-control" value="<?= array_key_exists('name', $level) ? $level['name'] : '' ?>" id="name" placeholder="اكتب اسم الفئة هنا">
                    </div>
                </div>
                <div class="form-group">
                    <input type="hidden" name="operation" value="edit-level">
                    <input type="hidden" name="level_id" value="<?= $level['id'] ?>">
                    <input type="hidden" name="old_image" value="<?= $level['image'] ?>">
                    <button type="submit" class="btn btn-gradient-primary">
                        <i class="fa fa-fw fa-save"></i>
                        <span>حفظ التعديلات</span> 
                    </button>
                    <button class="btn btn-gradient-secondary goback">إلغاء</button>
                </div>
            </div>
        </div>
	</form>
<?php else: ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-heading">
                        <i class="fa fa-list"></i>
                        <span>فئة <?= $level['name'] ?></span>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="">
                        <table class="table table-striped table-hover">
                            <tbody>
                                <tr>
                                    <th style="width: 120px;">المعرف</th>
                                    <td><?= $level['id'] ?></td>
                                </tr>
                                <tr>
                                    <th>تاريخ الإنشاء</th>
                                    <td><?= date("Y-m-d", strtotime($level['created_at'])) ?></td>
                                </tr>
                                <tr>
                                    <th>الخيارات</th>
                                    <td>
                                        <a href="level.php?level_id=<?= $level['id'] ?>&operation=edit" class="btn btn-info">
                                            <span>تعديل</span>
                                        </a>
                                        <a href="<?= actionUrl('levels.php', ['level_id', $level['id']], 'delete') ?>" class="btn btn-danger" data-toggle="confirm">
                                            <span>حذف</span>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>
<?php include "includes/layout/footer_open.php"; ?>
<script>
    $(function(){
    })
</script>
<?php include "includes/layout/footer_close.php"; ?>