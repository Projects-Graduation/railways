<?php 
require 'init.php';
// die(var_dump($user));
$_SESSION["page"] = "travels";
$title = "الرئيسية";
$travel_id = param('travel_id'); //isset($_GET['travel_id']) && !empty($_GET['travel_id']) && is_numeric($_GET['travel_id']) ? $_GET['travel_id'] : false;
$travel = getTravel($travel_id);
if ($travel_id && !array_key_exists('id', $travel)) {
    flash('alert-danger', 'لا توجد رحلة بهذا الرقم');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

$stations = roadStations($travel['road_id'], ['number', 'ASC']);
$cities = array_in_column('city_id', $stations, true);
// dd(array_unique($cities));
?>
<?php include 'includes/layout/header.php'; ?>
    <div class="row">
        <div class="col-xs-12">
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
                            <th class="_col-2 off-white" style="width: 120px">المعرف</th>
                            <td class="_col-4"><?= $travel['id'] ?></td>
                            <th class="_col-2 off-white" style="width: 120px">تاريخ الإقلاع</th>
                            <td class="_col-4"><?= $travel['departure_date'] ?></td>
                        </tr>
                        <tr class="_row">
                            <th class="_col-2 off-white" style="width: 120px">الخط</th>
                            <td class="_col-4"><?= $travel['road_link'] ?></td>
                            <th class="_col-2 off-white" style="width: 120px">زمن الإقلاع</th>
                            <td class="_col-4"><?= $travel['departure_full_time'] ?></td>
                        </tr>
                        <tr class="_row">
                            <th class="_col-2 off-white" style="width: 120px">القطار</th>
                            <td class="_col-4"><?= $travel['train_link'] ?></td>
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
                            <td class="_col-4"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <h3>
        <i class="fa fa-map-marker"></i>
        <span>المحطات</span>
    </h3>
    <div id="Timeline" class="Timeline">
        <div class="Timeline-line">
            <div class="Timeline-line-menu"></div>
        </div>
        <?php $counter = 1; foreach($stations as $data): $station = station($data); ?>
            <div class="Timeline-item Timeline-item--image <?= $counter % 2 == 0 ? 'is-right' : '' ?>">
                <div class="Timeline-item-inner">
                    <div class="Timeline-item-index"><?= $counter < 10 ? '0' . $counter : $counter ?></div>
                    <div class="Timeline-item-top">
                        <div class="Timeline-item-top-type">
                            <i></i> <span>محطة:</span><span><?= $station['name'] ?></span>				
                        </div>

                    </div>
                    <div class="Timeline-item-content">
                        <div class="Timeline-item-content-title">
                            مدينة: <?= $station['city_name'] ?>
                        </div>
                        <!-- <div class="Timeline-item-content-title">
                        </div> -->
                        <div class="Timeline-item-content-body">
                            <img src="<?= $station['image_url'] ?>">
                            <p><?= $station['description'] ?></p>
                        </div>
                    </div>

                </div>
            </div>
        <?php $counter++; endforeach;?>
    </div>
<?php include 'includes/layout/footer_open.php'; ?>
<style>
    @charset "UTF-8";
    /*--------------------------------------------

    Name:     Timeline
    Created:  13/02/15
    Author:   Raúl Hernández <raulghm@gmail.com>
    Github:   raulghm

    ----------------------------------------------*/
    /*
    Using BEM SuitCSS variant, see: https://github.com/suitcss/suit/blob/master/doc/naming-conventions.md
    */
    .cf:before, .Timeline-item:before, .Timeline-item-top:before,
    .cf:after,
    .Timeline-item:after,
    .Timeline-item-top:after {
    content: " ";
    /* 1 */
    display: table;
    /* 2 */
    }

    .cf:after, .Timeline-item:after, .Timeline-item-top:after {
    clear: both;
    }

    /**
    * For IE 6/7 only
    * Include this rule to trigger hasLayout and contain floats.
    */
    .cf, .Timeline-item, .Timeline-item-top {
    *zoom: 1;
    }

    .Timeline {
    width: 830px;
    margin: 0 auto;
    position: relative;
    }
    .Timeline-line {
    width: 40px;
    height: 100%;
    position: absolute;
    left: 50%;
    margin-left: -20px;
    padding-left: 20px;
    cursor: pointer;
    }
    .Timeline-line:after {
    content: "";
    position: absolute;
    border-left: 1px solid #dedede;
    height: 100%;
    }
    .Timeline-line.is-active .Timeline-line-menu {
    opacity: 1;
    }
    .Timeline.is-dragging .Timeline-item-inner {
    margin: 0;
    opacity: .7;
    }
    .Timeline-item {
    width: 45.8%;
    margin-right: 56.2%;
    position: relative;
    z-index: 90;
    }
    .Timeline-item-inner {
    position: relative;
    margin-bottom: 40px;
    width: 345px;
    border: 1px solid #dedede;
    -webkit-transition: all .3s ease;
    transition: all .3s ease;
    margin: -10px 0 -20px;
    }
    .Timeline-item-inner:before {
    content: "";
    position: absolute;
    top: 50%;
    right: -78px;
    border-radius: 50%;
    -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
    background-color: #999;
    width: 12px;
    height: 12px;
    }
    .Timeline-item-inner:after {
        content: "";
        width: 20px;
        height: 20px;
        position: absolute;
        right: -9px;
        top: 50%;
        height: 0;
        width: 0;
        border-bottom: 8px solid transparent;
        border-left: 8px solid #dedede;
        border-top: 8px solid transparent;
        -webkit-transform: translateY(-50%);
                transform: translateY(-50%);
        -webkit-transition: all .2s ease;
        transition: all .2s ease;
    }
    .Timeline-item:hover {
        -moz-user-select: none;
        -ms-user-select: none;
            user-select: none;
        -webkit-user-select: none;
    }
    .Timeline-item:hover:after {
    border-left-color: #999;
    }
    .Timeline-item:hover .Timeline-item-inner {
    border-color: #999;
    }
    .Timeline-item:hover .Timeline-item-inner:after {
        height: 0;
        width: 0;
        border-bottom: 8px solid transparent;
        border-left: 8px solid #999;
        border-top: 8px solid transparent;
    }
    .Timeline-item:hover .Timeline-item-top-tools {
    opacity: 1;
    }
    .Timeline-item:nth-child(odd) {
    margin-right: 0;
    width: 45.8%;
    margin-left: 56.2%;
    padding-left: 70px;
    }
    .Timeline-item:nth-child(odd):hover .Timeline-item-inner:after {
    height: 0;
    width: 0;
    border-bottom: 8px solid transparent;
    border-right: 8px solid #999;
    border-top: 8px solid transparent;
    }
    .Timeline-item:nth-child(odd) .Timeline-item-inner:before {
    right: auto;
    left: -77px;
    }
    .Timeline-item:nth-child(odd) .Timeline-item-inner:after {
    height: 0;
    width: 0;
    border-bottom: 8px solid transparent;
    border-right: 8px solid #c9c9c9;
    border-top: 8px solid transparent;
    border-left: 0;
    right: auto;
    left: -9px;
    }
    .Timeline-item:nth-child(odd) .Timeline-item-index {
    opacity: .6;
    left: -45px;
    right: auto;
    }
    .Timeline-item.is-dropping {
    cursor: -webkit-grabbing;
    }
    .Timeline-item-index {
    position: absolute;
    right: -45px;
    top: 50%;
    -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
    color: #c9c9c9;
    font-size: 24px;
    font-size: 2.4rem;
    font-weight: 200;
    font-family: Georgia, "Times New Roman", Times, serif;
    }
    .Timeline-item--quote .Timeline-item-content {
    font-family: Georgia, "Times New Roman", Times, serif;
    }
    .Timeline-item--image .Timeline-item-content-body img {
    max-width: 100%;
    margin-top: 5px;
    }
    .Timeline-item-top {
    background-color: #f8f8f8;
    padding: 10px 15px;
    }
    .Timeline-item-top:hover {
    cursor: move;
    cursor: -webkit-grab;
    }
    .Timeline-item-top-type {
    float: left;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 11px;
    font-size: 1.1rem;
    }
    .Timeline-item-top-type i {
    font-size: 16px;
    font-size: 1.6rem;
    }
    .Timeline-item-top-type span {
    margin-left: 10px;
    }
    .Timeline-item-content {
    background-color: #fff;
    padding: 10px 20px 20px;
    text-align: left;
    }
    .Timeline-item-content-title {
    font-size: 18px;
    font-size: 1.8rem;
    }
    .Timeline-item-content-image {
    background-size: cover;
    background-position: 50%;
    background-repeat: no-repeat;
    height: 135px;
    width: 341px;
    margin-top: 10px;
    margin-left: -20px;
    }
    .Timeline-item-content-body {
    position: relative;
    }
    .Timeline-item-content-body:empty {
    display: none;
    }
</style>
<script>
    /* Sortable — is a minimalist JavaScript library for reorderable drag-and-drop lists on modern browsers and touch devices. No jQuery. Supports Meteor, AngularJS, React and any CSS library, e.g. Bootstrap.
    https://github.com/RubaXa/Sortable */

    var $component = 'Timeline';

	function sort() {
		var $itemIndex = 0;

		console.log('reorder');
		
		$('.' + $component).find('.' + $component + '-item').each(function(index) {

			index++;
			$itemIndex = (index < 10) ? '0' + index : index;
			
			$(this).find('.' + $component + '-item-index').text($itemIndex);

			if (index % 2 === 0) {
        $(this).addClass('is-right');
      }
      else {
        $(this).removeClass('is-right');
      }

		});
	}

	$(document).ready(function(){
						 sort();

	 	var el = document.getElementById($component);
      var sortable = Sortable.create(el, {
        draggable: '.' + $component + "-item", 
        handle: '.' + $component + "-item-top",
        animation: 250,
        scroll: true, // or HTMLElement
        scrollSensitivity: 60, // px, how near the mouse must be to an edge to start scrolling.
        scrollSpeed: 10, // px
        ghostClass: "is-dropping",

        onStart: function (event) {
          $('.' + $component).toggleClass('is-dragging');
          console.log('onStart')
        },

        onEnd: function (event) {
          $('.' + $component).toggleClass('is-dragging');
          sort();
        },

      });
	});
</script>
<?php include 'includes/layout/footer_close.php'; ?>