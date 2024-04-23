<?php
session_start();
include 'koneksi.php';

// Handle delete comment action
if (isset($_POST['hapuskomentar'])) {
    $komentar_id = $_POST['komentar_id'];

    $sql = mysqli_query($koneksi, "DELETE FROM komentar_foto WHERE komentar_id='$komentar_id'");
    // Redirect back to the previous page after deleting the comment
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
?>
