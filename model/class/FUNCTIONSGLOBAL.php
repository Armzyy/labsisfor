<?php

    function now_timestamp(){
        $conv_now = strtotime(date('y-m-d'));  
        $now_new = date ('y-m-d', $conv_now);  
        $now_real = strtotime($now_new);

        return $now_real;
    }

    function conv_timestamp($valuets){
        $conv_ts = strtotime($valuets);  
        $conv_new = date ('y-m-d', $conv_ts);
        $conv_ts_real = strtotime($conv_new);

        return $conv_ts_real;
    }

    function conv_timestamp_time($valuets){
        $conv_ts = strtotime($valuets);  
        $conv_new = date ('H:i', $conv_ts);
        $conv_ts_real = strtotime($conv_new);

        return $conv_ts_real;
    }

    function conv_date($valuedt){
        $conv_dt = date ('d F Y', $valuedt);

        return $conv_dt;
    }

    function conv_time($valuedt){
        $conv_dt = date ('H:i', $valuedt);

        return $conv_dt;
    }

    function make_code($code, $valuemc){
        $kode = $code . sprintf("%05s", $valuemc + 1);
        
        return $kode;
    }

    function make_code_varchar($code, $valuemcv){
        $kode = $code . sprintf("%05s", $valuemcv);
        
        return $kode;
    }

    function date_id($tanggal){
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);
        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }

    function namerole($roleasli){
        if($roleasli == "admin"){
            $rolekelas = "Admin Lab";
        }else if($roleasli == "ketualab"){
            $rolekelas = "Ketua Lab";
        }else if($roleasli == "kooraslab"){
            $rolekelas = "Koor Aslab";
        }else if($roleasli == "koorpraktikum"){
            $rolekelas = "Koor Praktikum";
        }else if($roleasli == "aslab"){
            $rolekelas = "Asisten Lab";
        }else if($roleasli == "dosen"){
            $rolekelas = "Dosen Pengampu";
        }else if($roleasli == "KLDS"){
            $rolekelas = "Ketua Lab & Dosen Pengampu";
        }else if($roleasli == "KAMS"){
            $rolekelas = "Koor Aslab & Mahasiswa";
        }else if($roleasli == "KPMS"){
            $rolekelas = "Koor Praktikum & Mahasiswa";
        }else if($roleasli == "MHAS"){
            $rolekelas = "Asisten Lab & Mahasiswa";
        }else{
            $rolekelas = "Mahasiswa";
        }

        return $rolekelas;
    }

    function nilaiToabjad($nilai){
        if(($nilai <= 100) && ($nilai > 90)){
            $abjad = "A+";
        }else if(($nilai <= 90) && ($nilai > 85)){
            $abjad = "A";
        }else if(($nilai <= 85) && ($nilai > 79)){
            $abjad = "A-";
        }else if(($nilai <= 79) && ($nilai > 75)){
            $abjad = "B+";
        }else if(($nilai <= 75) && ($nilai > 72)){
            $abjad = "B";
        }else if(($nilai <= 72) && ($nilai > 65)){
            $abjad = "B-";
        }else if(($nilai <= 65) && ($nilai > 60)){
            $abjad = "C+";
        }else if(($nilai <= 60) && ($nilai > 50)){
            $abjad = "C";
        }else{
            $abjad = "E";
        }

        return $abjad;
    }

    function log_activitycode($code){
        if($code == 1){
            $aktifitas = "Melakukan aktifitas perubahan nama periode.";
        }else if($code == 2){
            $aktifitas = "Melakukan aktifitas perubahan status periode.";
        }else if($code == 3){
            $aktifitas = "Melakukan aktifitas perubahan format nilai.";
        }

        return $aktifitas;
    }