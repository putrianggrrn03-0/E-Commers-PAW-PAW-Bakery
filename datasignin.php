<?php
session_start();
include 'connection.php';

$email = $_POST['email_user'];
$password = $_POST ['password_user'];

$sql = "SELECT * FROM user WHERE email_user = '$email'";
$data = mysqli_query($conn, $sql);

$user = mysqli_fetch_assoc($data);
var_dump($user);
if (password_verify( $password, $user['password_user'])) {
    $_SESSION['id_user'] = $user['id_user'];
    $_SESSION['nama_user'] = $user['nama_user'];
    $_SESSION['email_user'] = $user['email_user'];

    header("Location: index.php");
} else {
     echo "<script>alert('Gagal Login');</script>";
}
