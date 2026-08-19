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
    $labada = getlaboratoriumexist($idcek);

    if($labada['Jumlah'] < 1){
        header('location: 404');
    }
    
    // =============================================== Security check

    if(isset($_SESSION['alert'])){
        $alert =  $_SESSION['alert'];
        unset($_SESSION['alert']);
    }


    $datalaboratorium = getlaboratoriumbyid($_GET["id"]);
    $datadosen = getuserbyrolelab("dosen");
    $datakalab1 = getuserbyrolelab("ketualab");
    $datamahasiswa = getuserbyrolelab("mahasiswa");
    $datakoor = getuserbyrolelab("kooraslab");

    $datakalab = getuserbyusername($datalaboratorium["kepala_laboratorium"]);
    $datakoorlab = getuserbyusername($datalaboratorium["koor_aslab"]);

    function showfile(){
        Global $datalaboratorium;
        
        $surattugas = $datalaboratorium['surat_tugas'];
        if($datalaboratorium['surat_tugas']== NULL){
            echo "<p>File : <span class='text-danger'><b>* file wajib pdf</b></span></p>";
        }else{
            echo "<a href='".LINK_download("asset/data/lab/surat_tugas/".$surattugas)."'>File : $surattugas</a><span class='text-danger pl-3'><b>* file wajib pdf</b></span>";
        }
    }

    function cetakdatadosen(){
        Global $datadosen, $datakalab1;

        while ($rowdatakalab1 = $datakalab1 -> fetch_assoc()){
            $idnumber = $rowdatakalab1["username"];
            $fistname = $rowdatakalab1["firstname"];

            echo "
                <option value='".$idnumber."'>".$idnumber." - ".$fistname."</option>
            ";
        }

        while ($rowdatadosen = $datadosen -> fetch_assoc()){
            $idnumber = $rowdatadosen["username"];
            $fistname = $rowdatadosen["firstname"];


            echo "
                <option value='".$idnumber."'>".$idnumber." - ".$fistname."</option>
            ";
        }
    }

    function cetakdatamahasiswa(){
        Global $datamahasiswa, $datakoor;

        while ($rowdatakoor = $datakoor -> fetch_assoc()){
            $idnumber = $rowdatakoor["username"];
            $fistname = $rowdatakoor["firstname"];

            echo "
                <option value='$idnumber'>$idnumber - $fistname</option>
            ";
        }

        while ($rowdatamahasiswa = $datamahasiswa -> fetch_assoc()){
            $idnumber = $rowdatamahasiswa["username"];
            $fistname = $rowdatamahasiswa["firstname"];

            echo "
                <option value='$idnumber'>$idnumber - $fistname</option>
            ";
        }
    }

    function showformketualab(){
        Global $db, $datakalab, $S_rolestatus;

        if($datakalab != NULL){
            $datakalabecho = $datakalab['username'].' - '.$datakalab['firstname'];
        }else{
            $datakalabecho = "";
        }

        if($S_rolestatus != "ketualab"){
            echo "
                <div class='form-group'>
                    <label for='kepalalab'>Kepala Laboratorium <span class='text-danger'><b>*</b></span></label>
                    <p class='text-success'>Kepala Laboratorium Saat Ini : <b>".$datakalabecho."</b></p>
                    <select class='kepalalab form-control' name='kepalalab' id='kepalalab' required>
                        <option value=''>Select</option>
            ";
                        cetakdatadosen();
            echo " 
                    </select>
                </div>
            ";
        }else{
            echo "
                <div class='form-group'>
                    <label for='kepalalab'>Kepala Laboratorium <span class='text-danger'><b>*</b></span></label>
                    <input type='hidden' class='form-control' name='kepalalab' id='kepalalab' value='".$datakalab['username']."'>
                    <input type='text' class='form-control' name='' id='' value='".$datakalab['username'].' - '.$datakalab['firstname']."' disabled>
                </div>
            ";
        }
    }

    if(isset($_POST["updatelaboratorium"])){
        $id = $_GET["id"];
        $namalaboratorium = $_POST["namalaboratorium"];
        $kepalalaboratorium = $_POST["kepalalab"];
        $kooraslab = $_POST["kooraslab"];

        if(($namalaboratorium != NULL) && ($kepalalaboratorium != NULL) && ($kooraslab != NULL)){
            $namauploadsurattugas = $_FILES['uploadsurattugas']['name'];
            $namauploadsurattugas_tmp = $_FILES['uploadsurattugas']['tmp_name'];
            $extsurattugas = pathinfo($namauploadsurattugas, PATHINFO_EXTENSION);
            $folderuploadsurattugas = $__asset."data/lab/surat_tugas/";
            $fixednamesurattugas = "Surat_Tugas_".$id."_".$kepalalaboratorium.".pdf";

            if($extsurattugas == "pdf"){
                move_uploaded_file($namauploadsurattugas_tmp, $folderuploadsurattugas.$fixednamesurattugas);

                $SQL_updatelaboratorium = "UPDATE laboratorium SET nama_laboratorium = '$namalaboratorium', kepala_laboratorium = '$kepalalaboratorium', surat_tugas = '$fixednamesurattugas' WHERE laboratorium_kode = '$id'";
                $updatelaboratorium = mysqli_query($db, $SQL_updatelaboratorium);

                $SQL_updatekoorlab = "UPDATE laboratorium SET koor_aslab = '$kooraslab'";
                $updatekoorlab = mysqli_query($db, $SQL_updatekoorlab);

                if($updatelaboratorium && $updatekoorlab){
                    $_SESSION['alert'] = $ALERT_updatelaboratoriumsukses;
                }else{
                    $_SESSION['alert'] = $ALERT_updatelaboratoriumgagal;
                }
                
                header('location: '.$LINK_laboratoriumadmin.'');
            }else{
                $_SESSION['alert'] = $ALERT_surattugastidakpdf;
                header('location: '.LINK_laboratoriumketualab($_GET["id"]).'');
            }
        }else{
            $_SESSION['alert'] = $ALERT_datalaboratoriumkosong;
            header('location: '.LINK_laboratoriumketualab($_GET["id"]).'');
        }
    }

    function linkcancel(){
        Global $S_rolestatus, $LINK_home, $LINK_laboratoriumadmin;

        if($S_rolestatus == "ketualab"){
            echo $LINK_home;
        }else if($S_rolestatus == "admin"){
            echo $LINK_laboratoriumadmin;
        }
    }
