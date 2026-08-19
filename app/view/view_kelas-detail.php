<?php 
    
        echo "

            <div class='container-fluid' id='container-wrapper'>
                <div class='d-sm-flex align-items-center justify-content-between'>
                    <h1 class='h3 mb-0 text-gray-800'>".$nama_kelas." - ".ucwords($jadwal)." - ".strtoupper($kelas_dosenn["kelas_dosen"])."</h1>
                    <ol class='breadcrumb'>
                        <li class='breadcrumb-item'><a href='index.php'>E-Laboratorium</a></li>
                        <li class='breadcrumb-item'><a href='index.php'>Dashboard</a></li>
        ";
            if($statuskelas == 'Non-Aktif'){
                echo "<li class='breadcrumb-item'><a href='".$LINK_riwayatkelas."'>Riwayat Praktikum</a></li>";
            }
            if($S_rolestatus == 'admin'){
                echo "<li class='breadcrumb-item'><a href='".$LINK_semuakelas."'>Semua Kelas</a></li>";
            }
        echo "
                        <li class='breadcrumb-item active' aria-current='page'>".$getclassid."</li>
                </div>
                <div class='d-sm-flex align-items-center justify-content-between mb-4'>
                    <h6>Terdaftar sebagai <span class='badge badge-primary'>".strtoupper($showrolekelas)."</span></h6>
                </div>
                <div class='col-xl-12 col-lg-12'>
        ";

    if($masukkelas == "Yes"){
        if(isset($headerkelas)){
            echo $headerkelas;
        }
        
        echo $btneditkelas;
        echo $btninputjadwalasistensi;

        if(isset($alert)){
            echo $alert;
        }

        echo $alertmodul;
        
        echo "
            </div>
            <div class='col-xl-12 col-lg-12 '>
                ".nav()."
                ".content()."
            </div>
        </div>";
    }else{
        echo "
            <div class='card'>
                <img src='".$__asset."images/lock2.png' class='card-img-top' style='height:200px; object-fit: cover;'>
                <div class='card-body'>
                    <h5 class='card-title'>Kelas Terkunci</h5>
                    <p class='card-text'>Harap lengkapi persyataran berikut :</p>
                    <ol>
        ";
        if($syaratkelascount['Jumlah'] == 0){
            echo "
                    <li>Lakukan pengumpulan <strong>kwitansi pembayaran praktikum (Kertas Kuning)</strong> kepada asisten laboratorium praktikum terkait.</li>
                    <li>Lakukan pengumpulan <strong>pas foto 3x4</strong> kepada asisten laboratorium praktikum terkait dan mendapatkan <strong>stempel laboratororium sistem informasi</strong>.</li>
                ";
        }else{
            if($syaratkelas['pengumpulan_kwitansi'] == "No"){
                echo "
                    <li>Lakukan pengumpulan <strong>kwitansi pembayaran praktikum (Kertas Kuning)</strong> kepada asisten laboratorium praktikum terkait.</li>
                ";
            }
            if($syaratkelas['pengumpulan_foto'] == "No"){
                echo "
                    <li>Lakukan pengumpulan <strong>pas foto 3x4</strong> kepada asisten laboratorium praktikum terkait dan mendapatkan <strong>stempel laboratororium sistem informasi</strong>.</li>
                ";
            }
        }
        
        echo "
                    </ol>
                    <p class='card-text'>Jika ada kesalahan data yang ditampilkan harap hubungi <a href='https://wa.me/62".$arraygetdataadmin['phone']."' target='_blank' class='text-info'>Admin Laboratorium.</a></p>
                    <a href='mahasiswa' class='btn btn-primary'>Kembali Ke Home</a>
                </div>
            </div>
        ";
    }

    
?>