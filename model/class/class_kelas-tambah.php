<?php
    include "config.php";

    // =============================================== Security check
    if(!isset($_SESSION['session_username'])){
        header('location: login');
        exit();
    }

    if(($S_rolestatus != "admin") && ($S_rolestatus != "kooraslab")){
        header('location: 404');
    }
    // =============================================== Security check

    if(isset($_SESSION['alert'])){
        $alert = $_SESSION['alert'];
        unset($_SESSION['alert']);
    }

    function showpraktikumname(){
        Global $db;

        $SQL_getlistpraktikum = "SELECT * FROM praktikum";
        $getlistpraktikum = mysqli_query($db, $SQL_getlistpraktikum);
        
        while($resultgetlistpraktikum = $getlistpraktikum -> fetch_assoc()){
            echo "<option value=".$resultgetlistpraktikum['praktikum_kode'].">".$resultgetlistpraktikum['fullname']." (".$resultgetlistpraktikum['shortname'].")</option>";
        }
    }

    function pilihlab(){
        Global $db, $S_rolestatus, $S_username;

        if($S_rolestatus == "ketualab"){
            $labb = getlaboratoriumbyidkalab($S_username);
            echo "
                <div class='form-group'>
                    <label for='input-laboratorium'>Laboratorium <span class='text-danger'><b>*</b></span></label>
                    <input type='text' class='form-control' name='hidden' id='hidden' value='".$labb['nama_laboratorium']."' readonly>
                    <input type='hidden' class='form-control' name='inputlaboratoriumkelas' id='input-laboratorium' value='".$labb['laboratorium_kode']."' required>
                </div>";
        }else{
            echo "
                <div class='form-group'>
                    <label for='input-laboratorium'>Laboratorium <span class='text-danger'><b>*</b></span></label>
                    <select class='form-control' name='inputlaboratoriumkelas' id='input-laboratorium' required>
                        <option value=''>Pilih Laboratorium</option>
            ";

            if($S_rolestatus != "admin")
            {
                $namalaboratroium = getalllaboratorium($S_username);

                while ($rowlab = $namalaboratroium -> fetch_assoc()){
                    echo "<option value='".$rowlab['laboratorium_kode']."'>".$rowlab['nama_laboratorium']."</option>";
                }
            }else{
                $namalaboratroium = getalllabadmin();
                
                while ($rowlab = $namalaboratroium -> fetch_assoc()){
                    echo "<option value='".$rowlab['laboratorium_kode']."'>".$rowlab['nama_laboratorium']."</option>";
                }
            }

            echo "
                    </select>
                </div>
            ";
        }
        
    }

    function showperiodeaktif(){
        Global $db;

        $SQL_getlistperiode = "SELECT * FROM periode WHERE status = 'Aktif'";
        $getlistperiode = mysqli_query($db, $SQL_getlistperiode);
        
        while($resultgetlistperiode = $getlistperiode -> fetch_assoc()){
            echo "<option value=".$resultgetlistperiode['periode_kode'].">".$resultgetlistperiode['nama_periode']."</option>";
        }
    }

    if(isset($_POST['tambahkelas'])){
        $namakelas = $_POST['inputfullnamekelas'];
        $namalab = $_POST['inputlaboratoriumkelas'];
        $jadwal = $_POST['inputjadwalkelas'];
        $periode = $_POST['inputperiodekelas'];
        $deskripsi = addslashes($_POST['inputdeskripsikelas']);

        $SQL_getkelasid = "SELECT MAX(id) AS max FROM kelas";
        $getkelasid = mysqli_query($db, $SQL_getkelasid);
        $resultgetkelasid = mysqli_fetch_array($getkelasid);

        $SQL_getperiode = "SELECT * FROM periode WHERE periode_kode = '$periode'";
        $getperiode = mysqli_query($db, $SQL_getperiode);
        $resultgetperiode = mysqli_fetch_array($getperiode);

        $kelaskode = make_code("KLS", $resultgetkelasid['max']);
        $errortkelas = 0;

        if(($namakelas != NULL) && ($namalab != NULL) && ($jadwal != NULL) && ($periode != NULL) && ($deskripsi != NULL)){
            $SQL_insertkelas = "INSERT INTO kelas(kelas_kode, jadwal, periode_kode, laboratorium_kode, praktikum_kode, deskripsi) VALUES ('$kelaskode', '$jadwal', '$periode', '$namalab', '$namakelas', '$deskripsi')";
            $insertkelas = mysqli_query($db, $SQL_insertkelas);

            if(!$insertkelas){
                $errortkelas++;
            }

            if($S_rolestatus == "admin"){
                $SQL_enroluseradmin = "INSERT INTO kelas_enrol(kelas_kode, username, role_kelas, pembuat_kelas) VALUES('$kelaskode', '$S_username', 'admin', 'yes')";
                $enroluseradmin = mysqli_query($db, $SQL_enroluseradmin);

                $SLQ_getkalabenrol = "SELECT kepala_laboratorium, koor_aslab FROM laboratorium WHERE laboratorium_kode = '$namalab'";
                $getkalabenrol = mysqli_query($db, $SLQ_getkalabenrol);
                $resultgetkalabenrol = mysqli_fetch_array($getkalabenrol);
                $ketualab = $resultgetkalabenrol['kepala_laboratorium'];
                $kooraslab = $resultgetkalabenrol['koor_aslab'];

                $SQL_enroluserketualab = "INSERT INTO kelas_enrol(kelas_kode, username, role_kelas) VALUES('$kelaskode', '$ketualab', 'ketualab')";
                $enroluserketualab = mysqli_query($db, $SQL_enroluserketualab);

                $SQL_enroluserkooraslab = "INSERT INTO kelas_enrol(kelas_kode, username, role_kelas) VALUES('$kelaskode', '$kooraslab', 'kooraslab')";
                $enroluserkooraslab = mysqli_query($db, $SQL_enroluserkooraslab);
                
                if(!$enroluseradmin){
                    $errortkelas++;
                }

                if(!$enroluserketualab){
                    $errortkelas++;
                }

                if(!$enroluserkooraslab){
                    $errortkelas++;
                }

            }else if($S_rolestatus == "ketualab"){
                $SQL_enroluserketualab = "INSERT INTO kelas_enrol(kelas_kode, username, role_kelas, pembuat_kelas) VALUES('$kelaskode', '$S_username', 'ketualab', 'yes')";
                $enroluserketualab = mysqli_query($db, $SQL_enroluserketualab);

                $SLQ_getkalabenrol = "SELECT kepala_laboratorium, koor_aslab FROM laboratorium WHERE laboratorium_kode = '$namalab'";
                $getkalabenrol = mysqli_query($db, $SLQ_getkalabenrol);
                $resultgetkalabenrol = mysqli_fetch_array($getkalabenrol);
                $ketualab = $resultgetkalabenrol['kepala_laboratorium'];
                $kooraslab = $resultgetkalabenrol['koor_aslab'];

                $SQL_enroluserkooraslab = "INSERT INTO kelas_enrol(kelas_kode, username, role_kelas) VALUES('$kelaskode', '$kooraslab', 'kooraslab')";
                $enroluserkooraslab = mysqli_query($db, $SQL_enroluserkooraslab);

                $SQL_enroluseradmin = "INSERT INTO kelas_enrol(kelas_kode, username, role_kelas) VALUES('$kelaskode', 'Admin_lab', 'admin')";
                $enroluseradmin = mysqli_query($db, $SQL_enroluseradmin);

                if(!$enroluserketualab){
                    $errortkelas++;
                }

                if(!$enroluserkooraslab){
                    $errortkelas++;
                }
            }else if($S_rolestatus == "kooraslab"){
                $SQL_enroluserkooraslab = "INSERT INTO kelas_enrol(kelas_kode, username, role_kelas, pembuat_kelas) VALUES('$kelaskode', '$S_username', 'kooraslab', 'yes')";
                $enroluserkooraslab = mysqli_query($db, $SQL_enroluserkooraslab);

                $SLQ_getkalabenrol = "SELECT kepala_laboratorium, koor_aslab FROM laboratorium WHERE laboratorium_kode = '$namalab'";
                $getkalabenrol = mysqli_query($db, $SLQ_getkalabenrol);
                $resultgetkalabenrol = mysqli_fetch_array($getkalabenrol);
                $ketualab = $resultgetkalabenrol['kepala_laboratorium'];
                $kooraslab = $resultgetkalabenrol['koor_aslab'];

                $SQL_enroluserketualab = "INSERT INTO kelas_enrol(kelas_kode, username, role_kelas) VALUES('$kelaskode', '$ketualab', 'ketualab')";
                $enroluserketualab = mysqli_query($db, $SQL_enroluserketualab);

                $SQL_enroluseradmin = "INSERT INTO kelas_enrol(kelas_kode, username, role_kelas) VALUES('$kelaskode', 'Admin_lab', 'admin')";
                $enroluseradmin = mysqli_query($db, $SQL_enroluseradmin);

                if(!$enroluserketualab){
                    $errortkelas++;
                }

                if(!$enroluserkooraslab){
                    $errortkelas++;
                }
            }

            for($i = 1; $i <= 16; $i++){
                $SQL_insertabsen = "INSERT INTO kelas_absen(kelas_kode, week, status) VALUES ('$kelaskode', '$i', 'notset')";
                $inserabsen = mysqli_query($db, $SQL_insertabsen);

                if(!$inserabsen){
                    $errortkelas++;
                }
            }
            
            $SQL_insertformatnilai = "INSERT INTO kelas_formatnilai(kelas_kode) VALUES('$kelaskode')";
            $insertfotmatnilai = mysqli_query($db, $SQL_insertformatnilai);

            if(!$insertfotmatnilai){
                $errortkelas++;
            }

            if($errortkelas == 0){
                $_SESSION['alert'] = $ALERT_tambahkelasberhasil;
                header('location: '.$LINK_home.'');
            }else{
                $_SESSION['alert'] = $ALERT_tambahkelasgagal;
                header('location: '.$LINK_home.'');
            }
        }else{
            $_SESSION['alert'] = $ALERT_tambahkelaskosong;
            header('location: '.$LINK_kelastambah.'');
        }
    }

?>