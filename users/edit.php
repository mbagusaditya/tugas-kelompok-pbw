<?php
include_once __DIR__ .  "./../koneksi.php";
include_once __DIR__ . './../upload_foto.php';
session_start();

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if ($_POST['METHOD'] !== "PUT") {
            header('location: admin.php?page=users/edit');
            die;
        }

        $id = $_POST['id'];
        $username = $_POST['username'];
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $password = isset($_POST['password']) && $_POST['password'] != '' ? md5($_POST['password']) : '';
        $avatar = $_FILES['avatar'];
        $lokasi_avatar = '';

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

        $sql = 'UPDATE users SET username=?, nama=?, email=?';

        if ($password !== '') $sql .= ', password=?';
        if ($lokasi_avatar !== '') $sql .= ', avatar=?';

        $sql .= ' WHERE id=?';

        $stmt = $conn->prepare($sql);

        $query_params = [$username, $nama, $email];

        // if ($password !== '') $stmt->bind_param('s', $password);
        // if ($lokasi_avatar !== '') $stmt->bind_param('s', $lokasi_avatar);
        if ($password !== '') $query_params[] = $password;
        if ($lokasi_avatar !== '') $query_params[] = $lokasi_avatar;

        $query_params[] = $id;

        // $stmt->bind_param('i', $id);

        $stmt->execute($query_params);

        if ($stmt->affected_rows > 0) {
            $_SESSION['flash_message'] = 'User berhasil diubah';
            header('location: admin.php?page=users');
            die;
        }

        $_SESSION['flash_message'] = 'User gagal diubah';
        header('location: admin.php?page=users/edit');
    }

    $id = $_GET['id'];
    $user = [];

    $stmt = $conn->prepare('SELECT id, username, nama, email FROM users WHERE id = ?');

    $stmt->bind_param('d', $id);

    $stmt->execute();

    $hasil = $stmt->get_result();

    $user = $hasil->fetch_assoc();
?>

<div class="card">
<div class="card-body">
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="METHOD" value="PUT">

        <input type="hidden" name="id" value="<?= $user['id'] ?>">

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" id="username" value="<?= $user['username'] ?>" />
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" name="nama" id="nama" value="<?= $user['nama'] ?>" />
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email" value="<?= $user['email'] ?>" />
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
