<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Kelas Praktikum</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">E-Laboratorium</a></li>
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Kelas Praktikum</li>
        </ol>
    </div>
    <!-- alert here -->
    <?php if(isset($alert)){echo $alert;}  ?>
     <!-- General Element -->
    <div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Masukkan Data Kelas Baru</h6>
    </div>
    <div class="card-body">
        <form method="post">
            <div class="form-group">
                <label for="input-fullname-kelas">Nama Kelas Praktikum <span class="text-danger"><b>*</b></span></label>
                <select class="form-control" name="inputfullnamekelas" id="input-fullname-kelas" required>
                    <option value="">Select</option>
                    <?php showpraktikumname() ?>
                </select>
            </div>
            <?php pilihlab() ?>
            <div class="form-group">
                <label for="input-jadwal-kelas">Jadwal Kelas <span class="text-danger"><b>*</b></span></label>
                <select class="form-control" name="inputjadwalkelas" id="input-jadwal-kelas" required>
                    <option value="pagi">Pagi</option>
                    <option value="malam">Malam</option>
                </select>
            </div>
            <div class="form-group">
                <label for="input-periode-kelas">Periode Kelas <span class="text-danger"><b>*</b></span></label>
                <select class="form-control" name="inputperiodekelas" id="input-periode-kelas">
                    <option value="">Select</option>
                    <?php showperiodeaktif() ?>
                </select>
            </div>
            <div class="form-group">
                <label for="input-deskripsi-kelas">Deskripsi <span class="text-danger"><b>*</b></span></label>
                <textarea class="form-control ckeditor" name="inputdeskripsikelas" id="input-deskripsi-kelas" rows="3"></textarea>
            </div> 
            <div class="text-xs font-weight-bold mb-1">
                <input type="submit" name="tambahkelas" class="col-xl-12 btn btn-sm btn-success" value="Tambahkan Kelas">
            </div>
            <div class="text-xs font-weight-bold mb-1">
                <a href="<?php echo $LINK_home; ?>" class="col-xl-12 btn btn-sm btn-danger">Cancel</a>
            </div>
        </form>
    </div>
    </div>
</div>