<?php
session_start();
if (empty($_SESSION['username']) AND empty($_SESSION['role'])){
    include 'login.php';
}else{
    include 'auth.php';
    include 'admin.php';
}