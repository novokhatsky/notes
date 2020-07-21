<?php

//ini_set("error_log", "/tmp/php-error.log");

require_once 'module/autoload.php';

date_default_timezone_set('Asia/Novosibirsk');

define('UID', 'notes');
define('BASE_URL', '/notes/');

$config =
[
    'srv'  => 'localhost',
    'user' => 'mind',
    'pass' => '01478569',
    'db'   => 'notes',
];

session_start();

if (isset($_GET['url'])) {
    $param = explode('/', $_GET['url']);
} else {
    $param = [];
}

if (isset($param[0])) {
    $action = $param[0];
} else {
    $action = 'index';
}

$db = new \advor\module\Db($config);
$id_current_user = new \advor\module\SessionVar(UID . 'id_user');
$current_user = new \advor\models\User($db);

$fullname = "controllers/{$action}.php";

if (file_exists($fullname)) {
    require_once $fullname;
} else {
    require_once 'views/404.html';
}

