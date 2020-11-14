<?php 
require 'init.php';
// die(var_dump($user));
$page = 'index';
$_SESSION["page"] = "index";
$title = "الرئيسية";
$navTitle = ['لوحة التحكم', 'dashboard'];
?>
<?php include 'includes/layout/header.php'; ?>
<!-- <h2 class="text-center"><?= APP_NAME ?></h2> -->
<?php include 'includes/layout/footer.php'; ?>
