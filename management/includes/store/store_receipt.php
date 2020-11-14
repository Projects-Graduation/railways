<?php
ob_start();
include('../../init.php');
$opr = isset($_POST['opr']) ? $_POST['opr'] : $_GET['opr'];
$receipt_id = isset($_POST['receipt_id']) ? $_POST['receipt_id'] : $_GET['receipt_id'];
$receipt_number = isset($_POST['receipt_number']) ? $_POST['receipt_number'] : $_GET['receipt_number'];
$policy_id = isset($_POST['policy_id']) ? $_POST['policy_id'] : $_GET['policy_id'];
if (isset($opr) && !empty($opr)) {
	$opr = trim($opr);
	if ($opr == 'add') {
		$fields =[
			'receipt_number' => $receipt_number,
			'policy_id' 	 => $policy_id,
			'created_at' 	 => date("m/d/Y H:i:s"),
			'updated_at' 	 => date("m/d/Y H:i:s")
		];
		if(addReceipt($fields)){
			flash('add-receipt', '<span class="fa fa-fw fa-lg fa-check"></span>تمت إضافة الإيصال', 'success');
			back();
		}else {
			flash('add-receipt', 'هنالك خطأ يرج المحاولة مرة اخرى', 'danger');
			back();
		}
	}elseif ($opr == 'delete') {
		if (deleteReceipt($policy_id)) {
			flash('delete-receipt', '<span class="fa fa-fw fa-lg fa-check"></span> تم الحذف الإيصال');
			back();
		}else {
			flash('delete-receipt', '<span class="fa fa-fw fa-lg fa-times"></span> لم يتم الحذف يرجى المحاولة مرة اخرى');
			back();
		}
	}
}else {
	header('Location: ../../index.php');
}
ob_end_flush();
?>