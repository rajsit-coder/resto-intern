<?php
require_once __DIR__ . '/includes/db.php';

$success = false;
$error   = "";

/* ---------- Handle POST ---------- */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name      = trim($_POST["name"] ?? "");
    $lastname  = trim($_POST["lastname"] ?? "");
    $phone     = trim($_POST["phone"] ?? "");
    $email     = trim($_POST["email"] ?? "");
    $date      = trim($_POST["date"] ?? "");
    $time      = trim($_POST["time"] ?? "");

    if ($name === "" || $lastname === "" || $phone === "" || $email === "" || $date === "" || $time === "") {
        $error = "Please fill out every field.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } elseif (!preg_match('/^(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-\d{4}$/', $date)) {
        $error = "Invalid date format. Use DD-MM-YYYY.";
    } elseif (!preg_match('/^(0[1-9]|1[0-2]):[0-5][0-9](AM|PM)$/i', $time)) {
        $error = "Invalid time format. Use hh:mmAM/PM.";
    } else {
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO bookings (name, lastname, phone, email, date, time) 
                 VALUES (:name, :lastname, :phone, :email, :date, :time)"
            );
            $stmt->execute([
                ":name"     => $name,
                ":lastname" => $lastname,
                ":phone"    => $phone,
                ":email"    => $email,
                ":date"     => $date,
                ":time"     => $time,
            ]);
            header("Location: thank-you.html");
            exit;
        } catch (PDOException $e) {
            $error = "Database error – please try again later.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact - ₹€$₮Φ</title>
      <link rel="icon" href="img-offer-1.png" type="image/png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #0e0e0e;
      color: white;
                  background-image: url('bg-pattern.jpg');
      background-repeat: repeat;
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
    .offcanvas {
      background-color: black;
      color: white;
    }
    .offcanvas .nav-link:hover {
      color: #FFC107 !important;
    }
    .form-control:focus {
      border-color: #ffc107 !important;
      box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25) !important;
    }
    
 footer {
     position: relative;
     color: white;
     overflow: hidden;
     height: 62vh;
 }
 
 footer video {
     position: absolute;
     top: 0;
     left: 0;
     width: 100%;
     height: 100%;
     object-fit: cover;
     z-index: -1;
 }
 
 .footer-content {
     padding: 50px 30px 30px;
     max-width: 800px;
 }
 
 .footer-logo h1 {
     font-size: 3.5rem;
     font-weight: bold;
     line-height: 1;
 }
 
 .footer-logo span {
     font-size: 1.2rem;
     letter-spacing: 1px;
     color: #f2a86f;
 }
 
 .footer-border {
     border-top: 1px solid rgba(255, 255, 255, 0.2);
     border-bottom: 1px solid rgba(255, 255, 255, 0.2);
     padding: 5px 0;
     margin: 5px 0;
 }
 
 .footer-note {
     display: flex;
     flex-wrap: wrap;
     gap: 30px;
     justify-content: center;
     font-size: 0.85rem;
     color: rgba(255, 255, 255, 0.6);
     padding: 30px 20px 10px;
     border-top: 1px solid rgba(255, 255, 255, 0.2);
 }
 
 .footer-social {
     display: flex;
     justify-content: center;
     gap: 30px;
     margin-top: 20px;
 }
 
 .footer-social a {
     color: rgba(255, 255, 255, 0.9);
     font-weight: bold;
     text-decoration: none;
     text-transform: uppercase;
     font-size: 0.85rem;
     display: flex;
     align-items: center;
     justify-content: center;
     flex-direction: column;
 }
 
 .footer-social a:hover {
     color: #f2a86f;
 }
 
 .arrow-icon {
     display: inline-block;
     transform: rotate(45deg);
     margin-right: 10px;
     color: #f2a86f;
 }
 
 @media (max-width: 768px) {
     footer {
         height: 60vh;
     }
     .footer-content {
         padding: 30px 20px;
     }
     .footer-logo h1 {
         font-size: 2.5rem;
     }
 }
 
 @media (max-width: 380px) {
     footer {
         height: 70vh;
     }
 }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="index.html">₹€$₮Φ</a>
      <ul class="navbar-nav flex-row d-none d-lg-flex ms-auto">
        <li class="nav-item"><a class="nav-link px-3" href="index.html">Home</a></li>
        <li class="nav-item"><a class="nav-link px-3" href="about.html">About</a></li>
        <li class="nav-item"><a class="nav-link px-3" href="#">Contact</a></li>
      </ul>
      <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>

  <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">₹€$₮Φ</h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
      </ul>
    </div>
  </div>

  <section id="book" class="container py-5 mt-5">
    <div class="text-center mb-5 d-flex justify-content-center align-items-center gap-3 flex-wrap">
      <img src="bg-title.png" alt="leaf" style="width: 60px;">
      <h1 class="fw-bold">BOOK A TABLE</h1>
    </div>

    <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="row">
      <div class="col-lg-8">
        <form class="row g-4" method="POST">
          <div class="col-md-6">
            <label class="form-label text-warning text-uppercase fw-bold">Name</label>
            <input name="name" type="text" class="form-control bg-black text-white border-0" placeholder="Name" required>
          </div>
          <div class="col-md-6">
            <label class="form-label text-warning text-uppercase fw-bold">Last Name</label>
            <input name="lastname" type="text" class="form-control bg-black text-white border-0" placeholder="Last Name">
          </div>
          <div class="col-md-6">
            <label class="form-label text-warning text-uppercase fw-bold">Phone</label>
            <input name="phone" type="text" class="form-control bg-black text-white border-0" placeholder="Phone" required>
          </div>
          <div class="col-md-6">
            <label class="form-label text-warning text-uppercase fw-bold">Email</label>
            <input name="email" type="email" class="form-control bg-black text-white border-0" placeholder="Email" required>
          </div>
          <div class="col-md-6">
            <label class="form-label text-warning text-uppercase fw-bold">Date (DD-MM-YYYY)</label>
            <input name="date" type="text" class="form-control bg-black text-white border-0" placeholder="19-07-2025" required>
          </div>
          <div class="col-md-6">
            <label class="form-label text-warning text-uppercase fw-bold">Time (hh:mmAM/PM)</label>
            <input name="time" type="text" class="form-control bg-black text-white border-0" placeholder="08:30PM" required>
          </div>
          <div class="col-12">
            <button class="btn btn-warning fw-bold px-4 py-2 text-black">BOOK A TABLE</button>
          </div>
        </form>
      </div>

      <div class="col-lg-4">
        <div class="bg-black p-4 mt-5 mt-lg-0">
          <h4 class="fw-bold">OPENING HOURS</h4>
          <p class="text-white-50">Visit us during our open hours and enjoy amazing dishes!</p>
          <hr class="text-white">
          <div class="d-flex justify-content-between"><span class="fw-bold">Monday – Friday</span><span>8AM – 6PM</span></div>
          <hr class="text-white">
          <div class="d-flex justify-content-between"><span class="fw-bold">Saturday</span><span>9AM – 5PM</span></div>
          <hr class="text-white">
          <div class="d-flex justify-content-between"><span class="fw-bold">Sunday</span><span>9AM – 4PM</span></div>
        </div>
      </div>
    </div>

    <div class="mt-5">
      <h4 class="fw-bold text-center mb-3">FIND US HERE</h4>
      <div class="ratio ratio-16x9">
        <iframe src="https://www.google.com/maps?q=Dominos+Sitamarhi&output=embed" style="border:0;" allowfullscreen loading="lazy"></iframe>
      </div>
    </div>
  </section>
  <footer role="contentinfo">
        <!-- Background Video -->
        <video autoplay muted loop playsinline>
    <source src="bg.mp4" type="video/mp4">
    Your browser does not support the video tag.
  </video>

        <!-- Content -->
        <div class="container footer-content text-white">
            <div class="footer-logo">
                <span><strong>B</strong></span>
                <h1 class="d-inline ms-1">16</h1><br>
                <span>HOURS OF OPERATION</span>
            </div>

            <div class="footer-border mt-4">
                <p><strong>MONDAY–WEDNESDAY:</strong> 11 A.M. to 2 P.M.</p>
                <p><strong>THURSDAY–SATURDAY:</strong> 11 A.M. to 8 P.M.</p>
            </div>

            <div>
                <p class="mb-1">Near Sit College</p>
                <p class="mb-1">Sitamarhi, Bihar 818181</p>
                <p class="mb-2 text-white">abc@gmail.com</p>
            </div>

            <div class="footer-border mt-4">
                <p><span class="arrow-icon">➤</span>Eat in or take out. We accept credit cards, personal checks, and cold-hard cash.</p>
            </div>

            <div class="footer-social">
                <a href="#"><i class="fab fa-facebook-f me-1"></i> Facebook</a>
                <a href="#"><i class="fab fa-twitter me-1"></i> Twitter</a>
                <a href="#"><i class="fab fa-youtube me-1"></i> YouTube</a>
                <a href="#"><i class="fab fa-instagram me-1"></i> Instagram</a>
            </div>
        </div>
    </footer>
  <script>
    window.addEventListener('scroll', function () {
      const navbar = document.querySelector('.navbar');
      navbar.classList.toggle('scrolled', window.scrollY > 10);
    });

    document.querySelector("form").addEventListener("submit", function (e) {
      const dateInput = document.querySelector('input[name="date"]').value.trim();
      const timeInput = document.querySelector('input[name="time"]').value.trim();
      const dateRegex = /^(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-\d{4}$/;
      const timeRegex = /^(0[1-9]|1[0-2]):[0-5][0-9](AM|PM)$/i;

      if (!dateRegex.test(dateInput)) {
        alert("Please enter a valid date in DD-MM-YYYY format.");
        e.preventDefault();
      } else if (!timeRegex.test(timeInput)) {
        alert("Please enter a valid time in hh:mmAM/PM format.");
        e.preventDefault();
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
