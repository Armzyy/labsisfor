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

    function showkelasnav(){
        Global $db, $S_username, $S_rolestatus, $LINK_semuakelas, $resultgetminkelas, $getkelasdata1nav;

        $navigation = isset($_GET['nav']) ? $_GET['nav'] : getminkelas();

        $kelasdata = getallkelasnav();

        $count = 0;
        while ($navkelas = $kelasdata -> fetch_assoc()){
            
            $navshort = $navkelas['shortname'];
            
            if($navshort == $navigation){
                $activenav = "active";
            }else{
                $activenav = "";
            }
            echo "
                <li class='nav-item'>
                    <a class='nav-link ".$activenav."' aria-current='page' href='".$LINK_semuakelas."&nav=".$navkelas['shortname']."'><b>".$navkelas['shortname']."</b></a>
                </li>
            ";
            $count++;
        }

        if($count == 0){
            echo "
                <li class='nav-item'>
                    Tidak Ada Kelas Praktikum Pada Sistem
                </li>
            ";
        }   
    }

    function contentkelas(){
        Global $db, $S_username, $S_rolestatus, $resultgetminkelas;

        $navigation = isset($_GET['nav']) ? $_GET['nav'] : getminkelas();

        $datapraktikum = getpraktikumbyshortname($navigation);
        $count = 0;
        while($rowdatapraktikum = $datapraktikum -> fetch_assoc()){
            echo "
                    <div class='col-xl-12'>
                        <div class='card'>
                            <div class='card-header py-3 d-flex flex-row align-items-center justify-content-between'>
                                <h6 class='m-0 font-weight-bold text-primary'>Kelas Praktikum ".$rowdatapraktikum['fullname']."</h6>
                            </div>
                            <div class='table-responsive p-3'>
                                <table class='table align-items-center table-flush' id='tablesemuakelas'>
                                    <thead class='thead-light'>
                                    <tr>
                                        <th class='d-none d-md-table-cell'>ID Kelas</th>
                                        <th>Nama Kelas</th>
                                        <th class='d-none d-md-table-cell'>Jumlah Mahasiswa</th>
                                        <th class='d-none d-md-table-cell'>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    ";

                                    $datakelasdetail = getallkelasbypraktikumkode($rowdatapraktikum['praktikum_kode']);

                                    while($resulgetkelass = $datakelasdetail -> fetch_assoc()){
                                        $jmlkelas = getjumlahkelas($resulgetkelass['kelas_kode']);
                                        if($resulgetkelass['status'] == "Aktif"){
                                            $color = "success";
                                        }else{
                                            $color = "danger";
                                        }

                                        $periodename = getperiodebyid($resulgetkelass['periode_kode']);
                                        echo "
                                            <tr>
                                                <td class='d-none d-md-table-cell'>".$resulgetkelass['kelas_kode']."</td>
                                                <td><a href='".LINK_kelas($resulgetkelass['kelas_kode'])."' class='text-capitalize'>".$rowdatapraktikum['fullname']." (".$rowdatapraktikum['shortname'].") - ".$resulgetkelass['jadwal']." - ".$periodename['nama_periode']."</a></td>
                                                <td class='d-none d-md-table-cell'>".$jmlkelas['jumlah']."</td>
                                                <td class='d-none d-md-table-cell'><span class='badge badge-".$color." p-2'>".$resulgetkelass['status']."</span></td>
                                            </tr>
                                        ";
                                    }
            echo "                       
                                </tbody>
                            </table>
                        </div>
                        <div class='card-footer'></div>
                    </div>
                </div>

            ";
            $count++;
        }
        if($count == 0){
            echo "
                <p>
                    result 0.
                </p>
            ";
        }   
    }

    function showsemuakelas(){
        Global $getperiodedata2, $resultgetkelascount, $getkelasdata1, $db;
        
        $kelasallcount = $resultgetkelascount;
        if($kelasallcount['Jumlah'] == 0){
            echo "
                <div class='col-xl-12 col-lg-7 mb-4'>
                    <div class='card'>
                        <div class='card-header py-3 d-flex flex-row align-items-center justify-content-between'>
                            <h6 class='m-0 font-weight-bold text-primary'>Tidak kelas aktif pada sistem.</h6>
                        </div>
                    </div>
                </div>
            ";
        }else{
            echo "
                <div class='col-xl-12 mb-4'>
                    <div class='card'>
                        <div class='card-header py-3 d-flex flex-row align-items-center justify-content-between'>
                            <h6 class='m-0 font-weight-bold text-primary'>Data Seluruh kelas Praktikum</h6>
                        </div>
                        <div class='table-responsive p-3'>
                            <table class='table align-items-center table-flush' id='tablesemuakelas'>
                                <thead class='thead-light'>
                                <tr>
                                    <th class='d-none d-md-table-cell'>ID Kelas</th>
                                    <th>Nama Kelas</th>
                                    <th class='d-none d-md-table-cell'>Jumlah Mahasiswa</th>
                                    <th class='d-none d-md-table-cell'>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                ";

                                while($resulgetkelass = $getkelasdata1 -> fetch_assoc()){
                                    $jmlkelas = getjumlahkelas($resulgetkelass['kelas_kode']);
                                    if($resulgetkelass['status'] == "Aktif"){
                                        $color = "success";
                                    }else{
                                        $color = "danger";
                                    }

                                    $periodename = getperiodebyid($resulgetkelass['periode_kode']);
                                    echo "
                                        <tr>
                                            <td class='d-none d-md-table-cell'>".$resulgetkelass['kelas_kode']."</td>
                                            <td><a href='".LINK_kelas($resulgetkelass['kelas_kode'])."' class='text-capitalize'>".$resulgetkelass['fullname']." (".$resulgetkelass['shortname'].") - ".$resulgetkelass['jadwal']." - ".$periodename['nama_periode']."</a></td>
                                            <td class='d-none d-md-table-cell'>".$jmlkelas['jumlah']."</td>
                                            <td class='d-none d-md-table-cell'><span class='badge badge-".$color." p-2'>".$resulgetkelass['status']."</span></td>
                                        </tr>
                                    ";
                                }
            echo "                       
                                </tbody>
                            </table>
                        </div>
                        <div class='card-footer'></div>
                    </div>
                </div>

            ";
        }
    }