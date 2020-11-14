<?php require 'init.php';
$_SESSION["page"] = 'ticket';

$operation = param('operation') ? param('operation') : 'search';
$level_id = param('level_id');
$passenger_id = param('passenger_id');
$ticket_id = isset($_GET['ticket_id']) && !empty($_GET['ticket_id']) && is_numeric($_GET['ticket_id']) ? $_GET['ticket_id'] : false;
$operation = $operation == 'search' && $ticket_id ? 'show' : $operation;

// $ticket = $ticket_id ? ticket(getOrRedirect('tickets', $ticket_id)) : false;
$ticket = $ticket_id ? getTicket($ticket_id) : [];
if ($ticket_id && !array_key_exists('id', $ticket)) {
    flash('alert-danger', 'لا توجد تذكرة بهذا الرقم');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
$travel_id = $ticket ? $ticket['travel_id'] : param('travel_id');
$travel = $travel_id ? travel(getOrRedirect('travels', $travel_id)) : false;
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
$levels = null;
$passenger = $passenger_id ? getPassenger($passenger_id) : null;
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
    $stations = roadStations($travel['road_id']);
    $levels_seats = [];
    foreach ($levels as $level) {
        $seats = $level['seats'];
        $_level_tickets = ticketBy(['level_train_id' => $level['id']]);
        $level_seats = range(1, $seats);
        $taken_seats = array_in_column('seat', $_level_tickets);
        $available_seats = array_filter($level_seats, function($seat) use ($taken_seats){
            return !in_array($seat, $taken_seats);
        });

        if (count($available_seats)) {
            $level_id = $level['id'];
            $levels_seats[$level_id] = array_values($available_seats);
        }
    }
}else{
    $levels = null;
}
// dd($travel);
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
	<form action="<?= APP_URL ?>/tickets.php?operation=add-ticket" method="post">
        <h4>
            <i class="mdi mdi-train-variant"></i>
            <span>بيانات الرحلة</span>
        </h4>
        <div class="form-group">
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
                    </tr>
                </thead>
                <tbody>
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
                    </tr>
                </tbody>
                <input type="hidden" name="travel_id" id="travel_id<?= $travel_id ?>" value="<?= $travel['id'] ?>">
            </table>
        </div>
        <h4>
            <i class="mdi mdi-ticket"></i>
            <span>بيانات التذكرة</span>
        </h4>
        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label for="level_train_id">الفئة</label>
                    </div>
                    <div class="col col-lg-8">
                        <select name="level_train_id" id="level_train_id" class="form-control" required>
                            <?php if($levels && $travel_id):?>
                                <?php foreach($levels as $lev):?>
                                    <option value="<?= $lev['id'] ?>"><?= $lev['level_name'] . ' (' . number_format($lev['ticket_price'], 2) . ')' ?></option>
                                <?php endforeach;?>
                            <?php else:?>
                                <option value="">إختر رحلة</option>
                            <?php endif;?>
                        </select>
                        <input type="hidden" name="price" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label for="seat">رقم المقعد</label>
                    </div>
                    <div class="col col-lg-8">
                        <select name="seat" id="seat" class="form-control" required></select>
                    </div>
                </div>
            </div>
        </div>
        <h4>
            <i class="mdi mdi-account"></i>
            <span>بيانات المسافر</span>
        </h4>
        <div class="form-group row">
            <div class="col-md-5 reset">
                <div class="col-md-4 col-lg-3">
                    <label for="passenger_name">الإسم</label>
                </div>
                <div class="col col-md-8 col-lg-9">
                    <input type="text" name="passenger_name" value="<?= $passenger ? $passenger['name'] : '' ?>" id="passenger_name" class="form-control"  placeholder="الإسم">
                </div>
            </div>
            <div class="col-md-3 reset">
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
            <div class="col-md-4 reset">
                <div class="col-md-4 col-lg-3">
                    <label for="passenger_phone">الهاتف</label>
                </div>
                <div class="col col-md-8 col-lg-9">
                    <input type="text" name="passenger_phone" value="<?= $passenger ? $passenger['phone'] : '' ?>" id="passenger_phone" class="form-control"  placeholder="رقم الهاتف">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="passenger_address">العنوان</label>
            <textarea name="passenger_address" id="passenger_address" class="form-control"  placeholder="العنوان"><?= $passenger ? $passenger['address'] : '' ?></textarea>
        </div>
        <div class="form-group clearfix">
            <input type="hidden" name="messages" value="تم حجز التذكرة بنجاح ">
            <input type="hidden" name="next" value="<?= page('ticket') ?>?ticket_id=:ticket_id">
            <input type="hidden" name="train_id" value="<?= $travel ? $travel['train_id'] : '' ?>">
            <button type="submit" class="btn btn-primary pull-left" style="margin-right: 15px;">
                <i class="fa fa-check-square"></i>
                <span>حجز</span>
            </button>
            <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-default goback pull-left mr-2">رجوع</a>
        </div>
	</form>
<?php elseif($operation == 'show'):?>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h3>
                <i class="mdi mdi-train-variant"></i>
                <span>الرحلة</span>
            </h3>
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
                    <th class="_col-2 off-white" style="width: 120px">المعرف</th>
                    <td class="_col-4"><?= $travel['id'] ?></td>
                    <th class="_col-2 off-white" style="width: 120px">تاريخ الإقلاع</th>
                    <td class="_col-4"><?= $travel['departure_date'] ?></td>
                </tr>
                <tr class="_row">
                    <th class="_col-2 off-white" style="width: 120px">الخط</th>
                    <td class="_col-4"><?= $travel['road_name'] ?></td>
                    <th class="_col-2 off-white" style="width: 120px">زمن الإقلاع</th>
                    <td class="_col-4"><?= $travel['departure_full_time'] ?></td>
                </tr>
                <tr class="_row">
                    <th class="_col-2 off-white" style="width: 120px">القطار</th>
                    <td class="_col-4"><?= $travel['train_name'] ?></td>
                    <th class="_col-2 off-white" style="width: 120px">تاريخ الوصول</th>
                    <td class="_col-4"><?= $travel['arrival_date'] ?></td>
                </tr>
                <tr class="_row">
                    <th class="_col-2 off-white" style="width: 120px">تاريخ الإنشاء</th>
                    <td class="_col-4"><?= date("Y-m-d", strtotime($travel['created_at'])) ?></td>
                    <th class="_col-2 off-white" style="width: 120px">زمن الوصول</th>
                    <td class="_col-4"><?= $travel['arrival_full_time'] ?></td>
                </tr>
                <tr class="_row">
                    <th class="_col-2 off-white" style="width: 120px">الحالة</th>
                    <td class="_col-4"><?= $travel['status_text'] ?></td>
                    <th class="_col-2 off-white" style="width: 120px"></th>
                    <td class="_col-4">
                        <a href="travel.php?travel_id=<?= $travel['id'] ?>" class="btn btn-info">
                            <span>عرض</span>
                        </a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-xs-12 col-md-6">
            <h3>
                <i class="mdi mdi-ticket"></i>
                <span>التذكرة</span>
            </h3>
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
                    <th class="_col-2 off-white" style="width: 120px">رقم التذكرة</th>
                    <td class="_col-4"><?= $ticket['id'] ?></td>
                    <th class="_col-2 off-white" style="width: 120px">الإسم</th>
                    <td class="_col-4"><?= $ticket['passenger_name'] ?></td>
                </tr>
                <tr class="_row">
                    <th class="_col-2 off-white" style="width: 120px">الفئة</th>
                    <td class="_col-4"><?= $ticket['level']['level_name'] ?></td>
                    <th class="_col-2 off-white" style="width: 120px">الجنس</th>
                    <td class="_col-4"><?= $ticket['passenger_gender'] ?></td>
                </tr>
                <tr class="_row">
                    <th class="_col-2 off-white" style="width: 120px">سعر التذكرة</th>
                    <td class="_col-4"><?= number_format($ticket['price'], 2) ?></td>
                    <th class="_col-2 off-white" style="width: 120px">رقم الهاتف</th>
                    <td class="_col-4"><?= $ticket['passenger_phone'] ?></td>
                </tr>
                <tr class="_row">
                    <th class="_col-2 off-white" style="width: 120px">رقم المقعد</th>
                    <td class="_col-4"><?= $ticket['seat'] ?></td>
                    <th class="_col-2 off-white" style="width: 120px">العنوان</th>
                    <td class="_col-4"><?= $ticket['passenger_address'] ?></td>
                </tr>
                <tr class="_row">
                    <th class="_col-2 off-white" style="width: 120px">الحالة</th>
                    <td class="_col-4"><?= $ticket['status_text'] ?></td>
                    <th class="_col-2 off-white" style="width: 120px"></th>
                    <td class="_col-4"></td>
                </tr>
            </table>
        </div>
    </div>
<?php else: ?>
    <form action="" method="get" class="form-inline">
        <label for="ticket_id">بحث عن تذكرة</label>
        <div class="input-group input-group-lg">
            <input type="number" name="ticket_id" id="ticket_id" class="form-control" placholder="ادخل اسم التذكرة هنا" required>
            <div class="input-group-btn">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-search"></i>
                    <span>بحث</span>
                </button>
            </div>
        </div>
    </form>
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
    const levels = <?= json_encode($levels) ?>;
    const levels_seats = <?= json_encode($levels_seats) ?>;
    function setLevelSeats(level_id = null)
    {
        let level = level_id ? levels.filter(function(l){ return l.id == level_id; })[0] : levels[0];
        let level_seats = levels_seats[level.id];
        let _options = ``;
        for (let index = 0; index < level_seats.length; index++) {
            const seat = level_seats[index];
            _options += `
                <option value="` + seat + `">` + seat + `</option>
            `;
        }
        $('select#seat').html(_options)
        $('input[name=price]').val(level.ticket_price)
    }
    
    $(function(){
        setLevelSeats()
        $(document).on('change', 'select[name=level_train_id]', function(){
            setLevelSeats($(this).val())
        });
        $('.icon-label').click(function(){
            $('.icon-label').removeClass('active');
            $(this).addClass('active');
        })

        // // Add minus icon for collapse element which is open by default
        // $(".collapse.show").each(function(){
        // 	$(this).prev(".panel-heading").find(".fa").addClass("fa-minus").removeClass("fa-plus");
        // });
        
        // // Toggle plus minus icon on show hide of collapse element
        // $(".collapse").on('show.bs.collapse', function(){
        // 	$(this).prev(".panel-heading").find(".fa").removeClass("fa-plus").addClass("fa-minus");
        // }).on('hide.bs.collapse', function(){
        // 	$(this).prev(".panel-heading").find(".fa").removeClass("fa-minus").addClass("fa-plus");
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