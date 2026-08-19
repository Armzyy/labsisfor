<div class='row mt-3' id='modul'>
    <div class='col-lg-12'>
        <div class="card">
            <h5 class="card-header">Format Penilaian Akhir</h5>
            <div class="card-body">
                <h5 class="card-title">Nilai Total : <?php Global $totalp; echo $totalp; ?>%</h5>
                <form method="post">
                    <label for="#penilaianaslab">Input persentase nilai asisten laboratorium <span class="text-xs">(Default 50%)</span></label>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" id="penilaianaslab" name="penilaianaslab" placeholder="Masukkan persentase nilai" value="<?php Global $aslabp; echo $aslabp; ?>" required>
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    <label for="#penilaiandosen">Input persentase nilai dosen pengampu <span class="text-xs">(Default 50%)</span></label>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" id="penilaiandosen" name="penilaiandosen" placeholder="Masukkan persentase nilai" value="<?php Global $dosenp; echo $dosenp; ?>" required>
                        <div class="input-group-append">
                            <span class="input-group-text text-xs">%</span>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary" name="submitpenilaian" id="submitpenilaian" value="Update">
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-lg-7 mt-4">
      <div class="card">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-secondary">Riwayat Aktifitas</h6>
            <hr>
            <table style="font-family: courier;font-size:16px" class="font-weight-bold" width="100%">
                <?php showlogformatnilai(); ?>
            </table>
          </div>
      </div>
    </div>
</div>