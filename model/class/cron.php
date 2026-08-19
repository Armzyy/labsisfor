<?php
// ==========================================
// 1. CRON JOB UNTUK PERIODE & KELAS
// ==========================================
// Scan semua waktu akhir periode & kelas terkait
if (isset($getperiodedata1) && $getperiodedata1) {
    while ($assocgetperiodedata = $getperiodedata1->fetch_assoc()) {

        $cronidperiode = $assocgetperiodedata['periode_kode'];

        // Check time status
        if ($assocgetperiodedata['status'] == "Aktif") {
            $SQL_updatestatusperiode = "UPDATE periode SET status='Aktif' WHERE periode_kode='$cronidperiode'";
            $updatestatusperiode = mysqli_query($db, $SQL_updatestatusperiode);

            $SQL_updatestatuskelas = "UPDATE kelas SET status='Aktif' WHERE periode_kode='$cronidperiode'";
            $updatestatuskelas = mysqli_query($db, $SQL_updatestatuskelas);
        } else {
            $SQL_updatestatusperiode = "UPDATE periode SET status='Non-Aktif' WHERE periode_kode='$cronidperiode'";
            $updatestatusperiode = mysqli_query($db, $SQL_updatestatusperiode);

            $SQL_updatestatuskelas = "UPDATE kelas SET status='Non-Aktif' WHERE periode_kode='$cronidperiode'";
            $updatestatuskelas = mysqli_query($db, $SQL_updatestatuskelas);
        }
    }
}


// ==========================================
// 2. CRON JOB UNTUK STATUS KETUA LAB (KALAB)
// ==========================================
if (isset($getuserdatadosen) && $getuserdatadosen) {
    while ($assocgetuserdosen = $getuserdatadosen->fetch_assoc()) {
        $idnumberdosen = $assocgetuserdosen['username'];

        $adakalab = getkalabbyidnumber($idnumberdosen);

        if ($adakalab['jumlah'] == 0) {
            $SQL_updateuserdosen = "UPDATE user SET role = 'dosen' WHERE username = '$idnumberdosen'";
            $updateuserdosen = mysqli_query($db, $SQL_updateuserdosen);
        } else {
            $SQL_updateuserdosen = "UPDATE user SET role = 'ketualab' WHERE username = '$idnumberdosen'";
            $updateuserdosen = mysqli_query($db, $SQL_updateuserdosen);
        }
    }
}


// ==========================================
// 3. CRON JOB UNTUK STATUS KOOR ASLAB (KOORLAB)
// ==========================================
if (isset($getuserdatakoorlab) && $getuserdatakoorlab) {
    while ($assocgetuserkoorlab = $getuserdatakoorlab->fetch_assoc()) {
        $idnumberkoorlab = $assocgetuserkoorlab['username'];

        $adakalab = getkoorlabbyidnumber($idnumberkoorlab);

        if ($adakalab['jumlah'] == 0) {
            $SQL_updateuserkoorlab = "UPDATE user SET role = 'mahasiswa' WHERE username = '$idnumberkoorlab'";
            $updateuserkoorlab = mysqli_query($db, $SQL_updateuserkoorlab);
        } else {
            $SQL_updateuserkoorlab = "UPDATE user SET role = 'kooraslab' WHERE username = '$idnumberkoorlab'";
            $updateuserkoorlab = mysqli_query($db, $SQL_updateuserkoorlab);
        }
    }
}


// ==========================================
// 4. CRON JOB UNTUK ABSENSI KELAS
// ==========================================
if (isset($getkelasabsensi) && $getkelasabsensi) {
    while ($assocgetkelasabsen = $getkelasabsensi->fetch_assoc()) {
        $kelasbasen = $assocgetkelasabsen['kelas_kode'];
        $weekabsen = $assocgetkelasabsen['week'];

        if (($assocgetkelasabsen['batasabsensi'] < now_timestamp()) && ($assocgetkelasabsen['batasabsensi'] != 0)) {
            $SQL_updatestatusabsen = "UPDATE kelas_absen SET status = 'closed' WHERE kelas_kode = '$kelasbasen' AND week = '$weekabsen'";
            $updatestatusabsen = mysqli_query($db, $SQL_updatestatusabsen);
        } else if ($assocgetkelasabsen['batasabsensi'] == 0) {
            $SQL_updatestatusabsen = "UPDATE kelas_absen SET status = 'notset' WHERE kelas_kode = '$kelasbasen' AND week = '$weekabsen'";
            $updatestatusabsen = mysqli_query($db, $SQL_updatestatusabsen);
        } else {
            $SQL_updatestatusabsen = "UPDATE kelas_absen SET status = 'dibuka' WHERE kelas_kode = '$kelasbasen' AND week = '$weekabsen'";
            $updatestatusabsen = mysqli_query($db, $SQL_updatestatusabsen);
        }
    }
}


// ==========================================
// 5. CRON JOB UNTUK ASISTEN MODUL
// ==========================================
// (Silakan isi di sini jika ada logika tambahan nantinya)


// ==========================================
// 6. CRON JOB PERHITUNGAN NILAI AKHIR (FIXED ERROR)
// ==========================================
// Perbaikan: Mengubah GROUP BY menjadi ORDER BY agar query tidak mengembalikan nilai false/error
$SQL_cekcountnilaiakhir = "SELECT kelas_kode, username, nilai_aslab, nilai_dosen, nilai_all 
                           FROM kelas_enrol 
                           WHERE role_kelas IN ('mahasiswa', 'KPMS', 'KAMS') 
                           ORDER BY username ASC";

$cekcountnilaiakhir = mysqli_query($db, $SQL_cekcountnilaiakhir);

// Pastikan query berhasil dieksekusi sebelum melakukan fetch_assoc
if ($cekcountnilaiakhir) {
    while ($rowcekcountnilaiakhir = $cekcountnilaiakhir->fetch_assoc()) {
        $kelasidnilai = $rowcekcountnilaiakhir['kelas_kode'];
        $nilaiformat = getformatnilai($kelasidnilai);
        $usernamenilai = $rowcekcountnilaiakhir['username'];
        $nilaiaslab = $rowcekcountnilaiakhir['nilai_aslab'];
        $nilaidosen = $rowcekcountnilaiakhir['nilai_dosen'];

        // Mengamankan nilai persentase jika data format nilai kosong agar tidak crash
        $p_aslab = isset($nilaiformat['persentase_aslab']) ? $nilaiformat['persentase_aslab'] : 0;
        $p_dosen = isset($nilaiformat['persentase_dosen']) ? $nilaiformat['persentase_dosen'] : 0;

        // Rumus perhitungan akumulasi nilai_all
        $nilaiall = ($nilaiaslab * ($p_aslab / 100)) + ($nilaidosen * ($p_dosen / 100));

        $SQL_countnilaiakhir = "UPDATE kelas_enrol SET nilai_all = '$nilaiall' WHERE kelas_kode = '$kelasidnilai' AND username = '$usernamenilai'";
        $countnilaiakhir = mysqli_query($db, $SQL_countnilaiakhir);
    }
} else {
    // Membantu proses debug jika query di atas suatu saat bermasalah dengan struktur tabel database
    die("Gagal menjalankan cron nilai akhir: " . mysqli_error($db));
}
