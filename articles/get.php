<?php
// Menginclude file koneksi database
include __DIR__ . "/../koneksi.php";

// Menentukan jumlah data per halaman
$limit = 2;

// Mengambil nomor halaman dari URL, jika tidak ada set ke halaman 1
$page = isset($_GET['p']) ? (int)$_GET['p'] : 1;

// Menghitung offset/starting point untuk query LIMIT
$mulai = ($page > 1) ? ($page * $limit) - $limit : 0;

// Mengambil total semua record article untuk menghitung jumlah halaman
$result = $conn->query("SELECT * FROM article");

// Menghitung total jumlah record
$total_records = $result->num_rows;

// Menghitung total jumlah halaman (pembulatan ke atas)
$pages = ceil($total_records / $limit);

// Query untuk mengambil data article dengan pagination, diurutkan dari tanggal terbaru
$sql = "SELECT * FROM article ORDER BY tanggal DESC LIMIT $mulai, $limit";

// Menjalankan query
$hasil = $conn->query($sql);

// Inisialisasi nomor urut data dimulai dari offset + 1
$no = $mulai + 1;
?>

<!-- Tabel untuk menampilkan data article -->
<table class="table table-hover">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th class="w-25">Judul</th>
            <th class="w-75">Isi</th>
            <th class="w-25">Gambar</th>
            <th class="w-25">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Looping data article yang diambil dari database
        while ($row = $hasil->fetch_assoc()) {
        ?>
            <tr>
                <!-- Menampilkan nomor urut -->
                <td><?= $no++ ?></td>

                <!-- Menampilkan judul, tanggal, dan username pembuat -->
                <td>
                    <strong><?= $row["judul"] ?></strong>
                    <br>Dibuat tanggal : <?= $row["tanggal"] ?>
                    <br>Dibuat oleh : <?= $row["username"] ?>
                </td>

                <!-- Menampilkan isi artikel -->
                <td><?= $row["isi"] ?></td>

                <!-- Menampilkan gambar artikel jika ada -->
                <td>
                    <?php
                    // Cek apakah ada gambar
                    if ($row["gambar"] != '') {
                        // Cek apakah file gambar ada di folder img
                        if (file_exists('../img/' . $row["gambar"] . '')) {
                    ?>
                            <!-- Tampilkan gambar dengan lebar 100px -->
                            <img src="/img/<?= $row["gambar"] ?>" width="100">
                    <?php
                        }
                    }
                    ?>
                </td>

                <!-- Kolom aksi untuk edit dan delete -->
                <td>
                    <!-- Tombol edit yang membuka modal edit -->
                    <a href="#" title="edit" class="badge rounded-pill text-bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row["id"] ?>"><i class="bi bi-pencil"></i></a>

                    <!-- Tombol delete yang membuka modal konfirmasi hapus -->
                    <a href="#" title="delete" class="badge rounded-pill text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row["id"] ?>"><i class="bi bi-x-circle"></i></a>

                    <!-- Awal Modal Edit -->
                    <div class="modal fade" id="modalEdit<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Article</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <!-- Form edit yang submit ke articles/edit.php -->
                                <form method="post" action="articles/edit.php" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <!-- Input judul artikel -->
                                        <div class="mb-3">
                                            <label for="formGroupExampleInput" class="form-label">Judul</label>
                                            <!-- Hidden input untuk menyimpan ID article -->
                                            <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                            <!-- Input judul dengan value dari database -->
                                            <input type="text" class="form-control" name="judul" placeholder="Tuliskan Judul Artikel" value="<?= $row["judul"] ?>" required>
                                        </div>
                                        <!-- Textarea isi artikel -->
                                        <div class="mb-3">
                                            <label for="floatingTextarea2">Isi</label>
                                            <!-- Textarea dengan value dari database -->
                                            <textarea class="form-control" placeholder="Tuliskan Isi Artikel" name="isi" required><?= $row["isi"] ?></textarea>
                                        </div>
                                        <!-- Input file untuk ganti gambar (optional) -->
                                        <div class="mb-3">
                                            <label for="formGroupExampleInput2" class="form-label">Ganti Gambar</label>
                                            <input type="file" class="form-control" name="gambar">
                                        </div>
                                        <!-- Menampilkan gambar lama -->
                                        <div class="mb-3">
                                            <label for="formGroupExampleInput3" class="form-label">Gambar Lama</label>
                                            <?php
                                            // Cek apakah ada gambar lama
                                            if ($row["gambar"] != '') {
                                                // Cek apakah file gambar ada
                                                if (file_exists('img/' . $row["gambar"] . '')) {
                                            ?>
                                                    <!-- Tampilkan gambar lama -->
                                                    <br><img src="img/<?= $row["gambar"] ?>" width="100">
                                            <?php
                                                }
                                            }
                                            ?>
                                            <!-- Hidden input untuk menyimpan nama gambar lama -->
                                            <input type="hidden" name="gambar_lama" value="<?= $row["gambar"] ?>">
                                        </div>
                                    </div>
                                    <!-- Footer modal dengan tombol close dan simpan -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <input type="submit" value="simpan" name="simpan" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Akhir Modal Edit -->

                    <!-- Awal Modal Hapus -->
                    <div class="modal fade" id="modalHapus<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Hapus Article</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <!-- Form hapus yang submit ke articles/delete.php -->
                                <form method="post" action="articles/delete.php" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <!-- Label konfirmasi hapus dengan judul artikel -->
                                            <label for="formGroupExampleInput" class="form-label">Yakin akan menghapus artikel "<strong><?= $row["judul"] ?></strong>"?</label>
                                            <!-- Hidden input untuk menyimpan ID yang akan dihapus -->
                                            <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                            <!-- Hidden input untuk menyimpan nama gambar yang akan dihapus -->
                                            <input type="hidden" name="gambar" value="<?= $row["gambar"] ?>">
                                        </div>
                                    </div>
                                    <!-- Footer modal dengan tombol batal dan hapus -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">batal</button>
                                        <input type="submit" value="hapus" name="hapus" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Akhir Modal Hapus -->
                </td>
            </tr>
        <?php
        // Akhir looping data
        }
        ?>
    </tbody>
</table>

<!-- Navigasi pagination -->
<nav class="mb-2">
    <ul class="pagination justify-content-end">
        <!-- Tombol First untuk ke halaman pertama -->
        <li class="page-item">
            <a class="page-link" href="#" onclick="load_data(1); return false;">First</a>
        </li>
        <?php
        // Menghitung halaman sebelumnya
        $prev = $page - 1;
        // Jika kurang dari 1, set ke 1
        if($prev < 1) $prev = 1;
        ?>
        <!-- Tombol Previous untuk ke halaman sebelumnya -->
        <li class="page-item">
            <a class="page-link" href="#" onclick="load_data(<?= $prev ?>); return false;">Previous</a>
        </li>
        <?php
        // Looping untuk menampilkan nomor halaman
        for ($i = 1; $i <= $pages; $i++) {
        ?>
            <!-- Link nomor halaman, tambah class active jika halaman aktif -->
            <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                <a class="page-link" href="#" onclick="load_data(<?= $i ?>); return false;"><?= $i ?></a>
            </li>
        <?php
        }
        ?>
        <?php
        // Menghitung halaman selanjutnya
        $next = $page + 1;
        // Jika lebih dari total halaman, set ke halaman terakhir
        if($next > $pages) $next = $pages;
        ?>
        <!-- Tombol Next untuk ke halaman selanjutnya -->
        <li class="page-item">
            <a class="page-link" href="#" onclick="load_data(<?= $next ?>); return false;">Next</a>
        </li>
        <!-- Tombol Last untuk ke halaman terakhir -->
        <li class="page-item">
            <a class="page-link" href="#" onclick="load_data(<?= $pages ?>); return false;">Last</a>
        </li>
    </ul>
</nav>
