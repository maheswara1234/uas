<?php
// 1. Query untuk menghitung jumlah artikel
$sql1 = "SELECT * FROM article ORDER BY tanggal DESC";
$hasil1 = $conn->query($sql1);
$jumlah_article = $hasil1->num_rows;

// 2. Query untuk menghitung jumlah gallery
$sql2 = "SELECT * FROM gallery";
$hasil2 = $conn->query($sql2);
$jumlah_gallery = $hasil2->num_rows;

// 3. Query untuk mengambil data user yang sedang login (untuk foto profil)
$username = $_SESSION['username'];
$sql_user = "SELECT * FROM user WHERE username = '$username'";
$hasil_user = $conn->query($sql_user);
$user_data = $hasil_user->fetch_assoc();

// Cek apakah ada foto profil, jika tidak pakai default
$foto_profil = "img/logo.png"; // Default
if (!empty($user_data['foto']) && file_exists("img/" . $user_data['foto'])) {
    $foto_profil = "img/" . $user_data['foto'];
}
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-4 text-center">
        <div class="card border-0">
            <div class="card-body">
                <h4 class="text-muted fw-lighter">Selamat Datang,</h4>
                <h4 class="text-danger fw-bold"><?= $user_data['username'] ?></h4>
                <img src="<?= $foto_profil ?>" class="rounded-circle mb-3 shadow" style="width: 150px; height: 150px; object-fit: cover;" alt="Foto Profil">
            </div>
        </div>
    </div>
</div>

<div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center pt-4">
    
    <div class="col">
        <a href="admin.php?page=article" class="text-decoration-none">
            <div class="card border border-danger mb-3 shadow" style="max-width: 18rem;">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="p-3">
                            <h5 class="card-title text-dark"><i class="bi bi-newspaper"></i> Article</h5> 
                        </div>
                        <div class="p-3">
                            <span class="badge rounded-pill text-bg-danger fs-2"><?php echo $jumlah_article; ?></span>
                        </div> 
                    </div>
                </div>
            </div>
        </a>
    </div> 

    <div class="col">
        <a href="admin.php?page=gallery" class="text-decoration-none">
            <div class="card border border-danger mb-3 shadow" style="max-width: 18rem;">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="p-3">
                            <h5 class="card-title text-dark"><i class="bi bi-camera"></i> Gallery</h5> 
                        </div>
                        <div class="p-3">
                            <span class="badge rounded-pill text-bg-danger fs-2"><?php echo $jumlah_gallery; ?></span>
                        </div> 
                    </div>
                </div>
            </div>
        </a>
    </div> 

</div>

