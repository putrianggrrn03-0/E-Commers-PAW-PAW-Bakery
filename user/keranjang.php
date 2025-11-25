<?php
session_start();
include '../connection.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: ../index.php?must_login=1");
    exit();
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
        <script>
            // Helper: parse currency like "Rp 1.234.000" -> 1234000
            function parseRp(text) {
                if (!text) return 0;
                return parseInt(text.replace(/[^0-9]/g, '') || '0', 10);
            }

            function formatRp(num) {
                return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function recalcTotal() {
                var totals = document.querySelectorAll('.item-subtotal');
                var sum = 0;
                totals.forEach(function(el){
                    sum += parseRp(el.textContent || el.innerText);
                });
                var el = document.getElementById('grand-total');
                if (el) el.textContent = formatRp(sum);
                toggleCheckoutButton(sum > 0);
            }

            function toggleCheckoutButton(enable) {
                var btn = document.querySelector('.btn-checkout');
                if (!btn) return;
                if (enable) {
                    // if it's a disabled button, replace with link to checkout
                    if (btn.tagName.toLowerCase() === 'button') {
                        var link = document.createElement('a');
                        link.className = btn.className + ' btn-primary';
                        link.href = 'checkout.php';
                        link.textContent = 'Checkout Sekarang';
                        btn.parentNode.replaceChild(link, btn);
                    } else {
                        btn.classList.remove('btn-secondary');
                        btn.classList.add('btn-primary');
                        btn.removeAttribute('disabled');
                        btn.removeAttribute('aria-disabled');
                        btn.href = 'checkout.php';
                    }
                } else {
                    // replace anchor or disable button
                    if (btn.tagName.toLowerCase() === 'a') {
                        var disabledBtn = document.createElement('button');
                        disabledBtn.className = btn.className.replace('btn-primary','btn-secondary');
                        disabledBtn.disabled = true;
                        disabledBtn.setAttribute('aria-disabled','true');
                        disabledBtn.textContent = 'Checkout Sekarang';
                        btn.parentNode.replaceChild(disabledBtn, btn);
                    } else {
                        btn.disabled = true;
                        btn.setAttribute('aria-disabled','true');
                    }
                }
            }

            

            // initial calc on load
            document.addEventListener('DOMContentLoaded', function(){
                recalcTotal();
            });
        </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php"><img src="../img/PAWLOGO.png" alt="Logo" width="150" height="40" class="d-inline-block align-text-top"></a>
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

    <div class="container py-5">
        <h2 class="text-center mb-4">Keranjang Belanja Anda</h2>
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

                $stmt = mysqli_prepare($conn, $sql);
                if (!$stmt) {
                    die("Query prepare gagal: " . mysqli_error($conn));
                }
                mysqli_stmt_bind_param($stmt, "i", $id_user);
                if (!mysqli_stmt_execute($stmt)) {
                    die("Eksekusi query gagal: " . mysqli_stmt_error($stmt));
                }

                $result = mysqli_stmt_get_result($stmt);
                $has_items = ($result && mysqli_num_rows($result) > 0);

                if ($has_items):
                    while ($item = mysqli_fetch_assoc($result)):
                ?>
                        <div class="card cart-card p-4 mb-4" data-product-id="<?php echo $item['id_produk']; ?>" data-price="<?php echo $item['harga']; ?>">
                            <div class="row cart-item align-items-center">
                                <div class="col-md-3 text-center">
                                    <img src="../img/<?php echo htmlspecialchars($item['gambar']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($item['nama_produk']); ?>">
                                </div>
                                <div class="col-md-4">
                                    <h5 class="mb-1"><?php echo htmlspecialchars($item['nama_produk']); ?></h5>
                                    <p class="text-muted small mb-1">Kategori: <?php echo htmlspecialchars($item['kategori']); ?></p>
                                    <p class="fw-semibold">Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></p>
                                </div>
                                <div class="col-md-2 d-flex align-items-center justify-content-center">
                                    <div class="d-flex qty-group">
                                        <button type="button" class="btn btn-outline-secondary qty-btn" data-action="decrement">−</button>
                                        <input type="number" name="quantity" class="qty-input" min="1" value="<?php echo $item['quantity']; ?>" data-keranjang-id="<?php echo $item['id_keranjang']; ?>" data-harga="<?php echo $item['harga']; ?>">
                                        <button type="button" class="btn btn-outline-secondary qty-btn" data-action="increment">+</button>
                                    </div>
                                </div>
                                <div class="col-md-3 text-end">
                                    <div class="mb-2">
                                        <small class="text-muted">Subtotal:</small><br>
                                        <span class="fw-bold item-subtotal">Rp <?php echo number_format($item['total_price_item'], 0, ',', '.'); ?></span>
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

                <div class="text-end mt-4">
                    <p class="total">Total: <span id="grand-total">Rp 0</span></p>
                    <?php if (!empty($has_items)): ?>
                        <a class="btn btn-checkout btn-primary" href="checkout.php">Checkout Sekarang</a>
                    <?php else: ?>
                        <button class="btn btn-checkout btn-secondary" disabled aria-disabled="true">Checkout Sekarang</button>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</body>

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

            // Remove item button (AJAX with server-response check)
            document.querySelectorAll('.btn-remove-item').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (!confirm('Apakah Anda yakin ingin menghapus item ini?')) return;
                    var keranjangId = btn.getAttribute('data-keranjang-id');
                    var card = btn.closest('.cart-card');

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'delete_keranjang.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            try { var res = JSON.parse(xhr.responseText); } catch(err) { res = null; }
                            if (res && res.success) {
                                if (card) card.remove();
                                updateTotals();
                                toggleCheckoutButton(getGrandTotal() > 0);
                            } else {
                                alert((res && res.message) ? res.message : 'Gagal menghapus item');
                            }
                        } else {
                            alert('Gagal menghubungi server.');
                        }
                    };
                    xhr.send('id_keranjang=' + keranjangId);
                });
            });

            // Initial calculation on page load
            updateTotals();
            toggleCheckoutButton(getGrandTotal() > 0);

            // Helper to compute current grand total (number)
            function getGrandTotal() {
                var total = 0;
                document.querySelectorAll('.cart-card').forEach(function(card) {
                    var price = parseInt(card.getAttribute('data-price')) || 0;
                    var qtyInput = card.querySelector('.qty-input');
                    var qty = parseInt(qtyInput.value) || 0;
                    total += price * qty;
                });
                return total;
            }

            // Toggle checkout control (enable/disable)
            function toggleCheckoutButton(enable) {
                var container = document.querySelector('.text-end.mt-4');
                if (!container) return;
                var existing = container.querySelector('.btn-checkout');
                if (enable) {
                    if (existing && existing.tagName.toLowerCase() === 'button') {
                        var link = document.createElement('a');
                        link.className = existing.className.replace('btn-secondary','btn-checkout btn-primary');
                        link.href = 'checkout.php';
                        link.textContent = 'Checkout Sekarang';
                        existing.parentNode.replaceChild(link, existing);
                    } else if (existing) {
                        existing.classList.remove('btn-secondary');
                        existing.classList.add('btn-primary');
                        existing.href = 'checkout.php';
                    }
                } else {
                    if (existing && existing.tagName.toLowerCase() === 'a') {
                        var btn = document.createElement('button');
                        btn.className = existing.className.replace('btn-primary','btn-secondary');
                        btn.disabled = true;
                        btn.setAttribute('aria-disabled','true');
                        btn.textContent = 'Checkout Sekarang';
                        existing.parentNode.replaceChild(btn, existing);
                    } else if (existing) {
                        existing.disabled = true;
                        existing.setAttribute('aria-disabled','true');
                    }
                }
            }
        })();
    </script>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../navbar-mobile.js"></script>
</html>
