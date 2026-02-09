<?php

$query = "SELECT COUNT(*) AS total_produk FROM tb_produk";
$result = mysqli_query($konek, $query);
$data = mysqli_fetch_assoc($result);
$jumlah_produk = $data['total_produk'];

$queryProduksi = "SELECT SUM(total_produksi) AS total_produksi FROM tb_produksi";
$resultProduksi = mysqli_query($konek, $queryProduksi);
$dataProduksi = mysqli_fetch_assoc($resultProduksi);
$total_produksi = $dataProduksi['total_produksi'] ?? 0;

$queryCacat = "SELECT SUM(jumlah) AS total_cacat FROM tb_kecacatan";
$resultCacat = mysqli_query($konek, $queryCacat);
$dataCacat = mysqli_fetch_assoc($resultCacat);
$total_cacat = $dataCacat['total_cacat'] ?? 0;


$persentase_kecacatan = $total_produksi > 0 ? round(($total_cacat / $total_produksi) * 100, 2) : 0;

$queryGrafik = "SELECT tgl_produksi, SUM(total_produksi) as total FROM tb_produksi GROUP BY tgl_produksi ORDER BY tgl_produksi ASC";
$resultGrafik = mysqli_query($konek, $queryGrafik);

$tanggal = [];
$jumlah = [];

while ($row = mysqli_fetch_assoc($resultGrafik)) {
    $tanggal[] = $row['tgl_produksi'];
    $jumlah[] = $row['total'];
}


$queryCacatGrafik = "
  SELECT tb_produksi.tgl_produksi, SUM(tb_kecacatan.jumlah) AS total_cacat
  FROM tb_kecacatan
  JOIN tb_produksi ON tb_kecacatan.id_produksi = tb_produksi.id_produksi
  GROUP BY tb_produksi.tgl_produksi
  ORDER BY tb_produksi.tgl_produksi ASC
";

$resultCacatGrafik = mysqli_query($konek, $queryCacatGrafik);

$tanggal_cacat = [];
$jumlah_cacat = [];

while ($row = mysqli_fetch_assoc($resultCacatGrafik)) {
    $tanggal_cacat[] = $row['tgl_produksi'];
    $jumlah_cacat[] = $row['total_cacat'];
}

?>


<!-- Judul -->
<div class="container my-4">
    <div class="d-flex align-items-center bg-white p-3 rounded shadow-sm" id="judul">
      <img src="asset/image/beranda.svg" alt="icon">
      <div>
        <h2 class="text-green mb-0">BERANDA</h2>
        <small>Halaman Utama Quality Control</small>
      </div>
    </div>
  </div>

  <!-- Welcome Panel -->
  <div class="container mb-4">
    <div class="bg-white text-center p-4 rounded shadow-sm">
      <h1>
        Selamat Datang, <span class="text-green"><?= $_SESSION['nama']?> (<?= $_SESSION['role']?>)</span><br>
        di Sistem Pengendalian Kualitas pada Pengemasan Garam<br>
        <span class="text-green">Statistical Process Control</span>
      </h1>
    </div>
  </div>
<!-- Dashboard Cards -->
<div class="container mb-4">
  <div class="row g-3">
    <div class="col-md-3">
      <div class="card text-center shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Jumlah Produk</h5>
          <p class="card-text fs-4"><?= $jumlah_produk?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Total Produksi</h5>
          <p class="card-text fs-4"><?= $total_produksi?> Pcs</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Jumlah Kecacatan</h5>
          <p class="card-text fs-4"><?= $total_cacat?> Pcs</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Persentase Kecacatan</h5>
          <p class="card-text fs-4"><?= $persentase_kecacatan?>%</p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">  
    <div class="col-md-6 mt-5">
      <h4 class="mb-3">Grafik Produksi Garam per Tanggal</h4>
      <canvas id="grafikProduksi" height="200"></canvas>
    </div>
    <div class="col-md-6 mt-5">
      <h4 class="mb-3">Grafik Kecacatan per Tanggal</h4>
      <canvas id="grafikKecacatan" height="200"></canvas>
    </div>
  </div>
</div>
