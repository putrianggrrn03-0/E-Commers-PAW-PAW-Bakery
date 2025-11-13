<?php
session_start();
include '../connection.php';

$nama = $_POST['nama_user'];
$email = $_POST['email_user'];
$alamat = $_POST ['alamat_user'];
$no_hp = $_POST ['no_hp'];
$password_plain = $_POST ['password_user'];

$password = password_hash($password_plain, PASSWORD_DEFAULT);

$sql = "INSERT INTO user (nama_user,email_user,password_user,no_hp,alamat_user)
VALUES ('$nama','$email','$password','$no_hp','$alamat')";

$check = mysqli_query($conn, $sql);
if (!$check){
    echo "<script>alert('Gagal Register');</script>";
} else {
    $sql = "SELECT * FROM user WHERE email_user = '$email'";
    $user = mysqli_query($conn, $sql);

    $data = mysqli_fetch_assoc($user);

    $_SESSION['id_user'] = $data['id_user'];
    $_SESSION['nama_user'] = $data['nama_user'];
    $_SESSION['email_user'] = $data['email_user'];

    header("Location: ../index.php");
}
