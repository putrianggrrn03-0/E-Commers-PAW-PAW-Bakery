<?php
include '../connection.php';

// Ambil semua data dari tabel pendaftar
$sql = "SELECT * FROM produk";
$result = mysqli_query($conn, $sql);

// Cek jika ada data
$number = 1;
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $number++ . "</td>";
        echo "<td>" . $row['nama_produk'] . "</td>";
        echo "<td>" . $row['harga'] . "</td>";
        echo "<td>" . $row['deskripsi'] . "</td>";
        echo "<td>" . $row['stok'] . "</td>";
        echo "<td>" . $row['kategori'] . "</td>";
        echo "<td> 
                <img src='" . $row['gambar'] . "' alt='Image Produk' width='100'>
                </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>Belum ada data pendaftar</td></tr>";
}

mysqli_close($conn);
?>
