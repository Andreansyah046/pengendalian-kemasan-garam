<?php
include './connect.php';

// Ambil produk untuk dropdown
$produkQuery = "SELECT * FROM tb_produk";
$produkResult = $konek->query($produkQuery);

// Ambil data filter
$filter_produk = $_GET['produk'] ?? '';
$tanggal_mulai = $_GET['tanggal_mulai'] ?? '';
$tanggal_selesai = $_GET['tanggal_selesai'] ?? '';

// Inisialisasi filter
$where = "WHERE 1=1";
$id_produk = 0;

if (!empty($filter_produk)) {
    $idProdukQuery = mysqli_query($konek, "SELECT id_produk FROM tb_produk WHERE nama_produk = '$filter_produk'");
    $resultProduk = mysqli_fetch_assoc($idProdukQuery);
    if ($resultProduk) {
        $id_produk = $resultProduk['id_produk'];
        $where .= " AND p.id_produk = '$id_produk'";
    }
}

if (!empty($tanggal_mulai) && !empty($tanggal_selesai)) {
    $where .= " AND p.tgl_produksi BETWEEN '$tanggal_mulai' AND '$tanggal_selesai'";
}

// Query utama untuk ambil data cacat
$query = "
    SELECT 
        jk.id_jenis_kecacatan,
        jk.nama_kecacatan,
        SUM(k.jumlah) AS total_cacat
    FROM tb_kecacatan k
    JOIN tb_produksi p ON k.id_produksi = p.id_produksi
    JOIN tb_jenis_kecacatan jk ON k.id_jenis_kecacatan = jk.id_jenis_kecacatan
    $where
    GROUP BY jk.id_jenis_kecacatan
    ORDER BY total_cacat DESC
";

$result = mysqli_query($konek, $query);

// Hitung total produksi
$queryProduksi = "
    SELECT SUM(p.total_produksi) AS total_produksi
    FROM tb_produksi p
    $where
";
$resultProduksi = mysqli_query($konek, $queryProduksi);
$rowProduksi = mysqli_fetch_assoc($resultProduksi);
$total_semua_produksi = $rowProduksi['total_produksi'] ?? 0;


// Hitung total cacat dan simpan data
$data = [];
$total_semua_cacat = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
    $total_semua_cacat += $row['total_cacat'];
}

if ($id_produk > 0 && $total_semua_cacat > 0) {
    // Bersihkan data lama
    mysqli_query($konek, "DELETE FROM tb_persentase_pareto WHERE id_produk = '$id_produk'");

    // Insert data baru
    $kumulatif = 0;
    foreach ($data as $row) {
        $persen = ($row['total_cacat'] / $total_semua_cacat) * 100;
        $kumulatif += $persen;

        $queryInsert = "
            INSERT INTO tb_persentase_pareto (id_produk, id_jenis_kecacatan, nama_kecacatan, total_cacat, persentase, persentase_kumulatif)
            VALUES ('$id_produk', '{$row['id_jenis_kecacatan']}', '{$row['nama_kecacatan']}', '{$row['total_cacat']}', '$persen', '$kumulatif')
        ";
        mysqli_query($konek, $queryInsert);
    }
}

?>


<div class="panel">
    <div class="panel-middle" id="judul">
        <img src="asset/image/kriteria.svg">
        <div id="judul-text">
            <h2 class="text-green">Persentase Kecacatan</h2>
            Halaman Persentase Kecacatan
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
        <input type="hidden" name="page" value="persentase">
        <div class="filter-form">
            <div class="filter-group">
                <label>Nama Produk:</label>
                <select class="form-custom" name="produk" onchange="this.form.submit()">
                    <option value="">-- Pilih Produk --</option>

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
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                    <h4 class="card-title">Total Produksi</h4>
                    <p class="card-text fs-4"><?= $total_semua_produksi?> Pcs</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                    <h4 class="card-title">Jumlah Cacat Keseluruhan</h4>
                    <p class="card-text fs-4"><?= $total_semua_cacat?> Pcs</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
        <?php 

        
      
        
        ?>
        <table class="table table-bordered display" id="normalTable">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Jenis Kecacatan</th>
                <th>Jumlah Cacat</th>
                <th>Persentase (%)</th>
                <th>Persentase Kumulatif (%)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Perbaiki jika $filter_produk adalah nama produk, bukan ID
            $id_produk = 0;

            if (!empty($filter_produk)) {
                $filter_produk = mysqli_real_escape_string($konek, trim($filter_produk));

                $idProdukQuery = mysqli_query(
                    $konek,
                    "SELECT id_produk FROM tb_produk WHERE nama_produk = '$filter_produk' LIMIT 1"
                );

                if ($idProdukQuery && mysqli_num_rows($idProdukQuery) > 0) {
                    $resultProduk = mysqli_fetch_assoc($idProdukQuery);
                    $id_produk = $resultProduk['id_produk'];
                }
            }


            // Jalankan query persentase
            $persentaseQuery = "
                    SELECT 
                        pp.*,
                        p.id_produk,
                        p.nama_produk,
                        SUM(k.jumlah) AS total_semua_cacat
                    FROM tb_persentase_pareto pp
                    JOIN tb_produksi pr ON pp.id_produksi = pr.id_produksi
                    JOIN tb_produk p ON pr.id_produk = p.id_produk
                    JOIN tb_kecacatan k ON k.id_produksi = pr.id_produksi
                    WHERE pr.id_produk = '$id_produk'
                    GROUP BY pp.id_persentase
            ";


            $persentaseResult = mysqli_query($konek, $persentaseQuery);
            $no = 1;
            
            while ($row = mysqli_fetch_assoc($persentaseResult)) {
                echo "<tr>";
                echo "<td>{$no}</td>";
                echo "<td>{$row['nama_produk']}</td>";
                echo "<td>{$row['nama_kecacatan']}</td>";
                echo "<td>{$row['total_semua_cacat']}</td>";
                echo "<td>" . number_format($row['persentase'], 2) . "%</td>";
                echo "<td>" . number_format($row['persentase_kumulatif'], 2) . "%</td>";
                echo "</tr>";
                $no++;
            }            
            ?>
        </tbody>

    </table>

        </div>
    </div>

    <div class="panel-bottom">
        <canvas id="paretoChart" width="500" height="200"></canvas>
    </div>
</div>

<?php
// Siapkan data chart dari hasil query yang sama
$chartQuery = $query; // ini sudah difilter
$chartResult = $konek->query($chartQuery);

$labels = [];
$jumlah_kecacatan = [];
$kumulatif = [];
$totalCacat = 0;
$nilai_kumulatif = 0;

// Pertama, ambil semua jumlah kecacatan untuk menghitung total
while ($row = $chartResult->fetch_assoc()) {
    $labels[] = $row['nama_kecacatan'];  // Jenis kecacatan
    $jumlah_kecacatan[] = ($row['total_cacat'] / $total_semua_cacat) * 100;
    $persen = ($row['total_cacat'] / $total_semua_cacat) * 100;
    $kumulatif[] = $nilai_kumulatif += $persen;
}

?>