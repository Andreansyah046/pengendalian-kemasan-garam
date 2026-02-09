<?php

function cek_auth($role, $url) {
    if (($_SESSION['role'])== $role) {
        header("Location: $url");
        exit();
    }
}