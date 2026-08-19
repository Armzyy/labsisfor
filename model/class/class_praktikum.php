<?php
    include "config.php";

    // =============================================== Security check
    if(!isset($_SESSION['session_username'])){
        header('location: login');
        exit();
    }

    if(($S_rolestatus != "admin") && ($S_rolestatus != "ketualab") && ($S_rolestatus != "kooraslab")){
        header('location: 404');
    }
    // =============================================== Security check

    if(isset($_SESSION['alert'])){
        $alert = $_SESSION['alert'];
        unset($_SESSION['alert']);
    }

    function showpraktikum(){
        Global $db;

        $SQL_getpraktikum = "SELECT * FROM praktikum";
        $getpraktikum = mysqli_query($db, $SQL_getpraktikum);
        $tag = 0;
        while($resultgetpraktikum = $getpraktikum -> fetch_assoc()){
            echo "
                <tr>
                    <td>".$resultgetpraktikum['praktikum_kode']."</td>
                    <td>".$resultgetpraktikum['fullname']."</td>
                    <td>".$resultgetpraktikum['shortname']."</td>
                    <td>
                        <a href='#".$tag."' class='btn btn-warning' data-toggle='modal' data-target='#editpraktikum".$tag."'>Edit</a>

                        <div class='modal fade' id='editpraktikum".$tag."' tabindex='-1' role='dialog' aria-labelledby='editpraktikumtitle' aria-hidden='true'>
                            <div class='modal-dialog' role='document'>
                                <div class='modal-content'>
                                    <form method='post'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title' id='editpraktikumtitle'>Edit Praktikum</h5>
                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                <span aria-hidden='true'>&times;</span>
                                            </button>
                                        </div>
                                        <div class='modal-body'>
                                            <div class='form-group'>
                                                <label for='edit-nama-praktikum".$tag."'>Nama Praktikum <span class='text-danger'><b>*</b></span></label>
                                                <input type='text' class='form-control' name='editnamapraktikum' id='edit-nama-praktikum' value='".$resultgetpraktikum['fullname']."' required>
                                            </div>
                                            <div class='form-group'>
                                                <label for='edit-singkatan-praktikum".$tag."'>Singkatan Praktikum <span class='text-danger'><b>*</b></span></label>
                                                <input type='text' class='form-control' name='editsingkatanpraktikum' id='edit-singkatan-praktikum' value='".$resultgetpraktikum['shortname']."' required>
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <input type='hidden' name='id_praktikum' value='".$resultgetpraktikum['praktikum_kode']."'>
                                            <input type='submit' class='btn btn-success' name='editpraktikum' value='Edit'>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>

                </tr>
            ";
            $tag++;
        }
    }

    if(isset($_POST['editpraktikum'])){
        $fullnameedit = $_POST['editnamapraktikum'];
        $shortnameedit = $_POST['editsingkatanpraktikum'];
        $praktikumid = $_POST['id_praktikum'];

        if(($fullnameedit != NULL) && ($shortnameedit != NULL)){
            $SQL_updatepraktikum = "UPDATE praktikum SET fullname = '$fullnameedit', shortname = '$shortnameedit' WHERE praktikum_kode = '$praktikumid'";
            $updatepraktikum = mysqli_query($db, $SQL_updatepraktikum);

            if($updatepraktikum){
                $_SESSION['alert'] = $ALERT_updatepraktikumberhasil;
                header('location: '.$LINK_praktikum.'');
            }else{
                $_SESSION['alert'] = $ALERT_updatepraktikumgagal;
                header('location: '.$LINK_praktikum.'');
            }
        }else{
            $_SESSION['alert'] = $ALERT_inputpraktikumkosong;
            header('location: '.$LINK_praktikum.'');
        }   
    }

    if(isset($_POST['tambah_praktikum'])){
        $fullname = $_POST['inputnamapraktikum'];
        $shortname = $_POST['inputsingkatanpraktikum'];

        $SQL_getidprak = "SELECT MAX(id) AS max FROM praktikum";
        $getidprak = mysqli_query($db, $SQL_getidprak);
        $resultgetidprak = mysqli_fetch_array($getidprak);

        $kodeprak =  make_code("PRK", $resultgetidprak['max']);

        if(($fullname != NULL) AND ($shortname != NULL)){

            $SQL_inputprak = "INSERT INTO praktikum(praktikum_kode, fullname, shortname) VALUES('$kodeprak', '$fullname', '$shortname')";
            $inputprak = mysqli_query($db, $SQL_inputprak);

            if($inputprak){
                $_SESSION['alert'] = $ALERT_inputpraktikumberhasil;
                header('location: '.$LINK_praktikum.'');
            }else{
                $_SESSION['alert'] = $ALERT_inputpraktikumgagal;
                header('location: '.$LINK_praktikum.'');
            }
        }else{
            $_SESSION['alert'] = $ALERT_inputpraktikumkosong;
            header('location: '.$LINK_praktikum.'');
        }
    }

?>