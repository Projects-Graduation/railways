<?php
header("Access-Control-Allow-Origin: *");
!define('APP_ROOT', realpath(dirname(__FILE__)));

!define('ASSETS_PATH', APP_ROOT . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR);

require 'includes/config.php';

!define('ASSETS_URL', APP_URL  . '/assets/' );

if (userLogedIn() === true) {
	$user = getUser($_SESSION['id']);
}else{
	redirect('login.php');
}
$_SESSION['page'] = "none";