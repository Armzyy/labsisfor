<?php

    include "config.php";

    
    // =============================================== Security check
    if(!isset($_SESSION['session_username'])){
        header('location: login');
        exit();
    }

    if(($S_rolestatus != "admin") && ($S_rolestatus != "ketualab")){
        header('location: 404');
    }
    // =============================================== Security check

    if(isset($_SESSION['alert'])){
        $alert = $_SESSION['alert'];
        unset($_SESSION['alert']);
    }

    if(isset($_POST['tambah_periode']))
    {
        $namaperiode = $_POST['inputnamaperiode'];

        if($namaperiode == ''){
            $_SESSION['alert'] = $ALERT_inputperiodekosong;
            header('location: '.$LINK_periode.'');
        }else{

            $SQL_ambilperiode = "SELECT max(id) AS maxID FROM periode";
            $ambilperiode= mysqli_query($db,$SQL_ambilperiode);
            $resultambilperiode = mysqli_fetch_array($ambilperiode);

            $real_periode_kode = make_code('PRD', $resultambilperiode['maxID']);

            $status_periode = "Aktif";

            $SQL_inputperiode = "INSERT INTO periode (periode_kode, nama_periode, status) VALUES ('$real_periode_kode', '$namaperiode' , '$status_periode')";
            $inputperiode = mysqli_query($db,$SQL_inputperiode);

            if($inputperiode){
                $_SESSION['alert'] = $ALERT_inputperiodesukses;
                header('location: '.$LINK_periode.'');
            }
            else{
                $_SESSION['alert'] = $ALERT_inputperiodegagal;
                header('location: '.$LINK_periode.'');
            }
        }
    }

    function showdataperiode(){
        GLOBAL $db;

        $S_rolestatus = $_SESSION['session_role'];

        $SQL_showperiode = "SELECT * FROM periode ORDER BY id DESC";
        $showperiode = mysqli_query($db,$SQL_showperiode);

        while($resultshowperiode = $showperiode->fetch_assoc()){
    
            if($resultshowperiode['status'] == "Non-Aktif")
            {
                $statusperiode = "Non-Aktif";
                $colorperiode = "danger";
            }else{
                $statusperiode = "Aktif";
                $colorperiode = "success";
            }
            echo "
                <tr>
                    <td>".$resultshowperiode['periode_kode']."</td>
                    <td>".$resultshowperiode['nama_periode']."</td>
                    <td><span class='badge badge-".$colorperiode."'>$statusperiode</span></td>
                    <td><a href='".LINK_periodedetail($resultshowperiode['periode_kode'])."' class='btn btn-sm btn-primary'>Detail</a></td>
                </tr>
            ";
        }
    }
