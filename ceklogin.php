<?php
require 'connect.php';

session_start(); // Selalu mulai session di awal

$user = @$_POST['username'];
$pass = @$_POST['password'];

if (empty($user) && empty($pass)) {
    $result = "Username dan password tidak boleh kosong";
} elseif (empty($user)) {
    $result = "Username tidak boleh kosong";
} elseif (empty($pass)) {
    $result = "Password tidak boleh kosong";
} else {
    // Gunakan prepared statement untuk menghindari SQL injection
    $stmt = $konek->prepare("SELECT * FROM tb_user WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $execute = $stmt->get_result();

    if ($execute->num_rows > 0) {
        $data = $execute->fetch_array(MYSQLI_ASSOC);
        if (password_verify($pass, $data['password'])) {
            $_SESSION['user'] = $data['username'];
            $_SESSION['role'] = $data['role'];
            $_SESSION['nama'] = $data['nama_lengkap'];
            $_SESSION['alert'] = ['type' => 'success', 'message' => 'Berhasil Login'];
            header("Location: " . $_SERVER['HTTP_REFERER']);
        } else {
            $_SESSION['alert'] = ['type' => 'error', 'message' => 'Username & password salah!!'];
            header("Location: " . $_SERVER['HTTP_REFERER']);
        }
    } else {
        $_SESSION['alert'] = ['type' => 'error', 'message' => 'Username salah!!'];
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}
