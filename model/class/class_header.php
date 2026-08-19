<?php
    include "config.php";
    
    $HEADER_background = "";
    $SIDEBAR_background = "";

    if($S_rolestatus == "admin"){
        $HEADER_background = "admin-background";
        $SIDEBAR_background = "sidebar-admin-background";
    }
    else if($S_rolestatus == "mahasiswa"){
        $HEADER_background = "mahasiswa-background";
        $SIDEBAR_background = "sidebar-mahasiswa-background";
    }
    else if($S_rolestatus == "ketualab"){
        $HEADER_background = "ketua-lab-background";
        $SIDEBAR_background = "sidebar-ketua-lab-background";
    }
    else if($S_rolestatus == "dosen"){
        $HEADER_background = "dosen-background";
        $SIDEBAR_background = "sidebar-dosen-background";
    }
    else if($S_rolestatus == "kooraslab"){
        $HEADER_background = "aslab-background";
        $SIDEBAR_background = "sidebar-aslab-background";
    }
    else{
        $HEADER_background = "mahasiswa-backgorund";
        $SIDEBAR_background = "sidebar-mahasiswa-background";
    }

    $SQL_getprofilepict = "SELECT picture FROM user WHERE username = '$S_username'";
    $getprofilepict = mysqli_query($db, $SQL_getprofilepict);
    $profilepicture = mysqli_fetch_array($getprofilepict);

    if($profilepicture['picture'] == "user"){
        $pp = $__asset."/profile_img/".$profilepicture['picture'].".png";
    }else{
        $pp = $profilepicture['picture'];
    }
    
    
    function getnameuser(){
        Global $db, $S_username, $S_rolestatus;

        $SQl_name = "SELECT * FROM user WHERE username = '$S_username'";
        $name = mysqli_query($db, $SQl_name);
        $resultname = mysqli_fetch_array($name);

        if(($S_rolestatus == "ketualab")||($S_rolestatus == "dosen")){
            echo $resultname['firstname'];
        }else{
            echo $resultname['firstname'];
        }
    }

    function showkelas(){
        Global $db, $S_username, $S_rolestatus;
        
        $getheader = getuserenrolshortnameD($S_username);

        while($rowheader = $getheader -> fetch_assoc()){

            if($rowheader['Jumlah'] > 0){
                echo "
                    <div class='sidebar-heading my-1 text-info'>
                        ⸻  &nbsp ".$rowheader['shortname']." &nbsp  ⸻
                    </div>
                ";
            }

            $getdatalist = getlinkenrolkelasbyshortname($S_username, $rowheader['shortname']);

            while($rowlist = $getdatalist -> fetch_assoc()){
                echo "
                    <li class='nav-item'>
                        <a class='nav-link collapsed' href='".LINK_kelas($rowlist['kelas_kode'])."' aria-expanded='true'>
                        <i class='fa fa-university text-primary'></i>
                        <span>".$rowlist['shortname']." - ".$rowlist['jadwal']." - ".$rowlist['nama_periode']."</span>
                        </a>
                    </li>
                ";
            }
        }
        

        
    }

    function showlab(){
        Global $db, $S_username, $S_rolestatus;

        $SQL_getlabsidebar = "SELECT * FROM laboratorium WHERE kepala_laboratorium = '$S_username'";
        $getlabsidebar = mysqli_query($db, $SQL_getlabsidebar);

        while($resultgetlabsidebar = $getlabsidebar -> fetch_assoc()){
            $idlab = $resultgetlabsidebar['laboratorium_kode'];
            echo "<a class='collapse-item text-wrap' href='".LINK_laboratoriumketualab($idlab)."'>".$resultgetlabsidebar['nama_laboratorium']."</a>";
            echo "<a class='collapse-item text-wrap' href='".LINK_laporanlaboratoriumketualab($idlab)."'>Laporan Laboratorium</a>";
        }
    }

    function linklab(){
        Global $S_rolestatus, $LINK_laboratoriumadmin;

        if(($S_rolestatus == "admin") || ($S_rolestatus == "ketualab")){
            echo "
                <li class='nav-item'>
                    <a class='nav-link collapsed' href='#' data-toggle='collapse' data-target='#collapselaboratorium'
                    aria-expanded='true' aria-controls='collapselaboratorium'>
                    <i class='far fa-fw fa-building'></i>
                    <span>Laboratorium</span>
                    </a>
                    <div id='collapselaboratorium' class='collapse' aria-labelledby='headinglaboratorium' data-parent='#accordionSidebar'>
                    <div class='bg-white py-2 collapse-inner rounded'>
            ";

                        if($S_rolestatus == 'admin'){
                            echo "<a class='collapse-item' href='".$LINK_laboratoriumadmin."'>Data Laboratorium</a>";
                        }
                        if($S_rolestatus == 'ketualab'){
                            showlab();
                        }
            echo "
                    </div>
                    </div>
                </li>
            ";
        }
    }

    function showpraktikumdropdown(){
        Global $S_rolestatus, $LINK_periode, $LINK_praktikum, $LINK_kelastambah, $LINK_riwayatkelas, $LINK_semuakelas;
        echo  "
            <li class='nav-item'>
            <a class='nav-link collapsed' href='#' data-toggle='collapse' data-target='#collapseForm' aria-expanded='true'
                aria-controls='collapseForm'>
                <i class='fab fa-fw fa-wpforms'></i>
                <span>Praktikum Aktif</span>
            </a>
            <div id='collapseForm' class='collapse' aria-labelledby='headingForm' data-parent='#accordionSidebar'>
                <div class='bg-white py-2 collapse-inner rounded'>";
                    if(($S_rolestatus == 'admin') || ($S_rolestatus == 'ketualab')){echo "<a class='collapse-item' href='".$LINK_periode."'>Periode</a>";}
                    if(($S_rolestatus == 'admin') || ($S_rolestatus == 'kooraslab')){echo "<a class='collapse-item' href='".$LINK_praktikum."'>Nama Praktikum</a>";}
                    if(($S_rolestatus == 'admin') || ($S_rolestatus == 'kooraslab')){echo "<a class='collapse-item' href='".$LINK_kelastambah."'>Tambah Kelas Praktikum</a>";}
                    if(($S_rolestatus == 'kooraslab') || ($S_rolestatus == 'ketualab')){echo "<a class='collapse-item' href='".$LINK_riwayatkelas."'>Kelas Praktikum aktif</a>";}
                    if($S_rolestatus == 'admin'){echo "<a class='collapse-item' href='".$LINK_semuakelas."'>Semua Kelas Praktikum</a>";}
        echo "  </div>
            </div>
        </li>
        ";
    }
    function linkuser(){
        Global $S_rolestatus, $LINK_user;

        if($S_rolestatus == "admin"){
            echo "
                <li class='nav-item'>
                    <a class='nav-link collapsed' href='#' data-toggle='collapse' data-target='#collapseuser' aria-expanded='true'
                    aria-controls='collapseuser'>
                    <i class='fas fa-fw fa-table'></i>
                    <span>User</span>
                    </a>
                    <div id='collapseuser' class='collapse' aria-labelledby='headinguser' data-parent='#accordionSidebar'>
                    <div class='bg-white py-2 collapse-inner rounded'>
                        <h6 class='collapse-header'>Tentang User</h6>
                        <a class='collapse-item' href= '".$LINK_user."'>Upload User</a>
                    </div>
                    </div>
                </li>
            ";
        }
    }
    
?>