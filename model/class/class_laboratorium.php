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

    if(isset($_SESSION['alert'])){
        $alert =  $_SESSION['alert'];
        unset($_SESSION['alert']);
    }

    function showlaboratorium(){
        Global $db, $S_rolestatus;

        $SQL_getlaboratorium = "SELECT * FROM laboratorium";
        $getlaboratorium = mysqli_query($db, $SQL_getlaboratorium);

        while($resultgetlaboratorium = $getlaboratorium-> fetch_assoc()){

            $kepalalab = getuserbyusername($resultgetlaboratorium['kepala_laboratorium']);

            if($kepalalab != null){
                echo "
                    <tr>
                        <td>".$resultgetlaboratorium['laboratorium_kode']."</td>
                        <td>".$resultgetlaboratorium['nama_laboratorium']."</td>
                        <td>".$kepalalab['firstname']."</td>
                        <td><a href='".LINK_download("asset/data/lab/surat_tugas/".$resultgetlaboratorium['surat_tugas'])."' class='btn btn-warning'>Download</a></td>
                        <td><a href='".LINK_laboratoriumketualab($resultgetlaboratorium['laboratorium_kode'])."' class='btn btn-success'>Edit</a></td>
                    </tr>
                ";
            }else{
                echo "
                    <tr>
                        <td>".$resultgetlaboratorium['laboratorium_kode']."</td>
                        <td>".$resultgetlaboratorium['nama_laboratorium']."</td>
                        <td></td>
                        <td>".$resultgetlaboratorium['surat_tugas']."</td>
                        <td><a href='".LINK_laboratoriumketualab($resultgetlaboratorium['laboratorium_kode'])."' class='btn btn-success'>Edit</a></td>
                    </tr>
                ";
            }
           
        }
        

    }

    if(isset($_POST['tambahlaboratorium'])){
        $namalaboratoium = $_POST['inputnamalaboratorium'];
        $code = "LBR";

        $SQL_getidlab = "SELECT MAX(id) AS id FROM laboratorium";
        $getidlab = mysqli_query($db, $SQL_getidlab);
        $resultgetidlab = mysqli_fetch_array($getidlab);

        $value = $resultgetidlab['id'];
        
        $kodelab = make_code($code, $value);

        if($namalaboratoium != ""){
            $SQL_inputlaboratorium = "INSERT INTO laboratorium(laboratorium_kode, nama_laboratorium) VALUES('$kodelab', '$namalaboratoium')";
            $inputlaboratorium = mysqli_query($db,$SQL_inputlaboratorium);

            if($inputlaboratorium){
                $_SESSION['alert'] = $ALERT_inputlaboratoriumsukses;
                header('location: '.$LINK_laboratoriumadmin.'');
            }else{
                $_SESSION['alert'] = $ALERT_inputlaboratoriumgagal;
                header('location: '.$LINK_laboratoriumadmin.'');
            }
        }else{
            $_SESSION['alert'] = $ALERT_datalaboratoriumkosong;
            header('location: '.$LINK_laboratoriumadmin.'');
        }
    }
?>