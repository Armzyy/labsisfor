<?php
    include "config.php"; 

    // =============================================== Security check
    if(!isset($_SESSION['session_username'])){
        header('location: login');
        exit();
    }

    if(($S_rolestatus == "admin")){
        header('location: 404');
    }
    // =============================================== Security check

    function showkelasnav(){
        Global $db, $S_username, $S_rolestatus, $LINK_navriwayatkelas, $resultgetminkelas;

        $navigation = isset($_GET['nav']) ? $_GET['nav'] : getminkelas();

        if($S_rolestatus == "ketualab"){
            $labid = getlaboratoriumbyidkalab($S_username);
            $kelasnav = getallkelasbylab($labid['laboratorium_kode']);
            $count = 0;
            while ($navkelas = $kelasnav -> fetch_assoc()){
                
                $navshort = $navkelas['shortname'];
                
                if($navshort == $navigation){
                    $activenav = "active";
                }else{
                    $activenav = "";
                }
                echo "
                    <li class='nav-item'>
                        <a class='nav-link ".$activenav."' aria-current='page' href='".$LINK_navriwayatkelas."&nav=".$navkelas['shortname']."'><b>".$navkelas['shortname']."</b></a>
                    </li>
                ";
                $count++;
            }

            if($count == 0){
                echo "
                    <li class='nav-item'>
                        Tidak Ada Kelas Praktikum Aktif
                    </li>
                ";
            }
        }else if($S_rolestatus == "kooraslab"){
            $kelasnav = getallkelas();
            $count = 0;
            while ($navkelas = $kelasnav -> fetch_assoc()){

                $navshort = $navkelas['shortname'];
                
                if($navshort == $navigation){
                    $activenav = "active";
                }else{
                    $activenav = "";
                }
                echo "
                    <li class='nav-item'>
                        <a class='nav-link ".$activenav."' aria-current='page' href='".$LINK_navriwayatkelas."&nav=".$navkelas['shortname']."'><b>".$navkelas['shortname']."</b></a>
                    </li>
                ";

                $count++;
            }

            if($count == 0){
                echo "
                    <li class='nav-item'>
                        Tidak Ada Kelas Praktikum Aktif
                    </li>
                ";
            }
        }else{
            $kelasnav = getallkelasenrol($S_username);
            $count = 0;
            while ($navkelas = $kelasnav -> fetch_assoc()){

                $navshort = $navkelas['shortname'];
                
                if($navshort == $navigation){
                    $activenav = "active";
                }else{
                    $activenav = "";
                }
                echo "
                    <li class='nav-item'>
                        <a class='nav-link ".$activenav."' aria-current='page' href='".$LINK_navriwayatkelas."&nav=".$navkelas['shortname']."'><b>".$navkelas['shortname']."</b></a>
                    </li>
                ";

                $count++;
            }

            if($count == 0){
                echo "
                    <li class='nav-item'>
                        Tidak Ada Kelas Praktikum Aktif
                    </li>
                ";
            }
        }
        
    }

    function contentkelas(){
        Global $db, $S_username, $S_rolestatus, $resultgetminkelas;

        $getnav = isset($_GET['nav']) ? $_GET['nav'] : getminkelas();

        $datakelas = getkelasallbyshortname($getnav, $S_username);
        $count = 0;
        while($rowdatakelas = $datakelas -> fetch_assoc()){

            $periodekelas = getperiodebyid($rowdatakelas['periode_kode']);
            $labkelas = getlaboratoriumbyid($rowdatakelas['laboratorium_kode']);
            $statuskk = $rowdatakelas['status'];

            if($statuskk == "Aktif"){
                $color = "success";
            }else{
                $color = "danger";
            }

            echo "
                <div class='card mb-3'>
                    <div class='row g-0'>
                        <div class='col-md-9'>
                             <div class='card-body'>
                                <h5 class='card-title'>".$rowdatakelas['fullname']." - ".$rowdatakelas['shortname']." - ".ucwords($rowdatakelas['jadwal'])."<span class='ml-3 badge badge-secondary text-sm'>".namerole($rowdatakelas['role_kelas'])."</span></h5>
                                <p class='card-text'>Periode : ".$periodekelas['nama_periode']." <span class='ml-5'></span> Laboratorium : ".$labkelas['nama_laboratorium']."</p>
                                <a href='".LINK_kelas_nav($rowdatakelas['kelas_kode'], 'forum')."' class='btn btn-primary'>Masuk Kelas</a>
                            </div>
                        </div>
                        <div class='col-md-3 d-flex align-items-center justify-content-center'>
                            <h4><span class='badge badge-".$color."'>Kelas ".$statuskk."</span></h4>
                        </div>
                    </div>
                </div>
            ";
            $count++;
        }
        if($count == 0){
            echo "
                Result 0.
            ";
        }
    }

    function showdatakelas(){
        Global $db, $S_username, $S_rolestatus;

        $SQL_countgetpraktikum = "SELECT COUNT(id) AS Jumlah FROM praktikum";
        $getcountpraktikum = mysqli_query($db, $SQL_countgetpraktikum);
        $resultgetcountpraktikum = mysqli_fetch_array($getcountpraktikum);
        
        if($resultgetcountpraktikum["Jumlah"] != 0){
            $SQL_getpraktikum = "SELECT * FROM praktikum";
            $getpraktikum = mysqli_query($db, $SQL_getpraktikum);
            
            while($resultgetpraktikum = $getpraktikum -> fetch_assoc()){

                echo "
                    <div class='col-lg-12'>
                    <div class='card mb-4'>
                        <div class='card-header py-3 d-flex flex-row align-items-center justify-content-between'>
                            <h6 class='m-0 font-weight-bold text-primary'>".$resultgetpraktikum['fullname']."</h6>
                        </div>
                        <div class='table-responsive p-3'>
                            <table class='table align-items-center table-flush' id='dataTable'>
                                <thead class='thead-light'>
                                    <tr>
                                        <th class='col-7'>Nama Kelas</th>
                                        <th>Periode</th>
                                        <th>Status</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                ";

                $shortname = $resultgetpraktikum['shortname'];

                $SQL_getkelasnonaktif = "SELECT a.kelas_kode, b.fullname, b.shortname, b.jadwal, b.jadwal, c.nama_periode, a.role_kelas, a.nilai_all FROM kelas_enrol a, kelas b, periode c WHERE username = '".$S_username."' AND a.kelas_kode = b.kelas_kode AND b.status = 'Non-Aktif' AND b.shortname = '".$shortname."' AND b.periode_kode = c.periode_kode";
                $kelasnonaktif1 = mysqli_query($db, $SQL_getkelasnonaktif);
                $kelasnonaktif2 = mysqli_query($db, $SQL_getkelasnonaktif);
                $rowcount = mysqli_num_rows($kelasnonaktif1);   
                
                if($rowcount == 0){
                    echo "        
                        <tr>
                            <td>Anda belum mengambil kelas praktikum ".$resultgetpraktikum['shortname']." / kelas Sedang Berjalan</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>                     
                    ";
                }else{
                    while($resultkelasnonaktif = $kelasnonaktif2 -> fetch_assoc()){
                        $kelas_kodecek = $resultkelasnonaktif['kelas_kode'];
                        $SQL_getformatnilai = "SELECT * FROM kelas_formatnilai WHERE kelas_kode = '$kelas_kodecek'";
                        $getformatnilai = mysqli_query($db, $SQL_getformatnilai);
                        $resultgetformatnilai = mysqli_fetch_array($getformatnilai);

                        if($resultkelasnonaktif['role_kelas'] == "admin"){
                            $sjabatan = "Admin Laboratorium";
                        }else if($resultkelasnonaktif['role_kelas'] == "ketualab"){
                            $sjabatan = "Ketua Laboratorium";
                        }else if($resultkelasnonaktif['role_kelas'] == "kooraslab"){
                            $sjabatan = "Koor Asistem Laboratorium";
                        }else if($resultkelasnonaktif['role_kelas'] == "koorpraktikum"){
                            $sjabatan = "Koor Praktikum";
                        }else if($resultkelasnonaktif['role_kelas'] == "aslab"){
                            $sjabatan = "Asisten Laboratorium";
                        }else if($resultkelasnonaktif['role_kelas'] == "dosen"){
                            $sjabatan = "Dosen Pengampu";
                        }else{
                            $sjabatan = "Mahasiswa";
                        }
                        echo "        
                            <tr>
                                <td><a href='".LINK_kelas($resultkelasnonaktif['kelas_kode'])."'>".$resultkelasnonaktif['fullname']." (".$resultkelasnonaktif['shortname'].") - <span class='text-capitalize'>".$resultkelasnonaktif['jadwal']."</span></a></td>
                                <td class='text-capitalize'>".$resultkelasnonaktif['nama_periode']."</td>
                                <td>".$sjabatan."</td> 
                                <td>".$resultkelasnonaktif['nilai_all']."</td>
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
        }else{
            echo "
                <div class='col-lg-12'>
                    <div class='card mb-4'>
                        <div class='card-header py-3 d-flex flex-row align-items-center justify-content-between'>
                            <h6 class='m-0 font-weight-bold text-primary'>Tidak Ada Kelas Praktikum Dalam Sistem.</h6>
                        </div>
                    </div>
                </div>
            ";
        }
    }
?>