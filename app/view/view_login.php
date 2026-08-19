<div class="container-login justify-content-center">
  <div class="row justify-content-center align-item-center">
    <div class="col-xl-6 col-lg-12 col-md-9">
      <div class="card shadow-sm my-5">
        <div class="card-body p-0">
          <div class="row">
            <div class="col-lg-12">
              <div class="login-form">
                <div class="text-center">
                  <img src="<?php echo $__asset; ?>images/logo_lab_color.png" alt="" class="w-25">
                </div>
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">Login</h1>
                </div>
                <div class="text-center">
                  <h1 class="h6 text-gray-900 mb-4">Izinkan Sistem Mengenali Anda.</h1>
                </div>
                <?php if(isset($alert)){echo $alert;} ?>
                <form class="user" method="post">
                  <div class="form-group">
                    <input type="text" class="form-control" id="Inputid" name="inputid" aria-describedby="emailHelp"
                      placeholder="Masukkan NIP/NPM">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control" name="inputpassword" id="Inputpassword" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <input type="submit" name="login" class="btn btn-info btn-block" value="Login">
                  </div>
                </form>
                <hr>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>