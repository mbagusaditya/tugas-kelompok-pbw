<?php
// Menginclude file koneksi database
include __DIR__ . "/../koneksi.php";

// Mengecek apakah tombol hapus diklik
if (isset($_POST['hapus'])) {
    // Mengambil ID article yang akan dihapus dari form
    $id = $_POST['id'];
    
    // Mengambil nama file gambar yang akan dihapus dari form
    $gambar = $_POST['gambar'];

    // Mengecek apakah article memiliki gambar
    if ($gambar != '') {
        // Mengecek apakah file gambar ada di folder img
        if (file_exists(__DIR__ . "/../img/" . $gambar)) {
            // Menghapus file gambar dari folder img
            unlink(__DIR__ . "/../img/" . $gambar);
        }
    }

    // Menyiapkan query delete dengan prepared statement untuk keamanan
    $stmt = $conn->prepare("DELETE FROM article WHERE id =?");

    // Binding parameter ke query (i = integer)
    $stmt->bind_param("i", $id);
    
    // Menjalankan query delete
    $hapus = $stmt->execute();

    // Mengecek apakah delete data berhasil
    if ($hapus) {
        // Jika berhasil, tampilkan pesan sukses dan redirect
        echo "<script>
            alert('Hapus data sukses');
            document.location='../admin.php?page=article';
        </script>";
    } else {
        // Jika gagal, tampilkan pesan gagal dan redirect
        echo "<script>
            alert('Hapus data gagal');
            document.location='../admin.php?page=article';
        </script>";
    }

    // Menutup statement
    $stmt->close();
    
    // Menutup koneksi database
    $conn->close();
}
?>
