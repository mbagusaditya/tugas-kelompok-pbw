<?php
include_once "./../koneksi.php";

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if ($_POST['METHOD'] !== "PUT") {
            header('location: admin.php?page=users/edit');
            die;
        }

        $id = $_POST['id'];
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        $stmt = $conn->prepare('UPDATE users SET username=?, password=? WHERE id=?');

        $stmt->bind_param('ssd', $username, $password, $id);

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header('location: admin.php?page=users');
            die;
        }

        header('location: admin.php?page=users/create');
    }

    $id = $_GET['id'];
    $user = [];

    $stmt = $conn->prepare('SELECT id, username FROM users WHERE id = ?');

    $stmt->bind_param('d', $id);

    $stmt->execute();

    $hasil = $stmt->get_result();

    $user = $hasil->fetch_assoc();
?>

<div class="card">
<div class="card-body">
    <form action="" method="post">
        <input type="hidden" name="METHOD" value="PUT">

        <input type="hidden" name="id" value="<?= $user['id'] ?>">

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" id="username" value="<?= $user['username'] ?>" />
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" />
        </div>

        <div class="d-flex justify-content-end">
            <button class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
</div>
