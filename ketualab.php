<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['session_role']) || $_SESSION['session_role'] !== 'ketualab') {
        header('location: login');
        exit();
    }

    define('__FOLDER_VIEW__', __DIR__ . '/app/view/');
    define('__FOLDER_LAYOUT__', __DIR__. '/app/view/layout/');
    define('__FOLDER_IMAGES__', __DIR__. '/asset/images/');
    define('__FOLDER_CLASS__', __DIR__. '/model/class/');
    define('__FOLDER_LINK__', __DIR__. '/model/link/');
    define('__FOLDER_JS__', __DIR__. '/asset/js/');
    
    $__asset = "asset/";

    $page = isset($_GET['page']) ? $_GET['page'] : 'login';

    $file_controller = __DIR__ . "/app/control/".$page.".php";

    if(file_exists($file_controller)){
        include $file_controller;
    }
    else{
        header('location: 404');
    }
?>