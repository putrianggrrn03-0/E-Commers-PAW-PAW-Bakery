<?php
session_start();
include 'connection.php';

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    $_SESSION['error'] = "Silakan login terlebih dahulu";
    header("Location: login.php");
    exit();
}

// Validasi input
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_produk = isset($_POST['produk_id']) ? (int)$_POST['produk_id'] : 0;
    $harga = isset($_POST['harga']) ? (int)$_POST['harga'] : 0;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    $id_user = (int)$_SESSION['id_user'];
    
    // Hitung total harga item
    $total_price_item = $harga * $quantity;

    // Validasi
    if ($id_produk <= 0 || $quantity <= 0 || $harga <= 0) {
        $_SESSION['error'] = "Data tidak valid";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Gunakan prepared statement untuk keamanan
    // Cek apakah produk sudah ada di keranjang user dan ambil quantity saat ini
    $check_sql = "SELECT id_keranjang, quantity FROM keranjang WHERE id_user = ? AND id_produk = ?";
    $check_stmt = mysqli_prepare($conn, $check_sql);
    if ($check_stmt === false) {
        $_SESSION['error'] = "Database error: " . mysqli_error($conn);
        header("Location: " . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'produk.php'));
        exit();
    }
    mysqli_stmt_bind_param($check_stmt, "ii", $id_user, $id_produk);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);

    if ($row_cart = mysqli_fetch_assoc($check_result)) {
        // Jika sudah ada, hitung quantity baru di PHP lalu update
        $existing_qty = (int)$row_cart['quantity'];
        $new_qty = $existing_qty + $quantity;

        // Hitung total harga item berdasarkan harga sekarang
        $new_total_price = $harga * $new_qty;

        $update_sql = "UPDATE keranjang SET quantity = ?, total_price_item = ? WHERE id_user = ? AND id_produk = ?";
        $update_stmt = mysqli_prepare($conn, $update_sql);
        if ($update_stmt === false) {
            $_SESSION['error'] = "Database error: " . mysqli_error($conn);
            mysqli_stmt_close($check_stmt);
            header("Location: " . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'produk.php'));
            exit();
        }
        mysqli_stmt_bind_param($update_stmt, "iiii", $new_qty, $new_total_price, $id_user, $id_produk);
        if (mysqli_stmt_execute($update_stmt)) {
            $_SESSION['success'] = "✅ Produk ditambahkan ke keranjang";
            mysqli_stmt_close($update_stmt);
            mysqli_stmt_close($check_stmt);
            header("Location: keranjang.php");
            exit();
        } else {
            $_SESSION['error'] = "❌ Gagal menambah produk: " . mysqli_error($conn);
            mysqli_stmt_close($update_stmt);
            mysqli_stmt_close($check_stmt);
            header("Location: " . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'produk.php'));
            exit();
        }
    } else {
        // Jika belum ada, insert data baru dengan total_price_item
        $insert_sql = "INSERT INTO keranjang (id_user, id_produk, quantity, total_price_item) VALUES (?, ?, ?, ?)";
        $insert_stmt = mysqli_prepare($conn, $insert_sql);
        if ($insert_stmt === false) {
            $_SESSION['error'] = "Database error: " . mysqli_error($conn);
            mysqli_stmt_close($check_stmt);
            header("Location: " . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'produk.php'));
            exit();
        }
        mysqli_stmt_bind_param($insert_stmt, "iiii", $id_user, $id_produk, $quantity, $total_price_item);
        
        if (mysqli_stmt_execute($insert_stmt)) {
            $_SESSION['success'] = "✅ Produk ditambahkan ke keranjang";
            mysqli_stmt_close($insert_stmt);
            mysqli_stmt_close($check_stmt);
            header("Location: keranjang.php");
            exit();
        } else {
            $_SESSION['error'] = "❌ Gagal menambah produk: " . mysqli_error($conn);
            mysqli_stmt_close($insert_stmt);
            mysqli_stmt_close($check_stmt);
            header("Location: " . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'produk.php'));
            exit();
        }
    }
    
    // Jika sampai sini (seharusnya sudah redirect di atas), tutup statement jika belum ditutup
    if ($check_stmt) {
        mysqli_stmt_close($check_stmt);
    }
}

// Jika bukan POST atau tidak ada kondisi lain, arahkan kembali ke halaman sebelumnya
header("Location: " . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'produk.php'));
exit();
?>
