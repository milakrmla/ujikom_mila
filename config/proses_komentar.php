<?php
session_start();
include 'koneksi.php';

// Pastikan permintaan berasal dari metode POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    // Redirect jika permintaan bukan dari metode POST
    header("Location: ../index.php");
    exit;
}

$foto_id = $_POST['foto_id'];
$user_id = $_SESSION['user_id'];
$isi_komentar = $_POST['isi_komentar'];
$tanggal_komentar = date('Y-m-d');

$query = mysqli_query($koneksi, "INSERT INTO komentar_foto VALUES('','$foto_id','$user_id','$isi_komentar','$tanggal_komentar')");

echo "<script>
location.href='../admin/index.php';
</script>";

?>