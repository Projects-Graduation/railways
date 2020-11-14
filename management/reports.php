<?php 
require 'init.php';
// die(var_dump($user));
$page = 'index';
$_SESSION["page"] = "index";
$title = "التقارير";
$view = param('view');
$trains = allTrains();
$roads = allRoads();
$road_id = param('road_id') ? param('road_id') : 'all';
$train_id = param('train_id') ? param('train_id') : 'all';
$travel_id = param('travel_id') ? param('travel_id') : 'all';
$status = param('status') ? param('status') : 'all';
$passenger_name = param('passenger_name');
$passenger_gender = param('passenger_gender') ? param('passenger_gender') : 'all';

if ($view == 'travels') {
    $data = [];
    $query = "SELECT * FROM `travels`";
    if ($road_id != 'all') {
        $query .= " WHERE road_id = ? ";
        $data[] = $road_id;
    }

    if ($train_id != 'all') {
        if ($road_id != 'all') {
            $query .= " AND train_id = ? ";
        }else{
            $query .= " WHERE train_id = ? ";
        }
        $data[] = $train_id;
    }
    
    if ($status != 'all') {
        if ($road_id != 'all' || $train_id != '') {
            $query .= " AND status = ? ";
        }else{
            $query .= " WHERE status = ? ";
        }
        $data[] = $status;
    }

    $stmt = $DB->prepare($query);
    $stmt->execute($data);
    $travels = $stmt->fetchAll();
}
else if ($view == 'tickets') {
    $data = [];
    $query = "SELECT * FROM `tickets`";
    if ($travel_id != 'all') {
        $query .= " WHERE travel_id = ? ";
        $data[] = $travel_id;
    }

    if ($train_id != 'all') {
        if ($road_id != 'all') {
            $query .= " AND train_id = ? ";
        }else{
            $query .= " WHERE train_id = ? ";
        }
        $data[] = $train_id;
    }
    
    if ($status != 'all') {
        if ($road_id != 'all' || $train_id != '') {
            $query .= " AND status = ? ";
        }else{
            $query .= " WHERE status = ? ";
        }
        $data[] = $status;
    }

    $stmt = $DB->prepare($query);
    $stmt->execute($data);
    $tickets = $stmt->fetchAll();
}
else if ($view == 'passengers') {
    $data = [];
    $query = "SELECT `tickets`.*, `travels`.`departure_date`, `travels`.`departure_time`, `travels`.`departure_mode`,
                `travels`.`departure_date`, `travels`.`departure_time`, `travels`.`departure_mode`,
                `roads`.`id` AS road_id, `roads`.`name` AS road_name, 
                `trains`.`name` AS train_name, 
                `levels`.`name` AS level_name, 
                `passengers`.`name` AS passenger_name, `passengers`.`gender` AS passenger_gender, `passengers`.`phone` AS passenger_phone, `passengers`.`address` AS passenger_address
            FROM `tickets`
            INNER JOIN `travels`
            ON `tickets`.`travel_id` = `travels`.`id`
            INNER JOIN `trains`
            ON `tickets`.`train_id` = `trains`.`id`
            INNER JOIN `passengers`
            ON `tickets`.`passenger_id` = `passengers`.`id`
            INNER JOIN `roads`
            ON `travels`.`road_id` = `roads`.`id`
            INNER JOIN `level_train`
            ON `tickets`.`level_train_id` = `level_train`.`id`
            INNER JOIN `levels`
            ON `level_train`.`level_id` = `levels`.`id`
    ";
    $is_first = true;
    if ($passenger_name) {
        $query .= " WHERE `passengers`.`name` LIKE ? ";
        $data[] = '%' . $passenger_name . '%';
        $is_first = false;
    }

    if ($passenger_gender != 'all') {
        if (!$is_first) {
            $query .= " AND `passengers`.`gender` = ? ";
        }else{
            $query .= " WHERE `passengers`.`gender` = ? ";
        }
        $data[] = $passenger_gender;
        $is_first = false;
    }

    if ($travel_id != 'all') {
        if (!$is_first) {
            $query .= " AND `tickets`.`travel_id` = ? ";
        }else{
            $query .= " WHERE `tickets`.`travel_id` = ? ";
        }
        $data[] = $travel_id;
        $is_first = false;
    }

    if ($train_id != 'all') {
        if (!$is_first) {
            $query .= " AND `tickets`.`train_id` = ? ";
        }else{
            $query .= " WHERE `tickets`.`train_id` = ? ";
        }
        $data[] = $train_id;
        $is_first = false;
    }
    
    if ($status != 'all') {
        if (!$is_first) {
            $query .= " AND `tickets`.`status` = ? ";
        }else{
            $query .= " WHERE `tickets`.`status` = ? ";
        }
        $data[] = $status;
        $is_first = false;
    }
    $stmt = $DB->prepare($query);
    $stmt->execute($data);
    $passengers = $stmt->fetchAll();
    // dd($passengers);
}
?>
<?php include 'includes/layout/header.php'; ?>
<?php if($view):?>
    <?php if($view == 'travels'):?>
        <div class="card">
            <div class="card-header clearfix">
                <h4 class="reset">
                    <i class="mdi mdi-train-variant"></i>
                    <span>تقرير الرحلات</span>
                </h4>
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($travels as $data): $travel = travel($data); ?>
                            <tr>
                                <td><?= $travel['id'] ?></td>
                                <td><?= $travel['road_name'] ?></td>
                                <td><?= $travel['train_name'] ?></td>
                                <td><?= $travel['status_text'] ?></td>
                                <td><?= $travel['departure_date'] ?></td>
                                <td><?= $travel['departure_full_time'] ?></td>
                                <td><?= $travel['arrival_date'] ?></td>
                                <td><?= $travel['arrival_full_time'] ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <form action="<?= page('reports') ?>" method="GET" class="form-inline">
                    <input type="hidden" name="view" value="travels">
                    <div class="form-group ml-2">
                        <label for="road_id">الخط</label>
                        <select name="road_id" id="road_id" class="form-control" required>
                            <option value="all" <?= $road_id == 'all' ? 'selected' : '' ?>>الكل</option>
                            <?php foreach($roads as $road):?>
                                <option value="<?= $road['id'] ?>" <?= $road_id == $road['id'] ? 'selected' : '' ?>><?= $road['name'] ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group ml-2">
                        <label for="train_id">القطار</label>
                        <select name="train_id" id="train_id" class="form-control" required>
                            <option value="all" <?= $train_id == 'all' ? 'selected' : '' ?>>الكل</option>
                            <?php foreach($trains as $train):?>
                                <option value="<?= $train['id'] ?>" <?= $train_id == $train['id'] ? 'selected' : '' ?>><?= $train['name'] ?></option>
                            <?php endforeach;?>
                        
                        </select>
                    </div>
                    <div class="form-group ml-2">
                        <label for="status">الحالة</label>
                        <select name="status" id="status" class="form-control">
                            <option value="all" <?= $status == 'all' ? 'selected' : '' ?>>الكل</option>
                            <option value="1" <?= $status == '1' ? 'selected' : '' ?>>في الإنتظار</option>
                            <option value="2" <?= $status == '2' ? 'selected' : '' ?>>مؤجلة</option>
                            <option value="3" <?= $status == '3' ? 'selected' : '' ?>>ملغية</option>
                            <option value="4" <?= $status == '4' ? 'selected' : '' ?>>منتهية</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-gradient-primary p-3">
                            <i class="fa fa-search"></i>
                            <span>بحث</span>
                        </button>
                        <a href="<?= page('reports') ?>" class="btn btn-gradient-info float-left p-3 mr-2">
                            <i class="fa fa-print"></i>
                            <span>قائمة التقارير</span>
                        </a>
                        <button class="btn btn-gradient-secondary goback float-left p-3 mr-2">
                            <span>رجوع</span>
                            <i class="fa fa-arrow-alt-circle-left"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php elseif($view == 'tickets'):?>
        <div class="card">
            <div class="card-header clearfix">
                <h4 class="reset">
                    <i class="mdi mdi-train-variant"></i>
                    <span>تقرير التذاكر</span>
                </h4>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>رقم الرحلة</th>
                            <th>رقم الذكرة</th>
                            <th>الفئة</th>
                            <th>السعر</th>
                            <th>المقعد</th>
                            <th>المسافر</th>
                            <th>الجنس</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tickets as $data): $ticket = ticket($data); ?>
                        <tr>
                            <td><?= $ticket['travel_id'] ?></td>
                            <td><?= $ticket['id'] ?></td>
                            <td><?= $ticket['level_name'] ?></td>
                            <td><?= number_format($ticket['price'], 2) ?></td>
                            <td><?= $ticket['seat'] ?></td>
                            <td><?= $ticket['passenger_name'] ?></td>
                            <td><?= $ticket['passenger_gender'] ?></td>
                            <td><?= $ticket['status_text'] ?></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <form action="<?= page('reports') ?>" method="GET" class="form-inline">
                    <input type="hidden" name="view" value="tickets">
                    <div class="form-group ml-2">
                        <label for="travel_id">الرحلة</label>
                        <select name="travel_id" id="travel_id" class="form-control" required>
                            <option value="all" <?= $travel_id == 'all' ? 'selected' : '' ?>>الكل</option>
                            <?php foreach(allTravels() as $travel):?>
                                <option value="<?= $travel['id'] ?>" <?= $travel_id == $travel['id'] ? 'selected' : '' ?>>رحلة رقم: <?= $travel['id'] ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group ml-2">
                        <label for="train_id">القطار</label>
                        <select name="train_id" id="train_id" class="form-control" required>
                            <option value="all" <?= $train_id == 'all' ? 'selected' : '' ?>>الكل</option>
                            <?php foreach($trains as $train):?>
                                <option value="<?= $train['id'] ?>" <?= $train_id == $train['id'] ? 'selected' : '' ?>><?= $train['name'] ?></option>
                            <?php endforeach;?>
                        
                        </select>
                    </div>
                    <div class="form-group ml-2">
                        <label for="status">الحالة</label>
                        <select name="status" id="status" class="form-control">
                            <option value="all" <?= $status == 'all' ? 'selected' : '' ?>>الكل</option>
                            <option value="1" <?= $status == '1' ? 'selected' : '' ?>>في الإنتظار</option>
                            <option value="2" <?= $status == '2' ? 'selected' : '' ?>>مؤجلة</option>
                            <option value="3" <?= $status == '3' ? 'selected' : '' ?>>ملغية</option>
                            <option value="4" <?= $status == '4' ? 'selected' : '' ?>>منتهية</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-gradient-primary p-3">
                            <i class="fa fa-search"></i>
                            <span>بحث</span>
                        </button>
                        <a href="<?= page('reports') ?>" class="btn btn-gradient-info float-left p-3 mr-2">
                            <i class="fa fa-print"></i>
                            <span>قائمة التقارير</span>
                        </a>
                        <button class="btn btn-gradient-secondary goback float-left p-3 mr-2">
                            <span>رجوع</span>
                            <i class="fa fa-arrow-alt-circle-left"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php elseif($view == 'passengers'):?>
        <div class="card">
            <div class="card-header clearfix">
                <h4 class="reset">
                    <i class="mdi mdi-account"></i>
                    <span>تقرير المسافرين</span>
                </h4>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>الخط</th>
                            <th>رقم الرحلة</th>
                            <th>رقم الذكرة</th>
                            <th>الفئة</th>
                            <th>السعر</th>
                            <th>المقعد</th>
                            <th>المسافر</th>
                            <th>الجنس</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($passengers as $passenger): ?>
                        <tr>
                            <td><?= $passenger['road_name'] ?></td>
                            <td><?= $passenger['travel_id'] ?></td>
                            <td><?= $passenger['id'] ?></td>
                            <td><?= $passenger['level_name'] ?></td>
                            <td><?= number_format($passenger['price'], 2) ?></td>
                            <td><?= $passenger['seat'] ?></td>
                            <td><?= $passenger['passenger_name'] ?></td>
                            <td><?= $passenger['passenger_gender'] ?></td>
                            <td><?= getTicketStatus($passenger['status']) ?></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <form action="<?= page('reports') ?>" method="GET">
                    <input type="hidden" name="view" value="passengers">
                    <div class="form-group row">
                        <div class="col">
                            <label for="passenger_name">الإسم</label>
                            <input type="text" name="passenger_name" id="passenger_name" class="form-control" value="<?= $passenger_name ?>">
                        </div>
                        <div class="col">
                            <label for="passenger_gender">الجنس</label>
                            <select name="passenger_gender" id="passenger_gender" class="form-control" required>
                                <option value="all" <?= $passenger_gender == 'all' ? 'selected' : '' ?>>الكل</option>
                                <option value="ذكر" <?= $passenger_gender == 'ذكر' ? 'selected' : '' ?>>ذكر</option>
                                <option value="انثى" <?= $passenger_gender == 'انثى' ? 'selected' : '' ?>>انثى</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="travel_id">الرحلة</label>
                            <select name="travel_id" id="travel_id" class="form-control" required>
                                <option value="all" <?= $travel_id == 'all' ? 'selected' : '' ?>>الكل</option>
                                <?php foreach(allTravels() as $travel):?>
                                    <option value="<?= $travel['id'] ?>" <?= $travel_id == $travel['id'] ? 'selected' : '' ?>>رحلة رقم: <?= $travel['id'] ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="train_id">القطار</label>
                            <select name="train_id" id="train_id" class="form-control" required>
                                <option value="all" <?= $train_id == 'all' ? 'selected' : '' ?>>الكل</option>
                                <?php foreach($trains as $train):?>
                                    <option value="<?= $train['id'] ?>" <?= $train_id == $train['id'] ? 'selected' : '' ?>><?= $train['name'] ?></option>
                                <?php endforeach;?>
                            
                            </select>
                        </div>
                        <div class="col">
                            <label for="status">الحالة</label>
                            <select name="status" id="status" class="form-control">
                                <option value="all" <?= $status == 'all' ? 'selected' : '' ?>>الكل</option>
                                <option value="1" <?= $status == '1' ? 'selected' : '' ?>>في الإنتظار</option>
                                <option value="2" <?= $status == '2' ? 'selected' : '' ?>>مؤجلة</option>
                                <option value="3" <?= $status == '3' ? 'selected' : '' ?>>ملغية</option>
                                <option value="4" <?= $status == '4' ? 'selected' : '' ?>>منتهية</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-gradient-primary p-3">
                            <i class="fa fa-search"></i>
                            <span>بحث</span>
                        </button>
                        <a href="<?= page('reports') ?>" class="btn btn-gradient-info p-3 mr-2">
                            <i class="fa fa-print"></i>
                            <span>قائمة التقارير</span>
                        </a>
                        <button class="btn btn-gradient-secondary goback p-3 mr-2">
                            <span>رجوع</span>
                            <i class="fa fa-arrow-alt-circle-left"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif;?>
<?php else:?>
    <div class="card mb-5">
        <div class="card-header header-sm d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">
                <i class="mdi mdi-train-variant"></i>
                <span>الرحلات</span>
            </h4>
        </div>
        <div class="card-body p-3">
            <form action="<?= page('reports') ?>" method="GET" class="form-inline">
                <input type="hidden" name="view" value="travels">
                <div class="form-group ml-2">
                    <label for="road_id">الخط</label>
                    <select name="road_id" id="road_id" class="form-control" required>
                        <option value="all">الكل</option>
                        <?php foreach($roads as $road):?>
                            <option value="<?= $road['id'] ?>"><?= $road['name'] ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group ml-2">
                    <label for="train_id">القطار</label>
                    <select name="train_id" id="train_id" class="form-control" required>
                        <option value="all">الكل</option>
                        <?php foreach($trains as $train):?>
                            <option value="<?= $train['id'] ?>"><?= $train['name'] ?></option>
                        <?php endforeach;?>
                    
                    </select>
                </div>
                <div class="form-group ml-2">
                    <label for="status">الحالة</label>
                    <select name="status" id="status" class="form-control">
                        <option value="all">الكل</option>
                        <option value="1">في الإنتظار</option>
                        <option value="2">مؤجلة</option>
                        <option value="3">ملغية</option>
                        <option value="4">منتهية</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-gradient-primary p-3">
                        <i class="fa fa-search"></i>
                        <span>بحث</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="card mb-5">
        <div class="card-header header-sm d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">
                <i class="mdi mdi-ticket"></i>
                <span>التذاكر</span>
            </h4>
        </div>
        <div class="card-body p-3">
            <form action="<?= page('reports') ?>" method="GET" class="form-inline">
                <input type="hidden" name="view" value="tickets">
                <div class="form-group ml-2">
                    <label for="travel_id">الرحلة</label>
                    <select name="travel_id" id="travel_id" class="form-control" required>
                        <option value="all">الكل</option>
                        <?php foreach(allTravels() as $travel):?>
                            <option value="<?= $travel['id'] ?>">رحلة رقم: <?= $travel['id'] ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group ml-2">
                    <label for="train_id">القطار</label>
                    <select name="train_id" id="train_id" class="form-control" required>
                        <option value="all">الكل</option>
                        <?php foreach($trains as $train):?>
                            <option value="<?= $train['id'] ?>"><?= $train['name'] ?></option>
                        <?php endforeach;?>
                    
                    </select>
                </div>
                <div class="form-group ml-2">
                    <label for="status">الحالة</label>
                    <select name="status" id="status" class="form-control">
                        <option value="all">الكل</option>
                        <option value="1">في الإنتظار</option>
                        <option value="2">مؤجلة</option>
                        <option value="3">ملغية</option>
                        <option value="4">منتهية</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-gradient-primary p-3">
                        <i class="fa fa-search"></i>
                        <span>بحث</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="card mb-5">
        <div class="card-header header-sm d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">
                <i class="mdi mdi-account"></i>
                <span>المسافرين</span>
            </h4>
        </div>
        <div class="card-body p-3">
            <form action="<?= page('reports') ?>" method="GET" class="form-inline">
                <input type="hidden" name="view" value="passengers">
                <div class="form-group ml-2">
                    <label for="passenger_name">الإسم</label>
                    <input type="text" name="passenger_name" id="passenger_name" class="form-control">
                </div>
                <div class="form-group ml-2">
                    <label for="passenger_gender">الجنس</label>
                    <select name="passenger_gender" id="passenger_gender" class="form-control" required>
                        <option value="all">الكل</option>
                        <option value="ذكر" <?= 'm' ?>>ذكر</option>
                        <option value="انثى" <?= 'f' ?>>انثى</option>
                    </select>
                </div>
                <div class="form-group ml-2">
                    <label for="travel_id">الرحلة</label>
                    <select name="travel_id" id="travel_id" class="form-control" required>
                        <option value="all">الكل</option>
                        <?php foreach(allTravels() as $travel):?>
                            <option value="<?= $travel['id'] ?>">رحلة رقم: <?= $travel['id'] ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group ml-2">
                    <label for="train_id">القطار</label>
                    <select name="train_id" id="train_id" class="form-control" required>
                        <option value="all">الكل</option>
                        <?php foreach($trains as $train):?>
                            <option value="<?= $train['id'] ?>"><?= $train['name'] ?></option>
                        <?php endforeach;?>
                    
                    </select>
                </div>
                <div class="form-group ml-2">
                    <label for="status">الحالة</label>
                    <select name="status" id="status" class="form-control">
                        <option value="all">الكل</option>
                        <option value="1">في الإنتظار</option>
                        <option value="2">مؤجلة</option>
                        <option value="3">ملغية</option>
                        <option value="4">منتهية</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-gradient-primary p-3">
                        <i class="fa fa-search"></i>
                        <span>بحث</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php endif;?>
<?php include 'includes/layout/footer.php'; ?>
