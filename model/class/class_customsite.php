<?php
    // =============================================== Security check
    if(!isset($_SESSION['session_username'])){
        header('location: login');
        exit();
    }

    if($S_rolestatus != 'admin'){
        header('location: 404');
    }
    // =============================================== Security check