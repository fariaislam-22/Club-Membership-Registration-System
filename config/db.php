
<?php
// Database connection via PDO
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'ulab_clubs');
define('DB_USER', 'root');      // change if needed
define('DB_PASS', '');          // change if needed
define('DB_CHARSET', 'utf8mb4');

$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES => false,
];

try {
  $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
  $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
  http_response_code(500);
  echo "Database connection failed.";
  exit;
}
