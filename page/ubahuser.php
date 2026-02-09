<?php
$id = htmlspecialchars(@$_GET['id']);
$query = "SELECT * FROM tb_user WHERE id_user='$id'";
$execute = $konek->query($query);
if ($execute->num_rows > 0){
    $data = $execute->fetch_array(MYSQLI_ASSOC);
}else{
    header('location:./?page=user');
    exit;
}
?>
<div class="panel-top panel-top-edit">
    <b><i class="fa fa-pencil-alt"></i> Ubah Data Pengguna</b>
</div>
<form id="form" method="POST" action="./proses/prosesubah.php">
    <input type="hidden" name="op" value="user">
    <input type="hidden" name="id" value="<?php echo $data['id_user']; ?>">
    <div class="panel-middle">

        <div class="group-input">
            <label for="username">Username :</label>
            <input type="text" value="<?php echo $data['username']; ?>" class="form-custom" required id="username" name="username">
        </div>
        <div class="group-input">
            <label for="nama_lengkap">Nama Lengkap :</label>
            <input type="text" value="<?php echo $data['nama_lengkap']; ?>" class="form-custom" required id="nama_lengkap" name="nama_lengkap">
        </div>
        <div class="group-input">
            <label for="role">Role :</label>
            <select class="form-custom" id="role" name="role" required>
                <?php
                $roles = mysqli_query($konek, "SELECT DISTINCT role FROM tb_user");
                while ($p = mysqli_fetch_assoc($roles)) {
                    $selected = ($p['role'] == $data['role']) ? 'selected' : '';
                    echo '<option value="'.$p['role'].'" '.$selected.'>'.$p['role'].'</option>';
                }
                ?>
            </select>

        </div>
        <label for="password">Password :</label>
        <div class="input-group my-1">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" >
            <button class="btn btn-outline-secondary" type="button" id="toggle-password">👁️</button>
        </div>
        <p class="text-danger">! Masukan password apabila ingin mengubahnya</p>
    </div>
    <div class="panel-bottom">
        <button type="submit" id="buttonsimpan" class="btn btn-green"><i class="fa fa-save"></i> Simpan</button>
        <button type="reset" class="btn btn-second">Reset</button>
    </div>
</form>
