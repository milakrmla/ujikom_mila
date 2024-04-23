<?php
session_start();
include 'koneksi.php';

// Pastikan permintaan berasal dari metode POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    // Redirect jika permintaan bukan dari metode POST
    header("Location: ../index.php");
    exit;
}

if (isset($_POST['tambah'])) {
    $judul_foto = mysqli_real_escape_string($koneksi, $_POST['judul_foto']); 
    $deskripsi_foto = mysqli_real_escape_string($koneksi, $_POST['deskripsi_foto']); 
    $tanggal_unggah = date('Y-m-d');
    $user_id = $_SESSION['user_id'];
    $foto = $_FILES['lokasi_file']['name'];
    $tmp = $_FILES['lokasi_file']['tmp_name'];
    $lokasi = '../assets/img/';
    $nama_foto = rand().'-'.$foto;
    $ukuranFile = $_FILES['lokasi_file']['size'];

    // cek apakah yang diupload adalah gambar
    $checkImage = getimagesize($tmp);
    if($checkImage === false) {
        // echo "<script>
        //         alert('File yang Anda upload bukan gambar!');
        //         location.href='../admin/foto.php';
        //       </script>";
        $_SESSION['alertsalah'] = 'File yang Anda upload bukan gambar!';
        header("Location: ../admin/foto.php");
        return false;
    }

    // cek jika ukurannya terlalu besar
    if( $ukuranFile > 20000000 ) { // 20MB dalam byte
        // echo "<script>
        //         alert('Ukuran gambar terlalu besar!');
        //       </script>";
        $_SESSION['alertsalah'] = 'Ukuran gambar terlalu besar!';
        header("Location: ../admin/foto.php");
        return false;
    }

    move_uploaded_file($tmp, $lokasi.$nama_foto);

    $sql = mysqli_query($koneksi, "INSERT INTO foto VALUES('','$judul_foto','$deskripsi_foto','$tanggal_unggah', '$nama_foto', '$user_id')");

    if($sql) {
        $_SESSION['alertbenar'] = 'Data berhasil disimpan!';
        header("Location: ../admin/foto.php");
        exit;
    }

}

if (isset($_POST['edit'])) {
    $foto_id = $_POST['foto_id'];
    $judul_foto = mysqli_real_escape_string($koneksi, $_POST['judul_foto']); 
    $deskripsi_foto = mysqli_real_escape_string($koneksi, $_POST['deskripsi_foto']); // escaping deskripsi foto
    $tanggal_unggah = date('Y-m-d');
    $user_id = $_SESSION['user_id'];
    $foto = $_FILES['lokasi_file']['name'];
    $tmp = $_FILES['lokasi_file']['tmp_name'];
    $lokasi = '../assets/img/';
    $nama_foto = rand().'-'.$foto;

    if ($foto == null) {
        $sql = mysqli_query($koneksi, "UPDATE foto SET judul_foto='$judul_foto', deskripsi_foto='$deskripsi_foto', tanggal_unggah='$tanggal_unggah' WHERE foto_id='$foto_id'"); 
    } else {
        $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE foto_id='$foto_id'");
        $data = mysqli_fetch_array($query);
        if (is_file('../assets/img/'.$data['lokasi_file'])) {
            unlink('../assets/img/'.$data['lokasi_file']);
        }
        move_uploaded_file($tmp, $lokasi.$nama_foto);
        $sql = mysqli_query($koneksi, "UPDATE foto SET judul_foto='$judul_foto', deskripsi_foto='$deskripsi_foto', tanggal_unggah='$tanggal_unggah', lokasi_file='$nama_foto' WHERE foto_id='$foto_id'"); 
    }
    echo "<script>
    alert('Data berhasil diperbarui!');
    location.href='../admin/foto.php';
    </script>";
}

if (isset($_POST['hapus'])) {
    $foto_id = $_POST['foto_id'];
    $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE foto_id='$foto_id'");
        $data = mysqli_fetch_array($query);
        if (is_file('../assets/img/'.$data['lokasi_file'])) {
            unlink('../assets/img/'.$data['lokasi_file']);
        }

        $sql = mysqli_query($koneksi, "DELETE FROM foto WHERE foto_id='$foto_id'");
        echo "<script>
        alert('Data berhasil diperbarui!');
        location.href='../admin/foto.php';
        </script>";
}

?>
