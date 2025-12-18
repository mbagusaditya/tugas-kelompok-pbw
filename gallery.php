<div class="container">
    <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i>
    </button>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th class="w-25">Tanggal</th>
                        <th class="w-25">Gambar</th>
                        <th class="w-50">Deskripsi</th>
                        <th class="w-25">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM gallery ORDER BY tanggal DESC";
                    $hasil = $conn->query($sql);

                    $no = 1;
                    while ($row = $hasil->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <?= $row["tanggal"] ?>
                            </td>
                            <td>
                                <?php if ($row["gambar"] != "") {
                                    if (
                                        file_exists(
                                            "img/" . $row["gambar"] . "",
                                        )
                                    ) { ?>
                                        <img src="img/<?= $row[
                                            "gambar"
                                        ] ?>" width="100">
                                <?php }
                                } ?>
                            </td>
                            <td><?= $row["deskripsi"] ?></td>
                            <td>
                                <a href="#" title="edit" class="badge rounded-pill text-bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row[
                                    "id"
                                ] ?>"><i class="bi bi-pencil"></i></a>
                                <a href="#" title="delete" class="badge rounded-pill text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row[
                                    "id"
                                ] ?>"><i class="bi bi-x-circle"></i></a>

                                <div class="modal fade" id="modalEdit<?= $row[
                                    "id"
                                ] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Gallery</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="formGroupExampleInput2" class="form-label">Ganti Gambar</label>
                                                        <input type="file" class="form-control" name="gambar">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="formGroupExampleInput3" class="form-label">Gambar Lama</label>
                                                        <?php if (
                                                            $row["gambar"] != ""
                                                        ) {
                                                            if (
                                                                file_exists(
                                                                    "img/" .
                                                                        $row[
                                                                            "gambar"
                                                                        ] .
                                                                        "",
                                                                )
                                                            ) { ?>
                                                                <br><img src="img/<?= $row[
                                                                    "gambar"
                                                                ] ?>" width="100">
                                                        <?php }
                                                        } ?>
                                                        <input type="hidden" name="gambar_lama" value="<?= $row[
                                                            "gambar"
                                                        ] ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="floatingTextarea2">Deskripsi</label>
                                                        <textarea class="form-control" placeholder="Tuliskan Deskripsi Foto" name="deskripsi" required><?= $row[
                                                            "deskripsi"
                                                        ] ?></textarea>
                                                    </div>
                                                    <input type="hidden" name="id" value="<?= $row[
                                                        "id"
                                                    ] ?>">
                                                    <input type="hidden" name="tanggal" value="<?= $row[
                                                        "tanggal"
                                                    ] ?>">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <input type="submit" value="simpan" name="simpan" class="btn btn-primary">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modalHapus<?= $row[
                                    "id"
                                ] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Hapus Gallery</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="formGroupExampleInput" class="form-label">Yakin akan menghapus data ini?</label>
                                                        <input type="hidden" name="id" value="<?= $row[
                                                            "id"
                                                        ] ?>">
                                                        <input type="hidden" name="gambar" value="<?= $row[
                                                            "gambar"
                                                        ] ?>">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">batal</button>
                                                    <input type="submit" value="hapus" name="hapus" class="btn btn-primary">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                </td>
                        </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Gallery</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="formGroupExampleInput2" class="form-label">Gambar</label>
                                <input type="file" class="form-control" name="gambar" required>
                            </div>
                            <div class="mb-3">
                                <label for="floatingTextarea2">Deskripsi</label>
                                <textarea class="form-control" placeholder="Tuliskan Deskripsi Foto" name="deskripsi" required></textarea>
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
</div>

<?php
include "upload_foto.php";

if (isset($_POST["simpan"])) {
    $deskripsi = $_POST["deskripsi"];
    $tanggal = date("Y-m-d H:i:s");
    $gambar = "";
    $nama_gambar = $_FILES["gambar"]["name"];

    if ($nama_gambar != "") {
        $cek_upload = upload_foto($_FILES["gambar"]);
        if ($cek_upload["status"]) {
            $gambar = $cek_upload["message"];
        } else {
            echo "<script>
                alert('" .
                $cek_upload["message"] .
                "');
                document.location='admin.php?page=gallery';
            </script>";
            die();
        }
    }

    if (isset($_POST["id"])) {
        $id = $_POST["id"];
        if ($nama_gambar == "") {
            $gambar = $_POST["gambar_lama"];
        } else {
            unlink("img/" . $_POST["gambar_lama"]);
        }

        $stmt = $conn->prepare(
            "UPDATE gallery SET gambar = ?, deskripsi = ?, tanggal = ? WHERE id = ?",
        );
        $stmt->bind_param("sssi", $gambar, $deskripsi, $tanggal, $id);
        $simpan = $stmt->execute();
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO gallery (gambar, deskripsi, tanggal) VALUES (?, ?, ?)",
        );
        $stmt->bind_param("sss", $gambar, $deskripsi, $tanggal);
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

if (isset($_POST["hapus"])) {
    $id = $_POST["id"];
    $gambar = $_POST["gambar"];

    if ($gambar != "") {
        unlink("img/" . $gambar);
    }

    $stmt = $conn->prepare("DELETE FROM gallery WHERE id =?");
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
