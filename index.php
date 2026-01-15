
<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daily Journal</title>
    <link rel="icon" href="img/logo.png" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
      crossorigin="anonymous"
    />

    <style>
      #gallery .carousel-item {
        height: 500px;
      }

      #gallery .carousel-item img {
        height: 100%;
        width: 100%;
        object-fit: cover;
        object-position: center;
      }

      @media (max-width: 768px) {
        #gallery .carousel-item {
          height: 300px;
        }
      }
    </style>
  </head>
  <body>
    <!-- nav begin -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top" id="navbar">
      <div class="container">
        <a class="navbar-brand" href="#">My Daily journal</a>
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
              <a class="nav-link" href="login.php" target="_blank">Login</a>
            </li>
          </ul>
          <div class="d-flex ms-3 gap-2">
            <button id="dark" class="btn btn-dark btn-sm">
              <i class="bi bi-moon-stars-fill"></i> Dark
            </button>
            <button id="light" class="btn btn-light btn-sm border">
              <i class="bi bi-sun-fill"></i> Light
            </button>
          </div>
        </div>
      </div>
    </nav>
    <!-- nav end -->
    <!-- hero begin -->
    <section id="hero" class="text-center p-5 bg-primary-subtle text-sm-start">
      <div class="container">
        <div class="d-sm-flex flex-sm-row-reverse align-items-center">
          <img src="img/banner.jpg" class="img-fluid" width="300" />
          <div>
            <h1 class="fw-bold display-4">
              Create Memories, Save Memories, Everyday
            </h1>
            <h4 class="lead display-6">
              Mencatat semua kegiatan sehari-hari yang ada tanpa terkecuali
            </h4>
            <span id="tanggal"></span>
            <span id="jam"></span>
          </div>
        </div>
      </div>
    </section>
    <!-- hero end -->
    <!-- article begin -->
    <section id="article" class="text-center p-5">
      <div class="container">
        <h1 class="fw-bold display-4 pb-3">article</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
        <?php
        $sql = "SELECT * FROM article ORDER BY tanggal DESC";
        $hasil = $conn->query($sql); 

        while ($row = $hasil->fetch_assoc()) { 
        ?>  
        <!-- col begin -->
          <div class="col">
            <div class="card h-100">
              <img
                src="img/<?= $row["gambar"]?>"
                class="card-img-top"
                alt="..."
              />
              <div class="card-body">
                <h5 class="card-title"><?= $row["judul"]?></h5>
                <p class="card-text">
                  <?= $row["isi"]?>
                </p>
              </div>
              <div class="card-footer">
                <small class="text-body-secondary"
                  ><?= $row["tanggal"]?></small
                >
              </div>
            </div>
          </div>
        <!-- col end -->
        <?php
        }
        ?>      
        </div>
      </div>
    </section>
    <!-- article end -->
    <!-- gallery begin -->
    <section id="gallery" class="text-center p-5 bg-primary-subtle">
      <div class="container">
        <h1 class="fw-bold display-4 pb-3">Gallery</h1>
        <div id="carouselExample" class="carousel slide">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="img/food6.jpg" class="d-block w-100" alt="..." />
            </div>
            <div class="carousel-item">
              <img src="img/food7.jpg" class="d-block w-100" alt="..." />
            </div>
            <div class="carousel-item">
              <img src="img/food8.jpg" class="d-block w-100" alt="..." />
            </div>
            <div class="carousel-item">
              <img src="img/food2.jpg" class="d-block w-100" alt="..." />
            </div>
            <div class="carousel-item">
              <img src="img/food1.jpg" class="d-block w-100" alt="..." />
            </div>
          </div>
          <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#carouselExample"
            data-bs-slide="prev"
          >
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#carouselExample"
            data-bs-slide="next"
          >
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
    </section>
    <!-- gallery end -->
    <!-- footer begin -->
    <footer class="text-center p-5">
      <div>
        <a href="https://www.instagram.com/">
          <i class="bi bi-instagram h2 p-2 text-dark"></i>
        </a>
      </div>
      <div>
        <a href="https://x.com/">
          <i class="bi bi-twitter-x h2 p-2 text-dark"></i>
        </a>
      </div>
      <div>
        <a href="https://www.whatsapp.com/?lang=id">
          <i class="bi bi-whatsapp h2 p-2 text-dark"></i>
        </a>
      </div>
      <div>M. Maheswara Syihab I &copy; 2025</div>
    </footer>
    <!-- footer end -->
    <!-- Tombol Back to Top -->
    <button
      id="backToTop"
      class="btn btn-danger rounded-circle position-fixed bottom-0 end-0 m-3 d-none"
    >
      <i class="bi bi-arrow-up" title="Back to Top"></i>
    </button>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
      crossorigin="anonymous"
    ></script>

    <!-- fungsi menampilkan waktu -->
    <script type="text/javascript">
      function tampilWaktu() {
        const waktu = new Date();

        const tanggal = waktu.getDate();
        const bulan = waktu.getMonth();
        const tahun = waktu.getFullYear();
        const jam = waktu.getHours();
        const menit = waktu.getMinutes();
        const detik = waktu.getSeconds();

        const arrBulan = [
          "1",
          "2",
          "3",
          "4",
          "5",
          "6",
          "7",
          "8",
          "9",
          "10",
          "11",
          "12",
        ];

        const tanggal_full = tanggal + "/" + arrBulan[bulan] + "/" + tahun;
        const jam_full = jam + ":" + menit + ":" + detik;

        document.getElementById("tanggal").innerHTML = tanggal_full;
        document.getElementById("jam").innerHTML = jam_full;
      }

      setInterval(tampilWaktu, 1000);
    </script>

    <!-- fungsi scroll ke atas -->
    <script type="text/javascript">
      const backToTop = document.getElementById("backToTop");

      window.addEventListener("scroll", function () {
        if (window.scrollY > 300) {
          backToTop.classList.remove("d-none");
          backToTop.classList.add("d-block");
        } else {
          backToTop.classList.remove("d-block");
          backToTop.classList.add("d-none");
        }
      });

      backToTop.addEventListener("click", function () {
        window.scrollTo({ top: 0, behavior: "smooth" });
      });
    </script>

    <!-- fungsi tombol dark & light -->
    <script type="text/javascript">
      // 1. Tangkap elemen
      const btnDark = document.getElementById("dark");
      const btnLight = document.getElementById("light");

      const body = document.body;
      const navbar = document.getElementById("navbar");
      const hero = document.getElementById("hero");
      const gallery = document.getElementById("gallery");
      const footerIcons = document.querySelectorAll("footer i");
      const cards = document.getElementsByClassName("card");

      // 2. Fungsi Tombol Dark
      btnDark.onclick = function () {
        // Body: Ubah ke hitam/gelap
        body.classList.add("bg-dark", "text-light");
        body.classList.remove("bg-light", "text-dark");

        // Navbar: Ubah ke gelap
        navbar.classList.remove("bg-body-tertiary", "navbar-light");
        navbar.classList.add("bg-dark", "navbar-dark");

        // Hero & Gallery: UBAH DARI BIRU MUDA JADI ABU-ABU (bg-secondary)
        // bg-secondary adalah kelas warna abu-abu di Bootstrap
        hero.classList.remove("bg-primary-subtle", "text-dark");
        hero.classList.add("bg-secondary", "text-white");

        gallery.classList.remove("bg-primary-subtle");
        gallery.classList.add("bg-secondary", "text-white");

        // Card: Ubah jadi gelap dengan border abu-abu agar terlihat rapi
        for (let i = 0; i < cards.length; i++) {
          cards[i].classList.add("bg-secondary", "text-white");
        }

        // Footer Icon: Ubah jadi putih
        for (let i = 0; i < footerIcons.length; i++) {
          footerIcons[i].classList.remove("text-dark");
          footerIcons[i].classList.add("text-white");
        }
      };

      // 3. Fungsi Tombol Light
      btnLight.onclick = function () {
        // Body: Balik ke terang
        body.classList.remove("bg-dark", "text-light");
        body.classList.add("bg-light", "text-dark");

        // Navbar: Balik ke terang
        navbar.classList.remove("bg-dark", "navbar-dark");
        navbar.classList.add("bg-body-tertiary", "navbar-light");

        // Hero & Gallery: BALIK DARI ABU-ABU JADI BIRU MUDA LAGI
        hero.classList.remove("bg-secondary", "text-white");
        hero.classList.add("bg-primary-subtle", "text-dark");

        gallery.classList.remove("bg-secondary", "text-white");
        gallery.classList.add("bg-primary-subtle");

        // Card: Hapus mode gelap
        for (let i = 0; i < cards.length; i++) {
          cards[i].classList.remove(
            "bg-secondary",
            "text-white");
        }

        // Footer Icon: Balik hitam
        for (let i = 0; i < footerIcons.length; i++) {
          footerIcons[i].classList.remove("text-white");
          footerIcons[i].classList.add("text-dark");
        }
      };
    </script>
  </body>
</html>
