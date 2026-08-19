<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Periode Praktikum <?php echo $periode ?> <span class="badge badge-<?php echo $statuscolor ?>"><?php echo $statusperiode ?></span></h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">E-Laboratorium</a></li>
      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="<?php echo $S_rolestatus."?page=periode" ?>">Periode</a></li>
      <li class="breadcrumb-item active" aria-current="page">Periode <?php echo $periode ?></li>
    </ol>
  </div>
  <?php if(isset($alert)){echo $alert;}?> 
  <div class="row mb-3">
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Jumlah Mahasiswa Praktikum</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php jumlahmahasiswaperiode() ?></div>
              <div class="mt-2 mb-0 text-muted text-xs">
                <span>Periode <?php echo $periode ?></span>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-solid fa-users fa-2x text-primary"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Jumlah Kelas Praktikum</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php getjumlahkelasperiode($id) ?></div>
              <div class="mt-2 mb-0 text-muted text-xs">
                <span>Periode <?php echo $periode ?></span>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-solid fa-flask fa-2x text-warning"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-6 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold mb-1">
                <button type="button" class="col-xl-12 btn btn-sm btn-success" data-toggle="modal" data-target="#editperiode" id="#modalCenter">Edit Periode</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-12 col-lg-7 mb-4">
      <div class="card">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-secondary">Riwayat Aktifitas</h6>
            <hr>
            <table style="font-family: courier;font-size:16px" class="font-weight-bold" width="100%">
                <?php showlogperiode(); ?>
            </table>
          </div>
      </div>
    </div>
    <?php showperiodekelas() ?>
</div>
<div class="modal fade" id="deleteperiodeModal" tabindex="-1" role="dialog" aria-labelledby="deleteperiodemodaltitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger" id="deleteperiodemodaltitle">Peringatan!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Apakah anda yakin ingin <span class="text-danger">delete periode</span> ?</p>
      </div>
      <form method="post">
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-success" data-dismiss="modal">Cancel</button>
          <input type="submit" name="deleteperiode" class="btn btn-danger" value="Delete">
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="editperiode" tabindex="-1" role="dialog" aria-labelledby="editperiodemodel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editperiodemodel">Edit periode <?php echo $periode ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="form-group">
              <label for="edit-nama-periode">Nama Periode</label>
              <input type="text" class="form-control" name="editnamaperiode" id="edit-nama-periode"
              placeholder="Contoh: 2023/2024" value="<?php echo $periode ?>">
          </div>
          <input type="submit" class="btn btn-primary mb-3" name="savename" value="Simpan Nama">
          <hr>
          <div class="form-group">
              <label for="input-status-periode">Status Periode <span class="text-danger"><b>*</b></span></label>
              <br>
              <select class="form-control" name="inputstatusperiode" id="input-status-periode" required>
                  <option value="Aktif">Aktif</option>
                  <option value="Non-Aktif">Non-Aktif</option>
              </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
          <input type="submit" name="savetime" class="btn btn-primary" value="Simpan Status">
        </div>
      </form>
    </div>
  </div>
</div>