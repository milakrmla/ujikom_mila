<?php
session_start();
include 'config/koneksi.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['kirimkomentar'])) {
    $foto_id = $_POST['foto_id'];
    $isi_komentar = $_POST['isi_komentar'];
    $tanggal_komentar = date('Y-m-d');

    // Simpan komentar ke dalam database
    $query = "INSERT INTO komentar_foto (foto_id, user_id, isi_komentar, tanggal_komentar) VALUES ('$foto_id', NULL, '$isi_komentar', '$tanggal_komentar')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        // Redirect ke halaman yang sesuai
        header("Location: index.php");
        exit(); // Penting untuk menghentikan eksekusi skrip setelah melakukan redirect
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}

// Handle like submission
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['foto_id'])) {
    $foto_id = $_GET['foto_id'];

    // Cek apakah pengguna telah menyukai foto tersebut sebelumnya berdasarkan cookie
    if(isset($_COOKIE['liked_'.$foto_id])) {
        // Jika pengguna telah menyukai foto tersebut sebelumnya, hapus like dari database
        $query = "DELETE FROM like_foto WHERE foto_id='$foto_id' AND user_id IS NULL";
        setcookie('liked_'.$foto_id, '', time() - 5, '/'); // Hapus cookie
    } else {
        // Cek apakah pengguna telah menyukai foto tersebut sebelumnya berdasarkan data yang tersimpan di database
        $cek_like = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE foto_id='$foto_id' AND user_id IS NULL");
        if (mysqli_num_rows($cek_like) > 0) {
            // Jika pengguna telah menyukai foto tersebut sebelumnya, hapus like dari database
            $query = "DELETE FROM like_foto WHERE foto_id='$foto_id' AND user_id IS NULL";
        } else {
            // Jika pengguna belum menyukai foto tersebut, simpan like ke dalam database
            $query = "INSERT INTO like_foto (foto_id, user_id, tanggal_like) VALUES ('$foto_id', NULL, NOW())";
        }
        // Set cookie untuk menandai bahwa pengguna telah menyukai foto tersebut
        setcookie('liked_'.$foto_id, '1', time() + 5, '/'); // Set cookie untuk 1 jam
    }

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        // Redirect ke halaman yang sesuai
        header("Location: index.php");
        exit(); // Penting untuk menghentikan eksekusi skrip setelah melakukan redirect
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Foto</title>
    <!-- favicon -->
    <link rel="shortcut icon" href="favicon.ico">
    <!-- css -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
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
          background-image: url('assets/image/bg.jpg');
          background-size: cover;
          background-position: center;
          font-family: "Josefin Sans", sans-serif;
          font-weight: 400;
        }
        
        .card {
            transition: all 0.3s ease; /* Transisi agar perubahan terlihat lebih halus */
            cursor: pointer;
            border-radius: 10px; /* Menambahkan border-radius untuk memberi sudut yang lebih lembut */
            overflow: hidden; /* Menghilangkan gambar yang mungkin melebihi border */
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1); /* Memberikan efek bayangan */
        }

        .card:hover {
            transform: scale(1.05); /* Membuat kartu sedikit membesar saat dihover */
            box-shadow: 0px 0px 15px 0px rgba(0, 0, 0, 0.2); /* Meningkatkan efek bayangan */
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
            <div class="collapse navbar-collapse " id="navbarNavAltMarkup">
                <div class="navbar-nav me-auto">
                
                </div>
                <a href="registrasi.php" class="btn custom-btn1" style="margin-right: 5px;">Sign Up</a>
                <a href="login.php" class="btn custom-btn2">Login</a>
            </div>
        </div>
    </nav>

    <div class="bg-image p-5 text-center shadow-1-strong rounded mb-5 text-white" style="position: relative;">
        <div class="position-absolute top-50 start-50 translate-middle" style="z-index: 1;">
            <h1 class="mb-3" style="color: #2D3250; white-space: nowrap;">Ekspresikan <b style="color: #F6B17A;">keindahan</b> dalam gambar.</h1>
            <p style="color: #2D3250;">
                <b>Tunjukkan</b> keindahan dunia dalam satu sentuhan gambar. <b>Temukan</b> inspirasi dalam setiap momen melalui koleksi foto pada galeri kami.
            </p>
        </div>
    </div>

    <div class="container mt-3">
        <div class="row">
            <?php
            $query = mysqli_query($koneksi, "SELECT * FROM foto INNER JOIN user ON foto.user_id=user.user_id");
            while($data = mysqli_fetch_array($query)) {
            ?>
            <div class="col-md-3">
                <!-- <a type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['foto_id'] ?>">
                    
                    <div class="card mb-2">
                        <img style="height: 12rem;" src="assets/img/<?php echo $data['lokasi_file'] ?>" class="card-img-top" title="<?php echo $data['judul_foto'] ?>">
                        <div class="card-footer text-center">
                            <?php 
                            $foto_id = $data['foto_id'];
                            $ceksuka = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE foto_id='$foto_id'");
                            ?>
                            <a href="login.php"><i class="fa-regular fa-heart"></i></a>
                            <?php 
                            $like = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE foto_id='$foto_id'");
                            echo mysqli_num_rows($like). ' Suka';
                            ?>
                            <a href="#" type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['foto_id'] ?>" style="margin-left: 5px;"><i class="fa-regular fa-comment"></i></a>
                            <?php
                            $jmlkomen = mysqli_query($koneksi, "SELECT * FROM komentar_foto WHERE foto_id='$foto_id'");
                            echo mysqli_num_rows($jmlkomen). ' Komentar';
                            ?>
                        </div>
                    </div>
                </a> -->

                <a type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['foto_id'] ?>">
                <div class="card mb-2">
                <img style="height: 12rem;" src="assets/img/<?php echo $data['lokasi_file'] ?>" class="card-img-top" title="<?php echo $data['judul_foto'] ?>">
                <div class="card-footer text-center">
                    <?php 
                    $foto_id = $data['foto_id'];
                    $ceksuka = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE foto_id='$foto_id'");
                    ?>
                    <?php
                        // Cek apakah pengguna telah menyukai foto tersebut sebelumnya
                        $cek_like = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE foto_id='$foto_id' AND user_id IS NULL");
                        if (mysqli_num_rows($cek_like) > 0) {
                            // Jika pengguna telah menyukai foto tersebut sebelumnya, tampilkan ikon hati solid
                            $heart_icon = '<i class="fa-solid fa-heart"></i>';
                        } else {
                            // Jika pengguna belum menyukai foto tersebut, tampilkan ikon hati regular
                            $heart_icon = '<i class="fa-regular fa-heart"></i>';
                        }
                        ?>

                        <a href="index.php?foto_id=<?php echo $data['foto_id'] ?>"><?php echo $heart_icon ?></a>
                    <?php 
                    $like = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE foto_id='$foto_id'");
                    echo mysqli_num_rows($like). ' Suka';
                    ?>
                    <a href="#" type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['foto_id'] ?>" style="margin-left: 5px;"><i class="fa-regular fa-comment"></i></a>
                    <?php
                    $jmlkomen = mysqli_query($koneksi, "SELECT * FROM komentar_foto WHERE foto_id='$foto_id'");
                    echo mysqli_num_rows($jmlkomen). ' Komentar';
                    ?>
                </div>
            </div>
                </a>

                <!-- Modal -->
                <div class="modal fade" id="komentar<?php echo $data['foto_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <a href="assets/img/<?php echo $data['lokasi_file'] ?>" target="_blank"><img src="assets/img/<?php echo $data['lokasi_file'] ?>" class="card-img-top" title="<?php echo $data['judul_foto'] ?>"></a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="m-2">
                                            <div class="overflow-auto">
                                                <div class="sticky-top">
                                                    <strong><?php echo $data['judul_foto'] ?></strong><br>
                                                    <span class="badge bg-secondary"><?php echo $data['nama_lengkap'] ?></span>
                                                    <span class="badge bg-secondary"><?php echo $data['tanggal_unggah'] ?></span>
                                                </div>
                                                <hr>
                                                <p align="left">
                                                    <?php echo $data['deskripsi_foto']?>
                                                </p>
                                                <hr>

                                                <!-- <div class="overflow-auto" style="max-height: 150px;">
                                                    <?php 
                                                    $foto_id = $data['foto_id'];
                                                    $komentar = mysqli_query($koneksi, "SELECT * FROM komentar_foto INNER JOIN user ON komentar_foto.user_id=user.user_id WHERE komentar_foto.foto_id='$foto_id'");
                                                    while($row = mysqli_fetch_array($komentar)) {
                                                    ?>
                                                    <p align="left">
                                                        <strong><?php echo $row['nama_lengkap'] ?></strong>
                                                        <?php echo $row['isi_komentar']; ?>
                                                    </p>
                                                    <?php } ?>
                                                </div> -->

                                                <div class="overflow-auto" style="max-height: 150px;">
                                                <?php 
                                                    $foto_id = $data['foto_id'];
                                                    $komentar = mysqli_query($koneksi, "SELECT * FROM komentar_foto LEFT JOIN user ON komentar_foto.user_id=user.user_id WHERE komentar_foto.foto_id='$foto_id'");
                                                    while($row = mysqli_fetch_array($komentar)) {
                                                        $nama_lengkap = $row['nama_lengkap'] ? $row['nama_lengkap'] : "Anonim";
                                                ?>
                                                    <p align="left">
                                                        <strong><?php echo $nama_lengkap ?></strong>
                                                        <?php echo $row['isi_komentar']; ?>
                                                    </p>
                                                <?php } ?>
                                                </div>

                                                <hr>
                                                <div class="sticky-bottom mb-2">
                                                    <!-- <form action="login.php" method="POST">
                                                        <div class="input-group">
                                                            <input type="hidden" name="foto_id" value="<?php echo $data['foto_id'] ?>">
                                                            <input type="text" name="isi_komentar" class="form-control" placeholder="Tambah Komentar" style="margin-left: 5px; border-radius: 5px;" required>
                                                            <div class="input-group-prepend">
                                                                <button type="submit" name="kirimkomentar" class="btn btn-outline-primary" style="margin-left: 5px;">Kirim</button>
                                                            </div>
                                                        </div>
                                                    </form> -->
                                                    
                                                    <form action="" method="POST">
                                                        <input type="hidden" name="foto_id" value="<?php echo $data['foto_id'] ?>">
                                                        <div class="input-group">
                                                            <input type="text" name="isi_komentar" class="form-control" placeholder="Tambah Komentar" required>
                                                            <div class="input-group-prepend">
                                                                <button type="submit" name="kirimkomentar" class="btn btn-outline-primary">Kirim</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    
    <!-- footer -->
    <footer class="d-flex justify-content-center border-top mt-3" style="background: #424769;">
        <p class="text-light mt-3">&copy; UJI KOMPETENSI RPL 2024 | Mila Karmila</p>
    </footer>

    <!-- js -->
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
</body>
</html>