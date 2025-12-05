<?php
include_once "./../koneksi.php";

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        $stmt = $conn->prepare('INSERT INTO users VALUES (null, ?, ?)');

        $stmt->bind_param('ss', $username, $password);

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header('location: admin.php?page=users');
            die;
        }

        header('location: admin.php?page=users/create');
    }
?>

<div class="card">
<div class="card-body">
    <form action="" method="post">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" id="username" />
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
