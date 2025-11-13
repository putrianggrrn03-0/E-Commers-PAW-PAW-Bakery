<?php
session_start();
include '../connection.php';

$email = $_POST['email_admin'];
$password = $_POST ['password_admin'];

$sql = "SELECT * FROM admin WHERE email_admin = '$email'";
$data = mysqli_query($conn, $sql);

$admin = mysqli_fetch_assoc($data);
var_dump($admin);
if ($password === $admin['password_admin']) {
    $_SESSION['id_admin'] = $admin['id_admin'];
    $_SESSION['nama_admin'] = $admin['nama_admin'];
    $_SESSION['email_admin'] = $admin['email_admin'];

    header("Location: dasboard.php");
} else {
     echo "<script>alert('Gagal Login');</script>";
}
