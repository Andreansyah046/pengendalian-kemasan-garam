<div class="panel">
    <div class="panel-middle" id="judul">
        <img src="asset/image/supplier.svg">
        <div id="judul-text">
            <h2 class="text-green">Produksi</h2>
            Halamanan  Data Produksi
        </div>
    </div>
</div>
<!-- judul -->
<div class="row">
    <?php if ($_SESSION['role'] != "kepala produksi"):?>
    <div class="col-3">
        <div class="panel">
            <?php
                if (@htmlspecialchars($_GET['aksi'])=='ubah' && $_SESSION['role'] != "kepala produksi"){
                    include 'ubahproduksi.php';
                }else{
                    include 'tambahproduksi.php';
                }
            ?>
        </div>
    </div>
    <?php endif;?>
    <div class="<?= $_SESSION['role'] != 'kepala produksi' ? 'col-9': 'col-12' ?>">
        <div class="panel">
            <div class="panel-top">
                <b class="text-green">Daftar Produksi</b>
            </div>
            <div class="panel-middle">
                    <table id="normalTable" class="table table-bordered display">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Jenis Kemasan</th>
                                <th>Tanggal Produk</th>
                                <th>Total Produksi</th>
                                <?php  if ($_SESSION['role'] != "kepala produksi") : ?>
                                    <th>Aksi</th>
                                <?php endif; ?>
                        </tr></thead>
                        
                       <tbody>
                        <?php
                        $query="SELECT * FROM view_produksi_produk";
                        $execute=$konek->query($query);
                        if ($execute->num_rows > 0){
                            $no=1;
                            while($data=$execute->fetch_array(MYSQLI_ASSOC)){   
                                ?>
                                <tr id='data'>
                                    <td><?=$no?></td>
                                    <td><?=$data['nama_produk']?></td>
                                    <td><?=$data['jenis_kemasan']?></td>
                                    <td><?=$data['tgl_produksi']?></td>
                                    <td><?=$data['total_produksi']?></td>
                                    
                                    <?php  if ($_SESSION['role'] != "kepala produksi") 
                                    echo "<td>
                                    <div class='norebuttom'>
                                        <a class='btn btn-light-green' href='./?page=produksi&aksi=ubah&id=".$data['id_produksi']."'><i class='fa fa-pencil-alt'></i></a>
                                        <a href='#' class='btn btn-yellow btn-hapus' data-id='".$data['id_produksi']."' data-op='produksi' data-nama='".$data['nama_produk']."'><i class='fa fa-trash-alt'></i></a>
                                    </div>
                                  </td>";
                                     ?>
                                </tr>
                                <?php                                
                                $no++;
                            }
                        }else{
                            echo "<tr><td  class='text-center text-green' colspan='3'>Kosong</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
            </div>
            <div class="panel-bottom"></div>
        </div>
    </div>
</div>