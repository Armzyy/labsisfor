<?php
    include 'config.php';

    // =============================================== Security check
    if(!isset($_SESSION['session_username'])){
        header('location: login');
        exit();
    }

    if(($S_rolestatus != "admin")){
        header('location: 404');
    }

    $idcek = $_GET['id'];
    $userada = getuserexist($idcek);
    if($userada['Jumlah'] < 1){
        header('location: 404');
    }
    // =============================================== Security check
    $alertskelas = "";
    $getuserid = $_GET['id'];


    $iduseredit = $_GET['id'];

    $stmt_finduser = mysqli_prepare($db, "SELECT * FROM user WHERE username = ?");
    mysqli_stmt_bind_param($stmt_finduser, "s", $iduseredit);
    mysqli_stmt_execute($stmt_finduser);
    $resultfinduser = mysqli_fetch_array(mysqli_stmt_get_result($stmt_finduser));

    $usernameedit = $resultfinduser['username'];
    $passwordedit = $resultfinduser['password'];
    $roleedit = $resultfinduser['role'];
    $firstnameedit = $resultfinduser['firstname'];
    $emailedit = $resultfinduser['email'];
    $phoneedit = $resultfinduser['phone'];
    $addressedit = $resultfinduser['address'];
    $cityedit = $resultfinduser['city'];

    if(isset($_POST['canceledit'])){
        header('location: '.$S_rolestatus.'?page=user');
    }

    if(isset($_POST['terimaedit'])){
        
        $uploadusernameedit = $_POST['editnameuser'];
        $uploadroleedit = $_POST['editroleuser'];
        $uploadfirstnameedit = $_POST['editfirstnameuser'];
        $uploademailedit = $_POST['editemailuser'];
        $uploadphoneedit = $_POST['editphoneuser'];
        $uploadalamatedit = $_POST['editalamatuser'];
        $uploadkotaedit = $_POST['editkotauser'];

        // if($uploadusernameedit == "" || $uploadroleedit == "" || $uploadfirstnameedit=="" || $uploademailedit=="" || $uploadphoneedit=="" || $uploadalamatedit=="" || $uploadkotaedit==""){
            
        // }else{
            $stmt_updateuser = mysqli_prepare($db, "UPDATE user SET username=?, role=?, firstname=?, email=?, phone=?, address=?, city=? WHERE username=?");
            mysqli_stmt_bind_param($stmt_updateuser, "ssssssss", $uploadusernameedit, $uploadroleedit, $uploadfirstnameedit, $uploademailedit, $uploadphoneedit, $uploadalamatedit, $uploadkotaedit, $iduseredit);
            $uploaddatauser = mysqli_stmt_execute($stmt_updateuser);
            
            if($uploaddatauser){
                $_SESSION['alert'] = $ALERT_updateuserberhasil;
                header('location: '.$S_rolestatus.'?page=user');
            }else{
                $_SESSION['alert'] = $ALERT_updateusergagal;
                header('location: '.$S_rolestatus.'?page=user');
            }
            
        // }
    }
        


    


?>