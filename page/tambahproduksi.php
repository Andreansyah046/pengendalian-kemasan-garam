<div class="panel-top">
    <b class="text-green"><i class="fa fa-plus-circle text-green"></i> Tambah data</b>
</div>
<form id="form" method="POST" action="./proses/prosestambah.php">
    <input type="hidden" name="op" value="produksi">
    
    <div class="panel-middle">

        <!-- Nama Produk -->
        <div class="group-input">
            <label for="id_produk">Nama Produk</label>
            <select class="form-custom" required name="id_produk" id="id_produk">
                <option selected disabled>--Pilih Nama Produk--</option>
                <?php
                $query = "SELECT * FROM tb_produk";
                $execute = $konek->query($query);
                if ($execute->num_rows > 0){
                    while($data = $execute->fetch_array(MYSQLI_ASSOC)){
                        echo "<option value=\"{$data['id_produk']}\">{$data['nama_produk']} - {$data['jenis_kemasan']}</option>";
                    }
                } else {
                    echo "<option value=\"\">Belum ada Jenis Barang</option>";
                }
                ?>
            </select>
        </div>

        <!-- Tanggal Produksi -->
        <div class="group-input">
            <label for="tgl_produksi">Tanggal Produksi</label>
            <input type="date" class="form-custom" required autocomplete="off" name="tgl_produksi" id="tgl_produksi">
        
        </div>

        <!-- Input Cacat -->
        <div class="group-input">
            <label for="jumlah_produksi">Total Produksi</label>
            <input type="number" class="form-custom" required autocomplete="off" placeholder="Jumlah Produksi" id="jumlah_produksi" name="jumlah_produksi">
        </div>
    </div>

    <div class="panel-bottom">
        <button type="submit" id="buttonsimpan" class="btn btn-green"><i class="fa fa-save"></i> Simpan</button>
        <button type="reset" id="buttonreset" class="btn btn-second">Reset</button>
    </div>
</form>
