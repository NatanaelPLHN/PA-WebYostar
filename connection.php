<?php

$serverName = "localhost";
$userName = "root";
$userPassword = "";
$dbname = "pa";

$conn = mysqli_connect($serverName,$userName,$userPassword,$dbname);
if(!$conn){
    die("Koneksi gagal".mysqli_connect_error());
}
?>