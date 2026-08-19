<?php

    define('__FOLDER_VIEW__', __DIR__ . '/app/view/');
    define('__FOLDER_LAYOUT__', __DIR__. '/app/view/layout/'); 
    define('__FOLDER_CLASS__', __DIR__. '/model/class/'); 
    
    $__asset = "asset/";

    $file_controller = __DIR__ . "/app/control/error404.php";

    if(file_exists($file_controller)){
        include $file_controller;
    }
    else{
        echo "<h1> Error 404 </h1>";
    }
?>