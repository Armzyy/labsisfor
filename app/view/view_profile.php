<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profile Saya</h1>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">E-Laboratorium</a></li>
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Profile</li>
        </ol>
    </div>
    <?php if(isset($alert)){echo $alert;}  ?>
    <div class="card mb-3">
        <div class="row g-0 align-items-center m-3">
            <div class="col-md-4 text-center">
                <a href="#" data-toggle='modal' data-target='#updatepp'><img src="<?php echo $photopp ?>" class="img-fluid rounded-start rounded-circle mb-4 border border-primary" alt="Photo Profile" style="width: 200px; height: 200px; object-fit: fill;"></a>
                <small id="negarahelp" class="form-text text-muted pl-2 pb-2">Click photo to change. <br> (square orientation) <br> From <a href="https://pexels.com/" target="_blank">Pexels.com</a> Only</small>
            </div>
            <div class="modal fade" id="updatepp" tabindex="-1" role="dialog" aria-labelledby="modaltambahpengumumantitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modaltambahpengumumantitle">Update Photo Profile</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>  
                        <div class="modal-body">
                            <form method="post">
                                <div class="form-group">
                                    <label for="input-photo-profile" class="text-left">Link Photo <span class="text-danger">*</span></label>
                                    <input type="url" class="form-control" name="inputphotoprofile" id="input-photo-profile" placeholder="Masukkan link photo" required>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-primary" name="updateprofile" value="Update PP">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card-body pb-0">
                    <h5 class="card-title text-primary"><b>Biodata</b></h5>
                    <hr>
                    <h5 class="text-dark"><?php echo $PROFILE['firstname']; ?></h5>
                    <h6 class="text-secondary"><?php echo $PROFILE['username'] ?></h6>
                    <p class="text-secondary" style="font-size: small;"><?php echo $PROFILE['institution']." - ".$PROFILE['departement'] ?></p>
                    <p><i class="text-danger mr-2 fas fa-solid fa-info-circle"></i>Hubungi Admin jika ada kesalahan data yang ditampilkan.</p>
                    <p class="card-text mt-4 mb-0 p-0 text-dark"><b>Random Quotes</b></p>
                    <p class="card-text ml-4 my-2 p-0"><i>" <?php echo $quotes[array_rand($quotes)] ?> "</i></p>
                    <hr>
                </div>
                <div class="card-footer">
                    <a class="small text-primary card-link" href="#" data-toggle="collapse" data-target="#detailprofile">Detail Profile <i class="fas fa-chevron-down"></i></a>
                </div>
                <div id="detailprofile" class="collapse">
                    <div class="row pl-3">
                        <div class="col-8">
                            <small id="telponhelp" class="form-text text-muted pl-2 pb-2">Nomor telepon aktif</small>
                            <form method="post">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">+62</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Masukkan nomor telepon" aria-label="phone" aria-describedby="basic-addon1" name="profiletelepon" value="<?php echo $PROFILE['phone'] ?>" required>
                                    <div class="input-group-append">
                                        <input type="submit" class="btn btn-info" name="submitprofiletelepon" value="Update">
                                    </div>
                                </div>
                            </form>
                            <small id="emailhelp" class="form-text text-muted pl-2 pb-2">Email aktif</small>
                            <form method="post">
                                <div class="input-group mb-3">
                                    <input type="email" class="form-control" placeholder="Masukkan email" aria-label="email" aria-describedby="basic-addon1" name="profileemail"  value="<?php echo $PROFILE['email'] ?>" required>
                                    <div class="input-group-append">
                                        <input type="submit" class="btn btn-info" name="submitprofileemail" value="Update">
                                    </div>
                                </div>
                            </form>
                            <small id="alamathelp" class="form-text text-muted pl-2 pb-2">Alamat domisili</small>
                            <form method="post">
                                <div class="input-group mb-3">
                                    <textarea class="form-control" aria-label="With textarea" placeholder="Masukkan alamat anda" name="alamatdomisili"><?php echo $PROFILE['address'] ?></textarea>
                                    <div class="input-group-append">
                                        <input type="submit" class="btn btn-info" name="submitalamatdomisili" value="Update">
                                    </div>
                                </div>
                            </form>
                            <small id="kotahelp" class="form-text text-muted pl-2 pb-2">Kota domisili</small>
                            <form method="post">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Masukkan kota anda" aria-label="city" aria-describedby="basic-addon1" name="kotadomisili"  value="<?php echo $PROFILE['city'] ?>" required>
                                    <div class="input-group-append">
                                        <input type="submit" class="btn btn-info" name="submitkotadomisili" value="Update">
                                    </div>
                                </div>
                            </form>
                            <a class="btn btn-danger" href="javascript:void(12);" data-toggle="modal" data-target="#passmodal">Ganti Password</a>
                            <div class="modal fade" id="passmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelpass" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title text-danger" id="exampleModalLabelpass">Ganti Password</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post">
                                        <div class="form-group">
                                            <label for="#inputpasswordlama">Password Lama</label>
                                            <input type="password" class="form-control" id="inputpasswordlama" name="inputpasswordlama" placeholder="Password" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="#inputpasswordbaru">Password Baru</label>
                                            <input type="password" class="form-control" id="inputpasswordbaru" name="inputpasswordbaru" placeholder="Password" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="#inputkonfirmasipasswordbaru">Konfirmasi Password Baru</label>
                                            <input type="password" class="form-control" id="inputkonfirmasipasswordbaru" name="inputkonfirmasipasswordbaru" placeholder="Password" required>
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>
                                        <input type="submit" class="btn btn-success" name="submitgantipassword" value="Update">
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if(isset($SVG)){echo $SVG;} ?>
    </div>
</div>