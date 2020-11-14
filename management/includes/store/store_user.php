<?php
ob_start();
include('../../init.php');
$opr = $_POST['opr'];
if (isset($opr) && !empty($opr)) {
	$opr = trim($opr);
	if ($opr == 'login') {
		if (userLogedIn() === false) {
			if(login($_POST['name'], $_POST['password'])){
				header('Location: ../../index.php');
			}else {
				header('Location: ' . $_SERVER['HTTP_REFERER']);
			}
		}else {
			header('Location: ../../index.php');
		}
	}elseif ($opr == 'add') {
		$fields =[
			'name' 	 	=> postData('name'),
			'password' 	=> postData('password', 'pw'),
			'fullname' 	=> postData('fullname'),
			'address'  	=> postData('address'),
			'email' 	=> postData('email'),
			'phone' 	=> postData('phone', 'int'),
			'created_at' 	=> date("Y/m/d H:i:s"),
			'updated_at' 	=> date("Y/m/d H:i:s")
		];

		if(addUser($fields)){
			flash('add-user', '<span class="fa fa-fw fa-lg fa-check"></span>تمت الإضافة بنجاح', 'success');
			header('Location: ../../index.php');
		}else {
			flash('update-user', 'هنالك خطأ يرج المحاولة مرة اخرى', 'danger');
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
	}elseif ($opr == 'update') {
		if (userLogedIn() === true) {
			$password = $_POST['password'] === "" ? $_POST['old_password'] : $_POST['password'];
			$fields =[
				'name' 	 	=> postData('name'),
				'password' 	=> filterPW($password),
				'fullname' 	=> postData('fullname'),
				'address'  	=> postData('address'),
				'email' 	=> postData('email'),
				'phone' 	=> postData('phone', 'int'),
				'updated_at' 	=> date("Y/m/d H:i:s")
			];

			if(updateUser($fields, postData('id', 'int'))){
				flash('update-user', '<span class="fa fa-fw fa-lg fa-check"></span>تم حفظ التعديلات', 'danger');
				header('Location: ' . $_SERVER['HTTP_REFERER']);
			}else {
				flash('update-user', 'هنالك خطأ يرج المحاولة مرة اخرى', 'danger');
				header('Location: ' . $_SERVER['HTTP_REFERER']);
			}
		}else {
			header('Location: ../../index.php');
		}
	}elseif ($opr == 'update-img') {
		$id = postData('id', 'int');
		$user = getUser($id);
		
		if(updateUserImage($id, $user['img'])){
			flash('update-user-img', '<span class="fa fa-fw fa-lg fa-check"></span>تم حفظ الصورة', 'danger');
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}else {
			flash('update-user-img', 'هنالك خطأ يرج المحاولة مرة اخرى', 'danger');
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
	}
}else {
	header('Location: ../../index.php');
}
ob_end_flush();
?>