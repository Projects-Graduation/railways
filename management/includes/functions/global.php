<?php
function layout($layout = 'header')
{
    require LAYOUT_PATH . $layout . '.php';
}
function printReport($operation, $niddle, $title, $prev_page = "index.php")
{
    return APP_URL . '/report.php?operation=' . $operation . '&' . $niddle[0] . '=' . $niddle[1] . '&title=' . $title. '&prev_page=' . $prev_page;
}

function goBack()
{
    $prev = param('prev') ? param('prev') : $_SERVER['HTTP_REFERER'];
    header("Location: " . $prev);
    exit;
}

function asset($fileName, $dest = 'css', $location = APP_URL)
{
    return $location . '/assets/' . $dest . '/' . $fileName;
}
function plugin($file)
{
    return WEBSITE_URL . '/src/plugins/' . $file;
}
function path_for($path)
{
    return APP_URL . '/' . $path;
}
function param($name)
{
    if (isset($_GET[$name]) && !empty($_GET[$name])) {
        return $_GET[$name];
    }elseif (isset($_POST[$name]) && !empty($_POST[$name])) {
        return $_POST[$name];
    }elseif (isset($_FILES[$name]) && !empty($_FILES[$name])) {
        return $_FILES[$name];
    }
    
    return false;
}
function actionUrl($page, $primary = null, $operation = 'edit')
{
    return APP_URL . "/" . $page . '?operation=' . $operation . '&' .$primary[0]. '=' . $primary[1];
}

function getOrRedirect($tableName, $value, $pk = 'id', $prev = null){
	$row = get($tableName, $value, $pk);
	if ($row) {
		return $row;
	}else{
		$message = 'لا توجد بيانات للمعرف: ' . $value;
		// $prev_location = is_null($prev) ? $_SERVER['HTTP_REFERER'] : $prev;
		header("Location: " . APP_URL . '/404.php?message=' . $message);
	}
}

function redirect($location)
{
    header("Location: " . $location);
    exit;
}
function limit_text($text, $limit) {
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        $text = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}


function home()
{
    echo '<script type="text/javascript">window.location = "index.php"</script>';
}

function back()
{
    header('location: ' . $_SERVER['HTTP_REFERER']);
}

function filterPW ($string) {
    return filterStr(sha1($string));
}

function filterInt($input)
{
    return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
}

function filterFloat($input)
{
    return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

function filterStr($input)
{
    return htmlentities(strip_tags($input, ENT_QUOTES));
}


function flash( $name = '', $message = '', $class = NULL )
{
    //We can only do something if the name isn't empty
    if( !empty( $name ) )
    {
        //No message, create it
        if( !empty( $message ) && empty( $_SESSION[$name] ) )
        {
            if( !empty( $_SESSION[$name] ) )
            {
                unset( $_SESSION[$name] );
            }
            if( !empty( $_SESSION[$class] ) )
            {
                unset( $_SESSION[$class] );
            }
            
            $_SESSION[$name] = $message;
            if (isset($class)) {
                $_SESSION['class'] = $class;
            } else {
                $_SESSION['class'] = 'success';
            }
        }
        //Message exists, display it
        elseif( !empty( $_SESSION[$name] ) && empty( $message ) )
        {
            $class = !empty( $_SESSION[$class] ) ? $_SESSION[$class] : 'success';
            echo $_SESSION[$name];
            unset($_SESSION[$name]);
            unset($_SESSION[$class]);
        }
    }
}

function image($item, $maxHeight = 240)
{
	echo '<div class="image-container">
		<div class="image-box" style="max-height:'.$maxHeight.'px;">
			<img src="' . itemImageFunc($item) . '"  alt="card-img" class="image">
		</div>
	</div>';
}


function itemCard($item, $isMeal = null)
{
	$editPage = isset($isMeal) ? 'edit-meal' : 'edit-item';
	$table = isset($isMeal) ? 'meals' : 'items';
	$price = isset($isMeal) ? mealPrice($item['id']) : $item['price'];
	echo '<div class="info-card">
		<div class="image-container"><div class="image-box"><img src="' .itemImageFunc($item) . '" alt="card-image" class="image"></div></div>
		<div class="header">
			<div class="title">
				<h4>' . $item['title'] . '</h4>
			</div>
		</div>
		<div class="footer">
			<button class="btn btn-gradient-primary btn-block details" type="button" data-toggle="collapse" data-target="#details' . $item['id'] . '" aria-expanded="false" aria-controls="details' . $item['id'] . '">
				<div class="show-details">
					<span class="pull-right">
						<span class="fa fa-fw fa-eye"></span>
						إظهار التفاصيل
					</span>
				</div>
				<div class="hide-details hide">
					<span class="pull-right">
						<span class="fa fa-fw fa-eye-slash"></span>
						إخفاء التفاصيل
					</span>
				</div>
				<span class="badge price pull-left">' . $price . ' ج</span>
			</button>
			<div class="collapse" id="details' . $item['id'] . '">
				<div class="list-group">
					<div class="list-group-item">
						' . $item['description'] . '
					</div>';
				if (isset($isMeal)) {
					echo '
					 <div class="list-group-item active">
						المحتويات
						<span class="fa fa-fw fa-angle-down pull-left"></span>
					</div>';
					foreach (mealItems($item['id']) as $MealItem){
						echo '<a href="item.php?id=' . $MealItem['id']. '" class="list-group-item">
							' . $MealItem['title']. '
							<span class="badge pull-left">' . $MealItem['price']. ' ج</span>
						</a>';
					}
					echo '<div class="list-group-item">
						المجموع
						<span class="badge pull-left">' . $price . ' ج</span>
					</div>';
				}
					echo '<div class="list-group-item clearfix">
						<a href="' . $editPage . '.php?id=' . $item['id'] . '" class="label label-info pull-right">
							تعديل
							<span class="fa fa-fw fa-edit"></span>
						</a>
						<a href="includes/store/delete.php?table=' . $table .'&id=' . $item['id'] . '" class="label label-danger pull-left">
							حذف
							<span class="fa fa-fw fa-trash"></span>
						</a>
					</div>
				</div>
				<div class="footer clearfix">
				</div>
			</div>
		</div>
	</div>';
}


function availableOrders()
{
	return where('orders', ['status' => 1], '=', ['updated_at', 'DESC']);
}

function availableReservations()
{
	return where('reservations', ['status' => 1], '=', ['updated_at', 'DESC']);
}

function availableItems()
{
	return where('items', ['status' => 1], '=', ['updated_at', 'DESC']);
}

function availableMeals()
{
	return where('meals', ['status' => 1], '=', ['updated_at', 'DESC']);
}

function status($stat)
{
	if ($stat == 1) {
		echo 'جاري ...';
	}else {
		echo 'تم <span class="fa fa-fw fa-check-circle"></span>';
	}
}

function itemImage($item)
{
	if (isset($item['menu'])) {
		switch ($item['menu']) {
			case 'مشروبات ساخنة':
				echo IMG_PATH . 'hot_drinks' . DS . $item['img'];
				break;
			case 'مشروبات باردة':
				echo IMG_PATH . 'cold_drinks' . DS . $item['img'];
				break;
			case 'الحلويات':
				echo IMG_PATH . 'sweets' . DS . $item['img'];
				break;
			case 'المثلجات':
				echo IMG_PATH . 'icecream' . DS . $item['img'];
				break;
			case 'مأكولات غربية':
				echo IMG_PATH . 'western' . DS . $item['img'];
				break;
			case 'مأكولات سودانية':
				echo IMG_PATH . 'sudanese' . DS . $item['img'];
				break;
			default:
				echo IMG_PATH . 'western' . DS . $item['img'];
				break;
		}
	}else {
		echo IMG_PATH . 'meal' . DS . $item['img'];
	}
}

function itemImageFunc($item)
{
	if (isset($item['menu'])) {
		switch ($item['menu']) {
			case 'مشروبات ساخنة':
				return IMG_PATH . 'hot_drinks' . DS . $item['img'];
				break;
			case 'مشروبات باردة':
				return IMG_PATH . 'cold_drinks' . DS . $item['img'];
				break;
			case 'الحلويات':
				return IMG_PATH . 'sweets' . DS . $item['img'];
				break;
			case 'المثلجات':
				return IMG_PATH . 'icecream' . DS . $item['img'];
				break;
			case 'مأكولات غربية':
				return IMG_PATH . 'western' . DS . $item['img'];
				break;
			case 'مأكولات سودانية':
				return IMG_PATH . 'sudanese' . DS . $item['img'];
				break;
			default:
				return IMG_PATH . 'western' . DS . $item['img'];
				break;
		}
	}else {
		return IMG_PATH . 'meal' . DS . $item['img'];
	}
}


function imagePath($item)
{
	if (isset($item['menu'])) {
		switch ($item['menu']) {
			case 'مشروبات ساخنة':
				return HOT_STORE;
				break;
			case 'مشروبات باردة':
				return COLD_STORE;
				break;
			case 'الحلويات':
				return SWEETS_STORE;
				break;
			case 'المثلجات':
				return ICECREAM_STORE;
				break;
			case 'مأكولات غربية':
				return WESTERN_STORE;
				break;
			case 'مأكولات سودانية':
				return SUDANESE_STORE;
				break;
			default:
				return WESTERN_STORE;
				break;
		}
	}else {
		return MEAL_STORE;
	}
}


function itemPage($item)
{
	switch ($item) {
		case 'مشروبات ساخنة':
			echo "<a href='drinks.php'>" . $item . "</a>";
			break;
		case 'مشروبات باردة':
			echo "<a href='drinks.php'>" . $item . "</a>";
			break;
		case 'الحلويات':
			echo "<a href='sweets.php'>" . $item . "</a>";
			break;
		case 'المثلجات':
			echo "<a href='icecream.php'>" . $item . "</a>";
			break;
		default:
			echo "<a href='food.php'>" . $item . "</a>";
			break;
	}
}

function itemSearch($items, $field, $fieldValue)
{
	$result = [];
	foreach ($items as $item => $value) {
		if ($item[$field] == $fieldValue) {
			$result [] = $item;
		}
	}
	return $result;
}
function url($pageName, $extension = null)
{
	$admin_root = @$_SERVER['HOST_NAME'];
	$extension = isset($extension) ? $extension : '.php';
	$file = $pageName . $extension;
	if (file_exists($file)) {
		echo $file;
	}else {
		$file = '..' . DIRECTORY_SEPARATOR . $pageName . $extension;
		if (file_exists($file)) {
			echo 'fastfood.test' . DIRECTORY_SEPARATOR . $pageName . $extension;
		}else {
			echo '#';
		}
	}

}
function page($pageName, $extension = null)
{
	$extension = isset($extension) ? $extension : '.php';
	$file = $pageName . $extension;
	if (file_exists($file)) {
		echo $file;
	}else {
		echo '#';
	}
}
function dd($data)
{
	echo '<pre>';
	die(var_dump($data));
	echo '</pre>';
}
function source($path, $location = WEBSITE_URL)
{
	return $location . '/src/' . $path;
}
function src($file, $path = null){
	switch ($path) {
		case 'img':
			echo IMG_PATH . $file;
			break;
		case 'js':
			echo JS_PATH . $file;
			break;
		case 'font':
			echo FONTS_PATH . $file;
			break;
		case 'plugin':
			echo PLUGINS_PATH . $file;
			break;
		case 'ajax':
			echo AJAX_PATH . $file;
			break;
		case 'store':
			echo STORE_PATH . $file;
			break;
		default:
			echo CSS_PATH . $file;
			break;
	}
}
function sources($files, $type = null)
{
	switch ($type) {
		case 'js':
			foreach ($files as $fileName) {
				$filePath = JS_PATH . $fileName . '.js';
				echo "<script type='text/javascript' src='{$filePath}'></script>\n";
			}
			break;
		default:
			foreach ($files as $fileName) {
				$filePath = CSS_PATH . $fileName . '.css';
				echo "<link rel='stylesheet' type='text/css' href='{$filePath}'>\n";
			}
			break;
	}
}

function getData($input, $filter = null)
{
	switch ($filter) {
		case 'int':
			return filterInt($_GET[$input]);
			break;
		case 'float':
			return filterFloat($_GET[$input]);
			break;
		case 'pw':
			return filterPW($_GET[$input]);
			break;
		default:
			return filterStr($_GET($input));
			break;
	}
}

function postData($input, $filter = null)
{
	switch ($filter) {
		case 'int':
			return filterInt($_POST[$input]);
			break;
		case 'float':
			return filterFloat($_POST[$input]);
			break;
		case 'pw':
			return filterPW($_POST[$input]);
			break;
		case '[]':
			return $input;
			break;
		default:
			return filterStr($_POST[$input]);
			break;
	}
}





// Random letters and numbers function


function assign_rand_value($num) {

    // accepts 1 - 36
    switch($num) {
        case "1"  : $rand_value = "a"; break;
        case "2"  : $rand_value = "b"; break;
        case "3"  : $rand_value = "c"; break;
        case "4"  : $rand_value = "d"; break;
        case "5"  : $rand_value = "e"; break;
        case "6"  : $rand_value = "f"; break;
        case "7"  : $rand_value = "g"; break;
        case "8"  : $rand_value = "h"; break;
        case "9"  : $rand_value = "i"; break;
        case "10" : $rand_value = "j"; break;
        case "11" : $rand_value = "k"; break;
        case "12" : $rand_value = "l"; break;
        case "13" : $rand_value = "m"; break;
        case "14" : $rand_value = "n"; break;
        case "15" : $rand_value = "o"; break;
        case "16" : $rand_value = "p"; break;
        case "17" : $rand_value = "q"; break;
        case "18" : $rand_value = "r"; break;
        case "19" : $rand_value = "s"; break;
        case "20" : $rand_value = "t"; break;
        case "21" : $rand_value = "u"; break;
        case "22" : $rand_value = "v"; break;
        case "23" : $rand_value = "w"; break;
        case "24" : $rand_value = "x"; break;
        case "25" : $rand_value = "y"; break;
        case "26" : $rand_value = "z"; break;
        case "27" : $rand_value = "0"; break;
        case "28" : $rand_value = "1"; break;
        case "29" : $rand_value = "2"; break;
        case "30" : $rand_value = "3"; break;
        case "31" : $rand_value = "4"; break;
        case "32" : $rand_value = "5"; break;
        case "33" : $rand_value = "6"; break;
        case "34" : $rand_value = "7"; break;
        case "35" : $rand_value = "8"; break;
        case "36" : $rand_value = "9"; break;
    }
    return $rand_value;
}

function get_rand_alphanumeric($length) {
    if ($length>0) {
        $rand_id="";
        for ($i=1; $i<=$length; $i++) {
            mt_srand((double)microtime() * 1000000);
            $num = mt_rand(1,36);
            $rand_id .= assign_rand_value($num);
        }
    }
    return $rand_id;
}

function get_rand_numbers($length) {
    if ($length>0) {
        $rand_id="";
        for($i=1; $i<=$length; $i++) {
            mt_srand((double)microtime() * 1000000);
            $num = mt_rand(27,36);
            $rand_id .= assign_rand_value($num);
        }
    }
    return $rand_id;
}

function get_rand_letters($length) {
    if ($length>0) {
        $rand_id="";
        for($i=1; $i<=$length; $i++) {
            mt_srand((double)microtime() * 1000000);
            $num = mt_rand(1,26);
            $rand_id .= assign_rand_value($num);
        }
    }
    return $rand_id;
}

function getRandom($length, $type)
{
	switch ($type) {
		case 'str':
			return get_rand_letters($length);
			break;
		case 'int':
			return get_rand_letters($length);
			break;
		default:
			return get_rand_alphanumeric($length);
			break;
	}
}