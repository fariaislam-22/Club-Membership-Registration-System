<?php
require_once __DIR__.'/config/sessions.php';
include __DIR__.'/partials/header.php';

/**
 * Find an image to show in the hero.
 * 1) Prefer assets/university_clubs.(png|jpg|jpeg|webp)
 * 2) Otherwise pick the first image file in /assets
 * Returns [webPath, fileExists, fileSystemPath]
 */
function find_hero_image(): array {
  $candidates = [
    'assets/university_clubs.png',
    'assets/university_clubs.jpg',
    'assets/university_clubs.jpeg',
    'assets/university_clubs.webp',
  ];
  foreach ($candidates as $rel) {
    if (file_exists(__DIR__ . '/' . $rel)) {
      return [$rel, true, __DIR__ . '/' . $rel];
    }
  }
  $glob = glob(__DIR__ . '/assets/*.{png,jpg,jpeg,webp,PNG,JPG,JPEG,WEBP}', GLOB_BRACE);
  if (!empty($glob)) {
    $first = 'assets/' . basename($glob[0]);
    return [$first, true, __DIR__ . '/' . $first];
  }
  return ['assets/university_clubs.png', false, __DIR__ . '/assets/university_clubs.png'];
}
[$heroImg, $heroExists, $heroFs] = find_hero_image();
$ver = $heroExists ? @filemtime($heroFs) : time(); // cache-bust
?>

<section class="hero">
  <div>
    <span class="kicker">Discover clubs you’ll love ✨</span>
    <h2>Find the right <span class="accent">club</span> for you</h2>
    <p>Personalized recommendations based on your interests. Join one club now—switch anytime.</p>
    <div class="cta">
      <a class="btn" href="/ulab_club_app/register.php">Find my club</a>
      <a class="btn-outline" href="/ulab_club_app/clubs.php">Browse all clubs →</a>
    </div>

    <div class="stats">
      <div class="stat">
        <span class="tag">Education</span>
        <div class="big">+20 clubs</div>
        <small>From debating to robotics</small>
      </div>
      <div class="stat">
        <span class="tag">On‑campus & online</span>
        <div class="big">+120 events</div>
        <small>Per academic year</small>
      </div>
      <div class="stat">
        <span class="tag">Student rating</span>
        <div class="big">4.9/5</div>
        <small>Based on member feedback</small>
      </div>
    </div>
  </div>

  <div>
    <?php if ($heroExists): ?>
      <!-- Plain image: no box, no shadow, fully transparent background -->
      <img
        alt="University Clubs illustration"
        src="<?php echo htmlspecialchars($heroImg) . '?v=' . $ver; ?>"
        style="max-width:100%;height:auto;display:block;border:0;box-shadow:none;background:transparent;border-radius:0;" />
    <?php endif; ?>
  </div>
</section>

<section class="grid-2">
  <div class="card">
    <h3>Build Lifelong Friendships 🤝</h3>
    <p>Meet like-minded students, create unforgettable memories, and grow your network beyond the classroom.</p>
  </div>
  <div class="card">
    <h3>Discover Your Passion 🎨</h3>
    <p>From debating and robotics to arts and sports, find the club that speaks to your interests and talents.</p>
  </div>
</section>

<section class="grid-2">
  <div class="card">
    <h3>Boost Your Skills 🚀</h3>
    <p>Gain leadership, teamwork, and problem-solving skills through real experiences in student organizations.</p>
  </div>
  <div class="card">
    <h3>Make an Impact 🌍</h3>
    <p>Be part of social initiatives, community projects, and cultural events that create positive change at ULAB.</p>
  </div>
</section>

<!-- ================== Testimonials (self-contained) ================== -->
<section class="tms-wrap">
  <div class="tms-head">
    <span class="tms-kicker">What students say ✨</span>
    <h3 class="tms-title">Testimonials</h3>
  </div>

  <div class="tms-carousel" data-tms>
    <button class="tms-nav tms-prev" aria-label="Previous">←</button>

    <div class="tms-track">
      <!-- Slide 1 -->
      <figure class="tms-card">
        <blockquote>
          “Joining the <strong>Electronics & Robotics Club</strong> changed my degree.
          I built real projects, led a team, and landed an internship.”
        </blockquote>
        <figcaption>
          <span class="tms-name">Ayan S.</span>
          <span class="tms-meta">ECE • 3rd year</span>
        </figcaption>
      </figure>

      <!-- Slide 2 -->
      <figure class="tms-card">
        <blockquote>
          “The <strong>Debating Club</strong> made me confident.
          Interviews feel like friendly debates now—best decision ever!”
        </blockquote>
        <figcaption>
          <span class="tms-name">Maliha R.</span>
          <span class="tms-meta">BBA • 2nd year</span>
        </figcaption>
      </figure>

      <!-- Slide 3 -->
      <figure class="tms-card">
        <blockquote>
          “Through the <strong>Social Welfare Club</strong> I met amazing people
          and organized events that actually helped our community.”
        </blockquote>
        <figcaption>
          <span class="tms-name">Tanzim K.</span>
          <span class="tms-meta">Media Studies • Final year</span>
        </figcaption>
      </figure>
    </div>

    <button class="tms-nav tms-next" aria-label="Next">→</button>

    <div class="tms-dots" aria-hidden="true"></div>
  </div>
</section>

<style>
/* ===== Testimonials styles (scoped via .tms- prefix) ===== */
.tms-wrap{
  margin: 50px auto 2px auto;
  max-width: 1060px;
  padding: 26px 18px 40px;
  border-radius: 22px;
  background:
    radial-gradient(800px 400px at -10% 0%, #FFE6D8 0%, rgba(255,230,216,0) 60%),
    radial-gradient(900px 400px at 110% 40%, #EDE4FF 0%, rgba(237,228,255,0) 60%),
    rgba(255,255,255,.6);
  backdrop-filter: saturate(160%) blur(6px);
}
.tms-head{ text-align:center; margin-bottom:10px; }
.tms-kicker{
  display:inline-block; padding:8px 12px; border-radius:999px; font-weight:800; font-size:12px;
  background:#FFF3E0; color:#7C2D12;
}
.tms-title{
  margin:10px 0 0; font-size: clamp(28px, 5vw, 40px); font-weight:900;
  background: linear-gradient(90deg, var(--accent), var(--accent-2), var(--accent-3));
  -webkit-background-clip:text; background-clip:text; color:transparent;
}

.tms-carousel{ position:relative; display:flex; align-items:center; gap:10px; }
.tms-track{
  overflow:hidden; width:100%;
  scroll-behavior:smooth; display:flex;
}
.tms-card{
  min-width: 100%; padding: 26px 26px 50px; margin:0;
  background:#fff; border:1px solid #E2E8F0; border-radius: 22px;
  box-shadow: 0 14px 40px rgba(16,24,40,.08);
}
.tms-card blockquote{
  margin:0 0 10px 0; font-size: clamp(16px, 2.2vw, 22px); line-height:1.55; color: var(--ink);
}
.tms-card blockquote::before,
.tms-card blockquote::after{
  content: "“"; color: var(--accent-2); font-weight:900; margin-right:6px;
}
.tms-card blockquote::after{ content:"”"; margin-left:6px; }
.tms-name{ font-weight:900; }
.tms-meta{ color: var(--muted); margin-left:6px; }

.tms-nav{
  flex:0 0 auto;
  width:38px; height:38px; border-radius:999px; border:1px solid #E2E8F0;
  background:#fff; cursor:pointer; font-weight:900;
  box-shadow: 0 8px 18px rgba(0,0,0,.06);
}
.tms-nav:hover{ background: rgba(155,92,246,.08); color:#5B21B6; }
.tms-prev{ margin-left:4px; }
.tms-next{ margin-right:4px; }

.tms-dots{ display:flex; justify-content:center; gap:8px; margin:12px 0 0; }
.tms-dots button{
  width:8px; height:8px; border-radius:999px; border:0;
  background: #E2E8F0; cursor:pointer;
}
.tms-dots button.is-active{ background: var(--accent-2); }
@media (max-width: 680px){
  .tms-wrap{ padding:18px 12px 6px; }
  .tms-card{ padding:18px; }
}
</style>

<script>
/* ===== Testimonials behavior (isolated, no globals) ===== */
(() => {
  const root = document.querySelector('[data-tms]');
  if (!root) return;

  const track = root.querySelector('.tms-track');
  const slides = [...root.querySelectorAll('.tms-card')];
  const prev = root.querySelector('.tms-prev');
  const next = root.querySelector('.tms-next');
  const dotsWrap = root.querySelector('.tms-dots');

  let index = 0;
  const go = (i) => {
    index = (i + slides.length) % slides.length;
    track.scrollTo({ left: index * track.clientWidth, behavior: 'smooth' });
    [...dotsWrap.children].forEach((b, j) => b.classList.toggle('is-active', j === index));
  };

  // Build dots
  slides.forEach((_, i) => {
    const b = document.createElement('button');
    b.addEventListener('click', () => go(i));
    dotsWrap.appendChild(b);
  });
  if (dotsWrap.firstChild) dotsWrap.firstChild.classList.add('is-active');

  prev.addEventListener('click', () => go(index - 1));
  next.addEventListener('click', () => go(index + 1));

  // Auto-advance every 6s (pause on hover)
  let timer = setInterval(() => go(index + 1), 6000);
  root.addEventListener('mouseenter', () => clearInterval(timer));
  root.addEventListener('mouseleave', () => timer = setInterval(() => go(index + 1), 6000));

  // Resize handler for proper width snaps
  window.addEventListener('resize', () => go(index));
})();
</script>
<!-- ================= end Testimonials ================= --

<!-- ============= Club Events + Join CTA (self-contained) ============= -->
<section class="ev-wrap">
  <div class="ev-head">
    <span class="ev-kicker">Happening on campus ✨</span>
    <h3 class="ev-title">Upcoming Club Events</h3>
    <p class="ev-sub">From hackathons to open mics — there’s something for everyone.</p>
  </div>

  <div class="ev-grid">
    <article class="ev-card">
      <div class="ev-badge">Tech</div>
      <h4>Robo Sprint: 12-Hour Build</h4>
      <p>Form a team, grab a kit, and build a line-follower robot. Prizes for speed and creativity.</p>
      <div class="ev-meta">
        <span>Fri • 4:00 PM</span>
        <span>Lab-2, ECE</span>
      </div>
    </article>

    <article class="ev-card">
      <div class="ev-badge ev-badge-purple">Creative</div>
      <h4>Campus Open Mic Night</h4>
      <p>Music, poetry, comedy—show your art on stage. First-timers welcome, cozy crowd guaranteed.</p>
      <div class="ev-meta">
        <span>Sat • 6:30 PM</span>
        <span>Auditorium</span>
      </div>
    </article>

    <article class="ev-card">
      <div class="ev-badge ev-badge-cyan">Community</div>
      <h4>Food Drive with Welfare Club</h4>
      <p>Pack relief boxes and distribute with local orgs. Make an impact with your friends.</p>
      <div class="ev-meta">
        <span>Sun • 10:00 AM</span>
        <span>Student Center</span>
      </div>
    </article>
  </div>

  <div class="ev-cta">
    <div class="ev-cta-text">
      <h4>Ready to join the fun?</h4>
      <p>Pick a club, meet your people, and start building memories today.</p>
    </div>
    <a class="ev-cta-btn" href="/ulab_club_app/register.php">Register now</a>
  </div>
</section>

<style>
/* ===== Events styles (scoped with ev- prefix — no conflicts) ===== */
.ev-wrap{
  max-width: 1100px;
  margin: 38px auto 0px auto;
  padding: 20px 18px 0px;
}
.ev-head{ text-align:center; }
.ev-kicker{
  display:inline-block; padding:8px 12px; border-radius:999px; font-weight:800; font-size:12px;
  background:#FFF3E0; color:#7C2D12;
}
.ev-title{
  margin:10px 0 4px; font-size: clamp(28px, 5vw, 40px); font-weight:900;
  background: linear-gradient(90deg, var(--accent), var(--accent-2), var(--accent-3));
  -webkit-background-clip:text; background-clip:text; color:transparent;
}
.ev-sub{ color: var(--muted); margin: 0 0 16px; }

.ev-grid{
  display:grid; gap:16px;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
}
.ev-card{
  background:#fff; border:1px solid #E2E8F0; border-radius:22px;
  padding:18px; box-shadow: 0 14px 40px rgba(16,24,40,.08);
  transition: transform .12s ease, box-shadow .12s ease;
}
.ev-card:hover{ transform: translateY(-2px); box-shadow: 0 18px 36px rgba(0,194,216,.18); }
.ev-card h4{ margin:6px 0 6px; font-size: 18px; }
.ev-card p{ margin:0 0 10px; color: var(--muted); }

.ev-badge{
  display:inline-flex; align-items:center; gap:6px;
  padding:6px 10px; border-radius:999px; font-size:12px; font-weight:800;
  background: rgba(255,207,92,.20); color:#92400E;
}
.ev-badge-purple{ background: rgba(155,92,246,.12); color:#5B21B6; }
.ev-badge-cyan{ background: rgba(0,194,216,.12); color:#0E7490; }

.ev-meta{
  display:flex; gap:10px; flex-wrap:wrap; color: var(--ink); font-weight:600;
  padding-top:6px; border-top:1px dashed #E2E8F0;
}

.ev-cta{
  margin-top:20px;
  display:flex; gap:16px; align-items:center; justify-content:space-between; flex-wrap:wrap;
  padding:18px;
  border-radius:22px;
  background:
    radial-gradient(700px 300px at -10% 0%, #FFE6D8 0%, rgba(255,230,216,0) 60%),
    radial-gradient(700px 300px at 110% 100%, #EDE4FF 0%, rgba(237,228,255,0) 60%),
    rgba(255,255,255,.72);
  border:1px solid #E2E8F0;
  box-shadow: var(--shadow);
}
.ev-cta-text h4{ margin:0 0 4px; font-size:20px; font-weight:900; }
.ev-cta-text p{ margin:0; color: var(--muted); }

.ev-cta-btn{
  display:inline-flex; align-items:center; justify-content:center;
  padding:12px 18px; border-radius:999px; font-weight:800; text-decoration:none;
  background: var(--accent); color:#fff; border:1px solid transparent;
  box-shadow: 0 10px 20px rgba(255,107,74,.25);
  transition: transform .12s ease, box-shadow .12s ease;
}
.ev-cta-btn:hover{ transform: translateY(-1px); }
@media (max-width: 640px){
  .ev-cta{ align-items: flex-start; }
}
</style>
<!-- ============= end Events + Join CTA ============= -->

<?php include __DIR__.'/partials/footer.php'; ?>
