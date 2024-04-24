<?php
session_start();
include 'koneksi.php';

if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    // Jika file ini diakses langsung melalui browser, alihkan ke halaman lain atau tampilkan pesan kesalahan
    header("Location: ../index.php");
    exit;
}

// Handle delete comment action
if (isset($_POST['hapuskomentar'])) {
    $komentar_id = $_POST['komentar_id'];

    $sql = mysqli_query($koneksi, "DELETE FROM komentar_foto WHERE komentar_id='$komentar_id'");
    // Redirect back to the previous page after deleting the comment
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
?>
