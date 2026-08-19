<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail <?php echo $datalaboratorium["nama_laboratorium"] ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">E-Laboratorium</a></li>
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><?php if($S_rolestatus != "ketualab"){echo "<a href='".$LINK_laboratoriumadmin."'>Laboratorium</a>";}else{echo "Laboratorium";}?></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Lab</li>
        </ol>
    </div>
    <?php if(isset($alert)){echo $alert;} ?>
    <div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Update Data <?php echo $datalaboratorium["nama_laboratorium"] ?></h6>
    </div>
    <div class="card-body">
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="namalaboratorium">Nama Laboratorium <span class="text-danger"><b>*</b></span></label>
                <input type="text" class="form-control" name="namalaboratorium" id="namalaboratorium" placeholder="Contoh : Laboratorium Sistem Informasi" value="<?php echo $datalaboratorium["nama_laboratorium"] ?>" required>
            </div>
            <?php showformketualab() ?>
            <div class="form-group pb-3">
                <label for="kooraslab">Koor Aslab <span class="text-danger"><b>*</b></span></label>
                <p class="text-success">Koor Aslab Saat Ini : <b><?php if($datakoorlab != NULL){echo $datakoorlab['username']." - ".$datakoorlab['firstname'];} ?></b></p>
                <select class="kooraslab form-control" name="kooraslab" id="kooraslab" required>
                    <option value="">Select</option>
                    <?php cetakdatamahasiswa() ?>
                </select>
            </div>
            <div class="form-group">
                <p>Upload File Tugas <span class="text-danger"><b>*</b></p>
                <?php showfile() ?>
                <input type="file" class="text-white btn btn-info form-control-file" name="uploadsurattugas" id="uploadsurattugas" required>
            </div>
            <div class="text-xs font-weight-bold mb-1 pt-5">
                <input type="submit" name="updatelaboratorium" class="col-xl-12 btn btn-sm btn-success" value="Update Laboratorium">
            </div>
            <div class="text-xs font-weight-bold mb-1">
                <a href="<?php linkcancel() ?>" class="col-xl-12 btn btn-sm btn-danger">Cancel</a>
            </div>
        </form>
    </div>
    </div>
</div>