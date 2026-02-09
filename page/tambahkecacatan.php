
<div class="panel-top">
    <b class="text-green">Tambah Kecacatan</b>
</div>
<div class="panel-middle">
    <form id="form" method="POST" action="./proses/prosestambah.php">
    <input type="hidden" name="op" value="kecacatan">
        <div class="group-input">
            <label>Nama Produk:</label>
            <select class="form-custom" id="id_produk" name="id_produk" required>
                <option value="">-- Pilih Produk --</option>
                <?php
                $produk = mysqli_query($konek, "
                    SELECT * FROM tb_produk 
                    WHERE id_produk IN (
                        SELECT id_produk FROM tb_produksi 
                        WHERE id_produksi NOT IN (
                            SELECT id_produksi FROM tb_kecacatan
                        )
                    )
                ");
            
                while ($p = mysqli_fetch_assoc($produk)) {
                    echo '<option value="'.$p['id_produk'].'">'.$p['nama_produk']. ' - ' .$p['jenis_kemasan'].'</option>';
                }
                ?>
            </select>
        </div>
        <div class="group-input">
            <label>Tanggal Produksi:</label>
            <select class="form-custom" name="tgl_produksi" id="tgl_produksi" required>
                <option value="">-- Pilih Tanggal Produksi --</option>
            </select>
        </div>
        <div class="group-input">
            <h4>Masukkan Jumlah Cacat:</h4>
            <?php
                $jenis = mysqli_query($konek, "SELECT * FROM tb_jenis_kecacatan");
                while ($j = mysqli_fetch_assoc($jenis)) {
                echo '
                    <label>'. ucfirst($j['nama_kecacatan']).'</label>
                    <input class="form-custom" type="number" name="kecacatan['.$j['id_jenis_kecacatan'].']" min="0" value="0"><br>
                ';
                }
            ?>
            <br>
        </div>
        <div class="panel-bottom">
        <button type="submit" id="buttonsimpan" class="btn btn-green"><i class="fa fa-save"></i> Simpan</button>
        <button type="reset" id="buttonreset" class="btn btn-second">Reset</button>
        <a href="?page=jeniskecacatan" class="btn btn-info"><i class="fa fa-edit"> Kelola Jenis Kecacatan</i></a>
    </div>
    </form>
</div>

