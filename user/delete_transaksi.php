<?php
session_start();
include '../connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id_user'])) {
  http_response_code(401);
  echo json_encode(['success' => false, 'message' => 'User not logged in']);
  exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['success' => false, 'message' => 'Method not allowed']);
  exit();
}

$id_user = (int)$_SESSION['id_user'];
$id_transaksi = isset($_POST['id_transaksi']) ? (int)$_POST['id_transaksi'] : 0;

if ($id_transaksi <= 0) {
  http_response_code(400);
  echo json_encode(['success' => false, 'message' => 'Invalid transaction id']);
  exit();
}

// Delete only if transaksi belongs to this user
$sql = "DELETE FROM transaksi WHERE id_transaksi = ? AND id_user = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'ii', $id_transaksi, $id_user);
if (!mysqli_stmt_execute($stmt)) {
  http_response_code(500);
  echo json_encode(['success' => false, 'message' => 'Gagal menghapus transaksi']);
  exit();
}

echo json_encode(['success' => true, 'message' => 'Transaksi dihapus']);
exit();

?>
