<?php cek_auth('kepala produksi', '?page=beranda'); ?>
<?php cek_auth('bagian produksi', '?page=beranda'); ?>

<div class="panel">
    <div class="panel-middle" id="judul">
        <img src="asset/image/kriteria.svg">
        <div id="judul-text">
            <h2 class="text-green">Jenis Kecacatan</h2>
            Halaman Jenis Kecacatan Berdasarkan Produksi
        </div>
    </div>
</div>
<!-- judul -->
<div class="row">
    <div class="col-3">
        <div class="panel">
            <?php
            if (@htmlspecialchars($_GET['aksi'])=='ubah'){
                include 'ubahjeniskecacatan.php';
            }else{
                include 'tambahjeniskecacatan.php';
            }
            ?>
        </div>
    </div>
    <div class="col-9">
        <div class="panel">
            <div class="panel-top">
                <b class="text-green">Daftar Jenis Kecacatan</b>
            </div>
            <div class="panel-middle">
                    <table id="normalTable" class="table table-bordered display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis Kecacatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $query = "SELECT * FROM tb_jenis_kecacatan";
                        $execute = $konek->query($query);
                        
                        if ($execute->num_rows > 0) {
                            $no = 1;
                            while ($data = $execute->fetch_array(MYSQLI_ASSOC)) {
                                ?>
                                <tr id="data">
                                <td><?= htmlspecialchars($no) ?></td>
                                <td><?= !empty($data['nama_kecacatan']) ? htmlspecialchars($data['nama_kecacatan']) : '-' ?></td>
                                <td>
                                <?php if ($_SESSION['role'] != "kepala produksi") : ?>
                                    <div class="norebuttom">
                                        <a class="btn btn-light-green" href="./?page=jeniskecacatan&aksi=ubah&id=<?= urlencode($data['id_jenis_kecacatan']) ?>">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                        <a href='#' class='btn btn-yellow btn-hapus' data-id="<?= $data['id_jenis_kecacatan']?>" data-op="jeniskecacatan" data-nama="<?= $data['nama_kecacatan']?>"><i class='fa fa-trash-alt'></i></a>
                                    </div>
                                        <?php else : ?>
                                            <!-- Untuk kepala produksi, tetap buat kolom kosong -->
                                            <div style="text-align:center;">-</div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php
                                $no++;
                            }
                        } else {
                            echo "<tr><td class='text-center text-green' colspan='6'>Kosong</td></tr>";
                        }
                        ?>
                        </tbody>

                    </table>
            </div>
            <div class="panel-bottom"></div>
        </div>
    </div>
</div>
