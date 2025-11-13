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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin - Data Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f5f0e6; /* cream */
      color: #3e2723; /* dark brown text */
      font-family: 'Poppins', sans-serif;
    }

    .navbar {
      background-color: #4b2e05; /* dark brown */
    }

    .navbar-brand, .nav-link {
      color: #f5f0e6 !important;
    }

    .navbar-brand:hover, .nav-link:hover {
      color: #e2c49a !important;
    }

    .card {
      background-color: #fffaf2;
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    th {
      background-color: #6d4c41;
      color: #fffaf2;
    }

    footer {
      background-color: #4b2e05;
      color: #f5f0e6;
      text-align: center;
      padding: 10px 0;
      margin-top: 40px;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
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

  <!-- Konten Utama -->
  <div class="container mt-4">
    <h3 class="mb-4">Data Produk</h3>

    <div class="card p-3">
      <table class="table table-striped table-hover align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Cheesecake Strawberry</td>
            <td>Cake</td>
            <td>Rp50.000</td>
            <td>25</td>
            <td>
              <button class="btn btn-sm btn-warning text-white">Edit</button>
              <button class="btn btn-sm btn-danger">Hapus</button>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>Cookies Cokelat</td>
            <td>Cookies</td>
            <td>Rp35.000</td>
            <td>40</td>
            <td>
              <button class="btn btn-sm btn-warning text-white">Edit</button>
              <button class="btn btn-sm btn-danger">Hapus</button>
            </td>
          </tr>
        </tbody>
      </table>

      <button class="btn" style="background-color:#4b2e05; color:#f5f0e6;">+ Tambah Produk</button>
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


  <footer>
    <p>© 2025 Admin Produk | Tema Dark Brown & Cream</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
