<?php require 'init.php';
$_SESSION['page']   = 'roads';
$title  = 'قائمة الخطوط';
$roads 	= allRoads(['created_at', 'DESC']);
// $addons=['datatables'];
// Operations script
$operation = param('operation') ? param('operation') : false;
$road_id = param('road_id') && is_numeric(param('road_id')) ? param('road_id') : false;
// die(var_dump($roads));

$editroad = $road_id ? getRoad($road_id) : false;
if ($operation) {
    if ($operation === 'delete') {
        $road = getRoad($road_id);
        if (deleteRoad($road_id)) {
            $old_image_path = IMAGES_DIR . DS . $road['image'];
            if (file_exists($old_image_path)) {
                unlink($old_image_path);
            }
            flash("alert-success", "تمت حذف الخط بنجاح.");
            header("Location: roads.php");
            exit;
        }else{
            flash("alert-danger", "عذرا حدث خطأ اثناء عملية الحذف يرجى المحاولة مرة اخرى.");
            header("Location: roads.php");
            exit;
        }
    }elseif ($operation === 'add-road') {
        $data = [];
        $data['name'] = param('name');
        $stations_names = param('stations_names');
        $stations_descriptions = param('stations_descriptions');
        $stations_images = param('stations_images');
        $stations_cities = param('stations_cities');
        // dd([$stations_images['name']]);
        $prev = param('prev') ? param('prev') : $_SERVER['HTTP_REFERER'];
        if (addRoad($data)) {
            $road_id = lastInsertedId();
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
                        'road_id' => $road_id,
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
            flash("alert-success", "تمت إضافة الخط  بنجاح.");
        }else {
            flash("alert-danger", "حدث خطأ اثناء حفظ التعديلات يرجى المحاولة مرة اخرى.");
        }
        $prev = param('prev') ? param('prev') : $_SERVER['HTTP_REFERER'];
        header("Location: " . $prev);
        exit;
    }elseif ($operation === 'edit-road') {
        $data = [];
        $name = param('name');
        $stations_names = param('stations_names');
        $stations_descriptions = param('stations_descriptions');
        $stations_images = param('stations_images');
        $stations_cities = param('stations_cities');
        if($name) $data['name'] = $name;
        if (updateRoad($data, $road_id)) {
            if ($stations_names && $stations_descriptions && $stations_images && $stations_cities) {
                foreach (roadStations($road_id) as $st) {
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
                    'road_id' => $road_id,
                    ]);
                    $station = [
                    'name' => $name,
                    'description' => $description,
                    'city_id' => $city_id,
                    'road_id' => $road_id,
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
            flash("alert-success", "تم تعديل بيانات الخط (" . getRoad($road_id)['name'] . ") بنجاح.");
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
<?php foreach ($roads as $data): $road = road($data); ?>
<tr>
<td><?= $road['id'] ?></td>
<td><?= $road['name'] ?></td>
<td><?= date("Y-m-d", strtotime($road['created_at'])) ?></td>
<td>
<a href="road.php?road_id=<?= $road['id'] ?>" class="btn btn-xs btn-info">
<span>عرض</span>
</a>
<a href="<?= actionUrl('road.php', ['road_id', $road['id']], 'edit') ?>" class="btn btn-xs btn-warning">
تعديل
</a>
<a href="<?= actionUrl('roads.php', ['road_id', $road['id']], 'delete') ?>" class="btn btn-xs btn-danger confirm">
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