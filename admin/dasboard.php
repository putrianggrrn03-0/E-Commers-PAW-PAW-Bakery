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
            <a class="navbar-brand" href="#">MyWebsite</a>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Dasboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="produk.php">Data Produk</a>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Data Order</a>
                    </li>
                </ul>
            </div>



            <div class="justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item d-flex ">

                        <?php
                        if (isset($_SESSION['nama_admin'])) {
                            echo '<div class="dropdown mt-1">
                            <button class="btn border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">'
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








    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>