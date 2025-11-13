<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SweetBite | Dashboard Pelanggan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #fdf5e6; /* Cream */
      color: #3e2723; /* Dark brown */
      font-family: 'Poppins', sans-serif;
    }

    /* Navbar styling */
    .navbar {
      background-color: #3e2723; /* Dark brown */
    }

    .navbar-brand, .nav-link, .navbar-toggler-icon {
      color: #fdf5e6 !important;
    }

    .nav-link:hover {
      color: #d7ccc8 !important;
    }

    /* Hero section */
    .hero {
      background-color: #6d4c41; /* Medium brown */
      color: #fff8dc;
      text-align: center;
      padding: 80px 20px;
      border-radius: 20px;
      margin-top: 20px;
    }

    .card {
      border: none;
      border-radius: 20px;
      background-color: #fff8dc;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      transition: transform 0.3s;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    footer {
      background-color: #3e2723;
      color: #fdf5e6;
      text-align: center;
      padding: 20px;
      margin-top: 50px;
      border-radius: 10px 10px 0 0;
    }

    .btn-brown {
      background-color: #3e2723;
      color: #fdf5e6;
      border-radius: 10px;
    }

    .btn-brown:hover {
      background-color: #5d4037;
      color: #fff8dc;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
       <a class="navbar-brand" href="#">MyWebsite</a>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
            </div>

            <form class="d-flex navbar-center ms-5" role="search">
                <input class="form-control me-2" size="40" type="search" placeholder="Search..." aria-label="Search">
            </form>

            <div class="justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Pesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Keranjang</a>
                    </li>
                    <li class="nav-item d-flex ">

                        <?php
                        if (isset($_SESSION['nama_user'])) {
                            echo '<div class="dropdown mt-1">
                            <button class="btn border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">'
                                . $_SESSION['nama_user'] .
                            '</button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item text-dark" href="#">Profil</a></li>
                                <li><a class="dropdown-item text-dark" href="logout.php">Log Out</a></li>
                            </ul>
                            </div>';
                        } else {
                        ?>

                        <?php
                            echo '
                        <a class="nav-link px-0" data-bs-toggle="modal" data-bs-target="#exampleModal2">Sign in/</a>
                        <a class="nav-link px-0" data-bs-toggle="modal" data-bs-target="#exampleModal">Register</a>
                    
                    ';
                        }
                        ?>
                    </li>
                </ul>
            </div>


        </div>
    </nav>

    <!-- Modal Register -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">REGISTER</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="register" action="dataregister.php" method="post">
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama_user" id="nama" aria-describedby="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email_user" id="email" aria-describedby="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="textarea" class="form-control" name="alamat_user" id="alamat" aria-describedby="alamat" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No Handphone</label>
                            <input type="number" class="form-control" name="no_hp" id="no_hp" aria-describedby="no_hp" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" name="password_user" class="form-control" id="exampleInputPassword1" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Sign Up</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <div class="container">
    <div class="hero mt-4">
      <h1>Selamat Datang di SweetBite!</h1>
      <p>Temukan kue favoritmu yang manis, lembut, dan dibuat dengan penuh cinta 💕</p>
      <a href="#" class="btn btn-brown mt-3">Lihat Kue Sekarang</a>
    </div>

    <!-- Produk Populer -->
    <h2 class="mt-5 mb-3 fw-bold text-center">🍪 Kue Populer Minggu Ini</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card p-3 text-center">
          <img src="https://images.unsplash.com/photo-1608198093002-ad4e005484b9?auto=format&fit=crop&w=600&q=80" class="card-img-top rounded-3" alt="Cheesecake">
          <div class="card-body">
            <h5 class="card-title">Cheesecake Strawberry</h5>
            <p class="card-text">Lembut dan manis, dipadukan dengan segarnya strawberry.</p>
            <button class="btn btn-brown">Beli Sekarang</button>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-3 text-center">
          <img src="https://images.unsplash.com/photo-1605475128023-4c7eb29d9e75?auto=format&fit=crop&w=600&q=80" class="card-img-top rounded-3" alt="Brownies">
          <div class="card-body">
            <h5 class="card-title">Brownies Coklat</h5>
            <p class="card-text">Padat, fudgy, dan kaya rasa coklat murni premium.</p>
            <button class="btn btn-brown">Beli Sekarang</button>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-3 text-center">
          <img src="https://images.unsplash.com/photo-1607083206173-77f2f3b2103f?auto=format&fit=crop&w=600&q=80" class="card-img-top rounded-3" alt="Cookies">
          <div class="card-body">
            <h5 class="card-title">Cookies Choco Chip</h5>
            <p class="card-text">Renyah di luar, lembut di dalam — dengan potongan coklat lezat.</p>
            <button class="btn btn-brown">Beli Sekarang</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Promo Section -->
    <div class="mt-5 text-center p-5 rounded-4" style="background-color: #f5deb3;">
      <h3>🎉 Promo Spesial Akhir Pekan!</h3>
      <p>Dapatkan potongan harga 20% untuk semua varian cheesecake hingga Minggu ini.</p>
      <a href="#" class="btn btn-brown">Lihat Promo</a>
    </div>
  </div>

  <!-- Footer -->
  <footer class="mt-5">
    <p>&copy; 2025 SweetBite Bakery | Semua hak cipta dilindungi 🍰</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
