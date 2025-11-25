<?php
session_start();
include '../connection.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: ../index.php?must_login=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../navbar-responsive.css">
    <title>Payment</title>
    <style>
        body{
            background-color: #FFF8DE;
        }
        .btn {
            color: white;
        }
    </style>
</head>


<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-brown">
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
    <!-- Delivery Address -->
    <div class="checkout-container">
        <header class="checkout-header">
            <h2 style="font-family: Georgia, 'Times New Roman', Times, serif;">Payment</h2>
        </header>

        <!-- Delivery Address -->
        <div class="section">
            <?php
            $id_user = $_SESSION['id_user'];

            $sql = "SELECT nama_user, no_hp, alamat_user FROM user WHERE id_user = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $id_user);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);
            ?>
            <div class="address-info">
                <strong><?php echo $user['nama_user'] ?></strong><br>
                <?php echo $user['no_hp'] ?><br>
                <?php echo $user['alamat_user'] ?>
            </div>
        </div>

        <form method="post" action="transaksi_process.php">
            <div class="section">
                <div class="section-title">Delivery Method</div>
                <div class="radio-group">
                    <label><input type="radio" name="delivery" value="Delivery" checked> Delivery</label>
                    <label><input type="radio" name="delivery" value="Pick up"> Pick Up</label>
                </div>
            </div>

            <!-- Order Summary (simplified) -->
            <div class="section">
                <div class="section-title">Order Summary</div>
                <?php
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
                mysqli_stmt_bind_param($stmt, "i", $id_user);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $total = 0;

                $has_items = (mysqli_num_rows($result) > 0);

                if ($has_items) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $total += $row['total_price_item'];
                        echo '<div class="order-summary"><div class="order-item"><img src="../img/' . htmlspecialchars($row['gambar']) . '"/><div class="order-text"><strong>' . htmlspecialchars($row['nama_produk']) . '</strong> • x' . $row['quantity'] . '</div></div><div><strong>Rp ' . number_format($row['total_price_item'], 0, ',', '.') . '</strong></div></div>';
                    }
                } else {
                    echo '<div class="alert alert-info">Keranjang Anda kosong. <a href="produk.php">Belanja sekarang</a></div>';
                }
                ?>
                <div class="subtotal">
                    <span>Total</span>
                    <span>Rp <?php echo number_format($total, 0, ',', '.') ?></span>
                </div>
            </div>

            <div class="section">
                <div class="section-title">Payment Method</div>
                <div class="payment-method">
                    <label><input type="radio" name="payment" value="Cash" checked> Cash</label>
                </div>
            </div>

            <?php if (!empty($has_items)): ?>
                <button class="btn btn-pay" type="submit" name="pay_now">Pay Now</button>
            <?php else: ?>
                <button class="btn btn-pay" type="submit" name="pay_now" disabled aria-disabled="true">Pay Now</button>
            <?php endif; ?>
        </form>
    </div> <!-- .checkout-container -->

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="../navbar-mobile.js"></script>

</html>