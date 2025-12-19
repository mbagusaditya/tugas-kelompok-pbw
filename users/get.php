<?php
require_once __DIR__ . "/../koneksi.php";

$page = $_GET['page'] ?? 1;

$stmt = $conn->prepare('SELECT * FROM users LIMIT 10 OFFSET ?');

$stmt->bind_param('d', $page);

$stmt->execute();

// $data = [];
$result = $stmt->get_result();

while ($nextData = $result->fetch_assoc()) {
    // $data[] = $nextData;
    $no = ($page - 1) * 10 + 1;
    $id = $nextData['id'];
    $nama = $nextData['nama'];
    $password = $nextData['password'];

    echo "<tr>
        <td>$no</td>
        <td>$nama</td>
        <td>$password</td>
        <td>
            <div class=\"d-flex\">
            <a href=\"./admin.php?page=users/edit&id=$id\" class=\"btn btn-warning me-3\">Edit</a>

            <form action=\"./users/delete.php\" method=\"post\" onsubmit=\"return confirm('yakin?')\">
                <input type=\"hidden\" name=\"METHOD\" value=\"DELETE\">

                <input type=\"hidden\" name=\"id\" value=\"$id\">

                <button class=\"btn btn-danger\" type=\"submit\">Delete</button>
            </form>
            </div>
        </td>
    </tr>";
}
