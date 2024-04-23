<?php 
session_start();
include 'koneksi.php';

// Pastikan permintaan berasal dari metode POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    // Redirect jika permintaan bukan dari metode POST
    header("Location: ../index.php");
    exit;
}

// Tangani perubahan data pengguna
if(isset($_POST['ubah_data'])){
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $alamat = $_POST['alamat'];

    $query = "UPDATE user SET username = '$username', email = '$email', nama_lengkap = '$nama_lengkap', alamat = '$alamat' WHERE user_id = '$user_id'";
    
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $_SESSION['alertbenar'] = 'Data berhasil diperbarui!';
        header("Location: ../admin/akun.php");
        exit;
    } else {
        $_SESSION['alertsalah'] = 'Terjadi kesalahan. Data tidak berhasil diperbarui.';
        header("Location: ../admin/akun.php");
        exit;
    }
}

// ganti password
if(isset($_POST['ubah_password'])){
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if($password !== $password2){
        $_SESSION['alertsalah2'] = 'Konfirmasi password tidak sesuai!';
        header("Location: ../admin/akun.php");
        exit;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    
    $query = "UPDATE user SET password = '$password' WHERE user_id = '$user_id'";
    
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $_SESSION['alertbenar2'] = 'Password berhasil diubah!';
        header("Location: ../admin/akun.php");
        exit;
    } else {
        $_SESSION['alertsalah2'] = 'Terjadi kesalahan. Password tidak berhasil diubah.';
        header("Location: ../admin/akun.php");
        exit;
    }
}
?>