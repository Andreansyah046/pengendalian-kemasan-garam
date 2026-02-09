<?php
$page = htmlspecialchars(@$_GET['page']);
switch ($page) {
    case null:
    case 'beranda':
        include 'page/beranda.php';
        break;
    case 'barang':
        include 'page/barang.php';
        break;
    case 'produksi':
        include 'page/produksi.php';
        break;
    case 'kecacatan':
        include 'page/kecacatan.php';
        break;
    case 'jeniskecacatan':
        include 'page/jeniskecacatan.php';
        break;
    case 'persentase':
        include 'page/persentase.php';
        break;
    case 'user':
        include 'page/user.php';
        break;
    case 'hasilkendali':
        include 'page/hasilkendali.php';
        break;
    case 'hasil':
        include 'page/hasilpareto.php';
        break;
    case 'profil':
        include 'page/profil.php';
        break;
    case 'tambahpersentase': // tanpakan .php agar konsisten
        include 'page/tambahpersentase.php';
        break;
    default:
        if (file_exists('page/404.php')) {
            include 'page/404.php';
        } else {
            echo "<h2>404 - Halaman tidak ditemukan</h2>";
        }
        break;
}
?>
