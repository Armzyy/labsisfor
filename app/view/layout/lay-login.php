<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/logo.png" rel="icon">
  <title>E-Laboratorium Login</title>
  <link href="<?php echo $__asset; ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo $__asset; ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo $__asset; ?>css/ruang-admin.min.css" rel="stylesheet">
  <link href="<?php echo $__asset; ?>css/loader.css" rel="stylesheet">
  <link href="<?php echo $__asset; ?>css/login-form.css" rel="stylesheet">

  <?php include __FOLDER_CLASS__ . "class_login.php"; ?>

  <?php include __FOLDER_LAYOUT__ . 'lay-script-login.php'?>

</head>
<body id="page-middle">
    <?php include __FOLDER_LAYOUT__ . "lay-loader.php"?>
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include __FOLDER_LAYOUT__ . "lay-header-login.php"?>
                <?php include __FOLDER_VIEW__ . $__content .".php"?>   
            </div>
        </div>
    </div>  
</body>
<script src="<?php echo $__asset; ?>js/loader.js"></script>
</html>