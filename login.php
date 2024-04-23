<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Galeri Foto</title>
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
        .custom-btn1:hover, .custom-btn1.active {
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
        .custom-btn3 {
            color: #FFFFFF;
            background-color: #424769;
            border-color: #595F80;
        }
        .custom-btn3:hover{
            color: #FFFFFF;
            background-color: #2d3250;
            border-color: #595F80;
        }
        .form-label, .form-control, .btn-round {
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <!-- nav -->
    <nav class="navbar navbar-expand-lg bg-white">
        <div class="container mt-2 mb-2">
            <a class="navbar-brand" style="color: #2d3250;" href="index.php"><i class="fa-solid fa-image" style="color: #2d3250;"></i> <strong>Galeri Foto</strong></a>
            <button class="navbar-toggler" type="button" data-bs-theme="light" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav me-auto">
                
                </div>
                <a href="index.php"><i class="fa-solid fa-xmark fa-lg" style="color: #2d3250;"></i></a>
            </div>
        </div>
    </nav>

    <div class="container mt-3">
        <div class="text-center">
            <h5 style="font-weight: bold;"><i class="fa-solid fa-right-to-bracket" style="color: #2d3250;"></i> LOGIN</h5>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4 mt-2">
                <div class="card" style="background: #7077A1; border-radius: 2%;">
                        <div class="card-body text-white mt-2" >
                            <?php if(isset($_SESSION['alertsalah'])): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo $_SESSION['alertsalah']; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php unset($_SESSION['alertsalah']); ?>
                            <?php endif; ?>
                            <form action="config/aksi_login.php" method="POST">
                                <label class="form-label" for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control" required>
                                <label class="form-label mt-2" for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                                <div class="d-grid mt-2">
                                    <button class="btn custom-btn3 btn-round" type="submit" name="kirim">LOGIN</button>
                                </div>
                            </form>
                            <hr>
                            <p>Belum punya akun? <a href="registrasi.php" style="color:#F6B17A;">Sign Up</a></p>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
    
    <!-- footer -->
    <footer class="d-flex justify-content-center border-top mt-5 fixed-bottom bg-white">
        <p class="mt-3" style="color: #2d3250;">&copy; UJI KOMPETENSI RPL 2024 | Mila Karmila</p>
    </footer>

<!-- js -->
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
</body>
</html>