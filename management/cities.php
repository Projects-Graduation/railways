<?php require 'init.php';
$_SESSION['page']   = 'cities';
$title  = 'قائمة المدن';
$cities 	= allCities(['created_at', 'DESC']);
// $addons=['datatables'];
// Operations script
$operation = param('operation') ? param('operation') : false;
$city_id = param('city_id') && is_numeric(param('city_id')) ? param('city_id') : false;
// die(var_dump($cities));

$editcity = $city_id ? getCity($city_id) : false;
if ($operation) {
    if ($operation === 'delete') {
        $city = getCity($city_id);
        if (deleteCity($city_id)) {
            $old_image_path = IMAGES_DIR . DS . $city['image'];
            if (file_exists($old_image_path)) {
                unlink($old_image_path);
            }
            flash("alert-success", "تمت حذف المدينة بنجاح.");
            header("Location: cities.php");
            exit;
        }else{
            flash("alert-danger", "عذرا حدث خطأ اثناء عملية الحذف يرجى المحاولة مرة اخرى.");
            header("Location: cities.php");
            exit;
        }
    }elseif ($operation === 'add-city') {
        $data = [];
        $image = param('image');
        $data['name'] = param('name');
        $data['description'] = param('description');
        $icon = param('icon');
        if($icon) $data['icon'] = $icon;
        $prev = param('prev') ? param('prev') : $_SERVER['HTTP_REFERER'];
        if(!empty($image['name'])){
            $image_extension = pathinfo(param('image')['name'], PATHINFO_EXTENSION);
            $image_name = 'city-' . date('ymdhis') . rand(10, 100) . '.' . $image_extension;
            $image_path = IMAGES_DIR . DS . $image_name;
            if (move_uploaded_file($image['tmp_name'], $image_path)) {
                $data['image'] = $image_name;
            }
        }
        if (addCity($data)) {
            flash("alert-success", "تمت إضافة المدينة  بنجاح.");
        }else {
            flash("alert-danger", "حدث خطأ اثناء حفظ التعديلات يرجى المحاولة مرة اخرى.");
        }
        $prev = param('prev') ? param('prev') : $_SERVER['HTTP_REFERER'];
        header("Location: " . $prev);
        exit;
    }elseif ($operation === 'edit-city') {
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
            $image_name = 'city-' . date('ymdhis') . rand(10, 100) . '.' . $image_extension;
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
        if (updateCity($data, $city_id)) {
            flash("alert-success", "تم تعديل بيانات المدينة (" . getCity($city_id)['name'] . ") بنجاح.");
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
						<?php foreach ($cities as $data): $city = city($data); ?>
							<tr>
								<td><?= $city['id'] ?></td>
								<td><?= $city['name'] ?></td>
								<td><?= date("Y-m-d", strtotime($city['created_at'])) ?></td>
								<td>
									<a href="city.php?city_id=<?= $city['id'] ?>" class="btn btn-xs btn-info">
										<span>عرض</span>
									</a>
									<a href="<?= actionUrl('city.php', ['city_id', $city['id']], 'edit') ?>" class="btn btn-xs btn-warning">
										تعديل
									</a>
									<a href="<?= actionUrl('cities.php', ['city_id', $city['id']], 'delete') ?>" class="btn btn-xs btn-danger confirm">
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