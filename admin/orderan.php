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
  <title>Daftar Orderan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

<?php

// fetch all transactions joined with user name
$sql = "SELECT t.*, u.nama_user, u.alamat_user FROM transaksi t LEFT JOIN user u ON t.id_user = u.id_user ORDER BY t.id_transaksi DESC";
$res = mysqli_query($conn, $sql);
?>

  <div class="container my-5">
    <h2 class="text-center mb-4">🛍️ Daftar Orderan Pelanggan</h2>

    <?php if (!$res || mysqli_num_rows($res) === 0): ?>
      <div class="alert alert-info text-center">Tidak ada orderan saat ini.</div>
    <?php else: ?>
      <div class="row">
        <?php while ($row = mysqli_fetch_assoc($res)): ?>
          <div class="col-md-6 mb-4">
            <div class="order-card p-4">
              <div class="order-header">
                <div>
                  <h5 class="mb-1">Nama Pelanggan: <strong><?php echo htmlspecialchars($row['nama_user'] ?: 'Guest'); ?></strong></h5>
                  <h5 class="mb-1">Alamat Pelanggan: <strong><?php echo htmlspecialchars($row['alamat_user'] ?: 'Guest'); ?></strong></h5>
                  <div class="order-meta">ID Transaksi: <?php echo htmlspecialchars($row['id_transaksi']); ?> • User ID: <?php echo htmlspecialchars($row['id_user']); ?></div>
                </div>
                <div>
                  <?php
                    $status = strtolower(trim($row['status'] ?? ''));
                    $badgeClass = 'badge-pending';
                    if ($status === 'selesai' || $status === 'completed') $badgeClass = 'badge-success';
                    if ($status === 'dibatalkan' || $status === 'canceled') $badgeClass = 'badge-cancel';
                  ?>
                  <span class="badge-status <?php echo $badgeClass; ?>"><?php echo htmlspecialchars($row['status'] ?: 'pending'); ?></span>
                </div>
              </div>

              <div class="mt-3">
                <strong>Produk:</strong>
                <ul class="mb-2" style="padding-left:18px;">
                  <?php
                    $printedAny = false;
                    if (!empty($row['produk_snapshot'])) {
                      $items = json_decode($row['produk_snapshot'], true);
                      if (is_array($items)) {
                        foreach ($items as $it) {
                          // try to extract name/qty/price
                          $name = $it['nama'] ?? $it['nama_produk'] ?? $it['name'] ?? ($it['title'] ?? null);
                          $qty = $it['qty'] ?? $it['quantity'] ?? $it['jumlah'] ?? 1;
                          $price = $it['harga'] ?? $it['price'] ?? $it['subtotal'] ?? null;
                          if ($name) {
                            $printedAny = true;
                            echo '<li>' . htmlspecialchars($name) . ' &times; ' . htmlspecialchars($qty);
                            if ($price) echo ' — Rp' . number_format((float)$price,0,',','.');
                            echo '</li>';
                          }
                        }
                      }
                    }
                    if (!$printedAny) {
                      // fallback to raw produk_ids or snapshot text
                      if (!empty($row['produk_ids'])) {
                        echo '<li>' . htmlspecialchars($row['produk_ids']) . '</li>';
                      } else if (!empty($row['produk_snapshot'])) {
                        echo '<li><pre style="white-space:pre-wrap;">' . htmlspecialchars($row['produk_snapshot']) . '</pre></li>';
                      } else {
                        echo '<li><em>Tidak ada detail produk</em></li>';
                      }
                    }
                  ?>
                </ul>

                <p class="mb-1"><strong>Total:</strong> Rp<?php echo number_format((float)$row['total'] ?? 0,0,',','.'); ?></p>
                <p class="mb-1"><strong>Metode Pengiriman:</strong> <?php echo htmlspecialchars($row['delivery_method'] ?? '-'); ?></p>
                <p class="mb-1"><strong>Pembayaran:</strong> <?php echo htmlspecialchars($row['payment'] ?? '-'); ?></p>
              </div>

              <div class="d-grid gap-2 mt-3">
                <a class="btn btn-outline-cream" target="_blank" href="../user/invoice_print.php?id=<?php echo urlencode($row['id_transaksi']); ?>">Lihat Invoice</a>
                <?php if ($status === 'selesai' || $status === 'completed'): ?>
                  <button class="btn btn-secondary" disabled>Selesai</button>
                <?php elseif ($status === 'dibatalkan' || $status === 'canceled'): ?>
                  <button class="btn btn-danger" disabled>Dibatalkan</button>
                <?php else: ?>
                  <form method="post" action="/admin/update_order_status.php" onsubmit="return confirm('Tandai transaksi ini sebagai selesai?');">
                    <input type="hidden" name="id_transaksi" value="<?php echo htmlspecialchars($row['id_transaksi']); ?>">
                    <input type="hidden" name="new_status" value="selesai">
                    <button class="btn btn-success">Tandai Selesai</button>
                  </form>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>

  </div>

</body>
</html>
