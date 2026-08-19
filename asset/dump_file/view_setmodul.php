<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Set Modul</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">E-Laboratorium</a></li>
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo $S_rolestatus?>?page=kelas">Kelas Praktikum</a></li>
            <li class="breadcrumb-item"><a href="<?php echo $S_rolestatus?>?page=kelas"><?php echo $kelas_kode ?></a></li>
            <li class="breadcrumb-item active" aria-current="page">Set Modul <?php echo $kelas_kode ?></li>
        </ol>
    </div>

    <div class="card-body">
        <form method="post" enctype="multipart/form-data">
            <div class="row mb-4">
                <?php echo $imputjmlmodul ?>
            </div>
        </form>

        <form method="post">
            <?php showsetmodul() ?>

            <div class="text-xs font-weight-bold mb-1">
                <a href="<?php echo $S_rolestatus."?page=kelas-detail&id=".$kelas_kode."&nav=tugas"; ?>" class="col-xl-12 btn btn-sm btn-danger">Cancel</a>
            </div>
        </form>
    </div>
</div>