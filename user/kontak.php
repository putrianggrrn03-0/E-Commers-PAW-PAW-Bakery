<?php
session_start();
include '../connection.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #fffdf9;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .contact-page {
            max-width: 900px; /* agar semua lebih kecil dan ditengah */
            margin: 40px auto;
            padding: 20px;
        }

        .contact-title {
            font-size: 36px;
            font-weight: 700;
            color: #4e342e;
            margin-bottom: 10px;
        }

        .contact-subtitle {
            color: #6d4c41;
            margin-bottom: 40px;
        }

        /* Kotak info + form ditengah */
        .contact-container {
            max-width: 900px;
            margin: auto;
            display: flex;
            flex-direction: column;
            gap: 25px;
            justify-content: center;
            align-items: center;
        }

        /* Info Box */
        .contact-info-box {
            width: 100%;
            background: #f7eee6;
            padding: 25px;
            border-radius: 18px;
            color: #4e342e;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .contact-info-box h3 {
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            gap: 8px;
        }

        .info-item i {
            font-size: 20px;
            color: #4e342e;
        }

        /* Form */
        .contact-form {
            width: 100%;
            background: #ffffff;
            padding: 25px;
            border-radius: 18px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            text-align: left; /* isi tetap rata kiri agar tidak aneh */
        }

        .contact-form h3 {
            color: #4e342e;
            margin-bottom: 15px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: 600;
            color: #4e342e;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            border: 1px solid #c7b9a6;
            margin-top: 5px;
        }

        .btn-send {
            width: 100%;
            padding: 12px;
            background: #4e342e;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 12px;
            cursor: pointer;
            transition: .3s;
        }

        .btn-send:hover {
            background: #3e2723;
        }

        /* Map */
        .map-box {
            margin-top: 35px;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .map-box iframe {
            width: 100%;
            height: 350px;
            border: 0;
        }
    </style>

</head>

<body>

    <section class="contact-page">
        <h2 class="contact-title">Hubungi Kami</h2>
        <p class="contact-subtitle">Kami selalu siap membantu segala kebutuhanmu ❤️</p>

        <div class="contact-container">

            <!-- Info -->
            <div class="contact-info-box">
                <h3>Informasi Kontak</h3>

                <div class="info-item">
                    <i class="bi bi-geo-alt-fill"></i>
                    <p>Sei.Selapian No.13-15, Medan</p>
                </div>

                <div class="info-item">
                    <i class="bi bi-envelope-fill"></i>
                    <p>paaw.paww.id@gmail.com</p>
                </div>

                <div class="info-item">
                    <i class="bi bi-instagram"></i>
                    <p>paaww.paww_</p>
                </div>

                <div class="info-item">
                    <i class="bi bi-telephone-fill"></i>
                    <p>+62 812 6423 9824</p>
                </div>

                <div class="info-item">
                    <i class="bi bi-clock-fill"></i>
                    <p>09.00 – 20.00 WIB</p>
                </div>
            </div>

            <!-- Form -->
            <form class="contact-form">
                <h3>Kirim Pesan</h3>

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" placeholder="Masukkan nama kamu">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email"  placeholder="Masukkan email kamu">
                </div>

                <div class="form-group">
                    <label>Pesan</label>
                    <textarea rows="4" placeholder="Tulis pesan kamu..."></textarea>
                </div>

                <button type="submit" class="btn-send">Kirim Sekarang</button>
            </form>
        </div>


    </section>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
