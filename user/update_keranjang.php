<?php
session_start();
include '../connection.php';

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    http_response_code(401);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_keranjang = isset($_POST['id_keranjang']) ? (int)$_POST['id_keranjang'] : 0;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
    $total_price = isset($_POST['total_price']) ? (int)$_POST['total_price'] : 0;
    $id_user = (int)$_SESSION['id_user'];
    if ($id_keranjang <= 0 || $quantity <= 0) {
        http_response_code(400);
        exit();
    }

    $update_sql = "UPDATE keranjang SET quantity = ?, total_price_item = ? WHERE id_keranjang = ? AND id_user = ?";
    $update_stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($update_stmt, "iiii", $quantity, $total_price, $id_keranjang, $id_user);
    
    if (mysqli_stmt_execute($update_stmt)) {
        http_response_code(200);
        echo json_encode(['success' => true, 'message' => 'Keranjang diperbarui']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Gagal memperbarui keranjang']);
    }
    
    mysqli_stmt_close($update_stmt);
} else {
    http_response_code(405);
}
?>
