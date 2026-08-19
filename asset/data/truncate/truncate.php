<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../images/logo_lab.png" rel="icon">
    <title>Truncate All Data</title>

    <?php
    include '../../../config.php';

    // if(isset($_POST['sumbittruncate'])){
    //     $pass = $_POST['passtruncate'];
    //     $passasli = "Truncateajadulu";
    //     $erorrr = 0;
    //     if($pass == $passasli){
    //         $SQL_Tkelas = "TRUNCATE TABLE kelas";
    //         $Tkelas = mysqli_query($db, $SQL_Tkelas);
    //         if(!$Tkelas){
    //             $erorrr++;
    //         }
            
    //         $SQL_Tkelas_absen = "TRUNCATE TABLE kelas_absen";
    //         $Tkelas_absen = mysqli_query($db, $SQL_Tkelas_absen);
    //         if(!$Tkelas_absen){
    //             $erorrr++;
    //         }
    //         $SQL_Tkelas_absen_absensi = "TRUNCATE TABLE kelas_absen_absensi";
    //         $Tkelas_absen_absensi = mysqli_query($db, $SQL_Tkelas_absen_absensi);

    //         if(!$Tkelas_absen_absensi){
    //             $erorrr++;
    //         }
    //         $SQL_Tkelas_enrol = "TRUNCATE TABLE kelas_enrol";
    //         $Tkelas_enrol = mysqli_query($db, $SQL_Tkelas_enrol);

    //         if(!$Tkelas_enrol){
    //             $erorrr++;
    //         }
    //         $SQL_Tkelas_formatnilai = "TRUNCATE TABLE kelas_formatnilai";
    //         $Tkelas_formatnilai = mysqli_query($db, $SQL_Tkelas_formatnilai);

    //         if(!$Tkelas_formatnilai){
    //             $erorrr++;
    //         }
    //         $SQL_Tkelas_forum = "TRUNCATE TABLE kelas_forum";
    //         $Tkelas_forum = mysqli_query($db, $SQL_Tkelas_forum);

    //         if(!$Tkelas_forum){
    //             $erorrr++;
    //         }
    //         $SQL_Tkelas_modul = "TRUNCATE TABLE kelas_modul";
    //         $Tkelas_modul = mysqli_query($db, $SQL_Tkelas_modul);

    //         if(!$Tkelas_modul){
    //             $erorrr++;
    //         }
    //         $SQL_Tkelas_modul_asisten = "TRUNCATE TABLE kelas_modul_asisten";
    //         $Tkelas_modul_asisten = mysqli_query($db, $SQL_Tkelas_modul_asisten);

    //         if(!$Tkelas_modul_asisten){
    //             $erorrr++;
    //         }
    //         $SQL_Tkelas_tugas = "TRUNCATE TABLE kelas_tugas";
    //         $Tkelas_tugas = mysqli_query($db, $SQL_Tkelas_tugas);

    //         if(!$Tkelas_tugas){
    //             $erorrr++;
    //         }
    //         $SQL_Tkelas_tugas_materi = "TRUNCATE TABLE kelas_tugas_materi";
    //         $Tkelas_tugas_materi = mysqli_query($db, $SQL_Tkelas_tugas_materi);

    //         if(!$Tkelas_tugas_materi){
    //             $erorrr++;
    //         }
    //         $SQL_Tkelas_tugas_pengumpulan = "TRUNCATE TABLE kelas_tugas_pengumpulan";
    //         $SQL_Tkelas_tugas_pengumpulan = mysqli_query($db, $SQL_Tkelas_tugas_pengumpulan);

    //         if(!$SQL_Tkelas_tugas_pengumpulan){
    //             $erorrr++;
    //         }
    //         $SQL_Tlaboratorium = "TRUNCATE TABLE laboratorium";
    //         $Tlaboratorium = mysqli_query($db, $SQL_Tlaboratorium);

    //         if(!$Tlaboratorium){
    //             $erorrr++;
    //         }
    //         $SQL_Tperiode = "TRUNCATE TABLE periode";
    //         $Tperiode = mysqli_query($db, $SQL_Tperiode);

    //         if(!$Tperiode){
    //             $erorrr++;
    //         }
    //         $SQL_Tpraktikum = "TRUNCATE TABLE praktikum";
    //         $Tpraktikum = mysqli_query($db, $SQL_Tpraktikum);

    //         if(!$Tpraktikum){
    //             $erorrr++;
    //         }
    //         $SQL_Ttmp_user_upload = "TRUNCATE TABLE tmp_user_upload";
    //         $Ttmp_user_upload = mysqli_query($db, $SQL_Ttmp_user_upload);

    //         if(!$Ttmp_user_upload){
    //             $erorrr++;
    //         }
    //         $SQL_Tuser= "TRUNCATE TABLE user";
    //         $Tuser = mysqli_query($db, $SQL_Tuser);

    //         if(!$Tuser){
    //             $erorrr++;
    //         }

    //         $enc_passreset = hash_init('sha512');
    //         hash_update($enc_passreset, "adminlab_123456789");
    //         $final_hash_reset = hash_final($enc_passreset);

    //         $SQL_INPUTADMIN = "INSERT INTO user(username, password, role, firstname, lastname, degree, email, phone, institution, departement, address, city, country, picture) VALUES('adminlab', '$final_hash_reset', 'admin', 'Admin', 'Laboratorium SI', 'The Master', 'admin@gmail.com', '832000000', 'INSTITUT TEKNOLOGI ADHI TAMA SURABAYA', 'SISTEM INFORMASI', 'Jl. Laboratorium SI ITATS', 'SURABAYA', 'INDONESIA', 'user')";
    //         $INPUTADMIN = mysqli_query($db, $SQL_INPUTADMIN);

    //         if(!$INPUTADMIN){
    //             $erorrr++;
    //         }

    //         if($erorrr == 0){
    //             header('location : index');
    //         }
    //     }
    // }
    if(isset($_POST['sumbittruncate'])){
        $pass = $_POST['passtruncate'];
        $passasli = "Truncateajadulu";
        $erorrr = 0;
        if($pass == $passasli){
            $SQL_Tkelas = "TRUNCATE TABLE kelas";
            $Tkelas = mysqli_query($db, $SQL_Tkelas);
            if(!$Tkelas){
                $erorrr++;
            }
            
            if($erorrr == 0){
                header('location : login');
            }
        }
    }
    ?>
</head>
<body>
    <div class="warpper">
        <div class="content-fluid">
            <form method="post">
                <p>Ingin melakukan Truncate?</p>
                <input type="password" name="passtruncate" id="passtruncate">
                <input type="submit" name="sumbittruncate" value="Truncate">
            </form>
        </div>
    </div>
</body>
</html>


    