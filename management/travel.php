<?php require 'init.php';
// $addons=['datatables'];
$icons = ['food food-apple-and-grapes-on-a-bowl', 'food food-apple-cut-in-half-with-visible-seeds', 'food food-apple-with-stem-and-leaf', 'food food-barbacue-utensils', 'food food-barbecue-grill', 'food food-beer-in-glass-and-bottle', 'food food-beer-pint', 'food food-bowl-of-hot-soup-on-a-plate', 'food food-burger-and-soda-with-straw', 'food food-cabbage', 'food food-cheers', 'food food-cheese-with-little-cutted-triangular-piece', 'food food-chef-with-hat', 'food food-cherries-with-stem', 'food food-chicken-leg', 'food food-chocolate-donut-with-sprinkles', 'food food-cocktail-drink-with-stirrer', 'food food-coffee-jar', 'food food-coffee-jar-and-filter', 'food food-coffee-maker-machine', 'food food-cooking-food-in-a-hot-casserole', 'food food-corn-with-leaves', 'food food-croissant', 'food food-cucumber-cut-in-half', 'food food-cupcake-dessert', 'food food-dining-travel-covered', 'food food-dish-cover', 'food food-eggplant-rotated-to-left', 'food food-fire-flames', 'food food-fish-tail-bone', 'food food-food-observation', 'food food-food-on-a-stick', 'food food-french-fries-on-container', 'food food-fresh-carrot', 'food food-fried-chicken-leg-on-a-plate', 'food food-fried-egg', 'food food-giant-pumpkin', 'food food-glass-of-wine-and-bottle', 'food food-grapes-and-pear-on-a-platter', 'food food-grapes-with-leaf-and-stem', 'food food-half-avocado', 'food food-half-lemon', 'food food-hamburger-with-sesame-seeds', 'food food-heating-pad', 'food food-horizontal-lemon', 'food food-hot-bread-with-smoke', 'food food-hot-coffee-on-a-tall-paper-cup', 'food food-hot-dogs-package', 'food food-hot-dog-with-sauce-and-bread', 'food food-hot-drink-on-a-cup-button', 'food food-hot-fish', 'food food-hot-fish-bone', 'food food-hot-kitchen-pot', 'food food-hot-travel-sign', 'food food-hot-pepper', 'food food-hot-pot', 'food food-hot-soup', 'food food-ice-cream-cone', 'food food-icecream-cup', 'food food-ice-cream-in-glass', 'food food-leaves-of-herbs', 'food food-loaves-of-bread', 'food food-long-cofee-pot', 'food food-meat-slice', 'food food-milk-jar-with-label', 'food food-milk-package', 'food food-noodle-soup-on-a-bowl', 'food food-onion-bulb', 'food food-onion-bulb-1', 'food food-opened-peas', 'food food-orange-with-leaf', 'food food-packed-sausage', 'food food-pair-of-gloves', 'food food-paper-cupcake', 'food food-peach-piece', 'food food-preserved-in-a-bottle', 'food food-restaurant-travel-card', 'food food-restaurant-utensils', 'food food-rice-bowl-with-chopsticks', 'food food-sausage-on-a-fork', 'food food-sausage-on-a-fork-1', 'food food-small-mushroom', 'food food-spoon-and-fork-upside-down', 'food food-squid', 'food food-strawberry', 'food food-sushi-platter-with-chopsticks', 'food food-take-away-tacos', 'food food-tea-bag-with-tag', 'food food-teapot-and-cup', 'food food-three-balls-ice-cream-cone', 'food food-three-bananas', 'food food-tomato-healthy-veggie', 'food food-traditional-mate', 'food food-tube-glass-with-shine', 'food food-two-layer-birthday-cake-with-candle', 'food food-upsized-drink-with-straw', 'food food-very-hot-drink-with-shine', 'food food-watermelon-slice', 'food food-wine-bottle-in-bucket-with-two-glasses', 'food food-wine-crystal-cup',];
$operation = param('operation') ? param('operation') : 'add';
$travel_id = isset($_GET['travel_id']) && !empty($_GET['travel_id']) && is_numeric($_GET['travel_id']) ? $_GET['travel_id'] : false;
$operation = $operation == 'add' && $travel_id ? 'show' : $operation;

$travel = $travel_id ? travel(getOrRedirect('travels', $travel_id)) : false;
$_SESSSION['page']   = 'travel';
$title  = $travel_id ? 'رحلة ' . $travel['id'] : 'إضافة رحلة';
$title = $operation == 'edit' ? 'تعديل رحلة ' . $travel['id'] : $title;

include "includes/layout/header.php"; 
?>
<?php if($operation == 'add'):?>
	<form action="travels.php?operation=add-travel" method="post">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-list"></i>
                <span>بيانات الرحلة</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label for="road_id"  class="boxy boxy-left boxy-sm">الخط: </label>
                            </div>
                            <div class="col-lg-9">
                                <select name="road_id" id="road_id" class="form-control" required>
                                    <option value="">إختر الخط</option>
                                    <?php foreach(allRoads() as $road):?>
                                        <option value="<?= $road['id'] ?>"><?= $road['name'] ?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label for="departure_date"  class="boxy boxy-left boxy-sm">تاريخ الإقلاع: </label>
                            </div>
                            <div class="col-lg-9">
                                <input type="date" value="<?= date('Y-m-d') ?>" name="departure_date" id="departure_date" class="form-control" placeholder="ادخل تاريخ الإقلاع هنا">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label for="arrival_date"  class="boxy boxy-left boxy-sm">تاريخ الوصول: </label>
                            </div>
                            <div class="col-lg-9">
                                <input type="date" value="<?= date('Y-m-d') ?>" name="arrival_date" id="arrival_date" class="form-control" placeholder="ادخل تاريخ الوصول هنا">
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label for="road_id"  class="boxy boxy-left boxy-sm">القطار: </label>
                            </div>
                            <div class="col-lg-9">
                                <select name="train_id" id="train_id" class="form-control" required>
                                    <option value="">إختر القطار</option>
                                    <?php foreach(allTrains() as $train):?>
                                        <option value="<?= $train['id'] ?>"><?= $train['name'] ?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label  class="boxy boxy-left boxy-sm">زمن الإقلاع: </label>
                            </div>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <input type="text" name="departure_time" id="departure_time" class="form-control" placeholder="زمن الإقلاع">
                                    <select name="departure_mode" id="departure_mode" class="form-control">
                                        <option value="am">صباح</option>
                                        <option value="pm">مساء</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label  class="boxy boxy-left boxy-sm">زمن الوصول: </label>
                            </div>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <input type="text" name="arrival_time" id="arrival_time" class="form-control" placeholder="زمن الوصول">
                                    <select name="arrival_mode" id="arrival_mode" class="form-control">
                                        <option value="am">صباح</option>
                                        <option value="pm">مساء</option>
                                    </select>
                                </div>
                            </div>
                        </div>
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
                        <input type="hidden" name="operation" value="add-travel">
                        <button class="btn btn-gradient-secondary goback float-left mr-2">إلغاء</button>
                        <button type="submit" class="btn btn-gradient-primary float-left">
                            <i class="fa fa-fw fa-plus"></i>
                            <span>إضافة</span> 
                        </button>
                    </div>
                </div>
            </div>
        </div>
	</form>
<?php elseif($operation == 'edit' && $travel):?>
	<form action="travels.php?operation=edit-travel" method="post">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-list"></i>
                <span>بيانات الرحلة</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label for="road_id"  class="boxy boxy-left boxy-sm">الخط: </label>
                            </div>
                            <div class="col-lg-9">
                                <select name="road_id" id="road_id" class="form-control" required>
                                    <option value="">إختر الخط</option>
                                    <?php foreach(allRoads() as $road):?>
                                        <option value="<?= $road['id'] ?>" <?= array_key_exists('road_id', $travel) ? ($travel['road_id'] == $road['id'] ? 'selected' : '') : '' ?>><?= $road['name'] ?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label for="departure_date"  class="boxy boxy-left boxy-sm">تاريخ الإقلاع: </label>
                            </div>
                            <div class="col-lg-9">
                                <input type="date" value="<?= array_key_exists('departure_date', $travel) ? $travel['departure_date'] : date('Y-m-d') ?>" name="departure_date" id="departure_date" class="form-control" placeholder="ادخل تاريخ الإقلاع هنا">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label for="arrival_date"  class="boxy boxy-left boxy-sm">تاريخ الوصول: </label>
                            </div>
                            <div class="col-lg-9">
                                <input type="date" value="<?= array_key_exists('arrival_date', $travel) ? $travel['arrival_date'] : date('Y-m-d') ?>" name="arrival_date" id="arrival_date" class="form-control" placeholder="ادخل تاريخ الوصول هنا">
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label for="road_id"  class="boxy boxy-left boxy-sm">القطار: </label>
                            </div>
                            <div class="col-lg-9">
                                <select name="train_id" id="train_id" class="form-control" required>
                                    <option value="">إختر القطار</option>
                                    <?php foreach(allTrains() as $train):?>
                                        <option value="<?= $train['id'] ?>" <?= array_key_exists('train_id', $travel) ? ($travel['train_id'] == $train['id'] ? 'selected' : '') : '' ?>><?= $train['name'] ?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label  class="boxy boxy-left boxy-sm">زمن الإقلاع: </label>
                            </div>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <input type="text" name="departure_time" value="<?= array_key_exists('departure_time', $travel) ? $travel['departure_time'] : '' ?>" id="departure_time" class="form-control" placeholder="زمن الإقلاع">
                                    <select name="departure_mode" id="departure_mode" class="form-control">
                                        <option value="am" <?= array_key_exists('departure_mode', $travel) ? ($travel['departure_mode'] == 'am' ? 'selected' : '') : '' ?>>صباح</option>
                                        <option value="pm"  <?= array_key_exists('departure_mode', $travel) ? ($travel['departure_mode'] == 'pm' ? 'selected' : '') : '' ?>>مساء</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label  class="boxy boxy-left boxy-sm">زمن الوصول: </label>
                            </div>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <input type="text" name="arrival_time" value="<?= array_key_exists('arrival_time', $travel) ? $travel['arrival_time'] : '' ?>" id="arrival_time" class="form-control" placeholder="زمن الوصول">
                                    <select name="arrival_mode" id="arrival_mode" class="form-control">
                                        <option value="am" <?= array_key_exists('arrival_mode', $travel) ? ($travel['arrival_mode'] == 'am' ? 'selected' : '') : '' ?>>صباح</option>
                                        <option value="pm"  <?= array_key_exists('arrival_mode', $travel) ? ($travel['arrival_mode'] == 'pm' ? 'selected' : '') : '' ?>>مساء</option>
                                    </select>
                                </div>
                            </div>
                        </div>
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
                                    <option value="1" <?= array_key_exists('status', $travel) ? ($travel['status'] == 1 ? 'selected' : '') : '' ?>>في الإنتظار</option>
                                    <option value="2" <?= array_key_exists('status', $travel) ? ($travel['status'] == 2 ? 'selected' : '') : '' ?>>مؤجلة</option>
                                    <option value="3" <?= array_key_exists('status', $travel) ? ($travel['status'] == 3 ? 'selected' : '') : '' ?>>ملغية</option>
                                    <option value="4" <?= array_key_exists('status', $travel) ? ($travel['status'] == 4 ? 'selected' : '') : '' ?>>منتهية</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <input type="hidden" name="operation" value="edit-travel">
                        <input type="hidden" name="travel_id" value="<?= $travel['id'] ?>">
                        <button class="btn btn-gradient-secondary goback float-left mr-2">إلغاء</button>
                        <button type="submit" class="btn btn-primary float-left">
                            <i class="fa fa-fw fa-save"></i>
                            <span>حفظ التعديلات</span> 
                        </button>
                    </div>
                </div>
            </div>
        </div>
	</form>
<?php else: ?>
    <div class="row">
        <div class="col col-lg-5">
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
                        <span>التذاكر</span>
                    </h3>
                </div>
                <div class="card-body p-0">
                    <?php $levels = trainLevels($travel['train_id']);  ?>
                    <?php foreach($levels as $level):?>
                        <?php $tickets = travelTickets($travel_id, $level['id']); ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="5">فئة: <?= $level['level_name'] . ' (' . number_format($level['ticket_price'], 2) . ')' ?></th>
                                </tr>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">الرقم</th>
                                    <th scope="col">المقعد</th>
                                    <th scope="col">المسافر</th>
                                    <th scope="col">الجنس</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($tickets as $ticket):?>
                                    <tr class="accordion-toggle collapsed" id="ticketForm<?= $ticket['id'] ?>" data-toggle="collapse" data-parent="#ticketForm<?= $ticket['id'] ?>" href="#ticket<?= $ticket['id'] ?>">
                                        <td class="expand-button"></td>
                                        <td><?= $ticket['id'] ?></td>
                                        <td><?= $ticket['seat'] ?></td>
                                        <td><?= $ticket['passenger_name'] ?></td>
                                        <td><?= $ticket['passenger_gender'] ?></td>
                                    </tr>
                                    <tr class="hide-table-padding off-white">
                                        <td colspan="5">
                                            <div id="ticket<?= $ticket['id'] ?>" class="collapse in pr-3 pl-3">
                                                <table class="table table-bordered">
                                                    <tr class="row">
                                                        <th class="col-2">رقم التذكرة</th>
                                                        <th class="col-4"><?= $ticket['id'] ?></th>
                                                        <th class="col-2">الإسم</th>
                                                        <th class="col-4"><?= $ticket['passenger_name'] ?></th>
                                                    </tr>
                                                    <tr class="row">
                                                        <th class="col-2">رقم المقعد</th>
                                                        <th class="col-4"><?= $ticket['seat'] ?></th>
                                                        <th class="col-2">الجنس</th>
                                                        <th class="col-4"><?= $ticket['passenger_gender'] ?></th>
                                                    </tr>
                                                    <tr class="row">
                                                        <th class="col-2">سعر التذكرة</th>
                                                        <th class="col-4"><?= number_format($ticket['price'], 2) ?></th>
                                                        <th class="col-2">رقم الهاتف</th>
                                                        <th class="col-4"><?= $ticket['passenger_phone'] ?></th>
                                                    </tr>
                                                    <tr class="row">
                                                        <th class="col-2">تاريخ الإنشاء</th>
                                                        <th class="col-4">
                                                            <a href="ticket.php?ticket_id=<?= $ticket['id'] ?>" class="btn btn-xs btn-info">
                                                                <span>عرض</span>
                                                            </a>
                                                            <a href="ticket.php?ticket_id=<?= $ticket['id'] ?>&operation=edit" class="btn btn-xs btn-warning">
                                                                <span>تعديل</span>
                                                            </a>
                                                            <a href="<?= actionUrl('tickets.php', ['ticket_id', $ticket['id']], 'delete') ?>" class="btn btn-xs btn-danger" data-toggle="confirm">
                                                                <span>حذف</span>
                                                            </a>
                                                        </th>
                                                        <th class="col-2">العنوان</th>
                                                        <th class="col-4"><?= $ticket['passenger_address'] ?></th>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                            <tfoot>
                                <tr class="accordion-toggle collapsed" id="ticketFormAccordion<?= $level['id'] ?>" data-toggle="collapse" data-parent="#ticketFormAccordion<?= $level['id'] ?>" href="#collapseTicketForm<?= $level['id'] ?>">
                                    <td class="expand-button"></td>
                                    <th colspan="5"><span>إضافة تذكرة</span></th>
                                </tr>
                                <tr class="off-white">
                                    <td colspan="5" class="hide-table-padding">
                                        <div id="collapseTicketForm<?= $level['id'] ?>" class="collapse in p-3">
                                            <form action="<?= APP_URL . '/tickets.php?operation=add-ticket' ?>" method="post">
                                                <fieldset>
                                                    <h4>
                                                        <i class="mdi mdi-ticket"></i>
                                                        <span>بيانات التذكرة</span>
                                                    </h4>
                                                    <div class="form-group row">
                                                        <div class="col">
                                                            <div class="form-group row">
                                                                <div class="col-lg-4">
                                                                    <label for="seat">رقم المقعد</label>
                                                                </div>
                                                                <div class="col col-lg-8">
                                                                    <select name="seat" id="seat" class="form-control" required>
                                                                        <?php for($i = 1; $i <= $level['seats']; $i++):?>
                                                                            <?php 
                                                                                $seat_is_empty = true;
                                                                                if (count($tickets)) {
                                                                                    $seat_key = array_search($i, array_column($tickets, 'seat'));
                                                                                    if ($seat_key != false) {
                                                                                        $seat_is_empty = !(array_key_exists($seat_key, $tickets));
                                                                                    }
                                                                                }

                                                                            ?>
                                                                            <?php if($seat_is_empty):?>
                                                                                <option value="<?= $i ?>"><?= $i ?></option>
                                                                            <?php endif;?>
                                                                        <?php endfor;?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group row">
                                                                <div class="col-lg-4">
                                                                    <label for="price">سعر التذكرة</label>
                                                                </div>
                                                                <div class="col col-lg-8">
                                                                    <input type="number" name="price" id="price" class="form-control" readonly value="<?= $level['ticket_price'] ?>" required placeholder="سعر التذكرة">
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
                                                            <input type="text" name="passenger_name" id="passenger_name" class="form-control"  placeholder="الإسم">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-4 col-lg-3">
                                                            <label for="passenger_gender">الجنس</label>
                                                        </div>
                                                        <div class="col col-md-8 col-lg-9">
                                                            <select name="passenger_gender" id="passenger_gender" class="form-control">
                                                                <option value="ذكر">ذكر</option>
                                                                <option value="انثى">انثى</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-4 col-lg-3">
                                                            <label for="passenger_phone">رقم الهاتف</label>
                                                        </div>
                                                        <div class="col col-md-8 col-lg-9">
                                                            <input type="text" name="passenger_phone" id="passenger_phone" class="form-control"  placeholder="رقم الهاتف">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-4 col-lg-3">
                                                            <label for="passenger_address">العنوان</label>
                                                        </div>
                                                        <div class="col col-md-8 col-lg-9">
                                                            <input type="text" name="passenger_address" id="passenger_address" class="form-control"  placeholder="العنوان">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="hidden" name="travel_id" value="<?= $travel_id ?>">
                                                        <input type="hidden" name="train_id" value="<?= $travel['train_id'] ?>">
                                                        <input type="hidden" name="level_train_id" value="<?= $level['id'] ?>">
                                                        <button type="submit" class="btn btn-gradient-primary float-left">
                                                            <i class="fa fa-plus"></i>
                                                            <span>إضافة</span>
                                                        </button>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    <?php endforeach;?>
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