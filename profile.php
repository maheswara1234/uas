<?php
include "koneksi.php";
include "upload_foto.php";

// 1. LOGIKA SIMPAN DATA (Ditaruh di atas agar data langsung terupdate saat tampil)
if (isset($_POST['simpan'])) {
    $password = $_POST['password'];
    $foto_lama = $_POST['foto_lama'];
    $username = $_SESSION['username'];
    $foto_baru = '';

    // Cek jika ada foto baru yang diupload
    if ($_FILES['foto']['name'] != '') {
        $cek_upload = upload_foto($_FILES["foto"]);
        
        if ($cek_upload['status']) {
            $foto_baru = $cek_upload['message'];
            
            // Hapus foto lama jika ada & bukan default (misal logo.png)
            if ($foto_lama != '' && file_exists("img/" . $foto_lama) && $foto_lama != 'logo.png') {
                unlink("img/" . $foto_lama);
            }
        } else {
            echo "<script>
                alert('" . $cek_upload['message'] . "');
                document.location='admin.php?page=profile';
            </script>";
            die;
        }
    } else {
        // Jika tidak upload foto baru, pakai foto lama
        $foto_baru = $foto_lama;
    }

    // Cek jika password diganti
    if ($password == '') {
        // Password kosong = update foto saja
        $stmt = $conn->prepare("UPDATE user SET foto = ? WHERE username = ?");
        $stmt->bind_param("ss", $foto_baru, $username);
    } else {
        // Password isi = update password & foto
        $password_baru = md5($password);
        $stmt = $conn->prepare("UPDATE user SET password = ?, foto = ? WHERE username = ?");
        $stmt->bind_param("sss", $password_baru, $foto_baru, $username);
    }

    if ($stmt->execute()) {
        echo "<script>
            alert('Data Profile Berhasil Diperbarui');
            document.location='admin.php?page=profile';
        </script>";
    } else {
        echo "<script>
            alert('Gagal Memperbarui Data');
            document.location='admin.php?page=profile';
        </script>";
    }
    $stmt->close();
}

// 2. LOGIKA AMBIL DATA USER
$username = $_SESSION['username'];
$sql = "SELECT * FROM user WHERE username = '$username'";
$hasil = $conn->query($sql);
$data = $hasil->fetch_assoc();

// Tentukan gambar profil
if (!empty($data['foto']) && file_exists("img/" . $data['foto'])) {
    $gambar_profil = "img/" . $data['foto'];
} else {
    $gambar_profil = "img/logo.png"; // Foto default
}
?>

<div class="container w-50"> <h4 class="mb-4">Pengaturan Profil</h4>
    
    <form method="post" action="" enctype="multipart/form-data">
        
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" value="<?= $data['username'] ?>" readonly>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Ganti Password</label>
            <input type="password" class="form-control" name="password" placeholder="Tuliskan Password Baru Jika Ingin Mengganti Password Saja">
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Ganti Foto Profil</label>
            <input type="file" class="form-control" name="foto">
            <input type="hidden" name="foto_lama" value="<?= $data['foto'] ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Foto Profil Saat Ini</label>
            <br>
            <img src="<?= $gambar_profil ?>" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;" alt="Foto Profil">
        </div>

        <div class="mb-3">
            <input type="submit" value="Simpan" name="simpan" class="btn btn-primary">
        </div>

    </form>
</div>