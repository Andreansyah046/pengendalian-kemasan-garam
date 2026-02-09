<div class="panel-top">
    <b class="text-green"><i class="fa fa-plus-circle text-green"></i> Tambah data</b>
</div>
<form id="form" method="POST" action="./proses/prosestambah.php">
    <input type="hidden" name="op" value="barang">
    <div class="panel-middle">
        <div class="group-input">
            <label for="barang">Nama Produk :</label>
            <input type="text" class="form-custom" required autocomplete="off" placeholder="Nama Produk" id="barang" name="barang">
        </div>
        <div class="group-input">
            <label for="jenis_kemasan">Jenis Kemasan :</label>
            <select class="form-custom" required id="jenis_kemasan" name="jenis_kemasan">
                <option selected disabled>-- Pilih Jenis Kemasan --</option>
                <option value="Kemasan 150 gram">Kemasan 150 gram</option>
                <option value="Kemasan 250 gram">Kemasan 250 gram</option>
                <option value="Kemasan 500 gram">Kemasan 500 gram</option>
                <option value="Kemasan 1000 gram">Kemasan 1000 gram</option>
            </select>
        </div>
    </div>
    <div class="panel-bottom">
        <button type="submit" id="buttonsimpan" class="btn btn-green"><i class="fa fa-save"></i> Simpan</button>
        <button type="reset" id="buttonreset" class="btn btn-second">Reset</button>
    </div>
</form>
