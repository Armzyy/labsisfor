<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit kelas <?php echo $nama_kelas; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">E-Laboratorium</a></li>
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <?php if($S_rolestatus == "admin"){echo "<li class='breadcrumb-item'><a href='".$LINK_semuakelas."'>Semua Kelas</a></li>";} ?>
            <li class="breadcrumb-item"><a href="<?php echo LINK_kelas($_GET['id']) ?>"><?php echo $_GET['id'] ?></a></li>
            <li class="breadcrumb-item active" aria-current="page">Kelas Praktikum Edit</li>
        </ol>
    </div>
    <?php if(isset($alert)){echo $alert;} ?>
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Update Data Kelas <?php echo $nama_kelasshort ?></h6>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label for="input-fullname-kelas">Nama Kelas (fullname) <span class="text-danger"><b>*</b></span></label>
                    <input type="text" class="form-control" name="inputfullnamekelas" id="input-fullname-kelas" placeholder="Contoh : Praktikum Pemrograman Berbasis Framework" value="<?php echo $nama_kelas; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="input-shortname-kelas">Singkatan Kelas (shortname) <span class="text-danger"><b>*</b></span></label>
                    <input type="text" class="form-control" name="inputshortnamekelas" id="input-shortname-kelas" placeholder="Contoh : PBO" value="<?php echo $nama_kelasshort ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="input-periode-kelas">Laboratorium Tertaut <span class="text-danger"><b>*</b></span></label>
                    <input class="form-control" type="text" name="inputlaboratoriumkelas" value="<?php echo $laboratorium ?>" id="input-periode-kelas" readonly>
                </div>
                <div class="form-group">
                    <label for="input-jadwal-kelas">Jadwal Kelas <span class="text-danger"><b>*</b></span></label>
                    <select class="form-control" name="inputjadwalkelas" id="input-jadwal-kelas" required>
                        <option value="">Pilih jadwal</option>
                        <option value="pagi">Pagi</option>
                        <option value="malam">Malam</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="input-periode-kelas">Periode Tertaut <span class="text-danger"><b>*</b></span></label>
                    <input class="form-control" type="text" name="inputperiodekelas" value="<?php echo $periode['nama_periode'] ?>" id="input-periode-kelas" readonly>
                </div>
                <div class="form-group">
                    <label for="input-deskripsi-kelas">Deskripsi</label>
                    <textarea class="form-control ckeditor" name="inputdeskripsikelas" id="input-deskripsi-kelas" rows="3"><?php echo $deskripsi?></textarea>
                </div> 

                <div class="text-xs font-weight-bold mb-1">
                    <input type="submit" name="updatekelas" class="col-xl-12 btn btn-sm btn-success" value="Update Kelas">
                </div>
                <div class="text-xs font-weight-bold mb-1">
                    <a href="<?php echo $S_rolestatus."?page=kelas-detail&id=".$getid."&nav=forum"; ?>" class="col-xl-12 btn btn-sm btn-danger">Cancel</a>
                </div>
            </form>
        </div>
        <!-- <?php //if(isset($delkelas)){echo $delkelas;} ?> -->
    </div>
</div>