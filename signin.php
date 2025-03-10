<?php
session_start();
require 'config.php'; // Database connection

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  if (empty($email) || empty($password)) {
    $errorMessage = "All fields are required.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errorMessage = "Invalid email format.";
  } else {
    try {
      $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // Check if user exists
      $stmt = $pdo->prepare("SELECT id, password, name,agent_code FROM agents WHERE email = ?");
      $stmt->execute([$email]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user && password_verify($password, $user['password'])) {
        // Start the session and set session variables
        $_SESSION['agent_id'] = $user['id'];
        $_SESSION['agent_email'] = $email;
        $_SESSION['agent_name'] = $user['name'];
        $_SESSION['code'] = $user['agent_code'];

        // Debugging: Check if session is set

        echo "<script>alert('Login successful!'); window.location.href = 'index.php';</script>";


        var_dump($_SESSION);
        exit;


      } else {
        $errorMessage = "Invalid email or password.";
      }
    } catch (PDOException $e) {
      $errorMessage = "Database error: " . $e->getMessage();
    }
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>S-MART Agent Dashboard | Sign In</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
  <!-- Custom styles -->
  <link rel="stylesheet" href="./css/style.min.css">
  <style>
    .bright-text{
      color: #FF7602;
    }
    .dark-text{
      color: #07048A;
    }
    .bright-bg{
      background-color: #FF7602;
    }
    .dark-bg{
      background: #07048A !important;
    }
  </style>
</head>

<body>
  <div class="layer"></div>
  <main class="page-center">
    <article class="sign-up">
    <img src="img/logo-dark.png" alt="" width="120vw">
    <hr>
      <h1 class="sign-up__title">Agent Signin</h1>
      <!-- <p class="sign-up__subtitle">Sign in to your agent account to continue</p> -->
    
      <?php if (!empty($errorMessage)) {
        echo "<p style='color:red;'>$errorMessage</p>";
      } ?>
      <br>
      <form class="sign-up-form form" action="" method="POST">
        <label class="form-label-wrapper">
          <p class="form-label">Email</p>
          <input class="form-input" type="email" name="email" placeholder="Enter your email" required>
        </label>
        <label class="form-label-wrapper">
          <p class="form-label">Password</p>
          <input class="form-input" type="password" name="password" placeholder="Enter your password" required>
        </label>
        <br>
        <button class="form-btn primary-default-btn transparent-btn dark-bg">Sign in</button>
      </form>
      <br>
      <span>No account yet? <a class="bright-text" href="signup.php">Get Started </a></span>
    </article>
  </main>
  <!-- Chart library -->
  <script src="./plugins/chart.min.js"></script>
  <!-- Icons library -->
  <script src="plugins/feather.min.js"></script>
  <!-- Custom scripts -->
  <script src="js/script.js"></script>
</body>

</html>