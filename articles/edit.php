<?php
// Memulai session untuk mengakses data user yang sedang login
session_start();

// Menginclude file koneksi database
include __DIR__ . "/../koneksi.php";

// Menginclude file fungsi upload foto
include __DIR__ . "/../upload_foto.php";

// Mengecek apakah tombol simpan diklik
if (isset($_POST['simpan'])) {
    // Mengambil ID article yang akan diedit dari form
    $id = $_POST['id'];
    
    // Mengambil data judul baru dari form
    $judul = $_POST['judul'];
    
    // Mengambil data isi artikel baru dari form
    $isi = $_POST['isi'];
    
    // Membuat tanggal update saat ini dengan format Y-m-d H:i:s
    $tanggal = date("Y-m-d H:i:s");
    
    // Mengambil username dari session user yang sedang login
    $username = $_SESSION['username'];
    
    // Mengambil nama file gambar baru yang diupload (jika ada)
    $nama_gambar = $_FILES['gambar']['name'];

    // Mengecek apakah user mengganti gambar atau tidak
    if ($nama_gambar == '') {
        // Jika tidak upload gambar baru, gunakan gambar lama
        $gambar = $_POST['gambar_lama'];
    } else {
        // Jika upload gambar baru, hapus gambar lama terlebih dahulu
        if ($_POST['gambar_lama'] != '') {
            // Menghapus file gambar lama dari folder img
            unlink(__DIR__ . "/../img/" . $_POST['gambar_lama']);
        }

        // Memanggil fungsi upload_foto untuk memproses upload gambar baru
        $cek_upload = upload_foto($_FILES["gambar"]);

        // Mengecek apakah upload berhasil
        if ($cek_upload['status']) {
            // Menyimpan nama file gambar baru yang berhasil diupload
            $gambar = $cek_upload['message'];
        } else {
            // Jika upload gagal, tampilkan pesan error dan redirect
            echo "<script>
                alert('" . $cek_upload['message'] . "');
                document.location='../admin.php?page=article';
            </script>";
            // Menghentikan eksekusi script
            die;
        }
    }

    // Menyiapkan query update dengan prepared statement untuk keamanan
    $stmt = $conn->prepare("UPDATE article
                            SET
                            judul =?,
                            isi =?,
                            gambar = ?,
                            tanggal = ?,
                            username = ?
                            WHERE id = ?");

    // Binding parameter ke query (s = string, i = integer)
    $stmt->bind_param("sssssi", $judul, $isi, $gambar, $tanggal, $username, $id);
    
    // Menjalankan query update
    $simpan = $stmt->execute();

    // Mengecek apakah update data berhasil
    if ($simpan) {
        // Jika berhasil, tampilkan pesan sukses dan redirect
        echo "<script>
            alert('Update data sukses');
            document.location='../admin.php?page=article';
        </script>";
    } else {
        // Jika gagal, tampilkan pesan gagal dan redirect
        echo "<script>
            alert('Update data gagal');
            document.location='../admin.php?page=article';
        </script>";
    }

    // Menutup statement
    $stmt->close();
    
    // Menutup koneksi database
    $conn->close();
}
?>
