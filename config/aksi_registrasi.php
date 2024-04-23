<?php
include 'koneksi.php';

// Pastikan permintaan berasal dari metode POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    // Redirect jika permintaan bukan dari metode POST
    header("Location: ../registrasi.php");
    exit;
}

$username = strtolower(stripslashes($_POST['username']));
$password = $_POST['password'];
$email = $_POST['email'];
$nama_lengkap = $_POST['nama_lengkap'];
$alamat = $_POST['alamat'];
$password2 = $_POST['password2'];

// cek username sudah ada atau belum
$result = mysqli_query($koneksi, "SELECT username FROM user WHERE username = '$username'");

if( mysqli_fetch_assoc($result) ) {
    echo "<script>
            alert('Username yang dipilih sudah terdaftar!');
            location.href='../registrasi.php';
        </script>";
    return false;
}

// cek konfirmasi password
if( $password !== $password2 ) {
    echo "<script>
            alert('Konfirmasi password tidak sesuai!');
            location.href='../registrasi.php';
        </script>";
    return false;
}

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan userbaru ke database
    $sql = mysqli_query($koneksi, "INSERT INTO user VALUES ('','$username','$password','$email','$nama_lengkap','$alamat')");

if ($sql) {
    echo "<script>
    alert('Pendaftaran akun berhasil');
    location.href='../login.php';
    </script>";
}

?>