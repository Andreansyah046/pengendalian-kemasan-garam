<?php
$id = htmlspecialchars(@$_GET['id']);
$query = "SELECT * FROM tb_produk WHERE id_produk ='$id'";
$execute = $konek->query($query);
if ($execute->num_rows > 0) {
    $data = $execute->fetch_array(MYSQLI_ASSOC);
} else {
    header('location:./?page=barang');
    exit;
}
?>

<div class="panel-top panel-top-edit">
    <b><i class="fa fa-pencil-alt"></i> Ubah Data Barang</b>
</div>

<form id="form" method="POST" action="./proses/prosesubah.php">
    <input type="hidden" name="op" value="barang">
    <input type="hidden" name="id" value="<?php echo $data['id_produk']; ?>">

    <div class="panel-middle">
        <div class="group-input">
            <label for="nama_barang">Nama Barang:</label>
            <input type="text" value="<?php echo htmlspecialchars($data['nama_produk']); ?>" class="form-custom" required autocomplete="off" placeholder="Nama Barang" id="nama_barang" name="barang">
        </div>


        <div class="group-input">
            <label for="jenis_kemasan">Jenis Kemasan</label>
            <select class="form-custom" required name="jenis_kemasan" id="jenis_kemasan">
                <option selected disabled>--Pilih Jenis Kemasan--</option>
                <?php
                $queryJenis = "SELECT * FROM tb_produk";
                $executeJenis = $konek->query($queryJenis);
                if ($executeJenis->num_rows > 0){
                    while($row = $executeJenis->fetch_array(MYSQLI_ASSOC)){
                        $selected = ($data['jenis_kemasan'] == $row['jenis_kemasan']) ? 'selected' : '';
                        echo "<option value=\"{$row['jenis_kemasan']}\" $selected>{$row['jenis_kemasan']}</option>";
                    }
                } else {
                    echo "<option value=\"\">Belum ada Jenis Barang</option>";
                }
                ?>
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
