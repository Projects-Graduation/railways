<?php
session_start();
!define('ROOT', realpath(dirname(__FILE__)));
// !define('FILES_PATH', '..' . DS . ROOT . DS . 'files' . DS);
!define('DS', DIRECTORY_SEPARATOR);
!define('APP_URL', "http://railways.test/management");
!define('WEBSITE_URL', "http://railways.test");
!define('INCLUDES_PATH', ROOT . DS);
!define('IMAGES_DIR', ROOT . DS . '..' . DS . '..' . DS . 'src' . DS . 'images');
!define('IMAGES_URL', WEBSITE_URL . '/src/images');
!define('LAYOUT_PATH', INCLUDES_PATH . 'layout' . DS);
// !define('DB_PATH', INCLUDES_PATH . 'database' . DS);
// !define('SITE_HEADER', LAYOUT_PATH . 'header.php');
// !define('SITE_FOOTER', LAYOUT_PATH . 'footer.php');
!define('APP_NAME', "هيئة سكك حديد السودان | الإدارة");

// !define('INCLUDES_PATH', ROOT . DS . 'includes' . DS);
!define('DB_PATH', INCLUDES_PATH . 'database' . DS);
!define('SITE_HEADER', INCLUDES_PATH . 'layout' . DS . 'header.php');
!define('SITE_FOOTER', INCLUDES_PATH . 'layout' . DS . 'footer.php');


!define('IMG_STORE', ROOT . DS . 'src' . DS . 'img' . DS);
!define('SUDANESE_STORE', IMG_STORE . 'sudanese');
!define('WESTERN_STORE', IMG_STORE . 'western');
!define('HOT_STORE', IMG_STORE . 'hot_drinks');
!define('COLD_STORE', IMG_STORE . 'cold_drinks');
!define('ICECREAM_STORE', IMG_STORE . 'icecream');
!define('SWEETS_STORE', IMG_STORE . 'sweets');
!define('USER_STORE', IMG_STORE . 'user');
!define('MEAL_STORE', IMG_STORE . 'meal');


!define('DOMAIN_ROOT', @$_SERVER['HOST_NAME']);
!define('ADMIN_PATH', ROOT . DS . 'admin' . DS);
// !define('ADMIN_HEADER', ADMIN_PATH . 'includes' . DS . 'header.php');
// !define('ADMIN_FOOTER', ADMIN_PATH . 'includes' . DS . 'footer.php');
!define('PAGES', DOMAIN_ROOT . 'pages' . DS);

!define('ADMIN_MENU', ADMIN_PATH . 'includes' . DS . 'menu.php');

!define('SRC_PATH', DOMAIN_ROOT . 'src' . DS);
!define('CSS_PATH', SRC_PATH . 'css' . DS);
!define('AJAX_PATH', DOMAIN_ROOT . 'includes' . DS . 'ajax' . DS);
!define('STORE_PATH', DOMAIN_ROOT . 'includes' . DS . 'store' . DS);
!define('IMG_PATH', SRC_PATH . 'img' . DS);
!define('FONTS_PATH', SRC_PATH . 'fonts' . DS);
!define('JS_PATH', SRC_PATH . 'js' . DS);
!define('PLUGINS_PATH', SRC_PATH . 'plugins' . DS);


!define('SOURCES_URL', WEBSITE_URL . "/courses/sources");
!define('COVERS_URL', WEBSITE_URL . "/courses/covers");
!define('COVERS_DIR', 'C:\laragon\www\courses\courses\covers' . DS);
!define('SOURCES_DIR', 'C:\laragon\www\courses\courses\sources' . DS);
// Data Base parameters
!define('DB_HOST' 	, '127.0.0.1');
!define('DB_NAME' 	, 'railways');
!define('DB_USER' 	, 'root');
!define('DB_PASS' 	, '');

/**
* Includes files array
* @var Array
*/
$includes = [
'database.db',
'functions.global',
'database.user',
'database.upload',
'database.relations',
'database.train',
'database.city',
'database.station',
'database.road',
'database.level',
'database.travel',
'database.passenger',
'database.ticket',
'functions.user_func'
];

/**
*  Autoloading Files in the array
*/
foreach ($includes as $filePath) {
    $fileName = INCLUDES_PATH . str_replace('.', DS, $filePath) . '.php';
    
    if (file_exists($fileName)) {
        require_once $fileName;
        // echo $fileName . '<br>';
    }
}