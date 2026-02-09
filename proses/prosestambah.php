<?php
require '../connect.php';
require '../class/crud.php';
$crud = new crud($konek);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = @$_GET['id'];
    $op = @$_GET['op'];
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = @$_POST['id'];
    $op = @$_POST['op'];
}

$barang = @$_POST['barang'];
$tgl_produksi = @$_POST['tgl_produksi'];
$jenis_kemasan = @$_POST['jenis_kemasan'];

$id_produk = @$_POST['id_produk'];
$jumlah_produksi = @$_POST['jumlah_produksi'];
$kecacatan = @$_POST['kecacatan'];

$kriteria = @$_POST['kriteria'];
$id_kecacatan = @$_POST['id_kecacatan'];
$nama_kecacatan = @$_POST['nama_kecacatan'];
$jumlah = @$_POST['jumlah'];

$sifat = @$_POST['sifat'];
$nilai = @$_POST['nilai'];
$keterangan = @$_POST['keterangan'];
$bobot = @$_POST['bobot'];

switch ($op) {
    case 'barang':
        $query = "INSERT INTO tb_produk VALUES ('','$barang', '$jenis_kemasan')";
        $crud->addData($query, $konek, 'Produk');
        header("Location: ../?page=barang");
        break;

    case 'produksi':
        $cek = mysqli_query($konek, "SELECT * FROM tb_produksi WHERE id_produk = '$id_produk' AND tgl_produksi = '$tgl_produksi'");
        if (mysqli_num_rows($cek) == 0) {
            $query = "INSERT INTO tb_produksi VALUES ('', '$id_produk', '$tgl_produksi', '$jumlah_produksi')";
            $crud->addData($query, $konek, 'Produksi');
        } else {
            $crud->setFlashMessage('error', 'Data produksi sudah ada!');
        }
        header("Location: ../?page=produksi");
        break;

    case 'kecacatan':
        // Ambil data produksi
        $query_produksi = mysqli_query($konek, "SELECT id_produksi, total_produksi FROM tb_produksi WHERE id_produk = '$id_produk' AND tgl_produksi = '$tgl_produksi'");
        
        if (mysqli_num_rows($query_produksi) == 0) {
            // Produksi belum ada, maka insert terlebih dahulu
            $query_insert_produksi = mysqli_query($konek, "INSERT INTO tb_produksi (id_produk, tgl_produksi) VALUES ('$id_produk', '$tgl_produksi')");
            if (!$query_insert_produksi) {
                $crud->setFlashMessage('error', 'Gagal menambahkan data produksi!');
                exit();
            }
            $id_produksi = mysqli_insert_id($konek);
            $jumlah_produksi = 0; // Jika baru, anggap jumlah produksi masih 0 (atau Anda bisa isi sesuai kebutuhan)
        } else {
            // Produksi sudah ada
            $data_produksi = mysqli_fetch_assoc($query_produksi);
            $id_produksi = $data_produksi['id_produksi'];
            $jumlah_produksi = $data_produksi['total_produksi'];
        }
    
        // Hitung total kecacatan
        $total_kecacatan = 0;
        foreach ($kecacatan as $jumlah) {
            $total_kecacatan += (int)$jumlah;
        }
    
        // Validasi jika jumlah kecacatan melebihi jumlah produksi
        if ($jumlah_produksi > 0 && $total_kecacatan > $jumlah_produksi) {
            $crud->setFlashMessage('error', 'Jumlah kecacatan melebihi jumlah produksi!');
            header("Location: ../?page=kecacatan");
            exit();
        }
    
        // Simpan data kecacatan
        foreach ($kecacatan as $id_jenis => $jumlah_kecacatan) {
            if ($jumlah_kecacatan > 0) {
                $query = "INSERT INTO tb_kecacatan (id_produksi, id_jenis_kecacatan, jumlah) 
                            VALUES ('$id_produksi', '$id_jenis', '$jumlah_kecacatan')";
                if (!mysqli_query($konek, $query)) {
                    $crud->setFlashMessage('error', 'Gagal menyimpan data kecacatan!');
                }
            }
        }
    
        $crud->setFlashMessage('success', 'Data kecacatan berhasil ditambahkan!');
        header("Location: ../?page=kecacatan");
        exit();
        break;
    

    case 'user':
        $username = $_POST['username'];
        $nama_lengkap = $_POST['nama_lengkap'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = $_POST['role'];

        $cekusername = mysqli_query($konek, "SELECT username FROM tb_user WHERE username = '$username'");
        if (mysqli_num_rows($cekusername) == 0) {
            $query = "INSERT INTO tb_user (username, password, nama_lengkap, role) 
                      VALUES ('$username', '$password', '$nama_lengkap', '$role')";
            $crud->addData($query, $konek, 'User');
        } else {
            $crud->setFlashMessage('error', 'Username sudah terdaftar!');
        }
        header("Location: ../?page=user");
        break;

    case 'jeniskecacatan':
        $jenis_kecacatan = $_POST['jenis_kecacatan'];
        $query = "INSERT INTO tb_jenis_kecacatan VALUES ('','$jenis_kecacatan')";
        $crud->addData($query, $konek, 'Jenis Kecacatan');
        header("Location: ../?page=jeniskecacatan");
        break;
}
?>
