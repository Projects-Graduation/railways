<?php require 'init.php';
// $addons=['datatables'];
$operation = param('operation') ? param('operation') : 'add';
$city_id = isset($_GET['city_id']) && !empty($_GET['city_id']) && is_numeric($_GET['city_id']) ? $_GET['city_id'] : false;
$operation = $operation == 'add' && $city_id ? 'show' : $operation;

$city = $city_id ? getCity($city_id) : false;
$_SESSSION['page']   = 'city';
$title  = $city_id ? 'مدينة ' . $city['name'] : 'إضافة مدينة';
$title = $operation == 'edit' ? 'تعديل مدينة ' . $city['name'] : $title;
$link = ['title' => 'مدينة', 'url' => 'cities.php', 'icon' => 'success'];
$cityStations     = cityStations($city_id, ['created_at', 'DESC']);


include "includes/layout/header.php"; ?>
<?php if($operation == 'add'):?>
	<form action="cities.php?operation=add-city" method="post">
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
                        بيانات المدينة
                    </h4>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label   class="boxy boxy-left boxy-sm" for="title">إسم المدينة: </label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="name" required class="form-control" id="name" placeholder="اكتب اسم المدينة هنا">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="description"  class="boxy boxy-left boxy-sm">وصف للمدينة: </label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="description" required class="form-control" id="description" placeholder="اكتب وصف للمدينة هنا">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="operation" value="add-city">
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
<?php elseif($operation == 'edit' && $city):?>
    <form action="cities.php?operation=edit-city" method="post">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <div class="image-wrapper">
                        <div class="image-previewer" style="background-image: url(<?= $city['image_url'] ?>);"></div>
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
                        بيانات المدينة
                    </h4>
                    <div class="card-body">
                        <div class="form-group clearfix">
                            <div class="col-md-4">
                                <label   class="boxy boxy-left boxy-sm" for="title">إسم المدينة: </label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="name" value="<?= array_key_exists('name', $city) ? $city['name'] : '' ?>" required class="form-control" id="name" placeholder="اكتب اسم المدينة هنا">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-md-4">
                                <label for="description"  class="boxy boxy-left boxy-sm">وصف للمدينة: </label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="description" value="<?= array_key_exists('description', $city) ? $city['description'] : '' ?>" required class="form-control" id="description" placeholder="اكتب وصف للمدينة هنا">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="operation" value="edit-city">
                            <input type="hidden" name="city_id" value="<?= $city['id'] ?>">
                            <input type="hidden" name="old_image" value="<?= $city['image'] ?>">
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
                    <div class="image-previewer" style="background-image: url(<?= $city['image_url'] ?>);"></div>
                    <label class="btn btn-gradient-primary">
                        <i class="fa fa-image"></i>
                        <span>تغيير الصورة</span>
                        <input type="file" id="image-input" name="image"/>
                    </label>
                </div>
                <input type="hidden" name="name" value="<?= $city['image'] ?>">
            </form>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-heading">
                        <i class="fa fa-list"></i>
                        <span>مدينة <?= $city['name'] ?></span>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="">
                        <table class="table table-striped table-hover">
                            <tbody>
                                <tr>
                                    <th style="width: 120px;">المعرف</th>
                                    <td><?= $city['id'] ?></td>
                                </tr>
                                <tr>
                                    <th>الوصف</th>
                                    <td><?= $city['description'] ?></td>
                                </tr>
                                <tr>
                                    <th>تاريخ الإنشاء</th>
                                    <td><?= date("Y-m-d", strtotime($city['created_at'])) ?></td>
                                </tr>
                                <tr>
                                    <th>الخيارات</th>
                                    <td>
                                        <a href="city.php?city_id=<?= $city['id'] ?>&operation=edit" class="btn btn-info">
                                            <span>تعديل</span>
                                        </a>
                                        <a href="<?= actionUrl('cities.php', ['city_id', $city['id']], 'delete') ?>" class="btn btn-danger" data-toggle="confirm">
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
    <div class="card">
        <div class="card-header clearfix">
            <h4 class="reset float-right">
                <i class="fa fa-th-large"></i>
                <span>المحطات</span>
            </h4>
            <div class="float-left">
                <a href="station.php?city_id=<?= $city['id'] ?>" class="btn btn-gradient-primary">
                    <i class="fa fa-plus"></i>
                    <span>اضافة محطة</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover table-condensed datatable">
                <thead>
                    <tr>
                        <th>الإسم</th>
                        <th>تاريخ الإضافة</th>
                        <th class="col-md-3">العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cityStations as $station): ?>
                        <tr>
                            <td><?= $station['title'] ?></td>
                            <td><?= date("Y-m-d", strtotime($station['created_at'])) ?></td>
                            <td style="width: 190px;">
                                <a href="station.php?station_id=<?= $station['id'] ?>" class="btn btn-xs btn-default">
                                    عرض
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="add-station.php?station_id=<?= $station['id'] ?>" class="btn btn-xs btn-info">
                                    تعديل
                                </a>
                                <!-- <a href="<?= actionUrl('stations.php', ['station_id', $station['id']], 'delete') ?>" class="btn btn-xs btn-danger confirm">
                                    حذف
                                </a> -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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