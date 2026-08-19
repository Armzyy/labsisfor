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
    // =============================================== Security check

    // cek alert
    if(isset($_SESSION['alert'])){
        $alert =  $_SESSION['alert'];
        unset($_SESSION['alert']);
    }

    if(isset($_GET['err'])){
        $geterror = $_GET['err'];

        $lasttryerror = "
            <div class='alert alert-danger'>
                <a href='".$S_rolestatus."?page=user' class='close' aria-label='close'>&times;</a>
                <strong>Peringatan!</strong> Beberapa Data <b class='text-uppercase'>User</b> error pada percoabaan sebelumnya : ".$geterror." Error.
            </div>
        ";
    }else{
        $lasttryerror = "";
    }
   
    if(isset($_POST['inputmanualuser'])){
        $usernamemanual = $_POST['inputusernameuser'];
        $passwordraw = $_POST['inputpassworduser'];

        $passwordmanual = password_hash($passwordraw, PASSWORD_BCRYPT);
        $rolemanual =  $_POST['inputroleuser'];
        $firstnamemanual =  strtoupper($_POST['inputfirstnameuser']);
        $emailmanual =  $_POST['inputemailuser'];
        $phonemanual =  $_POST['inputphoneuser'];
        $address =  $_POST['inputaddressuser'];
        $city =  strtoupper($_POST['inputcityuser']);

        $stmt_countuser = mysqli_prepare($db, "SELECT COUNT(id) AS Jumlah FROM user WHERE username = ?");
        mysqli_stmt_bind_param($stmt_countuser, "s", $usernamemanual);
        mysqli_stmt_execute($stmt_countuser);
        $resultcountuser = mysqli_fetch_array(mysqli_stmt_get_result($stmt_countuser));

        if($resultcountuser['Jumlah'] == 0){
            $stmt_uploaduser = mysqli_prepare($db, "INSERT INTO user(username, password, role, firstname, email, phone, address, city, picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'user')");
            mysqli_stmt_bind_param($stmt_uploaduser, "ssssssss", $usernamemanual, $passwordmanual, $rolemanual, $firstnamemanual, $emailmanual, $phonemanual, $address, $city);
            $uploadnewusermanual = mysqli_stmt_execute($stmt_uploaduser);

            if($uploadnewusermanual){
                $_SESSION['alert'] = $ALERT_uploaduserberhasil;
                header('location: '.$LINK_user.'');
            }else{
                $_SESSION['alert'] = $ALERT_uploadusergagal;
                header('location: '.$LINK_user.'');
            }
        }else{
            $_SESSION['alert'] = $ALERT_uploadusersudahada;
            header('location: '.$LINK_user.''); 
        }
    }

    function showuser(){
        Global $db;

        $S_rolestatus = $_SESSION['session_role'];
        $SQL_getuser = "SELECT * FROM user";
        $getuser = mysqli_query($db, $SQL_getuser);
        
        while($resultgetuser = $getuser -> fetch_assoc()){
            

            $iduser = $resultgetuser['username'];
            $namauser = $resultgetuser['firstname'];
            $roleuser =  $resultgetuser['role'];
            
            echo"
                <tr>
                    <td>".$iduser."</td>
                    <td>".$namauser."</td>
                    <td>".$roleuser."</td>
                    <td><a href='".LINK_useredit($iduser)."' class='btn btn-warning'>Edit</a></td>
                </tr>
            ";
        }
    }

    // button upload csv

    if(isset($_POST['inputuser'])){
        $namauploaduser = $_FILES['uploaduser']['name'];
        $namauploaduser_tmp = $_FILES['uploaduser']['tmp_name'];
        $extuser = pathinfo($namauploaduser, PATHINFO_EXTENSION);
        $folderuploaduser = $__asset."data/tmp_upload/";
        $fixednameuser = "uploaduser.csv";
        $delimitercsv = ";";
        
        if($extuser == "csv"){

            move_uploaded_file($namauploaduser_tmp, $folderuploaduser.$fixednameuser);

            $folderuploadcsv = $__asset."data/tmp_upload/";
            $opencsv = fopen($folderuploadcsv."uploaduser.csv", 'r');
            
            while(($rowcsv = fgetcsv($opencsv, 1000, $delimitercsv)) !== false) {
                if($rowcsv[0] == "username"){
                    header('location: '. LINK_uploaduser($delimitercsv).'');
                    break;
                }else{
                    $_SESSION['alert'] = $ALERT_delimitertidakcocok;
                    header('location: '.$LINK_user.'');
                    break;
                }
            }
        }else{
            $_SESSION['alert'] = $ALERT_delimitertidakcocok;
            header('location: '.$LINK_user.'');
        }
    }

    if(isset($_POST['deleteuser'])){

    }

    if(isset($_GET['delimiter'])){
        $delimiter = $_GET['delimiter'];

        if(($delimiter != ",") && ($delimiter != ";")){
            header('location: 404');
        }
    }

    function showcsv(){
        Global $db, $__asset, $delimiter;
        
        $folderuploadcsv = $__asset."data/tmp_upload/";
        $opencsv = fopen($folderuploadcsv."uploaduser.csv", 'r');
        $rowcount = 0;
        while(($rowcsv = fgetcsv($opencsv, 1000, $delimiter)) !== false) {
            $rowcount = $rowcount + 1;
            if($rowcount < 2){
                null;
            }else{
            echo "
                <tr>
                    <td>".$rowcsv[0]."</td>
                    <td>".$rowcsv[1]."</td>
                    <td>".$rowcsv[2]."</td>
                    <td>".$rowcsv[3]."</td>
                    <td>".$rowcsv[4]."</td>
                    <td>".$rowcsv[5]."</td>
                    <td>".$rowcsv[6]."</td>
                    <td>".$rowcsv[7]."</td>
                </tr>
            ";
            }
        }
    }

    // cancel button
    if(isset($_POST['cancelupload'])){

        $folderdeletecsv = $__asset."data/tmp_upload/";

        unlink($folderdeletecsv."uploaduser.csv");

        header('location: '.$LINK_user.'');
    }

    if(isset($_POST['terimaupload'])){

        $errorupload = null;
        $folderuploadcsv = $__asset."data/tmp_upload/";
        $opencsv = fopen($folderuploadcsv."uploaduser.csv", 'r');
        $rowcount = 0;
        while(($rowcsv = fgetcsv($opencsv, 1000, $delimiter)) !== false) {
            $rowcount = $rowcount + 1;
            if($rowcount < 2){
                null;
            }else{
                // $rowcsv[1] usahain adalah password
                $final_hash = password_hash($rowcsv[1], PASSWORD_BCRYPT);

                $stmt_cekuser = mysqli_prepare($db, "SELECT COUNT(id) AS jumlah FROM user WHERE username = ?");
                mysqli_stmt_bind_param($stmt_cekuser, "s", $rowcsv[0]);
                mysqli_stmt_execute($stmt_cekuser);
                $resultcekuser = mysqli_fetch_array(mysqli_stmt_get_result($stmt_cekuser));
                
                $firstname = addslashes($rowcsv[3]);

                if($resultcekuser['jumlah'] < 1){
                    $stmt_insuser = mysqli_prepare($db, "INSERT INTO user(username, password, role, firstname, email, phone, address, city, picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'user')");
                    mysqli_stmt_bind_param($stmt_insuser, "ssssssss", $rowcsv[0], $final_hash, $rowcsv[2], $firstname, $rowcsv[4], $rowcsv[5], $rowcsv[6], $rowcsv[7]);
                    $uploadnewuser = mysqli_stmt_execute($stmt_insuser);
                }else{
                    $errorupload[] = $rowcsv[0];
                }
            }
        }

        if($errorupload == null){
            $_SESSION['alert'] = $ALERT_uploaduserberhasil;
            $folderdeletecsv = $__asset."data/tmp_upload/";
            unlink($folderdeletecsv."uploaduser.csv");
            header('location: '.$LINK_user.'');
        }else{
            $errorcount = count($errorupload);
            
            $_SESSION['alert'] = $ALERT_uploaduserberhasilerr;
            $folderdeletecsv = $__asset."data/tmp_upload/";
            unlink($folderdeletecsv."uploaduser.csv");
            header('location: '.LINK_usererr($errorcount).'');
        }
    }
?>