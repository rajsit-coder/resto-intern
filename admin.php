<?php
require_once __DIR__ . '/includes/config.php';

// Simple authentication
if ($_GET['user'] !== 'admin' || $_GET['pass'] !== 'admin') {
    die("Access Denied");
}

// DB connection
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("DB connection failed: " . $e->getMessage());
}

// Fetch data from 'bookings' table
$stmt = $pdo->query("SELECT * FROM bookings");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel</title>
      <link rel="icon" href="img-offer-1.png" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #0e0e0e;
      color: white;
      background-image: url('bg-food-dark.png');
      background-size: cover;
      background-attachment: fixed;
    }

    .navbar {
      transition: background-color 0.3s ease, padding 0.3s ease;
      padding: 1.2rem 1rem;
      background-color: transparent;
    }

    .navbar-brand {
      color: #FFC107;
      font-size: 40px;
      font-family: 'Pacifico', cursive;
    }

    .navbar-brand::before {
      content: "";
      display: inline-block;
      background-image: url('img-offer-1.png');
      background-size: contain;
      background-repeat: no-repeat;
      width: 60px;
      height: 60px;
      margin-top: -10px;
      vertical-align: middle;
    }

    .navbar-brand:hover::before {
      filter: grayscale(100%);
    }

    .navbar.scrolled {
      background-color: black !important;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);
      padding: 0.6rem 1rem;
    }

    .nav-link {
      font-size: 20px;
      font-weight: 600;
      margin: 0 6px;
      color: white !important;
    }

    .nav-link:hover {
      color: #FFC107 !important;
    }

    .table-dark th, .table-dark td {
      vertical-align: middle;
    }

    .offcanvas {
      background-color: black;
      color: white;
    }

    .offcanvas .nav-link:hover {
      color: #FFC107 !important;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="index.html">₹€$₮Φ</a>

    <ul class="navbar-nav flex-row d-none d-lg-flex ms-auto">
      <li class="nav-item"><a class="nav-link px-3" href="index.html">Home</a></li>
      <li class="nav-item"><a class="nav-link px-3" href="about.html">About</a></li>
      <li class="nav-item"><a class="nav-link px-3" href="contact.php">Contact</a></li>
            <li class="nav-item"><a class="nav-link px-3" href="admin.php?user=admin&pass=admin">Admin</a></li>
    </ul>

    <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</nav>

<!-- Mobile Menu -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">₹€$₮Φ</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
      <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                  <li class="nav-item"><a class="nav-link px-3" href="admin.php?user=admin&pass=admin">Admin</a></li>
    </ul>
  </div>
</div>

<!-- Main Content -->
<div class="container mt-5 pt-5">
  <h2 class="text-warning text-center mb-4">Admin – Booking Records</h2>

  <?php if (count($rows) > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-dark table-hover text-center align-middle">
        <thead class="table-warning text-black">
          <tr>
            <?php foreach (array_keys($rows[0]) as $column): ?>
              <th><?= htmlspecialchars($column) ?></th>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $row): ?>
            <tr>
              <?php foreach ($row as $cell): ?>
                <td><?= htmlspecialchars($cell) ?></td>
              <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-warning">No records found.</div>
  <?php endif; ?>
</div>

<script>
  window.addEventListener('scroll', function () {
    const navbar = document.querySelector('.navbar');
    navbar.classList.toggle('scrolled', window.scrollY > 10);
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
