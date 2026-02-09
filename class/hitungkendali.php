<?php
include './connect.php';

// Ambil nama produk untuk dropdown
$produkQuery = "SELECT DISTINCT nama_produk FROM view_hasil_kendali";
$produkResult = $konek->query($produkQuery);

$filter_produk = isset($_GET['produk']) ? $_GET['produk'] : '';
$tanggal_mulai = isset($_GET['tanggal_mulai']) ? $_GET['tanggal_mulai'] : '';
$tanggal_selesai = isset($_GET['tanggal_selesai']) ? $_GET['tanggal_selesai'] : '';

// Hitung total produksi & cacat berdasarkan filter
$filterQuery = "
    SELECT p.id_produksi, p.total_produksi, 
           (SELECT SUM(jumlah) FROM tb_kecacatan k WHERE k.id_produksi = p.id_produksi) AS jumlah_cacat
    FROM tb_produksi p
    JOIN tb_produk pr ON p.id_produk = pr.id_produk
    WHERE 1=1
";

if (!empty($filter_produk)) {
    $produk_safe = $konek->real_escape_string($filter_produk);
    $filterQuery .= " AND pr.nama_produk = '$produk_safe'";
}

if (!empty($tanggal_mulai)) {
    $filterQuery .= " AND p.tgl_produksi >= '$tanggal_mulai'";
}
if (!empty($tanggal_selesai)) {
    $filterQuery .= " AND p.tgl_produksi <= '$tanggal_selesai'";
}

$resultFilter = $konek->query($filterQuery);

$total_produksi_semua = 0;
$total_cacat_semua = 0;

while ($row = $resultFilter->fetch_assoc()) {
    $total_produksi_semua += (int)$row['total_produksi'];
    $total_cacat_semua += (int)$row['jumlah_cacat'];
}

$cl = ($total_produksi_semua > 0) ? ($total_cacat_semua / $total_produksi_semua) : 0;

// Proses data kendali (bisa kamu skip kalau udah pernah dijalankan)
$sqlProduksi = "SELECT * FROM tb_produksi";
$result = $konek->query($sqlProduksi);

while ($row = $result->fetch_assoc()) {
    $id_produksi = $row['id_produksi'];
    $jumlah_produksi = (int)$row['total_produksi'];
    $sqlCacat = "SELECT SUM(jumlah) as total_cacat FROM tb_kecacatan WHERE id_produksi = $id_produksi";
    $jumlah_cacat = (int)$konek->query($sqlCacat)->fetch_assoc()['total_cacat'];
    
    if ($jumlah_produksi > 0 && $jumlah_cacat <= $jumlah_produksi) {
        $proporsi = $jumlah_cacat / $jumlah_produksi;
        $stdErr = sqrt(($cl * (1 - $cl)) / $jumlah_produksi);
        $ucl = $cl + 3 * $stdErr;
        $lcl = max(0, $cl - 3 * $stdErr);

        $cek = $konek->query("SELECT id_kendali FROM tb_kendali WHERE id_produksi = $id_produksi");
        $query = ($cek->num_rows > 0) ?
            "UPDATE tb_kendali SET jumlah_produksi=$jumlah_produksi, jumlah_cacat=$jumlah_cacat, proporsi=$proporsi, cl=$cl, ucl=$ucl, lcl=$lcl WHERE id_produksi=$id_produksi" :
            "INSERT INTO tb_kendali (id_produksi, jumlah_produksi, jumlah_cacat, proporsi, cl, ucl, lcl) VALUES ($id_produksi, $jumlah_produksi, $jumlah_cacat, $proporsi, $cl, $ucl, $lcl)";
        
        $konek->query($query);
    }
}
?>