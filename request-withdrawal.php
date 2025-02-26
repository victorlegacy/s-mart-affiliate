<?php
session_start();
require 'config.php'; // Database connection

// Ensure user is logged in
if (!isset($_SESSION['agent_email'])) {
  header("Location: signin.php");
  exit();
}

$agent_email = $_SESSION['agent_email'];
$agent_name = $_SESSION['agent_name'];
$successMessage = "";
$errorMessage = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $account_name = trim($_POST['account_name']);
  $account_number = trim($_POST['account_number']);
  $bank_name = trim($_POST['bank_name']);

  if (empty($account_name) || empty($account_number) || empty($bank_name)) {
    $errorMessage = "All fields are required.";
  } else {
    try {
      $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // Insert withdrawal request
      $stmt = $pdo->prepare("INSERT INTO agents_withdrawal (account_name, account_number, bank_name, status, agent_email, created_at) VALUES (?, ?, ?, 'pending', ?, NOW())");
      $stmt->execute([$account_name, $account_number, $bank_name, $agent_email]);

      $successMessage = "Withdrawal request submitted successfully!";
      echo "<script>alert('Withdrawal request submitted successfully!')</script>";
      echo "<script>location.href='withdrawal-request.php'</script>";
    } catch (PDOException $e) {
      $errorMessage = "Database error: " . $e->getMessage();
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>S-MART Affiliate Dashboard| Dashboard</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="./img/svg/logo.svg" type="image/x-icon" />
  <!-- Custom styles -->
  <link rel="stylesheet" href="./css/style.min.css" />
</head>
<style>
  .sidebar-head {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    justify-content: space-between !important;
    width: 100% !important;
    max-width: 100% !important;
    /* flex-wrap: nowrap !important; */
  }

  .logo-wrapper {
    display: flex !important;
    align-items: center !important;
  }

  .logo-wrapper img {
    max-width: 130px !important;
    height: auto !important;
  }

  .sidebar-toggle {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex-shrink: 0 !important;
    margin-left: 10px !important;
    margin-top: 10px !important;
  }

  .sidebar-user-container {
    display: flex;
    align-items: center;
    white-space: nowrap;
    /* Prevents wrapping */
    overflow: hidden;
    /* Ensures overflow is hidden */
    max-width: 200px;
    /* Set a max width to control layout */
  }

  .sidebar-user-icon {
    color: white;
    flex-shrink: 0;
    /* Prevents the icon from shrinking */
    margin-right: 8px;
    /* Adds some space between the icon and the name */
  }

  .sidebar-user-info {
    flex-grow: 1;
    /* Allows the name to take available space */
    overflow: hidden;
    text-overflow: ellipsis;
    /* Adds '...' if the name is too long */
  }
</style>

<body>
  <div class="layer"></div>
  <!-- ! Body -->
  <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
  <div class="page-flex">
    <!-- ! Sidebar -->
    <aside class="sidebar">
      <div class="sidebar-start">
        <div class="sidebar-head">
          <a href="/" class="logo-wrapper" title="Home">
            <span class="sr-only">Home</span>
            <img src="img/logo-white.png" width="100%" aria-hidden="true" alt="Logo" />
          </a>
          <button class="sidebar-toggle transparent-btn" title="Menu" type="button">
            <span class="sr-only">Toggle menu</span>
            <span class="icon menu-toggle" aria-hidden="true"></span>
          </button>
        </div>
        <div class="sidebar-body">
          <ul class="sidebar-body-menu">
            <li>
              <a href="index.php"><span class="icon home" aria-hidden="true"></span>Dashboard</a>
            </li>
            <li>
              <a class="show-cat-btn" href="##">
                <span class="icon document" aria-hidden="true"></span>Withdrawal
                <span class="category__btn transparent-btn" title="Open list">
                  <span class="sr-only">Open list</span>
                  <span class="icon arrow-down" aria-hidden="true"></span>
                </span>
              </a>
              <ul class="cat-sub-menu active">
                <li>
                  <a href="withdrawal-request.php" style="font-size: 12px">View Withdrawal Request</a>
                </li>
                <li>
                  <a href="request-withdrawal.php" class="active" style="font-size: 12px">Request For Withdrawal</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="profile.php"><i data-feather="user" aria-hidden="true" class="icon"></i>
                Profile</a>
            </li>
            <li>
              <a href="logout.php"><i data-feather="log-out" aria-hidden="true" class="icon"></i></i>
                Logout</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="sidebar-footer">
        <a href="##" class="sidebar-user" style="padding: 10px;">
          <!-- <span class="sidebar-user-img"> -->
          <!-- </span> -->
          <div class="sidebar-user-container">
            <i data-feather="user" aria-hidden="true" class="sidebar-user-icon"></i>
            <div class="sidebar-user-info">
              <span class="sidebar-user__title">
                <?php echo htmlspecialchars($agent_name); ?>
              </span>
            </div>
          </div>

        </a>
      </div>
    </aside>
    <div class="main-wrapper">
      <!-- ! Main nav -->
      <nav class="main-nav--bg">
        <div class="container main-nav">
          <div class="main-nav-start"></div>
          <div class="main-nav-end">
            <button class="sidebar-toggle transparent-btn" title="Menu" type="button">
              <span class="sr-only">Toggle menu</span>

              <span class="icon menu-toggle--gray" aria-hidden="true"></span>
            </button>
            <button class="theme-switcher gray-circle-btn" type="button" title="Switch theme">
              <span class="sr-only">Switch theme</span>
              <i class="sun-icon" data-feather="sun" aria-hidden="true"></i>
              <i class="moon-icon" data-feather="moon" aria-hidden="true"></i>
            </button>

            <div class="nav-user-wrapper">
              <button href="##" class="nav-user-btn dropdown-btn" title="My profile" type="button">
                <span class="sr-only">My profile</span>
                <span class="nav-user-img">
                  <picture>
                    <source srcset="./img/avatar/avatar-illustrated-02.webp" type="image/webp" />
                    <img src="./img/avatar/avatar-illustrated-02.png" alt="User name" />
                  </picture>
                </span>
              </button>
              <ul class="users-item-dropdown nav-user-dropdown dropdown">
                <li>
                  <a href="##">
                    <i data-feather="user" aria-hidden="true"></i>
                    <span>Profile</span>
                  </a>
                </li>
                <li>
                  <a href="##">
                    <i data-feather="settings" aria-hidden="true"></i>
                    <span>Account settings</span>
                  </a>
                </li>
                <li>
                  <a class="danger" href="##">
                    <i data-feather="log-out" aria-hidden="true"></i>
                    <span>Log out</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
      <!-- ! Main -->
      <main class="main users chart-page" id="skip-target">
        <div class="container">
          <h2 class="main-title">Request Withdrawal</h2>

          <div class="row">
            <?php if (!empty($successMessage)): ?>
              <p style="color: green; text-align: center;"><?php echo $successMessage; ?></p>
            <?php endif; ?>

            <?php if (!empty($errorMessage)): ?>
              <p style="color: red; text-align: center;"><?php echo $errorMessage; ?></p>
            <?php endif; ?>
            <div class="col-lg-12">
              <form class="form" action="" method="POST">
                <label class="form-label-wrapper">
                  <p class="form-label">Account Name</p>
                  <input class="form-input" type="text" name="account_name" placeholder="Enter your account name"
                    required>
                </label>
                <label class="form-label-wrapper">
                  <p class="form-label">Account Number</p>
                  <input class="form-input" type="text" name="account_number" placeholder="Enter your account number"
                    required>
                </label>

                <label class="form-label-wrapper">
                  <p class="form-label">Bank Name</p>
                  <input class="form-input" type="text" name="bank_name" placeholder="Enter your bank name" required>
                </label>


                <br>
                <button class="form-btn primary-default-btn transparent-btn" type="submit">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </main>
      <!-- ! Footer -->
      <footer class="footer">
        <div class="container footer--flex">
          <div class="footer-start">
            <p>
              2025 © S-MART Affiliate - Powered by
              <a href="" target="_blank" rel="noopener noreferrer">Onatech NGC</a>
            </p>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!-- Chart library -->
  <script src="./plugins/chart.min.js"></script>
  <!-- Icons library -->
  <script src="plugins/feather.min.js"></script>
  <!-- Custom scripts -->
  <script src="js/script.js"></script>
</body>

</html>