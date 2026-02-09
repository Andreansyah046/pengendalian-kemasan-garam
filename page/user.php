<!-- judul -->
<div class="panel">
    <div class="panel-middle" id="judul">
        <img src="asset/image/barang.svg">
        <div id="judul-text">
            <h2 class="text-green">DATA AKUN</h2>
            Halamanan Administrator Akun
        </div>
    </div>
</div>
<!-- judul -->
<div class="row">
    <div class="col-3">
        <div class="panel">
            <?php
            if (@htmlspecialchars($_GET['aksi'])=='ubah'){
                include 'ubahuser.php';
            }else{
                include 'tambahuser.php';
            }
            ?>
        </div>
    </div>
    <div class="col-9">
        <div class="panel">
            <div class="panel-top">
                <b class="text-green">Daftar User</b>
            </div>
            <div class="panel-middle">
                <table id="normalTable" class="table table-bordered display">
                    <thead><tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr></thead>
                    <tbody>
                    <?php
                    $query = "SELECT * FROM tb_user WHERE role!='admin'";
                    $execute = $konek->query($query);
                    
                    if ($execute->num_rows > 0) {
                        $no = 1;
                        while ($data = $execute->fetch_array(MYSQLI_ASSOC)) {
                            echo "
                            <tr id='data'>
                                <td>$no</td>
                                <td>$data[nama_lengkap]</td>
                                <td>$data[username]</td>
                                <td>$data[role]</td>
                                <td>
                                    <div class='norebuttom'>
                                        <a class=\"btn btn-light-green\" href='./?page=user&aksi=ubah&id=".$data['id_user']."'><i class='fa fa-pencil-alt'></i></a>
                                         <a href='#' class='btn btn-yellow btn-hapus' data-id='" . $data['id_user'] . "' data-op='user' data-nama='" . $data['username'] . "'><i class='fa fa-trash-alt'></i></a>
                                    </div>
                                </td>
                            </tr>";
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