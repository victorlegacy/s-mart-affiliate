<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: signin.php");
  exit();
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
              <a class="active" href="/"><span class="icon home" aria-hidden="true"></span>Dashboard</a>
            </li>
            <li>
              <a class="show-cat-btn" href="##">
                <span class="icon document" aria-hidden="true"></span>Withdrawal
                <span class="category__btn transparent-btn" title="Open list">
                  <span class="sr-only">Open list</span>
                  <span class="icon arrow-down" aria-hidden="true"></span>
                </span>
              </a>
              <ul class="cat-sub-menu">
                <li>
                  <a href="withdrawal-request.php" style="font-size: 12px">View Withdrawal Request</a>
                </li>
                <li>
                  <a href="request-withdrawal.php" style="font-size: 12px">Request For Withdrawal</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="profile.php"><i data-feather="user" aria-hidden="true" class="icon"></i>
                Profile</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="sidebar-footer">
        <a href="##" class="sidebar-user">
          <span class="sidebar-user-img">
            <picture>
              <source srcset="./img/avatar/avatar-illustrated-01.webp" type="image/webp" />
              <img src="./img/avatar/avatar-illustrated-01.png" alt="User name" />
            </picture>
          </span>
          <div class="sidebar-user-info">
            <span class="sidebar-user__title">Nafisa Sh.</span>
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
                  <a href="profile,php">
                    <i data-feather="user" aria-hidden="true"></i>
                    <span>Profile</span>
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
          <h2 class="main-title">Dashboard</h2>
          <div class="row stat-cards">
            <div class="col-md-6 col-xl-4">
              <article class="stat-cards-item">
                <div class="stat-cards-icon warning">
                  <i data-feather="file" aria-hidden="true"></i>
                </div>
                <div class="stat-cards-info">
                  <p class="stat-cards-info__num">₦50000</p>
                  <p class="stat-cards-info__title">Total Balance</p>
                </div>
              </article>
            </div>
            <div class="col-md-6 col-xl-4">
              <article class="stat-cards-item">
                <div class="stat-cards-icon purple">
                  <i data-feather="file" aria-hidden="true"></i>
                </div>
                <div class="stat-cards-info">
                  <p class="stat-cards-info__num">14</p>
                  <p class="stat-cards-info__title">
                    Total Withdrawal Request
                  </p>
                </div>
              </article>
            </div>
            <div class="col-md-6 col-xl-4">
              <article class="stat-cards-item">
                <div class="stat-cards-icon success">
                  <i data-feather="feather" aria-hidden="true"></i>
                </div>
                <div class="stat-cards-info">
                  <p class="stat-cards-info__num">https://smart0.com</p>
                  <p class="stat-cards-info__title">Payment Link</p>
                </div>
              </article>
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