<button class="btn btn-second" id="hidden"><i class="fa text-white fa-list text-black"></i></button>
<ul class="nav">
    <li><a href="./?page=beranda"><i class="fa text-white fa-home"></i> Beranda</a></li>
    
    <?php
        if ($_SESSION['role'] == "admin") {
            ?>
            <li><a href="./?page=barang"><i class="fa text-white fa-cube"></i> Produk</a></li>
            <li><a href="./?page=produksi"><i class="fa text-white fa-industry"></i> Produksi</a></li>
            <li><a href="./?page=kecacatan"><i class="fa text-white fa-times-circle"></i> Kecacatan</a></li>
            <li><a href="./?page=hasilkendali"><i class="fa text-white fa-chart-line"></i> Hasil Perhitungan</a></li>
            <li><a href="./?page=persentase"><i class="fa text-white fa-percentage"></i> Persentase</a></li>
            <li><a href="./?page=user"><i class="fa text-white fa-users-cog"></i> Data User</a></li>
            <?php
        }
        elseif ($_SESSION['role'] == "kepala produksi") {
            ?>
            <li><a href="./?page=barang"><i class="fa text-white fa-cube"></i> Produk</a></li>
            <li><a href="./?page=produksi"><i class="fa text-white fa-industry"></i> Produksi</a></li>
            <li><a href="./?page=hasilkendali"><i class="fa text-white fa-chart-line"></i> Hasil Perhitungan</a></li>
            <li><a href="./?page=persentase"><i class="fa text-white fa-percentage"></i> Persentase</a></li>
            <?php
        }
        elseif ($_SESSION['role'] == "bagian produksi") {
            ?>
            <li><a href="./?page=barang"><i class="fa text-white fa-cube"></i> Produk</a></li>
            <li><a href="./?page=produksi"><i class="fa text-white fa-industry"></i> Produksi</a></li>
            <?php
        }
    ?>

    <!-- Dropdown User -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa text-white fa-user-circle"></i> Akun
        </a>
        <ul class="dropdown-menu bg-success" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="./?page=profil"><i class="fa text-white fa-id-badge"></i> Profil</a></li>
            <li><a class="dropdown-item" href="./logout.php" id="out"><i class="fa text-white fa-sign-out-alt"></i> Keluar</a></li>
        </ul>
    </li>
</ul>
