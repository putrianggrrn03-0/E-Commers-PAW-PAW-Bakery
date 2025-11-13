<?php
session_start();
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay_now'])) {
  if (!isset($_SESSION['id_user'])) {
    header("Location: ../index.php");
    exit();
  }

  $id_user = $_SESSION['id_user'];

    $delivery_method = isset($_POST['delivery']) ? $_POST['delivery'] : 'Delivery';
    $payment = isset($_POST['payment']) ? $_POST['payment'] : 'Cash';

    $sql_cart = "SELECT k.id_keranjang, k.id_produk, k.total_price_item, k.quantity, p.nama_produk, p.harga, p.gambar
      FROM keranjang k
      JOIN produk p ON k.id_produk = p.id_produk
      WHERE k.id_user = ?";
    $stmt_cart = mysqli_prepare($conn, $sql_cart);
    mysqli_stmt_bind_param($stmt_cart, "i", $id_user);
    mysqli_stmt_execute($stmt_cart);
    $res_cart = mysqli_stmt_get_result($stmt_cart);

    $total = 0;
    $productIds = [];
    $snapshot = [];
    while ($r = mysqli_fetch_assoc($res_cart)) {
      if (isset($r['id_produk'])) {
        $productIds[] = $r['id_produk'];
      }
      $total += $r['total_price_item'];
      $snapshot[] = [
        'id_produk' => (int)$r['id_produk'],
        'nama_produk' => $r['nama_produk'],
        'harga' => (float)$r['harga'],
        'quantity' => (int)$r['quantity'],
        'subtotal' => (float)$r['total_price_item'],
        'gambar' => $r['gambar']
      ];
    }

    if (count($productIds) === 0) {
      header("Location: checkout.php?error=emptycart");
      exit();
    }

    $id_keranjang_str = implode(',', $productIds);

    $status = 'selesai';

    $produk_snapshot_json = json_encode($snapshot);

    $snapshot_col = false;
    $res_check = mysqli_query($conn, "SHOW COLUMNS FROM `transaksi` LIKE 'produk_snapshot'");
    if ($res_check && mysqli_num_rows($res_check) > 0) {
      $snapshot_col = true;
    }

    $ids_csv = $id_keranjang_str;

    // Start DB transaction to ensure consistency when decrementing stock and inserting transaksi
    mysqli_begin_transaction($conn);
    $ok = true;
    $errorMessage = '';

    // Decrement stok for each product based on quantity in $snapshot
    $update_sql = "UPDATE produk SET stok = stok - ? WHERE id_produk = ? AND stok >= ?";
    $stmt_update = mysqli_prepare($conn, $update_sql);
    if (!$stmt_update) {
      $ok = false;
      $errorMessage = 'Failed to prepare stock update.';
    }

    if ($ok) {
      foreach ($snapshot as $item) {
        $pid = (int)$item['id_produk'];
        $qty = (int)$item['quantity'];
        if ($qty <= 0) continue;
        mysqli_stmt_bind_param($stmt_update, 'iii', $qty, $pid, $qty);
        if (!mysqli_stmt_execute($stmt_update)) {
          $ok = false;
          $errorMessage = 'Gagal mengurangi stok untuk produk ID ' . $pid;
          break;
        }
        // ensure a row was affected (stock was sufficient)
        if (mysqli_stmt_affected_rows($stmt_update) === 0) {
          $ok = false;
          $errorMessage = 'Stok tidak cukup untuk produk ID ' . $pid;
          break;
        }
      }
    }

    if ($ok) {
      // Insert transaksi record
      if ($snapshot_col) {
        $sql_insert = "INSERT INTO transaksi (produk_ids, produk_snapshot, id_user, total, delivery_method, payment, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = mysqli_prepare($conn, $sql_insert);
        if (!$stmt_insert) {
          $ok = false;
          $errorMessage = 'Failed to prepare transaksi insert.';
        } else {
          mysqli_stmt_bind_param($stmt_insert, "ssidsss", $ids_csv, $produk_snapshot_json, $id_user, $total, $delivery_method, $payment, $status);
          if (!mysqli_stmt_execute($stmt_insert)) {
            $ok = false;
            $errorMessage = 'Gagal menyimpan transaksi.';
          }
        }
      } else {
        $sql_insert = "INSERT INTO transaksi (produk_ids, id_user, total, delivery_method, payment, status) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_insert = mysqli_prepare($conn, $sql_insert);
        if (!$stmt_insert) {
          $ok = false;
          $errorMessage = 'Failed to prepare transaksi insert (fallback).';
        } else {
          mysqli_stmt_bind_param($stmt_insert, "sidsss", $ids_csv, $id_user, $total, $delivery_method, $payment, $status);
          if (!mysqli_stmt_execute($stmt_insert)) {
            $ok = false;
            $errorMessage = 'Gagal menyimpan transaksi (fallback).';
          }
        }
      }
    }

    if ($ok) {
      // Clear user's cart
      $del_stmt = mysqli_prepare($conn, "DELETE FROM keranjang WHERE id_user = ?");
      if ($del_stmt) {
        mysqli_stmt_bind_param($del_stmt, 'i', $id_user);
        mysqli_stmt_execute($del_stmt);
        mysqli_stmt_close($del_stmt);
      }
      mysqli_commit($conn);
      header("Location: ../index.php?checkout=success");
      exit();
    } else {
      mysqli_rollback($conn);
      error_log('Checkout failed: ' . $errorMessage);
      header("Location: checkout.php?error=" . urlencode($errorMessage));
      exit();
    }
  }
