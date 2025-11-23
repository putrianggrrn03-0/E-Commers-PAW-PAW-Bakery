<?php
session_start();
include '../connection.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: ../index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paw Profile</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">PAW PAW</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="produk.php">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kontak.php">Contact</a>
                    </li>
                </ul>

                <form class="d-flex mx-lg-3 my-2 my-lg-0" role="search">
                    <input class="form-control" size="30" type="search" placeholder="Search..." aria-label="Search">
                </form>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="pesanan.php">Pesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="keranjang.php">Keranjang</a>
                    </li>
                    <li class="nav-item d-flex align-items-center">

                        <?php
                        if (isset($_SESSION['nama_user'])) {
                            echo '<div class="dropdown mt-1">
                            <button class="btn btn-sm btn-outline-light" type="button" style="font-weight: 600;" data-bs-toggle="dropdown" aria-expanded="false">'
                                . htmlspecialchars($_SESSION['nama_user']) .
                                '</button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item text-black" href="user/profil.php">Profil</a></li>
                                <li><a class="dropdown-item text-black" href="user/logout.php">Log Out</a></li>
                            </ul>
                            </div>';
                        } else {
                            echo '<a class="nav-link" data-bs-toggle="modal" data-bs-target="#exampleModal2" style="font-weight: 700;"><b>Sign in</b></a>';
                            echo '<a class="nav-link" data-bs-toggle="modal" data-bs-target="#exampleModal" style="font-weight: 700;"><b>Register</b></a>';
                        }
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Modal Register -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">REGISTER</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="register" action="dataregister.php" method="post">
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama_user" id="nama" aria-describedby="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email_user" id="email" aria-describedby="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="textarea" class="form-control" name="alamat_user" id="alamat" aria-describedby="alamat" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No Handphone</label>
                            <input type="number" class="form-control" name="no_hp" id="no_hp" aria-describedby="no_hp" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" name="password_user" class="form-control" id="exampleInputPassword1" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Sign Up</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal login -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">SIGN IN</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="signin" action="datasignin.php" method="post">
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email_user" id="email" aria-describedby="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password_user" id="exampleInputPassword1" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Log in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="profile-page">
        <div class="profile-container">
            <div class="profile-card">
                <div class="avatar-wrap">
                    <?php
                    $id_user = (int)$_SESSION['id_user'];
                    // fetch user details
                    $stmt = mysqli_prepare($conn, "SELECT nama_user, email_user, alamat_user FROM user WHERE id_user = ? LIMIT 1");
                    mysqli_stmt_bind_param($stmt, 'i', $id_user);
                    mysqli_stmt_execute($stmt);
                    $res = mysqli_stmt_get_result($stmt);
                    $user = mysqli_fetch_assoc($res);

                    // find profile image by glob (profile_{id}.*) in ../img
                    $imgDir = __DIR__ . '/../img/';
                    $found = glob($imgDir . 'profile_' . $id_user . '.*');
                    // default local svg (preferred) or fallback placeholder
                    $defaultSvgLocal = $imgDir . 'default_profile.svg';
                    $defaultSvgUrl = '../img/default_profile.svg';
                    $placeholder = 'https://via.placeholder.com/140?text=User';

                    if ($found && count($found) > 0) {
                        // use first match
                        $fname = basename($found[0]);
                        $profileUrl = '../img/' . $fname;
                    } elseif (file_exists($defaultSvgLocal)) {
                        $profileUrl = $defaultSvgUrl;
                    } else {
                        $profileUrl = $placeholder;
                    }
                    ?>
                    <img id="profile-pic" class="profile-avatar" src="<?php echo $profileUrl; ?>" alt="Profile Picture">
                    <button class="avatar-edit" id="editAvatar" title="Ubah foto">&#x1F4F7;</button>
                </div>
                <h2 id="userName"><?php echo isset($user['nama_user']) ? htmlspecialchars($user['nama_user']) : 'User'; ?></h2>
                <p class="profile-email"><?php echo isset($user['email_user']) ? htmlspecialchars($user['email_user']) : ''; ?></p>
                <p class="profile-address"><?php echo isset($user['alamat_user']) ? nl2br(htmlspecialchars($user['alamat_user'])) : ''; ?></p>

                <form id="uploadForm" action="upload_profile.php" method="post" enctype="multipart/form-data" style="display:none;">
                    <input type="file" name="avatar" id="avatarInput" accept="image/*">
                </form>

                <div class="menu">
                    <button class="btn-primary" onclick="window.location.href='pesanan.php'">Lihat Pesanan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('editAvatar').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('avatarInput').click();
        });

        document.getElementById('avatarInput').addEventListener('change', function(e) {
            var file = this.files[0];
            if (!file) return;
            if (file.size > 2 * 1024 * 1024) {
                alert('File terlalu besar (max 2MB)');
                return;
            }
            var allowed = ['image/jpeg', 'image/png', 'image/gif'];
            if (allowed.indexOf(file.type) === -1) {
                alert('Hanya file gambar (jpg, png, gif) yang diperbolehkan');
                return;
            }

            var fd = new FormData();
            fd.append('avatar', file);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'upload_profile.php', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        var res = JSON.parse(xhr.responseText);
                    } catch (err) {
                        res = null;
                    }
                    if (res && res.success) {
                        document.getElementById('profile-pic').src = res.url + '?t=' + Date.now();
                    } else {
                        alert((res && res.message) ? res.message : 'Upload gagal');
                    }
                } else {
                    alert('Upload gagal, server error');
                }
            };
            xhr.send(fd);
        });
    </script>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../navbar-mobile.js"></script>
</html>