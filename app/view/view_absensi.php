<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Presensi</h1>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">E-Laboratorium</a></li>
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <?php if($S_rolestatus == "admin"){echo "<li class='breadcrumb-item'><a href='".$LINK_semuakelas."'>Semua Kelas</a></li>";} ?>
        <li class="breadcrumb-item"><a href="<?php echo $S_rolestatus ?>?page=kelas-detail&id=<?php echo $kelas['kelas_kode'] ?>&nav=absen"><?php echo $kelas['kelas_kode'] ?></a></li>
        <li class="breadcrumb-item active" aria-current="page">Absensi Pertemuan <?php echo $weekabsensi?></li>
        </ol>
    </div>
    <?php if(isset($alert)){echo $alert;} ?>
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <a href="<?php if(isset($linkdownloadexceldosen)){echo $linkdownloadexceldosen;}else{echo $linkdownloadexcel;}?>" class="btn btn-success">Download Excel <i class="fa fa-file-excel ml-1" aria-hidden="true"></i></a>
                    <a href="<?php echo $linkdownloadpdf;?>" class="btn btn-danger ml-2">Download PDF <i class="fa fa-file-pdf ml-1" aria-hidden="true"></i></a>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <td colspan="2" class="border border-0 p-0"><b>Kelas</b></td>
                                <td colspan="8" class="border border-0 p-0">: <?php echo $kelas['fullname']." (".$kelas['shortname'].") - ".strtoupper($kelas['jadwal']); if(isset($kelasdosen)){echo strtoupper($kelasdosen);} ?></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="border border-0 p-0"><b>Periode</b></td>
                                <td colspan="8" class="border border-0 p-0">: <?php echo $kelas['nama_periode']; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="border border-0 p-0"><b>Laboratorium</b></td>
                                <td colspan="8" class="border border-0 p-0">: <?php echo $kelas['nama_laboratorium']; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="border border-0 p-0"><b>Pertemuan</b></td>
                                <td colspan="8" class="border border-0 p-0">: <?php echo $weekabsensi; ?></td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <table class="table align-items-center table-flush " id="table-data-absensi">
                        <thead class="thead-light">
                            <tr>
                                <th>NPM</th>
                                <th>NAMA</th>
                                <th>KEHADIRAN</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php showabsensi(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>