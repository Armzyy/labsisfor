<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">User</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">E-Laboratorium</a></li>
      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">User</li>
    </ol>
  </div>
  <?php if(isset($alert)){echo $alert;} ?>
  <?php echo $lasttryerror; ?>
  <div class="row mb-3">
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">DataTables</h6>
        </div>
        <div class="table-responsive p-3">
          <table class="table align-items-center table-flush" id="tableuser">
            <thead class="thead-light">
              <tr>
                <th>NIP/NPM</th>
                <th>Nama</th>
                <th>Role</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>NIP/NPM</th>
                <th>Nama</th>
                <th>Role</th>
                <th>Edit</th>
              </tr>
            </tfoot>
            <tbody>
              <?php showuser(); ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Tambah User</h6>
          <div class="dropdown no-arrow"></div>
        </div>
        <div class="card-body">
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#manualuser">Tambah User</button>
        <div class="modal fade" id="manualuser" tabindex="-1" role="dialog" aria-labelledby="manualusermodal" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="manualusermodal">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="input-username-user">Username (NPM/NIP) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="inputusernameuser" id="input-username-user" placeholder="Masukkan Username" required>
                    </div>
                    <div class="form-group">
                        <label for="input-password-user">Password <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="inputpassworduser" id="input-password-user" placeholder="Masukkan Password" required>
                    </div>
                    <div class="form-group">
                        <label for="input-role-user">Role <span class="text-danger">*</span></label>
                        <select class="form-control" name="inputroleuser" id="input-role-user" required>
                          <option value="mahasiswa">Mahasiswa</option>
                          <option value="dosen">Dosen</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="input-firstname-user">Fullname <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="inputfirstnameuser" id="input-firstname-user" placeholder="Masukkan Fullname" required>
                    </div>
                    <div class="form-group">
                        <label for="input-email-user">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="inputemailuser" id="input-email-user" placeholder="Masukkan Email" required>
                    </div>
                    <div class="form-group">
                        <label for="input-phone-user">Nomor Telepon <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="inputphoneuser" id="input-phone-user" placeholder="Masukkan Nomor Telepon" required>
                    </div>
                    <div class="form-group">
                        <label for="input-address-user">Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="inputaddressuser" id="input-address-user" placeholder="Masukkan Alamat" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="input-city-user">Kota <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="inputcityuser" id="input-city-user" placeholder="Masukkan Kota" required>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                  <input type="submit" name="inputmanualuser" class="btn btn-success" value="Tambah User">
                </div>
              </form>
            </div>
          </div>
        </div>
            <form method="post" enctype="multipart/form-data">
              <a href="<?php echo LINK_download("asset/data/contoh/uploaduser.csv") ?>">Contoh File upload_user.csv</a>
              <input type="file" class="text-white btn btn-info form-control-file" name="uploaduser" id="uploaduser" required>
              <div class="form-group">
                <br>
                <label for="delimiter" style="font-size: 12px;">Gunakan delimiter Titik Koma (;), bukan .csv UTF-8</label>
              </div>
              <div class="form-group">
                  <input type="submit" name="inputuser" class="btn btn-info btn-block" value="Upload">
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>