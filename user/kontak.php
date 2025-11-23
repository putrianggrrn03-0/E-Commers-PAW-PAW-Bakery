<?php
session_start();
include '../connection.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #fffdf9;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .contact-page {
            max-width: 900px;
            /* agar semua lebih kecil dan ditengah */
            margin: 40px auto;
            padding: 20px;
        }

        .contact-title {
            font-size: 36px;
            font-weight: 700;
            color: #4e342e;
            margin-bottom: 10px;
        }

        .contact-subtitle {
            color: #6d4c41;
            margin-bottom: 40px;
        }

        /* Kotak info + form ditengah */
        .contact-container {
            max-width: 900px;
            margin: auto;
            display: flex;
            flex-direction: column;
            gap: 25px;
            justify-content: center;
            align-items: center;
        }

        /* Info Box */
        .contact-info-box {
            width: 100%;
            background: #f7eee6;
            padding: 25px;
            border-radius: 18px;
            color: #4e342e;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .contact-info-box h3 {
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            gap: 8px;
        }

        .info-item i {
            font-size: 20px;
            color: #4e342e;
        }

        /* Form */
        .contact-form {
            width: 100%;
            background: #ffffff;
            padding: 25px;
            border-radius: 18px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            text-align: left;
            /* isi tetap rata kiri agar tidak aneh */
        }

        .contact-form h3 {
            color: #4e342e;
            margin-bottom: 15px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: 600;
            color: #4e342e;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            border: 1px solid #c7b9a6;
            margin-top: 5px;
        }

        .btn-send {
            width: 100%;
            padding: 12px;
            background: #4e342e;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 12px;
            cursor: pointer;
            transition: .3s;
        }

        .btn-send:hover {
            background: #3e2723;
        }

        /* Map */
        .map-box {
            margin-top: 35px;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .map-box iframe {
            width: 100%;
            height: 350px;
            border: 0;
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
                        <a class="nav-link" aria-current="page" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="produk.php">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kontak.php">Contact</a>
                    </li>
                </ul>

                <form class="d-flex mx-lg-3 my-2 my-lg-0" role="search">
                    <input class="form-control" size="30" type="search" placeholder="Search..." aria-label="Search">
                </form>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="pesanan.php">Pesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="keranjang.php">Keranjang</a>
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

    <!-- Modal login -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">SIGN IN</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="signin" action="datasignin.php" method="post">
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
                        <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Log in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <section class="contact-page">
        <h2 class="contact-title">Hubungi Kami</h2>
        <p class="contact-subtitle">Kami selalu siap membantu segala kebutuhanmu ❤️</p>

        <div class="contact-container">

            <!-- Info -->
            <div class="contact-info-box">
                <h3>Informasi Kontak</h3>

                <div class="info-item">
                    <i class="bi bi-geo-alt-fill"></i>
                    <p>Sei.Selapian No.13-15, Medan</p>
                </div>

                <div class="info-item">
                    <i class="bi bi-envelope-fill"></i>
                    <p>paaw.paww.id@gmail.com</p>
                </div>

                <div class="info-item">
                    <i class="bi bi-instagram"></i>
                    <p>paaww.paww_</p>
                </div>

                <div class="info-item">
                    <i class="bi bi-telephone-fill"></i>
                    <p>+62 812 6423 9824</p>
                </div>

                <div class="info-item">
                    <i class="bi bi-clock-fill"></i>
                    <p>09.00 – 20.00 WIB</p>
                </div>
            </div>

            <!-- Form -->
            <form class="contact-form">
                <h3>Kirim Pesan</h3>

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" placeholder="Masukkan nama kamu">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" placeholder="Masukkan email kamu">
                </div>

                <div class="form-group">
                    <label>Pesan</label>
                    <textarea rows="4" placeholder="Tulis pesan kamu..."></textarea>
                </div>

                <button type="submit" class="btn-send">Kirim Sekarang</button>
            </form>
        </div>


    </section>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../navbar-mobile.js"></script>

</html>