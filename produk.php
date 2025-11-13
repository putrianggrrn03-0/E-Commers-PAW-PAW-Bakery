<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SweetBite | Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
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

        /* Header */
        .page-header {
            text-align: center;
            background-color: #6d4c41;
            color: #fff8dc;
            padding: 60px 20px;
            border-radius: 0 0 30px 30px;
            margin-bottom: 50px;
        }

        /* Category Title */
        .category-title {
            color: #3e2723;
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }

        .category-title::after {
            content: "";
            display: block;
            width: 80px;
            height: 4px;
            background-color: #3e2723;
            margin: 10px auto;
            border-radius: 10px;
        }

        /* Product Card */
        .product-card {
            background-color: #fff8dc;
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .product-card img {
            height: 200px;
            object-fit: cover;
            border-bottom: 2px solid #d7ccc8;
        }

        .product-card .card-body {
            padding: 20px;
        }

        .product-name {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .product-price {
            color: #6d4c41;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .product-desc {
            font-size: 0.9rem;
            color: #5d4037;
            height: 45px;
        }

        .btn-cart {
            background-color: #3e2723;
            color: #fdf5e6;
            border-radius: 10px;
            width: 100%;
            transition: all 0.3s;
        }

        .btn-cart:hover {
            background-color: #5d4037;
        }

        .btn-cart:disabled {
            background-color: #b0a0a0;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .btn-cart:disabled:hover {
            background-color: #b0a0a0;
        }

        /* Quantity Counter */
        .qty-controls {
            display: flex;
            gap: 8px;
            margin-bottom: 12px;
            align-items: center;
            justify-content: center;
        }

        .qty-btn {
            width: 36px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            border: 1px solid #d7ccc8;
            background-color: #fff8dc;
            color: #3e2723;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.2s;
        }

        .qty-btn:hover {
            background-color: #6d4c41;
            color: #fdf5e6;
            border-color: #3e2723;
        }

        .qty-input {
            width: 60px;
            text-align: center;
            border: 1px solid #d7ccc8;
            border-radius: 6px;
            padding: 6px;
            font-weight: bold;
        }

        footer {
            background-color: #3e2723;
            color: #fdf5e6;
            text-align: center;
            padding: 15px;
            margin-top: 60px;
            border-radius: 15px 15px 0 0;
        }

        /* Animation */
        .fade-in {
            animation: fadeInUp 0.8s ease-in-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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

    <!-- Header -->
    <div class="page-header">
        <h1>Produk Kami</h1>
        <p>Temukan berbagai kue lezat dengan tampilan menggoda dan rasa yang memanjakan 💕</p>
    </div>

    <!-- Alert Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="container">

        <!-- Cake Section -->
        <h2 class="category-title fade-in">🎂 Cake</h2>
        <div class="row g-4 mb-5">
            <?php
            include 'connection.php';
            $sql = "SELECT * FROM produk WHERE kategori = 'cake'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="col-md-4 fade-in">
                        <div class="card product-card">
                            <img src="img/<?php echo $row['gambar'] ?>" class="card-img-top" alt="Cheesecake">
                            <div class="card-body">
                                <h5 class="product-name"><?php echo $row['nama_produk'] ?></h5>
                                <p class="product-price">Rp <?php echo number_format($row['harga'], 0, ',', '.') ?></p>
                                <p class="product-desc"><?php echo $row['deskripsi'] ?></p>
                                
                                <form method="POST" action="add_to_cart.php" class="add-to-cart-form">
                                    <input type="hidden" name="produk_id" value="<?php echo $row['id_produk'] ?>">
                                    <input type="hidden" name="harga" value="<?php echo $row['harga'] ?>">
                                    
                                    <div class="qty-controls">
                                        <button type="button" class="qty-btn qty-minus">−</button>
                                        <input type="number" name="quantity" class="qty-input qty-value" value="1" min="1" max="<?php echo $row['stok'] ?>" data-max="<?php echo $row['stok'] ?>">
                                        <button type="button" class="qty-btn qty-plus">+</button>
                                    </div>
                                    <small class="text-muted d-block text-center mb-2">Stok tersedia: <?php echo $row['stok'] ?></small>
                                    
                                    <button type="submit" class="btn btn-cart" <?php echo !isset($_SESSION['id_user']) ? 'disabled title="Login untuk menambahkan ke keranjang"' : ''; ?>>+ Tambah ke Keranjang</button>
                                </form>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<h1 class= 'text-center'> Product Not Available</h1>";
            }
            ?>
        </div>

        <!-- Cookies Section -->
        <h2 class="category-title fade-in">🍪 Cookies</h2>
        <div class="row g-4 mb-5">
            <?php
            include 'connection.php';
            $sql = "SELECT * FROM produk WHERE kategori='cookies'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="col-md-4 fade-in">
                        <div class="card product-card">
                            <img src="img/<?php echo $row['gambar'] ?>" class="card-img-top" alt="Cheesecake">
                            <div class="card-body">
                                <h5 class="product-name"><?php echo $row['nama_produk'] ?></h5>
                                <p class="product-price">Rp <?php echo number_format($row['harga'], 0, ',', '.') ?></p>
                                <p class="product-desc"><?php echo $row['deskripsi'] ?></p>
                                
                                <form method="POST" action="add_to_cart.php" class="add-to-cart-form">
                                    <input type="hidden" name="produk_id" value="<?php echo $row['id_produk'] ?>">
                                    <input type="hidden" name="harga" value="<?php echo $row['harga'] ?>">
                                    
                                    <div class="qty-controls">
                                        <button type="button" class="qty-btn qty-minus">−</button>
                                        <input type="number" name="quantity" class="qty-input qty-value" value="1" min="1" max="<?php echo $row['stok'] ?>" data-max="<?php echo $row['stok'] ?>">
                                        <button type="button" class="qty-btn qty-plus">+</button>
                                    </div>
                                    <small class="text-muted d-block text-center mb-2">Stok tersedia: <?php echo $row['stok'] ?></small>
                                    
                                    <button type="submit" class="btn btn-cart">+ Tambah ke Keranjang</button>
                                </form>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<h1 class= 'text-center'> Product Not Available</h1>";
            }
            ?>
        </div>


        <!-- Dessert Section -->
        <h2 class="category-title fade-in">🍨 Dessert</h2>
        <div class="row g-4 mb-5">
            <?php
            include 'connection.php';
            $sql = "SELECT * FROM produk WHERE kategori='dessert'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="col-md-4 fade-in">
                        <div class="card product-card">
                            <img src="img/<?php echo $row['gambar'] ?>" class="card-img-top" alt="Cheesecake">
                            <div class="card-body">
                                <h5 class="product-name"><?php echo $row['nama_produk'] ?></h5>
                                <p class="product-price">Rp <?php echo number_format($row['harga'], 0, ',', '.') ?></p>
                                <p class="product-desc"><?php echo $row['deskripsi'] ?></p>
                                
                                <form method="POST" action="add_to_cart.php" class="add-to-cart-form">
                                    <input type="hidden" name="produk_id" value="<?php echo $row['id_produk'] ?>">
                                    <input type="hidden" name="harga" value="<?php echo $row['harga'] ?>">
                                    
                                    <div class="qty-controls">
                                        <button type="button" class="qty-btn qty-minus">−</button>
                                        <input type="number" name="quantity" class="qty-input qty-value" value="1" min="1" max="<?php echo $row['stok'] ?>" data-max="<?php echo $row['stok'] ?>">
                                        <button type="button" class="qty-btn qty-plus">+</button>
                                    </div>
                                    <small class="text-muted d-block text-center mb-2">Stok tersedia: <?php echo $row['stok'] ?></small>
                                    
                                    <button type="submit" class="btn btn-cart" <?php echo !isset($_SESSION['user_id']) ? 'disabled title="Login untuk menambahkan ke keranjang"' : ''; ?>>+ Tambah ke Keranjang</button>
                                </form>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<h1 class= 'text-center'> Product Not Available</h1>";
            }
            ?>
        </div>

        <!-- Footer -->
        <footer>
            <p>&copy; 2025 SweetBite Bakery | Dibuat dengan cinta dan coklat 🍫</p>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        
        <script>
            // Quantity counter functionality - dari frontend dengan validasi stok
            document.querySelectorAll('.qty-minus').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('.add-to-cart-form');
                    const input = form.querySelector('.qty-value');
                    let currentValue = parseInt(input.value) || 1;
                    
                    // Kurangi quantity, minimum 1
                    if (currentValue > 1) {
                        input.value = currentValue - 1;
                    }
                });
            });

            document.querySelectorAll('.qty-plus').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('.add-to-cart-form');
                    const input = form.querySelector('.qty-value');
                    const maxStok = parseInt(input.getAttribute('data-max'));
                    let currentValue = parseInt(input.value) || 1;
                    
                    // Tambah quantity, tidak boleh melebihi stok
                    if (currentValue < maxStok) {
                        input.value = currentValue + 1;
                    } else {
                        alert('⚠️ Stok hanya tersedia ' + maxStok + ' item');
                    }
                });
            });
        </script>
</body>

</html>