<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <div class="<?php echo $SIDEBAR_background; ?>">
      <a class="sidebar-brand d-flex align-items-center justify-content-center bg-transparent"  href="index.php">
        <div class="sidebar-brand-icon">
          <img class="rounded-circle" style="width: 35px; height: 35px; object-fit: fill;" src="<?php echo $pp ?>">
        </div>
        <div class="sidebar-brand-text mx-3"><?php echo ucfirst($S_rolestatus) ?></div>
      </a>
    </div>
    <div class="sticky-top navbar-nav">
      <hr class="sidebar-divider my-0">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Umum
      </div>
      <?php linklab() ?>
      <?php if(($S_rolestatus == "mahasiswa")){showkelas(); } ?>
      <?php if(($S_rolestatus != "dosen") && ($S_rolestatus != "mahasiswa")){showpraktikumdropdown();}?>
      <?php
        if($S_rolestatus == "dosen"){
          echo "
              <li class='nav-item'>
                <a class='nav-link collapsed' href='".$LINK_riwayatkelas."' aria-expanded='true'>
                  <i class='fab fa-fw fa-wpforms'></i>
                  <span>Praktikum Aktif</span>
                </a>
              </li>
          ";
        }
      ?>
      <?php
        if($S_rolestatus != "admin"){
          echo "
              <li class='nav-item'>
                <a class='nav-link collapsed' href='".$LINK_kelaslampau."' aria-expanded='true'>
                  <i class='fa fa-clock'></i>
                  <span>Praktikum Lampau</span>
                </a>
              </li>
          ";
        }
      ?>
      <?php linkuser() ?>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Profile
      </div>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage" aria-expanded="true"
          aria-controls="collapsePage">
          <i class="fas fa-fw fa-columns"></i>
          <span>Profil</span>
        </a>
        <div id="collapsePage" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Tentang Profil</h6>
            <a class="collapse-item" href="<?php echo $LINK_profile ?>">Profile Saya</a>
            
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Logout</span>
        </a>
      </li>
      <hr class="sidebar-divider">
      <div class="version" id="version-ruangadmin"></div>
    </div>
</ul>
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-danger" id="exampleModalLabelLogout">Ohh No!</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin ingin <span class="text-danger">logout</span> ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-success" data-dismiss="modal">Cancel</button>
          <a href="logout" class="btn btn-danger">Logout</a>
        </div>
      </div>
    </div>
  </div>