<?php
    require_once "koneksi.php";
?>

<div class="py-4">
    <a href="./admin.php?page=users/create" class="btn btn-primary mb-3">Tambah user</a>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Username</th>
      <th scope="col">Password</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
      <?php
        $stmt = $conn->prepare('SELECT * FROM users WHERE username <> "admin" ORDER BY username ASC');

      $stmt->execute();

      $hasil = $stmt->get_result();

      while ($data = $hasil->fetch_assoc()) :
      ?>
    <tr>
      <th scope="row">1</th>
      <td>
          <?= $data['username'] ?>
      </td>
      <td>
          <?=
             $data['password']
          ?>
      </td>
      <td>
          <div class="d-flex">
          <a href="./admin.php?page=users/edit&id=<?= $data['id'] ?>" class="btn btn-warning me-3">Edit</a>

          <form action="./users/delete.php" method="post" onsubmit="return confirm('yakin?')">
              <input type="hidden" name="METHOD" value="DELETE">

              <input type="hidden" name="id" value="<?= $data['id'] ?>">

              <button class="btn btn-danger" type="submit">Delete</button>
          </form>
          </div>
      </td>
    </tr>
    <?php
        endwhile;
    ?>
  </tbody>
</table>
</div>
