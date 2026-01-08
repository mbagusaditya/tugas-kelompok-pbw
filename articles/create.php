<?php
// Memulai session untuk mengakses data user yang sedang login
session_start();

// Menginclude file koneksi database
include __DIR__ . "/../koneksi.php";

// Menginclude file fungsi upload foto
include __DIR__ . "/../upload_foto.php";

// Mengecek apakah tombol simpan diklik
if (isset($_POST['simpan'])) {
    // Mengambil data judul dari form
    $judul = $_POST['judul'];
    
    // Mengambil data isi artikel dari form
    $isi = $_POST['isi'];
    
    // Membuat tanggal saat ini dengan format Y-m-d H:i:s
    $tanggal = date("Y-m-d H:i:s");
    
    // Mengambil username dari session user yang sedang login
    $username = $_SESSION['username'];
    
    // Inisialisasi variabel gambar dengan string kosong
    $gambar = '';
    
    // Mengambil nama file gambar yang diupload
    $nama_gambar = $_FILES['gambar']['name'];

    // Proses upload gambar jika ada file yang diupload
    if ($nama_gambar != '') {
        // Memanggil fungsi upload_foto untuk memproses upload
        $cek_upload = upload_foto($_FILES["gambar"]);

        // Mengecek apakah upload berhasil
        if ($cek_upload['status']) {
            // Menyimpan nama file gambar yang berhasil diupload
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

    // Menyiapkan query insert dengan prepared statement untuk keamanan
    $stmt = $conn->prepare("INSERT INTO article (judul,isi,gambar,tanggal,username)
                            VALUES (?,?,?,?,?)");

    // Binding parameter ke query (s = string)
    $stmt->bind_param("sssss", $judul, $isi, $gambar, $tanggal, $username);
    
    // Menjalankan query insert
    $simpan = $stmt->execute();

    // Mengecek apakah insert data berhasil
    if ($simpan) {
        // Jika berhasil, tampilkan pesan sukses dan redirect
        echo "<script>
            alert('Simpan data sukses');
            document.location='../admin.php?page=article';
        </script>";
    } else {
        // Jika gagal, tampilkan pesan gagal dan redirect
        echo "<script>
            alert('Simpan data gagal');
            document.location='../admin.php?page=article';
        </script>";
    }

    // Menutup statement
    $stmt->close();
    
    // Menutup koneksi database
    $conn->close();
}
?>
