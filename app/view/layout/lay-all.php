<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="<?php echo $__asset; ?>images/logo_lab.png" rel="icon">
  <title><?php echo $title ?></title>
  <link href="<?php echo $__asset; ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo $__asset; ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo $__asset; ?>vendor/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo $__asset; ?>css/ruang-admin.min.css" rel="stylesheet">
  <link href="<?php echo $__asset; ?>css/loader.css" rel="stylesheet">
  <link href="<?php echo $__asset; ?>css/background-gradient.css" rel="stylesheet" type="text/css">
  <link href="<?php echo $__asset; ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  
  <?php include __FOLDER_LINK__ . "link_all.php"; ?>  
  <?php include __FOLDER_CLASS__ . "class_header.php"; ?>
  <?php include __FOLDER_CLASS__ . $__class .".php"; ?>
</head>

<body id="page-top">
  <?php include __FOLDER_LAYOUT__ . "lay-loader.php"?>
  <div id="wrapper">
    <?php include __FOLDER_LAYOUT__ . "lay-sidebar.php"?>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php include __FOLDER_LAYOUT__ . "lay-header.php"?>
          <?php include __FOLDER_VIEW__ . $__content .".php"?>
      </div>
        <?php include __FOLDER_LAYOUT__ . "lay-footer.php"?>
    </div>
  </div>
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
</body>
  <?php include __FOLDER_LAYOUT__ . 'lay-script.php'?>
  <?php 
    if($__js != ""){
      echo "
        <script>
      ";
          include __FOLDER_JS__ .$__js.'.js';
      echo "
        </script>
      ";
    }
  
  
  ?>
</html>