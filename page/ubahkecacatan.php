<?php
$id_produksi = $_GET['id_produksi'];
$produkQuery = mysqli_query($konek, "
    SELECT p.tgl_produksi, pr.nama_produk
    FROM tb_produksi p
    JOIN tb_produk pr ON pr.id_produk = p.id_produk
    WHERE p.id_produksi = '$id_produksi'
");
$produk = mysqli_fetch_assoc($produkQuery);

$jenisQuery = mysqli_query($konek, "SELECT * FROM tb_jenis_kecacatan");
$jenisKecacatan = [];
while ($row = mysqli_fetch_assoc($jenisQuery)) {
    $jenisKecacatan[$row['id_jenis_kecacatan']] = $row['nama_kecacatan'];
}

$kecacatanQuery = mysqli_query($konek, "SELECT * FROM tb_kecacatan WHERE id_produksi = '$id_produksi'");
$dataKecacatan = [];
while ($row = mysqli_fetch_assoc($kecacatanQuery)) {
    $dataKecacatan[$row['id_jenis_kecacatan']] = $row['jumlah'];
}
?>
<div class="panel-top panel-top-edit">
    <b><i class="fa fa-pencil-alt"></i> Ubah Kecacatan - <?= $produk['nama_produk'] ?> (<?= $produk['tgl_produksi'] ?>)</b>
</div>

<form method="POST" action="./proses/prosesubah.php">
    <input type="hidden" name="op" value="kecacatan">
    <input type="hidden" name="id_produksi" value="<?= $id_produksi ?>">

    <div class="panel-middle">
        <?php foreach ($jenisKecacatan as $id_jenis => $nama): ?>
            <div class="group-input">
                <label><?= ucfirst($nama) ?>:</label>
                <input type="number" name="jumlah[<?= $id_jenis ?>]" class="form-custom" value="<?= $dataKecacatan[$id_jenis] ?? 0 ?>">
            </div>
        <?php endforeach; ?>
    </div>

    <div class="panel-bottom">
        <button type="submit" class="btn btn-green"><i class="fa fa-save"></i> Simpan</button>
        <a href="?page=kecacatan" class="btn btn-second">Batal</a>
    </div>
</form>