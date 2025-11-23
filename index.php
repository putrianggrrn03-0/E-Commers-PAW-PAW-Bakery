<?php

use LDAP\Result;

session_start();
include 'connection.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>PAW PAW BAKERY & BEVERAGE</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Menggunakan CDN Bootstrap (tanpa integrity untuk mencegah mismatch saat debugging) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="navbar-search.css">
    <style>
        html, body {
            overflow-x: hidden;
            width: 100%;
        }
        #carouselExampleIndicators {
            max-width: 1500px;
            margin: auto;
        }

        #carouselExampleIndicators .carousel-inner {
            border-radius: 30px;
            overflow: hidden;
        }

        #carouselExampleIndicators .carousel-inner img {
            height: 550px;
            width: 100%;
            object-fit: cover;
        }

        #carouselExampleIndicators .carousel-indicators button {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #bbb;
        }

        #carouselExampleIndicators .carousel-indicators .active {
            background-color: #333;
        }

        @media (max-width: 768px) {
            #carouselExampleIndicators .carousel-inner img {
                height: 240px;
                /* otomatis mengecil */
            }
        }

        .carousel-item img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 40px;
        }

        .carousel-inner {
            border-radius: 40px;
            /* Membuat seluruh carousel melengkung */
            overflow: hidden;
            /* Biar gambar tidak keluar frame */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">PAW PAW</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user/produk.php">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user/kontak.php">Contact</a>
                    </li>
                </ul>

                <form class="d-flex mx-lg-3 my-2 my-lg-0" role="search">
                    <input class="form-control" size="30" type="search" placeholder="Search..." aria-label="Search">
                </form>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="user/pesanan.php">Pesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user/keranjang.php">Keranjang</a>
                    </li>
                    <li class="nav-item d-flex align-items-center">

                        <?php
                        if (isset($_SESSION['nama_user'])) {
                            echo '<div class="dropdown mt-1">
                            <button class="btn btn-sm btn-outline-light" type="button" style="font-weight: 600;" data-bs-toggle="dropdown" aria-expanded="false">'
                                . htmlspecialchars($_SESSION['nama_user']) .
                                '</button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item text-black" href="user/profil.php">Profil</a></li>
                                <li><a class="dropdown-item text-black" href="user/logout.php">Log Out</a></li>
                            </ul>
                            </div>';
                        } else {
                            echo '<a class="nav-link" data-bs-toggle="modal" data-bs-target="#exampleModal2" style="font-weight: 700;"><b>Sign in</b></a>';
                            echo '<a class="nav-link" data-bs-toggle="modal" data-bs-target="#exampleModal" style="font-weight: 700;"><b>Register</b></a>';
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
                <form class="register" action="user/dataregister.php" method="post">
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
                        <button type="submit" class="btn btn-primary">Sign Up</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal login -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">SIGN IN</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="signin" action="user/datasignin.php" method="post">
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email_user" id="email" aria-describedby="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password_user" id="exampleInputPassword1" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Log in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <?php if (isset($_GET['checkout']) && $_GET['checkout'] === 'success'): ?>
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Transaksi berhasil!</strong> Terima kasih, pesanan Anda telah diterima.
                <a href="user/pesanan.php" class="alert-link">Lihat pesanan</a>.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php elseif (isset($_GET['checkout']) && $_GET['checkout'] === 'failed'): ?>
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Transaksi gagal.</strong> Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <div class="container mt-3">

        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img/A1.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="img/InCollage_20251123_122829466.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="img/cv3.jpg" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

        <!-- Produk Populer -->
        <div class="container my-5">
            <h2 class="fw-bold text-center mb-4">🍪 Kue Populer Minggu Ini</h2>
            <div class="row g-4 justify-content-center">

                <!--P1-->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm" style="border-radius: 15px; overflow: hidden;">
                        <img class="card-img-top" src="img/ck.jpg" alt="Cheesecake" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-center fw-bold" style="color: #3e2723;">Cheesecake</h5>
                            <p class="card-text flex-grow-1" style="color: #666; line-height: 1.5;">Cheesecake lembut dan creamy dengan rasa manis-gurih yang seimbang, berpadu dengan aroma susu yang khas.</p>
                            <a href="user/produk.php" class="btn btn-primary mt-auto" style="border-radius: 10px; font-weight: 600;">Shop Now</a>
                        </div>
                    </div>
                </div>
                
                <!--P2-->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm" style="border-radius: 15px; overflow: hidden;">
                        <img class="card-img-top" src="img/co.jpg" alt="Cookies" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-center fw-bold" style="color: #3e2723;">Cookies</h5>
                            <p class="card-text flex-grow-1" style="color: #666; line-height: 1.5;">Cookies renyah di luar dan lembut di dalam, menghadirkan rasa manis gurih dengan berbagai pilihan topping dan isian.</p>
                            <a href="user/produk.php" class="btn btn-primary mt-auto" style="border-radius: 10px; font-weight: 600;">Shop Now</a>
                        </div>
                    </div>
                </div>
                
                <!--P3-->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm" style="border-radius: 15px; overflow: hidden;">
                        <img class="card-img-top" src="img/br.jpg" alt="Brownies" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-center fw-bold" style="color: #3e2723;">Brownies</h5>
                            <p class="card-text flex-grow-1" style="color: #666; line-height: 1.5;">Brownies cokelat pekat dengan tekstur fudgy, manisnya pas, dan aroma cokelat yang intens di setiap gigitan.</p>
                            <a href="user/produk.php" class="btn btn-primary mt-auto" style="border-radius: 10px; font-weight: 600;">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- <?php
                    $sql = "SELECT * FROM produk LIMIT 3";
                    $result = mysqli_query($conn, $sql);

                    if (!$result) {
                        die("Query gagal: " . mysqli_error($conn));
                    }

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="col-md-4">
                        <div class="card p-3 text-center">
                            <img src="img/<?php echo $row['gambar'] ?>" class="card-img-top rounded-3" alt="Cheesecake" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['nama_produk'] ?></h5>
                                <p class="card-text"><?php echo $row['deskripsi'] ?></p>
                                <a href="user/produk.php" class="btn btn-brown">Beli Sekarang</a>
                            </div>
                        </div>
                    </div>
            <?php
                        }
                    }
            ?> -->


            <!-- Promo Section -->
            <div class="mt-5 text-center p-5 rounded-4" style="background-color: #f5deb3;">
                <h3>🎉 Promo Spesial Akhir Pekan!</h3>
                <p>Dapatkan potongan harga 20% untuk semua varian cheesecake hingga Minggu ini.</p>
                <a href="#" class="btn btn-brown">Lihat Promo</a>
            </div>
            </div>
        </div> <!-- close .container -->

        <!-- Footer (full-width) -->
        <footer class="mt-5 w-100 text-center">
            <p>&copy; 2025 SweetBite Bakery | Semua hak cipta dilindungi 🍰</p>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
        <script src="navbar-mobile.js"></script>
</body>

</html>