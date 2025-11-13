<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay_now'])) {
  if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
  }

  $id_user = $_SESSION['id_user'];

    // sanitize and get methods
    $delivery_method = isset($_POST['delivery']) ? $_POST['delivery'] : 'Delivery';
    $payment = isset($_POST['payment']) ? $_POST['payment'] : 'Cash';

    // fetch all cart items for this user to compute total and collect id_keranjang
    $sql_cart = "SELECT id_keranjang, total_price_item FROM keranjang WHERE id_user = ?";
    $stmt_cart = mysqli_prepare($conn, $sql_cart);
    mysqli_stmt_bind_param($stmt_cart, "i", $id_user);
    mysqli_stmt_execute($stmt_cart);
    $res_cart = mysqli_stmt_get_result($stmt_cart);

    $total = 0;
    $ids = [];
    while ($r = mysqli_fetch_assoc($res_cart)) {
      $ids[] = $r['id_keranjang'];
      $total += $r['total_price_item'];
    }

    if (count($ids) === 0) {
      // nothing to checkout
      header("Location: checkout.php?error=emptycart");
      exit();
    }

    // store id_keranjang as comma-separated list
    $id_keranjang_str = implode(',', $ids);

    $status = 'selesai';

    // insert into transaksi
  $sql_insert = "INSERT INTO transaksi (id_keranjang, id_user, total, delivery_method, payment, status) VALUES (?, ?, ?, ?, ?, ?)";
  $stmt_insert = mysqli_prepare($conn, $sql_insert);
  if (!$stmt_insert) {
    // prepare failed
    header("Location: checkout.php?error=insertfail");
    exit();
  }
  
  mysqli_stmt_bind_param($stmt_insert, "sissss", $id_keranjang_str, $id_user, $total, $delivery_method, $payment, $status);
    $exec = mysqli_stmt_execute($stmt_insert);
    header("Location: index.php?checkout=success");
    exit();
  }