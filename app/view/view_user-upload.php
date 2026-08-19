<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">User Upload</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">E-Laboratorium</li>
      <li class="breadcrumb-item">Dashboard</li>
      <li class="breadcrumb-item">User</li>
      <li class="breadcrumb-item active" aria-current="page">User Upload</li>
    </ol>
  </div>
<div class="row mb-3">
  <div class="col-xl-12 col-lg-7 mb-4">
    <div class="card mb-4">
      <div class="card-body text-center">
        <form method="post">
          <input type="submit" class="btn btn-danger mb-1 col-xl-5" id='cancelupload' name="cancelupload" value="Cancel">
          <input type="submit" class="btn btn-success mb-1 col-xl-5" name="terimaupload" value="Upload">
        </form>
      </div>
    </div>
    <div class="card">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Verifikasi User</h6>
      </div>
      <div class="table-responsive p-3">
        <table class="table align-items-center table-flush" id="tableuserupload">
          <thead class="thead-light">
            <tr>
              <th>Username</th>
              <th>Password</th>
              <th>Role</th>   
              <th>Firstname</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Address</th>
              <th>City</th>
            </tr>
          </thead>
          <tbody>
              <?php showcsv(); ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>