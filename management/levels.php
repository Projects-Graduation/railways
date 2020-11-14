<?php require 'init.php';
$_SESSION['page']   = 'levels';
$title  = 'قائمة الالفئات';
$levels 	= allLevels(['created_at', 'DESC']);
// $addons=['datatables'];
// Operations script
$operation = param('operation') ? param('operation') : false;
$level_id = param('level_id') && is_numeric(param('level_id')) ? param('level_id') : false;
// die(var_dump($levels));

$editlevel = $level_id ? getLevel($level_id) : false;
if ($operation) {
    if ($operation === 'delete') {
        $level = getLevel($level_id);
        if (deleteLevel($level_id)) {
            $old_image_path = IMAGES_DIR . DS . $level['image'];
            if (file_exists($old_image_path)) {
                unlink($old_image_path);
            }
            flash("alert-success", "تمت حذف الفئة بنجاح.");
            header("Location: levels.php");
            exit;
        }else{
            flash("alert-danger", "عذرا حدث خطأ اثناء عملية الحذف يرجى المحاولة مرة اخرى.");
            header("Location: levels.php");
            exit;
        }
    }elseif ($operation === 'add-level') {
        $data = [];
        $data['name'] = param('name');
        $stations_names = param('stations_names');
        $stations_descriptions = param('stations_descriptions');
        $stations_images = param('stations_images');
        $stations_cities = param('stations_cities');
        // dd([$stations_images['name']]);
        $prev = param('prev') ? param('prev') : $_SERVER['HTTP_REFERER'];
        if (addLevel($data)) {
            $level_id = lastInsertedId();
            if ($stations_names && $stations_descriptions && $stations_images && $stations_cities) {
                for ($i=0; $i < count($stations_names); $i++) {
                    $name = $stations_names[$i];
                    $description = $stations_descriptions[$i];
                    $image = $stations_images[$i];
                    $city = $stations_cities[$i];
                    $station = [
                        'name' => $name,
                        'description' => $description,
                        'city_id' => $city,
                        'number' => $i + 1,
                        'level_id' => $level_id,
                    ];
                    if(array_key_exists($i, $stations_images['name'])){
                        $image_extension = pathinfo($stations_images['name'][$i], PATHINFO_EXTENSION);
                        $image_name = 'station-' . date('ymdhis') . rand(10, 100) . '.' . $image_extension;
                        $image_path = IMAGES_DIR . DS . $image_name;
                        if (move_uploaded_file($stations_images['tmp_name'][$i], $image_path)) {
                            $station['image'] = $image_name;
                        }
                    }
                    addStation($station);
                }
            }
            flash("alert-success", "تمت إضافة الفئة  بنجاح.");
        }else {
            flash("alert-danger", "حدث خطأ اثناء حفظ التعديلات يرجى المحاولة مرة اخرى.");
        }
        $prev = param('prev') ? param('prev') : $_SERVER['HTTP_REFERER'];
        header("Location: " . $prev);
        exit;
    }elseif ($operation === 'edit-level') {
        $data = [];
        $name = param('name');
        $stations_names = param('stations_names');
        $stations_descriptions = param('stations_descriptions');
        $stations_images = param('stations_images');
        $stations_cities = param('stations_cities');
        if($name) $data['name'] = $name;
        if (updateLevel($data, $level_id)) {
            if ($stations_names && $stations_descriptions && $stations_images && $stations_cities) {
                foreach (levelStations($level_id) as $st) {
                    if (!in_array($st['city_id'], $stations_cities)) {
                        deleteStation($st['id']);
                    }
                }

                for ($i=0; $i < count($stations_names); $i++) {
                    $name = $stations_names[$i];
                    $description = $stations_descriptions[$i];
                    $city_id = $stations_cities[$i];
                    $exist_station = stationBy([
                    'city_id' => $city_id,
                    'level_id' => $level_id,
                    ]);
                    $station = [
                    'name' => $name,
                    'description' => $description,
                    'city_id' => $city_id,
                    'level_id' => $level_id,
                    'number' => $i + 1,
                    ];
                    
                    if(array_key_exists($i, $stations_images['name'])){
                        $image_extension = pathinfo($stations_images['name'][$i], PATHINFO_EXTENSION);
                        $image_name = 'station-' . date('ymdhis') . rand(10, 100) . '.' . $image_extension;
                        $image_path = IMAGES_DIR . DS . $image_name;
                        if (move_uploaded_file($stations_images['tmp_name'][$i], $image_path)) {
                            $station['image'] = $image_name;
                        }
                    }
                    
                    // if ($i != 0) {
                    //     dd([$station]);
                    // }
                    
                    if ($exist_station) {
                        updateStation($station, $exist_station[0]['id']);
                    }else{
                        addStation($station);
                    }
                }
            }
            flash("alert-success", "تم تعديل بيانات الفئة (" . getLevel($level_id)['name'] . ") بنجاح.");
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
<?php foreach ($levels as $data): $level = level($data); ?>
<tr>
<td><?= $level['id'] ?></td>
<td><?= $level['name'] ?></td>
<td><?= date("Y-m-d", strtotime($level['created_at'])) ?></td>
<td>
<a href="level.php?level_id=<?= $level['id'] ?>" class="btn btn-xs btn-info">
<span>عرض</span>
</a>
<a href="<?= actionUrl('level.php', ['level_id', $level['id']], 'edit') ?>" class="btn btn-xs btn-warning">
تعديل
</a>
<a href="<?= actionUrl('levels.php', ['level_id', $level['id']], 'delete') ?>" class="btn btn-xs btn-danger confirm">
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