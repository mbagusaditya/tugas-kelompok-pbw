<?php
include_once "./../koneksi.php";

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if ($_POST['METHOD'] === "DELETE") {
            $id = $_POST['id'];

            $stmt = $conn->prepare('DELETE FROM users WHERE id = ?');

            $stmt->bind_param("d", $id);

            $stmt->execute();

            if ($stmt->affected_rows > 0) {

            }
        }
    }

    header('location: /admin.php?page=users');
?>
