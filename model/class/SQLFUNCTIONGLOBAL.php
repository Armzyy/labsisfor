<?php

    function getuserbyusername($getusername){
        Global $db;

        $stmt = mysqli_prepare($db, "SELECT * FROM user WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $getusername);
        mysqli_stmt_execute($stmt);
        $resultgetuserbyusername = mysqli_fetch_array(mysqli_stmt_get_result($stmt));

        return $resultgetuserbyusername;
    }

    function getuserbyidnumber($getidnumber){
        Global $db;

        $stmt = mysqli_prepare($db, "SELECT * FROM user WHERE idnumber = ?");
        mysqli_stmt_bind_param($stmt, "s", $getidnumber);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }

    function getuserbyrole($getrole1, $getrole2){
        Global $db;

        $stmt = mysqli_prepare($db, "SELECT * FROM user WHERE role = ? OR role = ?");
        mysqli_stmt_bind_param($stmt, "ss", $getrole1, $getrole2);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }

    function getuserbyrolelab($getrole1){
        Global $db;

        $stmt = mysqli_prepare($db, "SELECT * FROM user WHERE role = ?");
        mysqli_stmt_bind_param($stmt, "s", $getrole1);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }

    function getkelasbyid($idkelas){
        Global $db;

        $stmt = mysqli_prepare($db, "SELECT a.*, b.*, c.*, d.* FROM kelas a, praktikum b, periode c, laboratorium d WHERE a.praktikum_kode = b.praktikum_kode AND a.periode_kode = c.periode_kode AND a.laboratorium_kode = d.laboratorium_kode AND kelas_kode = ?");
        mysqli_stmt_bind_param($stmt, "s", $idkelas);
        mysqli_stmt_execute($stmt);
        return mysqli_fetch_array(mysqli_stmt_get_result($stmt));
    }

    function getsimplekelasbyid($idkelas){
        Global $db;

        $stmt = mysqli_prepare($db, "SELECT b.fullname, b.shortname, a.jadwal, c.periode_kode, d.laboratorium_kode FROM kelas a, praktikum b, periode c, laboratorium d WHERE a.praktikum_kode = b.praktikum_kode AND a.periode_kode = c.periode_kode AND a.laboratorium_kode = d.laboratorium_kode AND kelas_kode = ?");
        mysqli_stmt_bind_param($stmt, "s", $idkelas);
        mysqli_stmt_execute($stmt);
        return mysqli_fetch_array(mysqli_stmt_get_result($stmt));
    }

    function getkelasstatusbyid($idkelas){
        Global $db;

        $stmt = mysqli_prepare($db, "SELECT status FROM kelas a, praktikum b, periode c, laboratorium d WHERE a.praktikum_kode = b.praktikum_kode AND a.periode_kode = c.periode_kode AND a.laboratorium_kode = d.laboratorium_kode AND kelas_kode = ?");
        mysqli_stmt_bind_param($stmt, "s", $idkelas);
        mysqli_stmt_execute($stmt);
        return mysqli_fetch_array(mysqli_stmt_get_result($stmt));
    }

    function getkelasbyperiodeid($periodeid){
        Global $db;

        $stmt = mysqli_prepare($db, "SELECT * FROM kelas WHERE periode_kode = ?");
        mysqli_stmt_bind_param($stmt, "s", $periodeid);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }

    function jumlahmahasiswakelas($idkelas){
        Global $db;

        $stmt = mysqli_prepare($db, "SELECT COUNT(id) AS jumlah FROM kelas_enrol WHERE kelas_kode = ?");
        mysqli_stmt_bind_param($stmt, "s", $idkelas);
        mysqli_stmt_execute($stmt);
        return mysqli_fetch_array(mysqli_stmt_get_result($stmt));
    }

    function getperiodebyid($idperiode){
        Global $db;

        $stmt = mysqli_prepare($db, "SELECT * FROM periode WHERE periode_kode=?");
        mysqli_stmt_bind_param($stmt, "s", $idperiode);
        mysqli_stmt_execute($stmt);
        return mysqli_fetch_array(mysqli_stmt_get_result($stmt));
    }

    function getlaboratoriumbyid($idlaboratorium){
        Global $db;

        $stmt = mysqli_prepare($db, "SELECT * FROM laboratorium WHERE laboratorium_kode=?");
        mysqli_stmt_bind_param($stmt, "s", $idlaboratorium);
        mysqli_stmt_execute($stmt);
        return mysqli_fetch_array(mysqli_stmt_get_result($stmt));
    }

    function getkalabbyidnumber($idkalab){
        Global $db;

        $stmt = mysqli_prepare($db, "SELECT COUNT(id) AS jumlah FROM laboratorium WHERE kepala_laboratorium=?");
        mysqli_stmt_bind_param($stmt, "s", $idkalab);
        mysqli_stmt_execute($stmt);
        return mysqli_fetch_array(mysqli_stmt_get_result($stmt));
    }

    function getlaboratoriumbyidkalab($idkalabb){
        Global $db;

        $stmt = mysqli_prepare($db, "SELECT nama_laboratorium, laboratorium_kode FROM laboratorium WHERE kepala_laboratorium = ?");
        mysqli_stmt_bind_param($stmt, "s", $idkalabb);
        mysqli_stmt_execute($stmt);
        return mysqli_fetch_array(mysqli_stmt_get_result($stmt));
    }

    function getkoorlabbyidnumber($idkoorlab){
        Global $db;

        $stmt = mysqli_prepare($db, "SELECT COUNT(id) AS jumlah FROM laboratorium WHERE koor_aslab=?");
        mysqli_stmt_bind_param($stmt, "s", $idkoorlab);
        mysqli_stmt_execute($stmt);
        return mysqli_fetch_array(mysqli_stmt_get_result($stmt));
    }

    function getjumlahmahasiswaperiode($idperiode){
        Global $db;

        $stmt = mysqli_prepare($db, "SELECT kelas_kode AS kelas FROM kelas WHERE periode_kode = ?");
        mysqli_stmt_bind_param($stmt, "s", $idperiode);
        mysqli_stmt_execute($stmt);
        $selectkelasperiode = mysqli_stmt_get_result($stmt);

        $jumlah = 0;

        while($resultselectkelasperiode = $selectkelasperiode -> fetch_assoc()){
            $kelas_kode = $resultselectkelasperiode['kelas'];
            $stmt_j = mysqli_prepare($db, "SELECT COUNT(username) as jumlah FROM kelas_enrol WHERE kelas_kode = ?");
            mysqli_stmt_bind_param($stmt_j, "s", $kelas_kode);
            mysqli_stmt_execute($stmt_j);
            $selectkelasjumlah = mysqli_stmt_get_result($stmt_j);
            $resultselectkelasjumlah = mysqli_fetch_array($selectkelasjumlah);

            $jumlah_sementara = $resultselectkelasjumlah['jumlah'];
            $jumlah = $jumlah + $jumlah_sementara;
        }

        echo $jumlah;
    }

    function getjumlahkelasperiode($idperiode){
        Global $db;

        $stmt = mysqli_prepare($db, "SELECT COUNT(kelas_kode) AS jumlah FROM kelas WHERE periode_kode = ?");
        mysqli_stmt_bind_param($stmt, "s", $idperiode);
        mysqli_stmt_execute($stmt);
        $resultcountkelasperiode = mysqli_fetch_array(mysqli_stmt_get_result($stmt));

        echo $resultcountkelasperiode['jumlah'];
    }

    function getjumlahkelas($idkelas){
        Global $db;

        $stmt = mysqli_prepare($db, "SELECT COUNT(kelas_kode) AS jumlah FROM kelas_enrol WHERE kelas_kode = ? AND role_kelas = 'mahasiswa'");
        mysqli_stmt_bind_param($stmt, "s", $idkelas);
        mysqli_stmt_execute($stmt);
        return mysqli_fetch_array(mysqli_stmt_get_result($stmt));
    }

    function gettugasbykode($tugaskode){
        Global $db;

        $stmt = mysqli_prepare($db, "SELECT * FROM kelas_tugas WHERE tugas_kode = ?");
        mysqli_stmt_bind_param($stmt, "s", $tugaskode);
        mysqli_stmt_execute($stmt);
        return mysqli_fetch_array(mysqli_stmt_get_result($stmt));
    }

    function getnilaimodul($mdl, $id, $userr){
        Global $db;

        $stmt = mysqli_prepare($db, "SELECT b.nilai, b.nilaipendahuluan, b.nilaikomunikasi FROM kelas_tugas a, kelas_tugas_pengumpulan b WHERE a.modul=? AND a.kelas_kode=? AND b.tugas_kode = a.tugas_kode AND b.username = ?");
        mysqli_stmt_bind_param($stmt, "sss", $mdl, $id, $userr);
        mysqli_stmt_execute($stmt);
        return mysqli_fetch_array(mysqli_stmt_get_result($stmt));
    }

    function getpembuatkelas($iddd){
        Global $db;

        $stmt = mysqli_prepare($db, "SELECT * FROM kelas_enrol WHERE kelas_kode = ? AND pembuat_kelas = 'yes'");
        mysqli_stmt_bind_param($stmt, "s", $iddd);
        mysqli_stmt_execute($stmt);
        return mysqli_fetch_array(mysqli_stmt_get_result($stmt));
    }

    function getperiodeexist($id){
        Global $db;

        $stmt = mysqli_prepare($db, "SELECT COUNT(id) AS Jumlah FROM periode WHERE periode_kode = ?");
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        return mysqli_fetch_array(mysqli_stmt_get_result($stmt));
    }

    function getlaboratoriumexist($id){
        Global $db;

        $stmt = mysqli_prepare($db, "SELECT COUNT(id) AS Jumlah FROM laboratorium WHERE laboratorium_kode = ?");
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        return mysqli_fetch_array(mysqli_stmt_get_result($stmt));
    }

    function getkelasexist($id){
        Global $db;

        $stmt = mysqli_prepare($db, "SELECT COUNT(id) AS Jumlah FROM kelas WHERE kelas_kode = ?");
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        return mysqli_fetch_array(mysqli_stmt_get_result($stmt));
    }

    function getuserexist($id){
        Global $db;

        $stmt = mysqli_prepare($db, "SELECT COUNT(id) AS Jumlah FROM user WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        return mysqli_fetch_array(mysqli_stmt_get_result($stmt));
    }

    function ceknilai($usernameee, $kelasid){
        Global $db;
        
    }

    function getallkelasbylab($idlab){
        Global $db;
        $SQL_getkelasall = "SELECT DISTINCT b.shortname FROM kelas a, praktikum b, laboratorium c WHERE a.praktikum_kode = b.praktikum_kode AND a.laboratorium_kode = c.laboratorium_kode AND c.laboratorium_kode ='$idlab' AND a.status='Aktif'";
        $getkelasall = mysqli_query($db, $SQL_getkelasall);

        return $getkelasall;
    }

    function getallkelasbylabnonaktif($idlab){
        Global $db;
        $SQL_getkelasall = "SELECT DISTINCT b.shortname FROM kelas a, praktikum b, laboratorium c WHERE a.praktikum_kode = b.praktikum_kode AND a.laboratorium_kode = c.laboratorium_kode AND c.laboratorium_kode ='$idlab' AND a.status='Non-Aktif'";
        $getkelasall = mysqli_query($db, $SQL_getkelasall);

        return $getkelasall;
    }

    function getallkelas(){
        Global $db;
        $SQL_getallkelas = "SELECT DISTINCT b.shortname FROM kelas a, praktikum b WHERE a.praktikum_kode = b.praktikum_kode AND a.status='Aktif'";
        $getallkelas = mysqli_query($db, $SQL_getallkelas);

        return $getallkelas;
    }

    function getallkelasenrol($usernamiii){
        Global $db;
        $SQL_getallkelasenrol = "SELECT DISTINCT c.shortname FROM kelas_enrol a, kelas b, praktikum c WHERE a.username = '$usernamiii' AND a.kelas_kode = b.kelas_kode AND b.praktikum_kode = c.praktikum_kode";
        $getallkelasenrol = mysqli_query($db, $SQL_getallkelasenrol);

        return $getallkelasenrol;
    }


    function getallkelasnonaktif(){
        Global $db;
        $SQL_getallkelas = "SELECT DISTINCT b.shortname FROM kelas a, praktikum b WHERE a.praktikum_kode = b.praktikum_kode AND a.status='Non-Aktif'";
        $getallkelas = mysqli_query($db, $SQL_getallkelas);

        return $getallkelas;
    }  

    function getallkelasnav(){
        Global $db;
        $SQL_getallkelasnav = "SELECT DISTINCT b.shortname FROM kelas a, praktikum b WHERE a.praktikum_kode = b.praktikum_kode";
        $getallkelasnav = mysqli_query($db, $SQL_getallkelasnav);

        return $getallkelasnav;
    }  

    function getallkelasbypraktikumkode($praktikumkode){
        Global $db;

        $SQL_getallkelasbypraktikumkode = "SELECT * FROM kelas WHERE praktikum_kode = '$praktikumkode'";
        $getallkelasbypraktikumkode = mysqli_query($db, $SQL_getallkelasbypraktikumkode);
        
        return $getallkelasbypraktikumkode;
    }

    function getkelasallbyshortname($shortname, $usernameuu){
        Global $db;
        $SQL_getkelasallbyshortname = "SELECT b.fullname, b.shortname, a.*, c.role_kelas FROM kelas a, praktikum b, kelas_enrol c WHERE a.praktikum_kode = b.praktikum_kode AND a.kelas_kode = c.kelas_kode AND c.username = '$usernameuu' AND b.shortname = '$shortname' AND a.status='Aktif'";
        $getkelasallbyshortname = mysqli_query($db, $SQL_getkelasallbyshortname);
        
        return $getkelasallbyshortname;
    }

    function getkelasallbyshortnamenonaktif($shortname){
        Global $db;
        $SQL_getkelasallbyshortname = "SELECT b.fullname, b.shortname, a.* FROM kelas a, praktikum b WHERE a.praktikum_kode = b.praktikum_kode AND b.shortname = '$shortname' AND a.status='Non-Aktif'";
        $getkelasallbyshortname = mysqli_query($db, $SQL_getkelasallbyshortname);
        
        return $getkelasallbyshortname;
    }

    function getalllaboratorium($usernameeee){
        Global $db;
        $SQL_getalllaboratorium = "SELECT nama_laboratorium, laboratorium_kode FROM laboratorium WHERE koor_aslab = '$usernameeee'";
        $getalllaboratorium = mysqli_query($db, $SQL_getalllaboratorium);
        
        return $getalllaboratorium;
    }

    function getalllabadmin(){
        Global $db;
        $SQL_getalllabadmin = "SELECT nama_laboratorium, laboratorium_kode FROM laboratorium";
        $getalllabadmin = mysqli_query($db, $SQL_getalllabadmin);

        return $getalllabadmin;
    }

    function getpraktikumbyshortname($shortname){
        Global $db;
        $SQL_getpraktikumbyshortname = "SELECT * FROM praktikum WHERE shortname = '$shortname'";
        $getpraktikumbyshortname = mysqli_query($db, $SQL_getpraktikumbyshortname);

        return $getpraktikumbyshortname;
    }

    function getpraktikumbyid($idprak){
        Global $db;
        $SQL_getpraktikumbyid = "SELECT * FROM praktikum WHERE praktikum_kode = '$idprak'";
        $getpraktikumbyid = mysqli_query($db, $SQL_getpraktikumbyid);
        $resultgetpraktikumbyid = mysqli_fetch_array($getpraktikumbyid);

        return $resultgetpraktikumbyid;
    }

    function getminkelas(){
        Global $db;
        $SQL_getminkelas = "SELECT b.shortname, MIN(a.id) FROM kelas a, praktikum b WHERE a.praktikum_kode = b.praktikum_kode";
        $getminkelas = mysqli_query($db, $SQL_getminkelas);
        $resultgetminkelas = mysqli_fetch_array($getminkelas);

        return $resultgetminkelas['shortname'];
    }

    function getuserrolekelas($kelaskode, $usernameoo){
        Global $db;
        $SQL_getuserrolekelas = "SELECT role_kelas FROM kelas_enrol WHERE kelas_kode = '$kelaskode' AND username = '$usernameoo'";
        $getuserenrollkelas = mysqli_query($db, $SQL_getuserrolekelas);
        $resultgetuserenrollkelas = mysqli_fetch_array($getuserenrollkelas);

        return $resultgetuserenrollkelas['role_kelas'];
    }

    function getuserenrolshortnameD($usernameiopp){
        Global $db;
        $SQL_getuserenrolshortnameD = "SELECT DISTINCT COUNT(c.id) AS Jumlah, c.shortname FROM kelas_enrol a, kelas b, praktikum c WHERE a.username = '$usernameiopp' AND a.kelas_kode = b.kelas_kode AND b.praktikum_kode = c.praktikum_kode AND b.status = 'Aktif'";
        $getuserenrolshortnameD = mysqli_query($db, $SQL_getuserenrolshortnameD);
        
        return $getuserenrolshortnameD;
    }

    function getlinkenrolkelasbyshortname($usernamepp, $shortname){
        Global $db;
        $SQL_getlinkenrolkelasbyshortname = "SELECT c.shortname, d.nama_periode, b.jadwal, b.kelas_kode FROM kelas_enrol a, kelas b, praktikum c, periode d WHERE username = '$usernamepp' AND a.kelas_kode = b.kelas_kode AND b.praktikum_kode = c.praktikum_kode AND c.shortname = '$shortname' AND b.periode_kode = d.periode_kode";
        $getlinkenrolkelasbyshortname = mysqli_query($db, $SQL_getlinkenrolkelasbyshortname);

        return $getlinkenrolkelasbyshortname;
    }

    function getpembuatkelasbyusername($klsid, $usernamello){
        Global $db;
        $SQL_getpembuatkelasbyusername = "SELECT pembuat_kelas FROM kelas_enrol WHERE kelas_kode = '$klsid' AND username = '$usernamello'";
        $getpembuatkelasbyusername = mysqli_query($db, $SQL_getpembuatkelasbyusername);
        $resultgetpembuatkelasbyusername = mysqli_fetch_array($getpembuatkelasbyusername);

        return $resultgetpembuatkelasbyusername;
    }

    function getrolekelas($kelasid, $usernameooo){
        Global $db;
        $SQL_getrolekelas = "SELECT role_kelas FROM kelas_enrol WHERE kelas_kode = '$kelasid' AND username = '$usernameooo'";
        $getrolekelas = mysqli_query($db, $SQL_getrolekelas);
        $resultgetrolekelas = mysqli_fetch_array($getrolekelas);

        return $resultgetrolekelas;
    }

    function getdatamahasiswaenrol($klasid){
        Global $db;
        $SQL_getdataenrol = "SELECT a.*, b.* FROM kelas_enrol a, user b WHERE a.kelas_kode = '$klasid' AND a.role_kelas IN ('mahasiswa', 'KAMS', 'KPMS', 'MHAS') AND a.username = b.username ORDER BY a.username ASC";
        $getdatamahasiswaenrol = mysqli_query($db, $SQL_getdataenrol);
        
        return $getdatamahasiswaenrol;
    }

    function getdatamahasiswaenrolbykelasdosen($klasid, $kldsn){
        Global $db;
        $SQL_getdataenrol = "SELECT a.*, b.* FROM kelas_enrol a, user b WHERE a.kelas_kode = '$klasid' AND a.role_kelas IN ('mahasiswa', 'KAMS', 'KPMS') AND a.username = b.username AND a.kelas_dosen = '$kldsn' ORDER BY a.username ASC";
        $getdatamahasiswaenrol = mysqli_query($db, $SQL_getdataenrol);
        
        return $getdatamahasiswaenrol;
    }


    function countdatamahasiswaenrol($klasid){
        Global $db;
        $SQL_countdatamahasiswaenrol = "SELECT COUNT(id) AS Jumlah FROM kelas_enrol WHERE kelas_kode = '$klasid' AND role_kelas IN ('mahasiswa', 'KAMS', 'KPMS')";
        $countdatamahasiswaenrol = mysqli_query($db, $SQL_countdatamahasiswaenrol);
        $resultcountdatamahasiswaenrol = mysqli_fetch_array($countdatamahasiswaenrol);

        return $resultcountdatamahasiswaenrol;
    }

    function getnilaidataenrol($klasid, $usernyie){
        Global $db;
        $SQL_getnilaidataenrol = "SELECT nilai_aslab, nilai_dosen, nilai_all FROM kelas_enrol WHERE kelas_kode = '$klasid' AND username = '$usernyie'";
        $getnilaidataenrol = mysqli_query($db, $SQL_getnilaidataenrol);
        $resultgetnilaidataenrol = mysqli_fetch_array($getnilaidataenrol);

        return $resultgetnilaidataenrol;
    }

    function getnilaidataenrolbykelasdosen($klasid, $usernyie, $klsd){
        Global $db;
        $SQL_getnilaidataenrolbykelasdosen = "SELECT nilai_aslab, nilai_dosen, nilai_all FROM kelas_enrol WHERE kelas_kode = '$klasid' AND username = '$usernyie' AND kelas_dosen = '$klsd'";
        $getnilaidataenrolbykelasdosen = mysqli_query($db, $SQL_getnilaidataenrolbykelasdosen);
        $resultgetnilaidataenrolbykelasdosen = mysqli_fetch_array($getnilaidataenrolbykelasdosen);

        return $resultgetnilaidataenrolbykelasdosen;
    }

    function getenrolbyrole($klsid, $rolees){
        Global $db;
        $SQL_getenrolbyrole = "SELECT a.role_kelas, a.kelas_dosen, b.* FROM kelas_enrol a, user b WHERE a.username = b.username AND kelas_kode = '$klsid' AND role_kelas = '$rolees' ORDER BY a.username ASC";
        $getenrolbyrole = mysqli_query($db, $SQL_getenrolbyrole);

        return $getenrolbyrole;
    }

    function cekjadwalkelas($klsid){
        Global $db;
        $SQL_cekjadwalkelas = "SELECT jadwal FROM kelas WHERE kelas_kode = '$klsid'";
        $cekjadwalkelas = mysqli_query($db, $SQL_cekjadwalkelas);
        $resultcekjadwalkelas = mysqli_fetch_array($cekjadwalkelas);

        return $resultcekjadwalkelas;
    }

    function getuserKLDSrole($klsid){
        Global $db;
        $SQL_getuserKLDSrole = "SELECT a.role_kelas, a.kelas_dosen, b.* FROM kelas_enrol a, user b WHERE a.username = b.username AND kelas_kode = '$klsid' AND role_kelas = 'KLDS' ORDER BY a.username ASC";
        $getuserKLDSrole = mysqli_query($db, $SQL_getuserKLDSrole);

        return $getuserKLDSrole;
    }

    function getuserKAMSrole($klsid){
        Global $db;
        $SQL_getuserKAMSrole = "SELECT a.role_kelas, a.kelas_dosen, b.* FROM kelas_enrol a, user b WHERE a.username = b.username AND kelas_kode = '$klsid' AND role_kelas = 'KAMS' ORDER BY a.username ASC";
        $getuserKAMSrole = mysqli_query($db, $SQL_getuserKAMSrole);

        return $getuserKAMSrole;
    }

    function getuserMHASrole($klsid){
        Global $db;
        $SQL_getuserKAMSrole = "SELECT a.role_kelas, a.kelas_dosen, b.* FROM kelas_enrol a, user b WHERE a.username = b.username AND kelas_kode = '$klsid' AND role_kelas = 'MHAS' ORDER BY a.username ASC";
        $getuserKAMSrole = mysqli_query($db, $SQL_getuserKAMSrole);

        return $getuserKAMSrole;
    }

    function getuserKPMSrole($klsid){
        Global $db;
        $SQL_getuserKPMSrole = "SELECT a.role_kelas, a.kelas_dosen, b.* FROM kelas_enrol a, user b WHERE a.username = b.username AND kelas_kode = '$klsid' AND role_kelas = 'KPMS' ORDER BY a.username ASC";
        $getuserKPMSrole = mysqli_query($db, $SQL_getuserKPMSrole);

        return $getuserKPMSrole;
    }

    function getkelasdosen($klsid){
        Global $db;
        $SQL_getkelasdosen = "SELECT DISTINCT kelas_dosen FROM kelas_enrol WHERE kelas_kode='$klsid' AND kelas_dosen IS NOT NULL ORDER BY 
        CASE 
            WHEN kelas_dosen = 'p' THEN 1 
            WHEN kelas_dosen = 'p1' THEN 2 
            ELSE 3 
        END";
        $getkelasdosen = mysqli_query($db, $SQL_getkelasdosen);

        return $getkelasdosen;
    }

    function getkelasdosenbyusername($klsid, $useradad){
        Global $db;
        $SQL_getkelasdosenbyusername = "SELECT kelas_dosen, role_kelas FROM kelas_enrol WHERE kelas_kode = '$klsid' AND username = '$useradad'";
        $getkelasdosenbyusername = mysqli_query($db, $SQL_getkelasdosenbyusername);
        $resultgetkelasdosenbyusername = mysqli_fetch_array($getkelasdosenbyusername);

        return $resultgetkelasdosenbyusername;
    }

    function getmahasiswabykelasdosen($klsid, $rolem, $klsd){
        Global $db;
        $SQL_getmahasiswabykelasdosen = "SELECT a.role_kelas, a.kelas_dosen, b.* FROM kelas_enrol a, user b WHERE a.username = b.username AND kelas_kode = '$klsid' AND role_kelas = '$rolem' AND kelas_dosen = '$klsd' ORDER BY a.username ASC";
        $getmahasiswabykelasdosen = mysqli_query($db, $SQL_getmahasiswabykelasdosen);

        return $getmahasiswabykelasdosen;
    }

    function getpengumumanbykelasdosen($klsdosen, $klsid){
        Global $db;
        $SQL_getpengumumanbykelasdosen = "SELECT * FROM kelas_forum WHERE privasi IN ('publik', '$klsdosen') AND kelas_kode = '$klsid' ORDER BY id DESC";
        $getpengumumanbykelasdosen = mysqli_query($db, $SQL_getpengumumanbykelasdosen);

        return $getpengumumanbykelasdosen;
    }

    function getkooraslab($klsid){
        Global $db;
        $SQL_getkooraslab = "SELECT username FROM kelas_enrol WHERE kelas_kode = '$klsid' AND role_kelas = 'kooraslab'";
        $getkooraslab = mysqli_query($db, $SQL_getkooraslab);
        $resultgetkooraslab = mysqli_fetch_array($getkooraslab);

        return $resultgetkooraslab;
    }

    function getkoorpraktikum($klsid){
        Global $db;
        $SQL_getkoorpraktikum = "SELECT username FROM kelas_enrol WHERE kelas_kode = '$klsid' AND role_kelas = 'koorpraktikum'";
        $getkoorpraktikum = mysqli_query($db, $SQL_getkoorpraktikum);
        $resultgetkoorpraktikum = mysqli_fetch_array($getkoorpraktikum);

        return $resultgetkoorpraktikum;
    }

    function getdatabsen($klsid, $week){
        Global $db;
        $SQL_getdatabsen = "SELECT * FROM kelas_absen WHERE kelas_kode = '$klsid' AND week = '$week'";
        $getdatabsen = mysqli_query($db, $SQL_getdatabsen);
        $resultgetdatabsen = mysqli_fetch_array($getdatabsen);

        return $resultgetdatabsen;
    }

    function cekabsensibyusername($klsid, $week, $usernamhyy){
        Global $db;
        $SQL_cekabsensibyusername = "SELECT COUNT(id) AS Jumlah FROM kelas_absen_absensi WHERE kelas_kode = '$klsid' AND week = '$week' AND username = '$usernamhyy'";
        $cekabsensibyusername = mysqli_query($db, $SQL_cekabsensibyusername);
        $resultcekabsensibyusername = mysqli_fetch_array($cekabsensibyusername);

        return $resultcekabsensibyusername;
    }

    function cekstatusabsen($klsid, $week){
        Global $db;
        $SQL_cekstatusabsen = "SELECT status FROM kelas_absen WHERE kelas_kode = '$klsid' AND week = '$week'";
        $cekstatusabsen = mysqli_query($db, $SQL_cekstatusabsen);
        $resultcekstatusabsen = mysqli_fetch_array($cekstatusabsen);

        return $resultcekstatusabsen;
    }

    function getdatadosenkelas($klsid, $usernameiioo){
        Global $db;
        $SQL_getdatadosenkelas = "SELECT kelas_dosen FROM kelas_enrol WHERE kelas_kode = '$klsid' AND role_kelas IN ('dosen', 'KLDS') AND username = '$usernameiioo'";
        $getdatadosenkelas = mysqli_query($db, $SQL_getdatadosenkelas);
        $resultgetdatadosenkelas = mysqli_fetch_array($getdatadosenkelas);

        return $resultgetdatadosenkelas;
    }

    function getformatnilai($kldid){
        Global $db;
        $SQL_getformatnilai = "SELECT persentase_aslab, persentase_dosen FROM kelas_formatnilai WHERE kelas_kode = '$kldid'";
        $getformatnilai = mysqli_query($db, $SQL_getformatnilai);
        $resultgetformatnilai = mysqli_fetch_array($getformatnilai);

        return $resultgetformatnilai;
    }

    function getkelasdatabylabandperiode($labid, $perid){
        Global $db;
        $SQL_getkelasdatabylabandperiode = "SELECT a.*, b.shortname, b.fullname FROM kelas a, praktikum b WHERE a.laboratorium_kode = '$labid' AND a.periode_kode = '$perid' AND a.praktikum_kode = b.praktikum_kode GROUP BY a.id ASC";
        $getkelasdatabylabandperiode = mysqli_query($db, $SQL_getkelasdatabylabandperiode);

        return $getkelasdatabylabandperiode;
    }

    function getkodekelasbylabandperiode($lbrid, $prdid){
        Global $db;
        $SQL_getkodekelasbylabandperiode = "SELECT kelas_kode FROM kelas WHERE laboratorium_kode = '$lbrid' AND periode_kode = '$prdid' GROUP BY kelas_kode ASC";
        $getkodekelasbylabandperiode = mysqli_query($db, $SQL_getkodekelasbylabandperiode);

        return $getkodekelasbylabandperiode;
    }

    function getkelasdoseninkelaskode($klsid){
        Global $db;

        $SQL_getkelasdoseninkelaskode = "SELECT DISTINCT kelas_dosen FROM kelas_enrol WHERE kelas_kode = '$klsid' AND kelas_dosen IS NOT NULL GROUP BY 
            CASE
                WHEN kelas_dosen = 'p' THEN 1
                WHEN kelas_dosen = 'p1' THEN 2
                WHEN kelas_dosen = 'v' THEN 3
            END
        ";
        $getkelasdoseninkelaskode = mysqli_query($db, $SQL_getkelasdoseninkelaskode);

        return $getkelasdoseninkelaskode;
    }

    function getdosenonkelasdosen($klsid, $klsdosid){
        Global $db;
        $SQL_getdosenonkelasdosen = "SELECT a.username, b.firstname FROM kelas_enrol a, user b WHERE a.username = b.username AND a.kelas_kode = '$klsid' AND a.kelas_dosen = '$klsdosid' AND a.role_kelas IN('dosen', 'KLDS')";
        $getdosenonkelasdosen = mysqli_query($db, $SQL_getdosenonkelasdosen);
        $returngetdosenonkelasdosen = mysqli_fetch_array($getdosenonkelasdosen);

        return $returngetdosenonkelasdosen;
    }

    function getnamadosenbykelasidandkelasdosen($klsid, $klsdosid){
        Global $db;
        $SQL_getnamadosenbykelasidandkelasdosen = "SELECT b.firstname FROM kelas_enrol a, user b WHERE a.username = b.username AND a.kelas_kode = '$klsid' AND a.kelas_dosen = '$klsdosid' AND a.role_kelas IN ('dosen', 'KLDS')";
        $getnamadosenbykelasidandkelasdosen = mysqli_query($db, $SQL_getnamadosenbykelasidandkelasdosen);
        $resultgetnamadosenbykelasidandkelasdosen = mysqli_fetch_array($getnamadosenbykelasidandkelasdosen);

        return $resultgetnamadosenbykelasidandkelasdosen['firstname'];
    }
    // SELECT * FROM `kelas_enrol` WHERE kelas_kode = 'KLS00001' AND role_kelas IN('mahasiswa', 'KPMS', 'KAMS') AND kelas_dosen = 'p' ORDER BY `username` ASC

    function downloadnilaikelas($klsid, $kelas_dosen){
        Global $db;

        $SQL_downloadnilaikelas = "SELECT a.username, b.firstname, a.kelas_dosen, a.nilai_all, a.kelas_kode FROM kelas_enrol a, user b WHERE a.username = b.username AND a.kelas_kode = '$klsid' AND a.role_kelas IN('mahasiswa', 'KPMS', 'KAMS') AND kelas_dosen = '$kelas_dosen' ORDER BY
        CASE
            WHEN a.kelas_dosen = 'p' THEN 1
            WHEN a.kelas_dosen = 'p1' THEN 2
            WHEN a.kelas_dosen = 'pv' THEN 3
        END";
        $downloadnilaikelas = mysqli_query($db, $SQL_downloadnilaikelas);

        return $downloadnilaikelas;
    }

    function getsyarat($klsid, $usernameiuu){
        Global $db;
        $SQL_getsyarat = "SELECT COUNT(id) AS Jumlah FROM kelas_syarat WHERE kelas_kode = '$klsid' AND username = '$usernameiuu'";
        $getsyarat = mysqli_query($db, $SQL_getsyarat);
        $resultgetsyarat = mysqli_fetch_array($getsyarat);

        return $resultgetsyarat;
    }

    function getdetailsyarat($klsid, $usernameiuu){
        Global $db;
        $SQL_getdetailsyarat = "SELECT kepemilikan_modul, pengumpulan_kwitansi, pengumpulan_foto FROM kelas_syarat WHERE kelas_kode = '$klsid' AND username = '$usernameiuu'";
        $getdetailsyarat = mysqli_query($db, $SQL_getdetailsyarat);
        $returngetdetailsyarat = mysqli_fetch_array($getdetailsyarat);

        return $returngetdetailsyarat;
    }

    function coutgetdetailsyarat($klsid, $usernameiuu){
        Global $db;
        $SQL_coutgetdetailsyarat = "SELECT COUNT(id) AS Jumlah FROM kelas_syarat WHERE kelas_kode = '$klsid' AND username = '$usernameiuu'";
        $coutgetdetailsyarat = mysqli_query($db, $SQL_coutgetdetailsyarat);
        $returncoutgetdetailsyarat = mysqli_fetch_array($coutgetdetailsyarat);

        return $returncoutgetdetailsyarat;
    }

    function getasistenkelas($klsid){
        Global $db;
        $SQL_getasistenkelas = "SELECT a.username, b.firstname FROM kelas_enrol a, user b WHERE a.username = b.username AND a.kelas_kode = '$klsid' AND a.role_kelas IN ('aslab', 'koorpraktikum', 'kooraslab', 'MHAS', 'KPMS', 'KAMS');";
        $getasistenkelas = mysqli_query($db, $SQL_getasistenkelas);
        return $getasistenkelas;
    }

    function getjadwalkelas($klsid){
        Global $db;
        $SQL_getjadwalkelas = "SELECT * FROM kelas_jadwal_mengajar WHERE kelas_kode = '$klsid'";
        $getjadwalkelas = mysqli_query($db, $SQL_getjadwalkelas);

        return $getjadwalkelas;
    }

    function countjadwalkelas($klsid){
        Global $db;
        $SQL_getjadwalkelas = "SELECT COUNT(id) AS Jumlah FROM kelas_jadwal_mengajar WHERE kelas_kode = '$klsid'";
        $getjadwalkelas = mysqli_query($db, $SQL_getjadwalkelas);
        $resultgetjadwalkelas = mysqli_fetch_array($getjadwalkelas);

        return $resultgetjadwalkelas;
    }

    function getasistenmengajar($klsid){
        Global $db;
        $SQL_getasistenmengajar = "SELECT c.firstname, c.username, a.jadwalM_kode, a.nama_jadwal FROM kelas_jadwal_mengajar a, kelas_aslab_mengajar b, user c WHERE a.jadwalM_kode = b.jadwalM_kode AND b.username = c.username AND a.kelas_kode = '$klsid'";
        $getasistenmengajar = mysqli_query($db, $SQL_getasistenmengajar);

        return $getasistenmengajar;
    }

    function getjadwalkodeD($klsid){
        Global $db;
        $SQL_getjadwalkodeD = "SELECT DISTINCT jadwalM_kode FROM kelas_jadwal_mengajar WHERE kelas_kode = '$klsid'";
        $getjadwalkodeD = mysqli_query($db, $SQL_getjadwalkodeD);

        return $getjadwalkodeD;
    }

    function countgetjadwalkodeD($klsid){
        Global $db;
        $SQL_getjadwalkodeD = "SELECT COUNT(id) AS Jumlah FROM kelas_jadwal_mengajar WHERE kelas_kode = '$klsid'";
        $getjadwalkodeD = mysqli_query($db, $SQL_getjadwalkodeD);
        $resultgetjadwalkodeD = mysqli_fetch_array($getjadwalkodeD);
        return $resultgetjadwalkodeD;
    }

    function getasistenmengajarbyjadwalkode($jdw){
        Global $db;
        $SQL_getasistenmengajar = "SELECT c.firstname, a.* FROM kelas_jadwal_mengajar a, kelas_aslab_mengajar b, user c WHERE a.jadwalM_kode = b.jadwalM_kode AND b.username = c.username AND b.jadwalM_kode = '$jdw'";
        $getasistenmengajar = mysqli_query($db, $SQL_getasistenmengajar);

        return $getasistenmengajar;
    }

    function countgetasistenmengajarbyjadwalkode($jdw){
        Global $db;
        $SQL_countgetasistenmengajarbyjadwalkode = "SELECT COUNT(a.id) AS Jumlah FROM kelas_jadwal_mengajar a, kelas_aslab_mengajar b, user c WHERE a.jadwalM_kode = b.jadwalM_kode AND b.username = c.username AND b.jadwalM_kode = '$jdw'";
        $countgetasistenmengajarbyjadwalkode = mysqli_query($db, $SQL_countgetasistenmengajarbyjadwalkode);
        $resultcountgetasistenmengajarbyjadwalkode = mysqli_fetch_array($countgetasistenmengajarbyjadwalkode);

        return $resultcountgetasistenmengajarbyjadwalkode;
    }