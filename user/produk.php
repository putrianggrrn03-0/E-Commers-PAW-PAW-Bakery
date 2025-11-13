<?php
session_start();
include '../connection.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SweetBite | Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg" style="padding: 8px 15px 8px 50px;">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">PAW PAW</a>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="../index.php">Home</a>
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
                            <button class="btn border-0 text-light" type="button" style="font-weight: 600;" data-bs-toggle="dropdown" aria-expanded="false">'
                                . $_SESSION['nama_user'] .
                                '</button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item text-dark" href="profil.php">Profil</a></li>
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

    <div class="page-header">
        <h1>Produk Kami</h1>
        <p>Temukan berbagai kue lezat dengan tampilan menggoda dan rasa yang memanjakan 💕</p>
    </div>

    <div class="container">

        <!-- Cake Section -->
        <h2 class="category-title fade-in">🎂 Cake</h2>
        <div class="row g-4 mb-5">
            <?php
            $sql = "SELECT * FROM produk WHERE kategori = 'cake'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="col-md-4 fade-in">
                        <div class="card product-card position-relative">
                            <img src="../img/<?php echo $row['gambar'] ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['nama_produk']); ?>">
                            <?php if ((int)$row['stok'] <= 0): ?>
                                <div class="sold-overlay"><span class="sold-out">Sold Out</span></div>
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="product-name"><?php echo $row['nama_produk'] ?></h5>
                                <p class="product-price">Rp <?php echo number_format($row['harga'], 0, ',', '.') ?></p>
                                <p class="product-desc"><?php echo $row['deskripsi'] ?></p>
                                <?php if ((int)$row['stok'] > 0): ?>
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
                                <?php else: ?>
                                <div class="text-center mt-3">
                                    <small class="text-muted d-block mb-2">Stok tersedia: 0</small>
                                    <button class="btn btn-cart" disabled aria-disabled="true">Sold Out</button>
                                </div>
                                <?php endif; ?>
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
         <h2 class="category-title fade-in">🍪 Cookies</h2>
        <div class="row g-4 mb-5">
            <?php
            $sql = "SELECT * FROM produk WHERE kategori='cookies'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="col-md-4 fade-in">
                        <div class="card product-card position-relative">
                            <img src="../img/<?php echo $row['gambar'] ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['nama_produk']); ?>">
                            <?php if ((int)$row['stok'] <= 0): ?>
                                <div class="sold-overlay"><span class="sold-out">Sold Out</span></div>
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="product-name"><?php echo $row['nama_produk'] ?></h5>
                                <p class="product-price">Rp <?php echo number_format($row['harga'], 0, ',', '.') ?></p>
                                <p class="product-desc"><?php echo $row['deskripsi'] ?></p>
                                
                                <?php if ((int)$row['stok'] > 0): ?>
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
                                <?php else: ?>
                                <div class="text-center mt-3">
                                    <small class="text-muted d-block mb-2">Stok tersedia: 0</small>
                                    <button class="btn btn-cart" disabled aria-disabled="true">Sold Out</button>
                                </div>
                                <?php endif; ?>
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
            $sql = "SELECT * FROM produk WHERE kategori='dessert'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="col-md-4 fade-in">
                        <div class="card product-card position-relative">
                            <img src="../img/<?php echo $row['gambar'] ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['nama_produk']); ?>">
                            <?php if ((int)$row['stok'] <= 0): ?>
                                <div class="sold-overlay"><span class="sold-out">Sold Out</span></div>
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="product-name"><?php echo $row['nama_produk'] ?></h5>
                                <p class="product-price">Rp <?php echo number_format($row['harga'], 0, ',', '.') ?></p>
                                <p class="product-desc"><?php echo $row['deskripsi'] ?></p>
                                
                                <?php if ((int)$row['stok'] > 0): ?>
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
                                <?php else: ?>
                                <div class="text-center mt-3">
                                    <small class="text-muted d-block mb-2">Stok tersedia: 0</small>
                                    <button class="btn btn-cart" disabled aria-disabled="true">Sold Out</button>
                                </div>
                                <?php endif; ?>
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
    </div>

</body>
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
</html>
