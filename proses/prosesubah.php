<?php
require '../connect.php';
require '../class/crud.php';

$crud = new crud();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = @$_GET['id'];
    $op = @$_GET['op'];
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = @$_POST['id'];
    $op = @$_POST['op'];
}

// Data umum
$barang = @$_POST['barang'];
$jenis_kemasan = @$_POST['jenis_kemasan'];
$id_produksi = @$_POST['id_produksi'];
$id_produk = @$_POST['id_produk'];
$tgl_produksi = @$_POST['tgl_produksi'];
$jumlah_produksi = @$_POST['jumlah_produksi'];
$jumlah = @$_POST['jumlah'];
$persentase = @$_POST['persentase'];
$username = @$_POST['username'];
$nama_lengkap = @$_POST['nama_lengkap'];
$role = @$_POST['role'];
$password_lama = @$_POST['password_lama'];
$password_baru = @$_POST['password_baru'];
$jenis_kecacatan = @$_POST['jenis_kecacatan'];

switch ($op) {
    case 'barang':
        $query = "UPDATE tb_produk 
                  SET nama_produk='$barang', jenis_kemasan='$jenis_kemasan'
                  WHERE id_produk='$id'";
        $crud->update($query, $konek, 'Barang', './?page=barang');
        break;

    case 'produksi':
        $cek = mysqli_query($konek, "SELECT * FROM tb_produksi 
                WHERE id_produk = '$id_produk' 
                AND tgl_produksi = '$tgl_produksi' 
                AND id_produksi != '$id_produksi'");
        
        if (mysqli_num_rows($cek) == 0) {
            $query = "UPDATE tb_produksi 
                      SET id_produk = '$id_produk', 
                          tgl_produksi = '$tgl_produksi', 
                          total_produksi = '$jumlah_produksi' 
                      WHERE id_produksi = '$id_produksi'";
            $crud->update($query, $konek, 'Produksi', './?page=produksi');
        } else {
            echo json_encode("failed");
        }
        break;

    case 'kecacatan':
        foreach ($jumlah as $id_jenis => $jml) {
            $cek = mysqli_query($konek, "SELECT * FROM tb_kecacatan 
                    WHERE id_produksi='$id_produksi' 
                    AND id_jenis_kecacatan='$id_jenis'");
            
            if (mysqli_num_rows($cek) > 0) {
                $query = "UPDATE tb_kecacatan 
                          SET jumlah='$jml' 
                          WHERE id_produksi='$id_produksi' 
                          AND id_jenis_kecacatan='$id_jenis'";
                $crud->update($query, $konek, 'Kecacatan', './?page=kecacatan');
            } else {
                $query = "INSERT INTO tb_kecacatan (id_produksi, id_jenis_kecacatan, jumlah) 
                          VALUES ('$id_produksi', '$id_jenis', '$jml')";
                $crud->addData($query, $konek, 'Kecacatan');
            }
        }
        header("location:../?page=kecacatan");
        break;

    case 'persentase':
        $query = '';
        for ($i = 0; $i < count($id); $i++) {
            $query .= "UPDATE persentase_kriteria 
                       SET persentase='{$persentase[$i]}' 
                       WHERE id_persentase_kriteria='{$id[$i]}';";
        }
        $crud->update($query, $konek, 'Persentase', './?page=persentase');
        break;

    case 'user':
        $cekusername = mysqli_query($konek, "SELECT username FROM tb_user 
                        WHERE username = '$username' 
                        AND id_user != '$id'");
        if (mysqli_num_rows($cekusername) == 0) {
            if (!empty($_POST['password'])) {
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $query = "UPDATE tb_user 
                          SET username='$username', 
                              password='$password', 
                              nama_lengkap='$nama_lengkap', 
                              role='$role' 
                          WHERE id_user='$id'";
            } else {
                $query = "UPDATE tb_user 
                          SET username='$username', 
                              nama_lengkap='$nama_lengkap', 
                              role='$role' 
                          WHERE id_user='$id'";
            }
            $crud->update($query, $konek, 'User', './?page=user');
        } else {
            $_SESSION['alert'] = ['type' => 'error', 'message' => 'Username sudah digunakan!'];
        }
        break;

    case 'jeniskecacatan':
        $query = "UPDATE tb_jenis_kecacatan 
                  SET nama_kecacatan='$jenis_kecacatan' 
                  WHERE id_jenis_kecacatan='$id'";
        $crud->update($query, $konek, 'Jenis Kecacatan', './?page=jeniskecacatan');
        break;

    case 'profil':
        $getUser = mysqli_query($konek, "SELECT * FROM tb_user WHERE id_user='$id'");
        $dataUser = mysqli_fetch_assoc($getUser);

        if (!empty($password_baru)) {
            if (password_verify($password_lama, $dataUser['password'])) {
                $passwordHash = password_hash($password_baru, PASSWORD_DEFAULT);
                $query = "UPDATE tb_user 
                          SET password='$passwordHash' 
                          WHERE id_user='$id'";
                $crud->update($query, $konek, 'Profil', './?page=profil');
            } else {
                $_SESSION['alert'] = ['type' => 'error', 'message' => 'Password lama salah!'];
            }
        }
        header("location:../?page=profil");
        break;
}
?>
