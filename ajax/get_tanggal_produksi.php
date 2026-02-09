<?php
include '../connect.php';
$id_produk = $_POST['id_produk'];

// Ambil semua tanggal produksi dari produk ini
$query = mysqli_query($konek, "
    SELECT p.id_produksi, p.tgl_produksi 
    FROM tb_produksi p
    WHERE p.id_produk = '$id_produk'
    AND NOT EXISTS (
        SELECT 1 FROM tb_kecacatan k WHERE k.id_produksi = p.id_produksi
    )
    ORDER BY p.tgl_produksi ASC
");

echo '<option value="">-- Pilih Tanggal Produksi --</option>';
while ($row = mysqli_fetch_assoc($query)) {
    echo '<option value="'.$row['tgl_produksi'].'">'.$row['tgl_produksi'].'</option>';
}
?>
