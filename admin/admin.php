<?php
session_start();
include ('../connection.php');

if (isset($_SESSION["id_admin"])) {
  header("Location:dasboard.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <!-- Bs -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <!-- Default -->
  <link rel="stylesheet" href="../style.css" />
</head>

<body class="admin-body">
  <!-- Header -->
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#957C62;">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">PAW PAW</a>
        
      </div>
    </nav>
  </header>

  <!-- Login -->
  <section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card shadow-2-strong" style="border-radius: 1rem">
            <div class="card-body p-5 text-center">
              <h3 class="mb-5">Login Admin</h3>
              <form action="loginadmin.php" method="POST" class="mb-3 form-control-lg">
                <div class="form-outline mb-4">
                  <input type="email" class="form-control form-control-lg" name="email_admin" placeholder="Email" />
                </div>

                <div class="form-outline mb-4">
                  <input type="password" class="form-control form-control-lg" name="password_admin" placeholder="Password" />
                </div>

                <button class="btn btn-warning btn-lg btn-block form-control form-control-lg" type="submit" name="login" style="color: black; background-color:#FFE1AF; border-bottom: none;">
                  Login
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Bs -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Ion Icon -->
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>