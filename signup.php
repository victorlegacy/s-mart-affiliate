<?php
require 'config.php'; // Include database connection

$successMessage = "";
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);

  $password = trim($_POST['password']);
  $address = trim($_POST['address']);
  $city = trim($_POST['city']);
  $state = trim($_POST['state']);
  $localgovernment = trim($_POST['localgovernment']);

  // Validate required fields
  if (empty($name) || empty($email) || empty($phone) || empty($password) || empty($address) || empty($city) || empty($state) || empty($localgovernment)) {
    $errorMessage = "All fields are required.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errorMessage = "Invalid email format.";
  } else {
    try {
      $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // Check if email already exists
      $stmt = $pdo->prepare("SELECT id FROM agents WHERE email = ?");
      $stmt->execute([$email]);
      if ($stmt->fetch()) {
        $errorMessage = "Email is already registered.";
      } else {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Generate a unique agent code
        function generateAgentCode($pdo)
        {
          $agentCode = '';
          $isUnique = false;
          while (!$isUnique) {
            $agentCode = strtoupper(substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 10));
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM agents WHERE agent_code = ?");
            $stmt->execute([$agentCode]);
            $isUnique = ($stmt->fetchColumn() == 0);
          }
          return $agentCode;
        }

        $agentCode = generateAgentCode($pdo);

        // Insert agent into database
        $stmt = $pdo->prepare("INSERT INTO agents (name, email, phone, address, city, state, localgovt, password, agent_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $phone ,$address, $city, $state, $localgovernment, $hashedPassword, $agentCode]);

        // $successMessage = "Registration successful! Your agent code is: " . $agentCode;
        $successMessage = "Registration successful!";
        echo "<script>alert('Registration successful!')</script>";
        echo "<script>location.href='index.php'</script>";
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
  <title>S-MART Agent Dashboard | Sign Up</title>
  <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
  <link rel="stylesheet" href="./css/style.min.css">
</head>

<style>
  @media (min-width: 1024px) {

    /* Adjust the breakpoint as needed */
    .form {
      width: 600px;
    }
  }
 
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
<body>


  <div class="layer"></div>
  <main class="page-center">

    <article class="sign-up">
    <img src="img/logo-dark.png" alt="" width="120vw">
    <hr>
      <h1 class="sign-up__title">Agent Sign Up</h1>
      <p style="text-align: center !important; color:gray">Create an account to get started as an agent</p>

      <br>
      <!-- Display Messages -->
      <?php if (!empty($successMessage)): ?>
        <p style="color: green;"><?= $successMessage ?></p>
      <?php endif; ?>
      <?php if (!empty($errorMessage)): ?>
        <p style="color: red;"><?= $errorMessage ?></p>
      <?php endif; ?>

      <br>

      <form class="sign-up-form form" action="" method="POST">
        <label class="form-label-wrapper">
          <p class="form-label">Full Name</p>
          <input name="name" class="form-input" type="text" placeholder="Enter your Full name" required>
        </label>
        <label class="form-label-wrapper">
          <p class="form-label">Email</p>
          <input name="email" class="form-input" type="email" placeholder="Enter your Email" required>
        </label>
        <label class="form-label-wrapper">
          <p class="form-label">Phone</p>
          <input name="phone" class="form-input" type="tel" placeholder="Enter your Phone Number" required>
        </label>
        <label class="form-label-wrapper">
          <p class="form-label">Create Password</p>
          <input name="password" class="form-input" type="password" placeholder="Enter your Password" required>
        </label>
        <label class="form-label-wrapper">
          <p class="form-label">Address</p>
          <input name="address" class="form-input" type="text" placeholder="Enter your Address" required>
        </label>
        <label class="form-label-wrapper">
          <p class="form-label">City</p>
          <input name="city" class="form-input" type="text" placeholder="Enter your City" required>
        </label>
        <label class="form-label-wrapper">
          <p class="form-label">State</p>
          <input name="state" class="form-input" type="text" placeholder="Enter your State" required>
        </label>
        <label class="form-label-wrapper">
          <p class="form-label">Local Government</p>
          <input name="localgovernment" class="form-input" type="text" placeholder="Enter your Local government"
            required>
        </label>

        <br>
        <button name="submit" type="submit" class="form-btn primary-default-btn transparent-btn dark-bg">Register</button>
      </form>
    </article>
  </main>

  <script src="./plugins/chart.min.js"></script>
  <script src="plugins/feather.min.js"></script>
  <script src="js/script.js"></script>
</body>

</html>