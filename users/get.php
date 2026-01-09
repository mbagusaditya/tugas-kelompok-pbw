<?php
require_once __DIR__ . "/../koneksi.php";

$page = $_GET['page'] ?? 1;
$limit = 2;
$offset = $limit * ($page - 1);

$stmt = $conn->prepare('SELECT * FROM users WHERE username <> "admin" ORDER BY username ASC LIMIT ? OFFSET ?');

$stmt->bind_param('ii', $limit, $offset);

$stmt->execute();

// $data = [];
$result = $stmt->get_result();
$no = ($page - 1) * $limit + 1;

while ($nextData = $result->fetch_assoc()) {
    // $data[] = $nextData;
    $id = $nextData['id'];
    $avatar = '/img/'. ((isset($nextData['avatar']) && $nextData['avatar'] !== '') ? $nextData['avatar'] : 'user.png');
    $username = $nextData['username'];
    $nama = $nextData['nama'];
    $email = $nextData['email'];
    // $password = $nextData['password'];

    echo "<tr>
        <td>$no</td>
        <td>
            <img class=\"w-full\" style=\"width: 100px; height: 100px; border-radius: 9999px; object-fit: cover: object-position: center;\" src=\"$avatar\" />
        </td>
        <td>$username</td>
        <td>$nama</td>
        <td>$email</td>
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
    $no++;
}
