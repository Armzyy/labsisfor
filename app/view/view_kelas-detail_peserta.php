<?php btnpesertamanual(); ?>
<?php btnaslabmanual(); ?>
<?php btndosenmanual(); ?>
<?php btnpesertacsv(); ?>

<div class="mt-3">
    <?php navpeserta() ?>
</div>
<div class="card mb-4 mt-2">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <?php tabmahasiswa(); ?>
    </div>
    <div class="table-responsive p-3">
        <table class="table align-items-center table-flush " id="tablepeserta">
            <thead class="thead-light">
                <tr>
                    <th class="text-center">Foto</th>
                    <th>NIP/NPM</th>
                    <th>Nama</th>
                    <th>Peranan</th>
                    <!-- aadad -->
                    <?php theadpeserta() ?>
                </tr>
            </thead>
            <tbody>
                <?php showpeserta(); ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer"></div>
</div>


