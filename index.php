<?php

use app\controllers\UserController;

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/lib/DB/MysqliDb.php';
require_once __DIR__ . '/app/controllers/UserController.php';

$config = require 'config/config.php';
$db = new MysqliDb(
    $config['db_host'],
    $config['db_user'],
    $config['db_pass'],
    $config['db_name']
);
//super global=>array عشان نجيب ال url
$request = $_SERVER['REQUEST_URI'];
 
var_dump($request);
define('BASE_PATH', '/');

$controller = new UserController($db);

switch ($request) {
    case BASE_PATH:
        $controller->index();//بجيب كل يوزرات
        break;
    case BASE_PATH . 'add':
        $controller->addUser();
        break;
    case BASE_PATH . 'show':
        $controller->showUsers();
        break;
    case BASE_PATH . 'delete?id=' . $_GET['id']:
        // var_dump($_GET['id']);
        $controller->deleteUser($_GET['id']);
        break;
    case BASE_PATH . 'update?id=' . $_GET['id']:
        $controller->updateUser($_GET['id']);
        break;
    case BASE_PATH . 'edit?id=' . $_GET['id']:
        // var_dump($_GET['id']);
        $controller->editUser($_GET['id']);
        break;
    case BASE_PATH . 'search':
        $controller->searchUsers($_POST['search_term']);
        break;
    case BASE_PATH . 'show_search':
        $controller->showSearchedUsers($_GET['search_term']);
        break;
    default:
    // var_dump($request);
        break;
}
