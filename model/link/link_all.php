<?php 
    include "config.php";

    // Home
    $LINK_home = $S_rolestatus."?page=home";

    // Laboratorium
    $LINK_laboratoriumadmin = $S_rolestatus."?page=laboratorium";

    function LINK_laboratoriumketualab($idlabb){
        Global $S_rolestatus;

        $LINK_laboratoriumketualab = $S_rolestatus."?page=struktur-lab&id=".$idlabb."";
        return $LINK_laboratoriumketualab;
    }

    function LINK_laporanlaboratoriumketualab($idlabb){
        Global $S_rolestatus;

        $LINK_laporanlaboratoriumketualab = $S_rolestatus."?page=laporanlab&id=".$idlabb."";
        return $LINK_laporanlaboratoriumketualab;
    }

    // Periode
    $LINK_periode = $S_rolestatus."?page=periode";

    function LINK_periodedetail($idprdd){
        Global $S_rolestatus;

        $LINK_periodedetail = $S_rolestatus."?page=periode-detail&id=".$idprdd."";
        return $LINK_periodedetail;
    }

    // Praktikum
    $LINK_praktikum = $S_rolestatus."?page=praktikum";
    $LINK_kelastambah = $S_rolestatus."?page=kelas-tambah";
    $LINK_riwayatkelas = $S_rolestatus."?page=kelas";
    $LINK_navriwayatkelas = $S_rolestatus."?page=kelas";
    $LINK_semuakelas = $S_rolestatus."?page=semua-kelas";

    function LINK_kelas($idkll){
        Global $S_rolestatus;

        $LINK_kelas = $S_rolestatus."?page=kelas-detail&id=".$idkll."&nav=forum";
        return $LINK_kelas;
    }

    function LINK_kelas_nav($idkll, $nav){
        Global $S_rolestatus;

        $LINK_kelas = $S_rolestatus."?page=kelas-detail&id=".$idkll."&nav=".$nav."";
        return $LINK_kelas;
    }

    function LINK_kelas_absensi($idkll, $week){
        Global $S_rolestatus;

        $LINK_kelas = $S_rolestatus."?page=absensi&id=".$idkll."&week=".$week."";
        return $LINK_kelas;
    }

    // USER
    $LINK_user = $S_rolestatus."?page=user";
    
    function LINK_useredit($urss){
        Global $S_rolestatus;

        $LINK_useredit = $S_rolestatus."?page=edituser&id=".$urss;
        return $LINK_useredit;
    }

    function LINK_usererr($erss){
        Global $S_rolestatus;

        $LINK_usererr = $S_rolestatus."?page=user&err=".$erss;
        return $LINK_usererr;
    }

    function LINK_uploaduser($dllr){
        Global $S_rolestatus;

        $LINK_uploaduser = $S_rolestatus."?page=user-upload&delimiter=".$dllr;
        return $LINK_uploaduser;
    }
    // Download
    function LINK_download($locationD){
        Global $S_rolestatus;

        $LINK_download = $S_rolestatus."?page=download&file=".$locationD;
        return $LINK_download;
    }

    // profile
    $LINK_profile = $S_rolestatus."?page=profile";

    // kelas lampau
    
    $LINK_kelaslampau = $S_rolestatus."?page=kelas-lampau";

    // download excel
    $LINK_downloadexcel = $S_rolestatus."?page=downloadexcel";

    // download pdf
    $LINK_downloadpdf = $S_rolestatus."?page=downloadpdf";