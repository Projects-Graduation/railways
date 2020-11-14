<?php
ob_start();
include('../../init.php');
$opr = isset($_POST['opr']) ? $_POST['opr'] : $_GET['opr'];
$flight_id = isset($_POST['flight_id']) ? $_POST['flight_id'] : $_GET['flight_id'];
if (isset($opr) && !empty($opr)) {
	$opr = trim($opr);
	if ($opr == 'add') {
		$fields =[
			'flight_number' => postData('flight_number'),
			'flight_date'	=> postData('flight_date'),
			'packages'		=> postData('packages'),
			'total_weight'	=> postData('total_weight'),
			'created_at' 	=> date("m/d/Y H:i:s"),
			'updated_at' 	=> date("m/d/Y H:i:s")
		];
		if(addFlight($fields)){
			addFlightPolicies(lastInsertedId(), $_POST['policies']);
			flash('add-flight', '<span class="fa fa-fw fa-lg fa-check"></span>تمت الإضافة بنجاح', 'success');
			home('../../index.php');
		}else {
			flash('add-flight', 'هنالك خطأ يرج المحاولة مرة اخرى', 'danger');
			back();
		}
	}elseif ($opr == 'update') {
		$fields =[
			'flight_number' => postData('flight_number'),
			'flight_date'	=> postData('flight_date'),
			'packages'		=> postData('packages'),
			'total_weight'	=> postData('total_weight'),
			'created_at' 	=> date("m/d/Y H:i:s"),
			'updated_at' 	=> date("m/d/Y H:i:s")
		];
		if(updateFlight($fields, postData('flight_id', 'int'))){
			if(deleteFlightPolicies(postData('flight_id', 'int')))
			{
				addFlightPolicies(postData('flight_id', 'int'), $_POST['policies']);
			}
			flash('update-flight', '<span class="fa fa-fw fa-lg fa-check"></span> تم حفظ التعديلات', 'danger');
			back();
		}else {
			flash('update-flight', 'هنالك خطأ يرج المحاولة مرة اخرى', 'danger');
			back();
		}
	}elseif ($opr == 'delete') {
		if (deleteFlight($flight_id)) {
			flash('delete', '<span class="fa fa-fw fa-lg fa-check"></span> تم الحذف الرحلة بنجاح');
			back();
		}else {
			flash('delete', '<span class="fa fa-fw fa-lg fa-times"></span> لم يتم الحذف يرجى المحاولة مرة اخرى');
			back();
		}
	}elseif ($opr == 'approve') {
		$fields =[
			'status' 	 	=> 0,
			'updated_at' 	=> date("m/d/Y H:i:s")
		];
		if(updateFlight($fields, $flight_id)){
				flash('approve-flight', '<span class="fa fa-fw fa-lg fa-check"></span> تم تأكيد الرحلة', 'success');
				back();
			}else {
				flash('approve-flight', 'هنالك خطأ يرج المحاولة مرة اخرى', 'danger');
				back();
			}
	}elseif ($opr == 'add-policy') {
		$fields = [
			'policy_id' => postData('policy_id', 'int'),
			'packages'  => postData('packages', 'int'),
			'weight'    => postData('weight', 'int'),
			'flight_id' => postData('flight_id', 'int'),
			'created_at' => date("m/d/Y H:i:s"),
			'updated_at' => date("m/d/Y H:i:s")
		];
		if (getPolicy(postData('policy_id', 'int'))) {
			flush('add-policy', 'عذرا هنالك بوليسة بهذا الرقم');
			redirTo($_SERVER['HTTP_REFERER']);
		}else {
			if (addPolicy($fields)) {
				flash('add-policy', '<span class="fa fa-fw fa-lg fa-check"></span>تمت الإضافة بنجاح', 'success');
				back();
			}else {
				flash('add-policy', 'هنالك خطأ يرج المحاولة مرة اخرى', 'danger');
				back();
			}
		}
	}elseif ($opr == 'delete-policy') {
		if (deletePolicy($_GET['policy_id'])) {
			flash('delete-policy', '<span class="fa fa-fw fa-lg fa-check"></span> تم الحذف بنجاح');
			back();
		}else {
			flash('delete-policy', '<span class="fa fa-fw fa-lg fa-times"></span> لم يتم الحذف يرجى المحاولة مرة اخرى');
			back();
		}
	}elseif ($opr == 'update-img') {
		$id = postData('id', 'int');
		$flight = getFlight($id);
		
		if(updateflightImage($id, $flight['img'])){
			flash('update-flight-img', '<span class="fa fa-fw fa-lg fa-check"></span>تم حفظ الصورة', 'danger');
			back();
		}else {
			flash('update-flight-img', 'هنالك خطأ يرج المحاولة مرة اخرى', 'danger');
			back();
		}
	}
}else {
	header('Location: ../../index.php');
}
ob_end_flush();
?>