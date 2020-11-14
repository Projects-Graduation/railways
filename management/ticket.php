<?php require 'init.php';
// $addons=['datatables'];
$operation = param('operation') ? param('operation') : 'add';
$travel_id = param('travel_id');
$level_id = param('level_id');
$passenger_id = param('passenger_id');
$ticket_id = isset($_GET['ticket_id']) && !empty($_GET['ticket_id']) && is_numeric($_GET['ticket_id']) ? $_GET['ticket_id'] : false;
$operation = $operation == 'add' && $ticket_id ? 'show' : $operation;

$ticket = $ticket_id ? ticket(getOrRedirect('tickets', $ticket_id)) : false;
if ($ticket) {
    $travel_id = $ticket['travel_id'];
    $train_id = $ticket['train_id'];
    $passenger_id = $ticket['passenger_id'];
    $level_id = $ticket['level_train_id'];
}

$travels = travelBy(['status' => 1]);

$travel_id = param('travel_id') ? param('travel_id') : $travel_id;
$passenger_id = param('passenger_id') ? param('passenger_id') : $passenger_id;
$level_id = param('level_id') ? param('level_id') : $level_id;
// dd($ticket['id']);
$passenger = $passenger_id ? getPassenger($passenger_id) : null;
$_SESSSION['page']   = 'ticket';
$title  = $ticket_id ? 'تذكرة ' . $ticket['id'] : 'إضافة تذكرة';
$title = $operation == 'edit' ? 'تعديل تذكرة ' . $ticket['id'] : $title;
$travel = $travel_id ? getTravel($travel_id) : null;
$level = $level_id ? trainLevel($level_id) : null;
$train = $travel ? getTrain($travel['train_id']) : null;
$road = $train ? getRoad($travel['road_id']) : null;
$_tickets = $level_id ? travelTickets($travel_id, $level_id) : null;
// dd(availableTravels()[0]['canceled_at']);
if ($travel) {
    $levels = trainLevels($travel['train_id']);
}
if ($ticket) {
    if (array_key_exists('travel', $ticket) && is_null($travel)) {
        $travel = $ticket['travel'];
    }
    if (array_key_exists('train', $ticket) && is_null($train)) {
        $train = $ticket['train'];
    }
    if (array_key_exists('road', $ticket) && is_null($road)) {
        $road = $ticket['road'];
    }
    if (array_key_exists('level', $ticket) && is_null($level)) {
        $level = trainLevel($ticket['level_id']);
    }
}

include "includes/layout/header.php"; 
?>
<?php if($operation == 'add'):?>
	<form action="tickets.php?operation=add-ticket" method="post">
        <div class="card">
            <div class="card-header">
                <i class="mdi mdi-ticket"></i>
                <span>بيانات التذكرة</span>
            </div>
            <div class="card-body">
                <fieldset>
                    <h4>
                        <i class="fa fa-list"></i>
                        <span>قائمة الرحلات المتوفرة</span>
                    </h4>
                    <div class="form-group">
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
                            <?php foreach ($travels as $data): $travel = travel($data); ?>
                            <tr>
                                <td><?= $travel['id'] ?></td>
                                <td><?= $travel['road_link'] ?></td>
                                <td><?= $travel['train_link'] ?></td>
                                <td><?= $travel['departure_date'] ?></td>
                                <td><?= $travel['departure_full_time'] ?></td>
                                <td><?= $travel['arrival_date'] ?></td>
                                <td><?= $travel['arrival_full_time'] ?></td>
                                <td style="">
                                    <label>
                                        <input type="radio" class="refresh-form" name="travel_id" id="travel_id<?= $travel_id ?>" value="<?= $travel['id'] ?>" <?= $travel_id ? ($travel['id'] == $travel_id ? 'checked' : '') : '' ?>/>
                                        <span>إختيار</span> 
                                    </label>
                                    <!-- <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input refresh-form" name="travel_id" id="travel_id<?= $travel_id ?>" value="<?= $travel['id'] ?>" <?= $travel_id ? ($travel['id'] == $travel_id ? 'checked' : '') : '' ?>/>
                                            <span>إختيار</span> 
                                            <i class="input-helper"></i>
                                        </label>
                                    </div> -->
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                        </table>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label for="level_id">الفئة</label>
                                </div>
                                <div class="col col-lg-8">
                                    <select name="level_id" id="level_id" class="form-control refresh-form" required>
                                        <?php if($levels && $travel_id):?>
                                            <option value="">إختر الفئة</option>
                                            <?php foreach($levels as $lev):?>
                                                <option value="<?= $lev['id'] ?>" <?= $level_id ? ($lev['id'] == $level_id ? 'selected' : '') : '' ?>><?= $lev['level_name'] . ' (' . number_format($lev['ticket_price'], 2) . ')' ?></option>
                                            <?php endforeach;?>
                                        <?php else:?>
                                            <option value="">إختر رحلة</option>
                                        <?php endif;?>
                                    </select>
                                    <?php if($level):?>
                                        <input type="hidden" name="price" class="form-control" value="<?= $level['ticket_price'] ?>">
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label for="seat">رقم المقعد</label>
                                </div>
                                <div class="col col-lg-8">
                                    <select name="seat" id="seat" class="form-control" required>
                                        <?php if($level_id):?>
                                            <?php for($i = 1; $i <= $level['seats']; $i++):?>
                                                <?php 
                                                    $seat_is_empty = true;
                                                    if (count($_tickets)) {
                                                        $seat_key = array_search($i, array_column($_tickets, 'seat'));
                                                        $seat_is_empty = !(array_key_exists($seat_key, $_tickets));
                                                    }
                                                ?>
                                                <?php if($seat_is_empty):?>
                                                    <option value="<?= $i ?>"><?= $i ?></option>
                                                <?php endif;?>
                                            <?php endfor;?>
                                        <?php else:?>
                                            <option value="">إختر فئة</option>
                                        <?php endif;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h4>
                        <i class="mdi mdi-account"></i>
                        <span>بيانات المسافر</span>
                    </h4>
                    <div class="form-group row">
                        <div class="col-md-4 col-lg-3">
                            <label for="passenger_name">الإسم</label>
                        </div>
                        <div class="col col-md-8 col-lg-9">
                            <input type="text" name="passenger_name" value="<?= $passenger ? $passenger['name'] : '' ?>" id="passenger_name" class="form-control"  placeholder="الإسم">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4 col-lg-3">
                            <label for="passenger_gender">الجنس</label>
                        </div>
                        <div class="col col-md-8 col-lg-9">
                            <select name="passenger_gender" id="passenger_gender" class="form-control">
                                <option value="ذكر" <?= $passenger ? ($passenger['gender'] == 'ذكر' ? 'selected' : '') : '' ?>>ذكر</option>
                                <option value="انثى" <?= $passenger ? ($passenger['gender'] == 'انثى' ? 'selected' : '') : '' ?>>انثى</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4 col-lg-3">
                            <label for="passenger_phone">رقم الهاتف</label>
                        </div>
                        <div class="col col-md-8 col-lg-9">
                            <input type="text" name="passenger_phone" value="<?= $passenger ? $passenger['phone'] : '' ?>" id="passenger_phone" class="form-control"  placeholder="رقم الهاتف">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4 col-lg-3">
                            <label for="passenger_address">العنوان</label>
                        </div>
                        <div class="col col-md-8 col-lg-9">
                            <input type="text" name="passenger_address" value="<?= $passenger ? $passenger['address'] : '' ?>" id="passenger_address" class="form-control"  placeholder="العنوان">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="status"  class="boxy boxy-left boxy-sm">الحالة: </label>
                                </div>
                                <div class="col-lg-9">
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">في الإنتظار</option>
                                        <option value="2">مؤجلة</option>
                                        <option value="3">ملغية</option>
                                        <option value="4">منتهية</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <input type="hidden" name="train_id" value="<?= $travel ? $travel['train_id'] : '' ?>">
                            <input type="hidden" name="level_train_id" value="<?= $level ? $level['id'] : '' ?>">
                            <button class="btn btn-gradient-secondary goback float-left mr-2">إلغاء</button>
                            <button type="submit" class="btn btn-gradient-primary float-left">
                                <i class="fa fa-plus"></i>
                                <span>إضافة</span>
                            </button>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
	</form>
<?php elseif($operation == 'edit' && $ticket):?>
	<form action="tickets.php?operation=edit-ticket" method="post">
        <div class="card">
            <div class="card-header">
                <i class="mdi mdi-ticket"></i>
                <span>بيانات التذكرة</span>
            </div>
            <div class="card-body">
                <fieldset>
                    <h4>
                        <i class="fa fa-list"></i>
                        <span>قائمة الرحلات المتوفرة</span>
                    </h4>
                    <div class="form-group">
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
                            <?php foreach (availableTravels() as $data): $travel = travel($data); ?>
                            <tr>
                                <td><?= $travel['id'] ?></td>
                                <td><?= $travel['road_link'] ?></td>
                                <td><?= $travel['train_link'] ?></td>
                                <td><?= $travel['departure_date'] ?></td>
                                <td><?= $travel['departure_full_time'] ?></td>
                                <td><?= $travel['arrival_date'] ?></td>
                                <td><?= $travel['arrival_full_time'] ?></td>
                                <td style="">
                                    <label>
                                        <input type="radio" class="refresh-form" name="travel_id" id="travel_id<?= $travel_id ?>" value="<?= $travel['id'] ?>" <?= $travel_id ? ($travel['id'] == $travel_id ? 'checked' : '') : '' ?>/>
                                        <span>إختيار</span> 
                                    </label>
                                    <!-- <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input refresh-form" name="travel_id" id="travel_id<?= $travel_id ?>" value="<?= $travel['id'] ?>" <?= $travel_id ? ($travel['id'] == $travel_id ? 'checked' : '') : '' ?>/>
                                            <span>إختيار</span> 
                                            <i class="input-helper"></i>
                                        </label>
                                    </div> -->
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                        </table>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label for="level_id">الفئة</label>
                                </div>
                                <div class="col col-lg-8">
                                    <select name="level_id" id="level_id" class="form-control refresh-form" required>
                                        <?php if($levels && $travel_id):?>
                                            <option value="">إختر الفئة</option>
                                            <?php foreach($levels as $lev):?>
                                                <option value="<?= $lev['id'] ?>" <?= $level_id ? ($lev['id'] == $level_id ? 'selected' : '') : '' ?>><?= $lev['level_name'] . ' (' . number_format($lev['ticket_price'], 2) . ')' ?></option>
                                            <?php endforeach;?>
                                        <?php else:?>
                                            <option value="">إختر رحلة</option>
                                        <?php endif;?>
                                    </select>
                                    <?php if($level):?>
                                        <input type="hidden" name="price" class="form-control" value="<?= $level['ticket_price'] ?>">
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label for="seat">رقم المقعد</label>
                                </div>
                                <div class="col col-lg-8">
                                    <select name="seat" id="seat" class="form-control" required>
                                        <?php if($level_id):?>
                                            <?php for($i = 1; $i <= $level['seats']; $i++):?>
                                                <?php 
                                                    $seat_is_empty = true;
                                                    if (count($_tickets) && $i != $ticket['seat']) {
                                                        $seat_key = array_search($i, array_column($_tickets, 'seat'));
                                                        if ($seat_key != false) {
                                                            $seat_is_empty = !(array_key_exists($seat_key, $_tickets));
                                                        }
                                                    }
                                                ?>
                                                <?php if($seat_is_empty):?>
                                                    <option value="<?= $i ?>" <?= $i == $ticket['seat'] ? 'selected' : ''  ?>><?= $i ?></option>
                                                <?php endif;?>
                                            <?php endfor;?>
                                        <?php else:?>
                                            <option value="">إختر فئة</option>
                                        <?php endif;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h4>
                        <i class="mdi mdi-account"></i>
                        <span>بيانات المسافر</span>
                    </h4>
                    <div class="form-group row">
                        <div class="col-md-4 col-lg-3">
                            <label for="passenger_name">الإسم</label>
                        </div>
                        <div class="col col-md-8 col-lg-9">
                            <input type="text" name="passenger_name" value="<?= $passenger ? $passenger['name'] : '' ?>" id="passenger_name" class="form-control"  placeholder="الإسم">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4 col-lg-3">
                            <label for="passenger_gender">الجنس</label>
                        </div>
                        <div class="col col-md-8 col-lg-9">
                            <select name="passenger_gender" id="passenger_gender" class="form-control">
                                <option value="ذكر" <?= $passenger ? ($passenger['gender'] == 'ذكر' ? 'selected' : '') : '' ?>>ذكر</option>
                                <option value="انثى" <?= $passenger ? ($passenger['gender'] == 'انثى' ? 'selected' : '') : '' ?>>انثى</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4 col-lg-3">
                            <label for="passenger_phone">رقم الهاتف</label>
                        </div>
                        <div class="col col-md-8 col-lg-9">
                            <input type="text" name="passenger_phone" value="<?= $passenger ? $passenger['phone'] : '' ?>" id="passenger_phone" class="form-control"  placeholder="رقم الهاتف">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4 col-lg-3">
                            <label for="passenger_address">العنوان</label>
                        </div>
                        <div class="col col-md-8 col-lg-9">
                            <input type="text" name="passenger_address" value="<?= $passenger ? $passenger['address'] : '' ?>" id="passenger_address" class="form-control"  placeholder="العنوان">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="status"  class="boxy boxy-left boxy-sm">الحالة: </label>
                                </div>
                                <div class="col-lg-9">
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" <?= array_key_exists('status', $ticket) ? ($ticket['status'] == 1 ? 'selected' : '') : '' ?>>في الإنتظار</option>
                                        <option value="2" <?= array_key_exists('status', $ticket) ? ($ticket['status'] == 2 ? 'selected' : '') : '' ?>>مؤجلة</option>
                                        <option value="3" <?= array_key_exists('status', $ticket) ? ($ticket['status'] == 3 ? 'selected' : '') : '' ?>>ملغية</option>
                                        <option value="4" <?= array_key_exists('status', $ticket) ? ($ticket['status'] == 4 ? 'selected' : '') : '' ?>>منتهية</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <input type="hidden" name="passenger_id" value="<?= $passenger ? $passenger['id'] : '' ?>">
                            <input type="hidden" name="train_id" value="<?= $travel ? $travel['train_id'] : '' ?>">
                            <input type="hidden" name="level_train_id" value="<?= $level ? $level['id'] : '' ?>">
                            <input type="hidden" name="operation" value="edit-ticket">
                            <input type="hidden" name="ticket_id" value="<?= $ticket['id'] ?>">
                            <button class="btn btn-gradient-secondary goback float-left mr-2">إلغاء</button>
                            <button type="submit" class="btn btn-primary float-left">
                                <i class="fa fa-fw fa-save"></i>
                                <span>حفظ التعديلات</span> 
                            </button>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
	</form>
<?php else: ?>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3>
                        <i class="mdi mdi-train-variant"></i>
                        <span>الرحلة</span>
                    </h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered">
                        <tr>
                            <th colspan="2" class="off-white">
                                <i class="mdi mdi-format-list-bulleted"></i>
                                <span>تفاصيل الرحلة</span>
                            </th>
                            <th colspan="2" class="off-white">
                                <i class="mdi mdi-clock"></i>
                                <span>الوقت والتاريخ</span>
                            </th>
                        </tr>
                        <tr class="_row">
                            <th class="_col-2 off-white" style="width: 8px">المعرف</th>
                            <td class="_col-4"><?= $travel['id'] ?></td>
                            <th class="_col-2 off-white" style="width: 8px">تاريخ الإقلاع</th>
                            <td class="_col-4"><?= $travel['departure_date'] ?></td>
                        </tr>
                        <tr class="_row">
                            <th class="_col-2 off-white" style="width: 8px">الخط</th>
                            <td class="_col-4"><?= $travel['road_link'] ?></td>
                            <th class="_col-2 off-white" style="width: 8px">زمن الإقلاع</th>
                            <td class="_col-4"><?= $travel['departure_full_time'] ?></td>
                        </tr>
                        <tr class="_row">
                            <th class="_col-2 off-white" style="width: 8px">القطار</th>
                            <td class="_col-4"><?= $travel['train_link'] ?></td>
                            <th class="_col-2 off-white" style="width: 8px">تاريخ الوصول</th>
                            <td class="_col-4"><?= $travel['arrival_date'] ?></td>
                        </tr>
                        <tr class="_row">
                            <th class="_col-2 off-white" style="width: 8px">تاريخ الإنشاء</th>
                            <td class="_col-4"><?= date("Y-m-d", strtotime($travel['created_at'])) ?></td>
                            <th class="_col-2 off-white" style="width: 8px">زمن الوصول</th>
                            <td class="_col-4"><?= $travel['arrival_full_time'] ?></td>
                        </tr>
                        <tr class="_row">
                            <th class="_col-2 off-white" style="width: 8px">الحالة</th>
                            <td class="_col-4"><?= $travel['status_text'] ?></td>
                            <th class="_col-2 off-white" style="width: 8px"></th>
                            <td class="_col-4"></td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="text-center">
                        <a href="travel.php?travel_id=<?= $travel['id'] ?>" class="btn btn-info">
                            <span>عرض</span>
                        </a>
                        <a href="travel.php?travel_id=<?= $travel['id'] ?>&operation=edit" class="btn btn-warning">
                            <span>تعديل</span>
                        </a>
                        <a href="<?= actionUrl('travels.php', ['travel_id', $travel['id']], 'delete') ?>" class="btn btn-danger" data-toggle="confirm">
                            <span>حذف</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3>
                        <i class="mdi mdi-ticket"></i>
                        <span>التذكرة</span>
                    </h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered">
                        <tr>
                            <th colspan="2" class="off-white">
                                <i class="mdi mdi-format-list-bulleted"></i>
                                <span>تفاصيل التذكرة</span>
                            </th>
                            <th colspan="2" class="off-white">
                                <i class="mdi mdi-account"></i>
                                <span>بيانات المسافر</span>
                            </th>
                        </tr>
                        <tr class="_row">
                            <th class="_col-2 off-white" style="width: 8px">رقم التذكرة</th>
                            <td class="_col-4"><?= $ticket['id'] ?></td>
                            <th class="_col-2 off-white" style="width: 8px">الإسم</th>
                            <td class="_col-4"><?= $ticket['passenger_name'] ?></td>
                        </tr>
                        <tr class="_row">
                            <th class="_col-2 off-white" style="width: 8px">الفئة</th>
                            <td class="_col-4"><?= $ticket['level']['level_name'] ?></td>
                            <th class="_col-2 off-white" style="width: 8px">الجنس</th>
                            <td class="_col-4"><?= $ticket['passenger_gender'] ?></td>
                        </tr>
                        <tr class="_row">
                            <th class="_col-2 off-white" style="width: 8px">سعر التذكرة</th>
                            <td class="_col-4"><?= number_format($ticket['price'], 2) ?></td>
                            <th class="_col-2 off-white" style="width: 8px">رقم الهاتف</th>
                            <td class="_col-4"><?= $ticket['passenger_phone'] ?></td>
                        </tr>
                        <tr class="_row">
                            <th class="_col-2 off-white" style="width: 8px">رقم المقعد</th>
                            <td class="_col-4"><?= $ticket['seat'] ?></td>
                            <th class="_col-2 off-white" style="width: 8px">العنوان</th>
                            <td class="_col-4"><?= $ticket['passenger_address'] ?></td>
                        </tr>
                        <tr class="_row">
                            <th class="_col-2 off-white" style="width: 8px">الحالة</th>
                            <td class="_col-4"><?= $ticket['status_text'] ?></td>
                            <th class="_col-2 off-white" style="width: 8px"></th>
                            <td class="_col-4"></td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="text-center">
                        <a href="ticket.php?ticket_id=<?= $ticket['id'] ?>&operation=edit" class="btn btn-warning">
                            <span>تعديل</span>
                        </a>
                        <a href="<?= actionUrl('tickets.php', ['ticket_id', $ticket['id']], 'delete') ?>" class="btn btn-danger" data-toggle="confirm">
                            <span>حذف</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>
<?php include "includes/layout/footer_open.php"; ?>
<style>
tr.hide-table-padding td {
  padding: 0;
}

.expand-button {
	position: relative;
}

.accordion-toggle .expand-button:after
{
  position: absolute;
  left:.75rem;
  top: 50%;
  transform: translate(0, -50%);
  content: '-';
}
.accordion-toggle.collapsed .expand-button:after
{
  content: '+';
}
</style>
<script>
    $(function(){
        $(document).on('change', '.refresh-form', function(e){
            e.preventDefault();
            let form = $(this).closest('form');
            form.attr('method', 'GET');
            form.find('input[name=operation]').val('<?= $operation ?>')
            form.find('input[name=ticket_id]').val('<?= $ticket_id ? $ticket_id : '' ?>')
            form.attr('action', "<?= page('ticket') ?>");
            $('select[required], input[required]').removeAttr('required');
            form.submit();
        });

        $('.icon-label').click(function(){
            $('.icon-label').removeClass('active');
            $(this).addClass('active');
        })

        // // Add minus icon for collapse element which is open by default
        // $(".collapse.show").each(function(){
        // 	$(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
        // });
        
        // // Toggle plus minus icon on show hide of collapse element
        // $(".collapse").on('show.bs.collapse', function(){
        // 	$(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");
        // }).on('hide.bs.collapse', function(){
        // 	$(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
        // });

        $('.panel-group').on('hidden.bs.collapse', toggleIcon);
        $('.panel-group').on('shown.bs.collapse', toggleIcon);
        $('input.quantity').on('change, keyup', function(){
            calculate();
        })
        $('input[name=discount]').on('change, keyup', function(){
            let field_total = $('input[name=total]')
            let field_discount = $('input[name=discount]')
            let field_net = $('input[name=net]')

            let total = Number(field_total.val());
            let discount = Number(field_discount.val());
            let net = (total - discount);

            field_net.val(net)
        })

        $('.panel-group').on('hidden.bs.collapse', toggleIcon);
        $('.panel-group').on('shown.bs.collapse', toggleIcon);
    });
    function calculate()
    {
        let quantity_fields = $('input.quantity');
        let field_total = $('input[name=total]')
        let field_discount = $('input[name=discount]')
        let field_net = $('input[name=net]')
        let total = 0;
        for (let index = 0; index < quantity_fields.length; index++) {
            const quantity_field = $(quantity_fields[index]);
            let quantity = quantity_field.val();
            let price = quantity_field.siblings('input.price').val();
            total += (Number(quantity) * Number(price));
        }

        let discount = Number(field_discount.val());
        let net = total - discount;

        field_total.val(total)
        field_net.val(net)
    }
    function toggleIcon(e) {
        $(e.target)
            .prev('.panel-heading')
            .find(".more-less")
            .toggleClass('glyphicon-plus glyphicon-minus');
    }
</script>
<?php include "includes/layout/footer_close.php"; ?>