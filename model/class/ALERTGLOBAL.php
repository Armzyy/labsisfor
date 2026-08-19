<?php
    // Alert login input kosong
    $ALERT_inputloginkosong = "
        <div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> NIP/NPM dan Password tidak boleh kosong.
        </div>
    ";

    // Alert NIM/NPM login tidak ditemukan
    $ALERT_inputloginusernamesalah = "
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Perhatian!</strong> NIP/NPM dan Password tidak ditemukan.
        </div>
    ";

    //Alert Password login tidak sesuai
    $ALERT_inputloginpasswordsalah = "
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Perhatian!</strong> NIP/NPM dan Password salah.
        </div>
    ";

    // Alert periode input kosong
    $ALERT_inputperiodekosong = "
        <div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data periode tidak boleh kosong.
        </div>
    ";
    // Alert periode input berhasil
    $ALERT_inputperiodesukses = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Periode berhasil ditambahkan.
        </div>
    ";

    // Alert periode input gagal
    $ALERT_inputperiodegagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Periode gagal ditambahkan.
        </div>
    ";

    // Alert periode delete sukses
    $ALERT_deleteperiodesukses = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Periode berhasil dihapus.
        </div>
    ";

    // Alert periode delete gagal
    $ALERT_deleteperiodegagal = " 
        <div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Periode tidak dapat dihapus.
        </div>
    ";

    // Alert periode update nama kosong
    $ALERT_updateperiodenamakosong = " 
        <div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>nama</b> tidak boleh kosong.
        </div>
    ";

    // Alert periode update nama sukses
    $ALERT_updateperiodenamasukses = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>nama</b> berhasil diupdate.
        </div>
    ";

    // Alert periode update nama gagal
    $ALERT_updateperiodenamagagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>nama</b> tidak dapat diupdate.
        </div>
    ";

    // Alert periode update nama kosong
    $ALERT_updateperiodenamawaktukosong = " 
        <div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>nama</b> dan <b class='text-uppercase'>status</b> tidak boleh kosong.
        </div>
    ";

    // Alert periode update nama sukses
    $ALERT_updateperiodenamawaktusukses = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>nama</b> dan <b class='text-uppercase'>status</b> berhasil diupdate.
        </div>
    ";

    // Alert periode update nama gagal
    $ALERT_updateperiodenamawaktugagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>nama</b> dan <b class='text-uppercase'>status</b> tidak dapat diupdate.
        </div>
    ";

    // Alert periode delete periode sukses
    $ALERT_deleteperiodesukses = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>periode</b> berhasil dihapus.
        </div>
    ";

    // Alert periode delete periode gagal
    $ALERT_deleteperiodegagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>periode</b> tidak dapat dihapus.
        </div>
    ";

    $ALERT_updatelaboratoriumsukses = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>laboratorium</b> berhasil diupdate.
        </div>
    ";

    $ALERT_updatelaboratoriumgagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>laboratorium</b> gagal diupdate.
        </div>
    ";

    $ALERT_surattugastidakpdf = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>surat tugas laboratorium</b> bukan .pdf.
        </div>
    ";

    $ALERT_datalaboratoriumkosong = " 
        <div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>laboratorium</b> tidak boleh ada yang kosong.
        </div>
    ";

    $ALERT_inputlaboratoriumsukses = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>laboratorium</b> berhasil ditambahkan.
        </div>
    ";

    $ALERT_inputlaboratoriumgagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>laboratorium</b> gagal ditambahkan.
        </div>
    ";

    $ALERT_updatekelassukses = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Kelas</b> berhasil diupdate.
        </div>
    ";

    $ALERT_updatekelasgagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Kelas</b> gagal diupdate.
        </div>
    ";

    $ALERT_datakelaskosong = " 
        <div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Kelas</b> tidak boleh kosong.
        </div>
    ";

    $ALERT_tambahforumberhasil = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>forum</b> berhasil ditambahkan.
        </div>
    ";

    $ALERT_tambahforumgagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>forum</b> gagal ditambahkan.
        </div>
    ";

    $ALERT_dataforumkosong = " 
        <div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>forum</b> tidak boleh kosong.
        </div>
    ";

    $ALERT_forumberhasildihapus = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>forum</b> berhasil dihapus.
        </div>
    ";

    $ALERT_forumgagaldihapus = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>forum</b> gagal dihapus.
        </div>
    ";

    $ALERT_forumberhasildiupdate = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>forum</b> berhasil diupdate.
        </div>
    ";

    $ALERT_forumgagaldiupdate = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>forum</b> gagal diupdate.
        </div>
    ";

    $ALERT_tugasberhasilditambahkan = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>tugas</b> berhasil ditambahkan.
        </div>
    ";

    $ALERT_tugasgagalditambahkan = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>tugas</b> gagal ditambahkan.
        </div>
    ";

    $ALERT_datatugaskosong = " 
        <div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>tugas</b> tidak boleh kosong.
        </div>
    ";

    $ALERT_tugasberhasildiupdate = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasi!</strong> Data <b class='text-uppercase'>tugas</b> berhasil diupdate.
        </div>
    ";

    $ALERT_tugasgagaldiupdate = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>tugas</b> gagal diupdate.
        </div>
    ";

    $ALERT_materiberhasilupload = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Materi</b> berhasil ditambahkan.
        </div>
    ";

    $ALERT_materigagalupload = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Materi</b> gagal ditambahkan.
        </div>
    ";

    $ALERT_materibukangoogle = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Materi</b> bukan dari drive.google.com .
        </div>
    ";

    $ALERT_materikosong = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Materi</b> tidak boleh kosong.
        </div>
    ";

    $ALERT_materitidaksesuai = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Materi</b> extensi tidak sesuai.
        </div>
    ";

    $ALERT_materikosong = " 
        <div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Materi</b> tidak boleh kosong.
        </div>
    ";

    $ALERT_materiberhasildihapus = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Materi</b> berhasil dihapus.
        </div>
    ";

    $ALERT_materigagaldihapus = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Materi</b> gagal dihapus.
        </div>
    ";

    $ALERT_tugasberhasilupload = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Tugas</b> berhasil diupload.
        </div>
    ";

    $ALERT_tugasgagallupload = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Tugas</b> gagal diupload.
        </div>
    ";

    $ALERT_tugaskosong = " 
        <div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Tugas</b> tidak boleh kosong.
        </div>
    ";

    $ALERT_tugastidaksesuai = " 
        <div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Tugas</b> sesuai extensi.
        </div>
    ";

    $ALERT_tugasberhasildihapus = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Tugas</b> berhasil dihapus.
        </div>
    ";

    $ALERT_tugasgagaldihapus = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Tugas</b> gagal dihapus.
        </div>
    ";

    $ALERT_inputnilaiberhasil = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Nilai</b> berhasil diupdate.
        </div>
    ";

    $ALERT_inputnilaigagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Nilai</b> gagal diupdate.
        </div>
    ";

    $ALERT_inputnilaitidakvalid = " 
        <div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Nilai</b> tidak valid.
        </div>
    ";

    $ALERT_absensiberhasildibuka = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Presensi</b> berhasil diupdate.
        </div>
    ";

    $ALERT_absensigagaldibuka = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Presensi</b> gagal diupdate.
        </div>
    ";

    $ALERT_absensikosong = " 
        <div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Presensi</b> tidak boleh kosong.
        </div>
    ";

    $ALERT_berhasilabsensi = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Presensi</b> berhasil dicatat.
        </div>
    ";

    $ALERT_gagalabsensi = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Presensi</b> gagal dicatat.
        </div>
    ";

    $ALERT_absensiditutup = " 
        <div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Presensi</b> tidak dapat diinputkan - CLOSED.
        </div>
    ";

    $ALERT_gagalinputjmlmodul = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Set Modul</b> gagal dicatat.
        </div>
    ";

    $ALERT_berhasilinputjmlmodul = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Set Modul</b> berhasil dicatat.
        </div>
    ";

    $ALERT_inputjmlmodulkosong = " 
        <div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Set Modul</b> tidak boleh kosong.
        </div>
    ";

    $ALERT_berhasildeletesetmodul = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Set Modul</b> berhasil dihapus.
        </div>
    ";

    $ALERT_gagalldeletesetmodul = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Set Modul</b> gagal dihapus.
        </div>
    ";

    $ALERT_updatemodulberhasil = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Modul</b> berhasil diupdate.
        </div>
    ";

    $ALERT_updatemodulgagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Modul</b> gagal diupdate.
        </div>
    ";

    $ALERT_updatemodultidaksesuai = " 
        <div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Modul</b> yang dimasukkan tidak sesuai.
        </div>
    ";

    $ALERT_tambahasistenmodulberhasil = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Asisten</b> berhasil ditambahkan.
        </div>
    ";

    $ALERT_tambahasistenmodulgagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong>Beberapa Data <b class='text-uppercase'>Asisten</b> gagal ditambahkan.
        </div>
    ";

    $ALERT_tambahasistenmodulkosong = " 
        <div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Asisten Modul</b> tidak boleh kosong.
        </div>
    ";

    $ALERT_hapusasistenmodulberhasil = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Asisten Modul</b> berhasil dihapus.
        </div>
    ";

    $ALERT_hapusasistenmodulgagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Asisten Modul</b> gagal dihapus.
        </div>
    ";

    $ALERT_uploaduserberhasil = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Seluruh Data <b class='text-uppercase'>User</b> berhasil ditambahkan.
        </div>
    ";

    $ALERT_uploadusergagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>User</b> gagal ditambahkan.
        </div>
    ";

    $ALERT_updateuserberhasil = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>User</b> berhasil diupdate.
        </div>
    ";

    $ALERT_updateusergagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>User</b> gagal diupdate.
        </div>
    ";

    $ALERT_uploadusersudahada = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>User</b> telah ada dalam sistem.
        </div>
    ";

    $ALERT_uploaduserberhasilerr = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Beberapa Data <b class='text-uppercase'>User</b> berhasil ditambahkan.
        </div>
    ";

    $ALERT_inputpraktikumberhasil = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Praktikum</b> berhasil ditambahkan.
        </div>
    ";

    $ALERT_inputpraktikumgagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Praktikum</b> gagal ditambahkan.
        </div>
    ";

    $ALERT_inputpraktikumkosong = " 
        <div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Praktikum</b> tidak boleh kosong.
        </div>
    ";

    $ALERT_updatepraktikumberhasil = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Praktikum</b> berhasil diupdate.
        </div>
    ";

    $ALERT_updatepraktikumgagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Praktikum</b> gagal diupdate.
        </div>
    ";

    $ALERT_tambahkelasberhasil = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Kelas</b> berhasil ditambahkan.
        </div>
    ";

    $ALERT_tambahkelasgagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Kelas</b> gagal ditambahkan.
        </div>
    ";

    $ALERT_tambahkelaskosong = " 
        <div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Kelas</b> tidak boleh kosong.
        </div>
    ";

    $ALERT_delimitertidakcocok = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Delimiter</b> tidak sesuai.
        </div>
    ";

    $ALERT_enrolsukses = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Seluruh data <b class='text-uppercase'>Peserta</b> berhasil ditambahkan.
        </div>
    ";

    $ALERT_enrolsuksessebagian = " 
        <div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Beberapa data <b class='text-uppercase'>Peserta</b> berhasil ditambahkan.
        </div>
    ";

    $ALERT_enrolgagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Peserta</b> gagal ditambahkan.
        </div>
    ";

    $ALERT_pesertaberhasilhapus = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Peserta</b> berhasil dihapus.
        </div>
    ";

    $ALERT_pesertagagalhapus = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Peserta</b> gagal dihapus.
        </div>
    ";

    $ALERT_jadwalkosong = " 
        <div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Jadwal</b> tidak boleh kosong.
        </div>
    ";

    $ALERT_jadwalberhasil = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Jadwal</b> berhasil diinputkan.
        </div>
    ";

    $ALERT_jadwalgagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Jadwal</b> gagal diinputkan.
        </div>
    ";

    $ALERT_jadwalpenuh = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Jadwal</b> telah penuh.
        </div>
    ";

    $ALERT_inputpersentasependahuluankosong = " 
        <div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Format Nilai</b> tidak boleh kosong.
        </div>
    ";

    $ALERT_inputpersentasependahuluanberhasil = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Format Nilai</b> berhasil diupdate.
        </div>
    ";

    $ALERT_inputpersentasependahuluangagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Format Nilai</b> gagal diupdate.
        </div>
    ";

    $ALERT_updateprofilebukanpexels = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Link <b class='text-uppercase'>Profile Photo</b> bukan dari Pexels.com .
        </div>
    ";

    $ALERT_updateprofilekosong = " 
        <div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Profile</b> tidak boleh kosong.
        </div>
    ";

    $ALERT_updateprofileberhasil = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Profile</b> berhasil diupdate.
        </div>
    ";

    $ALERT_updateprofilegagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Profile</b> gagal diupdate.
        </div>
    ";

    $ALERT_passwordlamatidaksesuai = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Password lama</b> tidak sesuai.
        </div>
    ";

    $ALERT_passwordbarutidaksesuai = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Password baru</b> tidak sesuai.
        </div>
    ";

    $ALERT_passwordupdateberhasil = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Password</b> berhasil diupdate.
        </div>
    ";

    $ALERT_passwordupdategagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Password</b> gagal diupdate.
        </div>
    ";

    $ALERT_passwordupdatekosong = " 
        <div class='alert alert-waring alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Password</b> tidak boleh kosong.
        </div>
    ";

    $ALERT_delabsensiberhasil = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Absensi</b> berhasil dihapus.
        </div>
    ";

    $ALERT_delabsensigagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Absensi</b> gagal dihapus.
        </div>
    ";

    $ALERT_berhasildeletekelas = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Seluruh Data <b class='text-uppercase'>Kelas</b> berhasil dihapus.
        </div>
    ";

    $ALERT_gagaldeletekelas = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Seluruh Data <b class='text-uppercase'>Kelas</b> gagal dihapus.
        </div>
    ";
    
    $ALERT_syaratberhasil = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Syarat</b> berhasil diperbarui.
        </div>
    ";

    $ALERT_syaratgagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Syarat</b> gagal diperbarui.
        </div>
    ";

    $ALERT_linkpenilaianberhasil = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Link <b class='text-uppercase'>Penilaian</b> berhasil ditambahkan.
        </div>
    ";

    $ALERT_linkpenilaiangagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Link <b class='text-uppercase'>Penilaian</b> gagal ditambahkan.
        </div>
    ";

    $ALERT_linkpenilaiansalah = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Link <b class='text-uppercase'>Penilaian</b> bukan dari spreadsheets.
        </div>
    ";

    $ALERT_nilaiaslabberhasil = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Penilaian</b> berhasil diinputkan.
        </div>
    ";

    $ALERT_nilaiaslabgagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Penilaian</b> gagal diinputkan.
        </div>
    ";

    $ALERT_nilaiaslabsalah = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Data <b class='text-uppercase'>Penilaian</b> tidak sesuai.
        </div>
    ";

    $ALERT_tambahjadwalberhasil = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Jadwal</b> berhasil diinputkan.
        </div>
    ";

    $ALERT_tambahjadwalgagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Jadwal</b> gagal diinputkan.
        </div>
    ";
    
    $ALERT_linkjadwalasistensisalah = " 
        <div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Link <b class='text-uppercase'>Jadwal Asistensi</b> bukan dari spreadsheet .
        </div>
    ";

    $ALERT_linkjadwalasistensigagal = " 
        <div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Peringatan!</strong> Link <b class='text-uppercase'>Jadwal Asistensi</b> gagal diupdate.
        </div>
    ";

    $ALERT_linkjadwalasistensiberhasil = " 
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Link <b class='text-uppercase'>Jadwal Asistensi</b> berhasil diupdate.
        </div>
    ";

    $ALERT_hapusasistenmodulberhasil = "
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Asisten Mengajar Asistensi</b> berhasil dihapus.
        </div>
    ";

    $ALERT_hapusasistenmodulgagal = "
    <div class='alert alert-danger alert-dismissible'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
        <strong>Berhasil!</strong> Data <b class='text-uppercase'>Asisten Mengajar Asistensi</b> gagal dihapus.
    </div>
    ";

    $ALERT_hapusjadwalmodulberhasil = "
        <div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Data <b class='text-uppercase'>Jadwal Mengajar Asistensi</b> berhasil dihapus.
        </div>
    ";

    $ALERT_hapusjadwalmodulgagal = "
    <div class='alert alert-danger alert-dismissible'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
        <strong>Berhasil!</strong> Data <b class='text-uppercase'>Jadwal Mengajar Asistensi</b> gagal dihapus | Hapus asisten mengajar terlebih dahulu.
    </div>
    ";

