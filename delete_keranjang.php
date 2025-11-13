<?php
session_start();
include 'connection.php';

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    http_response_code(401);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_keranjang = isset($_POST['id_keranjang']) ? (int)$_POST['id_keranjang'] : 0;
    $id_user = (int)$_SESSION['id_user'];

    // Validasi
    if ($id_keranjang <= 0) {
        http_response_code(400);
        exit();
    }

    // Delete item dari keranjang dengan prepared statement
    $delete_sql = "DELETE FROM keranjang WHERE id_keranjang = ? AND id_user = ?";
    $delete_stmt = mysqli_prepare($conn, $delete_sql);
    mysqli_stmt_bind_param($delete_stmt, "ii", $id_keranjang, $id_user);
    
    if (mysqli_stmt_execute($delete_stmt)) {
        http_response_code(200);
        echo json_encode(['success' => true, 'message' => 'Item dihapus dari keranjang']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Gagal menghapus item']);
    }
    
    mysqli_stmt_close($delete_stmt);
} else {
    http_response_code(405);
}
?>
