<?php require 'init.php';
$_SESSION['page']   = 'tickets';
$title  = 'قائمة التذاكر';
$tickets 	= allTickets(['created_at', 'DESC']);
// $addons=['datatables'];
// Operations script
$operation = param('operation') ? param('operation') : false;
$ticket_id = param('ticket_id') && is_numeric(param('ticket_id')) ? param('ticket_id') : false;
// die(var_dump($tickets));

$editticket = $ticket_id ? getTicket($ticket_id) : false;
if ($operation) {
    if ($operation === 'delete') {
        $ticket = getTicket($ticket_id);
        if (deleteTicket($ticket_id)) {
            flash("alert-success", "تمت حذف التذكرة بنجاح.");
            header("Location: tickets.php");
            exit;
        }else{
            $prev = param('prev') ? param('prev') : $_SERVER['HTTP_REFERER'];
			header("Location: " . $prev);
			exit;
        }
    }elseif ($operation === 'add-ticket') {
        $data = [];
        $seat = param('seat');
        $price = param('price');
        $status = param('status');
        $travel_id = param('travel_id');
		$train_id = param('train_id');
		$level_train_id = param('level_train_id');
        
        if($seat) $data['seat'] = $seat;
        if($price) $data['price'] = $price;
        if($status) $data['status'] = $status;
        if($travel_id) $data['travel_id'] = $travel_id;
		if($train_id) $data['train_id'] = $train_id;
		if($level_train_id) $data['level_train_id'] = $level_train_id;

		$passenger_data = [];
        $passenger_name = param('passenger_name');
        $passenger_gender = param('passenger_gender');
		$passenger_phone = param('passenger_phone');
		$passenger_address = param('passenger_address');
		
        $passenger_data['name'] = $passenger_name ? $passenger_name : '';
        $passenger_data['gender'] = $passenger_gender ? $passenger_gender : '';
		$passenger_data['phone'] = $passenger_phone ? $passenger_phone : '';
		$passenger_data['address'] = $passenger_address ? $passenger_address : '';

		if (count($passenger_data)) {
			$passenger = firstOrInsert('passengers', $passenger_data);
			if ($passenger) {
				$data['passenger_id'] = $passenger['id'];
			}
		}
		// dd($data);

        
        $prev = param('prev') ? param('prev') : $_SERVER['HTTP_REFERER'];
        if (addTicket($data)) {
            flash("alert-success", "تمت إضافة التذكرة  بنجاح.");
        }else {
            flash("alert-error", "حدث خطأ اثناء حفظ التعديلات يرجى المحاولة مرة اخرى.");
		}
		if (param('next')) {
			$ticket_id = lastInsertedId();
			$next = param('next');
			$next = str_replace(':ticket_id', $ticket_id, $next);
			header("Location: " . $next);
			exit;
		}else{
			$prev = param('prev') ? param('prev') : $_SERVER['HTTP_REFERER'];
			header("Location: " . $prev);
			exit;
		}
    }elseif ($operation === 'edit-ticket') {
        $data = [];
        $seat = param('seat');
        $price = param('price');
        $status = param('status');
        $travel_id = param('travel_id');
		$train_id = param('train_id');
		$level_train_id = param('level_train_id');
		$passenger_id = param('passenger_id');

		$passenger_data = [];
        $passenger_name = param('passenger_name');
        $passenger_gender = param('passenger_gender');
		$passenger_phone = param('passenger_phone');
		$passenger_address = param('passenger_address');
		
        if($passenger_name) $passenger_data['name'] = $passenger_name;
        if($passenger_gender) $passenger_data['gender'] = $passenger_gender;
		if($passenger_phone) $passenger_data['phone'] = $passenger_phone;
		if($passenger_address) $passenger_data['address'] = $passenger_address;

		if (count($passenger_data)) {
			if ($passenger_id) {
				updatePassenger($passenger_data, $passenger_id);
			}else{
				$passenger = firstOrInsert('passengers', $passenger_data);
				if ($passenger) {
					$passenger_id = $passenger['id'];
				}
			}
		}
        
        if($seat) $data['seat'] = $seat;
        if($price) $data['price'] = $price;
        if($status) $data['status'] = $status;
        if($travel_id) $data['travel_id'] = $travel_id;
		if($train_id) $data['train_id'] = $train_id;
		if($level_train_id) $data['level_train_id'] = $level_train_id;
		if($passenger_id) $data['passenger_id'] = $passenger_id;
		
        if (updateTicket($data, $ticket_id)) {
            flash("alert-success", "تم تعديل بيانات التذكرة (" . getTicket($ticket_id)['id'] . ") بنجاح.");
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
			<span>التذاكر</span>
			</h4>
        <a href="<?= APP_URL . '/ticket.php?operation=add' ?>" class="btn btn-primary float-left">
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
              <th>تاريخ الاقلاع</th>
              <th>زمن الاقلاع</th>
              <th>تاريخ الوصول</th>
              <th>زمن الوصول</th>
              <th>الخيارات</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($tickets as $data): $ticket = ticket($data); ?>
              <tr>
                <td><?= $ticket['id'] ?></td>
                <td><?= $ticket['road_link'] ?></td>
                <td><?= $ticket['train_link'] ?></td>
                <td><?= $ticket['departure_date'] ?></td>
                <td><?= $ticket['departure_full_time'] ?></td>
                <td><?= $ticket['seat'] ?></td>
                <td><?= $ticket['arrival_full_time'] ?></td>
                <td style="">
                  <a href="ticket.php?ticket_id=<?= $ticket['id'] ?>" class="btn btn-xs btn-info">
                    <span>عرض</span>
                  </a>
                  <a href="ticket.php?ticket_id=<?= $ticket['id'] ?>&operation=edit" class="btn btn-xs btn-warning">
                    <span>تعديل</span>
                  </a>
                  <a href="<?= actionUrl('tickets.php', ['ticket_id', $ticket['id']], 'delete') ?>" class="btn btn-xs btn-danger" data-toggle="confirm">
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