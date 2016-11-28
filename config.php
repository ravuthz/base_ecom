<?php

error_reporting(E_ALL);

define("DB_TYPE", "mysql");
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "project_base_ecom");

define("BASE_PATH", dirname(__FILE__) . DIRECTORY_SEPARATOR);
define("BASE_LINK", '/' . basename(__DIR__) . '/');

define("HOST_LINK", $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT']);

define('PAGE_HEADER', BASE_PATH . 'app/views/header.php');
define('PAGE_FOOTER', BASE_PATH . 'app/views/footer.php');
define('PAGE_NAVBAR', BASE_PATH . 'app/views/navbar.php');
define('PAGE_SIDEBAR', BASE_PATH . 'app/views/sidebar.php');

define('PDF_PRINT', BASE_PATH . 'app/classes/pdfcrowd.php');

define('PATH_IMG', BASE_PATH . 'assets/images/');
define('PATH_CSS', BASE_PATH . 'assets/css/');
define('PATH_JS', BASE_PATH . 'assets/js/');

define('ASSET_IMG', BASE_LINK . 'assets/images/');
define('ASSET_CSS', BASE_LINK . 'assets/css/');
define('ASSET_JS', BASE_LINK . 'assets/js/');

define('NO_IMAGE', 'no-image.png');

session_start();

require_once "/app/helper.php";

require_once "/app/models/User.php";
require_once "/app/models/Bank.php";
require_once "/app/models/Product.php";
require_once "/app/models/Category.php";

require_once "/app/classes/Upload.php";
require_once "/app/classes/Database.php";
require_once "/app/classes/Authentication.php";

$db = new Database();
$auth = new Authentication();

//echo "<pre>";

// $server = "SERVER_NAME SERVER_ADDR SERVER_PORT REQUEST_URI SCRIPT_NAME PHP_SELF QUERY_STRING REQUEST_METHOD DOCUMENT_ROOT";
// foreach ($_SERVER as $ekey => $each) {
//     if (in_array($ekey, array_values(explode(' ', $server)))) {
//         echo "[ $ekey ] \t: $each \n";
//     }
// }

$requireLogin = [
    'products/create.php', 'products/update.php', 'products/delete.php',
    'products/cart.php', 'products/order.php',
    'categories/create.php', 'categories/update.php', 'categories/delete.php'
];

foreach ($requireLogin as $each) {
    if (strpos($_SERVER['REQUEST_URI'], $each) !== false && $auth->isLoggedIn() === false) {
        redirect("account/login.php");
    }
}

if ($auth->isLoggedIn()) {
    $auth_bank = $db->query('SELECT * FROM banks WHERE user_id = :uid', ['uid' => $auth->user()->id])->one();
    if (empty($auth_bank)) {
        session_set('warning', "You don't register bank yet");
        $auth_bank = new Bank();
    }
}

//echo "</pre>";

if (input_has('login')) {
    redirect('account/login.php');
}

if (input_has('logout')) {
    redirect('account/logout.php');
}
