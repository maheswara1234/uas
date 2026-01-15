<?php
include "koneksi.php";  
?>

<style>
    /* Container Utama untuk Masonry */
    .masonry-container {
        column-count: 4; /* Default 4 kolom di layar besar */
        column-gap: 1.5rem; /* Jarak antar kolom */
    }

    /* Item Card */
    .masonry-item {
        break-inside: avoid; /* Mencegah card terpotong antar kolom */
        margin-bottom: 1.5rem; /* Jarak bawah antar item */
    }

    /* Card Styling */
    .gallery-card {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        cursor: pointer;
    }

    /* Gambar menyesuaikan ukuran aslinya */
    .gallery-img {
        width: 100%;
        height: auto; /* PENTING: Agar tinggi menyesuaikan gambar asli */
        display: block;
        transition: transform 0.3s ease;
    }

    /* Efek Zoom saat Hover */
    .gallery-card:hover .gallery-img {
        transform: scale(1.05); /* Zoom halus */
    }

    /* Overlay (Teks & Tombol) */
    .gallery-overlay {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.6); /* Hitam transparan full */
        color: white;
        opacity: 0; /* Awalnya tidak terlihat */
        transition: opacity 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    /* Saat Hover, Tampilkan Overlay */
    .gallery-card:hover .gallery-overlay {
        opacity: 1;
    }

    /* Responsif: Atur jumlah kolom berdasarkan ukuran layar */
    @media (max-width: 992px) {
        .masonry-container { column-count: 3; }
    }
    @media (max-width: 768px) {
        .masonry-container { column-count: 2; }
    }
    @media (max-width: 576px) {
        .masonry-container { column-count: 1; }
    }
</style>

<div class="container">
    <button type="button" class="btn btn-secondary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i> Tambah Gambar
    </button>
    
    <div class="masonry-container">
        <?php
        $sql = "SELECT * FROM gallery ORDER BY tanggal DESC";
        $hasil = $conn->query($sql);

        while ($row = $hasil->fetch_assoc()) {
        ?>
            <div class="masonry-item">
                <div class="gallery-card">
                    <?php
                    if ($row["gambar"] != '') {
                        if (file_exists('img/' . $row["gambar"] . '')) {
                    ?>
                            <img src="img/<?= $row["gambar"] ?>" class="gallery-img" alt="Gallery Image">
                    <?php
                        }
                    }
                    ?>

                    <div class="gallery-overlay">
                        <small class="mb-2">
                            <i class="bi bi-calendar-event"></i> <?= $row["tanggal"] ?>
                        </small>
                        
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-success text-white" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row["id"] ?>">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row["id"] ?>">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalEdit<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Gallery</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                <div class="mb-3">
                                    <label for="gambar" class="form-label">Ganti Gambar</label>
                                    <input type="file" class="form-control" name="gambar">
                                </div>
                                <div class="mb-3">
                                    <label for="formGroupExampleInput3" class="form-label">Gambar Lama</label>
                                    <?php
                                    if ($row["gambar"] != '') {
                                        if (file_exists('img/' . $row["gambar"] . '')) {
                                    ?>
                                            <br><img src="img/<?= $row["gambar"] ?>" class="img-fluid border rounded mt-2" width="100%" alt="Gambar">
                                    <?php
                                        }
                                    }
                                    ?>
                                    <input type="hidden" name="gambar_lama" value="<?= $row["gambar"] ?>">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input type="submit" value="simpan" name="simpan" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalHapus<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Hapus Gallery</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="formGroupExampleInput" class="form-label">Yakin akan menghapus gambar ini?</label>
                                    <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                    <input type="hidden" name="gambar" value="<?= $row["gambar"] ?>">
                                    <?php
                                    if ($row["gambar"] != '') {
                                        if (file_exists('img/' . $row["gambar"] . '')) {
                                    ?>
                                            <br><img src="img/<?= $row["gambar"] ?>" class="img-fluid border rounded mt-2" width="100" alt="Gambar">
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <input type="submit" value="hapus" name="hapus" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalTambahLabel">Tambah Gallery</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control" name="gambar" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" value="simpan" name="simpan" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include "upload_foto.php";

//jika tombol simpan diklik
if (isset($_POST['simpan'])) {
    $tanggal = date("Y-m-d H:i:s");
    $gambar = '';
    $nama_gambar = $_FILES['gambar']['name'];

    if ($nama_gambar != '') {
        $cek_upload = upload_foto($_FILES["gambar"]);
        if ($cek_upload['status']) {
            $gambar = $cek_upload['message'];
        } else {
            echo "<script>
                alert('" . $cek_upload['message'] . "');
                document.location='admin.php?page=gallery';
            </script>";
            die;
        }
    }

    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        if ($nama_gambar == '') {
            $gambar = $_POST['gambar_lama'];
        } else {
            unlink("img/" . $_POST['gambar_lama']);
        }

        $stmt = $conn->prepare("UPDATE gallery SET gambar = ?, tanggal = ? WHERE id = ?");
        $stmt->bind_param("ssi", $gambar, $tanggal, $id);
        $simpan = $stmt->execute();
    } else {
        $stmt = $conn->prepare("INSERT INTO gallery (gambar, tanggal) VALUES (?, ?)");
        $stmt->bind_param("ss", $gambar, $tanggal);
        $simpan = $stmt->execute();
    }

    if ($simpan) {
        echo "<script>
            alert('Simpan data sukses');
            document.location='admin.php?page=gallery';
        </script>";
    } else {
        echo "<script>
            alert('Simpan data gagal');
            document.location='admin.php?page=gallery';
        </script>";
    }

    $stmt->close();
    $conn->close();
}

if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $gambar = $_POST['gambar'];

    if ($gambar != '') {
        unlink("img/" . $gambar);
    }

    $stmt = $conn->prepare("DELETE FROM gallery WHERE id = ?");
    $stmt->bind_param("i", $id);
    $hapus = $stmt->execute();

    if ($hapus) {
        echo "<script>
            alert('Hapus data sukses');
            document.location='admin.php?page=gallery';
        </script>";
    } else {
        echo "<script>
            alert('Hapus data gagal');
            document.location='admin.php?page=gallery';
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>