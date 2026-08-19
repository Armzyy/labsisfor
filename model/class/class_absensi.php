<?php
    include 'config.php';

    // =============================================== Security check
    if(!isset($_SESSION['session_username'])){
        header('location: login');
        exit();
    }

    $idcek = $_GET['id'];
    $weekcek = $_GET['week'];

    $SQL_cekenrolment = "SELECT COUNT(id) AS Jumlah, role_kelas FROM kelas_enrol WHERE kelas_kode = '$idcek' AND username = '$S_username'";
    $cekenrolment = mysqli_query($db, $SQL_cekenrolment);
    $resultcekenrolment = mysqli_fetch_array($cekenrolment);

    if($S_rolestatus != "admin"){
        if(($resultcekenrolment['Jumlah'] != 1)){
            header('location: 404');
        }else if($resultcekenrolment['role_kelas'] == "mahasiswa"){
            header('location: 404');
        }else if(($weekcek < 1) || ($weekcek > 16)){
            header('location: 404');
        }
    }

    $SQL_cekkelas = "SELECT COUNT(id) AS Jumlah FROM kelas WHERE kelas_kode = '$idcek'";
    $cekkelas = mysqli_query($db, $SQL_cekkelas);
    $resultcekkelas = mysqli_fetch_array($cekkelas);

    if($resultcekkelas['Jumlah'] == 0){
        header('location: 404');
    }

    $SQL_cekabsen = "SELECT COUNT(id) AS Jumlah FROM kelas_absen WHERE kelas_kode = '$idcek' AND week = '$weekcek' AND status = 'notset'";
    $cekabsen = mysqli_query($db, $SQL_cekabsen);
    $resultcekabsen = mysqli_fetch_array($cekabsen);

    if($resultcekabsen['Jumlah'] == 1){
        header('location: 404');
    }

    $SQL_cekenrolment = "SELECT COUNT(id) AS Jumlah FROM kelas_enrol WHERE kelas_kode = '$idcek' AND username = '$S_username'";
    $cekenrolment = mysqli_query($db, $SQL_cekenrolment);
    $resultcekenrolment = mysqli_fetch_array($cekenrolment);

    if($S_rolestatus != 'admin'){
        if(($resultcekenrolment['Jumlah'] != 1)){
            header('location: 404');
        }
    }
    // =============================================== Security check

    if(isset($_SESSION['alert'])){
        $alert =  $_SESSION['alert'];
        unset($_SESSION['alert']);
    }
    
    $idkelas = $_GET['id'];
    $weekabsensi = $_GET['week'];

    $kelas = getkelasbyid($idkelas);
    $periode = getperiodebyid($kelas['periode_kode']);
    $laboratorium = getlaboratoriumbyid($kelas['laboratorium_kode']);

    $linkdownloadexcel = $LINK_downloadexcel."&kode=absensi&klsid=".$idkelas."&week=".$weekabsensi;
    
    $linkdownloadpdf = $LINK_downloadpdf."&kode=absensi&klsid=".$idkelas."&week=".$weekabsensi;

    $SQL_cekkelasdosenabsen = "SELECT * FROM kelas_enrol WHERE kelas_kode = '$idkelas' AND username = '$S_username'";
    $cekkelasdosenabsen = mysqli_query($db, $SQL_cekkelasdosenabsen);
    $arraycekkelasdosenabsen = mysqli_fetch_array($cekkelasdosenabsen);

    if($arraycekkelasdosenabsen['role_kelas'] == "dosen"){
        $datamahasiswa = getdatamahasiswaenrolbykelasdosen($idkelas, $arraycekkelasdosenabsen['kelas_dosen']);
        $kelasdosen = "- ".$arraycekkelasdosenabsen['kelas_dosen'];
        $linkdownloadexceldosen = $LINK_downloadexcel."&kode=absensi&klsid=".$idkelas."&week=".$weekabsensi."&lksd=".$arraycekkelasdosenabsen['kelas_dosen'];
    }else{
        $datamahasiswa = getdatamahasiswaenrol($idkelas);
    }

    

    function showabsensi(){
        Global $db, $idkelas, $weekabsensi, $datamahasiswa;

        $tmnow = now_timestamp();
        $stabsensi = getdatabsen($idkelas, $weekabsensi);
        $tagabsen = 0;
        while($rowdatamahasiswa = $datamahasiswa -> fetch_assoc()){
            $absensicek = cekabsensibyusername($idkelas, $weekabsensi, $rowdatamahasiswa['username']);

            if($absensicek['Jumlah'] > 0){
                echo"
                    <tr>
                        <td>".$rowdatamahasiswa['username']."</td>
                        <td>".$rowdatamahasiswa['firstname']."</td>
                        <td><span class='badge rounded-pill badge-success'>Hadir</span></td>
                        <td>
                            <a href='#'><i class='fas fa-trash text-danger' data-toggle='modal' data-target='#hapusabsen".$tagabsen."'></i></a>
                            <div class='modal fade' id='hapusabsen".$tagabsen."' tabindex='-1' role='dialog' aria-labelledby='modalhapusabsentitle".$tagabsen."' aria-hidden='true'>
                                <div class='modal-dialog modal-dialog-centered' role='document'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title' id='modalhapusabsentitle".$tagabsen."'>Hapus Peserta</h5>
                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                <span aria-hidden='true'>&times;</span>
                                            </button>
                                        </div>
                                        <div class='modal-body'>
                                            <h6>Hapus Absensi ".$rowdatamahasiswa['username']." - ".$rowdatamahasiswa['firstname']."</h6>
                                        </div>
                                        <form method='post'>
                                            <div class='modal-footer'>
                                                <input type='hidden' id='usernameabsen' name='usernameabsen' value='".$rowdatamahasiswa['username']."'>
                                                <input class='btn btn-danger' type='submit' value='Hapus' id='hapusabsen' name='hapusabsen'>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                ";
            }else{
                if($stabsensi['status'] != "closed"){
                    echo"
                        <tr>
                            <td>".$rowdatamahasiswa['username']."</td>
                            <td>".$rowdatamahasiswa['firstname']."</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    ";
                }else{
                    echo"
                        <tr>
                            <td>".$rowdatamahasiswa['username']."</td>
                            <td>".$rowdatamahasiswa['firstname']."</td>
                            <td><span class='badge rounded-pill badge-danger'>Tidak Hadir</span></td>
                            <td>-</td>
                        </tr>
                    ";
                }
            }
            $tagabsen++;
        }
    }

    if(isset($_POST['hapusabsen'])){
        $usernameabsen = $_POST['usernameabsen'];

        $SQL_hapusabsen = "DELETE FROM kelas_absen_absensi WHERE kelas_kode = '$idkelas' AND week = '$weekabsensi' AND username = '$usernameabsen'";
        $hapusabsen = mysqli_query($db, $SQL_hapusabsen);

        if($hapusabsen){
            $_SESSION['alert'] = $ALERT_delabsensiberhasil;
            header('location: '.LINK_kelas_absensi($idkelas, $weekabsensi).'');
        }else{
            $_SESSION['alert'] = $ALERT_delabsensigagal;
            header('location: '.LINK_kelas_absensi($idkelas, $weekabsensi).'');
        }
    }
