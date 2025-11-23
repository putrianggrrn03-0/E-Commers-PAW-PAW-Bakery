<?php 
session_start();
include '../connection.php';

// Pastikan user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: ../index.php");
    exit();
}

$id_user = $_SESSION['id_user']; // ambil ID user dari session
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>History Pesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

  <div class="container mt-4">

    <div class="tab-content">

      <div class="tab-pane fade show active" id="selesai" role="tabpanel" aria-labelledby="tab-selesai">
        <?php 
        $sql = "SELECT t.id_transaksi, t.produk_ids, t.produk_snapshot, t.total AS total_price_item, t.status, t.payment, t.delivery_method
        FROM transaksi t
        WHERE t.id_user = ? AND t.status = 'selesai'
        ORDER BY t.id_transaksi DESC";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_user);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $products = [];
            if (!empty($row['produk_snapshot'])) {
              $decoded = json_decode($row['produk_snapshot'], true);
              if (is_array($decoded)) {
                foreach ($decoded as $p) {
                  $products[] = [
                    'id_produk' => isset($p['id_produk']) ? $p['id_produk'] : (isset($p['id']) ? $p['id'] : null),
                    'nama_produk' => isset($p['nama_produk']) ? $p['nama_produk'] : (isset($p['nama']) ? $p['nama'] : ''),
                    'harga' => isset($p['harga']) ? $p['harga'] : (isset($p['price']) ? $p['price'] : 0),
                    'gambar' => isset($p['gambar']) ? $p['gambar'] : '',
                    'quantity' => isset($p['quantity']) ? $p['quantity'] : (isset($p['qty']) ? $p['qty'] : 1),
                    'subtotal' => isset($p['subtotal']) ? $p['subtotal'] : null
                  ];
                }
              }
            } else {
              $prodIds = [];
              if (!empty($row['produk_ids'])) {
                $parts = explode(',', $row['produk_ids']);
                foreach ($parts as $p) {
                  $p = trim($p);
                  if ($p === '') continue;
                  $prodIds[] = (int)$p;
                }
                $prodIds = array_values(array_unique($prodIds));
              }

              if (count($prodIds) > 0) {
                $placeholders = implode(',', array_fill(0, count($prodIds), '?'));
                $sql_p = "SELECT id_produk, nama_produk, harga, gambar FROM produk WHERE id_produk IN ($placeholders)";
                $stmt_p = mysqli_prepare($conn, $sql_p);
                if ($stmt_p) {
                  $types = str_repeat('i', count($prodIds));
                  $bind_names = [];
                  $bind_names[] = & $types;
                  for ($i = 0; $i < count($prodIds); $i++) {
                    $bind_name = 'bind' . $i;
                    $$bind_name = $prodIds[$i];
                    $bind_names[] = &$$bind_name;
                  }
                  call_user_func_array(array($stmt_p, 'bind_param'), $bind_names);
                  mysqli_stmt_execute($stmt_p);
                  $res_p = mysqli_stmt_get_result($stmt_p);
                  while ($rprod = mysqli_fetch_assoc($res_p)) {
                    $products[] = $rprod;
                  }
                  mysqli_stmt_close($stmt_p);
                  unset($bind_names);
                }
              }
            }
        ?>
            <div class="order-card">
              <div class="order-header">
                <div>
                  <div class="order-meta">Order #<strong><?= $row['id_transaksi']; ?></strong> &middot; <span class="small-muted"><?php echo isset($row['created_at']) ? date('Y-m-d H:i', strtotime($row['created_at'])) : '-'; ?></span></div>
                </div>
                <div>
                  <?php $st = strtolower($row['status']); ?>
                  <?php if ($st === 'selesai'): ?>
                    <span class="badge-status badge-success">Selesai</span>
                  <?php elseif ($st === 'pending'): ?>
                    <span class="badge-status badge-pending">Pending</span>
                  <?php else: ?>
                    <span class="badge-status badge-cancel"><?= htmlspecialchars(ucfirst($row['status'])); ?></span>
                  <?php endif; ?>
                </div>
              </div>

              <?php if (count($products) > 0): ?>
                <?php foreach ($products as $prod): ?>
                  <div class="d-flex align-items-center mb-3">
                    <img src="../img/<?= htmlspecialchars($prod['gambar']); ?>" alt="produk" class="product-img me-3">
                    <div class="flex-grow-1">
                      <div class="fw-semibold"><?= htmlspecialchars($prod['nama_produk']); ?></div>
                      <div class="small-muted">Qty: <?= isset($prod['quantity']) ? (int)$prod['quantity'] : 1; ?></div>
                    </div>
                    <div class="text-end">
                      <div>Rp<?= number_format(isset($prod['harga'])?$prod['harga']:0, 0, ',', '.'); ?></div>
                      <?php if (!empty($prod['subtotal'])): ?>
                        <div class="small-muted">Subtotal: Rp<?= number_format($prod['subtotal'],0,',','.'); ?></div>
                      <?php endif; ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                  <div class="d-flex justify-content-center mt-5">
                    <div class="alert alert-light border text-center" style="max-width:640px;">
                      <h5 class="mb-1">Produk tidak ditemukan</h5>
                      <p class="mb-2 small text-muted">Mungkin sudah dihapus atau belum ada pesanan. Silakan lihat produk kami dan mulailah berbelanja.</p>
                      <a href="produk.php" class="btn btn-cream">Lihat Produk</a>
                    </div>
                  </div>
              <?php endif; ?>

              <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="small-muted">Pembayaran: <?= htmlspecialchars($row['payment']); ?> &middot; <?= htmlspecialchars($row['delivery_method']); ?></div>
                <div class="text-end">
                  <div class="fw-semibold">Total: Rp<?= number_format($row['total_price_item'], 0, ',', '.'); ?></div>
                </div>
              </div>

              <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="produk.php" class="btn btn-cream" title="Beli Lagi">Beli Lagi</a>
                <button class="btn btn-outline-cream btn-download-invoice" data-transaksi-id="<?= $row['id_transaksi']; ?>">Unduh PDF</button>
                <button class="btn btn-danger btn-delete-transaksi" data-transaksi-id="<?= $row['id_transaksi']; ?>">Hapus</button>
              </div>
            </div>
        <?php 
          }
        } else {
          echo "<div class='mb-3 text-center'>Produk tidak ditemukan.</div>";
        }
        ?>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('click', function(e) {
      if (e.target && e.target.classList.contains('btn-delete-transaksi')) {
        var btn = e.target;
        var id = btn.getAttribute('data-transaksi-id');
        if (!confirm('Yakin ingin menghapus riwayat transaksi ini?')) return;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_transaksi.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
          try { var res = JSON.parse(xhr.responseText); } catch (err) { res = null; }
          if (xhr.status === 200 && res && res.success) {
            var card = btn.closest('.order-card');
            if (card) card.remove();
          } else {
            alert((res && res.message) ? res.message : 'Gagal menghapus transaksi');
          }
        };
        xhr.send('id_transaksi=' + encodeURIComponent(id));
      }

      if (e.target && e.target.classList.contains('btn-download-invoice')) {
        var id = e.target.getAttribute('data-transaksi-id');
        var url = 'invoice_print.php?id=' + encodeURIComponent(id);
        window.open(url, '_blank');
      }
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../navbar-mobile.js"></script>
</body>
</html>
