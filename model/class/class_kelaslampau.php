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
        Global $db, $S_username, $S_rolestatus, $LINK_kelaslampau, $resultgetminkelas;

        $navigation = isset($_GET['nav']) ? $_GET['nav'] : getminkelas();

        if($S_rolestatus == "ketualab"){
            $labid = getlaboratoriumbyidkalab($S_username);
            $kelasnav = getallkelasbylabnonaktif($labid['laboratorium_kode']);
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
                        <a class='nav-link ".$activenav."' aria-current='page' href='".$LINK_kelaslampau."&nav=".$navkelas['shortname']."'><b>".$navkelas['shortname']."</b></a>
                    </li>
                ";
                $count++;
            }

            if($count == 0){
                echo "
                    <li class='nav-item'>
                        Tidak Ada Kelas Praktikum Lampau
                    </li>
                ";
            }
        }else{
            $kelasnav = getallkelasnonaktif();

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
                        <a class='nav-link ".$activenav."' aria-current='page' href='".$LINK_kelaslampau."&nav=".$navkelas['shortname']."'><b>".$navkelas['shortname']."</b></a>
                    </li>
                ";
                $count++;
            }

            if($count == 0){
                echo "
                    <li class='nav-item'>
                        Tidak Ada Kelas Praktikum Lampau
                    </li>
                ";
            }
        }
        
    }

    function contentkelas(){
        Global $db, $S_username, $S_rolestatus, $resultgetminkelas;

        $getnav = isset($_GET['nav']) ? $_GET['nav'] : getminkelas();

        $datakelas = getkelasallbyshortnamenonaktif($getnav);

        $countdata = 0;
        while($rowdatakelas = $datakelas -> fetch_assoc()){

            $periodekelas = getperiodebyid($rowdatakelas['periode_kode']);
            $labkelas = getlaboratoriumbyid($rowdatakelas['laboratorium_kode']);
            $statuskk = $rowdatakelas['status'];

            if($statuskk == "Non-Aktif"){
                $color = "danger";
            }else{
                $color = "success";
            }
            echo "
                <div class='card mb-3'>
                    <div class='row g-0'>
                        <div class='col-md-9'>
                             <div class='card-body'>
                                <h5 class='card-title'>".$rowdatakelas['fullname']." - ".$rowdatakelas['shortname']." - ".ucwords($rowdatakelas['jadwal'])."</h5>
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
            $countdata++;
        }

        if($countdata == 0){
            echo "
                Result 0.
            ";
        }
    }
?>