<?php cek_auth('kepala produksi', '?page=beranda'); ?>
<?php cek_auth('bagian produksi', '?page=beranda'); ?>

<div class="panel">
    <div class="panel-middle" id="judul">
        <img src="asset/image/kriteria.svg">
        <div id="judul-text">
            <h2 class="text-green">Kecacatan Produk</h2>
            Halaman Data Kecacatan Berdasarkan Produksi
        </div>
    </div>
</div>
<!-- judul -->
<div class="row">
    <div class="col-3">
        <div class="panel">
            <?php
            if (@htmlspecialchars($_GET['aksi'])=='ubah'){
                include 'ubahkecacatan.php';
            }else{
                include 'tambahkecacatan.php';
            }
            ?>
        </div>
    </div>
    <div class="col-9">
        <div class="panel">
            <div class="panel-top">
                <b class="text-green">Daftar Kecacatan Produk per Produksi</b>
            </div>
            <div class="panel-middle">
                    <?php
                    // Ambil semua jenis kecacatan
                    $jenisQuery = mysqli_query($konek, "SELECT * FROM tb_jenis_kecacatan");
                    $jenisKecacatan = [];
                    while ($row = mysqli_fetch_assoc($jenisQuery)) {
                        $jenisKecacatan[$row['id_jenis_kecacatan']] = $row['nama_kecacatan'];
                    }

                    // Ambil data produksi + join ke produk
                    $produksiQuery = mysqli_query($konek, "
                        SELECT p.id_produksi, p.tgl_produksi, pr.nama_produk, pr.jenis_kemasan
                        FROM tb_produksi p
                        JOIN tb_produk pr ON p.id_produk = pr.id_produk
                        ORDER BY p.tgl_produksi ASC
                    ");
                    ?>

                    <table id="normalTable" class="table table-bordered display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Produksi</th>
                                <th>Nama Produk</th>
                                <th>Jenis Kemasan</th>
                                <?php foreach ($jenisKecacatan as $nama): ?>
                                    <th><?= htmlspecialchars(ucfirst($nama)) ?></th>
                                <?php endforeach; ?>
                                <th>Total Cacat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 1;
                        while ($produksi = mysqli_fetch_assoc($produksiQuery)) {
                            $idProduksi = $produksi['id_produksi'];

                            $jumlahPerJenis = array_fill_keys(array_keys($jenisKecacatan), 0);

                            $cacatQuery = mysqli_query($konek, "
                                SELECT id_jenis_kecacatan, jumlah 
                                FROM tb_kecacatan 
                                WHERE id_produksi = $idProduksi
                            ");

                            $totalCacat = 0;
                            while ($cacat = mysqli_fetch_assoc($cacatQuery)) {
                                $idJenis = $cacat['id_jenis_kecacatan'];
                                $jumlah = $cacat['jumlah'];
                                $jumlahPerJenis[$idJenis] = $jumlah;
                                $totalCacat += $jumlah;
                            }

                            // Filter hanya jika total kecacatan lebih dari 0
                            if ($totalCacat > 0) {
                                echo "<tr>
                                        <td>$no</td>
                                        <td>{$produksi['tgl_produksi']}</td>
                                        <td>{$produksi['nama_produk']}</td>
                                        <td>{$produksi['jenis_kemasan']}</td>";

                                foreach ($jumlahPerJenis as $jumlah) {
                                    echo "<td>$jumlah</td>";
                                }

                                echo "<td><strong>$totalCacat</strong></td>
                                        <td>
                                            <div class='norebuttom'>
                                                <a class='btn btn-light-green' href='?page=kecacatan&aksi=ubah&id_produksi=$idProduksi'><i class='fa fa-pencil-alt'></i></a>
                                                <a href='#' class='btn btn-yellow btn-hapus' data-id='" . $produksi['id_produksi'] . "' data-op='kecacatan' data-nama='" . $produksi['nama_produk'] . "'><i class='fa fa-trash-alt'></i></a>
                                            </div>
                                        </td>
                                    </tr>";
                                $no++;
                            }
                        }
                        ?>
                        </tbody>

                    </table>
            </div>
            <div class="panel-bottom"></div>
        </div>
    </div>
</div>
