<?php
    
    // SQL Get user data
    $SQL_getuserdata = "SELECT * FROM user";
    $getuserdata = mysqli_query($db, $SQL_getuserdata);
    $arraygetuserdata = mysqli_fetch_array($getuserdata);

    // SQL Get user data
    $SQL_getuserdata1 = "SELECT * FROM user";
    $getuserdata1 = mysqli_query($db, $SQL_getuserdata1);

    // SQL Get user dataadmin
    $SQL_getdataadmin = "SELECT * FROM user WHERE role = 'admin'";
    $getdataadmin = mysqli_query($db, $SQL_getdataadmin);
    $arraygetdataadmin = mysqli_fetch_array($getdataadmin);

    // SQL Get user data dosen dan kalab
    $SQL_getuserdatadosen = "SELECT * FROM user WHERE role = 'dosen' OR role = 'ketualab'";
    $getuserdatadosen = mysqli_query($db, $SQL_getuserdatadosen);

    // SQL Get user data mahasiswa dan koorlab
    $SQL_getuserdatakoorlab = "SELECT * FROM user WHERE role = 'kooraslab' OR role = 'mahasiswa'";
    $getuserdatakoorlab = mysqli_query($db, $SQL_getuserdatakoorlab);

    // SQL Get laboratorium data
    $SQL_getlaboratoriumdata = "SELECT * FROM laboratorium";
    $getlaboratoriumdata = mysqli_query($db, $SQL_getlaboratoriumdata);
    $arraygetlaboratoriumdata = mysqli_fetch_array($getlaboratoriumdata);

    // SQL Get laboratorium data
    $SQL_getlaboratoriumdata1 = "SELECT * FROM laboratorium";
    $getlaboratoriumdata1 = mysqli_query($db, $SQL_getlaboratoriumdata1);

    // SQL Get periode data
    $SQL_getperiodedata = "SELECT * FROM periode";
    $getperiodedata = mysqli_query($db, $SQL_getperiodedata);
    $arraygetperiodedata = mysqli_fetch_array($getperiodedata);

    // SQL Get periode data
    $SQL_getperiodedata1 = "SELECT * FROM periode";
    $getperiodedata1 = mysqli_query($db, $SQL_getperiodedata1);

    // SQL Get periode data
    $SQL_getperiodedata2 = "SELECT * FROM periode";
    $getperiodedata2 = mysqli_query($db, $SQL_getperiodedata2);

    // SQL Get periode data DESC
    $SQL_getperiodedata3 = "SELECT * FROM periode ORDER BY periode_kode DESC";
    $getperiodedata3 = mysqli_query($db, $SQL_getperiodedata3);

    // SQL Get kelas data
    $SQL_getkelasdata = "SELECT * FROM kelas";
    $getkelasdata = mysqli_query($db, $SQL_getkelasdata);
    $arraygetkelasdata = mysqli_fetch_array($getkelasdata);

    $SQL_getkelasdata1 = "SELECT * FROM kelas";
    $getkelasdata1 = mysqli_query($db, $SQL_getkelasdata1);


    $SQL_getkelascount= "SELECT COUNT(id) AS Jumlah FROM kelas";
    $getkelascount = mysqli_query($db, $SQL_getkelascount);
    $resultgetkelascount = mysqli_fetch_array($getkelascount);

    // SQL Get kelas_forum data
    $SQL_getkelasforumdata = "SELECT * FROM kelas_forum";
    $getkelasforumdata = mysqli_query($db, $SQL_getkelasforumdata);
    $arraygetkelasforumdata = mysqli_fetch_array($getkelasforumdata);

    // SQL Get kelas_tugas data
    $SQL_getkelastugasdata = "SELECT * FROM kelas_tugas";
    $getkelastugasdata = mysqli_query($db, $SQL_getkelastugasdata);
    $arraygetkelastugasdata = mysqli_fetch_array($getkelastugasdata);


    // SQL Get kelas_user data
    $SQL_getkelasenroldata = "SELECT * FROM kelas_enrol";
    $getkelasenroldata = mysqli_query($db, $SQL_getkelasenroldata);
    $arraygetkelasenroldata = mysqli_fetch_array($getkelasenroldata);

    // SQL Get kelas_absen
    $SQL_getkelasabsensi = "SELECT * FROM kelas_absen";
    $getkelasabsensi = mysqli_query($db, $SQL_getkelasabsensi);

    // SQL Get kelas_enrol
    $SQL_getkelasenrol = "SELECT * FROM kelas_enrol";
    $getkelasenrol = mysqli_query($db, $SQL_getkelasenrol);

    // SQL get max id jadwal
    $SQL_getmaxidjadwal = "SELECT MAX(id) as MAX from kelas_jadwal_mengajar";
    $getmaxidjadwal = mysqli_query($db, $SQL_getmaxidjadwal);
    $arraygetmaxidjadwal = mysqli_fetch_array($getmaxidjadwal);