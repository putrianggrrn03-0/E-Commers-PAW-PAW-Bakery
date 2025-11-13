<?php
session_start();
include '../connection.php';

if (!isset($_SESSION['id_admin'])) {
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>PAW PAW BAKERY & BEVERAGE</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Menggunakan CDN Bootstrap (tanpa integrity untuk mencegah mismatch saat debugging) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="padding: 8px 15px 8px 50px;">
        <div class="container-fluid">
            <a class="navbar-brand" href="dasboard.php">Admin Panel</a>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="dasboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="produk.php">Data Produk</a>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="orderan.php">Data Order</a>
                    </li>
                </ul>
            </div>



            <div class="justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item d-flex ">

                        <?php
                        if (isset($_SESSION['nama_admin'])) {
                            echo '<div class="dropdown mt-1">
                            <button class="btn border-0 text-light" type="button" style="font-weight: 600;" data-bs-toggle="dropdown" aria-expanded="false">'
                                . $_SESSION['nama_admin'] .
                            '</button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item text-dark" href="#">Profil</a></li>
                                <li><a class="dropdown-item text-dark" href="logout.php">Log Out</a></li>
                            </ul>
                            </div>';
                        } ?>
                </ul>
            </div>


        </div>
    </nav>

    <?php
    // fetch counts for dashboard cards
    $prod_count = 0;
    $user_count = 0;
    $q1 = mysqli_query($conn, "SELECT COUNT(*) AS c FROM produk");
    if ($q1) {
        $r1 = mysqli_fetch_assoc($q1);
        $prod_count = (int)$r1['c'];
    }
    $q2 = mysqli_query($conn, "SELECT COUNT(*) AS c FROM user");
    if ($q2) {
        $r2 = mysqli_fetch_assoc($q2);
        $user_count = (int)$r2['c'];
    }
    ?>

    <main class="container my-5">
        <h1 class="mb-4" style="color:#3e2723;">Dashboard Admin</h1>

        <div class="row g-4">
            <div class="col-sm-6 col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="card-subtitle mb-2 text-muted">Total Produk</h6>
                                <h2 class="card-title" style="color:#b5651d; margin:0;"><?php echo number_format($prod_count); ?></h2>
                            </div>
                            <div style="font-size:36px; color:#f0c9a8;">
                                <!-- product icon -->
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 7L12 2l9 5v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7z" stroke="#b5651d" stroke-width="1.2" stroke-linejoin="round" stroke-linecap="round"/>
                                </svg>
                            </div>
                        </div>
                        <p class="small-muted mt-3 mb-0">Jumlah produk yang tersedia di toko.</p>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="card-subtitle mb-2 text-muted">Total Pengguna</h6>
                                <h2 class="card-title" style="color:#3e2723; margin:0;"><?php echo number_format($user_count); ?></h2>
                            </div>
                            <div style="font-size:36px; color:#c8d6d5;">
                                <!-- user icon -->
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8z" stroke="#3e2723" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M4 20v-1a6 6 0 0 1 6-6h4a6 6 0 0 1 6 6v1" stroke="#3e2723" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </div>
                        <p class="small-muted mt-3 mb-0">Pengguna terdaftar di website.</p>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>