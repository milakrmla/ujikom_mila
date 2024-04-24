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
        .custom-btn1:hover, .custom-btn1:active {
            color: #FFFFFF;
            background-color: #595F80;
            border-color: #595F80;
        }
        .custom-btn2 {
            color: #FFFFFF;
            background-color: #F6B17A;
            border-color: #C48D61;
        }
        .custom-btn2:hover, .custom-btn2:active {
            color: #FFFFFF;
            background-color: #C48D61;
            border-color: #C48D61;
        }
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

        /* background table th */
        thead tr .custom-th {
            background-color: #7077A1;
            color: #FFFFFF;
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
                    <a href="index.php" class="nav-link custom-nav ">Home</a>
                    <a href="profil.php" class="nav-link custom-nav">Profil</a>
                    <a href="foto.php" class="nav-link custom-nav active">Foto</a>
                </div>
                <a href="../logout.php" class="btn custom-btn1" style="margin-right: 10px;">Logout</a>
                <a href="akun.php" class="custom-icon1"><i class="fa-solid fa-circle-user fa-2xl" style="color: #FFFFFF"></i></i></a>
            </div>
        </div>
    </nav>

    <div class="container min-v-100">
        <div class="row" style="justify-content: center;">
            <div class="col-md-8">
                <div class="card mt-4" style="background: #7077A1;">
                    <div class="card-body text-light">
                        <h4 style="font-weight: bold;">Tambah Foto</h4>
                        <hr>

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
                        
                        <form action="../config/aksi_foto.php" method="POST" enctype="multipart/form-data">
                            <label class="form-label">Judul Foto</label>
                            <input type="text" name="judul_foto" class="form-control" required>
                            <label class="form-label mt-2">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi_foto" required></textarea>
                            <label class="form-label mt-2">File</label>
                            <input type="file" class="form-control" name="lokasi_file" required>
                            <button type="submit" class="btn custom-btn2 mt-3" name="tambah">Tambah Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row min-vh-100" style="justify-content: center;">
            <div class="col-md-12 mt-4">
                        <div class="col-md-12 d-flex justify-content-between mt-3">
                            <h2 style="font-weight: bold;">Data Galeri Foto</h2>
                            <form action="" method="POST" class="col-md-4 mb-3 d-flex">
                                <input type="text" name="keyword" class="form-control" size="30" placeholder="Masukkan keyword pencarian" autocomplete="off" style="margin-right: 10px;">
                                <button type="submit" name="cari" class="btn custom-btn2"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </form>
                        </div>
                        <div class="table-responsive" style="overflow-x: auto;">
                        <table class="table table-responsive table-bordered table-light" style="border-color: #2D3250;">
                            <thead class="text-center">
                                <tr class="">
                                    <th class="custom-th" width="30px">No</th>
                                    <th class="custom-th" width="100px">Foto</th>
                                    <th class="custom-th" width="200px">Judul Foto</th>
                                    <th class="custom-th">Deskripsi</th>
                                    <th class="custom-th" width="105px" >Tanggal</th>
                                    <th class="custom-th" width="182px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    if(isset($_POST['cari'])) {
                                        $keyword = $_POST['keyword'];
                                        $sql = "SELECT * FROM foto WHERE user_id = '$user_id' AND (judul_foto LIKE '%$keyword%' OR deskripsi_foto LIKE '%$keyword%')";
                                    } else {
                                        $sql = "SELECT * FROM foto WHERE user_id = '$user_id'";
                                    }
                                    $result = mysqli_query($koneksi, $sql);
                                    $no = 1;
                                    while($data = mysqli_fetch_array($result)){
                                ?>
                                <tr>
                                    <td align="center"><?php echo $no++ ?></td>
                                    <td><img src="../assets/img/<?php echo $data['lokasi_file'] ?>" width="100" data-bs-toggle="modal" data-bs-target="#fullImageModal<?php echo $data['foto_id'] ?>">
                                    <div class="modal fade" id="fullImageModal<?php echo $data['foto_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl text-center">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <a href="../assets/img/<?php echo $data['lokasi_file'] ?>" target="_blank"><img src="../assets/img/<?php echo $data['lokasi_file'] ?>" class="img-fluid"> </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </td>
                                    <td><?php echo $data['judul_foto'] ?></td>
                                    <td><?php echo $data['deskripsi_foto'] ?></td>
                                    <td><?php echo $data['tanggal_unggah'] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?php echo $data['foto_id'] ?>" >
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            Edit
                                        </button>

                                        <div class="modal fade" id="edit<?php echo $data['foto_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="../config/aksi_foto.php" method="POST" enctype="multipart/form-data">
                                                            <input type="hidden" name="foto_id" value="<?php echo $data['foto_id'] ?>">
                                                            <label class="form-label">Judul Foto</label>
                                                            <input type="text" name="judul_foto" value="<?php echo $data['judul_foto'] ?>" class="form-control" required>
                                                            <label class="form-label mt-2">Deskripsi</label>
                                                            <textarea class="form-control" name="deskripsi_foto" required><?php echo $data['deskripsi_foto'] ?></textarea>
                                                            <label class="form-label mt-2">Foto</label>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <a href="../assets/img/<?php echo $data['lokasi_file'] ?>" target="_blank"><img src="../assets/img/<?php echo $data['lokasi_file'] ?>" width="100"></a>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <label class="form-label">Ganti File</label>
                                                                    <input type="file" class="form-control" name="lokasi_file">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="edit" class="btn btn-primary">Edit Data</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $data['foto_id'] ?>">
                                            <i class="fa-solid fa-trash-can"></i>
                                            Hapus
                                        </button>

                                        <div class="modal fade" id="hapus<?php echo $data['foto_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="../config/aksi_foto.php" method="POST">
                                                            <input type="hidden" name="foto_id" value="<?php echo $data['foto_id'] ?>">
                                                            Apakah anda yakin akan menghapus data <strong>  <?php echo $data['judul_foto'] ?> </strong> ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="hapus" class="btn btn-primary">Hapus Data</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                                    </div>
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
