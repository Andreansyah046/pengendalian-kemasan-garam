<div class="panel-top">
    <b class="text-green"><i class="fa fa-plus-circle text-green"></i> Tambah data</b>
</div>
<form id="form" method="POST" action="./proses/prosestambah.php">
    <input type="hidden" name="op" value="user">
    <div class="panel-middle">
        <div class="group-input">
            <label for="username">Username :</label>
            <input type="text" class="form-custom" required autocomplete="off" placeholder="Username" id="username" name="username">
        </div>
        <div class="group-input">
            <label for="nama_lengkap">Nama Lengkap :</label>
            <input type="text" class="form-custom" required autocomplete="off" placeholder="Nama Lengkap" id="nama_lengkap" name="nama_lengkap">
        </div>
        <div class="group-input">
            <label for="role">Role :</label>
            <select class="form-custom" required id="role" name="role">
                <option value="admin">Admin</option>
                <option value="kepala produksi">Kepala Produksi</option>
                <option value="bagian produksi">Bagian produksi</option>
                <option value="bagian produksi">supervisor</option>
            </select>
        </div>
        <label for="password">Password :</label>
        <div class="input-group my-1">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" >
            <button class="btn btn-outline-secondary" type="button" id="toggle-password">👁️</button>
         </div>
    </div>
    <div class="panel-bottom">
        <button type="submit" id="buttonsimpan" class="btn btn-green"><i class="fa fa-save"></i> Simpan</button>
        <button type="reset" id="buttonreset" class="btn btn-second">Reset</button>
    </div>
</form>
