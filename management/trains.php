<?php require 'init.php';
$_SESSION['page']   = 'trains';
$title  = 'قائمة القطارات';
$trains 	= allTrains(['created_at', 'DESC']);
// $addons=['datatables'];
// Operations script
$operation = param('operation') ? param('operation') : false;
$train_id = param('train_id') && is_numeric(param('train_id')) ? param('train_id') : false;
// die(var_dump($trains));

$edittrain = $train_id ? getTrain($train_id) : false;
if ($operation) {
    if ($operation === 'delete') {
        $train = getTrain($train_id);
        if (deleteTrain($train_id)) {
            $old_image_path = IMAGES_DIR . DS . $train['image'];
            if (file_exists($old_image_path)) {
                unlink($old_image_path);
            }
            flash("alert-success", "تمت حذف القطار بنجاح.");
            header("Location: trains.php");
            exit;
        }else{
            flash("alert-danger", "عذرا حدث خطأ اثناء عملية الحذف يرجى المحاولة مرة اخرى.");
            header("Location: trains.php");
            exit;
        }
    }elseif ($operation === 'add-train') {
        $data = [];
        $image = param('image');
        $data['name'] = param('name');
        $data['number'] = param('number');
        $levels_ids = param('levels_ids');
        $levels_seats = param('levels_seats');
        $levels_prices = param('levels_prices');
        $prev = param('prev') ? param('prev') : $_SERVER['HTTP_REFERER'];
        if(!empty($image['name'])){
            $image_extension = pathinfo(param('image')['name'], PATHINFO_EXTENSION);
            $image_name = 'train-' . date('ymdhis') . rand(10, 100) . '.' . $image_extension;
            $image_path = IMAGES_DIR . DS . $image_name;
            if (move_uploaded_file($image['tmp_name'], $image_path)) {
                $data['image'] = $image_name;
            }
        }
        if (addTrain($data)) {
            $train_id = lastInsertedId();
            if ($levels_ids && $levels_seats && $levels_prices) {
                for ($i=0; $i < count($levels_ids); $i++) { 
                    $level_id = $levels_ids[$i];
                    $seats = $levels_seats[$i];
                    $ticket_price = $levels_prices[$i];
                    if ($seats && $ticket_price) {
                        $level_train = [
                            'level_id' => $level_id,
                            'seats' => $seats,
                            'ticket_price' => $ticket_price,
                        ];
                        addTrainLevels($train_id, $level_train);
                    }
                }
            }
            flash("alert-success", "تمت إضافة القطار  بنجاح.");
        }else {
            flash("alert-danger", "حدث خطأ اثناء حفظ التعديلات يرجى المحاولة مرة اخرى.");
        }
        $prev = param('prev') ? param('prev') : $_SERVER['HTTP_REFERER'];
        header("Location: " . $prev);
        exit;
    }elseif ($operation === 'edit-train') {
        $data = [];
        $name = param('name');
        $number = param('number');
        $levels_ids = param('levels_ids');
        $levels_seats = param('levels_seats');
        $levels_prices = param('levels_prices');

        $image = param('image');
        $old_image = param('old_image');
        if($name) $data['name'] = $name;
        if($number) $data['number'] = $number;
        if(!empty($image['name'])){
            $image_extension = pathinfo(param('image')['name'], PATHINFO_EXTENSION);
            $image_name = 'train-' . date('ymdhis') . rand(10, 100) . '.' . $image_extension;
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
        if (updateTrain($data, $train_id)) {
            if ($levels_ids && $levels_seats && $levels_prices) {
                // $trainLevels = trainLevels($train_id);

                for ($i=0; $i < count($levels_ids); $i++) { 
                    $level_id = $levels_ids[$i];
                    $seats = $levels_seats[$i];
                    $ticket_price = $levels_prices[$i];
                    if ($seats && $ticket_price) {
                        $trainLevel = trainLevel($train_id, $level_id);
                        if (is_array($trainLevel)) {
                            $data = [];
                            if ($trainLevel['seats'] != $seats) {
                                $data['seats'] = $seats;
                            }
                            if ($trainLevel['ticket_price'] != $ticket_price) {
                                $data['ticket_price'] = $ticket_price;
                            }
                            if (count($data)) {
                                update('level_train', $data, ['id', $trainLevel['id']]);
                            }
                        }else{
                            $level_train = [
                                'level_id' => $level_id,
                                'seats' => $seats,
                                'ticket_price' => $ticket_price,
                            ];
                            addTrainLevels($train_id, $level_train);
                        }
                    }else{
                        removeTrainLevels($train_id, $level_id);
                    }
                }
            }
            flash("alert-success", "تم تعديل بيانات القطار (" . getTrain($train_id)['name'] . ") بنجاح.");
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
						<?php foreach ($trains as $data): $train = train($data); ?>
							<tr>
								<td><?= $train['id'] ?></td>
								<td><?= $train['name'] ?></td>
								<td><?= date("Y-m-d", strtotime($train['created_at'])) ?></td>
								<td>
									<a href="train.php?train_id=<?= $train['id'] ?>" class="btn btn-xs btn-info">
										<span>عرض</span>
									</a>
									<a href="<?= actionUrl('train.php', ['train_id', $train['id']], 'edit') ?>" class="btn btn-xs btn-warning">
										تعديل
									</a>
									<a href="<?= actionUrl('trains.php', ['train_id', $train['id']], 'delete') ?>" class="btn btn-xs btn-danger confirm">
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