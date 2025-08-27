<?php
if (!isset($_SESSION)) { session_start(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ULAB Clubs</title>

  <!-- Cache-busted assets: force fresh CSS/JS after edits -->
  <link rel="stylesheet"
        href="/ulab_club_app/assets/style.css?v=<?php echo @filemtime(__DIR__ . '/../assets/style.css'); ?>" />
  <script defer
          src="/ulab_club_app/assets/app.js?v=<?php echo @filemtime(__DIR__ . '/../assets/app.js'); ?>"></script>
</head>
<body>
  <div class="bg-gradient"></div>
  <header class="site-header">
    <div class="container">
      <h1 class="brand">ULAB <span>Clubs</span></h1>
     <nav class="nav">
  <a class="nav-link" href="/ulab_club_app/index.php">Home</a>
  <a class="nav-link" href="/ulab_club_app/clubs.php">Clubs</a>
  <a class="nav-link" href="/ulab_club_app/my_membership.php">My Membership</a>
  
  <?php if (!empty($_SESSION['student'])): ?>
    <span class="student-pill">👤 <?php echo htmlspecialchars($_SESSION['student']['name']); ?></span>
    <a class="btn" href="/ulab_club_app/logout.php">Logout</a>
  <?php else: ?>
    <a class="btn" href="/ulab_club_app/register.php">Get Started</a>
  <?php endif; ?>
</nav>

    </div>
  </header>
  <main class="container">

