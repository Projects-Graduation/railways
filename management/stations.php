<?php require 'init.php';
$_SESSION['page']   = 'stations';
$title  = 'قائمة المحطات';
$stations 	= allStations(['created_at', 'DESC']);
// $addons=['datatables'];
// Operations script
$operation = param('operation') ? param('operation') : false;
$station_id = param('station_id') && is_numeric(param('station_id')) ? param('station_id') : false;
// die(var_dump($stations));

$editstation = $station_id ? getStation($station_id) : false;
if ($operation) {
    if ($operation === 'delete') {
        $station = getStation($station_id);
        if (deleteStation($station_id)) {
            $old_image_path = IMAGES_DIR . DS . $station['image'];
            if (file_exists($old_image_path)) {
                unlink($old_image_path);
            }
            flash("alert-success", "تمت حذف المحطة بنجاح.");
            header("Location: stations.php");
            exit;
        }else{
            flash("alert-danger", "عذرا حدث خطأ اثناء عملية الحذف يرجى المحاولة مرة اخرى.");
            header("Location: stations.php");
            exit;
        }
    }elseif ($operation === 'add-station') {
        $data = [];
        $image = param('image');
        $data['name'] = param('name');
        $data['description'] = param('description');
        $icon = param('icon');
        if($icon) $data['icon'] = $icon;
        $prev = param('prev') ? param('prev') : $_SERVER['HTTP_REFERER'];
        if(!empty($image['name'])){
            $image_extension = pathinfo(param('image')['name'], PATHINFO_EXTENSION);
            $image_name = 'station-' . date('ymdhis') . rand(10, 100) . '.' . $image_extension;
            $image_path = IMAGES_DIR . DS . $image_name;
            if (move_uploaded_file($image['tmp_name'], $image_path)) {
                $data['image'] = $image_name;
            }
        }
        if (addStation($data)) {
            flash("alert-success", "تمت إضافة المحطة  بنجاح.");
        }else {
            flash("alert-danger", "حدث خطأ اثناء حفظ التعديلات يرجى المحاولة مرة اخرى.");
        }
        $prev = param('prev') ? param('prev') : $_SERVER['HTTP_REFERER'];
        header("Location: " . $prev);
        exit;
    }elseif ($operation === 'edit-station') {
        $data = [];
        $name = param('name');
        $description = param('description');
        $image = param('image');
        $old_image = param('old_image');
        if($name) $data['name'] = $name;
        if($description) $data['description'] = $description;
        if($icon) $data['icon'] = $icon;
        if(!empty($image['name'])){
            $image_extension = pathinfo(param('image')['name'], PATHINFO_EXTENSION);
            $image_name = 'station-' . date('ymdhis') . rand(10, 100) . '.' . $image_extension;
            $image_path = IMAGES_DIR . DS . $image_name;
            if ($old_image) {
                $old_image_path = IMAGES_DIR . DS . $old_image;
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            }
            if (move_uploaded_file($image['tmp_name'], $image_path)) {
                $data['image'] = $image_name;
            }
        }
        if (updateStation($data, $station_id)) {
            flash("alert-success", "تم تعديل بيانات المحطة (" . getStation($station_id)['name'] . ") بنجاح.");
        }else {
            flash("alert-danger", "حدث خطأ اثناء حفظ التعديلات يرجى المحاولة مرة اخرى.");
        }
        $prev = param('prev') ? param('prev') : $_SERVER['HTTP_REFERER'];
        header("Location: " . $prev);
        exit;
    }
}


include "includes/layout/header.php"; ?>
  <div class="col-md-12">
    <div class="card">
      <div class="card-header clearfix">
        <h4 class="card-heading">
			<i class="fa fa-list"></i>
			<span>القائمة</span>
		</h4>
      </div>
      <div class="card-body">
			<div class="row">
			<div class="table-sorter-wrapper col-lg-12 table-responsive">
				<table class="table table-striped table-sorted">
					<thead>
						<tr>
							<th class="sortStyle descStyle" style="width: 60px">المعرف<i class="mdi mdi-chevron-down"></th>
							<th class="sortStyle descStyle">الإسم<i class="mdi mdi-chevron-down"></th>
							<th class="sortStyle descStyle">تاريخ الإنشاء<i class="mdi mdi-chevron-down"></th>
							<th>العمليات</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($stations as $data): $station = station($data); ?>
							<tr>
								<td><?= $station['id'] ?></td>
								<td><?= $station['name'] ?></td>
								<td><?= date("Y-m-d", strtotime($station['created_at'])) ?></td>
								<td>
									<a href="station.php?station_id=<?= $station['id'] ?>" class="btn btn-xs btn-info">
										<span>عرض</span>
									</a>
									<a href="<?= actionUrl('station.php', ['station_id', $station['id']], 'edit') ?>" class="btn btn-xs btn-warning">
										تعديل
									</a>
									<a href="<?= actionUrl('stations.php', ['station_id', $station['id']], 'delete') ?>" class="btn btn-xs btn-danger confirm">
										حذف
									</a>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
      </div>
    </div>
  </div>
  <?php include "includes/layout/footer.php"; ?>