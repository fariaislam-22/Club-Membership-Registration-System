<?php
require_once __DIR__.'/config/sessions.php';
require_once __DIR__.'/config/db.php';

/**
 * Auto-generate pastel chips from a club name (simple keyword rules).
 */
function generate_chips(string $clubName): array {
  $tags = [];
  $lower = strtolower($clubName);

  // Debating / MUN clubs
  if (str_contains($lower, 'debate') || str_contains($lower, 'mun') || str_contains($lower, 'model united')) {
    $tags[] = ['label' => 'Debate',     'color' => 'rgba(255,107,74,.10)', 'text' => '#7A2413']; // coral
    $tags[] = ['label' => 'Public Speaking','color' => 'rgba(0,194,216,.10)', 'text' => '#0E7490']; // cyan
    $tags[] = ['label' => 'Leadership', 'color' => 'rgba(155,92,246,.10)', 'text' => '#5B21B6']; // purple
  }

  // Robotics / Electronics / Programming
  if (str_contains($lower, 'robot') || str_contains($lower, 'electronics') || str_contains($lower, 'programming') || str_contains($lower, 'computer')) {
    $tags[] = ['label' => 'STEM',       'color' => 'rgba(0,194,216,.10)', 'text' => '#0E7490'];
    $tags[] = ['label' => 'Innovation', 'color' => 'rgba(255,207,92,.20)', 'text' => '#92400E'];
    $tags[] = ['label' => 'Teamwork',   'color' => 'rgba(34,197,94,.12)', 'text' => '#166534'];
  }

  // Arts, film, theatre, photography, culture
  if (str_contains($lower, 'art') || str_contains($lower, 'photo') || str_contains($lower, 'film') || str_contains($lower, 'theatre') || str_contains($lower, 'culture') || str_contains($lower, 'shangskriti')) {
    $tags[] = ['label' => 'Creativity', 'color' => 'rgba(155,92,246,.10)', 'text' => '#5B21B6'];
    $tags[] = ['label' => 'Expression', 'color' => 'rgba(255,107,74,.10)', 'text' => '#7A2413'];
    $tags[] = ['label' => 'Community',  'color' => 'rgba(34,197,94,.12)',  'text' => '#166534'];
  }

  // Sports, games, adventure
  if (str_contains($lower, 'sport') || str_contains($lower, 'games') || str_contains($lower, 'adventure') || str_contains($lower, 'field')) {
    $tags[] = ['label' => 'Sports',     'color' => 'rgba(255,207,92,.20)', 'text' => '#92400E'];
    $tags[] = ['label' => 'Fitness',    'color' => 'rgba(0,194,216,.10)', 'text' => '#0E7490'];
    $tags[] = ['label' => 'Team Spirit','color' => 'rgba(155,92,246,.10)', 'text' => '#5B21B6'];
  }

  // Social, welfare, YES, Rotaract, community
  if (str_contains($lower, 'social') || str_contains($lower, 'welfare') || str_contains($lower, 'yes') || str_contains($lower, 'rotaract') || str_contains($lower, 'community')) {
    $tags[] = ['label' => 'Community',  'color' => 'rgba(34,197,94,.12)', 'text' => '#166534'];
    $tags[] = ['label' => 'Volunteering','color' => 'rgba(0,194,216,.10)', 'text' => '#0E7490'];
    $tags[] = ['label' => 'Leadership', 'color' => 'rgba(255,107,74,.10)', 'text' => '#7A2413'];
  }

  // Business / Entrepreneurship
  if (str_contains($lower, 'business') || str_contains($lower, 'entrepreneur')) {
    $tags[] = ['label' => 'Networking', 'color' => 'rgba(255,207,92,.20)', 'text' => '#92400E'];
    $tags[] = ['label' => 'Leadership', 'color' => 'rgba(155,92,246,.10)', 'text' => '#5B21B6'];
    $tags[] = ['label' => 'Growth',     'color' => 'rgba(0,194,216,.10)', 'text' => '#0E7490'];
  }

  // If nothing matched, give a default
  if (empty($tags)) {
    $tags[] = ['label' => 'Campus Life','color' => 'rgba(100,116,139,.12)', 'text' => '#334155'];
    $tags[] = ['label' => 'Friendship', 'color' => 'rgba(155,92,246,.10)', 'text' => '#5B21B6'];
  }

  return $tags;
}

$msg = '';
$clubs = [];

try {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_login();
    check_csrf();

    $club_id = (int)($_POST['club_id'] ?? 0);
    if ($club_id > 0) {
      $student_id = $_SESSION['student']['student_id'];

      $pdo->beginTransaction();
      $chk = $pdo->prepare("SELECT id FROM clubs WHERE id = ?");
      $chk->execute([$club_id]);
      if (!$chk->fetch()) {
        throw new Exception("Club not found.");
      }

      $stmt = $pdo->prepare(
        "INSERT INTO memberships (student_id, club_id) VALUES (?, ?)
         ON DUPLICATE KEY UPDATE club_id = VALUES(club_id), created_at = CURRENT_TIMESTAMP"
      );
      $stmt->execute([$student_id, $club_id]);
      $pdo->commit();
      $msg = "You have joined the club successfully.";
    }
  }

  $rs = $pdo->query("SELECT id, name, COALESCE(description,'') AS description FROM clubs ORDER BY name ASC");
  $clubs = $rs ? $rs->fetchAll() : [];
} catch (Throwable $e) {
  $msg = "Database error. Please try again.";
  $clubs = [];
}

$myClubId = null;
if (!empty($_SESSION['student'])) {
  $student_id = $_SESSION['student']['student_id'];
  $m = $pdo->prepare("SELECT club_id FROM memberships WHERE student_id = ?");
  $m->execute([$student_id]);
  $row = $m->fetch();
  if ($row) $myClubId = (int)$row['club_id'];
}

include __DIR__.'/partials/header.php';
?>
<section>
  <h2 class="page-title">Available Clubs</h2>
<?php if (!empty($msg)): ?>
  <div class="alert success"><?php echo htmlspecialchars($msg); ?></div>
<?php endif; ?>

<div class="search-bar">
  <input id="clubSearch" type="text" placeholder="Search clubs..." />
</div>


  <?php if (empty($clubs)): ?>
    <div class="card">
      <h3>No clubs found</h3>
      <p class="muted">Import <code>init.sql</code> into MySQL to seed the clubs, or add rows to the <code>clubs</code> table.</p>
    </div>
  <?php else: ?>
    <div id="clubList" class="cards">
      <?php foreach ($clubs as $c): ?>
        <div class="card club-card" data-name="<?php echo htmlspecialchars(strtolower($c['name'])); ?>">
          <h3><?php echo htmlspecialchars($c['name']); ?></h3>
          <p><?php echo htmlspecialchars($c['description']); ?></p>

          <!-- Auto-tagged pastel chips -->
          <div class="chips">
            <?php foreach (generate_chips($c['name']) as $chip): ?>
              <span class="chip" style="background:<?php echo $chip['color']; ?>;color:<?php echo $chip['text']; ?>">
                <?php echo htmlspecialchars($chip['label']); ?>
              </span>
            <?php endforeach; ?>
          </div>

          <!-- Left-aligned action row -->
          <div class="club-actions" style="margin-top:12px;display:flex;justify-content:flex-start;align-items:center;gap:10px;">
            <?php if (!empty($_SESSION['student'])): ?>
              <form method="POST" class="inline-form" style="margin:0;">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>"/>
                <input type="hidden" name="club_id" value="<?php echo (int)$c['id']; ?>"/>
                <?php if ($myClubId === (int)$c['id']): ?>
                  <!-- Joined: keep soft green -->
                  <button class="btn" type="button" disabled style="background:#E8F8EF;color:#0F6B3E;border:1px solid #8FE1B6;box-shadow:none;">Joined ✓</button>
                <?php else: ?>
                  <!-- Join: use default full orange .btn -->
                  <button class="btn" type="submit">Join</button>
                <?php endif; ?>
              </form>
            <?php else: ?>
              <a class="btn-outline" href="/ulab_club_app/register.php" style="margin:0;">Sign in to Join</a>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>
<?php include __DIR__.'/partials/footer.php'; ?>
