<?php

use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php'; // Load Composer autoload

// Load .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Define database constants directly from .env
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);
define('DB_NAME', $_ENV['DB_NAME']);

try {
    // Create a new PDO connection
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>