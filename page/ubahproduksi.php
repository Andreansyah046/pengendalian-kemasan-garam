<?php
$id = htmlspecialchars(@$_GET['id']);
$query = "SELECT p.*, pr.nama_produk, pr.jenis_kemasan 
          FROM tb_produksi p 
          JOIN tb_produk pr ON p.id_produk = pr.id_produk 
          WHERE p.id_produksi='$id'";
$execute = $konek->query($query);
if ($execute->num_rows > 0){
    $data = $execute->fetch_array(MYSQLI_ASSOC);
}else{
    header('location:./?page=produksi');
    exit;
}
?>
<div class="panel-top panel-top-edit">
    <b><i class="fa fa-pencil-alt"></i> Ubah Data Produksi</b>
</div>
<form id="form" method="POST" action="./proses/prosesubah.php">
    <input type="hidden" name="op" value="produksi">
    <input type="hidden" name="id_produksi" value="<?php echo $data['id_produksi']; ?>">
    <div class="panel-middle">

        <div class="group-input">
            <label for="id_produk">Nama Produk :</label>
            <select class="form-custom" id="id_produk" name="id_produk" required>
                <option value="">-- Pilih Produk --</option>
                <?php
                $produk = mysqli_query($konek, "SELECT * FROM tb_produk");
                while ($p = mysqli_fetch_assoc($produk)) {
                    $selected = ($p['id_produk'] == $data['id_produk']) ? 'selected' : '';
                    echo '<option value="'.$p['id_produk'].'" '.$selected.'>'.$p['nama_produk'].' - '.$p['jenis_kemasan'].'</option>';
                }
                ?>
            </select>
        </div>

        <div class="group-input">
            <label for="tgl_produksi">Tanggal Produksi :</label>
            <input type="date" value="<?php echo $data['tgl_produksi']; ?>" class="form-custom" required id="tgl_produksi" name="tgl_produksi">
        </div>

        <div class="group-input">
            <label for="jumlah_produksi">Total Produksi :</label>
            <input type="number" value="<?php echo $data['total_produksi']; ?>" class="form-custom" required id="jumlah_produksi" name="jumlah_produksi">
        </div>

    </div>
    <div class="panel-bottom">
        <button type="submit" id="buttonsimpan" class="btn btn-green"><i class="fa fa-save"></i> Simpan</button>
        <button type="reset" class="btn btn-second">Reset</button>
    </div>
</form>
