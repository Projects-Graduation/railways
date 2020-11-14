<?php require 'init.php';
$_SESSION['page']   = 'travels';
$title  = 'قائمة الرحلات';
$travels 	= allTravels(['created_at', 'DESC']);
// $addons=['datatables'];
// Operations script
$operation = param('operation') ? param('operation') : false;
$travel_id = param('travel_id') && is_numeric(param('travel_id')) ? param('travel_id') : false;
// die(var_dump($travels));

$edittravel = $travel_id ? getTravel($travel_id) : false;
if ($operation) {
    if ($operation === 'delete') {
        $travel = getTravel($travel_id);
        if (deleteTravel($travel_id)) {
            $old_image_path = ITEMS_DIR . DS . $travel['image'];
            if (file_exists($old_image_path)) {
                unlink($old_image_path);
            }
            flash("alert-success", "تمت حذف الرحلة بنجاح.");
            header("Location: travels.php");
            exit;
        }else{
            flash("alert-error", "عذرا حدث خطأ اثناء عملية الحذف يرجى المحاولة مرة اخرى.");
            header("Location: travels.php");
            exit;
        }
    }elseif ($operation === 'add-travel') {
        $data = [];
        $arrival_date = param('arrival_date');
        $arrival_time = param('arrival_time');
        $arrival_mode = param('arrival_mode');
        $departure_date = param('departure_date');
        $departure_time = param('departure_time');
        $departure_mode = param('departure_mode');
        $status = param('status');
        $road_id = param('road_id');
        $train_id = param('train_id');
        
        if($arrival_date) $data['arrival_date'] = $arrival_date;
        if($arrival_time) $data['arrival_time'] = $arrival_time;
        if($arrival_mode) $data['arrival_mode'] = $arrival_mode;
        if($departure_date) $data['departure_date'] = $departure_date;
        if($departure_time) $data['departure_time'] = $departure_time;
        if($departure_mode) $data['departure_mode'] = $departure_mode;
        if($status) $data['status'] = $status;
        if($road_id) $data['road_id'] = $road_id;
        if($train_id) $data['train_id'] = $train_id;
        
        $prev = param('prev') ? param('prev') : $_SERVER['HTTP_REFERER'];
        if (addTravel($data)) {
            flash("alert-success", "تمت إضافة الرحلة  بنجاح.");
        }else {
            flash("alert-error", "حدث خطأ اثناء حفظ التعديلات يرجى المحاولة مرة اخرى.");
        }
        $prev = param('prev') ? param('prev') : $_SERVER['HTTP_REFERER'];
        header("Location: " . $prev);
        exit;
    }elseif ($operation === 'edit-travel') {
        $data = [];
        $arrival_date = param('arrival_date');
        $arrival_time = param('arrival_time');
        $arrival_mode = param('arrival_mode');
        $departure_date = param('departure_date');
        $departure_time = param('departure_time');
        $departure_mode = param('departure_mode');
        $status = param('status');
        $road_id = param('road_id');
        $train_id = param('train_id');
        
        if($arrival_date) $data['arrival_date'] = $arrival_date;
        if($arrival_time) $data['arrival_time'] = $arrival_time;
        if($arrival_mode) $data['arrival_mode'] = $arrival_mode;
        if($departure_date) $data['departure_date'] = $departure_date;
        if($departure_time) $data['departure_time'] = $departure_time;
        if($departure_mode) $data['departure_mode'] = $departure_mode;
        if($status) $data['status'] = $status;
        if($road_id) $data['road_id'] = $road_id;
		if($train_id) $data['train_id'] = $train_id;
		
        if (updateTravel($data, $travel_id)) {
            flash("alert-success", "تم تعديل بيانات الرحلة (" . getTravel($travel_id)['id'] . ") بنجاح.");
        }else {
            flash("alert-error", "حدث خطأ اثناء حفظ التعديلات يرجى المحاولة مرة اخرى.");
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
        <h4 class="reset float-right">
			<i class="fa fa-check-circle-o"></i>
			<span>الرحلات</span>
			</h4>
        <a href="<?= APP_URL . '/travel.php?operation=add' ?>" class="btn btn-primary float-left">
          <i class="fa fa-plus"></i>
          <span>إضافة</span>
        </a>
      </div>
      <div class="card-body">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>الرقم</th>
              <th>الخط</th>
              <th>القطار</th>
              <th>الحالة</th>
              <th>تاريخ الاقلاع</th>
              <th>زمن الاقلاع</th>
              <th>تاريخ الوصول</th>
              <th>زمن الوصول</th>
              <th>الخيارات</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($travels as $data): $travel = travel($data); ?>
              <tr>
                <td><?= $travel['id'] ?></td>
                <td><?= $travel['road_link'] ?></td>
				<td><?= $travel['train_link'] ?></td>
				<td><?= $travel['status_text'] ?></td>
                <td><?= $travel['departure_date'] ?></td>
                <td><?= $travel['departure_full_time'] ?></td>
                <td><?= $travel['arrival_date'] ?></td>
                <td><?= $travel['arrival_full_time'] ?></td>
                <td style="">
                  <a href="travel.php?travel_id=<?= $travel['id'] ?>" class="btn btn-xs btn-info">
                    <span>عرض</span>
                  </a>
                  <a href="travel.php?travel_id=<?= $travel['id'] ?>&operation=edit" class="btn btn-xs btn-warning">
                    <span>تعديل</span>
				  </a>
                  <a href="<?= actionUrl('travels.php', ['travel_id', $travel['id']], 'delete') ?>" class="btn btn-xs btn-danger" data-toggle="confirm">
                    <span>حذف</span>
                  </a>
                </td>
              </tr>
              <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php include "includes/layout/footer.php"; ?>