<?php
    $kelas_kode = $_GET['id'];

    if(isset($_POST['tambahmodul'])){
        $jml_modul = $_POST['jmlmodul'];

        header('location: '.$S_rolestatus.'?page=modul&id='.$kelas_kode.'&modul='.$jml_modul.'');
    }

    if(isset($_POST['gantimodul'])){
        header('location: '.$S_rolestatus.'?page=modul&id='.$kelas_kode.'');
    }

    if(isset($_GET['modul'])){
        $modul = $_GET['modul'];
        $imputjmlmodul = "
            <label for='#jmlmodul'>Jumlah Modul <span class='text-danger'><b>*</b></span></label>
            <div class='input-group' id='clockPicker3'>
                <select class='jmlmodul form-control' name='jmlmodul' id='jmlmodul' disabled>
                    <option value=''>".$modul."</option>
                </select>                  
                <div class='input-group-append'>
                    <input type='submit' name='gantimodul' class='btn btn-success' value='Ganti Modul'>
                </div>                      
            </div>
        ";
    }else{
        $imputjmlmodul = "
            <label for='#jmlmodul'>Jumlah Modul <span class='text-danger'><b>*</b></span></label>
            <div class='input-group' id='clockPicker3'>
                <select class='jmlmodul form-control' name='jmlmodul' id='jmlmodul' required>
                    <option value='1'>1</option>
                    <option value='2'>2</option>
                    <option value='3'>3</option>
                    <option value='4'>4</option>
                    <option value='5'>5</option>
                    <option value='6'>6</option>
                    <option value='7'>7</option>
                    <option value='8'>8</option>
                    <option value='9'>9</option>
                    <option value='10'>10</option>
                </select>                  
                <div class='input-group-append'>
                    <input type='submit' name='tambahmodul' class='btn btn-success' value='Tambah Modul'>
                </div>                      
            </div>
        ";
    }

    function showsetmodul(){
        Global $db, $kelas_kode;

        if(isset($_GET['modul'])){
            $modul = $_GET['modul'];

            $SQL_getasisten = "SELECT * FROM kelas_enrol WHERE kelas_kode = '$kelas_kode' AND role_kelas = 'aslab'";
            $getasisten = mysqli_query($db, $SQL_getasisten);

            for($i = 1; $i <= $modul; $i++){
                echo "
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-6'>
                                <label for='inputasisten".$i."'><b>Assisten Modul ".$i." </b><span class='text-danger'><b>*</b></span></label>
                                <select class='select2-multiple form-control' name='inputasisten".$i."[]' multiple='multiple' id='inputasisten".$i."' required>
                    ";
                    while($resultgetasisten = $getasisten -> fetch_assoc()){
                        $user = getuserbyusername($resultgetasisten['username']);
                        echo"
                            <option value='".$user['username']."'>".$user['username']." - ".$user['firstname']." ".$user['lastname']."</option>
                        ";
                    }
                echo "
                                </select>
                            </div>
                            <div class='col-6'>
                                <label for='jmlmodul'><b>Sebelum UTS / Sebelum UAS Modul ".$i." </b><span class='text-danger'><b>*</b></span></label>
                                <select class='jmlmodul form-control' name='jmlmodul' id='jmlmodul' required>
                                    <option value=''>Pilih jadwal</option>
                                    <option value='UTS'>Sebelum UTS</option>
                                    <option value='UAS'>Sebelum UAS</option>
                                </select>                  
                            </div>
                        </div>
                    </div>
                ";
            }

            echo "
                <div class='text-xs font-weight-bold mb-1 pt-5'>
                    <input type='submit' name='setmodul' class='col-xl-12 btn btn-sm btn-success' value='Set Modul'>
                </div>
            ";
        } 
    }