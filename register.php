<?php
session_start();

include "koneksi.php";
include "upload_foto.php";


if (isset($_SESSION['username'])) {
  //menuju ke halaman admin
  header("location:admin.php");
} else {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    $stmt = $conn->prepare("INSERT INTO users VALUES (null, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssss", $username, $nama, $email, $password, $lokasi_avatar);
    $stmt->execute();

    $stmt->get_result();

    if ($stmt->affected_rows > 0) {
        $_SESSION['username'] = $username;

        header('location: admin.php');
    } else {
        header('location: register.php');
    }

    $stmt->close();
    $conn->close();
  } else {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <title>Login | My Daily Journal</title>
      <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
      <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
      <link rel="icon" href="img/logo.png" />
    </head>

    <body class="bg-danger-subtle">
      <div class="container mt-5 pt-5">
        <div class="row">
          <div class="col-12 col-sm-8 col-md-6 m-auto">
            <div class="card border-0 shadow rounded-5">
              <div class="card-body">
                <div class="text-center mb-3">
                  <i class="bi bi-person-circle h1 display-4"></i>
                  <p>My Daily Journal</p>
                  <hr />
                </div>
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

                  <div class="text-center my-3 d-grid">
                    <button class="btn btn-danger rounded-4">
                        Register
                    </button>
                  </div>
                  <a href="./login.php">Sudah punya akun?</a>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    </body>

    </html>
<?php
  }
}
?>
