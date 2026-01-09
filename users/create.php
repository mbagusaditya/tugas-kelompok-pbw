<?php
include_once __DIR__ .  "./../koneksi.php";
include_once __DIR__ . "./../upload_foto.php";
session_start();

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $username = $_POST['username'];
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $avatar = $_FILES['avatar'];
        $lokasi_avatar = "";

        if ($avatar['name'] != '') {
            $cek_upload = upload_foto($_FILES["avatar"]);

            if ($cek_upload['status']) {
                $lokasi_avatar = $cek_upload['message'];
            } else {
                echo "<script>
                    alert('" . $cek_upload['message'] . "');
                    document.location='../admin.php?page=article';
                </script>";
                die;
            }
        }

        if (in_array('', [$nama, $username, $password, $email])) {
            $_SESSION['flash_message'] = 'User baru gagal dibuat';
            header('location: admin.php?page=users/create');
            die;
        }

        $stmt = $conn->prepare('INSERT INTO users VALUES (null, ?, ?, ?, ?, ?)');

        $stmt->bind_param('sssss', $username, $nama, $email, $password, $lokasi_avatar);

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['flash_message'] = 'User baru berhasil dibuat';
            header('location: admin.php?page=users');
            die;
        }

        $_SESSION['flash_message'] = 'User baru gagal dibuat';
        header('location: admin.php?page=users/create');
    }
?>

<div class="card">
<div class="card-body">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" id="username" />
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" name="nama" id="nama" />
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email" />
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" />
        </div>

        <div class="mb-3">
            <label for="avatar" class="form-label">Avatar</label>
            <input type="file" class="form-control" name="avatar" id="avatar" />
        </div>

        <div class="d-flex justify-content-end">
            <button class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
</div>

<?php
    if (isset($_SESSION['flash_message'])) :
?>

<script>
alert('<?= $_SESSION['flash_message'] ?>')
</script>

<?php
unset($_SESSION['flash_message']);
endif;
?>
