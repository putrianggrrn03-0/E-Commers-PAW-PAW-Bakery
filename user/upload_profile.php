<?php
session_start();
include '../connection.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['id_user'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$id_user = (int)$_SESSION['id_user'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'No file uploaded or upload error']);
    exit();
}

$file = $_FILES['avatar'];

// Basic validations
$maxSize = 2 * 1024 * 1024; // 2MB
if ($file['size'] > $maxSize) {
    echo json_encode(['success' => false, 'message' => 'File terlalu besar (max 2MB)']);
    exit();
}

$info = getimagesize($file['tmp_name']);
if ($info === false) {
    echo json_encode(['success' => false, 'message' => 'File bukan gambar valid']);
    exit();
}

$mime = $info['mime'];
$allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'];
if (!isset($allowed[$mime])) {
    echo json_encode(['success' => false, 'message' => 'Tipe file tidak diizinkan']);
    exit();
}

$ext = $allowed[$mime];
$targetDir = __DIR__ . '/../img/';
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

// remove existing profile files for this user
$pattern = $targetDir . 'profile_' . $id_user . '.*';
foreach (glob($pattern) as $old) {
    @unlink($old);
}

$targetName = 'profile_' . $id_user . '.' . $ext;
$targetPath = $targetDir . $targetName;

if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan file']);
    exit();
}

// Optional: set permissions
@chmod($targetPath, 0644);

$url = '../img/' . $targetName;

echo json_encode(['success' => true, 'url' => $url]);
exit();
