<?php
session_start();
$user_id = $_SESSION['user_id'];
include '../config/koneksi.php';

if ($_SESSION['status'] != 'login') {
    echo "<script>
    alert('Anda belum Login!');
    location.href='../index.php';
    </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Foto</title>
    <!-- favicon -->
    <link rel="shortcut icon" href="../favicon.ico">
    <!-- css -->
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/font-awesome/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <style>
        /* font */
        @import url('https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap');
        
        body {
            font-family: "Lato", sans-serif;
            font-weight: 400;
        }

        .custom-btn1 {
            color: #FFFFFF;
            background-color: #7077A1;
            border-color: #595F80;
        }
        .custom-btn1:hover {
            color: #FFFFFF;
            background-color: #595F80;
            border-color: #595F80;
        }
        .custom-btn2 {
            color: #FFFFFF;
            background-color: #F6B17A;
            border-color: #C48D61;
        }
        .custom-btn2:hover {
            color: #FFFFFF;
            background-color: #C48D61;
            border-color: #C48D61;
        }

        /* nav */
        .custom-nav {
            color: #FFFFFF;
            margin-left: 10px;
        }
        /* CSS untuk tautan yang sedang aktif dan tidak aktif */
        .nav-link.custom-nav.active {
            color: #FFFFFF;
            font-weight: bold;
        }
        /* CSS untuk tautan yang sedang tidak aktif dan dihover */
        .nav-link.custom-nav:not(.active):hover {
            color: #CCCCCC;
        }

        .bg-image {
          height: 100vh;
          background-image: url('../assets/img/bg.jpg');
          background-size: cover;
          background-position: center;
          font-family: "Josefin Sans", sans-serif;
          font-weight: 400;
        }

    </style>
</head>
<body>
    <!-- nav -->
    <nav class="navbar navbar-expand-lg" style="background: #2D3250;">
        <div class="container mt-2 mb-2">
            <a class="navbar-brand text-light" href="index.php"><i class="fa-solid fa-image"></i> <strong>Galeri Foto</strong></a>
            <button class="navbar-toggler" type="button" data-bs-theme="dark" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav me-auto">
                    <a href="index.php" class="nav-link custom-nav">Home</a>
                    <a href="profil.php" class="nav-link custom-nav">Profil</a>
                    <a href="foto.php" class="nav-link custom-nav">Foto</a>
                </div>
                <a href="../logout.php" class="btn custom-btn1" style="margin-right: 10px;">Logout</a>
                <a href="akun.php" class="custom-icon1"><i class="fa-solid fa-circle-user fa-2xl" style="color: #FFFFFF;"></i></a>
            </div>
        </div>
    </nav>

    <div class="container min-vh-100">
        <div class="row mt-4" style="justify-content: center;">
            <div class="col-md-10">
                <h4 style="font-weight: bold;">Profil Akun</h4>
                <div class="card" style="background: #7077A1;">
                    <div class="card-body text-light">

                        <?php if(isset($_SESSION['alertbenar'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo $_SESSION['alertbenar']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php unset($_SESSION['alertbenar']); ?>
                        <?php endif; ?>

                        <?php if(isset($_SESSION['alertsalah'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $_SESSION['alertsalah']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php unset($_SESSION['alertsalah']); ?>
                        <?php endif; ?>

                        <?php 
                            $user_id = $_SESSION['user_id'];
                            $sql = mysqli_query($koneksi, "SELECT * FROM user WHERE user_id = '$user_id'");
                            $data = mysqli_fetch_assoc($sql);  
                        ?>
                        <form action="../config/aksi_akun.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="user_id" value="<?php echo $data['user_id'] ?>">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $data['username'] ?>" required>
                            <label class="form-label">Email</label>
                            <input type="text" name="email" class="form-control" value="<?php echo $data['email'] ?>" required>
                            <label class="form-label mt-2">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap" value="<?php echo $data['nama_lengkap'] ?>" required>
                            <label class="form-label mt-2">Alamat</label>
                            <input type="text" class="form-control" name="alamat" value="<?php echo $data['alamat'] ?>" required>
                            <button type="submit" class="btn custom-btn2 mt-3" name="ubah_data">Ubah Data</button>
                        </form>
                    </div>
                </div>
                <div class="card text-light mt-3" style="background: #7077A1;">
                    <div class="card-header">
                        Ubah Password
                    </div>
                    <div class="card-body">
                        <?php if(isset($_SESSION['alertbenar2'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo $_SESSION['alertbenar2']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php unset($_SESSION['alertbenar2']); ?>
                        <?php endif; ?>
                        
                        <?php if(isset($_SESSION['alertsalah2'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $_SESSION['alertsalah2']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php unset($_SESSION['alertsalah2']); ?>
                        <?php endif; ?>

                        <form action="../config/aksi_akun.php" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $data['user_id'] ?>">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control"required>
                            <label class="form-label mt-2">Konfirmasi Password</label>
                            <input type="password" name="password2" class="form-control" required>
                            <button type="submit" class="btn custom-btn2 mt-3" name="ubah_password">Ubah Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <footer class="d-flex justify-content-center border-top mt-3" style="background: #424769;">
        <p class="text-light mt-3">&copy; UJI KOMPETENSI RPL 2024 | Mila Karmila</p>
    </footer>

    <!-- js -->
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
</body>
</html>