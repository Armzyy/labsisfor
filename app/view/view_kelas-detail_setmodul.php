<div class="card mt-3">
    <div class="card-header">
        <h5><b>Buat Jadwal</b></h5>
    </div>
    <div class="card-body">
        <p>Nama Jadwal</p>
        <form method="post">
            <input type="text" class="form-control" placeholder="Contoh : Senin 1" name="namajadwal" required>
            <div class="row mt-2">
                <div class="col-6">
                    <p>Hari mengajar</p>
                    <select class="form-control" name="harimengajar" required>
                        <option value="">Pilih hari</option>
                        <option value="senin">Senin</option>
                        <option value="selasa">Selasa</option>
                        <option value="rabu">Rabu</option>
                        <option value="kamis">Kamis</option>
                        <option value="jumat">Jum"at</option>
                    </select>
                </div>
                <div class="col-6">
                    <p>Jam mengajar</p>
                    <div class="form-group">
                        <div class="input-daterange input-group">
                            <input type="time" class="input-sm form-control" name="jamstart" required>
                            <div class="input-group-prepend">
                                <span class="input-group-text">sampai</span>
                            </div>
                            <input type="time" class="input-sm form-control" name="jamend" required>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-center">
                    <input type="submit" class="btn btn-success w-50" name="inputjadwalkelas" value="Tambah Jadwal">
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card mt-3">
  <div class="card-body">
    <div class="row">
        <div class="col-6">
            <h5><b>List Jadwal</b></h5>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php showjadwal(); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-6">
            <h5>
                <b>List Asisten</b>
                <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#tambahaslabmengajar">
                    Tambah Asisten
                </button>
            </h5>
            <div class="modal fade" id="tambahaslabmengajar" tabindex="-1" role="dialog" aria-labelledby="tambahaslabmengajarLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahaslabmengajarLabel">Asisten Mengajar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post">
                        <div class="modal-body">
                            <p>Pilih Jadwal</p>
                            <select class="custom-select" id="jadwalmengajar" name="inputjadwalmengajar" required>
                                <option value="">Pilih jadwal</option>
                                <?php optionjadwal(); ?>
                            </select>
                            <p class="mt-3">Asisten (multiple)</p>
                            <select class="custom-select" name="asistenmengajar[]" multiple="multiple" required>
                                <option value="">Pilih Asisten</option>
                                <?php optionasisten(); ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-success" name="tambahasistenjadwal" value="Tambah">
                        </div>
                    </form>
                </div>
            </div>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jadwal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php showasistenmengajar(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div>
</div>