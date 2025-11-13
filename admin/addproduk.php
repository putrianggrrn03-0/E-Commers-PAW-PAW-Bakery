<?php
session_start();
include '../connection.php';

$nama = $_POST['nama_produk'];
$harga = $_POST['harga'];
$deskripsi = $_POST ['deskripsi'];
$stok = $_POST ['stok'];
$kategori = $_POST ['kategori'];

if (isset($_FILES["gambar"]) && $_FILES["gambar"]["error"] == 0) {
        $targetdir = "../img/";
        $img = $targetdir . basename($_FILES["gambar"]["name"]);
        // Move the uploaded file
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $img)) {
            $insert_query = "INSERT INTO produk (nama_produk,harga,deskripsi,stok,kategori,gambar) 
                        VALUES ('$nama','$harga','$deskripsi','$stok','$kategori','$img')";

            if (mysqli_query($conn, $insert_query)) {
                echo "<script>alert('Produk berhasil ditambahkan!');</script>";
                header("Location: produk.php");
            } else {
                echo "Error: " . $insert_query . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "File upload failed.";
        }
    } else {
        echo "No file uploaded or there was an upload error.";
    }