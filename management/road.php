<?php require 'init.php';
// $addons=['datatables'];
$operation = param('operation') ? param('operation') : 'add';
$road_id = isset($_GET['road_id']) && !empty($_GET['road_id']) && is_numeric($_GET['road_id']) ? $_GET['road_id'] : false;
$operation = $operation == 'add' && $road_id ? 'show' : $operation;

$road = $road_id ? getRoad($road_id) : false;
$_SESSSION['page']   = 'road';
$title  = $road_id ? 'خط ' . $road['name'] : 'إضافة خط';
$title = $operation == 'edit' ? 'تعديل خط ' . $road['name'] : $title;
$link = ['title' => 'خط', 'url' => 'roads.php', 'icon' => 'success'];
$roadStations     = roadStations($road_id, ['created_at', 'DESC']);
$roadCities     = roadCities($road_id, ['created_at', 'DESC']);
// dd($roadCities);

include "includes/layout/header.php"; ?>
<?php if($operation == 'add'):?>
	<form action="roads.php?operation=add-road" method="post" enctype="multipart/form-data">
        <div class="card">
            <h4 class="card-header">
                <span class="fa fa-fw fa-lg fa-list"></span>
                بيانات الخط
            </h4>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-4">
                        <label   class="boxy boxy-left boxy-sm" for="title">إسم الخط: </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="name" required class="form-control" id="name" placeholder="اكتب اسم الخط هنا">
                    </div>
                </div>
                <div class="form-group row">
                    <h4>المحطات</h4>
                    <table id="stations-table" class="table table-striped table-sorted">
                        <thead>
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>المدينة</th>
                                <th>الإسم</th>
                                <th>الوصف</th>
                                <th>الصورة</th>
                                <th style="width: 60px;"><i class="fa fa-times"></i></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th><i class="fa fa-plus"></i></th>
                                <th colspan="4"></th>
                                <th>
                                    <button type="button" class="btn btn-gradient-primary btn-xs btn-add-station">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="form-group">
                    <input type="hidden" name="operation" value="add-road">
                    <button type="submit" class="btn btn-gradient-primary">
                        <i class="fa fa-fw fa-plus"></i>
                        <span>إضافة</span> 
                    </button>
                    <button class="btn btn-gradient-secondary goback">إلغاء</button>
                </div>
            </div>
        </div>
	</form>
<?php elseif($operation == 'edit' && $road):?>
    <form action="roads.php?operation=edit-road" method="post">
        <div class="card">
            <h4 class="card-header">
                <span class="fa fa-fw fa-lg fa-list"></span>
                بيانات الخط
            </h4>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-4">
                        <label   class="boxy boxy-left boxy-sm" for="title">إسم الخط: </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="name" required class="form-control" value="<?= array_key_exists('name', $road) ? $road['name'] : '' ?>" id="name" placeholder="اكتب اسم الخط هنا">
                    </div>
                </div>
                <div class="form-group row">
                    <h4>المحطات</h4>
                    <table id="stations-table" class="table table-striped table-sorted">
                        <thead>
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>المدينة</th>
                                <th>الإسم</th>
                                <th>الوصف</th>
                                <th>الصورة</th>
                                <th style="width: 60px;"><i class="fa fa-times"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $counter = 1; ?>
                            <?php foreach($roadStations as $station):?>
                                <tr>
                                    <td><?= $counter++ ?></td>
                                    <td>
                                        <select name="stations_cities[]" class="form-control">
                                            <?php foreach(allCities() as $city):?>
                                                <option value="<?= $city['id'] ?>" <?= $city['id'] == $station['city_id']  ? 'selected' : '' ?>><?= $city['name'] ?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="stations_names[]" value="<?= $station['name'] ?>" placeholder="إسم المحطة"></td>
                                    <td><input type="text" class="form-control" name="stations_descriptions[]" value="<?= $station['description'] ?>" placeholder="وصف المحطة"></td>
                                    <td><input type="file" class="form-control" name="stations_images[]"></td>
                                    <td>
                                        <button type="button" class="btn btn-gradient-danger btn-xs btn-remove-station">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><i class="fa fa-plus"></i></th>
                                <th colspan="4"></th>
                                <th>
                                    <button type="button" class="btn btn-gradient-primary btn-xs btn-add-station">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="form-group">
                    <input type="hidden" name="operation" value="edit-road">
                    <input type="hidden" name="road_id" value="<?= $road['id'] ?>">
                    <input type="hidden" name="old_image" value="<?= $road['image'] ?>">
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
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-heading">
                        <i class="fa fa-list"></i>
                        <span>خط <?= $road['name'] ?></span>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="">
                        <table class="table table-striped table-hover">
                            <tbody>
                                <tr>
                                    <th style="width: 120px;">المعرف</th>
                                    <td><?= $road['id'] ?></td>
                                </tr>
                                <tr>
                                    <th>تاريخ الإنشاء</th>
                                    <td><?= date("Y-m-d", strtotime($road['created_at'])) ?></td>
                                </tr>
                                <tr>
                                    <th>الخيارات</th>
                                    <td>
                                        <a href="road.php?road_id=<?= $road['id'] ?>&operation=edit" class="btn btn-info">
                                            <span>تعديل</span>
                                        </a>
                                        <a href="<?= actionUrl('roads.php', ['road_id', $road['id']], 'delete') ?>" class="btn btn-danger" data-toggle="confirm">
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
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header clearfix">
                    <h4 class="reset float-right">
                        <i class="fa fa-th-large"></i>
                        <span>المحطات</span>
                    </h4>
                    <div class="float-left">
                        <a href="station.php?road_id=<?= $road['id'] ?>" class="btn btn-gradient-primary btn-xs">
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
                                <th>المدينة</th>
                                <th class="col-md-3">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($roadStations as $data): $station = station($data); ?>
                                <tr>
                                    <td><?= $station['name'] ?></td>
                                    <td><?= $station['city_link'] ?></td>
                                    <td style="width: 190px;">
                                        <!-- <a href="station.php?station_id=<?= $station['id'] ?>" class="btn btn-xs btn-info">
                                            عرض
                                        </a>
                                        <a href="add-station.php?station_id=<?= $station['id'] ?>" class="btn btn-xs btn-warning">
                                            تعديل
                                        </a> -->
                                        <a href="<?= actionUrl('stations.php', ['station_id', $station['id']], 'delete') ?>" class="btn btn-xs btn-danger confirm">
                                            حذف
                                        </a>
                                    </td>
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
        $('.btn-add-station').click(function(){
            let tbody = $('#stations-table tbody')
            let rows = $('#stations-table tbody tr')
            let row = `
                <tr>
                    <td>` + (rows.length + 1) + `</td>
                    <td>
                        <select name="stations_cities[]" class="form-control">
                            <?php foreach(allCities() as $city):?>
                                <option value="<?= $city['id'] ?>"><?= $city['name'] ?></option>
                            <?php endforeach;?>
                        </select>
                    </td>
                    <td><input type="text" class="form-control" name="stations_names[]" placeholder="إسم المحطة"></td>
                    <td><input type="text" class="form-control" name="stations_descriptions[]" placeholder="وصف المحطة"></td>
                    <td><input type="file" class="form-control" name="stations_images[]"></td>
                    <td>
                        <button type="button" class="btn btn-gradient-danger btn-xs btn-remove-station">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                </tr>
            `
            tbody.append(row)
        })
        $(document).on('click', '.btn-remove-station', function(){
            $(this).closest('tr').remove()
            stationsTableCount()
        })
    })
    function stationsTableCount()
    {
        let tds = $('#stations-table tbody tr td:first-child')
        for (let index = 0; index < tds.length; index++) {
            const td = $(tds[index]);
            $(td).text((index + 1))
        }
        
    }
</script>
<?php include "includes/layout/footer_close.php"; ?>