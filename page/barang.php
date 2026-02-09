
<!-- judul -->
<div class="panel">
    <div class="panel-middle" id="judul">
        <img src="asset/image/barang.svg">
        <div id="judul-text">
            <h2 class="text-green">DATA PRODUK</h2>
            Halamanan Data Produk
        </div>
    </div>
</div>
<!-- judul -->
<div class="row">
    <?php if ($_SESSION['role'] != "kepala produksi"):?>
    <div class="col-3">
        <div class="panel">
            <?php
            if (@htmlspecialchars($_GET['aksi'])=='ubah'){
                include 'ubahbarang.php';
            }else{
                include 'tambahbarang.php';
            }
            ?>
        </div>
    </div>
    <?php endif;?>
    <div class="<?= $_SESSION['role'] != 'kepala produksi' ? 'col-9': 'col-12' ?>">
        <div class="panel">
            <div class="panel-top">
                <b class="text-green">Daftar Produk</b>
            </div>
            <div class="panel-middle">
                <table id="normalTable" class="table table-bordered display">
                    <thead><tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Jenis Kemasan</th>
                        <?php  if ($_SESSION['role'] != "kepala produksi"):?>
                        <th>Aksi</th>
                        <?php endif ?>
                    </tr></thead>
                    <tbody>
                    <?php
                    $query = "SELECT * FROM tb_produk";
                    $execute = $konek->query($query);
                    
                    if ($execute->num_rows > 0) {
                        $no = 1;
                        while ($data = $execute->fetch_array(MYSQLI_ASSOC)) {
                            ?>
                            <tr id='data'>
                                <td><?= $no ?></td>
                                <td><?= $data['nama_produk'] ?></td>
                                <td><?= $data['jenis_kemasan'] ?></td>
                                <?php if ($_SESSION['role'] != "kepala produksi") 
                                echo "<td>
                                <div class='norebuttom'>
                                    <a class='btn btn-light-green' href='./?page=barang&aksi=ubah&id=" . $data['id_produk'] . "'><i class='fa fa-pencil-alt'></i></a>
                                    <a href='#' class='btn btn-yellow btn-hapus' data-id='" . $data['id_produk'] . "' data-op='barang' data-nama='" . $data['nama_produk'] . "'><i class='fa fa-trash-alt'></i></a>
                                </div>
                              </td>";?>
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