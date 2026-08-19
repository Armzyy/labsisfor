<?php
    include 'config.php';
    
    // =============================================== Security check
    if(!isset($_SESSION['session_username'])){
        header('location: login');
        exit();
    }

    if(($S_rolestatus != "admin") && ($S_rolestatus != "ketualab") && ($S_rolestatus != "KLDS")){
        header('location: 404');
    }
    
    $idlab = $getkode = isset($_GET['id']) ? $_GET['id'] : 'null';

    if($idlab == "null"){
        header('location: 404');
    }else{
        $labada = getlaboratoriumexist($idlab);
        $kalabada = getlaboratoriumbyidkalab($S_username);

        if($labada['Jumlah'] == 0){
            header('location: 404');
        }else if($kalabada['laboratorium_kode'] != $idlab){
            header('location: 404');
        }
    }
    // =============================================== Security check

    function showlaporan(){
        Global $getperiodedata3, $kalabada, $LINK_downloadexcel, $LINK_downloadpdf, $idlab;

        while($rowdataperiode = $getperiodedata3->fetch_assoc()){

            $datakelas = getkelasdatabylabandperiode($kalabada['laboratorium_kode'], $rowdataperiode['periode_kode']);

            echo "
                <div class='card mt-3'>
                    <div class='card-header'>
                        Periode ".$rowdataperiode['nama_periode']."
                    </div>
                    <div class='card-body'>
                        <h5 class='card-title'>Laporan ".$kalabada['nama_laboratorium']."</h5>
                        <p class='card-text'>Kelas Terdaftar :
            ";
            $countend = 0;
            while($rowdatakelas = $datakelas -> fetch_assoc()){
                if($countend == 0){
                    echo $rowdatakelas['shortname']."-".ucwords($rowdatakelas['jadwal']);
                }else{
                    echo ", ".$rowdatakelas['shortname']."-".ucwords($rowdatakelas['jadwal']);
                }
                $countend++;
            }
            echo "
                        </p>
                        <div class='mt-3'>
                            <a href='".$LINK_downloadexcel."&kode=laporan&lbrid=".$kalabada['laboratorium_kode']."&prdid=".$rowdataperiode['periode_kode']."' class='btn btn-success'>Download Excel <i class='fa fa-file-excel ml-1' aria-hidden='true'></i></a>
                            <a href='".$LINK_downloadpdf."&kode=laporan&lbrid=".$kalabada['laboratorium_kode']."&prdid=".$rowdataperiode['periode_kode']."' class='btn btn-danger ml-2'>Download PDF <i class='fa fa-file-pdf ml-1' aria-hidden='true'></i></a>
                        </div>
                    </div>
                </div>
            ";
        }
    }
?>