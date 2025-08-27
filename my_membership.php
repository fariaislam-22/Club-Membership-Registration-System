<?php
require_once __DIR__.'/config/sessions.php';
require_login();
require_once __DIR__.'/config/db.php';

$student_id = $_SESSION['student']['student_id'];

$stmt = $pdo->prepare("
  SELECT c.id AS club_id, c.name, c.description, m.created_at
  FROM memberships m
  JOIN clubs c ON c.id = m.club_id
  WHERE m.student_id = ?
  LIMIT 1
");
$stmt->execute([$student_id]);
$membership = $stmt->fetch();

// Helper: pretty dates & computed fields (no DB changes needed)
$role        = 'Member';            // default; upgrade later if you add roles
$status      = 'Active';            // derived; you can change from DB in the future
$memberSince = null;
$daysAsMember = null;
$renewalDate = null;
$membershipId = null;

if ($membership) {
  // Deterministic membership ID like ULAB-0001-023
  $membershipId = sprintf('ULAB-%04d-%03d', (int)$student_id, (int)$membership['club_id']);

  // Dates
  $joined = $membership['created_at'] ? new DateTime($membership['created_at']) : null;
  if ($joined) {
    $memberSince  = $joined->format('M d, Y • H:i');
    $today        = new DateTime('now');
    $daysAsMember = $joined->diff($today)->days;
    $renewal      = (clone $joined)->modify('+1 year');
    $renewalDate  = $renewal->format('M d, Y');
  }
}

include __DIR__.'/partials/header.php';
?>
<section class="card membership-card">
  <h2>My Membership</h2>

  <?php if ($membership): ?>
    <p><strong>Membership ID:</strong> <?php echo htmlspecialchars($membershipId); ?></p>
    <p><strong>Club:</strong> <?php echo htmlspecialchars($membership['name']); ?></p>
    <p><strong>Description:</strong> <?php echo htmlspecialchars($membership['description'] ?: '—'); ?></p>

    <p><strong>Role:</strong> <?php echo htmlspecialchars($role); ?></p>
    <p><strong>Status:</strong> <?php echo htmlspecialchars($status); ?></p>

    <p><strong>Member since:</strong> <?php echo htmlspecialchars($memberSince ?? $membership['created_at']); ?></p>
    <?php if ($daysAsMember !== null): ?>
      <p><strong>Days as member:</strong> <?php echo (int)$daysAsMember; ?></p>
    <?php endif; ?>

    <?php if ($renewalDate): ?>
      <p><strong>Renewal date:</strong> <?php echo htmlspecialchars($renewalDate); ?> <span class="muted">(auto‑calculated: +1 year)</span></p>
    <?php endif; ?>

    <p class="muted">You can switch clubs anytime from the <a href="/ulab_club_app/clubs.php">Clubs</a> page.</p>

    <div style="display:flex; gap:10px; margin-top:12px;">
      <a class="btn-outline" href="/ulab_club_app/clubs.php">Browse clubs</a>
      <a class="btn" href="/ulab_club_app/clubs.php">Switch club</a>
    </div>

  <?php else: ?>
    <p>You have not joined any club yet. Visit the <a href="/ulab_club_app/clubs.php">Clubs</a> page to join one.</p>
    <div style="margin-top:12px;">
      <a class="btn" href="/ulab_club_app/clubs.php">Find a club</a>
    </div>
  <?php endif; ?>
</section>
<?php include __DIR__.'/partials/footer.php'; ?>
