<div class="card mt-3">
  <div class="card-header m-0 pb-0">
    <h5 class="text-primary"><b>Cek Persyaratan</b></h5>
  </div>
  <!-- <div class="card-body">
     <div class="form-group">
        <label for="select2Multiple" class="font-weight-bold">Pengumpulan Kwitansi</label>
        <select class="select2-multiple form-control" name="states[]" multiple="multiple" id="select2Multiple">
            <?php //enrolsyarat(); ?>
        </select>
    </div>
    <input type="submit" class="btn btn-success" value="Input Kwitansi">
  </div> -->
  <div class="card-body">
    <!-- <hr> -->
    <div class="table-responsive">
        <table class="table align-items-center table-flush " id="tabelsyarat1">
            <thead class="thead-light text-center">
                <tr>
                    <th>NO.</th>
                    <th>NPM</th>
                    <th>NAMA</th>
                    <th>KWITANSI</th>
                    <th>FOTO</th>
                    <th>MODUL</th>
                </tr>
            </thead>
            <tbody class="text-center">
              <form method="post">
                <?php enrolsyarat(); ?>
              </form>
            </tbody>
        </table>
    </div>
  </div>
</div>