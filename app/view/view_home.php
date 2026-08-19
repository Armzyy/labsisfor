<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">E-Laboratorium</a></li>
      <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    </ol>
  </div>
  <?php if(isset($alert)){echo $alert;}  ?>
  <div class="row mb-3">
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Jumlah Ketua Lab</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $jumlahkalabsaatini ?></div>
              <div class="mt-2 mb-0 text-muted text-xs">
                <span>Tergabung di sistem</span>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-solid fa-user-cog fa-2x text-primary"></i>
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
              <div class="text-xs font-weight-bold text-uppercase mb-1">Jumlah Dosen Praktikum</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $jumlahdosensaatini ?></div>
              <div class="mt-2 mb-0 text-muted text-xs">
                <span>Tergabung di sistem</span>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-solid fa-user-graduate fa-2x text-warning"></i>
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
              <div class="text-xs font-weight-bold text-uppercase mb-1">Jumlah Mahasiswa</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $jumlahmahasiswasaatini ?></div>
              <div class="mt-2 mb-0 text-muted text-xs">
                <span>Tergabung di sistem</span>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-solid fa-users fa-2x text-success"></i>
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
              <div class="text-xs font-weight-bold text-uppercase mb-1">Jam Saat Ini</div>
              <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $jamsaatini; ?></div>
              <div class="mt-2 mb-0 text-muted text-xs">
                <span>Asia/Jakarta (GMT+7)</span>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-clock fa-2x text-info"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php showperiodeaktif(); ?>
  </div>
</div>