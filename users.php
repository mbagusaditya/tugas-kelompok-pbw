<?php
    require_once "koneksi.php";
    session_start();
?>

<div class="py-4">
    <a href="./admin.php?page=users/create" class="btn btn-primary mb-3">Tambah user</a>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Avatar</th>
      <th scope="col">Username</th>
      <th scope="col">Nama</th>
      <th scope="col">Email</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody id="table-body">
      <?php
      $stmt = $conn->prepare('SELECT COUNT(id) total FROM users WHERE username <> "admin"');

      $stmt->execute();

      $hasil_count = $stmt->get_result()->fetch_assoc()['total'];

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

<nav aria-label="Page navigation example">
  <ul class="pagination" id="pagination" data-total="<?= $hasil_count / 2 ?>">
    <li class="page-item"><a class="page-link" id="prev-page" href="#">Previous</a></li>
    <?php
        for($i = 0; $i <= ($hasil_count - 1) / 2; $i++):
    ?>
    <li class="page-item">
        <a class="page-link" id="page-<?= $i + 1 ?>" data-page="<?= $i + 1 ?>" href="#">
            <?= $i + 1 ?>
        </a>
    </li>
    <?php
        endfor;
    ?>
    <li class="page-item"><a class="page-link" id="next-page" href="#">Next</a></li>
  </ul>
</nav>
</div>

<?php
    function scriptGetPaginate(){
?>

<script>
const tableBody = $('#table-body');
let currentPage = 1;
let totalPage = $('#pagination').data('total');

$(document).on('DOMContentLoaded', function() {
  $.get('http://localhost:5500/users/get.php?page=1', function(res) {
    tableBody.html(res)
    $('#page-1').addClass('active')
  })
})

  $('.page-link').on('click', function() {
    if ($(this).attr('id') === 'prev-page'){
      if (currentPage > 1) {
        currentPage -= 1;

        $.get('http://localhost:5500/users/get.php?page=' + currentPage, function(res) {
          tableBody.html(res)
          $('.page-link.active').removeClass('active')
          $('#page-' + currentPage).addClass('active')
        })
      }
    }
    else if ($(this).attr('id') === 'next-page'){
      if (currentPage < totalPage) {
        currentPage += 1;

        $.get('http://localhost:5500/users/get.php?page=' + currentPage, function(res) {
          tableBody.html(res)
          $('.page-link.active').removeClass('active')
          $('#page-' + currentPage).addClass('active')
        })
      }
    }
    else {
      let page = $(this).data('page')
      currentPage = page;

      $.get('http://localhost:5500/users/get.php?page=' + page, function(res) {
        tableBody.html(res)
        $('.page-link.active').removeClass('active')
        $('#page-' + page).addClass('active')
      })
    }
  })
</script>

<?php
    }
?>

<?php
    if (isset($_SESSION['flash_message'])) :
?>

<script>
alert('<?= $_SESSION["flash_message"] ?>')
</script>

<?php
unset($_SESSION['flash_message']);
endif;
?>
