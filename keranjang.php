<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f0eb;
            /* cream lembut */
            font-family: 'Poppins', sans-serif;
        }

        .navbar {
            background-color: #4e342e;
            /* dark brown */
        }

        .navbar-brand,
        .nav-link,
        .navbar-text {
            color: #f5f0eb !important;
        }

        .cart-card {
            background-color: #fffaf5;
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .cart-item img {
            border-radius: 12px;
        }

        .btn-checkout {
            background-color: #795548;
            color: #f5f0eb;
            border: none;
            border-radius: 10px;
            padding: 10px 25px;
            transition: 0.3s;
        }

        .btn-checkout:hover {
            background-color: #5d4037;
        }

        .total {
            font-size: 1.2rem;
            font-weight: bold;
            color: #4e342e;
        }

        /* Quantity counter styles */
        .qty-input {
            width: 72px;
            padding: .375rem .5rem;
            border-radius: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .qty-btn {
            width: 36px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }

        .qty-group {
            gap: .25rem;
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

    <!-- Isi Keranjang -->
    <div class="container py-5">
        <h2 class="text-center mb-4" style="color: #4e342e;">Keranjang Belanja Anda</h2>

        <div class="row justify-content-center">
            <div class="col-md-8">

                <?php
                $id_user = (int)$_SESSION['id_user'];

                if (!$conn) {
                    die("Koneksi database gagal: " . mysqli_connect_error());
                }

                $sql = "SELECT 
            k.id_keranjang,
            k.id_produk,
            k.quantity,
            k.total_price_item,
            p.id_produk,
            p.nama_produk,
            p.kategori,
            p.harga,
            p.gambar
        FROM keranjang k
        JOIN produk p ON k.id_produk = p.id_produk
        WHERE k.id_user = ?
        ORDER BY k.id_keranjang DESC";

                // Siapkan statement
                $stmt = mysqli_prepare($conn, $sql);

                // Cek jika gagal prepare
                if (!$stmt) {
                    die("Query prepare gagal: " . mysqli_error($conn));
                }
                mysqli_stmt_bind_param($stmt, "i", $id_user);

                // Jalankan query
                if (!mysqli_stmt_execute($stmt)) {
                    die("Eksekusi query gagal: " . mysqli_stmt_error($stmt));
                }

                $result = mysqli_stmt_get_result($stmt);

                if ($result && mysqli_num_rows($result) > 0):
                    while ($item = mysqli_fetch_assoc($result)):
                ?>
                        <!-- Card Keranjang -->
                        <div class="card cart-card p-4 mb-4" data-product-id="<?php echo $item['id_produk']; ?>" data-price="<?php echo $item['harga']; ?>">
                            <div class="row cart-item align-items-center">
                                <div class="col-md-3 text-center">
                                    <img src="img/<?php echo htmlspecialchars($item['gambar']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($item['nama_produk']); ?>">
                                </div>
                                <div class="col-md-4">
                                    <h5 class="mb-1" style="color:#4e342e;"><?php echo htmlspecialchars($item['nama_produk']); ?></h5>
                                    <p class="text-muted small mb-1">Kategori: <?php echo htmlspecialchars($item['kategori']); ?></p>
                                    <p class="fw-semibold" style="color:#795548;">Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></p>
                                </div>
                                <div class="col-md-2 d-flex align-items-center justify-content-center">
                                    <div class="d-flex qty-group">
                                        <button type="button" class="btn btn-outline-secondary qty-btn" data-action="decrement" aria-label="Kurangi jumlah">&minus;</button>
                                        <input type="number" name="quantity" class="qty-input" min="1" value="<?php echo $item['quantity']; ?>" aria-label="Jumlah produk" data-keranjang-id="<?php echo $item['id_keranjang']; ?>" data-harga="<?php echo $item['harga']; ?>">
                                        <button type="button" class="btn btn-outline-secondary qty-btn" data-action="increment" aria-label="Tambah jumlah">+</button>
                                    </div>
                                </div>
                                <div class="col-md-3 text-end">
                                    <div class="mb-2">
                                        <small class="text-muted">Subtotal:</small><br>
                                        <span class="fw-bold item-subtotal" style="color:#795548; font-size:1.1rem;">Rp <?php echo number_format($item['total_price_item'], 0, ',', '.'); ?></span>
                                    </div>
                                    <button class="btn btn-outline-danger btn-sm btn-remove-item" data-keranjang-id="<?php echo $item['id_keranjang']; ?>">Hapus</button>
                                </div>
                            </div>
                        </div>

                    <?php
                    endwhile;
                    mysqli_stmt_close($stmt);
                else:
                    ?>
                    <div class="alert alert-info text-center">
                        <p>Keranjang Anda kosong. <a href="produk.php">Belanja sekarang</a></p>
                    </div>
                <?php
                endif;
                ?>


                <!-- Total -->
                <div class="text-end mt-4">
                    <p class="total">Total: <span id="grand-total">Rp 0</span></p>
                    <a class="btn btn-checkout" href="checkout.php">Checkout Sekarang</a>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Quantity counter handlers + Total calculation
        (function() {
            function clamp(n, min, max) {
                return Math.max(min, Math.min(max, n));
            }

            // Helper: format currency to Rp
            function formatCurrency(num) {
                return 'Rp ' + num.toLocaleString('id-ID', {
                    minimumFractionDigits: 0
                });
            }

            // Helper: recalculate totals
            function updateTotals() {
                var grandTotal = 0;

                document.querySelectorAll('.cart-card').forEach(function(card) {
                    var price = parseInt(card.getAttribute('data-price')) || 0;
                    var qtyInput = card.querySelector('.qty-input');
                    var qty = parseInt(qtyInput.value) || 0;
                    var subtotal = price * qty;

                    // Update item subtotal display
                    var subtotalSpan = card.querySelector('.item-subtotal');
                    if (subtotalSpan) {
                        subtotalSpan.textContent = formatCurrency(subtotal);
                    }

                    grandTotal += subtotal;
                });

                // Update grand total
                var grandTotalSpan = document.getElementById('grand-total');
                if (grandTotalSpan) {
                    grandTotalSpan.textContent = formatCurrency(grandTotal);
                }
            }

            // Attach event listeners to all quantity controls
            document.querySelectorAll('.qty-group').forEach(function(group) {
                var btns = group.querySelectorAll('.qty-btn');
                var input = group.querySelector('.qty-input');

                btns.forEach(function(btn) {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        var action = btn.getAttribute('data-action');
                        var current = parseInt(input.value) || 0;
                        if (action === 'increment') current = current + 1;
                        else if (action === 'decrement') current = current - 1;
                        current = clamp(current, parseInt(input.getAttribute('min') || 1), Number.MAX_SAFE_INTEGER);
                        input.value = current;
                        updateTotals();
                        input.dispatchEvent(new Event('input', {
                            bubbles: true
                        }));
                    });
                });

                // Saat quantity berubah, update ke database
                input.addEventListener('change', function() {
                    var val = parseInt(input.value) || 0;
                    input.value = clamp(val, parseInt(input.getAttribute('min') || 1), Number.MAX_SAFE_INTEGER);
                    updateTotals();

                    // Update quantity di database
                    var keranjangId = input.getAttribute('data-keranjang-id');
                    var harga = parseInt(input.getAttribute('data-harga'));
                    var newQty = parseInt(input.value);
                    var totalPrice = harga * newQty;

                    // Kirim AJAX request
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'update_keranjang.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.send('id_keranjang=' + keranjangId + '&quantity=' + newQty + '&total_price=' + totalPrice);
                });
            });

            // Remove item button
            document.querySelectorAll('.btn-remove-item').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                        var keranjangId = btn.getAttribute('data-keranjang-id');
                        var card = btn.closest('.cart-card');

                        // Kirim AJAX request untuk delete
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', 'delete_keranjang.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                card.remove();
                                updateTotals();
                            }
                        };
                        xhr.send('id_keranjang=' + keranjangId);
                    }
                });
            });

            // Initial calculation on page load
            updateTotals();
        })();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>