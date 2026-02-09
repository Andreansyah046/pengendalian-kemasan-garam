<?php include "./class/hitungkendali.php"?>

<div class="panel">
    <div class="panel-middle" id="judul">
        <img src="asset/image/kriteria.svg">
        <div id="judul-text">
            <h2 class="text-green">Hasil Perhitungan</h2>
            Hasil Perhitungan kendali
        </div>
    </div>
</div>
<div class="panel">
    <style>
        .filter-form {
            display: flex;
            padding: 10px 20px 0 20px;
            gap: 20px;
            align-items: flex-end;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .form-custom {
            padding: 5px;
            min-width: 150px;
        }
    </style>

    <form method="GET" action="">
        <input type="hidden" name="page" value="hasilkendali">
        <div class="filter-form">
            <div class="filter-group">
                <label>Nama Produk:</label>
                <select class="form-custom" name="produk" onchange="this.form.submit()">
                    <option value="">-- Semua Produk --</option>
                    <?php
                    while ($row = $produkResult->fetch_assoc()) {
                        $selected = ($filter_produk === $row['nama_produk']) ? 'selected' : '';
                        echo "<option value=\"{$row['nama_produk']}\" $selected>{$row['nama_produk']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="filter-group">
                <label>Tanggal Mulai:</label>
                <input type="date" class="form-custom" name="tanggal_mulai" value="<?= $tanggal_mulai ?>">
            </div>

            <div class="filter-group">
                <label>Tanggal Selesai:</label>
                <input type="date" class="form-custom" name="tanggal_selesai" value="<?= $tanggal_selesai ?>">
            </div>

            <div class="filter-group">
                <label style="visibility: hidden;">Terapkan</label>
                <button type="submit" class="form-custom">Terapkan</button>
            </div>
        </div>
    </form>

    <div class="panel-middle">
        <div class="container bg-light rounded pt-1 pb-3">
            <div class="row">
                <div class="col-md-2">Nama Produk</div>
                <div class="col-md-7">: <?= !isset($_GET["produk"]) || $_GET["produk"] == "" ? "Semua Produk" : $_GET["produk"] ?></div>
            </div>
            <div class="row">
                <div class="col-md-2">Total Produksi</div>
                <div class="col-md-7">: <?= $total_produksi_semua ?> Pcs</div>
            </div>
            <div class="row">
                <div class="col-md-2">Total Kecacatan</div>
                <div class="col-md-7">: <?= $total_cacat_semua ?> Pcs</div>
            </div>
        </div>
        <div class="table-responsive mt-4">
            <table id="formatTgl" class="table table-bordered display">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Produksi</th>
                        <th>Jumlah Produksi</th>
                        <th>Jumlah Cacat</th>
                        <th>Proporsi</th>
                        <th>CL</th>
                        <th>UCL</th>
                        <th>LCL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM view_hasil_kendali WHERE 1=1";

                    if ($filter_produk) {
                        $produk_safe = $konek->real_escape_string($filter_produk);
                        $query .= " AND nama_produk = '$produk_safe'";
                    }

                    if ($tanggal_mulai && $tanggal_selesai) {
                        $query .= " AND tgl_produksi BETWEEN '$tanggal_mulai' AND '$tanggal_selesai'";
                    } elseif ($tanggal_mulai) {
                        $query .= " AND tgl_produksi >= '$tanggal_mulai'";
                    } elseif ($tanggal_selesai) {
                        $query .= " AND tgl_produksi <= '$tanggal_selesai'";
                    }

                    $result = $konek->query($query);
                    $no = 1;

                    if ($result && $result->num_rows > 0) {
                        while ($data = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$no}</td>
                                <td>{$data['tgl_produksi']}</td>
                                <td>{$data['jumlah_produksi']}</td>
                                <td>{$data['jumlah_cacat']}</td>
                                <td>{$data['proporsi']}</td>
                                <td>{$data['cl']}</td>
                                <td>{$data['ucl']}</td>
                                <td>{$data['lcl']}</td>
                            </tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='9' style='text-align:center;'>Data tidak tersedia.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel-bottom">
        <div style="width:100%; max-width:900px; margin:30px auto;">
            <canvas id="kendaliChart"></canvas>
        </div>
    </div>
</div>
<?php
// Siapkan data chart dari hasil query yang sama
$chartQuery = $query; // ini sudah difilter
$chartResult = $konek->query($chartQuery);

$labels = [];
$proporsi = [];
$clData = [];
$uclData = [];
$lclData = [];

while ($row = $chartResult->fetch_assoc()) {
    $labels[] = $row['tgl_produksi'];
    $proporsi[] = $row['proporsi'];
    $clData[] = $row['cl'];
    $uclData[] = $row['ucl'];
    $lclData[] = $row['lcl'];
}
?>

