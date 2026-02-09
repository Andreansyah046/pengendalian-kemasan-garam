<?php
require '../connect.php';
require '../class/crud.php';
if ($_SERVER['REQUEST_METHOD']=='GET') {
    $id=@$_GET['id'];
    $op=@$_GET['op'];
}else if ($_SERVER['REQUEST_METHOD']=='POST'){
    $id=@$_POST['id'];
    $op=@$_POST['op'];
}
$crud=new crud();
switch ($op){
    case 'barang':
        $query="DELETE FROM tb_produk WHERE id_produk ='$id'";
        $crud->delete($query, $konek, 'Produk');
        break;
    case 'produksi':
        $query="DELETE FROM tb_produksi WHERE id_produksi='$id'";
        $crud->delete($query, $konek, 'Produksi');
        break;
    case 'kecacatan':
        $query = "DELETE FROM tb_kecacatan WHERE id_produksi = '$id'";
        $crud->delete($query, $konek, 'Kecacatan');
        break;
    case 'user':
        $query="DELETE FROM tb_user WHERE id_user='$id'";
        $crud->delete($query, $konek, 'User');
        break;
    case 'jeniskecacatan':
        $query="DELETE FROM tb_jenis_kecacatan WHERE id_jenis_kecacatan='$id'";
        $crud->delete($query, $konek, 'Jenis Kecacatan');
        break;
}
header("Location: " . $_SERVER['HTTP_REFERER']);
