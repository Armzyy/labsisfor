<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">User Edit</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">E-Laboratorium</a></li>
      <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="<?php echo $S_rolestatus ?>?page=user">User</a></li>
      <li class="breadcrumb-item active" aria-current="page">User edit</li>
    </ol>
  </div>
<div class="row mb-3">
  <div class="col-xl-12 col-lg-7 mb-4">
    <div class="card">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Edit Data User</h6>
      </div>
        <div class="card-body">
        <form method='post'>
            <div class='form-group'>
                <label for='editnameuser'><b>Username user <span class="text-danger">*</span> </b></label>
                <input type='text' class='form-control' id='editnameuser' name='editnameuser' placeholder='Masukkan nama user ' value='<?php echo $usernameedit; ?>'>
            </div>
            <div class='form-group'>
                <label for='editroleuser'><b>Role user <span class="text-danger">*</span></b> <span class='text-success'>options: dosen / mahasiswa </span></label>
                <input type='text' class='form-control' id='editroleuser' name='editroleuser' placeholder='Masukkan role user' value='<?php echo $roleedit; ?>'>
            </div>
            <div class='form-group'>
                <label for='editfirstnameuser'><b>Fullname user <span class="text-danger">*</span></b></label>
                <input type='text' class='form-control' id='editfirstnameuser' name='editfirstnameuser' placeholder='Masukkan fullname user' value='<?php echo $firstnameedit; ?>'>
            </div>
            <div class='form-group'>
                <label for='editemailuser'><b>Email user <span class="text-danger">*</span></b></label>
                <input type='text' class='form-control' id='editemailuser' name='editemailuser' placeholder='Masukkan email user' value='<?php echo $emailedit; ?>'>
            </div>
            <div class='form-group'>
                <label for='editphoneuser'><b>Phone user <span class="text-danger">*</span></b></label>
                <input type='text' class='form-control' id='editphoneuser' name='editphoneuser' placeholder='Masukkan phone user' value='<?php echo $phoneedit; ?>'>
            </div>
            <div class='form-group'>
                <label for='editalamatuser'><b>Alamat user </b></label>
                <input type='text' class='form-control' id='editalamatuser' name='editalamatuser' placeholder='Masukkan alamat user' value='<?php echo $addressedit; ?>'>
            </div>
            <div class='form-group'>
                <label for='editkotauser'><b>Kota asal user </b></label>
                <input type='text' class='form-control' id='editkotauser' name='editkotauser' placeholder='Masukkan kota asal user' value='<?php echo $cityedit; ?>'>
            </div>
            <div class='text-center'>
                <input type='submit' class='btn btn-danger mb-1 col-xl-5' name='canceledit' value='Cancel'>
                <input type='submit' class='btn btn-success mb-1 col-xl-5' name='terimaedit' value='Edit'>
            </div>
        </form>
            
        </div>
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Paksa ganti password user id: <?php echo $getuserid ?></h6>
        </div>
        <div class="card-body">
        <form method='post'>
            <div class='form-group'>
                <label for='editpassworduser'><b>Password user <span class='text-success'>Default: <span class="text-lowercase">[nama depan]_12345678</span> </b></label>
                <input type='password' class='form-control' id='editnameuser' name='editpassworduser' placeholder='password'>
            </div>
            <div class='form-group'>
                <label for='editpassworduser'><b>Konfirmasi password user</b></label>
                <input type='password' class='form-control' id='editnameuser' name='editpassworduser' placeholder='password'>
            </div>
            <div class='text-center'>
                <input type='submit' class='btn btn-success mb-1 col-xl-5' name='forcepassword' value='Paksa ganti'>
            </div>
        </form>
      <div class="card-footer"></div>
    </div>
    <br>
  </div>
</div>
</div>