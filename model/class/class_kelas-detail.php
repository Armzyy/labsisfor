<?php
    include 'config.php';

    if(isset($_SESSION['alert'])){
        $alert =  $_SESSION['alert'];
        unset($_SESSION['alert']);
    }

    // =============================================== Security check
    if(!isset($_SESSION['session_username'])){
        header('location: login');
        exit();
    }

    $idcek = $_GET['id'];
    $navcek = $_GET['nav'];

    $datenow = now_timestamp();
    $timenow = date("H:i:sa");
    
    $kelasada = getkelasexist($idcek);
    if($kelasada['Jumlah'] < 1){
        header('location: 404');
    }
    $SQL_cekstatuskelas = "SELECT status FROM kelas WHERE kelas_kode = '$idcek'";
    $cekstatuskelas = mysqli_query($db, $SQL_cekstatuskelas);
    $resultcekstatuskelas = mysqli_fetch_array($cekstatuskelas);
    $statuskelas = $resultcekstatuskelas['status'];
    
    $SQL_cekenrolment = "SELECT COUNT(id) AS Jumlah FROM kelas_enrol WHERE kelas_kode = '$idcek' AND username = '$S_username'";
    $cekenrolment = mysqli_query($db, $SQL_cekenrolment);
    $resultcekenrolment = mysqli_fetch_array($cekenrolment);

    if(($resultcekenrolment['Jumlah'] != 1) && ($S_rolestatus != "admin")){
        header('location: 404');
    }

    if((!isset($navcek))&&(!isset($idcek))){
        header('location: 404');
    }

    $rolekelascek = getrolekelas($idcek, $S_username);

    if($S_rolestatus != "admin"){
        if(($navcek == "setmodul") && ($rolekelascek['role_kelas'] != "ketualab") && ($rolekelascek['role_kelas'] != "kooraslab") && ($rolekelascek['role_kelas'] != "koorpraktikum") && ($rolekelascek['role_kelas'] != "KLDS") && ($rolekelascek['role_kelas'] != "KAMS") && ($rolekelascek['role_kelas'] != "KPMS")){
            header('location: 404');
        }else if(($navcek == "formatnilai") && ($rolekelascek['role_kelas'] != "ketualab") && ($rolekelascek['role_kelas'] != "dosen") && ($rolekelascek['role_kelas'] != "KLDS")){
            header('location: 404');
        }else if(($navcek == "nilai") && ($rolekelascek['role_kelas'] == "mahasiswa")){
            header('location: 404');
        }
    }

    $getclassid = $_GET['id'];
    $getnav = $_GET['nav'];

    $rolekelas = getrolekelas($getclassid, $S_username);

    $S_rolekelas = $rolekelas['role_kelas'];
    $kelas_dosenn = getkelasdosenbyusername($getclassid, $S_username);
    $syaratkelas = getdetailsyarat($getclassid, $S_username);
    $syaratkelascount = coutgetdetailsyarat($getclassid, $S_username);
    if($S_rolekelas == "mahasiswa"){
        if($syaratkelascount['Jumlah'] == 0){
            $masukkelas = "No";
        }else{
            if(($syaratkelas['pengumpulan_kwitansi'] == "No") || ($syaratkelas['pengumpulan_foto'] == "No")){
                $masukkelas = "No";
            }else{
                $masukkelas = "Yes";
            }
        }
        
    }else{
        $masukkelas = "Yes";
    }
    
    // =============================================== Security check

    
    
    $kelasdetail = getkelasbyid($getclassid);

    $nama_kelas = $kelasdetail['fullname'];
    $nama_kelas_short = $kelasdetail['shortname'];
    $jadwal = $kelasdetail['jadwal'];

    $periodedetail = getperiodebyid($kelasdetail['periode_kode']);

    $periode_nama = $periodedetail['nama_periode'];

    $laboratoriumdetail = getlaboratoriumbyid($kelasdetail['laboratorium_kode']);

    $laboratorium_nama = $laboratoriumdetail['nama_laboratorium'];

    $deskripsikelas = $kelasdetail['deskripsi'];
    
    $showrolekelas = namerole($S_rolekelas);

    function showjadwalheader(){
        Global $getclassid;

        
    }

    if($S_rolekelas == "mahasiswa"){

        if($kelasdetail['link_asistensi'] == NULL){
            $linkasistensi = "<span class='text-dark'>Tidak ada jadwal asistensi</span>";
        }else{
            $linkasistensi = "<a href='".$kelasdetail['link_asistensi']."' target='_blank'>Jadwal Asistensi</a>";
        }
        $headerkelas = "
            <div class='card mb-5'>
                <div class='card-header py-3 d-flex flex-row align-items-center justify-content-between text-wrap'>
                    <h3 class='m-0 font-weight-bold text-primary'>".$nama_kelas." ( ".$nama_kelas_short." ) - ".ucwords($jadwal)."</h3>
                </div>
                <div class='card-body'>
                    <div class='mb-3'>
                        <h6 class='m-0 font-weight-bold text-primary'>".$periode_nama." - ".$laboratorium_nama." </h6>
                        <div class='card-footer text-left'>
                            <a class='m-0 small text-primary card-link' href='#' data-toggle='collapse' data-target='#detailkelas'>Detail kelas <i class='fas fa-chevron-right'></i></a>
                        </div>
                        <div id='detailkelas' class='collapse'>
                            <div class='ml-4'>
                                ".$deskripsikelas."
                            </div>
                        </div>
                        <div class='card-footer text-left'>
                            <a class='m-0 small text-primary card-link' href='#' data-toggle='collapse' data-target='#jadwalasistensi'>Jadwal Asistensi <i class='fas fa-chevron-right'></i></a>
                        </div>
                        <div id='jadwalasistensi' class='collapse'>
                            <div class='ml-4'>
                                Klik link untuk melihat jadwal asistensi : ".$linkasistensi."
                            </div>
                        </div>
                        <div class='card-footer text-left'>
                            <a class='m-0 small text-primary card-link' href='#' data-toggle='collapse' data-target='#jadwalmengajar'>Jadwal Mengajar <i class='fas fa-chevron-right'></i></a>
                        </div>
                        <div id='jadwalmengajar' class='collapse'>
                            <div class='p-3 table-responsive-md'>
                                <table class='table align-items-center table-flush' style='border:none;'>
                                    <thead class='text-center thead-dark'>
                                        <tr>
                                            <th>Jadwal</th>
                                            <th>Hari</th>
                                            <th>Asisten</th>
                                        </tr>
                                    </thead>
                                    <tbody class='text-center'>
        ";
            $jadwalkode = getjadwalkodeD($getclassid);
            $countjadwalkode = countgetjadwalkodeD($getclassid);

            if($countjadwalkode['Jumlah'] != 0){
                while($rowjadwalkode = $jadwalkode -> fetch_assoc()){

                    $asssm =  getasistenmengajarbyjadwalkode($rowjadwalkode['jadwalM_kode']);
                    $countasssm = countgetasistenmengajarbyjadwalkode($rowjadwalkode['jadwalM_kode']);

                    $Crow = 1;
                    while($rowasssm = $asssm -> fetch_assoc()){
                        
                        if($Crow == 1){
                            $headerkelas = $headerkelas."
                                <tr>
                                    <td rowspan='".$countasssm['Jumlah']."' style='vertical-align:middle;'>".$rowasssm['nama_jadwal']."</td>
                                    <td rowspan='".$countasssm['Jumlah']."' style='vertical-align:middle;'>".ucwords($rowasssm['hari']).", ".conv_time($rowasssm['jam_mulai'])." - ".conv_time($rowasssm['jam_akhir'])."</td>
                                    <td style='vertical-align:middle;height: 15px;'>".$rowasssm['firstname']."</td>
                                </tr>
                            ";
                        }else{
                            $headerkelas = $headerkelas."
                                <tr>
                                    <td style='vertical-align:middle;height: 15px;'>".$rowasssm['firstname']."</td>
                                </tr>
                            ";
                        }
                        $Crow++;
                    }
                }   
            }else{
                $headerkelas = $headerkelas."
                    <tr>
                        <td colspan='3'>Tidak ada jadwal mengajar.</td>
                    </tr>
                ";
            }
        $headerkelas = $headerkelas."
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ";  
    }

    if(($S_rolekelas == "mahasiswa") || ($S_rolekelas == "MHAS") || ($S_rolekelas == "KPMS") || ($S_rolekelas == "KAMS")){
        $syaratmodul = getdetailsyarat($getclassid, $S_username);
        if($syaratkelascount['Jumlah'] == 0){
            $alertmodul = "";
        }else{
            if($syaratmodul['kepemilikan_modul'] == "No"){
                $alertmodul = "
                    <div class='alert alert-secondary' role='alert'>
                        Anda belum memiliki modul praktikum ".$kelasdetail['shortname'].". Untuk pemesanan/kesalahan data, hubungi <a href='https://wa.me/62".$arraygetdataadmin['phone']."' target='_blank' class='text-info'>Admin Laboratorium.</a>
                    </div>
                ";
            }else{
                $alertmodul = "";
            }
        }
    }else{
        $alertmodul = "";
    }

    
    $pembuatkelas = getpembuatkelasbyusername($getclassid, $S_username);

    if(($pembuatkelas['pembuat_kelas'] == "yes") || ($S_rolekelas == "koorpraktikum") || ($S_rolekelas == "KAMS") || ($S_rolekelas == "KPMS") || ($S_rolekelas == "admin")){
        $btneditkelas = "<a href='".$S_rolestatus."?page=kelas-edit&id=".$getclassid."' class='btn btn-warning text-sm mb-3'>Edit kelas</a>";
        $btninputjadwalasistensi = "
            <a href='#' class='btn btn-primary text-sm mb-3 ml-3' data-toggle='modal' data-target='#linkasistensi'>Tambah jadwal asistensi</a>
            <div class='modal fade' id='linkasistensi' tabindex='-1' role='dialog' aria-labelledby='linkasistensiLabel' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title' id='linkasistensiLabel'>Input Link Jadwal Asistensi</h5>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                    <form method='post'>
                        <div class='modal-body'>
                            <p>Input link G-drive file jadwal asistensi</p>
                            <input type='text' class='form-control' placeholder='https://docs.google.com/spreadsheets/' name='linkjadwalasistensi' required>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                            <input type='submit' class='btn btn-success' name='submitlinkasistensi' value='Input Link'>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        ";
    }else{
        $btneditkelas = "";
        $btninputjadwalasistensi = "";
    }

    if(isset($_POST['submitlinkasistensi'])){
        $linkjadwalasistensi = $_POST['linkjadwalasistensi'];

        if($linkjadwalasistensi != ""){
            if(str_contains($linkjadwalasistensi, "docs.google.com/spreadsheets/")){
                $SQL_inputjadwalasistensi = "UPDATE kelas SET link_asistensi = '$linkjadwalasistensi' WHERE kelas_kode = '$getclassid'";
                $inputjadwalasistensi = mysqli_query($db, $SQL_inputjadwalasistensi);

                if($inputjadwalasistensi){
                    $_SESSION['alert'] = $ALERT_linkjadwalasistensiberhasil;
                    header('location: '.LINK_kelas_nav($getclassid, 'forum').'');
                }else{
                    $_SESSION['alert'] = $ALERT_linkjadwalasistensigagal;
                    header('location: '.LINK_kelas_nav($getclassid, 'forum').'');
                }
            }else{
                $_SESSION['alert'] = $ALERT_linkjadwalasistensisalah;
                header('location: '.LINK_kelas_nav($getclassid, 'forum').'');
            }
        }else{
            $_SESSION['alert'] = $ALERT_linkjadwalasistensigagal;
            header('location: '.LINK_kelas_nav($getclassid, 'forum').'');
        }
    }

    function cek(){
        for($i = 1 ; $i <= 10; $i++){
            echo "lala";
        }
    }
    
    $jadwalasistensi = "adad";
        

    if($getnav == "forum"){
        $activeforum = "active";
    }else if($getnav == "tugas"){
        $activetugas = "active";
    }else if($getnav == "absen"){
        $activeabsen = "active";
    }else if($getnav == "nilai"){
        $activenilai = "active";
    }else if($getnav == "peserta"){
        $activepeserta = "active";
    }else if($getnav == "setmodul"){
        $activesetmodul = "active";
    }else if($getnav == "formatnilai"){
        $activeformatnilai = "active";
    }else if($getnav == "syarat"){
        $activesyarat = "active";
    }else{
        header('location: 404');
    }
    
    function forum(){
        include 'app/view/view_kelas-detail_forum.php';
    }

    function tugas(){
        include 'app/view/view_kelas-detail_tugas.php';
    }

    function absen(){
        include 'app/view/view_kelas-detail_absen.php';
    }
 
    function nilai(){
        include 'app/view/view_kelas-detail_nilai.php';
    }

    function peserta(){
        include 'app/view/view_kelas-detail_peserta.php';
    }

    function setmodul(){
        include 'app/view/view_kelas-detail_setmodul.php';
    }

    function formatnilai(){
        include 'app/view/view_kelas-detail_formatnilai.php';
    }

    function syarat(){
        include 'app/view/view_kelas-detail_syarat.php';
    }

    function content(){
        Global $getnav, $S_rolekelas;

        if($getnav == "forum"){
            forum();
        }else if($getnav == "tugas"){
            tugas();
        }else if($getnav == "absen"){
            absen();
        }else if($getnav == "nilai"){
            nilai();
        }else if($getnav == "peserta"){
            peserta();
        }else if($getnav == "setmodul"){
            setmodul();
        }else if($getnav == "formatnilai"){
            formatnilai();
        }else if($getnav == "syarat"){
            syarat();
        }else{
            header('location: 404');
        }
    }

    $jdwlkelas = cekjadwalkelas($getclassid);
    
    if($jdwlkelas['jadwal'] == "pagi"){
        $getcls = isset($_GET['cls']) ? $_GET['cls'] : 'p';
        if(($getcls != "p") && ($getcls != "p1")){
            header('location: 404');
        }
    }else{
        $getcls = isset($_GET['cls']) ? $_GET['cls'] : 'v';
        if(($getcls != "v")){
            header('location: 404');
        }
    }

    function nav(){
        Global $S_rolekelas, $activeforum, $activetugas, $activesyarat, $activenilai, $activeabsen, $activepeserta, $activesetmodul, $getclassid, $activeformatnilai;

        if(($S_rolekelas == "ketualab") || ($S_rolekelas == "KLDS")){
            echo "
                <ul class='nav nav-tabs d-block d-sm-flex'>
                    <li class='nav-item'><a class='nav-link px-5 ".$activeforum."' href='".LINK_kelas_nav($getclassid, "forum")."' id='tugas' id='forum'>Forum</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activetugas."' href='".LINK_kelas_nav($getclassid, "tugas")."' id='tugas'>Tugas</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activenilai."' href='".LINK_kelas_nav($getclassid, "nilai")."' id='nilai'>Nilai</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activeformatnilai."' href='".LINK_kelas_nav($getclassid, "formatnilai")."' id='formatnilai'>Format Nilai</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activeabsen."' href='".LINK_kelas_nav($getclassid, "absen")."' id='absen'>Absen</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activepeserta."' href='".LINK_kelas_nav($getclassid, "peserta")."' id='peserta'>Peserta</a></li>
                </ul>
            ";
        }else if($S_rolekelas == "admin"){
            echo "
                <ul class='nav nav-tabs d-block d-sm-flex'>
                    <li class='nav-item'><a class='nav-link px-5 ".$activeforum."' href='".LINK_kelas_nav($getclassid, "forum")."' id='tugas' id='forum'>Forum</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activetugas."' href='".LINK_kelas_nav($getclassid, "tugas")."' id='tugas'>Tugas</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activenilai."' href='".LINK_kelas_nav($getclassid, "nilai")."' id='nilai'>Nilai</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activeformatnilai."' href='".LINK_kelas_nav($getclassid, "formatnilai")."' id='formatnilai'>Format Nilai</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activeabsen."' href='".LINK_kelas_nav($getclassid, "absen")."' id='absen'>Absen</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activepeserta."' href='".LINK_kelas_nav($getclassid, "peserta")."' id='peserta'>Peserta</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activesyarat."' href='".LINK_kelas_nav($getclassid, "syarat")."' id='peserta'>Syarat</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activesetmodul."' href='".LINK_kelas_nav($getclassid, "setmodul")."' id='setmodul'>Set Jadwal Mengajar</a></li>
                </ul>
            ";
        }else if(($S_rolekelas == "kooraslab") || ($S_rolekelas == "koorpraktikum") || ($S_rolekelas == "KAMS") || ($S_rolekelas == "KPMS")){
            echo "
                <ul class='nav nav-tabs d-block d-sm-flex'>
                    <li class='nav-item'><a class='nav-link px-5 ".$activeforum."' href='".LINK_kelas_nav($getclassid, "forum")."' id='tugas' id='forum'>Forum</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activetugas."' href='".LINK_kelas_nav($getclassid, "tugas")."' id='tugas'>Tugas</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activenilai."' href='".LINK_kelas_nav($getclassid, "nilai")."' id='nilai'>Nilai</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activeabsen."' href='".LINK_kelas_nav($getclassid, "absen")."' id='absen'>Absen</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activepeserta."' href='".LINK_kelas_nav($getclassid, "peserta")."' id='peserta'>Peserta</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activesyarat."' href='".LINK_kelas_nav($getclassid, "syarat")."' id='peserta'>Syarat</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activesetmodul."' href='".LINK_kelas_nav($getclassid, "setmodul")."' id='setmodul'>Set Jadwal Mengajar</a></li>
                </ul>
            ";
        }else if(($S_rolekelas == "dosen")){
            echo "
                <ul class='nav nav-tabs d-block d-sm-flex'>
                    <li class='nav-item'><a class='nav-link px-5 ".$activeforum."' href='".LINK_kelas_nav($getclassid, "forum")."' id='tugas' id='forum'>Forum</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activetugas."' href='".LINK_kelas_nav($getclassid, "tugas")."' id='tugas'>Tugas</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activenilai."' href='".LINK_kelas_nav($getclassid, "nilai")."' id='nilai'>Nilai</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activeformatnilai."' href='".LINK_kelas_nav($getclassid, "formatnilai")."' id='formatnilai'>Format Nilai</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activeabsen."' href='".LINK_kelas_nav($getclassid, "absen")."' id='absen'>Absen</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activepeserta."' href='".LINK_kelas_nav($getclassid, "peserta")."' id='peserta'>Peserta</a></li>
                </ul>
            ";
        }else if(($S_rolekelas == "aslab") || ($S_rolekelas == "MHAS")){
            echo "
                <ul class='nav nav-tabs d-block d-sm-flex'>
                    <li class='nav-item'><a class='nav-link px-5 ".$activeforum."' href='".LINK_kelas_nav($getclassid, "forum")."' id='tugas' id='forum'>Forum</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activetugas."' href='".LINK_kelas_nav($getclassid, "tugas")."' id='tugas'>Tugas</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activenilai."' href='".LINK_kelas_nav($getclassid, "nilai")."' id='nilai'>Nilai</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activeabsen."' href='".LINK_kelas_nav($getclassid, "absen")."' id='absen'>Absen</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activesyarat."' href='".LINK_kelas_nav($getclassid, "syarat")."' id='absen'>Syarat</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activepeserta."' href='".LINK_kelas_nav($getclassid, "peserta")."' id='peserta'>Peserta</a></li>
                </ul>
            ";
        }else{
            echo "
                <ul class='nav nav-tabs d-block d-sm-flex'>
                    <li class='nav-item'><a class='nav-link px-5 ".$activeforum."' href='".LINK_kelas_nav($getclassid, "forum")."' id='tugas' id='forum'>Forum</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activetugas."' href='".LINK_kelas_nav($getclassid, "tugas")."' id='tugas'>Tugas</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activeabsen."' href='".LINK_kelas_nav($getclassid, "absen")."' id='absen'>Absen</a></li>
                    <li class='nav-item'><a class='nav-link px-5 ".$activepeserta."' href='".LINK_kelas_nav($getclassid, "peserta")."' id='peserta'>Peserta</a></li>
                </ul>
            ";
        }
    }

    // input pengumuman
    
    function zonkforum(){
        Global $getclassid, $db;

        $SQL_countforum = "SELECT COUNT(id) AS jumlah FROM kelas_forum WHERE kelas_kode = '$getclassid'";
        $countforum = mysqli_query($db, $SQL_countforum);
        $resultcountforum = mysqli_fetch_array($countforum);

        if($resultcountforum['jumlah'] == 0){
            echo "
                <div class='text-center mt-5 pb-5 text-dark' style='text-shadow: 1px 1px 3px grey;'>
                    <h5>Tidak ada forum untuk ditampilkan.</h5>
                </div>
            ";
         }
    }

    function btnpengumuman(){
        Global $S_rolekelas, $statuskelas, $getclassid, $S_username;

        $jadwalkls = cekjadwalkelas($getclassid);

        if($statuskelas != "Non-Aktif"){
            if(($S_rolekelas != "mahasiswa")){
                echo "
                    <button type='button' class='btn btn-secondary mt-3' data-toggle='modal' data-target='#tambahpengumuman' id='#tambahpengumuman'>Buat Forum</button>
                    <div class='modal fade' id='tambahpengumuman' tabindex='-1' role='dialog' aria-labelledby='modaltambahpengumumantitle' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered' role='document'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modaltambahpengumumantitle'>Buat Forum</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>  
                                <div class='modal-body'>
                                    <form method='post'>
                                        <div class='form-group'>
                                            <label for='input-judul-pengumuman'>Judul Forum <span class='text-danger'>*</span></label>
                                            <input type='text' class='form-control' name='inputjudulpengumuman' id='input-judul-pengumuman' placeholder='Masukkan judul' required>
                                        </div>
                                        <div class='form-group'>
                                            <label for='input-deskripsi-pengumuman'>Deskripsi</label>
                                            <textarea class='form-control ckeditor' name='inputdeskripsipengumuman' id='input-deskripsi-pengumuman' rows='3'></textarea>
                                        </div>
                                        <div class='form-group'>
                                            <label for='input-privasi'>Privasi <i class='fas fa-lock text-xs text-dark ml-1'></i></label>
                                            <select class='form-control' id='input-privasi' name='inputprivasi' required>
                ";

                if($S_rolekelas != "dosen"){
                    if($jadwalkls['jadwal'] == "pagi"){
                        echo "
                            <option value='publik'>Dilihat semua kelas</option>
                            <option value='p'>Hanya untuk kelas P</option>
                            <option value='p1'>Hanya untuk kelas P1</option>
                        ";
                    }else{
                        echo "
                            <option value='publik'>Dilihat semua kelas</option>
                        ";
                    }
                }else{
                    $kelasdosenn = getkelasdosenbyusername($getclassid, $S_username);
                    echo "<option value='".$kelasdosenn['kelas_dosen']."'>Hanya untuk kelas ".strtoupper($kelasdosenn['kelas_dosen'])."</option>";
                }
                
                echo "
                                            </select>
                                        </div>
                                        <div class='modal-footer'>
                                            <input type='submit' class='btn btn-primary' name='tambahpengumuman' value='Buat pengumuman'>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                ";
            }
        }
    }
    
    if(isset($_POST['tambahpengumuman'])){

        $judulpengumuman = $_POST['inputjudulpengumuman'];
        $deskripsipengumuman = addslashes($_POST['inputdeskripsipengumuman']);
        $privasi = $_POST['inputprivasi'];

        $now_real = now_timestamp();

        if(($judulpengumuman!=NULL)&&($deskripsipengumuman!=NULL)){
            $SQL_insertpengumuman = "INSERT INTO kelas_forum(kelas_kode, judul_forum, forum, privasi, username, waktu_buat) VALUES('$getclassid', '$judulpengumuman', '$deskripsipengumuman', '$privasi', '$S_username', '$now_real')";
            $insertpengumuman = mysqli_query($db, $SQL_insertpengumuman);

            if($insertpengumuman){
                $_SESSION['alert'] = $ALERT_tambahforumberhasil;
                header('location: '.LINK_kelas_nav($getclassid, 'forum').'');
            }
            else{
                $_SESSION['alert'] = $ALERT_tambahforumgagal;
                header('location: '.LINK_kelas_nav($getclassid, 'forum').'');
            }
        }else{
            $_SESSION['alert'] = $ALERT_dataforumkosong;
            header('location: '.LINK_kelas_nav($getclassid, 'forum').'');
        }
    }

    function showpengumuman(){
        Global $db, $S_username, $getclassid, $S_rolestatus, $S_rolekelas, $statuskelas;
        $SQL_getpengumuman = "SELECT * FROM kelas_forum WHERE kelas_kode = '$getclassid' ORDER BY id DESC";
        $getpengumuman = mysqli_query($db, $SQL_getpengumuman);

        $tag = 1;

        $kelasdose = getkelasdosenbyusername($getclassid, $S_username);

        if(($kelasdose['role_kelas'] == "mahasiswa") || ($kelasdose['role_kelas'] == "dosen")){
            $dataforum = getpengumumanbykelasdosen($kelasdose['kelas_dosen'], $getclassid);
        }else{
            $dataforum = $getpengumuman;
        }
        while($resultgetpengumuman = $dataforum->fetch_assoc()){

            // double sql
            $SQL_getuser = "SELECT * FROM user WHERE username = '".$resultgetpengumuman['username']."'";
            $getuser = mysqli_query($db, $SQL_getuser);
            $resultgetuser = mysqli_fetch_array($getuser);

            $waktu_buat = date_id(date ('Y-m-d', $resultgetpengumuman['waktu_buat']));

            echo "
                    <div class='card h-100 my-3 id='".$tag."'>
                        <div class='card-header'>
                            <div class='row align-items-center text-left'>
                                <div class='col-1 d-none d-lg-block text-center'>
                                    <i class='fas fa-bell fa-2x text-success'></i>
                                </div>
                                <div class='col-10 p-0 d-inline-block'>
                                    <div class='row ml-3 align-items-center'>
                                        <h5 class='text-dark font-weight-bold my-0'>".$resultgetpengumuman['judul_forum']."</h5>
                                    </div>
            ";

            if($statuskelas != "Non-Aktif"){
                if(($S_rolekelas != "mahasiswa")){
                    echo "
                                            <div class='row ml-3 my-1 align-items-center'>
                                                <a href='#".$tag."' data-toggle='modal' data-target='#editpengumuman".$tag."'><i class='fas fa-edit fa-1x text-warning'></i></a><a href='#".$tag."' class='ml-3' data-toggle='modal' data-target='#hapuspengumuman".$tag."'><i class='fas fa-trash fa-1x text-danger'></i></a>
                                            </div> 
                        ";
                }
            }
            echo "
                                    <div class='row ml-3 mt-2 align-items-center'>
                                        <h6 class='text-dark text-xs'>".$resultgetuser['firstname']."<span class='px-2'>-</span>".$waktu_buat."<span class='px-2'>-</span>".strtoupper($resultgetpengumuman['privasi'])."</h6>
                                    </div>
                                </div>
                            </div>
                            <hr class='my-0 border border-5 border-dark'>
                        </div>
                        <div class='card-body my-0 ml-3 py-3'>
                            <h6 class='text-dark'>".$resultgetpengumuman['forum']."</h6>
                        </div>
                    </div>

                    <div class='modal fade' id='editpengumuman".$tag."' tabindex='-1' role='dialog' aria-labelledby='editpengumumantitle' aria-hidden='true'>
                        <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                            <form method='post'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='editpengumumantitle'>Edit Pengumuman</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                    <div class='form-group'>
                                        <label for='edit-judul-pengumuman".$tag."'>Judul</label>
                                        <input type='text' class='form-control' name='editjudulpengumuman' id='edit-judul-pengumuman' value='".$resultgetpengumuman['judul_forum']."'>
                                    </div>
                                    <div class='form-group'>
                                        <label for='edit-deskripsi-pengumuman".$tag."'>Deskripsi</label>
                                        <textarea class='form-control ckeditor' name='editdeskripsipengumuman' id='edit-deskripsi-pengumuman".$tag."' rows='3'>".$resultgetpengumuman['forum']."</textarea>
                                    </div>
                                </div>
                                <div class='modal-footer'>
                                        <input type='hidden' name='id_pengumuman' value='".$resultgetpengumuman['id']."'>
                                        <input type='hidden' name='usernameedit' value='".$S_username."'>
                                        <input type='submit' class='btn btn-success' name='editpengumuman' value='Ubah'>
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>

                    <div class='modal fade' id='hapuspengumuman".$tag."' tabindex='-1' role='dialog' aria-labelledby='hapuspengumumantitle' aria-hidden='true'>
                        <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='hapuspengumumantitle'>Hapus Pengumuman</h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>
                            <div class='modal-body'>
                                <p>Ingin menghapus pengumuman ".$resultgetpengumuman['judul_forum']." ?</p>
                            </div>
                            <div class='modal-footer'>
                                <form method='post'>
                                    <input type='hidden' name='id_pengumuman' value='".$resultgetpengumuman['id']."'>
                                    <input type='submit' class='btn btn-danger' name='hapuspengumuman' value='Hapus'>
                                </form>
                            </div>
                        </div>
                        </div>
                    </div>
            ";
            $tag = $tag + 1;
        }
        echo "<div class='".$tag."' id='maxtageditpengumuman'></div>";
    }

    if(isset($_POST['editpengumuman'])){

        $judulforum = $_POST['editjudulpengumuman'];
        $deskripsiforum = addslashes($_POST['editdeskripsipengumuman']);
        $usernameedit = $_POST['usernameedit'];
        $idforum = $_POST['id_pengumuman'];
        $pengumumannow = now_timestamp();
        if(($judulforum!=NULL) && ($deskripsiforum!=NULL)){
            $SQL_editpengumuman = "UPDATE kelas_forum SET judul_forum = '$judulforum', forum = '$deskripsiforum', username = '$usernameedit', waktu_buat = '$pengumumannow' WHERE id = '$idforum' ";
            $editpengumuman = mysqli_query($db, $SQL_editpengumuman);
    
            if($editpengumuman){
                $_SESSION['alert'] = $ALERT_forumberhasildiupdate;
                header('location: '.LINK_kelas_nav($getclassid, 'forum').'');
            }else{
                $_SESSION['alert'] = $ALERT_forumgagaldiupdate;
                header('location: '.LINK_kelas_nav($getclassid, 'forum').'');
            }
        }else{
            $_SESSION['alert'] = $ALERT_dataforumkosong;
            header('location: '.LINK_kelas_nav($getclassid, 'forum').'');
        }
    }

    if(isset($_POST['hapuspengumuman'])){

        $idforum = $_POST['id_pengumuman'];

        $SQL_hapuspengumuman = "DELETE FROM kelas_forum WHERE id = '$idforum' ";
        $hapuspengumuman = mysqli_query($db, $SQL_hapuspengumuman);

        if($hapuspengumuman){
            $_SESSION['alert'] = $ALERT_forumberhasildihapus;
            header('location: '.LINK_kelas_nav($getclassid, 'forum').'');
        }else{
            $_SESSION['alert'] = $ALERT_forumgagaldihapus;
            header('location: '.LINK_kelas_nav($getclassid, 'forum').'');
        }
    }

    // Input Tugas

    function zonktugas(){
        Global $getclassid, $db;

        $SQL_counttugas = "SELECT COUNT(id) AS jumlah FROM kelas_tugas WHERE kelas_kode = '$getclassid'";
        $counttugas = mysqli_query($db, $SQL_counttugas);
        $resultcounttugas = mysqli_fetch_array($counttugas);

        if($resultcounttugas['jumlah'] == 0){
            echo "
                <div class='text-center mt-5 pb-5 text-dark' style='text-shadow: 1px 1px 3px grey;'>
                    <h5>Tidak ada tugas untuk ditampilkan.</h5>
                </div>
            ";
         } 
    }

    function showmodulkelas(){
        Global $db, $getclassid, $getnav;

        $SQL_getmodulkelas = "SELECT DISTINCT nama_modul FROM kelas_modul WHERE kelas_kode = '$getclassid'";
        $getemodulkelas = mysqli_query($db, $SQL_getmodulkelas);

        while($resultgetmodulkelas = $getemodulkelas -> fetch_assoc()){
            $namamodul = $resultgetmodulkelas['nama_modul'];

            $SQL_cekmodulexist = "SELECT COUNT(id) AS jumlah FROM kelas_tugas WHERE kelas_kode = '$getclassid' AND modul ='$namamodul'";
            $cekmodulexist = mysqli_query($db, $SQL_cekmodulexist);
            $resultcekmodulexist = mysqli_fetch_array($cekmodulexist);

            if($resultcekmodulexist['jumlah'] == 0){
                $numbersmodul = preg_replace('/[^0-9]/', '', $namamodul);
                $lettersmodul = preg_replace('/[^a-zA-Z]/', '', $namamodul);

                if($namamodul == "tugasakhir"){
                    $lettersmodul = "Tugas Akhir";
                }
                echo "<option value='".$resultgetmodulkelas['nama_modul']."' class='text-capitalize'>".$lettersmodul." ".$numbersmodul."</option>";
            }
        }
        
    }
   

    if(isset($_POST['tambahtugas'])){
        $modultugas = $_POST['inputmodultugas'];

        $numberstugas = preg_replace('/[^0-9]/', '', $modultugas);
        $letterstugas = preg_replace('/[^a-zA-Z]/', '', $modultugas);

        if($modultugas == "tugasakhir"){
            $judultugas = "Pengumpulan Tugas Akhir";
        }else{
            $judultugas = "Pengumpulan Tugas ".ucwords($letterstugas)." ".ucwords($numberstugas);
        }
        $deskripsitugas = addslashes($_POST['inputdeskripsitugas']);
        $tenggat = $_POST['inputtenggattugas'];
        
        // convert format timestamp now
        $tenggat_conv = strtotime($tenggat);  
        $tenggat_new = date ('y-m-d', $tenggat_conv);  

        // convert real timestamp now
        $tenggattugas = strtotime($tenggat_new);

        // convert format timestamp now
        $now_conv = strtotime(date('y-m-d'));  
        $now_new = date ('y-m-d', $now_conv);  

        // convert real timestamp now
        $now_real = strtotime($now_new);

        $code = "TGS";

        $SQL_maxidtugas = "SELECT MAX(id) as MAX from kelas_tugas";
        $maxidtugas = mysqli_query($db, $SQL_maxidtugas);
        $resultmaxidtugas = mysqli_fetch_array($maxidtugas);
        
        $kodetuugas = make_code($code, $resultmaxidtugas['MAX']);
        
        if(($judultugas != NULL) && ($deskripsitugas != NULL) && ($tenggat != NULL)){
            $SQL_inserttugas = "INSERT INTO kelas_tugas(tugas_kode, modul, kelas_kode, judul_tugas, deskripsi, waktu_buat, tanggal_selesai, username) VALUES ('$kodetuugas', '$modultugas', '$getclassid', '$judultugas', '$deskripsitugas', '$now_real', '$tenggattugas', '$S_username')";
            $inserttugas = mysqli_query($db, $SQL_inserttugas);

            if($inserttugas){
                $_SESSION['alert'] = $ALERT_tugasberhasilditambahkan;
                header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
            }
            else{
                $_SESSION['alert'] = $ALERT_tugasgagalditambahkan;
                header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
            }
        }else{
            $_SESSION['alert'] = $ALERT_datatugaskosong;
            header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
        }
    }

    function btntugas(){
        Global $S_rolekelas, $statuskelas;

        if($statuskelas != "Non-Aktif"){
            if(($S_rolekelas != "dosen") && ($S_rolekelas != "mahasiswa") && ($S_rolekelas != "ketualab") && ($S_rolekelas != "KLDS")){
                echo "
                    <button type='button' class='btn btn-secondary mt-3' data-toggle='modal' data-target='#tambahtugas' id='#tambahtugas'>Tambah Tugas</button>
                    <div class='modal fade' id='tambahtugas' tabindex='-1' role='dialog' aria-labelledby='modaltambahtugastitle' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered' role='document'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modaltambahtugastitle'>Tambah Tugas</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                    <form method='post'>
                                        <div class='form-group'>
                                            <label for='#input-modul-tugas'>Modul Tugas <span class='text-danger'>*</span></label>
                                            <select class='select2-inputmodultugas form-control text-capitalize' name='inputmodultugas' id='input-modul-tugas' required>
                                                <option value=''>Select</option>
                ";

                showmodulkelas();
                
                echo "
                                            </select>
                                        </div>
                                        <div class='form-group'>
                                            <label for='#input-deskripsi-tugas'>Deskripsi <span class='text-danger'>*</span></label>
                                            <textarea class='form-control ckeditor' name='inputdeskripsitugas' id='input-deskripsi-tugas' rows='3' placeholder='Masukkan Deskripsi'></textarea>
                                        </div>
                                        <div class='form-group'>
                                            <label for='#input-tenggat-tugas'>Tenggat tugas <span class='text-danger'>*</span></label>
                                            <input type='date' class='input-sm form-control' name='inputtenggattugas' id='input-tenggat-tugas' required>
                                        </div>
                                        <div class='modal-footer'>
                                            <input type='submit' class='btn btn-primary' name='tambahtugas' value='Tambah tugas'>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                ";
            }
        }
    }

    function showtugas(){
        Global $db, $S_username, $getclassid, $S_rolestatus, $S_rolekelas, $statuskelas;
        $SQL_gettugas = "SELECT * FROM kelas_tugas WHERE kelas_kode = '$getclassid' ORDER BY id DESC";
        $gettugas = mysqli_query($db, $SQL_gettugas);
        $tag = 1;

        while($resultgettugas = $gettugas->fetch_assoc()){
            // double sql

            $SQL_getuser = "SELECT * FROM user WHERE username = '".$resultgettugas['username']."'";
            $getuser = mysqli_query($db, $SQL_getuser);
            $resultgetuser = mysqli_fetch_array($getuser);

            $waktu_buat =  date_id(date ('Y-m-d', $resultgettugas['waktu_buat']));
            $waktu_tenggat = date_id(date ('Y-m-d', $resultgettugas['tanggal_selesai']));
            $valuetenggat = date ('Y-m-d', $resultgettugas['tanggal_selesai']);
            
            // convert format timestamp now
            $now_conv = strtotime(date('y-m-d'));  
            $now_new = date ('y-m-d', $now_conv);  

            // convert real timestamp now
            $now_real = strtotime($now_new);

            if($now_real <= $resultgettugas['tanggal_selesai']){
                $color = 'success';
            }
            else{
                $color = 'danger';  
            }

            $tugaskode = $resultgettugas['tugas_kode'];

            $SQL_counmateri = "SELECT COUNT(id) AS jumlah FROM kelas_tugas_materi WHERE tugas_kode = '$tugaskode'";
            $countmateri = mysqli_query($db, $SQL_counmateri);
            $resultcountmateri = mysqli_fetch_array($countmateri);
            $uploadfilemateri = "";
            
            $SQL_counttugas = "SELECT COUNT(id) AS jumlah FROM kelas_tugas_pengumpulan WHERE tugas_kode = '$tugaskode' AND username = '$S_username'";
            $counttugas = mysqli_query($db, $SQL_counttugas);
            $resultcounttugas = mysqli_fetch_array($counttugas);

            $SQL_getmateriname = "SELECT * FROM kelas_tugas_materi WHERE tugas_kode = '$tugaskode'";
            $getmateriname = mysqli_query($db, $SQL_getmateriname);
            $resultgetmateriname = mysqli_fetch_array($getmateriname);

            $SQL_gettugasname = "SELECT * FROM kelas_tugas_pengumpulan WHERE tugas_kode = '$tugaskode' AND username = '$S_username'";
            $gettugasname = mysqli_query($db, $SQL_gettugasname);
            $resultgettugasname = mysqli_fetch_array($gettugasname);
            
            if($resultgetmateriname != NULL){
                $downloadmateri = "
                    <div class='text-center py-2'>
                        <a class='text-center btn-block btn-success p-2' target='_blank' href='".$resultgetmateriname['file_materi']."'>Unduh Materi</span></a>
                    </div>
                ";
                if(($S_rolekelas != "mahasiswa") && ($S_rolekelas != "dosen")  && ($S_rolekelas != "ketualab") && ($S_rolekelas != "KLDS") && ($statuskelas != "Non-Aktif")){
                    $hapusmateri = "
                        <a href='#' class='btn btn-danger w-25 ml-3 ' data-toggle='modal' data-target='#hapusmateri".$tag."'>Hapus Materi</a>
                    ";
                    $hapusmateri2 = "
                        <a href='#' class='btn btn-danger w-50 mt-3' data-toggle='modal' data-target='#hapusmateri".$tag."'>Hapus Materi</a>
                    ";
                }else{
                    $hapusmateri = ""; 
                    $hapusmateri2 = "";
                }
            }

            if($resultgettugasname != NULL){
                $downloadtugas = "
                    <div class='text-center py-2'>
                        <a class='text-center btn-block btn-success p-2' target='_blank' href='".$resultgettugasname['file_tugas']."'>Unduh Tugas</span></a>
                    </div>
                ";
            }

            

            if(($resultcountmateri['jumlah'] == 0)){

                if($statuskelas != "Non-Aktif"){
                    $uploadfilemateri = "
                        <form method='post' enctype='multipart/form-data'>
                            <div class='form-group'>
                                <div class='form-group'>
                                    <label for='#input-link-materi'>Upload Materi ".$resultgettugas['judul_tugas']." <span class='text-danger'><b>*</b></span></label>
                                    <input type='text' class='form-control' name='inputlinkmateri' id='input-link-materi' placeholder='Input link g-drive materi' required>
                                </div>
                            </div>
                            <input type='hidden' name='idtugasmateri' value='".$resultgettugas['tugas_kode']."'>
                            <input type='hidden' name='idkelasmateri' value='".$resultgettugas['kelas_kode']."'>
                            <input type='submit' class='text-white btn-sm btn-success form-control' name='uploadmaterikeas' id='uploadmaterikeas' value='Upload'>
                        </form>
                    ";
                }
                $downloadmateri = "Tidak ada materi.";
                $hapusmateri = ""; 
                $hapusmateri2 = "";
            }

            if($resultcounttugas['jumlah'] == 0){
                $downloadtugas = "Tidak ada tugas yang dikumpulkan.";
            }


            echo "
                    <div class='card h-100 my-3' id='".$tag."'>
                        <div class='card-header'>
                            <div class='row align-items-center text-left'>
                                <div class='col-1 d-none d-lg-block text-center'>
                                    <i class='fas fa-tasks fa-2x text-success'></i>
                                </div>
                                <div class='col-10 p-0'>
                                    <div class='row ml-3 my-0 align-items-center'>
                                        <h5 class='text-dark font-weight-bold my-0'>".$resultgettugas['judul_tugas']."</h5>
                                    </div>
            ";  
            if($statuskelas != "Non-Aktif"){
                if(($S_rolekelas != "dosen") && ($S_rolekelas != "mahasiswa") && ($S_rolekelas != "ketualab") && ($S_rolekelas != "KLDS")){
                    echo "
                                            <div class='row ml-3 my-1 align-items-center'>
                                                <a href='' data-toggle='modal' data-target='#edittugas".$tag."'><i class='fas fa-edit fa-1x text-success'></i></a><a href='' class='ml-3' data-toggle='modal' data-target='#hapustugas".$tag."'><i class='fas fa-trash fa-1x text-danger'></i></a>
                                            </div>  
                    ";
                }
            }

            if($resultgetuser['degree'] != ""){
                $degreetugas = ", ".$resultgetuser['degree'];
            }else{
                $degreetugas = "";
            }
            echo "
                                    <div class='row ml-3 mt-2 align-items-center d-none d-lg-block'>
                                        <h6 class='text-dark text-xs'>".$resultgetuser['firstname']." ".$resultgetuser['lastname'].$degreetugas." - ".$waktu_buat." <span class='text-".$color."'><i class='fas fa-calendar fa-1x ml-3 mr-1'></i>Tenggat : ".$waktu_tenggat ."</span></h6>
                                    </div>
                                    <div class='row ml-3 my-0 align-items-center d-lg-none'>
                                        <h6 class='text-dark text-xs'>".$resultgetuser['firstname']." ".$resultgetuser['lastname'].$degreetugas." - ".$waktu_buat." <br>
                                        <span class='text-".$color."'><i class='fas fa-calendar fa-1x my-1 mr-1'></i>Tenggat : ".$waktu_tenggat ."</span></h6>
                                    </div>
                                </div>
                            </div>
                            <hr class='my-0 mr-0 border border-5 border-dark'>
                        </div>
                        <div class='card-body my-0 ml-3 py-3'>
                            <h6 class='text-dark'>".$resultgettugas['deskripsi']."</h6>
                        </div>
                        <div class='card-footer my-0 ml-3 py-3'>
                            <div class='d-none d-lg-block'>
                                <div class='row'>
                                    <div class='col-6 d-flex justify-content-start'>
                                        <a href='#' class='btn btn-info w-25' data-toggle='modal' data-target='#materi".$tag."'>Materi</a>
                                        ".$hapusmateri."
                                        <h6 class='text-dark text-xs pl-3'>Materi file ".$resultcountmateri['jumlah']."/1</h6><br>
                                    </div>
                        ";
                        if($S_rolekelas == "mahasiswa"){
                            echo "
                                        <div class='col-6 d-flex justify-content-end'>
                                            <h6 class='text-dark text-xs pr-3'>Upload file ".$resultcounttugas['jumlah']."/1</h6>
                                            <a href='#' class='btn btn-secondary w-50' data-toggle='modal' data-target='#uploadtugas".$tag."'>Upload Tugas</a>
                                        </div>
                            ";
                        }else if(($S_rolekelas == "KPMS") || ($S_rolekelas == "KAMS")){
                            echo "
                                        <div class='col-6 d-flex justify-content-end'>
                                            <h6 class='text-dark text-xs pr-3'>Upload file ".$resultcounttugas['jumlah']."/1</h6>
                                            <a href='#' class='btn btn-secondary w-50' data-toggle='modal' data-target='#uploadtugas".$tag."'>Upload Tugas</a>
                                            <a href='#' class='btn btn-secondary w-50 ml-3' data-toggle='modal' data-target='#lihattugas".$tag."'>Lihat Tugas</a>
                                        </div>
                            ";
                        }else{
                            echo "
                                        <div class='col-6 d-flex justify-content-end'>
                                            <a href='#' class='btn btn-secondary w-50' data-toggle='modal' data-target='#lihattugas".$tag."'>Lihat Tugas</a>
                                        </div>
                            ";
                        }
                        echo "
                                </div>
                            </div>
                            <div class='row d-lg-none'>
                                <div class='col-12'>
                                    <h6 class='text-dark text-xs'>Materi file ".$resultcountmateri['jumlah']."/1</h6>
                                    <a href='#' class='btn btn-info w-50' data-toggle='modal' data-target='#materi".$tag."'>Materi</a>
                                    ".$hapusmateri2."
                                </div>
                            </div>
                        ";
                        if($S_rolekelas == "mahasiswa"){
                            echo "
                                <div class='row d-lg-none mt-3'>
                                    <div class='col-12'>
                                        <h6 class='text-dark text-xs'>Upload file ".$resultcounttugas['jumlah']."/1</h6>
                                        <a href='#' class='btn btn-secondary w-75' data-toggle='modal' data-target='#uploadtugas".$tag."'>Upload Tugas</a>
                                    </div>
                                </div>
                            ";
                        }else if(($S_rolekelas == "KPMS") || ($S_rolekelas == "KAMS")){
                            echo "
                                <div class='row d-lg-none mt-3'>
                                    <div class='col-12'>
                                        <h6 class='text-dark text-xs'>Upload file ".$resultcounttugas['jumlah']."/1</h6>
                                        <a href='#' class='btn btn-secondary w-75' data-toggle='modal' data-target='#uploadtugas".$tag."'>Upload Tugas</a>
                                        <a href='#' class='btn btn-secondary w-50 mt-3' data-toggle='modal' data-target='#lihattugas".$tag."'>Lihat Tugas</a>
                                    </div>
                                </div>
                            ";
                        }else{
                            echo "
                                <div class='row d-lg-none mt-3'>
                                    <div class='col-12'>
                                        <a href='#' class='btn btn-secondary w-50' data-toggle='modal' data-target='#lihattugas".$tag."'>Lihat Tugas</a>
                                    </div>
                                </div>       
                            ";
                        }
                        echo "
                        </div>
                    </div>
                    ";
                    if($resultgetmateriname != NULL){
                        echo "
                            <div class='modal fade' id='hapusmateri".$tag."' tabindex='-1' role='dialog' aria-labelledby='hapusmaterititle' aria-hidden='true'>
                                <div class='modal-dialog' role='document'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='hapusmaterititle'>Hapus materi</h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>
                                    <div class='modal-body'>
                                        <p>Ingin menghapus materi tugas <b>".$resultgettugas['judul_tugas']."</b>?</p>
                                    </div>
                                    <div class='modal-footer'>
                                        <form method='post'>
                                            <input type='hidden' name='id_materi' value='".$resultgetmateriname['tugas_kode']."'>
                                            <input type='hidden' name='nama_materi' value='".$resultgetmateriname['file_materi']."'>
                                            <input type='submit' class='btn btn-danger' name='hapusmateri' value='Hapus'>
                                        </form>
                                    </div>
                                </div>
                                </div>
                            </div>
                        ";
                    }

                    echo "

                    <div class='modal fade' id='edittugas".$tag."' tabindex='-1' role='dialog' aria-labelledby='edittugastitle' aria-hidden='true'>
                        <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                            <form method='post'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='edittugastitle'>Edit Tugas ".$resultgettugas['judul_tugas']."</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                    <div class='form-group'>
                                        <label for='edit-judul-tugas".$tag."'>Judul</label>
                                        <input type='text' class='form-control' name='editjudultugas' id='edit-judul-tugas' value='".$resultgettugas['judul_tugas']."' readonly>
                                    </div>
                                    <div class='form-group'>
                                        <label for='edit-deskripsi-tugas".$tag."'>Deskripsi</label>
                                        <textarea class='form-control ckeditor' name='editdeskripsitugas' id='edit-deskripsi-tugas".$tag."' rows='3'>".$resultgettugas['deskripsi']."</textarea>
                                    </div>
                                    <div class='form-group' id='simple-date4'>
                                        <label for='edit-tenggat-tugas".$tag."'>Tenggat tugas <span class='text-danger'>*</span></label>
                                        <input type='date' class='input-sm form-control' name='edittenggattugas' id='edit-tenggat-tugas".$tag."' value='".$valuetenggat."'>
                                    </div>
                                </div>
                                <div class='modal-footer'>
                                        <input type='hidden' name='id_tugas' value='".$resultgettugas['tugas_kode']."'>
                                        <input type='hidden' name='user_tugasedit' value='".$S_username."'>
                                        <input type='submit' class='btn btn-success' name='edittugas' value='Ubah'>
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>
                    <div class='modal fade' id='materi".$tag."' tabindex='-1' role='dialog' aria-labelledby='edittugastitle' aria-hidden='true'>
                        <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='edittugastitle'>Materi ".$resultgettugas['judul_tugas']."</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                    ".$downloadmateri."
                                <hr>
                            ";
                    if(($S_rolekelas != "dosen")&&($S_rolekelas != "mahasiswa")  && ($S_rolekelas != "ketualab") && ($S_rolekelas != "KLDS")){
                        echo $uploadfilemateri;
                    }
                    echo "
                                </div>
                        </div>
                        </div>
                    </div>
                    <div class='modal fade' id='hapustugas".$tag."' tabindex='-1' role='dialog' aria-labelledby='hapustugastitle' aria-hidden='true'>
                        <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='hapustugastitle'>Hapus tugas</h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>
                            <div class='modal-body'>
                                <p>Ingin menghapus tugas <b>".$resultgettugas['judul_tugas']."</b>?</p>
                                <p><b class='text-danger'>Peringatan!</b></p>
                                <p>Menghapus tugas akan juga menghapus keseluruhan <b>materi</b> dan <b>tugas-tugas</b> yang sudah dikumpulan. Pastikan data sudah di backup terlebih dahulu.</p>
                            </div>
                            <div class='modal-footer'>
                                <form method='post'>
                                    <input type='hidden' name='id_tugashapus' value='".$resultgettugas['tugas_kode']."'>
                                    <input type='hidden' name='id_kelastugashapus' value='".$resultgettugas['kelas_kode']."'>
                                    <input type='submit' class='btn btn-danger' name='hapustugas' value='Hapus'>
                                </form>
                            </div>
                        </div>
                        </div>
                    </div>

                ";
                if($statuskelas != "Non-Aktif"){
                    echo "
                            <div class='modal fade' id='uploadtugas".$tag."' tabindex='-1' role='dialog' aria-labelledby='uploadtugastitle' aria-hidden='true'>
                                <div class='modal-dialog' role='document'>
                                <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title' id='uploadtugastitle'>Upload ".$resultgettugas['judul_tugas']."</h5>
                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                <span aria-hidden='true'>&times;</span>
                                            </button>
                                        </div>
                                        <div class='modal-body'>
                                            ".$downloadtugas."
                                            <hr>
                                            <form method='post' enctype='multipart/form-data'>
                                                <div class='form-group'>
                                                    <div class='form-group'>
                                                        <label for='#input-link-tugas'>Tugas ".$resultgettugas['judul_tugas']." <span class='text-danger'><b>*</b></span></label>
                                                        <input type='text' class='form-control' name='inputlinktugas' id='input-link-tugas' placeholder='Input link g-drive tugas' required>
                                                    </div>
                                                </div>
                                                <input type='hidden' name='idtugaspengumpulan' value='".$resultgettugas['tugas_kode']."'>
                                                <input type='hidden' name='idkelaspengumpulan' value='".$resultgettugas['kelas_kode']."'>
                                                <input type='hidden' name='pengumpulan' value='".$resultcounttugas['jumlah']."'>
                                ";

                                if($resultcounttugas['jumlah'] > 0){
                                    $btnuploadtgs = "secondary";
                                }else{
                                    $btnuploadtgs = "success";
                                }
                                echo "
                                                <input type='submit' class='text-white btn-sm btn-".$btnuploadtgs." form-control' name='uploadtugaskelas' id='uploadtugaskelas' value='Upload'>
                                            </form>
                                        </div>
                                </div>
                                </div>
                            </div>
                        ";
                }else{
                    echo "
                        <div class='modal fade' id='uploadtugas".$tag."' tabindex='-1' role='dialog' aria-labelledby='uploadtugastitle' aria-hidden='true'>
                            <div class='modal-dialog' role='document'>
                            <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='uploadtugastitle'>Upload ".$resultgettugas['judul_tugas']."</h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>
                                    <div class='modal-body'>
                                        ".$downloadtugas."
                                        <hr>
                                    </div>
                            </div>
                            </div>
                        </div>
                    ";
                }
                echo "
                    <div class='modal fade w-100' id='lihattugas".$tag."' tabindex='-1' role='dialog' aria-labelledby='lihattugastitle' aria-hidden='true'>
                        <div class='modal-dialog modal-lg' role='document'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='lihattugastitle'>Data ".$resultgettugas['judul_tugas']."</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                        <div class='table-responsive p-3'>
                                            <table class='table align-items-center table-flush' id='tablelihattugas".$tag."'>
                                                <thead class='thead-light'>
                                                <tr>
                                                    <th>NPM</th>
                                                    <th>NAMA</th>
                                                    <th>STATUS</th>
                                                    <th>FILE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                    ";
                    $tgss = $resultgettugas['tugas_kode'];
                    $SQL_datatugas = "SELECT * FROM kelas_tugas_pengumpulan WHERE tugas_kode = '$tgss'";
                    $datatugas = mysqli_query($db, $SQL_datatugas);
                    
                    while($resultdatatugas = $datatugas -> fetch_assoc()){
                        $userdatatugas = getuserbyusername($resultdatatugas['username']);
                        
                        if($resultdatatugas['status'] == "terlambat"){
                            $statustugas = "<span class='badge badge-danger'>TERLAMBAT</span>";
                        }else{
                            $statustugas = "<span class='badge badge-success'>TEPAT WAKTU</span>";
                        }
                        
                        echo "
                            <tr>
                                <td>".$userdatatugas['username']."</td>
                                <td>".$userdatatugas['firstname']." ".$userdatatugas['lastname']."</td>
                                <td>".$statustugas."</td>
                                <td><a class='text-center btn-block btn-success p-2' target='_blank' href='".$resultdatatugas['file_tugas']."'>Download Tugas</a></td> 
                            </tr>
                    ";
                    }
                    
                    echo "
                                                </tbody>
                                            </table>
                                        </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                    
            ";
            $tag = $tag + 1;
        }
        echo "<div class='".$tag."' id='maxtagedittugas'></div>";
    }

    if(isset($_POST['edittugas'])){
        $tugasdeskripsi = $_POST['editdeskripsitugas'];
        $usernameedittugas = $_POST['user_tugasedit'];
        $tugastenggat = conv_timestamp($_POST['edittenggattugas']);
        $idtugas = $_POST['id_tugas'];
        $tugasnow = now_timestamp();
    
        if(($tugasdeskripsi != NULL) && ($tugastenggat != NULL)){
            $SQL_updatetugas = "UPDATE kelas_tugas SET deskripsi = '$tugasdeskripsi', tanggal_selesai = ' $tugastenggat', username = '$usernameedittugas', waktu_buat = '$tugasnow' WHERE tugas_kode = '$idtugas'";
            $updatetugas = mysqli_query($db, $SQL_updatetugas);

            if($updatetugas){
                $_SESSION['alert'] = $ALERT_tugasberhasildiupdate;
                header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
            }else{
                $_SESSION['alert'] = $ALERT_tugasgagaldiupdate;
                header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
            }
        }else{
            $_SESSION['alert'] = $ALERT_datatugaskosong;
            header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
        }
    }
    if(isset($_POST['hapusmateri'])){    
        $idmateri = $_POST['id_materi'];
        $namamateri = $_POST['nama_materi'];

        $SQL_deletemateri = "DELETE FROM kelas_tugas_materi WHERE tugas_kode = '$idmateri'";
        $deletemateri = mysqli_query($db, $SQL_deletemateri);

        if($deletemateri){
            $_SESSION['alert'] = $ALERT_materiberhasildihapus;
            // $folderdeletemateri = $__asset."data/materi/";
            // unlink($folderdeletemateri.$namamateri);
            header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
        }else{
            $_SESSION['alert'] = $ALERT_materigagaldihapus;
            header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
        }
    }


    if(isset($_POST["uploadmaterikeas"])){
        $idtugasmateri = $_POST['idtugasmateri'];
        $idkelasmateri = $_POST['idkelasmateri'];

        // AKTIFKAN JIKA KALIAN MENGGUNAKAN FILE SEBAGAI INPUTAN
        // $namauploadfilemateri = $_FILES['filemateri']['name'];
        // $namauploadfilemateri_tmp = $_FILES['filemateri']['tmp_name'];
        // $extfilemateri = pathinfo($namauploadfilemateri, PATHINFO_EXTENSION);
        // $folderuploadfilemateri = $__asset."data/materi/";
        // $fixednamefilemateri = "Materi_".$idtugasmateri."_".$idkelasmateri.".".$extfilemateri;
        
        // if($extfilemateri == "pdf"){
        //     move_uploaded_file($namauploadfilemateri_tmp, $folderuploadfilemateri.$fixednamefilemateri);
        //     $_SESSION['alert'] = $ALERT_materiberhasilupload;
        //     $SQL_insertmateri = "INSERT INTO kelas_tugas_materi(tugas_kode, file_materi) VALUES('$idtugasmateri', '$fixednamefilemateri')";
        //     $insertmateri = mysqli_query($db, $SQL_insertmateri);
        //     header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
        // }else if($extfilemateri == "zip"){
        //     move_uploaded_file($namauploadfilemateri_tmp, $folderuploadfilemateri.$fixednamefilemateri);
        //     $_SESSION['alert'] = $ALERT_materiberhasilupload;
        //     $SQL_insertmateri = "INSERT INTO kelas_tugas_materi(tugas_kode, file_materi) VALUES('$idtugasmateri', '$fixednamefilemateri')";
        //     $insertmateri = mysqli_query($db, $SQL_insertmateri);
        //     header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
        // }else if($extfilemateri == "rar"){
        //     move_uploaded_file($namauploadfilemateri_tmp, $folderuploadfilemateri.$fixednamefilemateri);
        //     $_SESSION['alert'] = $ALERT_materiberhasilupload;
        //     $SQL_insertmateri = "INSERT INTO kelas_tugas_materi(tugas_kode, file_materi) VALUES('$idtugasmateri', '$fixednamefilemateri')";
        //     $insertmateri = mysqli_query($db, $SQL_insertmateri);
        //     header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
        // }else{
        //     $_SESSION['alert'] = $ALERT_materitidaksesuai;
        //     header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
        // }

        // AKTIFKAN JIKA KALIAN MENGGUNAKAN LINK SEBAGAI INPUTAN

        $linkmateri = $_POST['inputlinkmateri'];

        if(($linkmateri != "") && ($idtugasmateri != "") && ($idkelasmateri != "")){
            if(str_contains($linkmateri, 'drive.google')){
                $SQL_cekmateri = "SELECT COUNT(id) AS Jumlah FROM kelas_tugas_materi WHERE tugas_kode = '$idtugasmateri'";
                $cekmateri = mysqli_query($db, $SQL_cekmateri);
                $resultcekmateri = mysqli_fetch_array($cekmateri);

                if($resultcekmateri['Jumlah'] == 0){
                    $SQL_inputmateri = "INSERT INTO kelas_tugas_materi(tugas_kode, file_materi) VALUES('$idtugasmateri', '$linkmateri')";
                    $inputmateri = mysqli_query($db, $SQL_inputmateri);

                    if($inputmateri){
                        $_SESSION['alert'] = $ALERT_materiberhasilupload;
                        header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
                    }else{
                        $_SESSION['alert'] = $ALERT_materigagalupload;
                        header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
                    }
            }else{
                $_SESSION['alert'] = $ALERT_materibukangoogle;
                header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
            }
            }else{
                if(str_contains($linkmateri, 'drive.google')){
                    $SQL_updatemateri = "UPDATE kelas_tugas_materi SET file_materi = '$linkmateri' WHERE tugas_kode = '$idtugasmateri'";
                    $updatemateri = mysqli_query($db, $SQL_updatemateri);

                    if($updatemateri){
                        $_SESSION['alert'] = $ALERT_materiberhasilupload;
                        header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
                    }else{
                        $_SESSION['alert'] = $ALERT_materigagalupload;
                        header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
                    }
                }else{
                    $_SESSION['alert'] = $ALERT_materibukangoogle;
                    header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
                }
            }
        }else{
            $_SESSION['alert'] = $ALERT_materikosong;
            header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
        }
    }

    if(isset($_POST['uploadtugaskelas'])){
        $idtugaskelas = $_POST['idtugaspengumpulan'];
        $idkelastugas = $_POST['idkelaspengumpulan'];
        $pengumpulan = $_POST['pengumpulan'];
        

        // AKTIFKAN JIKA KALIAN MENGGUNAKAN FILE SEBAGAI INPUTAN
        // $namauploadfiletugas = $_FILES['filetugas']['name'];
        // $namauploadfiletugas_tmp = $_FILES['filetugas']['tmp_name'];
        // $extfiletugas = pathinfo($namauploadfiletugas, PATHINFO_EXTENSION);
        // $folderuploadfiletugas = $__asset."data/assignment/";
        // $fixednamefiletugas = "TUGAS_".$S_username."_".$idtugaskelas."_".$idkelastugas.".".$extfiletugas;

        // $SQL_getjadwaluser = "SELECT jadwal FROM kelas_enrol WHERE kelas_kode = '$getclassid' AND username = '$S_username'";
        // $getjadwaluser = mysqli_query($db, $SQL_getjadwaluser);
        // $resultgetjadwaluser = mysqli_fetch_array($getjadwaluser);
        // $jadwalupload = $resultgetjadwaluser['jadwal'];

        // if($pengumpulan == 0){
        //     if($extfiletugas == "pdf"){
        //         move_uploaded_file($namauploadfiletugas_tmp, $folderuploadfiletugas.$fixednamefiletugas);
        //         $_SESSION['alert'] = $ALERT_tugasberhasilupload;
        //         $SQL_inserttugas = "INSERT INTO kelas_tugas_pengumpulan(tugas_kode, file_tugas, username, jadwal) VALUES('$idtugaskelas', '$fixednamefiletugas', '$S_username', '$jadwalupload')";
        //         $inserttugas = mysqli_query($db, $SQL_inserttugas);
        //         header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
        //     }else if($extfiletugas == "zip"){
        //         move_uploaded_file($namauploadfiletugas_tmp, $folderuploadfiletugas.$fixednamefiletugas);
        //         $_SESSION['alert'] = $ALERT_tugasberhasilupload;
        //         $SQL_inserttugas = "INSERT INTO kelas_tugas_pengumpulan(tugas_kode, file_tugas, username, jadwal) VALUES('$idtugaskelas', '$fixednamefiletugas', '$S_username', '$jadwalupload')";
        //         $inserttugas = mysqli_query($db, $SQL_inserttugas);
        //         header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
        //     }else if($extfiletugas == "rar"){
        //         move_uploaded_file($namauploadfiletugas_tmp, $folderuploadfiletugas.$fixednamefiletugas);
        //         $_SESSION['alert'] = $ALERT_tugasberhasilupload;
        //         $SQL_inserttugas = "INSERT INTO kelas_tugas_pengumpulan(tugas_kode, file_tugas, username, jadwal) VALUES('$idtugaskelas', '$fixednamefiletugas', '$S_username', '$jadwalupload')";
        //         $inserttugas = mysqli_query($db, $SQL_inserttugas);
        //         header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
        //     }else{
        //         $_SESSION['alert'] = $ALERT_tugastidaksesuai;
        //         header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
        //     }
        // }else{
        //     if($extfiletugas == "pdf"){
        //         move_uploaded_file($namauploadfiletugas_tmp, $folderuploadfiletugas.$fixednamefiletugas);
        //         $_SESSION['alert'] = $ALERT_tugasberhasilupload;
        //         $SQL_updatetugas = "UPDATE kelas_tugas_pengumpulan SET tugas_kode = '$idtugaskelas', file_tugas = '$fixednamefiletugas', username = '$S_username' , jadwal = '$jadwalupload' WHERE tugas_kode = '$idtugaskelas' AND username = '$S_username'";
        //         $inserttugas = mysqli_query($db, $SQL_updatetugas);
        //         header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
        //     }else if($extfiletugas == "zip"){
        //         move_uploaded_file($namauploadfiletugas_tmp, $folderuploadfiletugas.$fixednamefiletugas);
        //         $_SESSION['alert'] = $ALERT_tugasberhasilupload;
        //         $SQL_updatetugas = "UPDATE kelas_tugas_pengumpulan SET tugas_kode = '$idtugaskelas', file_tugas = '$fixednamefiletugas', username = '$S_username' , jadwal = '$jadwalupload' WHERE tugas_kode = '$idtugaskelas' AND username = '$S_username'";
        //         $inserttugas = mysqli_query($db, $SQL_updatetugas);
        //         header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
        //     }else if($extfiletugas == "rar"){
        //         move_uploaded_file($namauploadfiletugas_tmp, $folderuploadfiletugas.$fixednamefiletugas);
        //         $_SESSION['alert'] = $ALERT_tugasberhasilupload;
        //         $SQL_updatetugas = "UPDATE kelas_tugas_pengumpulan SET tugas_kode = '$idtugaskelas', file_tugas = '$fixednamefiletugas', username = '$S_username' , jadwal = '$jadwalupload' WHERE tugas_kode = '$idtugaskelas' AND username = '$S_username'";
        //         $inserttugas = mysqli_query($db, $SQL_updatetugas);
        //         header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
        //     }else{
        //         $_SESSION['alert'] = $ALERT_tugastidaksesuai;
        //         header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
        //     }
        // }

        // AKTIFKAN JIKA KALIAN MENGGUNAKAN LINK SEBAGAI INPUTAN

        $linktugas = $_POST['inputlinktugas'];


        $cektenggattugas = gettugasbykode($idtugaskelas);
        $waktukumpul = now_timestamp();
        if($waktukumpul <= $cektenggattugas['tanggal_selesai']){
            $statustugas = "tepatwaktu";
        }else{
            $statustugas = "terlambat";
        }

        if(($idtugaskelas != "") && ($linktugas != "")){

            if($pengumpulan == 0){
                $SQL_inserttugas = "INSERT INTO kelas_tugas_pengumpulan(tugas_kode, file_tugas, username, status) VALUES('$idtugaskelas', '$linktugas', '$S_username', '$statustugas')";
                $inserttugas = mysqli_query($db, $SQL_inserttugas);
                
                if($inserttugas){
                    $_SESSION['alert'] = $ALERT_tugasberhasilupload;
                    header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
                }else{
                    $_SESSION['alert'] = $ALERT_tugasgagalupload;
                    header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
                }
            }else{
                $SQL_updatetugas = "UPDATE kelas_tugas_pengumpulan SET file_tugas = '$linktugas', status = '$statustugas' WHERE tugas_kode = '$idtugaskelas' AND username = '$S_username'";
                $updatetugas = mysqli_query($db, $SQL_updatetugas);
                
                if($updatetugas){
                    $_SESSION['alert'] = $ALERT_tugasberhasilupload;
                    header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
                }else{
                    $_SESSION['alert'] = $ALERT_tugasgagalupload;
                    header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
                }
            }
        }else{
            $_SESSION['alert'] = $ALERT_tugaskosong;
            header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
        }
        
    }

    if(isset($_POST['hapustugas'])){
        $idtugashapus = $_POST['id_tugashapus'];
        $idkelastugashapus = $_POST['id_kelastugashapus'];

        $SQL_tugaspengumpulan = "SELECT * FROM kelas_tugas_pengumpulan WHERE tugas_kode = '$idtugashapus'";
        $tugaspengumpulan = mysqli_query($db, $SQL_tugaspengumpulan);

        while($resulttugaspengumpulan = $tugaspengumpulan -> fetch_assoc()){
            $filetugas = $resulttugaspengumpulan['file_tugas'];
            $tugakodehapus = $resulttugaspengumpulan['tugas_kode'];
            $usernametugas = $resulttugaspengumpulan['username'];
            $pathtugas = $__asset."data/assignment/";
            
            unlink($pathtugas.$filetugas);

            $SQL_hapustugaspengumpulan = "DELETE FROM kelas_tugas_pengumpulan WHERE tugas_kode = '$tugakodehapus' AND username = '$usernametugas'";
            $hapustugaspengumpulan = mysqli_query($db, $SQL_hapustugaspengumpulan);
        }

        $SQL_materi = "SELECT * FROM kelas_tugas_materi WHERE tugas_kode = '$idtugashapus'";
        $materi = mysqli_query($db, $SQL_materi);

        while($resulmateri = $materi -> fetch_assoc()){
            $filemateri = $resulmateri['file_materi'];
            $materikodehapus = $resulmateri['tugas_kode'];
            $pathmateri = $__asset."data/materi/";
            
            unlink($pathmateri.$filemateri);

            $SQL_hapusmateri = "DELETE FROM kelas_tugas_materi WHERE tugas_kode = '$tugakodehapus'";
            $hapusmateri = mysqli_query($db, $SQL_hapusmateri);
        }

        $SQL_hapustugaskelas = "DELETE FROM kelas_tugas WHERE tugas_kode = '$idtugashapus' AND kelas_kode = '$idkelastugashapus'";
        $hapustugaskelas = mysqli_query($db, $SQL_hapustugaskelas);

        if($hapustugaskelas){
            $_SESSION['alert'] = $ALERT_tugasberhasildihapus;
            header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
        }else{
            $_SESSION['alert'] = $ALERT_tugasgagaldihapus;
            header('location: '.LINK_kelas_nav($getclassid, 'tugas').'');
        }
        
    }

// peserta
    function btnpesertamanual(){
        Global $S_rolekelas, $statuskelas, $getclassid;

        if($statuskelas != "Non-Aktif"){
            if(($S_rolekelas != "dosen")&&($S_rolekelas != "mahasiswa")&&($S_rolekelas != "aslab")&&($S_rolekelas != "MHAS")){
                echo "
                    <button type='button' class='btn btn-secondary mt-3' data-toggle='modal' data-target='#tambahpesertamanual'>Tambah Mahasiswa</button>
                    <div class='modal fade' id='tambahpesertamanual' tabindex='-1' role='dialog' aria-labelledby='modaltambahpesertamanualtitle' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered' role='document'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modaltambahpesertamanualtitle'>Tambah Mahasiswa</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                    <form method='post' enctype='multipart/form-data'>
                                        <div class='form-group'>
                                            <label for='input-username-enrol'>Username (NPM) <span class='text-danger'>*</span></label>
                                            <input type='text' class='form-control' name='inputusernameenrol' id='input-username-enrol' placeholder='Masukkan Username' required>
                                        </div>
                                        <div class='form-group'>
                                            <label for='input-role-enrol'>Role <span class='text-danger'>*</span></label>
                                            <select class='form-control' name='inputroleenrol' id='input-role-enrol' required>
                                                <option value='mahasiswa'>Mahasiswa</option>
                                                <option value='MHAS'>Mahasiswa & Aslab (MHAS)</option>
                                                <option value='KAMS'>Kooraslab & mahasiswa (KAMS)</option>
                                                <option value='KPMS'>Koorpraktikum & mahasiswa (KPMS)</option>
                                            </select>
                                        </div>
                                        <div class='form-group mt-3'>
                                            <label for='input-role-enrol'>Kelas Mahasiswa</label>
                                            <select class='form-control' name='inputkelasmanual' id='input-role-enrol' required>
                                                <option value=''>Pilih Kelas</option>
                ";
                
                $jadwalkelas = getkelasbyid($getclassid);

                if($jadwalkelas['jadwal'] == "pagi"){
                    echo "
                        <option value='p'>P</option>
                        <option value='p1'>P1</option>
                    ";
                }else{
                    echo "
                        <option value='v'>V</option>
                    ";
                }
                
                echo "
                                            </select>
                                        </div>
                                        <div class='form-group mt-3'>
                                            <input type='submit' name='inputpesertamanual' class='btn btn-info btn-block' value='Tambahkan'>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                ";
            }
        }
    }

    function btnaslabmanual(){
        Global $S_rolekelas, $statuskelas, $getclassid;

        if($statuskelas != "Non-Aktif"){
            if(($S_rolekelas != "dosen")&&($S_rolekelas != "mahasiswa")&&($S_rolekelas != "aslab")&&($S_rolekelas != "MHAS")){
                echo "
                    <button type='button' class='btn btn-secondary mt-3' data-toggle='modal' data-target='#tambahaslabmanual'>Tambah Aslab</button>
                    <div class='modal fade' id='tambahaslabmanual' tabindex='-1' role='dialog' aria-labelledby='modaltambahaslabmanualtitle' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered' role='document'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modaltambahaslabmanualtitle'>Tambah Aslab</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                    <form method='post' enctype='multipart/form-data'>
                                        <div class='form-group'>
                                            <label for='input-username-enrol'>Username (NPM) <span class='text-danger'>*</span></label>
                                            <input type='text' class='form-control' name='inputusernameenrol' id='input-username-enrol' placeholder='Masukkan Username' required>
                                        </div>
                                        <div class='form-group'>
                                            <label for='input-role-enrol'>Role <span class='text-danger'>*</span></label>
                                            <select class='form-control' name='inputroleenrol' id='input-role-enrol' required>
                                                <option value='koorpraktikum'>Koorpraktikum</option>
                                                <option value='aslab'>Aslab</option>
                                            </select>
                                        </div>
                                        <div class='form-group mt-3'>
                                            <input type='submit' name='inputaslabmanual' class='btn btn-info btn-block' value='Tambahkan'>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                ";
            }
        }
    }


    if(isset($_POST['inputpesertamanual'])){
        $usernameenrol = $_POST['inputusernameenrol'];
        $rolenrol = $_POST['inputroleenrol'];
        $kelasdosen = $_POST['inputkelasmanual'];

        if(($usernameenrol != NULL) && ($rolenrol != NULL) && ($kelasdosen != NULL)){

            if($rolenrol == "KAMS"){
                $kooraslab = getkooraslab($getclassid);
                if(($usernameenrol == $kooraslab['username']) && ($kelasdosen != NULL)){
                    $SQL_insertpeserta = "UPDATE kelas_enrol SET role_kelas = '$rolenrol', kelas_dosen = '$kelasdosen' WHERE kelas_kode = '$getclassid' AND username = '$usernameenrol'";
                    $insertpeserta = mysqli_query($db, $SQL_insertpeserta);

                    if($insertpeserta){
                        $_SESSION['alert'] = $ALERT_enrolsukses;
                        header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
                    }else{
                        $_SESSION['alert'] = $ALERT_enrolgagal;
                        header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
                    }
                }else{
                    $_SESSION['alert'] = $ALERT_enrolgagal;
                    header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
                }
            }else if($rolenrol == "KPMS"){
                $koorprak = getkoorpraktikum($getclassid);
                if(($usernameenrol == $koorprak['username']) && ($kelasdosen != NULL)){
                    $SQL_insertpeserta = "UPDATE kelas_enrol SET role_kelas = '$rolenrol', kelas_dosen = '$kelasdosen' WHERE kelas_kode = '$getclassid' AND username = '$usernameenrol'";
                    $insertpeserta = mysqli_query($db, $SQL_insertpeserta);

                    if($insertpeserta){
                        $_SESSION['alert'] = $ALERT_enrolsukses;
                        header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
                    }else{
                        $_SESSION['alert'] = $ALERT_enrolgagal;
                        header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
                    }
                }else{
                    $_SESSION['alert'] = $ALERT_enrolgagal;
                    header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
                }
            }else{
                $SQL_cekenrol3 = "SELECT COUNT(id) AS Jumlah FROM kelas_enrol WHERE kelas_kode = '$getclassid' AND username = '$usernameenrol'";
                $cekenrol3 = mysqli_query($db, $SQL_cekenrol3);
                $resultcekenrol3 = mysqli_fetch_array($cekenrol3);

                $SQL_cekenrol4 = "SELECT COUNT(id) AS Jumlah FROM user WHERE username = '$usernameenrol'";
                $cekenrol4 = mysqli_query($db, $SQL_cekenrol4);
                $resultcekenrol4 = mysqli_fetch_array($cekenrol4);

                if(($resultcekenrol3['Jumlah'] < 1) && ($resultcekenrol4['Jumlah'] > 0)){

                    if(($rolenrol == "mahasiswa") || ($rolenrol == "MHAS")){
                        if($kelasdosen != NULL){
                            $SQL_insertpeserta = "INSERT INTO kelas_enrol(kelas_kode, username, role_kelas, kelas_dosen) VALUES('$getclassid', '$usernameenrol', '$rolenrol', '$kelasdosen')";
                            $insertpeserta = mysqli_query($db, $SQL_insertpeserta);
                        }else{
                            $_SESSION['alert'] = $ALERT_enrolgagal;
                            header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
                        }
                    }else{
                        $SQL_insertpeserta = "INSERT INTO kelas_enrol(kelas_kode, username, role_kelas) VALUES('$getclassid', '$usernameenrol', '$rolenrol')";
                        $insertpeserta = mysqli_query($db, $SQL_insertpeserta);
                    }

                    if($insertpeserta){
                        $_SESSION['alert'] = $ALERT_enrolsukses;
                        header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
                    }else{
                        $_SESSION['alert'] = $ALERT_enrolgagal;
                        header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
                    }
                }else{
                    $_SESSION['alert'] = $ALERT_enrolgagal;
                    header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
                }
            }
        }
    }

    if(isset($_POST['inputaslabmanual'])){
        $usernameenrol = $_POST['inputusernameenrol'];
        $rolenrol = $_POST['inputroleenrol'];

        if(($usernameenrol != NULL) && ($rolenrol != NULL)){
            $SQL_cekenrol3 = "SELECT COUNT(id) AS Jumlah FROM kelas_enrol WHERE kelas_kode = '$getclassid' AND username = '$usernameenrol'";
            $cekenrol3 = mysqli_query($db, $SQL_cekenrol3);
            $resultcekenrol3 = mysqli_fetch_array($cekenrol3);

            $SQL_cekenrol4 = "SELECT COUNT(id) AS Jumlah FROM user WHERE username = '$usernameenrol'";
            $cekenrol4 = mysqli_query($db, $SQL_cekenrol4);
            $resultcekenrol4 = mysqli_fetch_array($cekenrol4);

            if(($resultcekenrol3['Jumlah'] < 1) && ($resultcekenrol4['Jumlah'] > 0)){

                $SQL_insertpeserta = "INSERT INTO kelas_enrol(kelas_kode, username, role_kelas) VALUES('$getclassid', '$usernameenrol', '$rolenrol')";
                $insertpeserta = mysqli_query($db, $SQL_insertpeserta);

                if($insertpeserta){
                    $_SESSION['alert'] = $ALERT_enrolsukses;
                    header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
                }else{
                    $_SESSION['alert'] = $ALERT_enrolgagal;
                    header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
                }
            }else{
                $_SESSION['alert'] = $ALERT_enrolgagal;
                header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
            }
        }
    }

    function btndosenmanual(){
        Global $S_rolekelas, $statuskelas, $getclassid;

        if($statuskelas != "Non-Aktif"){
            if(($S_rolekelas == "kooraslab") || ($S_rolekelas == "ketualab") || ($S_rolekelas == "KLDS") || ($S_rolekelas == "KAMS") || ($S_rolekelas == "admin")){
                echo "
                    <button type='button' class='btn btn-secondary mt-3' data-toggle='modal' data-target='#tambahdosenmanual'>Tambah Dosen</button>
                    <div class='modal fade' id='tambahdosenmanual' tabindex='-1' role='dialog' aria-labelledby='modaltambahdosenmanualtitle' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered' role='document'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modaltambahdosenmanualtitle'>Tambah Dosen</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                    <form method='post' enctype='multipart/form-data'>
                                        <div class='form-group'>
                                            <label for='input-role-enrol-dosen'>Pilih Dosen <span class='text-danger'>*</span></label>
                                            <select class='form-control' name='inputroleenroldosen' id='input-role-enrol-dosen' required>
                    ";

                    $datadosen = getuserbyrole("dosen", "ketualab");
                    while ($rowdosen = $datadosen -> fetch_assoc()){
                        echo "
                                                    <option value='".$rowdosen['username']."'>".$rowdosen['firstname']."</option>
                        ";
                    }
                    echo "
                                            </select>
                                        </div>
                                        <div class='form-group'>
                                            <label for='input-role-enrol-dosen'>Pilih Dosen <span class='text-danger'>*</span></label>
                                            <select class='form-control' name='inputkelas' id='input-role-enrol-dosen' required>
                    ";

                    $jadwalkelas = cekjadwalkelas($getclassid);

                    if($jadwalkelas['jadwal'] == "pagi"){
                        echo "
                            <option value='p'>Kelas P</option>
                            <option value='p1'>Kelas P1</option>
                        ";
                    }else{
                        echo "
                            <option value='v'>Kelas V</option>
                        ";
                    }
                    
                    echo "
                                            </select>
                                        </div>
                                        <div class='form-group mt-3'>
                                            <input type='submit' name='inputdosenmanual' class='btn btn-info btn-block' value='Tambahkan'>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                ";
            }
        }
    }

    if(isset($_POST['inputdosenmanual'])){
        $usernameenrol = $_POST['inputroleenroldosen'];
        $kelasdosen = $_POST['inputkelas'];

        if(($usernameenrol != NULL) && ($kelasdosen != NULL)){
            $SQL_cekenrolexist = "SELECT COUNT(id) AS Jumlah FROM kelas_enrol WHERE kelas_kode = '$getclassid' AND username = '$usernameenrol'";
            $cekenrolexist = mysqli_query($db, $SQL_cekenrolexist);
            $resultcekenrolexist = mysqli_fetch_array($cekenrolexist);

            if($resultcekenrolexist['Jumlah'] == 0){
                $SQL_insertpeserta = "INSERT INTO kelas_enrol(kelas_kode, username, role_kelas, kelas_dosen) VALUES('$getclassid', '$usernameenrol', 'dosen', '$kelasdosen')";
                $insertpeserta = mysqli_query($db, $SQL_insertpeserta);
    
                if($insertpeserta){
                    $_SESSION['alert'] = $ALERT_enrolsukses;
                    header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
                }else{
                    $_SESSION['alert'] = $ALERT_enrolgagal;
                    header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
                }
            }else{
                $SQL_cekketualab = "SELECT COUNT(id) AS Jumlah FROM kelas_enrol WHERE kelas_kode = '$getclassid' AND username = '$usernameenrol' AND role_kelas = 'ketualab'";
                $cekketualab = mysqli_query($db, $SQL_cekketualab);
                $resultcekketualab = mysqli_fetch_array($cekketualab);

                if($resultcekketualab['Jumlah'] == 1){
                    $SQL_updatedatauserenrol = "UPDATE kelas_enrol SET kelas_dosen = '$kelasdosen', role_kelas = 'KLDS' WHERE kelas_kode = '$getclassid' AND username = '$usernameenrol' AND role_kelas = 'ketualab'";
                    $updatedatauserenrol = mysqli_query($db, $SQL_updatedatauserenrol);
                    
                    if($updatedatauserenrol){
                        $_SESSION['alert'] = $ALERT_enrolsukses;
                        header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
                    }else{
                        $_SESSION['alert'] = $ALERT_enrolgagal;
                        header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
                    }
                }else{
                    $_SESSION['alert'] = $ALERT_enrolgagal;
                    header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
                }
            }
        }
    }

    function btnpesertacsv(){
        Global $S_rolekelas, $statuskelas;

        if($statuskelas != "Non-Aktif"){
            if(($S_rolekelas != "dosen")&&($S_rolekelas != "mahasiswa")&&($S_rolekelas != "aslab")&&($S_rolekelas != "MHAS")){
                echo "
                    <button type='button' class='btn btn-secondary mt-3' data-toggle='modal' data-target='#tambahpeserta'>Tambah Peserta CSV</button>
                    <div class='modal fade' id='tambahpeserta' tabindex='-1' role='dialog' aria-labelledby='modaltambahpesertatitle' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered' role='document'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modaltambahpesertatitle'>Tambah Peserta</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                    <form method='post' enctype='multipart/form-data'>
                                        <a href='". LINK_download('asset/data/contoh/kelasenrol.csv')."'>Contoh File kelas_enrol.csv</a>
                                        <input type='file' class='text-white btn btn-info form-control-file' name='inputpesertacsv' id='inputpesertacsv'>
                                        <div class='form-group'>
                                            <br>
                                            <label for='delimiter'>Pilih delimiter</label>
                                            <select name='delimiter' class='form-control' id='delimiter' required>
                                                <option>;</option>
                                                <option>,</option>
                                            </select>
                                        </div>
                                        <div class='form-group mt-3'>
                                            <input type='submit' name='inputpeserta' class='btn btn-info btn-block' value='Upload'>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                ";
            }
        }
    }   

    if(isset($_POST['inputpeserta'])){
        $namapesertaupload = $_FILES['inputpesertacsv']['name'];
        $namapesertaupload_tmp = $_FILES['inputpesertacsv']['tmp_name'];
        $extpeserta = pathinfo($namapesertaupload, PATHINFO_EXTENSION);
        $folderuploadpeserta = $__asset."data/tmp_upload/";
        $fixednameuser = "uploadenrolkelas.csv";
        $delimitercsv = $_POST['delimiter'];
        
        if($extpeserta == "csv"){

            move_uploaded_file($namapesertaupload_tmp, $folderuploadpeserta.$fixednameuser);

            $folderuploadcsv = $__asset."data/tmp_upload/";
            $opencsv = fopen($folderuploadcsv."uploadenrolkelas.csv", 'r');
            $rowcount = 0;
            $error = 0;
            while(($rowcsv = fgetcsv($opencsv, 1000, $delimitercsv)) !== false) {  
                if($rowcsv[0] == "username"){
                    while(($kolcsv = fgetcsv($opencsv, 1000, $delimitercsv)) !== false){
                        $rowcount++;
                        if($rowcount < 1){
                            NULL;
                        }else{
                            $SQL_cekenrol0 = "SELECT COUNT(id) AS Jumlah FROM user WHERE username = '$kolcsv[0]'";
                            $cekenrol0 = mysqli_query($db, $SQL_cekenrol0);
                            $resultcekenrol0 = mysqli_fetch_assoc($cekenrol0);

                            $SQL_cekenrol1 = "SELECT COUNT(id) AS Jumlah FROM kelas_enrol WHERE kelas_kode = '$getclassid' AND username = '$kolcsv[0]' AND role_kelas = '$kolcsv[1]'";
                            $cekenrol1 = mysqli_query($db, $SQL_cekenrol1);
                            $resultcekenrol1 = mysqli_fetch_assoc($cekenrol1);

                            $SQL_cekenrol2 = "SELECT COUNT(id) AS Jumlah FROM kelas_enrol WHERE kelas_kode = '$getclassid' AND username = '$kolcsv[0]'";
                            $cekenrol2 = mysqli_query($db, $SQL_cekenrol2);
                            $resultcekenrol2 = mysqli_fetch_assoc($cekenrol2);

                            if(($resultcekenrol0['Jumlah'] == 1) && ($resultcekenrol1['Jumlah'] == 0) && ($resultcekenrol2['Jumlah'] == 0)){
                                if(($kolcsv[1] == "aslab") || ($kolcsv[1] == "koorpraktikum")){
                                    $SQL_insertpeserta = "INSERT INTO kelas_enrol(kelas_kode, username, role_kelas) VALUES('$getclassid', '$kolcsv[0]', '$kolcsv[1]')";
                                    $insertpeserta = mysqli_query($db, $SQL_insertpeserta);
                                }else{
                                    $SQL_insertpeserta = "INSERT INTO kelas_enrol(kelas_kode, username, role_kelas, kelas_dosen) VALUES('$getclassid', '$kolcsv[0]', '$kolcsv[1]', '$kolcsv[2]')";
                                    $insertpeserta = mysqli_query($db, $SQL_insertpeserta);
                                }
                            }else{
                                $error++;
                            }
                        }
                    }
                    header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
                    break;
                }else{
                    $_SESSION['alert'] = $ALERT_delimitertidakcocok;
                    header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
                    break;
                }
            }
            
            if($error == 0){
                $_SESSION['alert'] = $ALERT_enrolsukses;
                header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
            }else{
                $_SESSION['alert'] = $ALERT_enrolsuksessebagian;
                header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
            }
            
        }else{
            $_SESSION['alert'] = $ALERT_delimitertidakcocok;
            header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
        }

        unlink($folderuploadpeserta."uploadenrolkelas.csv");
    }

    $getdata = isset($_GET['data']) ? $_GET['data'] : 'mahasiswa';

    function theadpeserta(){
        Global $S_rolekelas, $getdata;
        
        if(($getdata == "mahasiswa") || ($getdata == "dosen")){
            echo "<th>Kelas</th>";
        }

        echo "<th>Telepon</th>";

        if(($S_rolekelas == "koorpraktikum") || ($S_rolekelas == "KPMS")){
            if(($getdata == "mahasiswa") || ($getdata == "aslab")){
                echo "<th>Aksi</th";
            }
        }else if(($S_rolekelas == "kooraslab") || ($S_rolekelas == "KAMS")){
            if(($getdata == "mahasiswa") || ($getdata == "aslab") || ($getdata == "koorpraktikum") || ($getdata == "dosen")){
                echo "<th>Aksi</th";
            }
        }else if(($S_rolekelas == "ketualab") || ($S_rolekelas == "KLDS") || ($S_rolekelas == "admin")){
            if(($getdata == "mahasiswa") || ($getdata == "aslab") || ($getdata == "koorpraktikum") || ($getdata == "dosen")){
                echo "<th>Aksi</th";
            }
        }
    }

    if($getdata == "mahasiswa"){
        $actmhs = "active";
        $actaslab = "";
        $actkoorp = "";
        $actkoora = "";
        $actds = "";
        $actka = "";
    }else if($getdata == "aslab"){
        $actmhs = "";
        $actaslab = "active";
        $actkoorp = "";
        $actkoora = "";
        $actds = "";
        $actka = "";
    }else if($getdata == "koorpraktikum"){
        $actmhs = "";
        $actaslab = "";
        $actkoorp = "active";
        $actkoora = "";
        $actds = "";
        $actka = "";
    }else if($getdata == "kooraslab"){
        $actmhs = "";
        $actaslab = "";
        $actkoorp = "";
        $actkoora = "active";
        $actds = "";
        $actka = "";
    }else if($getdata == "dosen"){
        $actmhs = "";
        $actaslab = "";
        $actkoorp = "";
        $actkoora = "";
        $actds = "active";
        $actka = "";
    }else if($getdata == "ketualab"){
        $actmhs = "";
        $actaslab = "";
        $actkoorp = "";
        $actkoora = "";
        $actds = "";
        $actka = "active";
    }else{
        header('location: 404');
    }

    function navpeserta(){
        Global $getclassid, $actmhs, $actaslab, $actkoorp, $actkoora, $actds, $actka;

        echo "
            <ul class='nav nav-tabs'>
                <li class='nav-item'>
                    <a class='nav-link ".$actmhs."' aria-current='page' href='".LINK_kelas_nav($getclassid, "peserta")."&data=mahasiswa'>Mahasiswa</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link ".$actaslab."' aria-current='page' href='".LINK_kelas_nav($getclassid, "peserta")."&data=aslab'>Aslab</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link ".$actkoorp."' aria-current='page' href='".LINK_kelas_nav($getclassid, "peserta")."&data=koorpraktikum'>Koor Praktikum</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link ".$actkoora."' aria-current='page' href='".LINK_kelas_nav($getclassid, "peserta")."&data=kooraslab'>koor Aslab</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link ".$actds."' aria-current='page' href='".LINK_kelas_nav($getclassid, "peserta")."&data=dosen'>Dosen Pengampu</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link ".$actka."' aria-current='page' href='".LINK_kelas_nav($getclassid, "peserta")."&data=ketualab'>Ketua Lab</a>
                </li>
            </ul>
        ";
    }

    function tabmahasiswa(){
        Global $getclassid, $S_rolekelas;

        $kelasdosendata = getkelasdosen($getclassid);
        $countkelasdosen = 0;
        $kelasjadwal = getsimplekelasbyid($getclassid);

        if($kelasjadwal['jadwal'] == "pagi"){
            $cls = isset($_GET['cls']) ? $_GET['cls'] : 'p';
        }else{
            $cls = isset($_GET['cls']) ? $_GET['cls'] : 'v';
        }
        $data = isset($_GET['data']) ? $_GET['data'] : 'mahasiswa';
        if(($S_rolekelas != "mahasiswa") && ($S_rolekelas != "dosen") && ($data == "mahasiswa")){
            echo "<ul class='nav nav-tabs'>";
            while($rowkelasdosendata = $kelasdosendata -> fetch_assoc()){
                if($rowkelasdosendata['kelas_dosen'] == $cls){
                    $active = "active";
                }else{
                    $active = "";
                }
                echo "
                    <li class='nav-item'>
                        <a class='nav-link ".$active."' aria-current='page' href='".LINK_kelas_nav($getclassid, "peserta")."&data=mahasiswa&cls=".$rowkelasdosendata['kelas_dosen']."'>".strtoupper($rowkelasdosendata['kelas_dosen'])."</a>
                    </li>
                ";
                $countkelasdosen++;
            }
            echo "</ul>";
            echo "<h6 class='text-primary mr-3'>Data Mahasiswa Kelas <b>".strtoupper($cls)."</b></h6>";
        }
    }

    function showpeserta(){
        Global $db, $S_username, $getclassid, $S_rolestatus, $S_rolekelas, $getkelasenroldata, $__asset, $statuskelas, $getdata;

        $roledata = isset($_GET['data']) ? $_GET['data'] : 'mahasiswa';

        $getdatapeserta = getenrolbyrole($getclassid, $roledata);

        if(($roledata == "ketualab") || ($roledata == "dosen")){

            $dataKLDS = getuserKLDSrole($getclassid);
            $tagKLDS = 1;
            while($rowdataKLDS = $dataKLDS -> fetch_assoc()){

                if($rowdataKLDS['picture'] == "user"){
                    $pp1 = $__asset."/profile_img/".$rowdataKLDS['picture'].".png";
                }else{
                    $pp1 = $rowdataKLDS['picture'];
                }

                echo "
                    <tr>
                        <td class='text-center'><img class='rounded-circle' style='width: 35px; height: 35px; object-fit: fill;' src='".$pp1."'></td>
                        <td>".$rowdataKLDS['username']."</td>
                        <td>".$rowdataKLDS['firstname']."</td>
                ";

                if($roledata == "dosen"){
                    echo "
                            <td>Dosen Pengampu</td>
                    ";
                }else if($roledata == "ketualab"){
                    echo "
                            <td>Ketua Lab</td>
                    ";
                }

                if($roledata == "dosen"){
                    if($rowdataKLDS['kelas_dosen'] == "p"){
                        echo "<td>P</td>";
                    }else if($rowdataKLDS['kelas_dosen'] == "p1"){
                        echo "<td>P1</td>";
                    }else if($rowdataKLDS['kelas_dosen'] == "v"){
                        echo "<td>V</td>";
                    }else{
                        echo "<td>Belum Terdaftar</td>";
                    }
                }

                echo "
                        <td><a href='https://wa.me/+62".$rowdataKLDS['phone']."'><i class='fas fa-phone text-success'></i></a></td>
                ";

                if($roledata == "dosen"){
                    echo "
                        <td>
                            <a href='#'><i class='fas fa-trash text-danger' data-toggle='modal' data-target='#hapusKLDS".$tagKLDS."'></i></a>
                            <div class='modal fade' id='hapusKLDS".$tagKLDS."' tabindex='-1' role='dialog' aria-labelledby='modalhapusKLDStitle".$tagKLDS."' aria-hidden='true'>
                                <div class='modal-dialog modal-dialog-centered' role='document'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title' id='modalhapusKLDStitle".$tagKLDS."'>Hapus Peserta</h5>
                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                <span aria-hidden='true'>&times;</span>
                                            </button>
                                        </div>
                                        <div class='modal-body'>
                                            <h6>Hapus Peserta ".$rowdataKLDS['username']." - ".$rowdataKLDS['firstname']."</h6>
                                        </div>
                                        <form method='post'>
                                            <div class='modal-footer'>
                                                <input type='hidden' name='usernameKLDS' id='usernameKLDS' value='".$rowdataKLDS['username']."'>
                                                <input class='btn btn-danger' type='submit' name='hapusdataKLDS' id='hapusdataKLDS' value='Hapus'>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    "; 
                }

                echo"
                    </tr>
                ";
            }

        }

        if(($roledata == "koorpraktikum") || ($roledata == "mahasiswa")){
            $dataKPMS = getuserKPMSrole($getclassid);
            $tagKPMS = 1;
            while($rowdataKPMS = $dataKPMS -> fetch_assoc()){

                if($rowdataKPMS['picture'] == "user"){
                    $pp1 = $__asset."/profile_img/".$rowdataKPMS['picture'].".png";
                }else{
                    $pp1 = $rowdataKPMS['picture'];
                }

                echo "
                    <tr>
                        <td class='text-center'><img class='rounded-circle' style='width: 35px; height: 35px; object-fit: fill;' src='".$pp1."'></td>
                        <td>".$rowdataKPMS['username']."</td>
                        <td>".$rowdataKPMS['firstname']."</td>
                ";

                if($roledata == "mahasiswa"){
                    echo "
                            <td>Mahasiswa</td>
                    ";
                }else if($roledata == "koorpraktikum"){
                    echo "
                            <td>Koor Praktikum</td>
                    ";
                }

                if($roledata == "mahasiswa"){
                    if($rowdataKPMS['kelas_dosen'] == "p"){
                        echo "<td>P</td>";
                    }else if($rowdataKPMS['kelas_dosen'] == "p1"){
                        echo "<td>P1</td>";
                    }else if($rowdataKPMS['kelas_dosen'] == "v"){
                        echo "<td>V</td>";
                    }else{
                        echo "<td>Belum Terdaftar</td>";
                    }
                }

                echo "
                        <td><a href='https://wa.me/+62".$rowdataKPMS['phone']."'><i class='fas fa-phone text-success'></i></a></td>
                ";

                if($roledata == "mahasiswa"){
                    echo "
                        <td>
                            <a href='#'><i class='fas fa-trash text-danger' data-toggle='modal' data-target='#hapusKPMS".$tagKPMS."'></i></a>
                            <div class='modal fade' id='hapusKPMS".$tagKPMS."' tabindex='-1' role='dialog' aria-labelledby='modalhapusKPMStitle".$tagKPMS."' aria-hidden='true'>
                                <div class='modal-dialog modal-dialog-centered' role='document'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title' id='modalhapusKPMStitle".$tagKPMS."'>Hapus Peserta</h5>
                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                <span aria-hidden='true'>&times;</span>
                                            </button>
                                        </div>
                                        <div class='modal-body'>
                                            <h6>Hapus Peserta ".$rowdataKPMS['username']." - ".$rowdataKPMS['firstname']."</h6>
                                        </div>
                                        <form method='post'>
                                            <div class='modal-footer'>
                                                <input type='hidden' name='usernameKPMS' id='usernameKPMS' value='".$rowdataKPMS['username']."'>
                                                <input class='btn btn-danger' type='submit' name='hapusdataKPMS' id='hapusdataKPMS' value='Hapus'>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    "; 
                }

                echo"
                    </tr>
                ";
            }
        }

        if(($roledata == "kooraslab") || ($roledata == "mahasiswa")){
            $dataKAMS = getuserKAMSrole($getclassid);
            $tagKAMS= 1;
            while($rowdataKAMS= $dataKAMS-> fetch_assoc()){

                if($rowdataKAMS['picture'] == "user"){
                    $pp1 = $__asset."/profile_img/".$rowdataKAMS['picture'].".png";
                }else{
                    $pp1 = $rowdataKAMS['picture'];
                }

                echo "
                    <tr>
                        <td class='text-center'><img class='rounded-circle' style='width: 35px; height: 35px; object-fit: fill;' src='".$pp1."'></td>
                        <td>".$rowdataKAMS['username']."</td>
                        <td>".$rowdataKAMS['firstname']."</td>
                ";

                if($roledata == "mahasiswa"){
                    echo "
                            <td>Mahasiswa</td>
                    ";
                }else if($roledata == "kooraslab"){
                    echo "
                            <td>Koor Aslab</td>
                    ";
                }

                if($roledata == "mahasiswa"){
                    if($rowdataKAMS['kelas_dosen'] == "p"){
                        echo "<td>P</td>";
                    }else if($rowdataKAMS['kelas_dosen'] == "p1"){
                        echo "<td>P1</td>";
                    }else if($rowdataKAMS['kelas_dosen'] == "v"){
                        echo "<td>V</td>";
                    }else{
                        echo "<td>Belum Terdaftar</td>";
                    }
                }

                echo "
                        <td><a href='https://wa.me/+62".$rowdataKAMS['phone']."'><i class='fas fa-phone text-success'></i></a></td>
                ";

                if($roledata == "mahasiswa"){
                    echo "
                        <td>
                            <a href='#'><i class='fas fa-trash text-danger' data-toggle='modal' data-target='#hapusKAMS".$tagKAMS."'></i></a>
                            <div class='modal fade' id='hapusKAMS".$tagKAMS."' tabindex='-1' role='dialog' aria-labelledby='modalhapusKAMStitle".$tagKAMS."' aria-hidden='true'>
                                <div class='modal-dialog modal-dialog-centered' role='document'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title' id='modalhapusKAMStitle".$tagKAMS."'>Hapus Peserta</h5>
                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                <span aria-hidden='true'>&times;</span>
                                            </button>
                                        </div>
                                        <div class='modal-body'>
                                            <h6>Hapus Peserta ".$rowdataKAMS['username']." - ".$rowdataKAMS['firstname']."</h6>
                                        </div>
                                        <form method='post'>
                                            <div class='modal-footer'>
                                                <input type='hidden' name='usernameKAMS' id='usernameKAMS' value='".$rowdataKAMS['username']."'>
                                                <input class='btn btn-danger' type='submit' name='hapusdataKAMS' id='hapusdataKAMS' value='Hapus'>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    "; 
                }

                echo"
                    </tr>
                ";
            }
        }

        if(($roledata == "aslab") || ($roledata == "mahasiswa")){
            $dataMHAS = getuserMHASrole($getclassid);
            $tagMHAS= 1;
            while($rowdataMHAS= $dataMHAS-> fetch_assoc()){

                if($rowdataMHAS['picture'] == "user"){
                    $pp1 = $__asset."/profile_img/".$rowdataMHAS['picture'].".png";
                }else{
                    $pp1 = $rowdataMHAS['picture'];
                }

                echo "
                    <tr>
                        <td class='text-center'><img class='rounded-circle' style='width: 35px; height: 35px; object-fit: fill;' src='".$pp1."'></td>
                        <td>".$rowdataMHAS['username']."</td>
                        <td>".$rowdataMHAS['firstname']."</td>
                ";

                if($roledata == "mahasiswa"){
                    echo "
                            <td>Mahasiswa</td>
                    ";
                }else if($roledata == "aslab"){
                    echo "
                            <td>Asisten Lab</td>
                    ";
                }

                if($roledata == "mahasiswa"){
                    if($rowdataMHAS['kelas_dosen'] == "p"){
                        echo "<td>P</td>";
                    }else if($rowdataMHAS['kelas_dosen'] == "p1"){
                        echo "<td>P1</td>";
                    }else if($rowdataMHAS['kelas_dosen'] == "v"){
                        echo "<td>V</td>";
                    }else{
                        echo "<td>Belum Terdaftar</td>";
                    }
                }

                echo "
                        <td><a href='https://wa.me/+62".$rowdataMHAS['phone']."'><i class='fas fa-phone text-success'></i></a></td>
                ";

                echo"
                    </tr>
                ";
            }
        }
        
        $tagpst = 1;

        if(($S_rolekelas == "mahasiswa") || ($S_rolekelas == "dosen")){
            $clsmain = getkelasdosenbyusername($getclassid, $S_username);
            $cls = $clsmain['kelas_dosen'];
        }else{
            $kelasjadwal1 = getsimplekelasbyid($getclassid);
            
            if($kelasjadwal1['jadwal'] == "pagi"){
                $cls = isset($_GET['cls']) ? $_GET['cls'] : 'p';
            }else{
                $cls = isset($_GET['cls']) ? $_GET['cls'] : 'v';
            }
        }

        if($roledata == "mahasiswa"){
            if($cls == "p"){
                $getdatap = getmahasiswabykelasdosen($getclassid, $roledata, $cls);
            }else if($cls == "p1"){
                $getdatap = getmahasiswabykelasdosen($getclassid, $roledata, $cls);
            }else if($cls == "v"){
                $getdatap = getmahasiswabykelasdosen($getclassid, $roledata, $cls);
            }
        }else{
            $getdatap = $getdatapeserta;
        }

        while ($rowdatapeserta = $getdatap -> fetch_assoc()){
            
            if($rowdatapeserta['picture'] == "user"){
                $pp = $__asset."/profile_img/".$rowdatapeserta['picture'].".png";
            }else{
                $pp = $rowdatapeserta['picture'];
            }

            $reolll = namerole($rowdatapeserta['role_kelas']);
            echo "
                <tr>
                    <td class='text-center'><img class='rounded-circle' style='width: 35px; height: 35px; object-fit: fill;' src='".$pp."'></td>
                    <td>".$rowdatapeserta['username']."</td>
                    <td>".$rowdatapeserta['firstname']."</td>
                    <td>".$reolll."</td>
            ";
            if(($roledata == "mahasiswa") || ($roledata == "dosen")){
                if($rowdatapeserta['kelas_dosen'] == "p"){
                    echo "<td>P</td>";
                }else if($rowdatapeserta['kelas_dosen'] == "p1"){
                    echo "<td>P1</td>";
                }else if($rowdatapeserta['kelas_dosen'] == "v"){
                    echo "<td>V</td>";
                }else{
                    echo "<td>Belum Terdaftar</td>";
                }
                
            }
            echo"
                    <td><a href='https://wa.me/+62".$rowdatapeserta['phone']."'><i class='fas fa-phone text-success'></i></a></td>
            ";

        

            if(($S_rolekelas == "koorpraktikum") || ($S_rolekelas == "KPMS")){
                if(($getdata == "mahasiswa") || ($getdata == "aslab")){
                    echo "
                    <td>
                        <a href='#'><i class='fas fa-trash text-danger' data-toggle='modal' data-target='#hapuspeserta".$tagpst."'></i></a>
                        <div class='modal fade' id='hapuspeserta".$tagpst."' tabindex='-1' role='dialog' aria-labelledby='modalhapuspesertatitle".$tagpst."' aria-hidden='true'>
                            <div class='modal-dialog modal-dialog-centered' role='document'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='modalhapuspesertatitle".$tagpst."'>Hapus Peserta</h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>
                                    <div class='modal-body'>
                                        <h6>Hapus Peserta ".$rowdatapeserta['username']." - ".$rowdatapeserta['firstname']."</h6>
                                    </div>
                                    <form method='post'>
                                        <div class='modal-footer'>
                                            <input type='hidden' id='usernamepeserta' name='usernamepeserta' value='".$rowdatapeserta['username']."'>
                                            <input class='btn btn-danger' type='submit' value='Hapus' id='hapuspeserta' name='hapuspeserta'>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>";
                    
                }
            }else if(($S_rolekelas == "kooraslab") || ($S_rolekelas == "KAMS")){
                if(($getdata == "mahasiswa") || ($getdata == "aslab") || ($getdata == "koorpraktikum") || ($getdata == "dosen")){
                    echo "
                    <td>
                        <a href='#'><i class='fas fa-trash text-danger' data-toggle='modal' data-target='#hapuspeserta".$tagpst."'></i></a>
                        <div class='modal fade' id='hapuspeserta".$tagpst."' tabindex='-1' role='dialog' aria-labelledby='modalhapuspesertatitle".$tagpst."' aria-hidden='true'>
                            <div class='modal-dialog modal-dialog-centered' role='document'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='modalhapuspesertatitle".$tagpst."'>Hapus Peserta</h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>
                                    <div class='modal-body'>
                                        <h6>Hapus Peserta ".$rowdatapeserta['username']." - ".$rowdatapeserta['firstname']."</h6>
                                    </div>
                                    <form method='post'>
                                        <div class='modal-footer'>
                                            <input type='hidden' id='usernamepeserta' name='usernamepeserta' value='".$rowdatapeserta['username']."'>
                                            <input class='btn btn-danger' type='submit' value='Hapus' id='hapuspeserta' name='hapuspeserta'>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>";
                }
            }else if(($S_rolekelas == "ketualab") || ($S_rolekelas == "KLDS") || ($S_rolekelas == "admin")){
                if(($getdata == "mahasiswa") || ($getdata == "aslab") || ($getdata == "koorpraktikum") || ($getdata == "dosen")){
                    echo "
                    <td>
                        <a href='#'><i class='fas fa-trash text-danger' data-toggle='modal' data-target='#hapuspeserta".$tagpst."'></i></a>
                        <div class='modal fade' id='hapuspeserta".$tagpst."' tabindex='-1' role='dialog' aria-labelledby='modalhapuspesertatitle".$tagpst."' aria-hidden='true'>
                            <div class='modal-dialog modal-dialog-centered' role='document'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='modalhapuspesertatitle".$tagpst."'>Hapus Peserta</h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>
                                    <div class='modal-body'>
                                        <h6>Hapus Peserta ".$rowdatapeserta['username']." - ".$rowdatapeserta['firstname']."</h6>
                                    </div>
                                    <form method='post'>
                                        <div class='modal-footer'>
                                            <input type='hidden' id='usernamepeserta' name='usernamepeserta' value='".$rowdatapeserta['username']."'>
                                            <input class='btn btn-danger' type='submit' value='Hapus' id='hapuspeserta' name='hapuspeserta'>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>";
                }
            }
            echo "
                </tr>
            ";

            $tagpst++;
        }
    }

    if(isset($_POST['hapusdataKLDS'])){
        $usernameKLDS = $_POST['usernameKLDS'];

        $SQL_hapusKLDS = "UPDATE kelas_enrol SET role_kelas = 'ketualab', kelas_dosen = NULL WHERE kelas_kode = '$getclassid' AND username = '$usernameKLDS'";
        $hapusKLDS = mysqli_query($db, $SQL_hapusKLDS);

        if($hapusKLDS){
            $_SESSION['alert'] = $ALERT_pesertaberhasilhapus;
            header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
        }else{
            $_SESSION['alert'] = $ALERT_pesertagagalhapus;
            header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
        }
    }

    if(isset($_POST['hapusdataKPMS'])){
        $usernameKPMS = $_POST['usernameKPMS'];

        $SQL_hapusKPMS = "UPDATE kelas_enrol SET role_kelas = 'koorpraktikum', kelas_dosen = NULL WHERE kelas_kode = '$getclassid' AND username = '$usernameKPMS'";
        $hapusKPMS = mysqli_query($db, $SQL_hapusKPMS);

        if($hapusKPMS){
            $_SESSION['alert'] = $ALERT_pesertaberhasilhapus;
            header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
        }else{
            $_SESSION['alert'] = $ALERT_pesertagagalhapus;
            header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
        }
    }

    if(isset($_POST['hapusdataKAMS'])){
        $usernameKAMS = $_POST['usernameKAMS'];

        $SQL_hapusKAMS = "UPDATE kelas_enrol SET role_kelas = 'kooraslab', kelas_dosen = NULL WHERE kelas_kode = '$getclassid' AND username = '$usernameKAMS'";
        $hapusKAMS = mysqli_query($db, $SQL_hapusKAMS);

        if($hapusKAMS){
            $_SESSION['alert'] = $ALERT_pesertaberhasilhapus;
            header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
        }else{
            $_SESSION['alert'] = $ALERT_pesertagagalhapus;
            header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
        }
    }

    if(isset($_POST['hapuspeserta'])){
        $usernamehapusP = $_POST['usernamepeserta'];

        $SQL_hapuspeserta = "DELETE FROM kelas_enrol WHERE kelas_kode = '$getclassid' AND username = '$usernamehapusP'";
        $hapuspeserta = mysqli_query($db, $SQL_hapuspeserta);

        if($hapuspeserta){
            $_SESSION['alert'] = $ALERT_pesertaberhasilhapus;
            header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
        }else{
            $_SESSION['alert'] = $ALERT_pesertagagalhapus;
            header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
        }
    }

    if(isset($_POST['updatesyarat'])){
        $usernamesyarat = $_POST['usernamesyarat'];
        $kwitansikumpul = $_POST['pengumpulankwitansi'];
        $modulkumpul = $_POST['kepemilikanmodul'];
        $fotokumpul = $_POST['pengumpulanfoto'];

        if($kwitansikumpul == ""){
            $kwitansik = "No";
        }else{
            $kwitansik = $kwitansikumpul;
        }

        if($modulkumpul == ""){
            $modulk = "No";
        }else{
            $modulk = $modulkumpul;
        }

        if($fotokumpul == ""){
            $fotok = "No";
        }else{
            $fotok = $fotokumpul;
        }

        $SQL_cekusernamesyarat = "SELECT COUNT(id) AS Jumlah FROM kelas_syarat WHERE kelas_kode = '$getclassid' AND username = '$usernamesyarat'";
        $cekusernamesyarat = mysqli_query($db, $SQL_cekusernamesyarat);
        $resultcekusernamesyarat = mysqli_fetch_array($cekusernamesyarat);

        if($resultcekusernamesyarat['Jumlah'] == 0){
            $SQL_kirimsyarat = "INSERT INTO kelas_syarat(kelas_kode, username, kepemilikan_modul, pengumpulan_kwitansi, pengumpulan_foto) VALUES ('$getclassid', '$usernamesyarat', '$modulk', '$kwitansik', '$fotok')";
            $kirimsyarat = mysqli_query($db, $SQL_kirimsyarat);
            
            if($kirimsyarat){
                $_SESSION['alert'] = $ALERT_syaratberhasil;
                header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
            }else{
                $_SESSION['alert'] = $ALERT_syaratgagal;
                header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
            }
        }else{
            $SQL_updatesyarat = "UPDATE kelas_syarat SET kepemilikan_modul = '$modulk', pengumpulan_kwitansi = '$kwitansik', pengumpulan_foto = '$fotok' WHERE kelas_kode = '$getclassid' AND username = '$usernamesyarat'";
            $updatesyarat = mysqli_query($db, $SQL_updatesyarat);
            
            if($updatesyarat){
                $_SESSION['alert'] = $ALERT_syaratberhasil;
                header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
            }else{
                $_SESSION['alert'] = $ALERT_syaratgagal;
                header('location: '.LINK_kelas_nav($getclassid, "peserta").'');
            }
        }
    }

// show nilai

    function downloadnilai(){
        Global $db, $S_username, $getclassid, $S_rolestatus, $S_rolekelas, $LINK_downloadexcel, $LINK_downloadpdf;

        $kelasdosenuser = getkelasdosenbyusername($getclassid, $S_username);

        if(($S_rolekelas == "dosen") || ($S_rolekelas == "KLDS")){
            echo "
                <div class='mt-3'>
                    <a href='".$LINK_downloadexcel."&kode=nilai&klsid=".$getclassid."&klsdos=".$kelasdosenuser['kelas_dosen']."' class='btn btn-success'>Download Excel <i class='fa fa-file-excel ml-1' aria-hidden='true'></i></a>
                    <a href='".$LINK_downloadpdf."&kode=nilai&klsid=".$getclassid."&klsdos=".$kelasdosenuser['kelas_dosen']."' class='btn btn-danger ml-2'>Download PDF <i class='fa fa-file-pdf ml-1' aria-hidden='true'></i></a>
                </div>
            ";
        }
    }

    function showpengumpulantugas(){
        Global $db, $S_username, $getclassid, $S_rolestatus, $getkelasenroldata, $S_rolekelas, $statuskelas, $ALERT_linkpenilaianberhasil, $ALERT_linkpenilaiangagal, $ALERT_linkpenilaiansalah;

        $kelasdata = getkelasbyid($getclassid);

        if(($S_rolekelas == "koorpraktikum") || ($S_rolekelas == "kooraslab") || ($S_rolekelas == "KAMS") || ($S_rolekelas == "KPMS") || ($S_rolekelas == "aslab") || ($S_rolekelas == "MHAS")){
            if($kelasdata['link_penilaian'] == NULL){
                $linkp = "<button type='button' class='btn btn-secondary' disabled>Tidak ada link</button>";
                $disabled = "disabled";
            }else{
                $linkp = "<a href='".$kelasdata['link_penilaian']."' class='btn btn-primary' target='_blank'>Pergi ke..</a>";
                $disabled = "disabled";
            }
            echo "
                <div class='card mt-3'>
                    <div class='card-body'>
                        <h5 class='card-title'>Link Penilaian</h5>
                        <p class='card-text'>Klik link dibawah untuk mengisi penilaian.</p>
                        ".$linkp."
            ";
        

            if(($S_rolekelas == "koorpraktikum") || ($S_rolekelas == "KPMS")){
                echo "
                        <button type='button' class='btn btn-warning' data-toggle='modal' data-target='#inputlinkpenilaian'>Input Link</button>

                        <div class='modal fade' id='inputlinkpenilaian' tabindex='-1' role='dialog' aria-labelledby='inputlinkpenilaiantitle' aria-hidden='true'>
                            <div class='modal-dialog modal-dialog-centered' role='document'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='inputlinkpenilaiantitle'>Input Link Penilaian</h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>
                                    <div class='modal-body'>
                                        <form method='post'>
                                            <div class='form-group'>
                                                <label for='#linkpenilaian'>Inputkan Link spreadsheet penilaian</label>
                                                <input id='inputlinkpenilaianform' name='inputlinkpenilaianform' type='text' placeholder='https://docs.google.com/spreadsheets/' class='form-control'>
                                            </div>
                                            <input id='submitlinkpenilaian' name='submitlinkpenilaian' type='submit' class='btn btn-primary col-lg-12' value='Tambah Link'>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                ";
            }
            echo "
                    </div>
                </div>
            ";
        }

        $datadosen = getdatadosenkelas($getclassid, $S_username);

        if(($S_rolekelas == "koorpraktikum") || ($S_rolekelas == "kooraslab") || ($S_rolekelas == "KAMS") || ($S_rolekelas == "KPMS") || ($S_rolekelas == "aslab") || ($S_rolekelas == "MHAS")){
            echo "
                <div class='card my-3'>
                    <div class='card-body'>
                        <h5 class='card-title text-dark font-weight-bold mb-2'>Penilaian Akhir - Asisten Laboratorium</h5>
                        <hr class='my-0 border border-5 border-dark'>
                        <div class='mt-3'>
                            <table class='table table-striped'>
                                <thead>
                                    <tr class='font-weight-bold'>
                                        <th scope='col'>NPM</th>
                                        <th scope='col'>Nama</th>
                                        <th scope='col'>Kelas</th>
                                        <th scope='col'>Nilai Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
            ";
        }else if(($S_rolekelas == "dosen") || ($S_rolekelas == "KLDS")){
            echo "
                <div class='card my-3'>
                    <div class='card-body'>
                        <h5 class='card-title text-dark font-weight-bold mb-2'>Penilaian Akhir - Dosen Pengampu (".strtoupper($datadosen['kelas_dosen']).")</h5>
                        <hr class='my-0 border border-5 border-dark'>
                        <div class='mt-3'>
                            <table class='table table-striped'>
                                <thead>
                                    <tr class='font-weight-bold'>
                                        <th scope='col'>NPM</th>
                                        <th scope='col'>Nama</th>
                                        <th scope='col'>Kelas</th>
                                        <th scope='col'>Nilai Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
            ";
        }else{
            echo "
                <div class='card my-3'>
                    <div class='card-body'>
                        <h5 class='card-title text-dark font-weight-bold mb-2'>Data Nilai Keseluruhan <span class='text-xs'>(".date_id(date ('Y-m-d', now_timestamp())).")</span></h5>
                        <hr class='my-0 border border-5 border-dark'>
                        <div class='mt-3'>
                            <table class='table table-striped'>
                                <thead>
                                    <tr class='font-weight-bold'>
                                        <th scope='col'>NPM</th>
                                        <th scope='col'>Nama</th>
                                        <th scope='col'>Kelas</th>
                                        <th scope='col'>Nilai Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
            ";
        }

        if(($S_rolekelas == "koorpraktikum") || ($S_rolekelas == "kooraslab") || ($S_rolekelas == "KAMS") || ($S_rolekelas == "KPMS") || ($S_rolekelas == "aslab") || ($S_rolekelas == "MHAS")){
            $dataenrol = getdatamahasiswaenrol($getclassid);
        }else if(($S_rolekelas == "dosen") || ($S_rolekelas == "KLDS")){
            $dataenrol = getdatamahasiswaenrolbykelasdosen($getclassid, $datadosen['kelas_dosen']);
        }else{
            $dataenrol = getdatamahasiswaenrol($getclassid);
        }

        while($rowdataenrol = $dataenrol -> fetch_assoc()){

            $datanilai = getnilaidataenrol($getclassid, $rowdataenrol['username']);

            if(($S_rolekelas == "koorpraktikum") || ($S_rolekelas == "kooraslab") || ($S_rolekelas == "KAMS") || ($S_rolekelas == "KPMS") || ($S_rolekelas == "aslab") || ($S_rolekelas == "MHAS")){
                if($datanilai['nilai_aslab'] == 0){
                    $nilaiaslab = "";
                }else{
                    $nilaiaslab = $datanilai['nilai_aslab'];
                }

                echo "
                                        <tr>
                                            <th scope='row'>".$rowdataenrol['username']."</th>
                                            <td>".$rowdataenrol['firstname']."</td>
                                            <td>".strtoupper($rowdataenrol['kelas_dosen'])."</td>
                                            <td>
                                                <form method='post'>
                                                    <div class='input-group'>
                                                        <input type='number' step='0.1' class='form-control' placeholder='Input Nilai Akhir' name='nilaiakhir' value='$nilaiaslab'>
                                                        <input type='hidden' class='form-control' name='usernamenilaiakhir' value='".$rowdataenrol['username']."'>
                ";
                echo "
                    <input type='submit' class='btn btn-outline-success' id='button-nilai-akhir' name='submitnilaiakhiraslab' value='Input'>
                ";
                echo "
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                ";
            }else if(($S_rolekelas == "dosen") || ($S_rolekelas == "KLDS")){
                if($datanilai['nilai_dosen'] == 0){
                    $nilaiaslab = "";
                }else{
                    $nilaiaslab = $datanilai['nilai_dosen'];
                }

                echo "
                                        <tr>
                                            <th scope='row'>".$rowdataenrol['username']."</th>
                                            <td>".$rowdataenrol['firstname']."</td>
                                            <td>".strtoupper($rowdataenrol['kelas_dosen'])."</td>
                                            <td>
                                                <form method='post'>
                                                    <div class='input-group'>
                                                        <input type='number' step='0.1' class='form-control' placeholder='Input Nilai Akhir' name='nilaiakhir' value='$nilaiaslab'>
                                                        <input type='hidden' class='form-control' name='usernamenilaiakhir' value='".$rowdataenrol['username']."'>
                ";
                echo "
                    <input type='submit' class='btn btn-outline-success' id='button-nilai-akhir' name='submitnilaiakhirdosen' value='Input'>
                ";
                echo "
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                ";
            }else{
                $nilaiaslab = $datanilai['nilai_all'];

                echo "
                                        <tr>
                                            <th scope='row'>".$rowdataenrol['username']."</th>
                                            <td>".$rowdataenrol['firstname']."</td>
                                            <td>".strtoupper($rowdataenrol['kelas_dosen'])."</td>
                                            <td>".$nilaiaslab."</td>
                                        </tr>
                ";
            }
        }
        echo "
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        ";

    }

    if(isset($_POST['submitlinkpenilaian'])){
        $linkpenilaian = $_POST['inputlinkpenilaianform'];

        if(str_contains($linkpenilaian, "docs.google.com/spreadsheets/")){
            $SQL_inputlinkpenilaian = "UPDATE kelas SET link_penilaian = '$linkpenilaian' WHERE kelas_kode = '$getclassid'";
            $inputlinkpenilaian = mysqli_query($db, $SQL_inputlinkpenilaian);

            if($inputlinkpenilaian){
                $_SESSION['alert'] = $ALERT_linkpenilaianberhasil;
                header('location: '.LINK_kelas_nav($getclassid, "nilai").'');
            }else{
                $_SESSION['alert'] = $ALERT_linkpenilaiangagal;
                header('location: '.LINK_kelas_nav($getclassid, "nilai").'');
            }
        }else{
            $_SESSION['alert'] = $ALERT_linkpenilaiansalah;
            header('location: '.LINK_kelas_nav($getclassid, "nilai").'');
        }
    }

    if(isset($_POST['submitnilaiakhiraslab'])){
        $valuenilai = $_POST['nilaiakhir'];
        $usernamenilai = $_POST['usernamenilaiakhir'];

        if($valuenilai != ""){
            $SQL_inputnilaiaslab = "UPDATE kelas_enrol SET nilai_aslab = '$valuenilai' WHERE kelas_kode = '$getclassid' AND username = '$usernamenilai'";
            $inputnilaiaslab = mysqli_query($db, $SQL_inputnilaiaslab);

            if($inputnilaiaslab){
                $_SESSION['alert'] = $ALERT_nilaiaslabberhasil;
                header('location: '.LINK_kelas_nav($getclassid, "nilai").'');
            }else{
                $_SESSION['alert'] = $ALERT_nilaiaslabgagal;
                header('location: '.LINK_kelas_nav($getclassid, "nilai").'');
            }
        }else{
            $_SESSION['alert'] = $ALERT_nilaiaslabsalah;
            header('location: '.LINK_kelas_nav($getclassid, "nilai").'');
        }
    }

    if(isset($_POST['submitnilaiakhirdosen'])){
        $valuenilai = $_POST['nilaiakhir'];
        $usernamenilai = $_POST['usernamenilaiakhir'];

        if($valuenilai != ""){
            $SQL_inputnilaiaslab = "UPDATE kelas_enrol SET nilai_dosen = '$valuenilai' WHERE kelas_kode = '$getclassid' AND username = '$usernamenilai'";
            $inputnilaiaslab = mysqli_query($db, $SQL_inputnilaiaslab);

            if($inputnilaiaslab){
                $_SESSION['alert'] = $ALERT_nilaiaslabberhasil;
                header('location: '.LINK_kelas_nav($getclassid, "nilai").'');
            }else{
                $_SESSION['alert'] = $ALERT_nilaiaslabgagal;
                header('location: '.LINK_kelas_nav($getclassid, "nilai").'');
            }
        }else{
            $_SESSION['alert'] = $ALERT_nilaiaslabsalah;
            header('location: '.LINK_kelas_nav($getclassid, "nilai").'');
        }
    }


// absensi
    function showabsensi(){
        Global $db, $getclassid, $S_username, $S_rolestatus, $S_rolekelas, $statuskelas;

        $SQL_getabsensikelas = "SELECT * FROM kelas_absen WHERE kelas_kode = '$getclassid'";
        $getabsensikelas = mysqli_query($db, $SQL_getabsensikelas);

        $tagabsen = 0;

        while($resultgetabsensikelas = $getabsensikelas -> fetch_assoc()){
            $statusabsen = $resultgetabsensikelas['status'];
            $weekkelas = $resultgetabsensikelas['week'];
            $batasabsensi = $resultgetabsensikelas['batasabsensi'];

            $tglbatasabsensi = conv_date($batasabsensi);

            $userabsen = "SELECT COUNT(id) AS jumlah FROM kelas_absen_absensi WHERE kelas_kode = '$getclassid' AND week ='$weekkelas' AND username = '$S_username'";
            $userabsen = mysqli_query($db, $userabsen);
            $resultuserabsen = mysqli_fetch_array($userabsen);

            if($resultuserabsen['jumlah'] < 1){
                if($statuskelas != "Non-Aktif"){
                    $presensibutton = "<a href='#' class='btn btn-success' data-toggle='modal' data-target='#modalpresensi".$tagabsen."'>Presensi</a>";
                }else{
                    $presensibutton = "<button type='button' class='btn btn-secondary' disabled>Belum presensi</button>";
                }
            }else if($resultuserabsen['jumlah'] > 1){
                $presensibutton = "<button type='button' class='btn btn-success' disabled>Anda mengisi ".$resultuserabsen['jumlah']." kali presensi </button>";
            }else if(($resultuserabsen['jumlah'] > 0) && ($statusabsen == "closed")){
                $presensibutton = "<button type='button' class='btn btn-secondary' disabled>Sudah presensi</button>";
            }else{
                $presensibutton = "<button type='button' class='btn btn-success' disabled>Sudah presensi</button>";
            }


            if($statusabsen == "notset"){
                echo "
                    <div class='card h-100 my-4' id=''>
                        <div class='card-header'>
                            <div class='row align-items-center text-left'>
                                <div class='col-1 d-none d-lg-block text-center'>
                                    <i class='fas fa-archive fa-2x text-secondary'></i>
                                </div>
                                <div class='col-10 py-0 my-0'>
                                    <div class='row ml-1 my-0 py-0 align-items-center'>
                                        <h4 class='my-0 py-0'><b class=''>Absen pertemuan ".$weekkelas."</b></h4>
                                    </div>
                ";
                if($statuskelas != "Non-Aktif"){
                    if(($S_rolekelas != "dosen") && ($S_rolekelas != "mahasiswa")){
                        echo"
                                            <div class='row ml-1 mt-2 py-0 align-items-center'>
                                                <a href='#' data-toggle='modal' data-target='#modalabseninput".$tagabsen."'><i class='fas fa-edit fa-1x text-warning'></i></a>
                                            </div>
                        ";
                    }
                }
                echo"
                                    <div class='row ml-1 mb-2 py-0 align-items-center'>
                                        <span class='text-xs'>Dibuka hingga : Belum dibuka</span>
                                    </div>
                ";
                if(($S_rolekelas == "mahasiswa") || ($S_rolekelas == "KAMS") || ($S_rolekelas == "KPMS")){
                    echo "
                                        <div class='row ml-1 my-0 align-items-center'>
                                            <button type='button' class='btn btn-secondary' disabled>Belum dibuka</button>
                                        </div>
                        ";
                }
                echo"
                                </div>
                            </div>
                        </div>
                    </div>
                ";
            }else if($statusabsen == "dibuka"){
                echo "
                    <div class='card h-100 my-4' id=''>
                        <div class='card-header'>
                            <div class='row align-items-center text-left'>
                                <div class='col-1 d-none d-lg-block text-center'>
                                    <i class='fas fa-check fa-2x text-success'></i>
                                </div>
                                <div class='col-10 py-0 my-0'>
                                    <div class='row ml-1 my-0 py-0 align-items-center'>
                                        <h4 class='my-0 py-0'><b class=''>Absen pertemuan ".$weekkelas."</b></h4>
                                    </div>
                ";
                
                if(($S_rolekelas != "dosen") && ($S_rolekelas != "mahasiswa")){
                    if($statuskelas != "Non-Aktif"){
                        echo " 
                                <div class='row ml-1 mt-2 align-items-center'>
                                    <span><a href='#' data-toggle='modal' data-target='#modalabseninput".$tagabsen."'><i class='fas fa-edit fa-1x text-warning'></i></a><a href='".LINK_kelas_absensi($getclassid, $weekkelas)."'><i class='pl-3 fas fa-user-check fa-1x text-success'></i></a></span>
                                </div>  
                            ";
                    }else{
                        echo " 
                                <div class='row ml-1 mt-2 align-items-center'>
                                    <span><a href='".LINK_kelas_absensi($getclassid, $weekkelas)."'><i class='fas fa-user-check fa-1x text-success'></i></a></span>
                                </div>  
                            ";
                    }
                }
                if($S_rolekelas == "dosen"){
                    echo " 
                                        <div class='row ml-1 mt-2 align-items-center'>
                                            <span><a href='".LINK_kelas_absensi($getclassid, $weekkelas)."'><i class='fas fa-user-check fa-1x text-success'></i></a></span>
                                        </div>  
                        ";
                }
                echo    "
                                    <div class='row ml-1 mb-2 align-items-center'>
                                        <span class='text-xs'>Dibuka hingga : ".$tglbatasabsensi."</span>
                                    </div>  
                ";
                if(($S_rolekelas == "mahasiswa") || ($S_rolekelas == "KAMS") || ($S_rolekelas == "KPMS")){
                    echo "
                                        <div class='row ml-1 my-0 align-items-center'>
                                            ".$presensibutton."
                                        </div>
                    ";
                }
                echo"
                                </div>
                            </div>
                        </div>
                    </div>
                ";
            }else if(($statusabsen == "closed") && ($resultuserabsen['jumlah'] > 0)){
                echo "
                    <div class='card h-100 my-4' id=''>
                        <div class='card-header'>
                            <div class='row align-items-center text-left'>
                                <div class='col-1 d-none d-lg-block text-center'>
                                    <i class='fas fa-check fa-2x text-success'></i>
                                </div>
                                <div class='col-10 py-0 my-0'>
                                    <div class='row ml-1 my-0 py-0 align-items-center'>
                                        <h4 class='my-0 py-0'><b class=''>Absen pertemuan ".$weekkelas."</b></h4>
                                    </div>
                    ";
                    if(($S_rolekelas != "dosen") && ($S_rolekelas != "mahasiswa")){
                        if($statuskelas != "Non-Aktif"){
                            echo " 
                                <div class='row ml-1 mt-2 py-0 align-items-center'>
                                    <span><a href='#' data-toggle='modal' data-target='#modalabseninput".$tagabsen."'><i class='fas fa-edit fa-1x text-warning'></i></a><a href='".LINK_kelas_absensi($getclassid, $weekkelas)."'><i class='pl-3 fas fa-user-check fa-1x text-success'></i></a></span>
                                </div>  
                            ";
                        }else{
                            echo " 
                                <div class='row ml-1 mt-2 py-0 align-items-center'>
                                    <span><a href='".LINK_kelas_absensi($getclassid, $weekkelas)."'><i class='fas fa-user-check fa-1x text-success'></i></a></span>
                                </div>  
                            ";
                        }
                        
                    }
                    if($S_rolekelas == "dosen"){
                        echo " 
                            <div class='row ml-1 mt-2 py-0 align-items-center'>
                                <span><a href='".LINK_kelas_absensi($getclassid, $weekkelas)."'><i class='fas fa-user-check fa-1x text-success'></i></a></span>
                            </div>  
                        ";
                    }
                    echo "
                                    
                                    <div class='row ml-1 mb-2 align-items-center'>
                                        <span class='text-xs'>Dibuka hingga : Closed</span>
                                    </div> 
                    ";
                    if(($S_rolekelas == "mahasiswa") || ($S_rolekelas == "KAMS") || ($S_rolekelas == "KPMS")){
                        echo "
                                        <div class='row ml-1 my-0 align-items-center'>
                                            ".$presensibutton."
                                        </div>
                        ";
                    }
                    echo "
                                </div>
                            </div>
                        </div>
                    </div>
                ";
            }else if(($statusabsen == "closed") && ($resultuserabsen['jumlah'] < 1)){
                echo "
                    <div class='card h-100 my-4' id=''>
                        <div class='card-header'>
                            <div class='row align-items-center text-left'>
                                <div class='col-1 d-none d-lg-block text-center'>
                                    <i class='fas fa-angry fa-2x text-danger'></i>
                                </div>
                                <div class='col-10 my-0 py-0'>
                                    <div class='row ml-1 my-0 py-0 align-items-center'>
                                        <h4 class='my-0 py-0'><b class=''>Absen pertemuan ".$weekkelas."</b></h4>
                                    </div>  
                ";
                    if(($S_rolekelas != "dosen") && ($S_rolekelas != "mahasiswa")){
                        if($statuskelas != "Non-Aktif"){
                            echo " 
                                <div class='row ml-1 mt-2 py-0 align-items-center'>
                                    <span><a href='#' data-toggle='modal' data-target='#modalabseninput".$tagabsen."'><i class='fas fa-edit fa-1x text-warning'></i></a><a href='".LINK_kelas_absensi($getclassid, $weekkelas)."'><i class='pl-3 fas fa-user-check fa-1x text-success'></i></a></span>
                                </div> 
                            ";
                        }else{
                            echo " 
                                <div class='row ml-1 mt-2 py-0 align-items-center'>
                                    <span><a href='".LINK_kelas_absensi($getclassid, $weekkelas)."'><i class='fas fa-user-check fa-1x text-success'></i></a></span>
                                </div> 
                            ";
                        }
                        
                    }
                    if($S_rolekelas == "dosen"){
                        echo " 
                            <div class='row ml-1 mt-2 py-0 align-items-center'>
                                <span><a href='".LINK_kelas_absensi($getclassid, $weekkelas)."'><i class='fas fa-user-check fa-1x text-success'></i></a></span>
                            </div> 
                        ";
                    }
                    echo "
                                    
                                    <div class='row ml-1 mb-2 py-0 align-items-center'>
                                        <span class='text-xs'>Dibuka hingga : Closed</span>
                                    </div> 
                    ";
                    if(($S_rolekelas == "mahasiswa") || ($S_rolekelas == "KAMS") || ($S_rolekelas == "KPMS")){
                        echo "
                                        <div class='row ml-1 my-0 align-items-center'>
                                            <button type='button' class='btn btn-secondary' disabled>Belum presensi</button>
                                        </div>
                        ";
                    }
                    echo "
                                </div>
                            </div>
                        </div>
                    </div>
                ";
            }

            echo "
                <div class='modal fade' id='modalabseninput".$tagabsen."' tabindex='-1' role='dialog' aria-labelledby='modalabseninputtitle' aria-hidden='true'>
                    <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='modalabseninputtitle'>Edit Presensi ".$weekkelas."</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <form method='post'>
                            <div class='modal-body'>
                                <div class='form-group' id='simple-date4'>
                                    <label for='input-batas-absensi'>Batas presensi <span class='text-danger'>*</span></label>
                                    <input type='hidden' name='minggumodal' value='".$weekkelas."'>
                                    <input type='hidden' name='kelasidmodal' value='".$getclassid."'>
                                    <input type='date' class='input-sm form-control' name='inputbatasabsesnsi' id='input-batas-absensi'>
                                </div>                               
                            </div>
                            <div class='modal-footer'>
                                <input type='submit' class='btn btn-primary' name='editabsensi' value='Edit presensi'>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            ";

            echo "
                <div class='modal fade' id='modalpresensi".$tagabsen."' tabindex='-1' role='dialog' aria-labelledby='modalpresensititle' aria-hidden='true'>
                    <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='modalpresensititle'>Catat Presensi ".$weekkelas."</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                            <div class='form-group' id='simple-date4'>
                                Ingin mencatat presensi pertemuan ".$weekkelas."?
                            </div>                               
                        </div>
                        <div class='modal-footer'>
                            <form method='post'>
                                <input type='hidden' name='minggu' value='".$weekkelas."'>
                                <input type='hidden' name='kelasid' value='".$getclassid."'>
                                <input type='submit' class='btn btn-success' name='inputabsensi' value='Presensi'>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
            ";

            $tagabsen++;
        }
    }

    if(isset($_POST['editabsensi'])){
        $weekmodal = $_POST['minggumodal'];
        $kelasidmodal = $_POST['kelasidmodal'];
        $batasabsensimodal = $_POST['inputbatasabsesnsi'];
        $convbatasabsensimodal = conv_timestamp($batasabsensimodal);

        if($batasabsensimodal != null){
            $SQL_updateabsensi = "UPDATE kelas_absen SET batasabsensi = '$convbatasabsensimodal', status = 'dibuka' WHERE kelas_kode = '$kelasidmodal' AND week = '$weekmodal'";
            $updateabsensi = mysqli_query($db, $SQL_updateabsensi);

            if($updateabsensi){
                $_SESSION['alert'] = $ALERT_absensiberhasildibuka;
                header('location: '.LINK_kelas_nav($getclassid, "absen").'');
            }else{
                $_SESSION['alert'] = $ALERT_absensigagaldibuka;
                header('location: '.LINK_kelas_nav($getclassid, "absen").'');
            }
        }else{
            $_SESSION['alert'] = $ALERT_absensikosong;
            header('location: '.LINK_kelas_nav($getclassid, "absen").'');
        }
    }

    if(isset($_POST['inputabsensi'])){
        $weekinputabsen = $_POST['minggu'];
        $kelasinputabsen = $_POST['kelasid'];

        $SQL_cekabsensi = "SELECT status from kelas_absen WHERE kelas_kode = '$kelasinputabsen' AND week = '$weekinputabsen'";
        $cekabsensi = mysqli_query($db, $SQL_cekabsensi);
        $resultcekabsensi = mysqli_fetch_array($cekabsensi);

        if($resultcekabsensi['status'] == "dibuka"){
            $SQL_inputabsensi = "INSERT INTO kelas_absen_absensi(kelas_kode, week, username) VALUES('$kelasinputabsen', '$weekinputabsen', '$S_username')";
            $inputabsensi = mysqli_query($db, $SQL_inputabsensi);

            if($inputabsensi){
                $_SESSION['alert'] = $ALERT_berhasilabsensi;
                header('location: '.LINK_kelas_nav($getclassid, "absen").'');
            }else{
                $_SESSION['alert'] = $ALERT_gagalabsensi;
                header('location: '.LINK_kelas_nav($getclassid, "absen").'');
            }
        }else{
            $_SESSION['alert'] = $ALERT_absensiditutup;
            header('location: '.LINK_kelas_nav($getclassid, "absen").'');
        }
    }

// formatnilai

    $valuepersentase = getformatnilai($getclassid);
    $aslabp = $valuepersentase['persentase_aslab'];
    $dosenp = $valuepersentase['persentase_dosen'];
    $totalp = $aslabp + $dosenp;

    if(isset($_POST['submitpenilaian'])){
        $penilaianaslab = $_POST['penilaianaslab'];
        $penilaiandosen = $_POST['penilaiandosen'];
        $tpenilaian = $penilaianaslab + $penilaiandosen;
        if($tpenilaian <= 100){
            $SQL_inputformatnilai = "UPDATE kelas_formatnilai SET persentase_aslab = '$penilaianaslab', persentase_dosen = '$penilaiandosen' WHERE kelas_kode = '$getclassid'";
            $inputformatnilai = mysqli_query($db, $SQL_inputformatnilai);
    
            $SQL_insertlog = "INSERT INTO log_activity(username, activity, location, date, time) VALUES('$S_username', 3, '$idcek', '$datenow', '$timenow')";
            $insertlog = mysqli_query($db, $SQL_insertlog);
    
            if($inputformatnilai){
                $_SESSION['alert'] = $ALERT_inputpersentasependahuluanberhasil;
                header('location: '.LINK_kelas_nav($getclassid, "formatnilai").'');
            }else{
                $_SESSION['alert'] = $ALERT_inputpersentasependahuluangagal;
                header('location: '.LINK_kelas_nav($getclassid, "formatnilai").'');
            }
        }else{
            $_SESSION['alert'] = $ALERT_inputpersentasependahuluangagal;
            header('location: '.LINK_kelas_nav($getclassid, "formatnilai").'');
        }
       

    }

    function showlogformatnilai(){
        Global $db, $S_rolestatus, $idcek, $S_username;

        $SQL_getlogformatnilai = "SELECT * FROM log_activity WHERE location = '$idcek' ORDER BY id DESC;";
        $getlogformatnilai = mysqli_query($db, $SQL_getlogformatnilai);

        while($rowgetlogformatnilai = $getlogformatnilai -> fetch_assoc()){
            $namapengguna = getuserbyusername($S_username);
            $aktifitas = log_activitycode($rowgetlogformatnilai['activity']);
            $date = date_id(date ('Y-m-d', $rowgetlogformatnilai['date']));

            echo "
                <tr>
                    <td class='mr-5' width='30%' style='font-size:14px'>[".$rowgetlogformatnilai['username']."] ".$namapengguna['firstname']."</td>
                    <td>".$aktifitas."</td>
                    <td>".$date.", ".$rowgetlogformatnilai['time']."</td>
                </tr>
            ";
        }
    }

// setmodul
    function btnaddmodul(){
        Global $db, $S_rolestatus, $S_username, $getclassid, $getnav, $statuskelas;

        if($statuskelas != "Non-Aktif"){
            $SQL_cekmodul = "SELECT COUNT(id) as jumlah FROM kelas_modul WHERE kelas_kode = '$getclassid'";
            $cek_modul = mysqli_query($db, $SQL_cekmodul);
            $resultcekmodul = mysqli_fetch_array($cek_modul);

            if($resultcekmodul['jumlah'] == 0){
                echo "
                    <button type='button' class='btn btn-secondary mt-3' data-toggle='modal' data-target='#modalsetmodul' id='#modalsetmodul'>Set Modul</button>

                    <div class='modal fade' id='modalsetmodul' tabindex='-1' role='dialog' aria-labelledby='modalsetmodultitle' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered' role='document'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modalsetmodultitle'>Set Modul</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                    <form method='post'>
                                        <div class='form-group'>
                                            <label for='#jmlmodul'>Jumlah Modul (Tidak termasuk TA)</label>
                                            <input id='jmlmodul' name='jmlmodul' type='text' class='form-control'>
                                        </div>
                                        <input id='inputjmlmodul' name='inputjmlmodul' type='submit' class='btn btn-primary col-lg-12' value='Tambah Modul'>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                ";
            }else{
                // echo "
                //     <button type='button' class='btn btn-danger mt-3' data-toggle='modal' data-target='#modaldeletsetmodul' id='#modaldeletsetmodul'>Delete Set Modul</button>

                //     <div class='modal fade' id='modaldeletsetmodul' tabindex='-1' role='dialog' aria-labelledby='modaldeletsetmodultitle' aria-hidden='true'>
                //         <div class='modal-dialog modal-dialog-centered' role='document'>
                //             <div class='modal-content'>
                //                 <div class='modal-header'>
                //                     <h5 class='modal-title' id='modaldeletsetmodultitle'>Delete Set Modul</h5>
                //                     <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                //                         <span aria-hidden='true'>&times;</span>
                //                     </button>
                //                 </div>
                //                 <div class='modal-body'>
                //                     <form method='post'>
                //                         <h6 class='text-danger'><b>Peringatan!</b></h6>    
                //                         <p>Jika anda menghapus set modul pada kelas ini, maka <b class='text-danger'>keseluruhan data modul, tugas, materi, penilaian, jadwal, asisten dan penilaian akan terhapus secara keseluruhan</b>.</p>
                //                         <p><b>Ingin melanjutkan?</b></p>
                //                         <input id='deletesetmodul' name='deletesetmodul' type='submit' class='btn btn-danger col-lg-12' value='Hapus Set Modul'>
                //                     </form>
                //                 </div>
                //             </div>
                //         </div>
                //     </div>
                // ";
            }
        }
    }

    if(isset($_POST['inputjmlmodul'])){
        $jmlmodul = $_POST['jmlmodul'];
        $error = 0;

        if($jmlmodul == 0){
            $_SESSION['alert'] = $ALERT_inputjmlmodulkosong;
            header('location: '.LINK_kelas_nav($getclassid, "setmodul").'');
        }else{
            for($i = 1; $i <= $jmlmodul; $i++){
                $modulname = "modul".$i."";
                $SQL_inputjmlmodul = "INSERT INTO kelas_modul(nama_modul, kelas_kode) VALUES('$modulname', '$getclassid')";
                $inputjmlmodul = mysqli_query($db, $SQL_inputjmlmodul);
                
                if($i == $jmlmodul){
                    $SQL_inputjmlmodul1 = "INSERT INTO kelas_modul(nama_modul, kelas_kode) VALUES('tugasakhir', '$getclassid')";
                    $inputjmlmodul1 = mysqli_query($db, $SQL_inputjmlmodul1);
                }
                if((!$inputjmlmodul) && (!$inputjmlmodul1)){
                    $error++;
                }
            }

            if($error > 0){
                $_SESSION['alert'] = $ALERT_gagalinputjmlmodul;
                header('location: '.LINK_kelas_nav($getclassid, "setmodul").'');
            }else{
                $_SESSION['alert'] = $ALERT_berhasilinputjmlmodul;
                header('location: '.LINK_kelas_nav($getclassid, "setmodul").'');
            }
        }
    }

    if(isset($_POST['deletesetmodul'])){
        
        $SQL_gettugasmodul = "SELECT tugas_kode FROM kelas_tugas WHERE kelas_kode ='$getclassid'";
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

        $SQL_delassmodul = "DELETE FROM kelas_modul_asisten WHERE kelas_kode = '$getclassid'";
        $delassmodul = mysqli_query($db, $SQL_delassmodul);
        if(!$delassmodul){
            $errrr++;
        }

        $SQL_delmodul = "DELETE FROM kelas_modul WHERE kelas_kode = '$getclassid'";
        $delmodul = mysqli_query($db, $SQL_delmodul);
        if(!$delmodul){
            $errrr++;
        }

        if($errrr < 1){
            $_SESSION['alert'] = $ALERT_berhasildeletesetmodul;
            header('location: '.LINK_kelas_nav($getclassid, "setmodul").'');
        }else{
            $_SESSION['alert'] = $ALERT_gagaldeletesetmodul;
            header('location: '.LINK_kelas_nav($getclassid, "setmodul").'');
        }
    }

    function showmodul(){
        Global $db, $S_rolestatus, $getclassid, $getnav, $getuserdata1, $arraygetuserdata, $statuskelas;

        echo "
            <div class='card mt-3'>
                <div class='card-header'>
                    <h5><b>Buat Jadwal</b></h5>
                </div>
                <div class='card-body'>
                   <p>Nama Jadwal</p>
                   <input type='text' class='form-control' placeholder='Contoh : Senin 1'>
                   <div class='row mt-2'>
                        <div class='col-6'>
                            <p>Hari mengajar</p>
                            <select class='form-control' aria-label='Default select example'>
                                <option value=''>Pilih hari</option>
                                <option value='senin'>Senin</option>
                                <option value='selasa'>Selasa</option>
                                <option value='rabu'>Rabu</option>
                                <option value='kamis'>Kamis</option>
                                <option value='jumat'>Jum'at</option>
                            </select>
                        </div>
                        <div class='col-6'>
                            <p>Jam mengajar</p>
                            <div class='form-group' id='simple-date4'>
                                <div class='input-daterange input-group'>
                                    <input type='time' class='input-sm form-control' name='start' />
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text'>sampai</span>
                                    </div>
                                    <input type='time' class='input-sm form-control' name='end' />
                                </div>
                            </div>
                        </div>
                   <div>
                </div>
            </div>

             <div class='card'>
                <div class='card-header'>
                    Quote
                </div>
                <div class='card-body'>
                    <div class='row'>
                        <div class='col-6'>
                            <div class='table-responsive p-3'>
                                <table class='table align-items-center table-flush table-hover'>
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Hari</th>
                                            <th>Jam</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Senin 1</td>
                                            <td>Senin</td>
                                            <td>10:00 - 12:00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class='col-6'>
                            <p></p>
                        </div>
                    </div>
                </div>
            </div>
        ";
    }

    function showjadwal(){
        Global $db, $S_rolestatus, $getclassid, $getnav, $getuserdata1, $arraygetuserdata, $statuskelas;

        $jadwalkelas = getjadwalkelas($getclassid);
        $countjadwal = countjadwalkelas($getclassid);

        if($countjadwal['Jumlah'] == 0){
            echo "
                <tr>
                    <td rowspan='4'>Tidak ada jadwal.</td>
                </tr>
            ";
        }else{
            $tagjadwal = 1;
            while($rowjadwal = $jadwalkelas -> fetch_assoc()){
                echo "
                    <tr>
                        <td>".$rowjadwal['nama_jadwal']."</td>
                        <td>".ucwords($rowjadwal['hari'])."</td>
                        <td>".conv_time($rowjadwal['jam_mulai'])." - ".conv_time($rowjadwal['jam_akhir'])."</td>
                        <td>
                            <a href='#' data-toggle='modal' data-target='#hapusjadwal".$tagjadwal."'><i class='fas fa-trash text-danger'></i></a>

                            <div class='modal fade' id='hapusjadwal".$tagjadwal."' tabindex='-1' role='dialog' aria-labelledby='hapusjadwalLabel".$tagjadwal."' aria-hidden='true'>
                                <div class='modal-dialog' role='document'>
                                    <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='hapusjadwalLabel".$tagjadwal."'>Hapus Jadwal</h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>
                                    <div class='modal-body'>
                                        ingin menghapus jadwal <b>".$rowjadwal['nama_jadwal']."</b> ?
                                    </div>
                                    <div class='modal-footer'>
                                        <form method='post'>
                                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                            <input type='hidden' name='jwdkls' value='".$getclassid."'>
                                            <input type='hidden' name='jdwkode' value='".$rowjadwal['jadwalM_kode']."'>
                                            <input type='submit' class='btn btn-danger' name='hpsjadwall' value='Hapus Jadwal'>
                                        </form>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                ";
                $tagjadwal++;
            }
        }
    }

    if(isset($_POST['hpsjadwall'])){
        $kelasjadwal = $_POST['jwdkls'];
        $kodejadwal = $_POST['jdwkode'];

        $SQL_cekjwdass = "SELECT COUNT(id) AS Jumlah FROM kelas_aslab_mengajar WHERE jadwalM_kode='$kodejadwal'";
        $cekjwdass = mysqli_query($db, $SQL_cekjwdass);
        $arraycekjwdass = mysqli_fetch_array($cekjwdass);

        if($arraycekjwdass['Jumlah'] == 0){
            $SQL_deljwdmengajar = "DELETE FROM kelas_jadwal_mengajar WHERE kelas_kode='$kelasjadwal' AND jadwalM_kode='$kodejadwal'";
            $deljwdmengajar = mysqli_query($db, $SQL_deljwdmengajar);
        }
        
        if($deljwdmengajar){
            $_SESSION['alert'] = $ALERT_hapusjadwalmodulberhasil;
            header('location: '.LINK_kelas_nav($getclassid, "setmodul").'');
        }else{
            $_SESSION['alert'] = $ALERT_hapusjadwalmodulgagal;
            header('location: '.LINK_kelas_nav($getclassid, "setmodul").'');
        }
    }

    if(isset($_POST['inputjadwalkelas'])){
        $namajadwal = $_POST['namajadwal'];
        $harimengajar = $_POST['harimengajar'];
        $jammulai = conv_timestamp_time($_POST['jamstart']);
        $jamakhir = conv_timestamp_time($_POST['jamend']);


        $kodejadwal = make_code("JDWLM", $arraygetmaxidjadwal['MAX']);
        if(($namajadwal != "") && ($harimengajar != "") && ($jammulai != "") && ($jamakhir != "")){
            $SQL_tambahjadwal = "INSERT INTO kelas_jadwal_mengajar(jadwalM_kode, kelas_kode, nama_jadwal, hari, jam_mulai, jam_akhir) VALUES ('$kodejadwal', '$getclassid', '$namajadwal', '$harimengajar', '$jammulai', '$jamakhir')";
            $tambahjadwal = mysqli_query($db, $SQL_tambahjadwal);

            if($tambahjadwal){
                $_SESSION['alert'] = $ALERT_tambahjadwalberhasil;
                header('location: '.LINK_kelas_nav($getclassid, "setmodul").'');
            }else{
                $_SESSION['alert'] = $ALERT_tambahjadwalgagal;
                header('location: '.LINK_kelas_nav($getclassid, "setmodul").'');
            }
        }else{
            $_SESSION['alert'] = $ALERT_tambahjadwalgagal;
            header('location: '.LINK_kelas_nav($getclassid, "setmodul").'');
        }
    }

    function optionjadwal(){
        Global $db, $S_rolestatus, $getclassid, $getnav, $getuserdata1, $arraygetuserdata, $statuskelas;

        $jadwalkelas = getjadwalkelas($getclassid);

        while($rowjadwalkelas = $jadwalkelas -> fetch_assoc()){
            echo "<option value='".$rowjadwalkelas['jadwalM_kode']."'>".ucwords($rowjadwalkelas['nama_jadwal'])."</option>";
        }
    }

    function optionasisten(){
        Global $db, $S_rolestatus, $getclassid, $getnav, $getuserdata1, $arraygetuserdata, $statuskelas;

        $asistenkelas = getasistenkelas($getclassid);

        while($rowasistenkelas = $asistenkelas -> fetch_assoc()){
            echo "<option value='".$rowasistenkelas['username']."'>".$rowasistenkelas['firstname']."</option>";
        }
    }

    

    if(isset($_POST['tambahasistenjadwal'])){
        $jadwalmengajar = $_POST['inputjadwalmengajar'];
        $asistenmengajar = $_POST['asistenmengajar'];

        if(($jadwalmengajar != "") && ($asistenmengajar != "")){
            foreach($asistenmengajar as $asst){
                $SQL_inputasisten = "INSERT INTO kelas_aslab_mengajar(jadwalM_kode, username) VALUES('$jadwalmengajar', '$asst')";
                $inputasisten = mysqli_query($db, $SQL_inputasisten);

                if($inputasisten){
                    $_SESSION['alert'] = $ALERT_tambahasistenmodulberhasil;
                    header('location: '.LINK_kelas_nav($getclassid, "setmodul").'');
                }else{
                    $_SESSION['alert'] = $ALERT_tambahasistenmodulgagal;
                    header('location: '.LINK_kelas_nav($getclassid, "setmodul").'');
                }
            }
        }else{
            $_SESSION['alert'] = $ALERT_tambahasistenmodulgagal;
            header('location: '.LINK_kelas_nav($getclassid, "setmodul").'');
        }
    }

    function showasistenmengajar(){
        Global $db, $S_rolestatus, $getclassid, $getnav, $getuserdata1, $arraygetuserdata, $statuskelas;

        $asistenmengajar = getasistenmengajar($getclassid);
        $tagasisten = 1;
        while($rowasistenmengajar = $asistenmengajar -> fetch_assoc()){
            echo"
                <tr>
                    <td>".$rowasistenmengajar['firstname']."</td>
                    <td>".$rowasistenmengajar['nama_jadwal']."</td>
                    <td>
                        <a href='#' data-toggle='modal' data-target='#hapusasisten".$tagasisten."'><i class='fas fa-trash text-danger'></i></a>

                        <div class='modal fade' id='hapusasisten".$tagasisten."' tabindex='-1' role='dialog' aria-labelledby='hapusasistenLabel".$tagasisten."' aria-hidden='true'>
                            <div class='modal-dialog' role='document'>
                                <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='hapusasistenLabel".$tagasisten."'>Hapus Asisten</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                    ingin menghapus asisten <b>".$rowasistenmengajar['firstname']."</b> ?
                                </div>
                                <div class='modal-footer'>
                                    <form method='post'>
                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                        <input type='hidden' name='unamesst' value='".$rowasistenmengajar['username']."'>
                                        <input type='hidden' name='jdwlsst' value='".$rowasistenmengajar['jadwalM_kode']."'>
                                        <input type='submit' class='btn btn-danger' name='hpsasst' value='Hapus Asisten'>
                                    </form>
                                </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            ";
            $tagasisten++;
        }
    }

    if(isset($_POST['hpsasst'])){
        $usernamww = $_POST['unamesst'];
        $jadwllmww = $_POST['jdwlsst'];

        $SQL_delasstmengajar = "DELETE FROM kelas_aslab_mengajar WHERE username='$usernamww' AND jadwalM_kode='$jadwllmww'";
        $delasstmengajar = mysqli_query($db, $SQL_delasstmengajar);

        if($delasstmengajar){
            $_SESSION['alert'] = $ALERT_hapusasistenmodulberhasil;
            header('location: '.LINK_kelas_nav($getclassid, "setmodul").'');
        }else{
            $_SESSION['alert'] = $ALERT_hapusasistenmodulgagal;
            header('location: '.LINK_kelas_nav($getclassid, "setmodul").'');
        }
    }


// syarat

    function enrolsyarat(){
        Global $getclassid;

        $enrolsyarat = getdatamahasiswaenrol($getclassid);
        $number = 1;
        while($rowenrolsyarat = $enrolsyarat -> fetch_assoc()){
            $genap = $number % 2;
            if($genap == 0){
                $tcolor = "style='background-color:#DCDCDC;'";
            }else{
                $tcolor = ""; 
            }

            $syaratcek = getsyarat($getclassid, $rowenrolsyarat['username']);

            if($syaratcek['Jumlah'] == 0){
                $kwitansiterpenuhi = "";
                $fototerpenuhi = "";
                $modulterpenuhi = "";
            }else{
                $syarattepenuhi = getdetailsyarat($getclassid, $rowenrolsyarat['username']);

                if($syarattepenuhi['pengumpulan_kwitansi']=="Yes"){
                    $kwitansiterpenuhi = "checked";
                }else{
                    $kwitansiterpenuhi = "";
                }

                if($syarattepenuhi['pengumpulan_foto']=="Yes"){
                    $fototerpenuhi = "checked";
                }else{
                    $fototerpenuhi = "";
                }

                if($syarattepenuhi['kepemilikan_modul']=="Yes"){
                    $modulterpenuhi = "checked";
                }else{
                    $modulterpenuhi = "";
                }
            }
            

            echo "
                <tr ".$tcolor.">
                    <td>".$number."</td>
                    <td>".$rowenrolsyarat['username']."</td>
                    <td class='d-none'><input type='hidden' name='usernamesyarat".$number."' value='".$rowenrolsyarat['username']."'></td>
                    <td class='text-left'>".$rowenrolsyarat['firstname']."</td>
                    <td>
                        <div class='custom-control custom-checkbox'>
                          <input type='checkbox' class='custom-control-input' name='inputkwitansi".$number."' id='inputkwitansi".$number."' ".$kwitansiterpenuhi.">
                          <label class='custom-control-label' for='inputkwitansi".$number."'>K</label>
                        </div>
                    </td>
            ";
            echo "
                    <td>
                        <div class='custom-control custom-checkbox'>
                          <input type='checkbox' class='custom-control-input' name='inputfoto".$number."' id='inputfoto".$number."' ".$fototerpenuhi.">
                          <label class='custom-control-label' for='inputfoto".$number."'>F</label>
                        </div>
                    </td>
            ";
            echo "
                    <td>
                        <div class='custom-control custom-checkbox'>
                          <input type='checkbox' class='custom-control-input' name='inputmodul".$number."' id='inputmodul".$number."' ".$modulterpenuhi.">
                          <label class='custom-control-label' for='inputmodul".$number."'>M</label>
                        </div>
                    </td>
                </tr>
            ";
            $number++;
        }
        $newnumber = $number-1;
        echo "
            <tr>
                <td><input type='hidden' name='countcheck' value='".$newnumber."'></td>
                <td colspan='6'><input class='btn btn-success w-50' type='submit' name='inputsyarat' id='inputsyarat' value='Update'></td>
            </tr>
            ";
    }
    
    if(isset($_POST['inputsyarat'])){
        $countcek = $_POST['countcheck'];
        
        for($i = 1; $i <= $countcek; $i++){
            if(!isset($_POST['usernamesyarat'.$i])){
                $_SESSION['alert'] = $ALERT_syaratgagal;
                header('location: '.LINK_kelas_nav($getclassid, "syarat").'');
            }else{
                $usernamiiuu = $_POST['usernamesyarat'.$i];
            }
            if(isset($_POST['inputkwitansi'.$i])){
                $kwitansikirim = "Yes";
            }else{
                $kwitansikirim = "No";
            }
            if(isset($_POST['inputfoto'.$i])){
                $fotokirim = "Yes";
            }else{
                $fotokirim = "No";
            }
            if(isset($_POST['inputmodul'.$i])){
                $modulkirim = "Yes";
            }else{
                $modulkirim = "No";
            }
            
            $syaratcek = getsyarat($getclassid, $usernamiiuu);

            if($syaratcek['Jumlah'] == 0){
                $SQL_inputsyarat = "INSERT INTO kelas_syarat(kelas_kode, username, kepemilikan_modul, pengumpulan_kwitansi, pengumpulan_foto) VALUES ('$getclassid', '$usernamiiuu', '$modulkirim', '$kwitansikirim', '$fotokirim')";
                $inputsyarat = mysqli_query($db, $SQL_inputsyarat);

                if($inputsyarat){
                    $_SESSION['alert'] = $ALERT_syaratberhasil;
                    header('location: '.LINK_kelas_nav($getclassid, "syarat").'');
                }else{
                    $_SESSION['alert'] = $ALERT_syaratgagal;
                    header('location: '.LINK_kelas_nav($getclassid, "syarat").'');
                }
            }else{
                $SQL_updatesyarat = "UPDATE kelas_syarat SET kepemilikan_modul = '$modulkirim', pengumpulan_kwitansi = '$kwitansikirim', pengumpulan_foto = '$fotokirim' WHERE kelas_kode = '$getclassid' AND username = '$usernamiiuu'";
                $updatesyarat = mysqli_query($db, $SQL_updatesyarat);

                if($updatesyarat){
                    $_SESSION['alert'] = $ALERT_syaratberhasil;
                    header('location: '.LINK_kelas_nav($getclassid, "syarat").'');
                }else{
                    $_SESSION['alert'] = $ALERT_syaratgagal;
                    header('location: '.LINK_kelas_nav($getclassid, "syarat").'');
                }
            }
        }
    }