<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Periode Praktikum</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">E-Laboratorium</a></li>
      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Periode</li>
    </ol>
  </div>
  <div class="row mb-3">
    <div class="col-xl-8 col-lg-7 mb-4">
      <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Daftar Periode Praktikum</h6>
        </div>
        <div class="table-responsive">
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th>ID</th>
                <th>Nama Periode</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
                <?php showdataperiode(); ?>
            </tbody>
          </table>
        </div>
        <div class="card-footer"></div>
      </div>
    </div>
    <div class="col-xl-4 col-lg-5">
        <?php if(isset($alert)){echo $alert;}  ?>
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Tambah Periode</h6>
          <div class="dropdown no-arrow">
          </div>
        </div>
        <div class="card-body">
             <form method="post">
                <div class="form-group">
                    <label for="label-nama-periode">Nama Periode</label>
                    <input type="text" class="form-control" name="inputnamaperiode" id="label-nama-periode"
                    placeholder="Contoh: 2023/2024">
                </div>
                <div class="form-group">
                    <input type="submit" name="tambah_periode" class="btn btn-info btn-block" value="Tambahkan">
                </div>
            </form>
        </div>
      </div>
    </div>
</div>