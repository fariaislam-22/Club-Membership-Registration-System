
<?php
require_once __DIR__.'/config/sessions.php';
require_once __DIR__.'/config/db.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  check_csrf();

  $name = trim($_POST['name'] ?? '');
  $student_id = trim($_POST['student_id'] ?? '');
  $email = trim($_POST['email'] ?? '');

  if ($name === '' || strlen($name) < 2) $errors[] = "Name is required.";
  if ($student_id === '' || !preg_match('/^[A-Za-z0-9\-]{4,20}$/', $student_id)) $errors[] = "Valid Student ID is required.";
  if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";

  if (!$errors) {
    // upsert student
    $stmt = $pdo->prepare("INSERT INTO students (student_id, name, email) VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE name = VALUES(name), email = VALUES(email)");
    $stmt->execute([$student_id, $name, $email]);

    // Set session and regenerate ID
    $_SESSION['student'] = ['student_id' => $student_id, 'name' => $name, 'email' => $email];
    session_regenerate_id(true);

    $success = "Profile saved. You're signed in.";
  }
}

include __DIR__.'/partials/header.php';
?>
<section class="card form-card">
  <h2>Student Registration</h2>
  <p>Enter your details to continue. This creates (or updates) your profile.</p>

  <?php if ($errors): ?>
    <div class="alert error">
      <ul><?php foreach ($errors as $e) echo "<li>".htmlspecialchars($e)."</li>"; ?></ul>
    </div>
  <?php elseif ($success): ?>
    <div class="alert success"><?php echo htmlspecialchars($success); ?></div>
  <?php endif; ?>

  <form id="registerForm" method="POST" novalidate>
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>"/>
    <label>Name
      <input type="text" name="name" required value="<?php echo htmlspecialchars($_SESSION['student']['name'] ?? '') ?>"/>
    </label>
    <label>Student ID
      <input type="text" name="student_id" required value="<?php echo htmlspecialchars($_SESSION['student']['student_id'] ?? '') ?>"/>
    </label>
    <label>Email
      <input type="text" name="email" required value="<?php echo htmlspecialchars($_SESSION['student']['email'] ?? '') ?>"/>
    </label>
    <button class="btn" type="submit">Save & Continue</button>
  </form>
</section>
<?php include __DIR__.'/partials/footer.php'; ?>
