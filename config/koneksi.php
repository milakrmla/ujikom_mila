<?php
$hostname = 'localhost';
$userdb = 'root';
$passdb = '';
$namedb = 'ujikom';

$koneksi = mysqli_connect($hostname,$userdb,$passdb,$namedb);

if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    // Jika file ini diakses langsung melalui browser, alihkan ke halaman lain atau tampilkan pesan kesalahan
    header("Location: ../index.php");
    exit;
}
?>