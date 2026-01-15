<?php
include "koneksi.php";

$keyword = $_POST['keyword'];

// --- LOGIKA PENCARIAN ---
$sql = "SELECT * FROM gallery 
        WHERE judul LIKE ? 
        ORDER BY tanggal DESC";

$stmt = $conn->prepare($sql);
$search = "%" . $keyword . "%";
$stmt->bind_param("s", $search);
$stmt->execute();
$hasil = $stmt->get_result();

$no = 1;
while ($row = $hasil->fetch_assoc()) {
?>
    <tr>
        <td><?= $no++ ?></td>
        <td>
            <strong><?= $row["judul"] ?></strong>
            <br>pada : <?= $row["tanggal"] ?>
            <br>oleh : admin
        </td>
        <td>
            <?php
            if ($row["gambar"] != '') {
                if (file_exists('img/' . $row["gambar"] . '')) {
                    echo '<img src="img/' . $row["gambar"] . '" class="img-fluid" style="max-width: 150px; height: auto;" alt="Gambar">';
                }
            }
            ?>
        </td>
        
        <td class="text-end">
            <div class="d-flex flex-column align-items-end gap-2">
                <a href="#" title="edit" class="badge rounded-pill text-bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row["id"] ?>">
                    <i class="bi bi-pencil"></i>
                </a>
                <a href="#" title="delete" class="badge rounded-pill text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row["id"] ?>">
                    <i class="bi bi-x-circle"></i>
                </a>
            </div>

            <div class="modal fade" id="modalEdit<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content text-start">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Gambar</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                <div class="mb-3">
                                    <label for="judul" class="form-label">Judul</label>
                                    <input type="text" class="form-control" name="judul" value="<?= $row["judul"] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="gambar" class="form-label">Ganti Gambar</label>
                                    <input type="file" class="form-control" name="gambar">
                                </div>
                                <div class="mb-3">
                                    <label for="formGroupExampleInput3" class="form-label">Gambar Lama</label>
                                    <?php
                                    if ($row["gambar"] != '') {
                                        if (file_exists('img/' . $row["gambar"] . '')) {
                                            echo '<br><img src="img/' . $row["gambar"] . '" class="img-fluid" style="max-width: 200px;" alt="Gambar">';
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
                    <div class="modal-content text-start">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Hapus Gambar</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="formGroupExampleInput" class="form-label">Yakin akan menghapus gambar "<strong><?= $row["judul"] ?></strong>"?</label>
                                    <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                    <input type="hidden" name="gambar" value="<?= $row["gambar"] ?>">
                                    <?php
                                    if ($row["gambar"] != '') {
                                        if (file_exists('img/' . $row["gambar"] . '')) {
                                            echo '<br><img src="img/' . $row["gambar"] . '" class="img-fluid" style="max-width: 100px;" alt="Gambar">';
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
        </td>
    </tr>
<?php
}
?>