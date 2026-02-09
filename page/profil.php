<?php
$id = $_SESSION['user']; // Ambil ID dari sesi login

$query = "SELECT * FROM tb_user WHERE username='$id'";
$execute = $konek->query($query);
if ($execute->num_rows > 0) {
    $data = $execute->fetch_array(MYSQLI_ASSOC);
} else {
    header('location:./logout.php');
    exit;
}
?>
<div class="panel">
    <div class="panel-middle" id="judul">
        <img src="asset/image/supplier.svg">
        <div id="judul-text">
            <h2 class="text-green">Profil</h2>
            Halamanan Profil pengguna
        </div>
    </div>
</div>
<div class="row mb-4">
    <!-- SECTION KIRI: Info Profil -->
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-top">
                <h5 class="mb-3"><i class="fa fa-id-card"></i> Informasi Pengguna</h5>
            </div>
            <div class="panel-middle">
                <div class="group-input">
                    <label>Username:</label>
                    <input type="text" class="form-custom" value="<?php echo $data['username']; ?>" readonly>
                </div>
                <div class="group-input">
                    <label>Nama Lengkap:</label>
                    <input type="text" class="form-custom" value="<?php echo $data['nama_lengkap']; ?>" readonly>
                </div>
                <div class="group-input">
                    <label>Role:</label>
                    <input type="text" class="form-custom" value="<?php echo $data['role']; ?>" readonly>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION KANAN: Form Ubah Password -->
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-top">
                <h5 class="mb-3"><i class="fa fa-key"></i> Ubah Password</h5>
            </div>
            <div class="panel-middle">
                <form method="POST" action="./proses/prosesubah.php">
                    <input type="hidden" name="op" value="profil">
                    <input type="hidden" name="id" value="<?php echo $data['id_user']; ?>">

                    <!-- Password Lama -->
                    <label for="password_lama">Password Lama:</label>
                    <div class="input-group mb-2">
                        <input type="password" class="form-control" name="password_lama" id="password_lama" required placeholder="Masukkan password lama">
                    </div>

                    <!-- Password Baru -->
                    <label for="password_baru">Password Baru:</label>
                    <div class="input-group mb-2">
                        <input type="password" class="form-control" name="password_baru" id="password" placeholder="Isi jika ingin mengubah password">
                        <button class="btn btn-outline-secondary" type="button" id="toggle-password">👁️</button>
                    </div>
                    <p class="text-danger mb-3">* Password lama harus sesuai !</p>

                    <div class="text-end">
                        <button type="submit" class="btn btn-green"><i class="fa fa-save"></i> Simpan</button>
                        <button type="reset" class="btn btn-second">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>