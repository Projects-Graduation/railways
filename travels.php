<?php 
require 'init.php';
// die(var_dump($user));
$page = 'index';
$_SESSION["page"] = "travels";
$title = "الرحلات المتوفرة";
$level_id = param('level_id') ? param('level_id') : 'all';
$from_id = param('from_id') ? param('from_id') : 'all';
$to_id = param('to_id') ? param('to_id') : 'all';
$departure_date = param('departure_date');
if ($departure_date) {
    $travels = travelBy(['departure_date' => $departure_date, 'status' => 1], ['created_at', 'DESC']);
}else{
    $travels = travelBy(['status' => 1], ['created_at', 'DESC']);
}

if ($from_id != 'all') {
    $_travels = [];
    foreach ($travels as $travel) {
        $stations = stationBy(['road_id' => $travel['road_id']]);
        $cities = array_in_column('city_id', $stations);
        if (count($cities)) {
            if (in_array($from_id, $cities)) {
                $_travels[] = $travel;
            }
        }
    }

    $travels = $_travels;
}

if ($to_id != 'all') {
    $_travels = [];
    foreach ($travels as $travel) {
        $stations = stationBy(['road_id' => $travel['road_id']]);
        $cities = array_in_column('city_id', $stations);
        if (count($cities)) {
            if (in_array($to_id, $cities)) {
                $_travels[] = $travel;
            }
        }
    }

    $travels = $_travels;
}


if ($level_id != 'all') {
    $_travels = [];
    foreach ($travels as $travel) {
        $levels = trainLevels($travel['train_id']);
        $level_is_empty = true;
        if (count($levels)) {
            $level_key = array_search($level_id, array_column($levels, 'level_id'));
            if ($level_key != false) {
                $level_is_empty = !(array_key_exists($level_key, $levels));
            }
        }
        if (!$level_is_empty) {
            $_travels[] = $travel;
        }
    }

    $travels = $_travels;
}

// dd($travels);
?>
<?php include 'includes/layout/header.php'; ?>
    <div class="panel">
        <div class="panel-heading">
            <h4>
                <span class="fa fa-fw fa-ticket"></span>
                <span>الرحلات الموفرة</span>
            </h4>
            <form class="form-inline" action="<?= page('travels') ?>" method="GET">
                <label style="margin-left: 30px;"><i class="fa fa-filter"></i><span>فرز</span></label>
                <label>من مدينة</label>
                <div class="input-group">
                    <span class="input-group-btn">
                        <label for="from_id" class="btn btn-default" type="button"><span class="fa fa-fw fa-map-marker"></span></label>
                    </span>
                    <select name="from_id" id="from_id" class="form-control">
                        <option value="all">الكل</option>
                        <?php foreach(allCities() as $_city):?>
                            <option value="<?= $_city['id'] ?>" <?= $from_id ? ($_city['id'] == $from_id ? 'selected' : '') : '' ?>><?= $_city['name'] ?></option>
                        <?php endforeach;?>
                    </select>
                </div><!-- /input-group -->
                <label>إلى</label>
                <div class="input-group">
                    <span class="input-group-btn">
                        <label for="to_id" class="btn btn-default" type="button"><span class="fa fa-fw fa-map-marker"></span></label>
                    </span>
                    <select name="to_id" id="to_id" class="form-control">
                        <option value="all">الكل</option>
                        <?php foreach(allCities() as $_city):?>
                            <option value="<?= $_city['id'] ?>" <?= $to_id ? ($_city['id'] == $to_id ? 'selected' : '') : '' ?>><?= $_city['name'] ?></option>
                        <?php endforeach;?>
                    </select>
                </div><!-- /input-group -->
                <label>الفئة</label>
                <div class="input-group">
                    <span class="input-group-btn">
                        <label for="level_id" class="btn btn-default" type="button"><span class="fa fa-fw fa-caret-down"></span></label>
                    </span>
                    <select name="level_id" id="level_id" class="form-control">
                        <option value="all">الكل</option>
                        <?php foreach(allLevels() as $_level):?>
                            <option value="<?= $_level['id'] ?>" <?= $level_id ? ($_level['id'] == $level_id ? 'selected' : '') : '' ?>><?= $_level['name'] ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <label>تاريخ الإقلاع</label>
                <div class="input-group">
                    <input type="date" id="datepicker" name="departure_date" value="<?= param_exists('departure_date') ? param('departure_date') : date('Y-m-d') ?>" class="form-control datepicker" placeholder="تاريخ الإقلاع">
                    <span class="input-group-btn">
                        <label class="btn btn-default" onclick="clearDepartureDate()" type="button"><span class="fa fa-fw fa-times"></span></label>
                    </span>
                </div>
                <button type="submit" class="btn btn-primary">بحث</button>
            </form>
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped table-hover table-vm">
                <thead>
                    <tr>
                        <th>الرقم</th>
                        <th>الخط</th>
                        <th>القطار</th>
                        <th>المدن</th>
                        <th>الحالة</th>
                        <th>تاريخ الاقلاع</th>
                        <th>زمن الاقلاع</th>
                        <th>تاريخ الوصول</th>
                        <th>زمن الوصول</th>
                        <th>حجز</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($travels as $data): $travel = travel($data); $stations = roadStations($travel['road_id']); ?>
                        <tr>
                            <td><?= $travel['id'] ?></td>
                            <td><?= $travel['road_name'] ?></td>
                            <td><?= $travel['train_name'] ?></td>
                            <td>
                                <ol>
                                    <?php $cities = []; foreach($stations as $data): $station = station($data); ?>
                                        <?php if(!in_array($station['city_id'], $cities)):?>
                                            <li><?= $station['city_name'] ?></li>
                                        <?php endif;?>
                                    <?php $cities[] = $station['city_id']; endforeach;?>
                                </ol>
                            </td>
                            <td><?= $travel['status_text'] ?></td>
                            <td><?= $travel['departure_date'] ?></td>
                            <td><?= $travel['departure_full_time'] ?></td>
                            <td><?= $travel['arrival_date'] ?></td>
                            <td><?= $travel['arrival_full_time'] ?></td>
                            <td>
                                <a href="<?= page('ticket') ?>?travel_id=<?= $travel['id'] ?>&operation=add" class="btn btn-primary">
                                    <i class="fa fa-check-square"></i>
                                    <span>حجز</span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
<?php include 'includes/layout/footer_open.php'; ?>
<script>
    function clearDepartureDate()
    {
        $('input[name=departure_date]').val(null);
    }
</script>
<?php include 'includes/layout/footer_close.php'; ?>
