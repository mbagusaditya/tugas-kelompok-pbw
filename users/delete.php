<?php
include_once "./../koneksi.php";
session_start();

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if ($_POST['METHOD'] === "DELETE") {
            $id = $_POST['id'];

            $stmt = $conn->prepare('DELETE FROM users WHERE id = ?');

            $stmt->bind_param("d", $id);

            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $_SESSION['flash_message'] = 'User berhasil dihapus';
            } else {
                $_SESSION['flash_message'] = 'User gagal dihapus';
            }
        }
    }

    header('location: /admin.php?page=users');
?>
