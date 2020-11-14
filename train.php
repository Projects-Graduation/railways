<?php require 'init.php';
// $addons=['datatables'];
$operation = param('operation') ? param('operation') : 'add';
$train_id = isset($_GET['train_id']) && !empty($_GET['train_id']) && is_numeric($_GET['train_id']) ? $_GET['train_id'] : false;
$operation = $operation == 'add' && $train_id ? 'show' : $operation;

$train = $train_id ? train(getOrRedirect('trains', $train_id)) : false;
$_SESSSION['page']   = 'train';
$title  = $train_id ? 'قطار ' . $train['name'] : 'إضافة قطار';
$title = $operation == 'edit' ? 'تعديل قطار ' . $train['name'] : $title;
$link = ['title' => 'قطار', 'url' => 'trains.php', 'icon' => 'success'];
$trainLevels = trainLevels($train_id);


include "includes/layout/header.php"; ?>
<?php if($operation == 'add'):?>
	<form action="trains.php?operation=add-train" method="post">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <div class="image-wrapper">
                        <div class="image-previewer"></div>
                        <label class="btn btn-gradient-primary">
                            <i class="fa fa-image"></i>
                            <span>إختر الصورة</span>
                            <input type="file" name="image" />
                        </label>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <h4 class="card-header">
                        <span class="fa fa-fw fa-lg fa-list"></span>
                        بيانات القطار
                    </h4>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label   class="boxy boxy-left boxy-sm" for="title">إسم القطار: </label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="name" required class="form-control" id="name" placeholder="اكتب اسم القطار هنا">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="number"  class="boxy boxy-left boxy-sm">رقم للقطار: </label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" name="number" required class="form-control" id="number" placeholder="اكتب رقم للقطار هنا">
                            </div>
                        </div>
                        <div class="form-group">
                            <h4>الفئات</h4>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>عدد المقاعد</th>
                                        <th>سعر الذكرة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $counter = 0; foreach(allLevels() as $level):?>
                                        <tr>
                                            <td><?= ++$counter ?></td>
                                            <td><?= $level['name'] ?></td>
                                            <td>
                                                <input type="hidden" name="levels_ids[]" value="<?= $level['id'] ?>">
                                                <input type="number" class="form-control" name="levels_seats[]" value="0">
                                            </td>
                                            <td><input type="number" class="form-control" name="levels_prices[]" value="0"></td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="operation" value="add-train">
                            <button type="submit" class="btn btn-gradient-primary">
                                <i class="fa fa-fw fa-plus"></i>
                                <span>إضافة</span> 
                            </button>
                            <button class="btn btn-gradient-secondary goback">إلغاء</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</form>
<?php elseif($operation == 'edit' && $train):?>
    <form action="trains.php?operation=edit-train" method="post">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <div class="image-wrapper">
                        <div class="image-previewer" style="background-image: url(<?= $train['image_url'] ?>);"></div>
                        <label class="btn btn-gradient-primary">
                            <i class="fa fa-image"></i>
                            <span>إختر الصورة</span>
                            <input type="file" name="image" />
                        </label>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <h4 class="card-header">
                        <span class="fa fa-fw fa-lg fa-list"></span>
                        بيانات القطار
                    </h4>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label   class="boxy boxy-left boxy-sm" for="title">إسم القطار: </label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="name" value="<?= array_key_exists('name', $train) ? $train['name'] : '' ?>" required class="form-control" id="name" placeholder="اكتب اسم القطار هنا">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="number"  class="boxy boxy-left boxy-sm">رقم للقطار: </label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" name="number" value="<?= array_key_exists('number', $train) ? $train['number'] : '' ?>" required class="form-control" id="number" placeholder="اكتب رقم للقطار هنا">
                            </div>
                        </div>
                        <div class="form-group">
                            <h4>الفئات</h4>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>عدد المقاعد</th>
                                        <th>سعر الذكرة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $counter = 0; foreach(allLevels() as $level):?>
                                        <?php 
                                            $level_trains = where('level_train', ['level_id' => $level['id'], 'train_id' => $train['id']]); 
                                            $level_train = $level_trains ? $level_trains[0] : false;
                                        ?>
                                        <tr>
                                            <td><?= ++$counter ?></td>
                                            <td><?= $level['name'] ?></td>
                                            <td>
                                                <input type="hidden" name="levels_ids[]" value="<?= $level['id'] ?>">
                                                <input type="number" class="form-control" name="levels_seats[]" value="<?= $level_train ? $level_train['seats'] : 0 ?>">
                                            </td>
                                            <td><input type="number" class="form-control" name="levels_prices[]" value="<?= $level_train ? $level_train['ticket_price'] : 0 ?>"></td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="operation" value="edit-train">
                            <input type="hidden" name="train_id" value="<?= $train['id'] ?>">
                            <input type="hidden" name="old_image" value="<?= $train['image'] ?>">
                            <button type="submit" class="btn btn-gradient-primary">
                                <i class="fa fa-fw fa-save"></i>
                                <span>حفظ التعديلات</span> 
                            </button>
                            <button class="btn btn-gradient-secondary goback">إلغاء</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</form>
<?php else: ?>
    <div class="row mb-5">
        <div class="col-lg-4">
            <form id="change-image-form" action="?change-image" method="POST">
                <div class="image-wrapper">
                    <div class="image-previewer" style="background-image: url(<?= $train['image_url'] ?>);"></div>
                    <label class="btn btn-gradient-primary">
                        <i class="fa fa-image"></i>
                        <span>تغيير الصورة</span>
                        <input type="file" id="image-input" name="image"/>
                    </label>
                </div>
                <input type="hidden" name="name" value="<?= $train['image'] ?>">
            </form>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-heading">
                        <i class="fa fa-list"></i>
                        <span>قطار <?= $train['name'] ?></span>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="">
                        <table class="table table-striped table-hover">
                            <tbody>
                                <tr>
                                    <th style="width: 120px;">المعرف</th>
                                    <td><?= $train['id'] ?></td>
                                </tr>
                                <tr>
                                    <th>الرقم</th>
                                    <td><?= $train['number'] ?></td>
                                </tr>
                                <tr>
                                    <th>تاريخ الإنشاء</th>
                                    <td><?= date("Y-m-d", strtotime($train['created_at'])) ?></td>
                                </tr>
                                <tr>
                                    <th>الخيارات</th>
                                    <td>
                                        <a href="train.php?train_id=<?= $train['id'] ?>&operation=edit" class="btn btn-info">
                                            <span>تعديل</span>
                                        </a>
                                        <a href="<?= actionUrl('trains.php', ['train_id', $train['id']], 'delete') ?>" class="btn btn-danger" data-toggle="confirm">
                                            <span>حذف</span>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header clearfix">
                    <h4 class="reset float-right">
                        <i class="mdi mdi-sort-variant"></i>
                        <span>الفئات</span>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover table-condensed datatable">
                        <thead>
                            <tr>
                                <th>الإسم</th>
                                <th>عدد المقاعد</th>
                                <th>سعر التذكرة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($trainLevels as $level): ?>
                                <tr>
                                    <td><?= $level['level_name'] ?></td>
                                    <td><?= $level['seats'] ?></td>
                                    <td><?= number_format($level['ticket_price'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>
<?php include "includes/layout/footer_open.php"; ?>
<script>
    $(function(){
        $('.icon-label').click(function(){
            $('.icon-label').removeClass('active');
            $(this).addClass('active');
        })
    })
</script>
<?php include "includes/layout/footer_close.php"; ?>