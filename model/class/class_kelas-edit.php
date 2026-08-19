<?php
    include "config.php";

    // =============================================== Security check
    if(!isset($_SESSION['session_username'])){
        header('location: login');
        exit();
    }

    $idcek = $_GET['id'];
    $SQL_cekenrolment = "SELECT COUNT(id) AS Jumlah, role_kelas FROM kelas_enrol WHERE kelas_kode = '$idcek' AND username = '$S_username'";
    $cekenrolment = mysqli_query($db, $SQL_cekenrolment);
    $resultcekenrolment = mysqli_fetch_array($cekenrolment);
    $rolekelascek = $resultcekenrolment['role_kelas'];

    $kelasada = getkelasexist($idcek);
    if($kelasada['Jumlah'] < 1){
        header('location: 404');
    }
    
    if($S_rolestatus != "admin"){
        if(($resultcekenrolment['Jumlah'] != 1)){
            header('location: 404');
        }else if(($rolekelascek != "ketualab") && ($rolekelascek != "kooraslab") && ($rolekelascek != "koorpraktikum")){
            header('location: 404');
        }       
    }

    // =============================================== Security check

    $getid = $_GET['id'];

    if(isset($_SESSION['alert'])){
        $alert =  $_SESSION['alert'];
        unset($_SESSION['alert']);
    }

    $resultgetkelas = getkelasbyid($getid);

    $nama_kelas = $resultgetkelas['fullname'];
    $nama_kelasshort =  $resultgetkelas['shortname'];
    $periode = getperiodebyid($resultgetkelas['periode_kode']);
    $deskripsi = $resultgetkelas['deskripsi'];

    $resultgetlaboratorium = getlaboratoriumbyid($resultgetkelas['laboratorium_kode']);
    $laboratorium = $resultgetlaboratorium['nama_laboratorium'];

    $getenroled = getpembuatkelas($getid);
    
    if($S_username == $getenroled['username']){
        $delkelas = "
            <div class='card-footer'>
                <p class='text-danger'>BAHAYA HAPUS KELAS !</p>
                <button type='button' class='btn btn-danger col-xl-12' data-toggle='modal' data-target='#deletekelas' id='#deletekelas'>Hapus Kelas</button>
                <div class='modal fade' id='deletekelas' tabindex='-1' role='dialog' aria-labelledby='deletekelastitle' aria-hidden='true'>
                    <div class='modal-dialog modal-dialog-centered' role='document'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='deletekelastitle'>Hapus Kelas</h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>
                            <div class='modal-body'>
                                <form method='post'>
                                    <h6 class='text-danger'><b>Peringatan!</b></h6>    
                                    <p>Jika anda menghapus kelas ini, maka <b class='text-danger'>keseluruhan data forum, absen, peserta, modul, tugas, materi, penilaian, jadwal, asisten dan penilaian akan terhapus secara keseluruhan</b>.</p>
                                    <p><b>Ingin melanjutkan?</b></p>
                                    <input id='deletekelassubmit' name='deletekelassubmit' type='submit' class='btn btn-danger col-xl-12' value='Hapus kelas'>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ";
    }
    if(isset($_POST['updatekelas'])){
        $jadwalkelas = $_POST['inputjadwalkelas'];
        $deskripsilkelas = addslashes($_POST['inputdeskripsikelas']);

        if(($jadwalkelas != NULL) && ($deskripsilkelas != NULL)){
            $SQL_updatekelas = "UPDATE kelas SET jadwal = '$jadwalkelas', deskripsi = '$deskripsilkelas' WHERE kelas_kode = '$getid'";
            $updatekelas = mysqli_query($db, $SQL_updatekelas);

            if($updatekelas){
                $_SESSION['alert'] = $ALERT_updatekelassukses;
            }else{
                $_SESSION['alert'] = $ALERT_updatekelasgagal;
            }

            header('location: '.$S_rolestatus.'?page=kelas-detail&id='.$getid.'&nav=forum');
        }else{
            $_SESSION['alert'] = $ALERT_datakelaskosong;
            header('location: '.$S_rolestatus.'?page=kelas-edit&id='.$getid.'');
        }
    }

    if(isset($_POST['deletekelassubmit'])){

        $SQL_gettugasmodul = "SELECT tugas_kode FROM kelas_tugas WHERE kelas_kode ='$getid'";
        $gettugasmodul = mysqli_query($db, $SQL_gettugasmodul );
        $errrr = 0;

        while($resultgettugasmodul = $gettugasmodul -> fetch_assoc()){
            $tugaskodeee = $resultgettugasmodul['tugas_kode'];

            $SQL_delmaterimodul = "DELETE FROM kelas_tugas_materi WHERE tugas_kode = '$tugaskodeee'";
            $delmaterimodul = mysqli_query($db, $SQL_delmaterimodul);
            if(!$delmaterimodul){
                $errrr++;
            }

            $SQL_deltugaspengumpulan = "DELETE FROM kelas_tugas_pengumpulan WHERE tugas_kode = '$tugaskodeee'";
            $deltugaspengumpulan = mysqli_query($db, $SQL_deltugaspengumpulan);
            if(!$deltugaspengumpulan){
                $errrr++;
            }

            $SQL_deltugasmodul = "DELETE FROM kelas_tugas WHERE tugas_kode = '$tugaskodeee'";
            $deltugasmodul = mysqli_query($db, $SQL_deltugasmodul);
            if(!$deltugasmodul){
                $errrr++;
            }
        }

        $SQL_delassmodul = "DELETE FROM kelas_modul_asisten WHERE kelas_kode = '$getid'";
        $delassmodul = mysqli_query($db, $SQL_delassmodul);
        if(!$delassmodul){
            $errrr++;
        }

        $SQL_delmodul = "DELETE FROM kelas_modul WHERE kelas_kode = '$getid'";
        $delmodul = mysqli_query($db, $SQL_delmodul);
        if(!$delmodul){
            $errrr++;
        }

        $SQL_delforum = "DELETE FROM kelas_forum WHERE kelas_kode = '$getid'";
        $delforum = mysqli_query($db, $SQL_delforum);
        if(!$delforum){
            $errrr++;
        }

        $SQL_delformatnilai = "DELETE FROM kelas_formatnilai WHERE kelas_kode = '$getid'";
        $delformatnilai = mysqli_query($db, $SQL_delformatnilai);
        if(!$delformatnilai){
            $errrr++;
        }

        $SQL_delabsensidata = "DELETE FROM kelas_absen_absensi WHERE kelas_kode = '$getid'";
        $delabsensidata = mysqli_query($db, $SQL_delabsensidata);
        if(!$delabsensidata){
            $errrr++;
        }

        $SQL_delabsensi = "DELETE FROM kelas_absen WHERE kelas_kode = '$getid'";
        $delabsensid = mysqli_query($db, $SQL_delabsensi);
        if(!$delabsensid){
            $errrr++;
        }

        $SQL_delenroled = "DELETE FROM kelas_enrol WHERE kelas_kode = '$getid'";
        $delenroled = mysqli_query($db, $SQL_delenroled);
        if(!$delenroled){
            $errrr++;
        }

        $SQL_delkelas = "DELETE FROM kelas WHERE kelas_kode = '$getid'";
        $delkelas = mysqli_query($db, $SQL_delkelas);
        if(!$delkelas){
            $errrr++;
        }

        if($errrr < 1){
            $_SESSION['alert'] = $ALERT_berhasildeletekelas;
            header('location: '.$LINK_home.'');
        }else{
            $_SESSION['alert'] = $ALERT_gagaldeletekelas;
            header('location: '.$LINK_home.'');
        }
    }