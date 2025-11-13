<?php
session_start();
include '../connection.php';

if (!isset($_SESSION['id_user'])) {
  header('Location: ../index.php');
  exit();
}

$id_user = (int)$_SESSION['id_user'];
$id_transaksi = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id_transaksi <= 0) {
  echo 'Invalid transaction id';
  exit();
}

// Fetch transaksi
$sql = "SELECT * FROM transaksi WHERE id_transaksi = ? AND id_user = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'ii', $id_transaksi, $id_user);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($res) === 0) {
  echo 'Transaksi tidak ditemukan.';
  exit();
}
$t = mysqli_fetch_assoc($res);

// fetch user details for the invoice (use id_user from transaksi if present)
$invoice_user = ['nama_user' => '', 'email_user' => '', 'alamat_user' => ''];
$uid = isset($t['id_user']) ? (int)$t['id_user'] : $id_user;
$ustm = mysqli_prepare($conn, "SELECT nama_user, email_user, alamat_user FROM user WHERE id_user = ? LIMIT 1");
if ($ustm) {
  mysqli_stmt_bind_param($ustm, 'i', $uid);
  mysqli_stmt_execute($ustm);
  $ures = mysqli_stmt_get_result($ustm);
  if ($ures && mysqli_num_rows($ures) > 0) {
    $invoice_user = mysqli_fetch_assoc($ures);
  }
  mysqli_stmt_close($ustm);
}

// Prefer produk_snapshot; otherwise parse produk_ids
$items = [];
if (!empty($t['produk_snapshot'])) {
  $decoded = json_decode($t['produk_snapshot'], true);
  if (is_array($decoded)) {
    $items = $decoded;
  }
} elseif (!empty($t['produk_ids'])) {
  $parts = explode(',', $t['produk_ids']);
  $ids = array_map('intval', array_filter(array_map('trim', $parts)));
  if (count($ids) > 0) {
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $sqlp = "SELECT id_produk, nama_produk, harga, gambar FROM produk WHERE id_produk IN ($placeholders)";
    $stmtp = mysqli_prepare($conn, $sqlp);
    if ($stmtp) {
      $types = str_repeat('i', count($ids));
      $bind_names[] = & $types;
      for ($i = 0; $i < count($ids); $i++) {
        $bind_name = 'b' . $i;
        $$bind_name = $ids[$i];
        $bind_names[] = &$$bind_name;
      }
      call_user_func_array(array($stmtp, 'bind_param'), $bind_names);
      mysqli_stmt_execute($stmtp);
      $resp = mysqli_stmt_get_result($stmtp);
      while ($r = mysqli_fetch_assoc($resp)) {
        $items[] = $r;
      }
      mysqli_stmt_close($stmtp);
      unset($bind_names);
    }
  }
}

// Build invoice HTML (embedded CSS so Dompdf will render consistently)
ob_start();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Invoice #<?php echo htmlspecialchars($t['id_transaksi']); ?></title>
  <style>
    /* Dompdf-friendly invoice styles */
    @page { size: A4; margin: 20mm; }
    body { font-family: 'DejaVu Sans', Arial, Helvetica, sans-serif; color: #222; margin: 0; padding: 0; }
    .invoice-wrap { width: 100%; max-width: 800px; margin: 0 auto; padding: 16px; }

    /* Header uses table layout for widest Dompdf compatibility */
    .header-table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
    .header-table td { vertical-align: top; }
    .company { font-size: 26px; font-weight: 700; color: #2b2b2b; text-transform: capitalize; }
    .company-sub { display: block; font-size: 11px; color: #666; margin-top: 4px }
    .meta { text-align: right; font-size: 12px; color: #333 }
    .meta .title { font-weight: 600; margin-bottom: 6px }

    /* Items table */
    table.items { width: 100%; border-collapse: collapse; margin-top: 8px; font-size: 12px }
    table.items th, table.items td { border: 1px solid #ddd; padding: 8px; }
    table.items th { background: #f0f0f0; text-align: left; }
    .text-right { text-align: right }
    tfoot td { font-weight: 700; }

    /* Notes and footer */
    .notes { margin-top: 14px; font-size: 12px; color: #444 }
    .footer { text-align: center; font-size: 11px; color: #777; margin-top: 20px }

    /* Logo (if provided) */
    .logo { max-width: 120px; height: auto; }

    /* Avoid page-break inside rows */
    tr { page-break-inside: avoid; }
  </style>
</head>
<body>
  <div class="invoice-wrap">
    <div class="header">
      <table class="header-table">
        <tr>
          <td style="width:60%">
            <div class="company">PAW PAW Bakery</div>
            <div class="company-sub">Jl. Mawar No.12 · Paw City · Telp: 0812-3456-7890</div>

            <div class="bill-to" style="margin-top:12px;">
              <div style="font-weight:600; margin-bottom:6px;">Kepada:</div>
              <div><?php echo htmlspecialchars($invoice_user['nama_user'] ?: ($t['nama_user'] ?? 'Pelanggan')); ?></div>
              <div style="margin-top:6px; color:#555; font-size:13px">Alamat: <?php echo nl2br(htmlspecialchars($invoice_user['alamat_user'] ?? '')); ?></div>
              <div style="margin-top:6px; color:#666; font-size:13px">Email: <?php echo htmlspecialchars($invoice_user['email_user'] ?? ''); ?></div>
            </div>
          </td>
          <td style="width:40%" class="meta">
            <div class="title">Invoice</div>
            <div>Invoice #: <?php echo htmlspecialchars($t['id_transaksi']); ?></div>
            <div>Tanggal: <?php echo date('Y-m-d H:i', strtotime($t['created_at'] ?? date('Y-m-d H:i'))); ?></div>
            <div>Pembayaran: <?php echo htmlspecialchars($t['payment']); ?></div>
            <div>Status: <?php echo htmlspecialchars($t['status']); ?></div>
          </td>
        </tr>
      </table>
    </div>

    <table class="items">
      <thead>
        <tr>
          <th style="width:5%">No</th>
          <th style="width:55%">Produk</th>
          <th style="width:10%">Qty</th>
          <th style="width:15%" class="text-right">Harga</th>
          <th style="width:15%" class="text-right">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $i = 1; $sum = 0;
          foreach ($items as $it):
            $qty = isset($it['quantity']) ? (int)$it['quantity'] : (isset($it['qty']) ? (int)$it['qty'] : 1);
            $harga = isset($it['harga']) ? (float)$it['harga'] : (isset($it['price']) ? (float)$it['price'] : 0);
            $subtotal = isset($it['subtotal']) ? (float)$it['subtotal'] : $harga * $qty;
            $sum += $subtotal;
        ?>
        <tr>
          <td><?php echo $i++; ?></td>
          <td><?php echo htmlspecialchars($it['nama_produk'] ?? ($it['nama'] ?? ($it['title'] ?? 'Produk'))); ?></td>
          <td><?php echo $qty; ?></td>
          <td class="text-right">Rp<?php echo number_format($harga, 0, ',', '.'); ?></td>
          <td class="text-right">Rp<?php echo number_format($subtotal, 0, ',', '.'); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4" class="text-right">Total</td>
          <td class="text-right">Rp<?php echo number_format((float)$t['total'], 0, ',', '.'); ?></td>
        </tr>
      </tfoot>
    </table>

    <div class="notes">
      <p>Terima kasih telah berbelanja di paw paw. Jika ada pertanyaan mengenai pesanan ini, silakan hubungi customer service kami.</p>
    </div>

    <div class="footer">PAW PAW Bakery &middot; Thank you for your purchase</div>
  </div>
</body>
</html>
<?php
$invoiceHtml = ob_get_clean();

// Try to generate PDF with Dompdf if installed via Composer (vendor/autoload.php)
$autoload = __DIR__ . '/../vendor/autoload.php';
if (file_exists($autoload)) {
  require_once $autoload;
}

if (class_exists('\Dompdf\Dompdf')) {
  try {
    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($invoiceHtml);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $pdfName = 'invoice_' . $t['id_transaksi'] . '.pdf';
    // Stream inline (Attachment => 0) so browser previews PDF in a new tab instead of forcing download
    $dompdf->stream($pdfName, ['Attachment' => 0]);
    exit();
  } catch (Exception $e) {
    error_log('Dompdf error: ' . $e->getMessage());
    echo $invoiceHtml;
    exit();
  }
} else {
  echo $invoiceHtml;
  exit();
}

