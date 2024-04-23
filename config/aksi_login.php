<?php
session_start();
include 'koneksi.php';

// Pastikan permintaan berasal dari metode POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    // Redirect jika permintaan bukan dari metode POST
    header("Location: ../registrasi.php");
    exit;
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");

$cek = mysqli_num_rows($sql);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($sql);
    if (password_verify($password, $data['password'])) {
        $_SESSION['username'] = $data['username'];
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['status'] = 'login';
        echo "<script>
            alert('Login berhasil');
            location.href='../admin/index.php';
            </script>";
    } else {
        // echo "<script>
        //     alert('Username atau Password salah!');
        //     location.href='../login.php';
        //     </script>";
        $_SESSION['alertsalah'] = 'Username atau Password salah!';
        header("Location: ../login.php");
        return false;
    }
} else {
    // echo "<script>
    //     alert('Username atau Password salah!');
    //     location.href='../login.php';
    //     </script>";
    $_SESSION['alertsalah'] = 'Username atau Password salah!';
    header("Location: ../login.php");
    return false;
}
?>