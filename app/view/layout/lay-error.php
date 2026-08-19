<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titleerror ?></title>
    <link href="<?php echo $__asset; ?>css/error-page.css" rel="stylesheet">

    <?php session_start(); ?>

    
    <?php if(isset($__class)){include __FOLDER_CLASS__ . $__class .".php";} ?>  
</head>
<body>

    <?php include __FOLDER_VIEW__ . $__content .".php"?>
                
</body>
</html>