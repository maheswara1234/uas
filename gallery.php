<div class="container">
    <div class="row mb-2">
        <div class="col-md-6">
            <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-lg"></i> Tambah Gambar
            </button>
        </div>
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" id="search" class="form-control" placeholder="Ketikkan minimal 3 karakter untuk pencarian...">
                <span class="input-group-text">
                    <i class="bi bi-search"></i>
                </span>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-primary">
                    <tr>
                        <th style="width: 1%;">No</th>
                        <th class="w-50">Judul</th>
                        <th class="w-25">Gambar</th>
                        <th class="text-end" style="width: 1%; white-space: nowrap;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="result">
                    </tbody>
            </table>
        </div>
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
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control" name="judul" placeholder="Tuliskan Judul Gambar" required>
                        </div>
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

<script>
    function loadData(keyword = '') {
        $.ajax({
            url: "gallery_data.php",
            type: "POST",
            data: {
                keyword: keyword
            },
            success: function(data) {
                $("#result").html(data);
            }
        });
    }

    loadData();

    $("#search").on("keyup", function() {
        let keyword = $(this).val();
        if (keyword.length >= 3 || keyword.length === 0) {
            loadData(keyword);
        }
    });
</script>

<?php
include "upload_foto.php";

// LOGIKA PHP: SIMPAN & HAPUS
if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
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
        // UPDATE
        $id = $_POST['id'];
        if ($nama_gambar == '') {
            $gambar = $_POST['gambar_lama'];
        } else {
            unlink("img/" . $_POST['gambar_lama']);
        }

        $stmt = $conn->prepare("UPDATE gallery SET judul = ?, gambar = ?, tanggal = ? WHERE id = ?");
        $stmt->bind_param("sssi", $judul, $gambar, $tanggal, $id);
        $simpan = $stmt->execute();
    } else {
        // INSERT
        $stmt = $conn->prepare("INSERT INTO gallery (judul, gambar, tanggal) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $judul, $gambar, $tanggal);
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