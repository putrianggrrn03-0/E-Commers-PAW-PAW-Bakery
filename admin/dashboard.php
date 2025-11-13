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
         <!--Burger icon (tombol collapse) -->
            <div class="burger-menu" style=>
                 <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" 
                 aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                 <span class="navbar-toggler-icon"></span>
                 <a style="margin-top: 5px;" class="navbar-brand" href="#">MyWebsite</a>
                </button>
                </div>
                

         <div class="justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item d-flex">
                         <i class="fa-solid fa-user me-1"></i>
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
            
            <!-- Menu -->
                 <div class="collapse navbar-collapse" id="navbarMenu" >
                    <ul class="navbar-nav ms-auto mb-1 mb-lg-0">
                         <li class="nav-item" >
                            <a class="nav-link active" aria-current="page" href="produk.php">Data Produk</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="#">Kategori</a>
                         </li>
                      </ul>
                 </div>

        </div>
    </nav>







    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>