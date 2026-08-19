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

    $idcek = $_GET["id"];
    $periodeada = getperiodeexist($idcek);
    if($periodeada['Jumlah'] < 1){
        header('location: 404');
    }
    // =============================================== Security check

    $id = $_GET['id'];
    $timenow = date("H:i:sa");
    // after update time
    $periode_detail = getperiodebyid($id);

    $username = $_SESSION['session_username'];
    $datenow = now_timestamp();

    $periode = $periode_detail['nama_periode'];
    $statusperiode = $periode_detail['status'];
    $statuscolor = "";

    if($statusperiode == "Aktif")
    {
        $statuscolor = "success";
    }else{
        $statuscolor = "danger";
    }

    if(isset($_SESSION['alert'])){
        $alert = $_SESSION['alert'];
        unset($_SESSION['alert']);
    }
    

    if(isset($_POST['savename']))
    {
        $editnamaperiode = $_POST['editnamaperiode'];

        if($editnamaperiode == ""){
            $_SESSION['alert'] = $ALERT_updateperiodenamakosong;
            header('location: '.LINK_periodedetail($id).'');
        }else{
            // sql here
            $SQL_editnamaperiode = "UPDATE periode SET nama_periode = '$editnamaperiode' WHERE periode_kode = '$id'; ";
            $updatenamaperiode = mysqli_query($db, $SQL_editnamaperiode);

            $SQL_insertlog = "INSERT INTO log_activity(username, activity, location, date, time) VALUES('$username', 1, '$id', '$datenow', '$timenow')";
            $insertlog = mysqli_query($db, $SQL_insertlog);

            if($updatenamaperiode){
                $_SESSION['alert'] = $ALERT_updateperiodenamasukses;
                header('location: '.LINK_periodedetail($id).'');
            }
            else{
                $_SESSION['alert'] = $ALERT_updateperiodenamagagal;
                header('location: '.LINK_periodedetail($id).'');
            }
        }
        
    }

    if(isset($_POST['savetime']))
    {
        $status_periode = $_POST['inputstatusperiode'];

        if($status_periode == ""){
            $_SESSION['alert'] = $ALERT_updateperiodenamawaktukosong;
            header('location: '.LINK_periodedetail($id).'');
        }
        else{
            $SQL_editnamawaktuperiode = "UPDATE periode SET status = '$status_periode' WHERE periode_kode = '$id'; ";
            $updatenamawaktuperiode = mysqli_query($db, $SQL_editnamawaktuperiode);

            $SQL_insertlog = "INSERT INTO log_activity(username, activity, location, date, time) VALUES('$username', 2, '$id', '$datenow', '$timenow')";
            $insertlog = mysqli_query($db, $SQL_insertlog);

            if($updatenamawaktuperiode ){
                $_SESSION['alert'] = $ALERT_updateperiodenamawaktusukses;
                header('location: '.LINK_periodedetail($id).'');
            }
            else{
                $_SESSION['alert'] = $ALERT_updateperiodenamawaktugagal;
                header('location: '.LINK_periodedetail($id).'');
            }

        }
    }

    if(isset($_POST['deleteperiode']))
    {
        // trio detele 1/3 (periode -> kelas -> enrol_kelas ->  forum_kelas -> tugas_kelas - > )

    }

    function jumlahmahasiswaperiode(){
        Global $db, $id;

        $kelasperiode = getkelasbyperiodeid($id);
        $JUMLAHTOTALMAHASISWA = 0;

        while($resultkelas = $kelasperiode -> fetch_assoc()){
            $idkelas = $resultkelas['kelas_kode'];

            $SQL_getjumlahmahasiswaperiode = "SELECT COUNT(id) AS jumlah FROM kelas_enrol where kelas_kode = '$idkelas' AND role_kelas = 'mahasiswa'";
            $getjumlahmahasiswaperiode = mysqli_query($db, $SQL_getjumlahmahasiswaperiode);
            $resultgetjumlahmahasiswaperiode = mysqli_fetch_array($getjumlahmahasiswaperiode);

            $JUMLAHTOTALMAHASISWA = $JUMLAHTOTALMAHASISWA + $resultgetjumlahmahasiswaperiode['jumlah'];
        }

        echo $JUMLAHTOTALMAHASISWA;
    }

    function showperiodekelas(){
        Global $db, $S_rolestatus, $id, $periode, $getlaboratoriumdata;

        $SQL_getlbt = "SELECT * FROM laboratorium";
        $getlbr = mysqli_query($db, $SQL_getlbt);

        while ($resultlaboratoriumdata = $getlbr -> fetch_assoc()){
            $idlab = $resultlaboratoriumdata['laboratorium_kode'];

            echo "
                <div class='col-xl-12 col-lg-7 mb-4'>
                    <div class='card'>
                        <div class='card-header py-3 d-flex flex-row align-items-center justify-content-between'>
                        <h6 class='m-0 font-weight-bold text-primary'>Kelas Praktikum Periode ".$periode." - ".$resultlaboratoriumdata['nama_laboratorium']."</h6>
                        </div>
                        <div class='table-responsive'>
                        <table class='table align-items-center table-flush'>
                            <thead class='thead-light'>
                                <tr>
                                    <th>ID Kelas</th>
                                    <th>Nama Kelas</th>
                                    <th>Jumlah Mahasiswa</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
            ";

            $SQL_getkelasbyperiodeandlab = "SELECT * FROM kelas WHERE periode_kode = '$id' AND laboratorium_kode = '$idlab'";
            $getkelasbyperiodeandlab = mysqli_query($db, $SQL_getkelasbyperiodeandlab);
            
            $count = mysqli_num_rows($getkelasbyperiodeandlab);

            if($count > 0){
                while ($resultgetkelasbyperiodeandlab = $getkelasbyperiodeandlab->fetch_assoc()){
                    
                    if ($resultgetkelasbyperiodeandlab['status'] == "Aktif"){
                        $kelascolor = "success";
                    }
                    else{
                        $kelascolor = "danger";
                    }
                    $kode_kelas = $resultgetkelasbyperiodeandlab['kelas_kode'];

                    $jmlmahasiswakelasperiode = getjumlahkelas($kode_kelas);

                    $datapraktikum = getpraktikumbyid($resultgetkelasbyperiodeandlab['praktikum_kode']);
                    echo "
                        <tr>
                            <td>".$kode_kelas."</td>
                            <td><a href='".LINK_kelas($kode_kelas)."'>".$datapraktikum['fullname']." (".$datapraktikum['shortname'].") - ".ucwords($resultgetkelasbyperiodeandlab['jadwal'])."</a></td>
                            <td>".$jmlmahasiswakelasperiode['jumlah']."</td>
                            <td><span class='badge badge-$kelascolor'>".$resultgetkelasbyperiodeandlab['status']."</span></td>
                        </tr>
                    ";
                }
            }
            else{
                echo "
                <tr>
                    <td>-</td>
                    <td>-</td>
                    <td>Tidak ada kelas pada laboratorium</td>
                    <td>-</td>
                </tr>
                ";
            }

                echo "  
                                </tbody>
                            </table>
                            </div>
                            <div class='card-footer'></div>
                        </div>
                        </div>
                ";
        }
    }

    function showlogperiode(){
        Global $db, $S_rolestatus, $id, $username;

        $SQL_getlogperiode = "SELECT * FROM log_activity WHERE location = '$id' ORDER BY id DESC;";
        $getlogperiode = mysqli_query($db, $SQL_getlogperiode);

        while($rowgetlogperiode = $getlogperiode -> fetch_assoc()){
            $namapengguna = getuserbyusername($username);
            $aktifitas = log_activitycode($rowgetlogperiode['activity']);
            $date = date_id(date ('Y-m-d', $rowgetlogperiode['date']));

            echo "
                <tr>
                    <td class='mr-5' width='30%' style='font-size:14px'>[".$rowgetlogperiode['username']."] ".$namapengguna['firstname']."</td>
                    <td>".$aktifitas."</td>
                    <td>".$date.", ".$rowgetlogperiode['time']."</td>
                </tr>
            ";
        }
    }