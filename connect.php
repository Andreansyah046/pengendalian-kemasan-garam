<?php
$konek=new mysqli('localhost','root','','db_garam');
if ($konek->connect_errno){
    "Database Error".$konek->connect_error;
}
?>