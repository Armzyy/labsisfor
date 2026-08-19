<?php
    // =============================================== Security check
    if(!isset($_SESSION['session_username'])){
        header('location: login');
        exit();
    }

    $getkode = isset($_GET['kode']) ? $_GET['kode'] : 'null';
    $getklsid = isset($_GET['klsid']) ? $_GET['klsid'] : 'null';
    $getweek = isset($_GET['week']) ? $_GET['week'] : 'null';
    $getlbrid= isset($_GET['lbrid']) ? $_GET['lbrid'] : 'null';
    $getprdid = isset($_GET['prdid']) ? $_GET['prdid'] : 'null';
    $getklsdos = isset($_GET['klsdos']) ? $_GET['klsdos'] : 'null';

    if(($getklsid != "null") && ($getweek != "null")){
        $absensi = "yes";
    }else{
        $absensi = "no";
    }

    if(($getlbrid != "null") && ($getprdid != "null")){
        $laporan = "yes";
    }else{
        $laporan = "no";
    }

    if(($getklsid != "null") && ($getklsdos != "null")){
        $nilai = "yes";
    }else{
        $nilai = "no";
    }

    if(($getkode == "null")){
        header('location: 404');
    }else if(($laporan == "no") && ($absensi == "no") && ($nilai == "no")){
        header('location: 404');
    }else{
        if($absensi == "yes"){
            $cekmahasiswa = getuserrolekelas($getklsid, $S_username);
    
            if($cekmahasiswa == "mahasiswa"){
                header('location: 404');
            }

            $statusabsen = cekstatusabsen($getklsid, $getweek);

            if($statusabsen['status'] == "notset"){
                header('location: 404');
            }
        }

        if($laporan == "yes"){
            $cekketualab = getuserbyusername($S_username);

            if($cekketualab['role'] != "ketualab"){
                header('location: 404');
            }
        }

        if($nilai == "yes"){
            $cekrolekelas = getuserrolekelas($getklsid, $S_username);

            if(($cekrolekelas != "dosen") && ($cekrolekelas != "KLDS")){
                header('location: 404');
            }
        }
    }

    if(($getkode != "absensi") && ($getkode != "laporan") && ($getkode != "nilai")){
        header('location: 404');
    }

    $link = "http://localhost/e-laboratorium/mahasiswa?page=downloadexcel&kode=absensi&klsid=KLS00001&week=1";
    // =============================================== Security check

    function downloadabsensi(){
        Global $S_username, $week, $rollback;
        
        $kelasid = $_GET['klsid'];
        $week = $_GET['week'];
        $kelasdata = getkelasbyid($kelasid);

        if(isset($_GET['lksd'])){
            $kelasdosen = $_GET['lksd'];
            $dataenrol = getdatamahasiswaenrolbykelasdosen($kelasid, $kelasdosen);
            $keladdes = $kelasdata['fullname']." (".$kelasdata['shortname'].") - ".strtoupper($kelasdata['jadwal'])." - ".$kelasdosen;
        }else{
            $dataenrol = getdatamahasiswaenrol($kelasid);
            $keladdes = $kelasdata['fullname']." (".$kelasdata['shortname'].") - ".strtoupper($kelasdata['jadwal']);
        }

        echo "
            <table class='table' id='table0' class='table2excel'>
                <thead>
                    <tr>
                        <td colspan='2'>Kelas</td>
                        <td colspan='8'>: ".$keladdes."</td>
                    </tr>
                    <tr>
                        <td colspan='2'>Periode</td>
                        <td colspan='8'> :".$kelasdata['nama_periode']."</td>
                    </tr>
                    <tr>
                        <td colspan='2'>Laboratorium</td>
                        <td colspan='8'> :".$kelasdata['nama_laboratorium']."</td>
                    </tr>
                    <tr>
                        <td colspan='2'>Pertemuan</td>
                        <td colspan='8'> :Minggu ".$week."</td>
                    </tr>
                    <tr>
                        <th colspan='3'>NPM</th>
                        <th colspan='5'>NAMA</th>
                        <th colspan='2'>KEHADIRAN</th>
                    </tr>
                </thead>
                <tbody>
        ";

        while($rowdataenrol = $dataenrol -> fetch_assoc()){

            $cekabsensi = cekabsensibyusername($kelasid, $week, $rowdataenrol['username']);

            if($cekabsensi['Jumlah'] > 0){
                $status = "Hadir";
            }else{
                $status = "Tidak hadir";
            }
            echo "
                        <tr>
                            <td colspan='3'>".$rowdataenrol['username']."</td>
                            <td colspan='5'>".$rowdataenrol['firstname']."</td>
                            <td colspan='2'>".$status."</td>
                        </tr>
            ";
        }
        echo "
                </tbody>
                </table>
        ";

        echo "
            <div class='Absensi_".$kelasdata['fullname']."_".$kelasdata['jadwal']."_".$kelasdata['nama_periode']."' id='judul'>
            </div>
        ";
        echo "
            <div class='0' id='counttables'>
            </div>
        ";
        
        echo "
            <div class='".LINK_kelas_nav($kelasid, "absen")."' id='linkback'>
            </div>
        ";

        echo "
            <div class='yes' id='rollback'>
            </div>
         ";
         
    }

    function downloadlaporan(){
        Global $S_username, $kelasid, $week, $rollback;

        $laboratoriumid = $_GET['lbrid'];
        $periodeid = $_GET['prdid'];
        $laboratoriumdata = getlaboratoriumbyid($laboratoriumid);
        $periodedata = getperiodebyid($periodeid);

        $datakelaslab = getkodekelasbylabandperiode($laboratoriumid, $periodeid);
        $tablenote=0;

        while($rowdatakelaslab = $datakelaslab -> fetch_assoc()){
            $datakelasdosen = getkelasdoseninkelaskode($rowdatakelaslab['kelas_kode']);
            $datakelas = getsimplekelasbyid($rowdatakelaslab['kelas_kode']);
            while($rowdatakelasdosen = $datakelasdosen -> fetch_assoc()){ 
                echo "
                        <table class='table' id='table".$tablenote."' class='table2excel'>
                            <thead>
                                <tr>
                                    <td colspan='2' class='border border-0'>Periode</td>
                                    <td colspan='8' class='border border-0'>: ".$periodedata['nama_periode']."</td>
                                </tr>
                                <tr>
                                    <td colspan='2' class='border border-0'>Laboratorium</td>
                                    <td colspan='8' class='border border-0'>: ".$laboratoriumdata['nama_laboratorium']."</td>
                                </tr>
                                <tr>
                                    <td colspan='10' class='border border-0'>Laporan Keseluruhan</td>
                                </tr>
                            <thead>
                ";
                $datadosenkelas = getdosenonkelasdosen($rowdatakelaslab['kelas_kode'], $rowdatakelasdosen['kelas_dosen']);
                $normalisasidatadosen = $datadosenkelas['firstname'];

                if($normalisasidatadosen == NULL){
                    $namadosen = "Tidak ada";
                }else{
                    $namadosen = $normalisasidatadosen;
                }

                echo "
                    <thead>
                        <tr style='height: 50px'>
                            <td colspan='10' data-fill-color='000000' class='border border-0'></td>
                        </tr>
                        <tr>
                            <td colspan='2' class='border border-0'>kelas</td>
                            <td colspan='8' class='border border-0'>: ".$datakelas['fullname']." - ".ucfirst($datakelas['jadwal'])." (".ucfirst($rowdatakelasdosen['kelas_dosen']).")</td>
                        </tr>
                        <tr>
                            <td colspan='2' class='border border-0'>Dosen</td>
                            <td colspan='8' class='border border-0'>: ".$namadosen."</td>
                        </tr>
                         <tr>
                            <td colspan='10' class='border border-0'></td>
                        </tr>
                        <tr>
                            <th colspan='3'>NPM</th>
                            <th colspan='5'>NAMA</th>
                            <th colspan='1'>NILAI</th>
                            <th colspan='1'>ABJAD</th>
                        </tr>
                    </thead>
                    <tbody>
                ";

                $datamahasiswa = getdatamahasiswaenrolbykelasdosen($rowdatakelaslab['kelas_kode'], $rowdatakelasdosen['kelas_dosen']);

                while($rowdatamahasiswa = $datamahasiswa -> fetch_assoc()){
                    echo "
                        <tr>
                            <td colspan='3'>".$rowdatamahasiswa['username']."</td>
                            <td colspan='5'>".$rowdatamahasiswa['firstname']."</td>
                            <td colspan='1'>".$rowdatamahasiswa['nilai_all']."</td>
                            <td colspan='1'>".nilaiToabjad($rowdatamahasiswa['nilai_all'])."</td>
                        </tr>
                    ";
                }

                echo "</tbody></table><div class='".$datakelas['shortname']."-(".ucfirst($rowdatakelasdosen['kelas_dosen']).")' id='sheet".$tablenote."'></div>";
                $tablenote++;
            }
        }

        echo "
            <div class='Laporan_".$laboratoriumdata['nama_laboratorium']."_".$periodedata['nama_periode']."' id='judul'>
            </div>
        ";
        echo "
            <div class='$tablenote' id='counttables'>
            </div>
        ";
        echo "
            <div class='".LINK_laporanlaboratoriumketualab($laboratoriumid)."' id='linkback'>
            </div>
        ";
        echo "
            <div class='yes' id='rollback'>
            </div>
        ";

        
    }

    function downloadnilai(){
        Global $S_username, $kelasid, $week, $rollback;
        
        $kelasidnilai = $_GET['klsid'];
        $kelasdosennilai = $_GET['klsdos'];
        $datakelas = getsimplekelasbyid($kelasidnilai);
        $periodedata = getperiodebyid($datakelas['periode_kode']);
        $laboratoriumdata = getlaboratoriumbyid($datakelas['laboratorium_kode']);

        echo "
            <table class='table' id='table0' class='table2excel'>
                <thead>
                    <tr>
                        <td colspan='2' class='border border-0'>Periode</td>
                        <td colspan='8' class='border border-0'>: ".$periodedata['nama_periode']."</td>
                    </tr>
                    <tr>
                        <td colspan='2' class='border border-0'>Laboratorium</td>
                        <td colspan='8' class='border border-0'>: ".$laboratoriumdata['nama_laboratorium']."</td>
                    </tr>
                    <tr>
                        <td colspan='10' class='border border-0'>Nilai Kelas ".$datakelas['fullname']." - ".$datakelas['jadwal']." - ".strtoupper($kelasdosennilai)."</td>
                    </tr>
                </thead>
                 <thead>
                    <tr>
                        <th colspan='2'>NPM</th>
                        <th colspan='5'>NAMA</th>
                        <th colspan='1'>KELAS</th>
                        <th colspan='1'>NILAI</th>
                        <th colspan='1'>ABJAD</th>
                    </tr>
                </thead>
            <tbody>
        ";
        $datanilai = downloadnilaikelas($kelasidnilai, $kelasdosennilai);

        while($rowdatanilai = $datanilai -> fetch_assoc()){
            echo "
                <tr>
                    <td colspan='2'>".$rowdatanilai['username']."</td>
                    <td colspan='5'>".$rowdatanilai['firstname']."</td>
                    <td colspan='1'>".strtoupper($rowdatanilai['kelas_dosen'])."</td>
                    <td colspan='1'>".$rowdatanilai['nilai_all']."</td>
                    <td colspan='1'>".nilaiToabjad($rowdatanilai['nilai_all'])."</td>
                </tr>
            ";
        }
        echo "</tbody></table>";

        echo "
            <div class='Nilai_".$datakelas['fullname']."_".$datakelas['jadwal']."_".strtoupper($kelasdosennilai)."_".$periodedata['nama_periode']."' id='judul'>
            </div>
        ";
        echo "
            <div class='0' id='counttables'>
            </div>
        ";
        echo "
            <div class='".LINK_kelas_nav($kelasidnilai, "nilai")."' id='linkback'>
            </div>
        ";
        echo "
            <div class='yes' id='rollback'>
            </div>
        ";
    } 

    function contentdownload(){
        Global $absensi, $laporan, $nilai;

        $kode_excel = isset($_GET['kode']) ? $_GET['kode'] : 'null';

        if($kode_excel != "null"){
            if($absensi == "yes"){
                downloadabsensi();
            }
            if($laporan == "yes"){
                downloadlaporan();
            }
            if($nilai == "yes"){
                downloadnilai();
            }
        }else{
            echo "eror";
        }
    }    
?>