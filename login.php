<?php
    define('__FOLDER_VIEW__', __DIR__ . '/app/view/');
    define('__FOLDER_LAYOUT__', __DIR__. '/app/view/layout/');
    define('__FOLDER_IMAGES__', __DIR__. '/asset/images/');
    define('__FOLDER_CLASS__', __DIR__. '/model/class/');
    define('__FOLDER_LINK__', __DIR__. '/model/link/');
    
    $__asset = "asset/";

    $page = "login";

    $file_controller = __DIR__ . "/app/control/".$page.".php";

    if(file_exists($file_controller)){
        include $file_controller;
    }
    else{
        header('location: 404');
    } 
?>