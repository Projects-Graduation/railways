<?php require 'init.php';
// $addons=['datatables'];
$icons = ['food food-apple-and-grapes-on-a-bowl', 'food food-apple-cut-in-half-with-visible-seeds', 'food food-apple-with-stem-and-leaf', 'food food-barbacue-utensils', 'food food-barbecue-grill', 'food food-beer-in-glass-and-bottle', 'food food-beer-pint', 'food food-bowl-of-hot-soup-on-a-plate', 'food food-burger-and-soda-with-straw', 'food food-cabbage', 'food food-cheers', 'food food-cheese-with-little-cutted-triangular-piece', 'food food-chef-with-hat', 'food food-cherries-with-stem', 'food food-chicken-leg', 'food food-chocolate-donut-with-sprinkles', 'food food-cocktail-drink-with-stirrer', 'food food-coffee-jar', 'food food-coffee-jar-and-filter', 'food food-coffee-maker-machine', 'food food-cooking-food-in-a-hot-casserole', 'food food-corn-with-leaves', 'food food-croissant', 'food food-cucumber-cut-in-half', 'food food-cupcake-dessert', 'food food-dining-meal-covered', 'food food-dish-cover', 'food food-eggplant-rotated-to-left', 'food food-fire-flames', 'food food-fish-tail-bone', 'food food-food-observation', 'food food-food-on-a-stick', 'food food-french-fries-on-container', 'food food-fresh-carrot', 'food food-fried-chicken-leg-on-a-plate', 'food food-fried-egg', 'food food-giant-pumpkin', 'food food-glass-of-wine-and-bottle', 'food food-grapes-and-pear-on-a-platter', 'food food-grapes-with-leaf-and-stem', 'food food-half-avocado', 'food food-half-lemon', 'food food-hamburger-with-sesame-seeds', 'food food-heating-pad', 'food food-horizontal-lemon', 'food food-hot-bread-with-smoke', 'food food-hot-coffee-on-a-tall-paper-cup', 'food food-hot-dogs-package', 'food food-hot-dog-with-sauce-and-bread', 'food food-hot-drink-on-a-cup-button', 'food food-hot-fish', 'food food-hot-fish-bone', 'food food-hot-kitchen-pot', 'food food-hot-meal-sign', 'food food-hot-pepper', 'food food-hot-pot', 'food food-hot-soup', 'food food-ice-cream-cone', 'food food-icecream-cup', 'food food-ice-cream-in-glass', 'food food-leaves-of-herbs', 'food food-loaves-of-bread', 'food food-long-cofee-pot', 'food food-meat-slice', 'food food-milk-jar-with-label', 'food food-milk-package', 'food food-noodle-soup-on-a-bowl', 'food food-onion-bulb', 'food food-onion-bulb-1', 'food food-opened-peas', 'food food-orange-with-leaf', 'food food-packed-sausage', 'food food-pair-of-gloves', 'food food-paper-cupcake', 'food food-peach-piece', 'food food-preserved-in-a-bottle', 'food food-restaurant-station-card', 'food food-restaurant-utensils', 'food food-rice-bowl-with-chopsticks', 'food food-sausage-on-a-fork', 'food food-sausage-on-a-fork-1', 'food food-small-mushroom', 'food food-spoon-and-fork-upside-down', 'food food-squid', 'food food-strawberry', 'food food-sushi-platter-with-chopsticks', 'food food-take-away-tacos', 'food food-tea-bag-with-tag', 'food food-teapot-and-cup', 'food food-three-balls-ice-cream-cone', 'food food-three-bananas', 'food food-tomato-healthy-veggie', 'food food-traditional-mate', 'food food-tube-glass-with-shine', 'food food-two-layer-birthday-cake-with-candle', 'food food-upsized-drink-with-straw', 'food food-very-hot-drink-with-shine', 'food food-watermelon-slice', 'food food-wine-bottle-in-bucket-with-two-glasses', 'food food-wine-crystal-cup',];
$operation = param('operation') ? param('operation') : 'add';
$station_id = isset($_GET['station_id']) && !empty($_GET['station_id']) && is_numeric($_GET['station_id']) ? $_GET['station_id'] : false;
$operation = $operation == 'add' && $station_id ? 'show' : $operation;

$station = $station_id ? getStation($station_id) : false;
$_SESSSION['page']   = 'station';
$title  = $station_id ? 'محطة ' . $station['name'] : 'إضافة محطة';
$title = $operation == 'edit' ? 'تعديل محطة ' . $station['name'] : $title;
$link = ['title' => 'محطة', 'url' => 'stations.php', 'icon' => 'success'];
$stationStations     = stationStations($station_id, ['created_at', 'DESC']);


include "includes/layout/header.php"; ?>
<?php if($operation == 'add'):?>
	<form action="stations.php?operation=add-station" method="post">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <div class="image-wrapper">
                        <div class="image-previewer"></div>
                        <label class="btn btn-gradient-primary">
                            <i class="fa fa-image"></i>
                            <span>إختر الصورة</span>
                            <input type="file" name="image" />
                        </label>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <h4 class="card-header">
                        <span class="fa fa-fw fa-lg fa-list"></span>
                        بيانات المحطة
                    </h4>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label   class="boxy boxy-left boxy-sm" for="title">إسم المحطة: </label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="name" required class="form-control" id="name" placeholder="اكتب اسم المحطة هنا">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="description"  class="boxy boxy-left boxy-sm">وصف للمحطة: </label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="description" required class="form-control" id="description" placeholder="اكتب وصف للمحطة هنا">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="operation" value="add-station">
                            <button type="submit" class="btn btn-gradient-primary">
                                <i class="fa fa-fw fa-plus"></i>
                                <span>إضافة</span> 
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</form>
<?php elseif($operation == 'edit' && $station):?>
    <h4>
		<span class="fa fa-fw fa-lg fa-edit"></span>
		<span><?= $title ?></span>
	</h4>
	<hr class="st12"></hr>
	<form action="stations.php?operation=edit-station" method="post">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group clearfix">
                    <div class="col-md-4">
                        <label   class="boxy boxy-left boxy-sm" for="title">إسم المحطة: </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="name" value="<?= array_key_exists('name', $station) ? $station['name'] : '' ?>" required class="form-control" id="name" placeholder="اكتب اسم المحطة هنا">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <div class="col-md-4">
                        <label for="description"  class="boxy boxy-left boxy-sm">وصف للمحطة: </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="description" value="<?= array_key_exists('description', $station) ? $station['description'] : '' ?>" required class="form-control" id="description" placeholder="اكتب وصف للمحطة هنا">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <div class="col-md-4">
                        <label for="price"  class="boxy boxy-left boxy-sm">ايقونة المحطة: </label>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <?php foreach($icons as $icon):?>
                                <div class="col-md-2"><label class="icon-label <?= $station['icon'] == $icon ? 'active' : '' ?>"><input type="radio" name="icon" value='<?= $icon ?>' <?= $station['icon'] == $icon ? 'selected' : '' ?>><i class='<?= $icon ?>'></i></label></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="hidden" name="operation" value="edit-station">
                    <input type="hidden" name="station_id" value="<?= $station['id'] ?>">
                    <input type="hidden" name="old_image" value="<?= $station['image'] ?>">
                    <button type="submit" class="btn btn-gradient-primary">
                        <i class="fa fa-fw fa-save"></i>
                        <span>حفظ التعديلات</span> 
                    </button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <div class="image-wrapper">
                        <div class="image-previewer" style="background-image: url(<?= $station['image_url'] ?>);"></div>
                        <label class="btn btn-gradient-primary">
                            <i class="fa fa-image"></i>
                            <span>إختر الصورة</span>
                            <input type="file" name="image" />
                        </label>
                    </div>
                </div>
            </div>
        </div>
	</form>
<?php else: ?>
    <div class="card">
        <div class="card-heading">
            <h4 class="reset pull-right">
                <i class="fa fa-list"></i>
                <span>محطة <?= $station['name'] ?></span>
            </h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <form id="change-image-form" action="?change-image" method="POST">
                        <div class="image-wrapper">
                            <div class="image-previewer" style="background-image: url(<?= $station['image_url'] ?>);"></div>
                            <label class="btn btn-gradient-primary">
                                <i class="fa fa-image"></i>
                                <span>تغيير الصورة</span>
                                <input type="file" id="image-input" name="image"/>
                            </label>
                        </div>
                        <input type="hidden" name="name" value="<?= $station['image'] ?>">
                    </form>
                </div>
                <div class="col-xs-12 col-md-8">
                    <table class="table table-striped table-hover">
                        <tbody>
                            <tr>
                                <th style="width: 120px;">المعرف</th>
                                <td><?= $station['id'] ?></td>
                            </tr>
                            <tr>
                                <th>الوصف</th>
                                <td><?= $station['description'] ?></td>
                            </tr>
                            <tr>
                                <th>تاريخ الإنشاء</th>
                                <td><?= date("Y-m-d", strtotime($station['created_at'])) ?></td>
                            </tr>
                            <tr>
                                <th>الخيارات</th>
                                <td>
                                    <a href="station.php?station_id=<?= $station['id'] ?>&operation=edit" class="btn btn-info">
                                        <span>تعديل</span>
                                    </a>
                                    <a href="<?= actionUrl('stations.php', ['station_id', $station['id']], 'delete') ?>" class="btn btn-danger" data-toggle="confirm">
                                        <span>حذف</span>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-heading clearfix">
            <h4 class="reset pull-right">
                <i class="fa fa-th-large"></i>
                <span>الاصناف</span>
            </h4>
            <div class="card-tools pull-left">
                <a href="add-item.php?station_id=<?= $station['id'] ?>" class="btn btn-gradient-primary">
                    <i class="fa fa-plus"></i>
                    <span>اضافة صنف</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover table-condensed datatable">
                <thead>
                    <tr>
                        <th>الإسم</th>
                        <th>تاريخ الإضافة</th>
                        <th class="col-md-3">العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stationStations as $item): ?>
                        <tr>
                            <td><?= $item['title'] ?></td>
                            <td><?= date("Y-m-d", strtotime($item['created_at'])) ?></td>
                            <td style="width: 190px;">
                                <a href="item.php?item_id=<?= $item['id'] ?>" class="btn btn-xs btn-default">
                                    عرض
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="add-item.php?item_id=<?= $item['id'] ?>" class="btn btn-xs btn-info">
                                    تعديل
                                </a>
                                <!-- <a href="<?= actionUrl('items.php', ['item_id', $item['id']], 'delete') ?>" class="btn btn-xs btn-danger confirm">
                                    حذف
                                </a> -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif;?>
<?php include "includes/layout/footer_open.php"; ?>
<script>
    $(function(){
        $('.icon-label').click(function(){
            $('.icon-label').removeClass('active');
            $(this).addClass('active');
        })
    })
</script>
<?php include "includes/layout/footer_close.php"; ?>