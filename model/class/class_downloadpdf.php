<?php
    // ignore Undefined type 'Dompdf\Dompdf'.
    
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

    
    $link = "http://localhost/e-laboratorium/mahasiswa?page=downloadpdf&kode=absensi&klsid=KLS00001&week=1";

    // =============================================== Security check

    require_once ($__asset."vendor/dompdf/autoload.inc.php");
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();
    
    function pdfabsensi(){
        Global $S_username, $kelasid, $week, $dompdf;

        $kelasid = $_GET['klsid'];
        $week = $_GET['week'];
        $kelasdata = getkelasbyid($kelasid);
        
        $htmlabsensi1 = "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Document</title>
            </head>
            <body>
                <table border='0' style='width:100%;'>
                    <thead>
                        <tr>
                            <td colspan='2' class='border border-0'>Kelas</td>
                            <td colspan='8' class='border border-0'>: ".$kelasdata['fullname']." (".$kelasdata['shortname'].") - ".strtoupper($kelasdata['jadwal'])."</td>
                        </tr>
                        <tr>
                            <td colspan='2' class='border border-0'>Periode</td>
                            <td colspan='8' class='border border-0'>: ".$kelasdata['nama_periode']."</td>
                        </tr>
                        <tr>
                            <td colspan='2' class='border border-0'>Laboratorium</td>
                            <td colspan='8' class='border border-0'>: ".$kelasdata['nama_laboratorium']."</td>
                        </tr>
                        <tr>
                            <td colspan='2' class='border border-0'>Pertemuan</td>
                            <td colspan='8' class='border border-0'>: ".$week."</td>
                        </tr>
                        <tr style='height: 50px'>
                            <td colspan='10' class='border border-0'></td>
                        </tr>
                        <tr>
                            <td class='bg-dark text-dark' colspan='10'></td>
                        </tr>
                    </thead>
                </table>
                <hr>
                <table border='1' style='width:100%; border-collapse: collapse;'>
                    <thead>
                        <tr>
                            <th colspan='3' class='border border-1'>NPM</th>
                            <th colspan='5' class='border border-1'>NAMA</th>
                            <th colspan='2' class='border border-1'>KEHADIRAN</th>
                        </tr>
                    </thead>
                    <tbody>
        ";

        $dataenrol = getdatamahasiswaenrol($kelasid);
        $jmldata = countdatamahasiswaenrol($kelasid);
        $outdata = 0;
        $htmlabsensi2 = "";
        while($rowdataenrol = $dataenrol -> fetch_assoc()){

            $cekabsensi = cekabsensibyusername($kelasid, $week, $rowdataenrol['username']);

            if($cekabsensi['Jumlah'] > 0){
                $status = "Hadir";
            }else{
                $status = "Tidak hadir";
            }

            if($outdata < 1){
                $htmlabsensi2 = "
                    <tr>
                        <td colspan='3' class='border border-1'>".$rowdataenrol['username']."</td>
                        <td colspan='5' class='border border-1'>".$rowdataenrol['firstname']."</td>
                        <td colspan='2' class='border border-1'>".$status."</td>
                    </tr>
                ";
            }else{
                $htmlabsensi2 = $htmlabsensi2."
                    <tr>
                        <td colspan='3' class='border border-1'>".$rowdataenrol['username']."</td>
                        <td colspan='5' class='border border-1'>".$rowdataenrol['firstname']."</td>
                        <td colspan='2' class='border border-1'>".$status."</td>
                    </tr>
                ";
            }
            $outdata++;
        }

        $htmlabsensi3 = "
                </tbody>
            </table>
            </body>
            </html>
        ";

        $htmlabsensi4 = $htmlabsensi1.$htmlabsensi2.$htmlabsensi3;

        $originalString = $kelasdata['nama_periode'];
        $search = "/";
        $replace = "_";
        $newString = str_replace($search, $replace, $originalString);

        $judul = $kelasdata['shortname']."_".$week."_".$kelasdata['jadwal']."_".$newString.".pdf";
        $dompdf->loadHtml($htmlabsensi4);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream($judul);
    }

    function pdflaporan(){
        Global $S_username, $kelasid, $week, $dompdf;

        $laboratoriumid = $_GET['lbrid'];
        $periodeid = $_GET['prdid'];
        $datalaboratorium = getlaboratoriumbyid($laboratoriumid);
        $dataperiode = getperiodebyid($periodeid);

        $htmllaporan1 = "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Document</title>
            </head>
            <body>
                <table border='0' style='width:100%;'>
                    <thead>
                        <tr>
                            <td colspan='2' class='border border-0'>Periode</td>
                            <td colspan='8' class='border border-0'>: ".$dataperiode['nama_periode']."</td>
                        </tr>
                        <tr>
                            <td colspan='2' class='border border-0'>Laboratorium</td>
                            <td colspan='8' class='border border-0'>: ".$datalaboratorium['nama_laboratorium']."</td>
                        </tr>
                        <tr style='height: 50px'>
                            <td colspan='10' class='border border-0'>Laporan Keseluruhan</td>
                        </tr>
                        <tr>
                            <td class='bg-dark text-dark' colspan='10'></td>
                        </tr>
                    </thead>
                </table>
        ";

        $datakelas = getkodekelasbylabandperiode($laboratoriumid, $periodeid);
        $htmllaporan3 = "";
        while($rowdatakelas = $datakelas ->fetch_assoc()){
            $datakelassimple = getsimplekelasbyid($rowdatakelas['kelas_kode']);
            $datakelasdosen = getkelasdoseninkelaskode($rowdatakelas['kelas_kode']);
            $htmllaporan4 = "";
            while($rowdatakelasdosen = $datakelasdosen -> fetch_assoc()){

                $datadosenkelas = getnamadosenbykelasidandkelasdosen($rowdatakelas['kelas_kode'], $rowdatakelasdosen['kelas_dosen']);

                $htmllaporan4 = $htmllaporan4."
                    <hr style='background-color:black; height:10px;'>
                        <table border='0' style='width:100%; break-after:page;'>
                            <thead>
                                <tr>
                                    <td colspan='2' class='border border-0'>Kelas</td>
                                    <td colspan='8' class='border border-0'>: ".$datakelassimple['fullname']." - ".$datakelassimple['jadwal']." - ".strtoupper($rowdatakelasdosen['kelas_dosen'])."</td>
                                </tr>
                                <tr>
                                    <td colspan='2' class='border border-0'>Dosen</td>
                                    <td colspan='8' class='border border-0'>: ".$datadosenkelas."</td>
                                </tr>
                            </thead>
                        </table>
                        <div style='margin-top:2px; margin-bottom:2px;'>
                        </div>
                        <table border='1' style='width:100%; border-collapse: collapse;'>
                            <thead>
                                <tr>
                                    <th colspan='3' class='border border-1'>NPM</th>
                                    <th colspan='5' class='border border-1'>NAMA</th>
                                    <th colspan='1' class='border border-1'>KELAS</th>
                                    <th colspan='1' class='border border-1'>NILAI</th>
                                    <th colspan='1' class='border border-1'>ABJAD</th>
                                </tr>
                            </thead>
                            <tbody>
                ";

                $datamahasiswa = getdatamahasiswaenrolbykelasdosen($rowdatakelas['kelas_kode'], $rowdatakelasdosen['kelas_dosen']);
                while($rowdatamahasiswa = $datamahasiswa ->fetch_assoc()){
                    $htmllaporan4 = $htmllaporan4."      
                        <tr>
                            <td colspan='3' style='text-align: center;'>".$rowdatamahasiswa['username']."</td>
                            <td colspan='5'><span style='margin-left:5px;'>".$rowdatamahasiswa['firstname']."</span></td>
                            <td colspan='1' style='text-align: center;'>".$rowdatamahasiswa['kelas_dosen']."</td>
                            <td colspan='1' style='text-align: center;'>".$rowdatamahasiswa['nilai_all']."</td>
                            <td colspan='1' style='text-align: center;'>".nilaiToabjad($rowdatamahasiswa['nilai_all'])."</td>
                        </tr>
                    ";   
                }

                $htmllaporan4 = $htmllaporan4."
                            </tbody>
                        </table>
                        <div style='page-break-before: always;'></div>
                ";
            }
            $htmllaporan3 = $htmllaporan3.$htmllaporan4;
        }

        $htmllaporan7 = "</body></html>";

        $htmllaporanfinal = $htmllaporan1.$htmllaporan3.$htmllaporan7;

        $originalString = $dataperiode['nama_periode'];
        $search = "/";
        $replace = "_";
        $newString = str_replace($search, $replace, $originalString);

        $judul = "Laporan_".$datalaboratorium['nama_laboratorium']."_".$newString.".pdf";
        $dompdf->loadHtml($htmllaporanfinal);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream($judul);
    }

    function pdfnilai(){
        Global $S_username, $kelasid, $week, $dompdf;

        $kelasidnilai = $_GET['klsid'];
        $kelasdosennilai = $_GET['klsdos'];
        $datakelas = getsimplekelasbyid($kelasidnilai);
        $periodedata = getperiodebyid($datakelas['periode_kode']);
        $laboratoriumdata = getlaboratoriumbyid($datakelas['laboratorium_kode']);

        $htmlnilai1 = "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Document</title>
            </head>
            <body>
                <table border='0' style='width:100%;'>
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
                </table>
                <div style='margin-top:5px'>
                </div>
                <table border='1' style='width:100%; border-collapse: collapse;'> 
                    <thead>
                        <tr>
                            <td class='bg-dark text-dark' colspan='10' style='background-color:black;height: 10px'></td>
                        </tr>
                        <tr>
                            <th colspan='2' class='border border-0' style='font-weight: bold;'>NPM</th>
                            <th colspan='5' class='border border-0' style='font-weight: bold;'>NAMA</th>
                            <th colspan='1' class='border border-0' style='font-weight: bold;'>KELAS</th>
                            <th colspan='1' class='border border-0' style='font-weight: bold;'>NILAI</th>
                            <th colspan='1' class='border border-0' style='font-weight: bold;'>ABJAD</th>
                        </tr>
                    </thead>
                    <tbody>
        ";

        $datanilai = downloadnilaikelas($kelasidnilai, $kelasdosennilai);

        while($rowdatanilai = $datanilai -> fetch_assoc()){
            $htmlnilai1 = $htmlnilai1."
                            <tr>
                                <td colspan='2' class='border border-0' style='text-align: center;'>".$rowdatanilai['username']."</td>
                                <td colspan='5' class='border border-0'><span style='margin-left:5px;'>".$rowdatanilai['firstname']."</span></td>
                                <td colspan='1' class='border border-0' style='text-align: center;'>".strtoupper($rowdatanilai['kelas_dosen'])."</td>
                                <td colspan='1' class='border border-0' style='text-align: center;'>".$rowdatanilai['nilai_all']."</td>
                                <td colspan='1' class='border border-0' style='text-align: center;'>".nilaiToabjad($rowdatanilai['nilai_all'])."</td>
                            </tr>
            ";
        }

        $htmlnilai1 = $htmlnilai1."</tbody></table></body></html>";
        $originalString = $periodedata['nama_periode'];
        $search = "/";
        $replace = "_";
        $newString = str_replace($search, $replace, $originalString);

        $judul = "Data_Nilai_".$datakelas['fullname']."_".$datakelas['jadwal']."_".strtoupper($kelasdosennilai)."_".$newString.".pdf";
        $dompdf->loadHtml($htmlnilai1);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream($judul);
    }

    function contentdownload(){
        Global $absensi, $laporan, $nilai;

        $kode_excel = isset($_GET['kode']) ? $_GET['kode'] : 'null';

        if($kode_excel != "null"){
            if($absensi == "yes"){
                pdfabsensi();
            }
            if($laporan == "yes"){
                pdflaporan();
            }
            if($nilai == "yes"){
                pdfnilai();
            }
        }else{
            echo "eror";
        }
    }

    contentdownload();

?>