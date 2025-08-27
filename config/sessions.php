
<?php
// Secure session settings (adjust cookie_secure if using HTTPS)
$cookieParams = session_get_cookie_params();
session_set_cookie_params([
  'lifetime' => 0,
  'path' => $cookieParams['path'],
  'domain' => $cookieParams['domain'],
  'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
  'httponly' => true,
  'samesite' => 'Lax'
]);

session_start();

// Generate CSRF token if missing
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Helper: check login
function require_login() {
  if (empty($_SESSION['student'])) {
    header('Location: /ulab_club_app/register.php');
    exit;
  }
}

// Helper: validate CSRF
function check_csrf() {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
      http_response_code(403);
      echo "Invalid CSRF token.";
      exit;
    }
  }
}
