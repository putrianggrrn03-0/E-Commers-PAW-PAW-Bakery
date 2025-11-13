<?php 
session_start();
include 'connection.php';

// Pastikan user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit();
}

$id_user = $_SESSION['id_user']; // ambil ID user dari session
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>History Pesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
            background-color: #fdf5e6;
            /* Cream */
            font-family: 'Poppins', sans-serif;
            color: #3e2723;
            /* Dark Brown */
        }

        /* Navbar */
        .navbar {
            background-color: #3e2723;
        }

        .navbar-brand,
        .nav-link {
            color: #fdf5e6 !important;
            font-weight: 500;
        }

        .nav-link:hover {
            color: #d7ccc8 !important;
        }
    .order-card {
      background-color: #5d4037;
      border-radius: 15px;
      padding: 15px;
      margin-bottom: 20px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    }
    .shop-name {
      font-weight: bold;
      color: #f5f5dc;
    }
    .status {
      color: #81c784;
      font-weight: bold;
    }
    .product-img {
      width: 80px;
      height: 80px;
      border-radius: 10px;
      object-fit: cover;
    }
    .btn-cream {
      background-color: #f5f5dc;
      color: #3e2723;
      border-radius: 8px;
      font-weight: 600;
      border: none;
      transition: 0.3s;
    }
    .btn-cream:hover {
      background-color: #e0d7b8;
    }
    .btn-outline-cream {
      border: 1px solid #f5f5dc;
      color: #f5f5dc;
      border-radius: 8px;
      font-weight: 600;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg" style="padding: 8px 15px 8px 50px;">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">MyWebsite</a>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="produk.php">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
            </div>

            <form class="d-flex justify-content-center mx-auto me-4" role="search">
                <input class="form-control" size="40" type="search" placeholder="Search..." aria-label="Search">
            </form>

            <div class="justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="pesanan.php">Pesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="keranjang.php">Keranjang</a>
                    </li>
                    <li class="nav-item d-flex">

                        <?php
                        if (isset($_SESSION['nama_user'])) {
                            echo '<div class="dropdown mt-1 color: #d7ccc8;">
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

  <!-- Tab Status Pesanan -->
  <div class="container mt-4">

    <div class="tab-content">

      <!-- Transaksi Selesai -->
      <div class="tab-pane fade show active" id="selesai" role="tabpanel" aria-labelledby="tab-selesai">
        <?php 
       $sql = "SELECT 
          t.id_transaksi,
          t.id_keranjang,
          t.total AS total_price_item,
          t.status,
          t.payment,
          t.delivery_method,
          k.quantity,
          p.nama_produk,
          p.harga,
          p.gambar
        FROM transaksi t
        JOIN keranjang k ON t.id_keranjang = k.id_keranjang
        JOIN produk p ON k.id_produk = p.id_produk
        WHERE t.id_user = ? AND t.status = 'selesai'
        ORDER BY t.id_transaksi DESC";

        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            die("Query error (selesai): " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "i", $id_user);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="order-card">
              <div class="d-flex justify-content-end align-items-center mb-2">
                <span class="status text-success"><?= ucfirst($row['status']); ?></span>
              </div>
              <div class="d-flex align-items-center mb-3">
                <img src="img/<?= htmlspecialchars($row['gambar']); ?>" alt="produk" class="product-img me-3">
                <div class="flex-grow-1">
                  <div class="fw-semibold"><?= htmlspecialchars($row['nama_produk']); ?></div>
                  <div class="small">x<?= $row['quantity']; ?></div>
                </div>
                <div class="text-end">
                  <div>Rp<?= number_format($row['harga'], 0, ',', '.'); ?></div>
                  <small>Total: Rp<?= number_format($row['total_price_item'], 0, ',', '.'); ?></small>
                </div>
              </div>
              <div class="text-end">
                <button class="btn btn-outline-cream btn-sm me-2">Nilai</button>
                <button class="btn btn-cream btn-sm">Beli Lagi</button>
              </div>
            </div>
        <?php 
          }
        } else {
          echo "<p class='text-center'>Belum ada transaksi selesai.</p>";
        }
        ?>
      </div>

      <!-- Transaksi Pending -->

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
