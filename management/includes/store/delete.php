<?php 
require '../../init.php';
if (isset($_GET['flight_id']) && get($_GET['table'], $_GET['flight_id'])){
	// // $object =	get($_GET['table'], $_GET['flight_id']);
	// var_dump($object);
	if (count(get($_GET['table'], $_GET['flight_id']))) {
		if (delete($_GET['table'], ['flight_id', $_GET['flight_id']])) {
			flash('delete', '<span class="fa fa-fw fa-lg fa-check-circle"></span><br>تم الحذف بنجاح');
			back();
		}else {
			flash('delete', '<span class="fa fa-fw fa-lg fa-times-circle"></span><br>عفوا حدث خطأ حاول مجددا');
			back();
		}
	}else {
		flash('delete', '<span class="fa fa-fw fa-lg fa-times-circle"></span><br>عفوا حدث خطأ حاول مجددا');
		back();
	}

}else{header('location: index.php');}