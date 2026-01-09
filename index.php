<?php
session_start();
include "koneksi.php";

$user = null;

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $stmt = $conn->prepare('SELECT * FROM users WHERE username = ? limit 1');
    $stmt->bind_param('s', $username);

    $stmt->execute();

    $result = $stmt->get_result();

    $user = $result->fetch_assoc();
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Daily Journal</title>
    <link rel="icon" href="img/logo.png" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
  </head>
  <body>
    <!-- nav begin -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top" id="navbar">
      <div class="container">
        <a class="navbar-brand" href="#">My Daily Journal</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-dark">
            <li class="nav-item">
              <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#article">Article</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#gallery">Gallery</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#schedule">Schedule</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#aboutme">About Me</a>
            </li>
            <?php if (isset($_SESSION["username"])): ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?= $_SESSION["username"] ?>
                </a>
                <ul class="dropdown-menu">
                    <?php if ($_SESSION["username"] === "admin"): ?>
                        <li><a class="dropdown-item" href="admin.php">Dashboard</a></li>
                    <?php endif; ?>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </li>
            <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
            </li>
            <?php endif; ?>

            <div class="d-flex flex-column flex-sm-row ms-0 ms-lg-2 justify-content-stretch gap-3">
                <button
                type="button"
                class="btn btn-dark theme "
                id="dark"
                title="dark"
                style="flex-grow: 1;"
                >
                <i class="bi bi-moon-stars-fill"></i>
                </button>

                <button
                type="button"
                class="btn btn-danger theme"
                id="light"
                title="light"
                style="flex-grow: 1;"
                >
                <i class="bi bi-brightness-high"></i>
                </button>
            </div>
          </ul>
        </div>
      </div>
    </nav>
    <!-- nav end -->
    <!-- hero begin -->
    <section id="hero" class="text-center p-5 bg-danger-subtle text-sm-start">
      <div class="container">
          <div class="row">
            <div class="col-lg-8">
            <div>
                <h1 class="fw-bold display-4">
                Create Memories, Save Memories, Everyday
                </h1>
                <h4 class="lead display-6">
                Mencatat semua kegiatan sehari-hari yang ada tanpa terkecuali
                </h4>
                <h6>
                <span id="tanggal"></span>
                <span id="jam"></span>
                </h6>
            </div>
            </div>

            <div class="col-lg-4 justify-content-center justify-content-lg-end d-flex align-items-center">
                <img src="img/banner.png" class="img-fluid" width="300" />
            </div>
        </div>
      </div>
    </section>
    <!-- hero end -->
    <!-- article begin -->
    <section id="article" class="text-center p-5">
      <div class="container">
        <h1 class="fw-bold display-4 pb-3">Article</h1>
        <div class="row overflow-x-hidden g-4" style="padding-bottom: 20px;">
          <?php
          $sql = "SELECT * FROM article ORDER BY tanggal DESC";
          $hasil = $conn->query($sql);

          $no = 1;
          while ($row = $hasil->fetch_assoc()) { ?>
            <div class="col-8 col-md-4 flex-shrink-0 article-item">
              <div class="card h-100">
                <img src="img/<?= $row[
                    "gambar"
                ] ?>" class="card-img-top" alt="..." />
                <div class="card-body">
                  <h5 class="card-title"><?= $row["judul"] ?></h5>
                  <p class="card-text">
                    <?= mb_strimwidth(strip_tags($row["isi"]), 0, 200, "...") ?>
                  </p>
                </div>
                <div class="card-footer">
                  <small class="text-body-secondary">
                    <?= $row["tanggal"] ?>
                  </small>
                </div>
                <div class="card-footer">
                   <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#articleModal<?= $row[
                       "id"
                   ] ?>">
                      Detail
                    </button>
                </div>
              </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="articleModal<?= $row[
                "id"
            ] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content text-black">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"><?= $row[
                        "judul"
                    ] ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <img src="img/<?= $row[
                        "gambar"
                    ] ?>" class="img-fluid mb-3" alt="...">
                    <p><?= $row["isi"] ?></p>
                    <small class="text-muted">Posted on <?= $row[
                        "tanggal"
                    ] ?></small>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
            <?php }
          ?>
        </div>
        <div class="text-center mt-3">
          <button class="btn btn-sm btn-danger d-none" id="showLessBtn">Tampilkan Sedikit</button>
          <button class="btn btn-sm btn-success d-none" id="showMoreBtn">Tampilkan Banyak</button>
        </div>

        <script>
            const visibleStep = 3;
            let visibleCount = 3; // Initial visible count
            const articles = document.querySelectorAll('.article-item');
            const showMoreBtn = document.getElementById('showMoreBtn');
            const showLessBtn = document.getElementById('showLessBtn');

            function updateVisibility() {
                articles.forEach((article, index) => {
                    if (index < visibleCount) {
                        article.classList.remove('d-none');
                    } else {
                        article.classList.add('d-none');
                    }
                });

                // Update Show More Button Visibility
                if (visibleCount >= articles.length) {
                    showMoreBtn.classList.add('d-none');
                } else {
                    showMoreBtn.classList.remove('d-none');
                }

                // Update Show Less Button Visibility
                if (visibleCount > visibleStep) {
                    showLessBtn.classList.remove('d-none');
                } else {
                    showLessBtn.classList.add('d-none');
                }
            }

            if (showMoreBtn) {
              showMoreBtn.addEventListener('click', () => {
                  visibleCount += visibleStep;
                  updateVisibility();
              });
            }

            if (showLessBtn) {
              showLessBtn.addEventListener('click', () => {
                  visibleCount -= visibleStep;
                  // Ensure we don't go below the step
                  if (visibleCount < visibleStep) visibleCount = visibleStep;
                  updateVisibility();
              });
            }

            // Initial call
            updateVisibility();
        </script>
      </div>
    </section>
    <!-- article end -->
    <!-- gallery begin -->
    <section id="gallery" class="text-center p-5 bg-danger-subtle">
      <div class="container">
        <h1 class="fw-bold display-4 pb-3">Gallery</h1>
        <style>
            .masonry-grid {
                column-count: 1;
                column-gap: 1rem;
            }
            @media (min-width: 576px) { .masonry-grid { column-count: 2; } }
            @media (min-width: 768px) { .masonry-grid { column-count: 3; } }
            @media (min-width: 992px) { .masonry-grid { column-count: 4; } }

            .masonry-item {
                break-inside: avoid;
                margin-bottom: 1rem;
            }
        </style>
        <div class="masonry-grid">
            <?php
            $sql = "SELECT * FROM gallery ORDER BY tanggal DESC";
            $hasil = $conn->query($sql);
            while ($row = $hasil->fetch_assoc()) { ?>
              <div class="masonry-item card">
                <img src="img/<?= $row[
                    "gambar"
                ] ?>" class="card-img-top" alt="Gallery Image" />
                <div class="card-body">
                  <p class="card-text small text-body-secondary"><?= $row[
                      "tanggal"
                  ] ?></p>
                </div>
              </div>
            <?php }
            ?>
        </div>
      </div>
    </section>
    <!-- gallery end -->
    <!-- schedule begin -->
    <section id="schedule" class="text-center p-5">
      <div class="container">
        <h1 class="fw-bold display-4 pb-3">Schedule</h1>
        <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center">
          <div class="col">
            <div class="card h-100">
              <div class="card-header bg-danger text-white">SENIN</div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  Etika Profesi<br />16.20-18.00 | H.4.4
                </li>
                <li class="list-group-item">
                  Sistem Operasi<br />18.30-21.00 | H.4.8
                </li>
              </ul>
            </div>
          </div>
          <div class="col">
            <div class="card h-100">
              <div class="card-header bg-danger text-white">SELASA</div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  Pendidikan Kewarganegaraan<br />12.30-13.10 | Kulino
                </li>
                <li class="list-group-item">
                  Probabilitas dan Statistik<br />15.30-18.00 | H.4.9
                </li>
                <li class="list-group-item">
                  Kecerdasan Buatan<br />18.30-21.00 | H.4.11
                </li>
              </ul>
            </div>
          </div>
          <div class="col">
            <div class="card h-100">
              <div class="card-header bg-danger text-white">RABU</div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  Manajemen Proyek Teknologi Informasi<br />15.30-18.00 | H.4.6
                </li>
              </ul>
            </div>
          </div>
          <div class="col">
            <div class="card h-100">
              <div class="card-header bg-danger text-white">KAMIS</div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  Bahasa Indonesia<br />12.30-14.10 | Kulino
                </li>
                <li class="list-group-item">
                  Pendidikan Agama Islam<br />16.20-18.00 | Kulino
                </li>
                <li class="list-group-item">
                  Penambangan Data<br />18.30-21.00 | H.4.9
                </li>
              </ul>
            </div>
          </div>
          <div class="col">
            <div class="card h-100">
              <div class="card-header bg-danger text-white">JUMAT</div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  Pemrograman Web Lanjut<br />10.20-12.00 | D.2.K
                </li>
              </ul>
            </div>
          </div>
          <div class="col">
            <div class="card h-100">
              <div class="card-header bg-danger text-white">SABTU</div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">FREE</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- schedule end -->
    <?php
    if (isset($_SESSION['username'])):
    ?>

    <?php
        $avatar = $user['avatar'] !== "" ? '/img/' . $user['avatar'] : '/img/user.png';
    ?>
    <!-- about me begin -->
    <section id="aboutme" class="text-center p-5 bg-danger-subtle">
      <div class="container">
        <div class="d-sm-flex align-items-center justify-content-center">
          <div class="p-3 d-flex " style="max-width: 300px; width: 100%;">
            <img
              src="<?= $avatar ?>"
              class="rounded-circle border shadow"
              style="width: 100%; aspect-ratio: 1/1; object-fit: cover; object-position: center;"
            />
          </div>
          <div class="p-md-5 text-sm-start">
            <h3 class="lead">Pemrograman Berbasis Web</h3>
            <h1 class="fw-bold">
                <?= $user['nama'] ?>
            </h1>
            Fakultas Ilmu Komputer<br />
            <a
              href="https://dinus.ac.id/"
              class="fw-bold text-decoration-none"
              >Universitas Dian Nuswantoro</a
            >
          </div>
        </div>
      </div>
    </section>
    <?php
        endif;
    ?>
    <!-- about me end -->
    <!-- footer begin -->
    <footer id="footer" class="text-center p-5">
      <div>
        <a href="https://www.instagram.com/udinusofficial"
          ><i class="bi bi-instagram h2 p-2"></i
        ></a>
        <a href="https://twitter.com/udinusofficial"
          ><i class="bi bi-twitter h2 p-2"></i
        ></a>
        <a href="https://wa.me/+62812685577"
          ><i class="bi bi-whatsapp h2 p-2"></i
        ></a>
      </div>
      <div>Kelompok 8 &copy; 2025</div>
    </footer>
    <!-- footer end -->

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
    <script type="text/javascript">
      window.setTimeout("tampilWaktu()", 1000);

      function tampilWaktu() {
        var waktu = new Date();
        var bulan = waktu.getMonth() + 1;

        setTimeout("tampilWaktu()", 1000);
        document.getElementById("tanggal").innerHTML =
          waktu.getDate() + "/" + bulan + "/" + waktu.getFullYear();
        document.getElementById("jam").innerHTML =
          waktu.getHours() +
          ":" +
          waktu.getMinutes() +
          ":" +
          waktu.getSeconds();
      }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript">
      document.getElementById("dark").onclick = function () {
        document.body.style.backgroundColor = "#222"; // Dark Grey background

        const navbar = document.getElementById("navbar");
        navbar.classList.remove("bg-body-tertiary");
        navbar.classList.add("bg-dark", "navbar-dark");

        const hero = document.getElementById("hero");
        hero.classList.remove("bg-danger-subtle", "text-black");
        hero.classList.add("bg-dark", "text-white");

        const gallery = document.getElementById("gallery");
        gallery.classList.remove("bg-danger-subtle", "text-black");
        gallery.classList.add("bg-dark", "text-white");

        const aboutme = document.getElementById("aboutme");
        aboutme.classList.remove("bg-danger-subtle", "text-black");
        aboutme.classList.add("bg-dark", "text-white");

        document.getElementById("footer").classList.remove("text-black");
        document.getElementById("footer").classList.add("text-white");

        document.getElementById("article").classList.remove("text-black");
        document.getElementById("article").classList.add("text-white");

        document.getElementById("schedule").classList.remove("text-black");
        document.getElementById("schedule").classList.add("text-white");

        const collection = document.getElementsByClassName("card");
        for (let i = 0; i < collection.length; i++) {
          collection[i].classList.add("bg-dark", "text-white", "border-secondary");
          collection[i].classList.remove("bg-white", "text-dark"); // Ensure default card styles are removed if necessary
        }

        const collection2 = document.getElementsByClassName("list-group-item");
        for (let i = 0; i < collection2.length; i++) {
          collection2[i].classList.add("bg-dark", "text-white", "border-secondary");
        }
      };

      document.getElementById("light").onclick = function () {
        document.body.style.backgroundColor = "white";

        const navbar = document.getElementById("navbar");
        navbar.classList.remove("bg-dark", "navbar-dark");
        navbar.classList.add("bg-body-tertiary");

        const hero = document.getElementById("hero");
        hero.classList.remove("bg-dark", "text-white");
        hero.classList.add("bg-danger-subtle", "text-black");

        const gallery = document.getElementById("gallery");
        gallery.classList.remove("bg-dark", "text-white");
        gallery.classList.add("bg-danger-subtle", "text-black");

        const aboutme = document.getElementById("aboutme");
        aboutme.classList.remove("bg-dark", "text-white");
        aboutme.classList.add("bg-danger-subtle", "text-black");

        document.getElementById("footer").classList.remove("text-white");
        document.getElementById("footer").classList.add("text-black");

        document.getElementById("article").classList.remove("text-white");
        document.getElementById("article").classList.add("text-black");

        document.getElementById("schedule").classList.remove("text-white");
        document.getElementById("schedule").classList.add("text-black");

        const collection = document.getElementsByClassName("card");
        for (let i = 0; i < collection.length; i++) {
          collection[i].classList.remove("bg-dark", "text-white", "border-secondary");
          collection[i].classList.add("bg-white", "text-dark");
        }

        const collection2 = document.getElementsByClassName("list-group-item");
        for (let i = 0; i < collection2.length; i++) {
          collection2[i].classList.remove("bg-dark", "text-white", "border-secondary");
        }
      };
    </script>
  </body>
</html>
