<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Orderan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f3f9f4;
      font-family: 'Poppins', sans-serif;
    }
    .order-card {
      border-radius: 15px;
      background-color: #fff;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      transition: transform 0.2s ease-in-out;
    }
    .order-card:hover {
      transform: translateY(-5px);
    }
    .status {
      border-radius: 10px;
      padding: 5px 10px;
      color: white;
      font-weight: 500;
    }
    .status.pending {
      background-color: #f0ad4e;
    }
    .status.completed {
      background-color: #5cb85c;
    }
    .status.canceled {
      background-color: #d9534f;
    }
  </style>
</head>
<body>

  <div class="container my-5">
    <h2 class="text-center mb-4">🛍️ Daftar Orderan Pelanggan</h2>
    <div class="row justify-content-center">
      
      <!-- Contoh 1 -->
      <div class="col-md-4 mb-4">
        <div class="order-card p-4">
          <h5>Nama Pelanggan: <strong>Putri</strong></h5>
          <p>Produk: <strong>Salad Buah Segar</strong></p>
          <p>Jumlah: 2 Porsi</p>
          <p>Total: <strong>Rp30.000</strong></p>
          <p>Status: <span class="status pending">Menunggu Pembayaran</span></p>
          <button class="btn btn-success w-100 mt-3">Tandai Selesai</button>
        </div>
      </div>

      <!-- Contoh 2 -->
      <div class="col-md-4 mb-4">
        <div class="order-card p-4">
          <h5>Nama Pelanggan: <strong>Rani</strong></h5>
          <p>Produk: <strong>Cheesecake Mini</strong></p>
          <p>Jumlah: 1 Porsi</p>
          <p>Total: <strong>Rp20.000</strong></p>
          <p>Status: <span class="status completed">Selesai</span></p>
          <button class="btn btn-secondary w-100 mt-3" disabled>Selesai</button>
        </div>
      </div>

      <!-- Contoh 3 -->
      <div class="col-md-4 mb-4">
        <div class="order-card p-4">
          <h5>Nama Pelanggan: <strong>Andi</strong></h5>
          <p>Produk: <strong>Cookies Cokelat</strong></p>
          <p>Jumlah: 3 Porsi</p>
          <p>Total: <strong>Rp45.000</strong></p>
          <p>Status: <span class="status canceled">Dibatalkan</span></p>
          <button class="btn btn-danger w-100 mt-3" disabled>Dibatalkan</button>
        </div>
      </div>

    </div>
  </div>

</body>
</html>
