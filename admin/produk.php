<?php
session_start();
include '../connection.php';

if (!isset($_SESSION['id_admin'])) {
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
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

        <h2 class="text-center">Daftar Stok</h2>
        <div class="d-flex justify-content-end me-5">
            <button data-bs-toggle="modal" data-bs-target="#tambahProduk">
                ADD PRODUK
            </button>
        </div>
    
    <div class="modal fade" id="tambahProduk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">ADD PRODUK</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="tambahProduk" action="addproduk.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="nama produk" class="form-label">Nama_produk</label>
                            <input type="text" class="form-control" name="nama_produk" id="nama" aria-describedby="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="text" class="form-control" name="harga" id="harga" aria-describedby="harga" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <input type="textarea" class="form-control" name="deskripsi" id="deskripsi" aria-describedby="deskripsi" required>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" name="stok" id="stok" aria-describedby="stok" required>
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <input type="text" name="kategori" class="form-control" id="kategori"  aria-describedby="kategori" required>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control" name="gambar" id="gambar" aria-describedby="gambar" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <table class="table">
  <thead class="thead-dark">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Deskripsi</th>
            <th>Stok</th>
            <th>Kategori</th>
            <th>gambar</th>
        </tr>
  </thead>
  <tbody>
    <?php include 'dataproduk.php'; ?>
  </tbody>
</table>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>