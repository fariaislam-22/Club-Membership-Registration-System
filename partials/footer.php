<footer class="site-footer">
  <div class="footer-container">
    <div class="footer-col">
      <h4>ULAB Clubs</h4>
      <p class="tagline">Connecting students through passions, creativity, and community.</p>
    </div>

    <div class="footer-col">
      <h4>Explore</h4>
      <ul>
        <li><a href="/ulab_club_app/index.php">Home</a></li>
        <li><a href="/ulab_club_app/clubs.php">Clubs</a></li>
        <li><a href="/ulab_club_app/my_membership.php">My Membership</a></li>
        <li><a href="/ulab_club_app/register.php">Register</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h4>Contact</h4>
      <ul>
        <li>Email: <a href="mailto:clubs@ulab.edu.bd">clubs@ulab.edu.bd</a></li>
        <li>Campus: Dhanmondi, Dhaka</li>
      </ul>
    </div>
  </div>

  <div class="footer-bottom">
    <p>© <?php echo date('Y'); ?> University of Liberal Arts Bangladesh. All rights reserved.</p>
  </div>
</footer>

<style>
.site-footer {
  background: var(--bg);   /* pastel purple background from your theme */
  border-top: 1px solid #E2E8F0;
  margin-top: 20px;        /* reduced top margin */
  padding: 18px 20px 20px; /* reduced top padding */
  color: var(--ink);
  font-size: 14px;
}
.footer-container {
  max-width: 1100px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px,1fr));
  gap: 20px;
}
.footer-col h4 {
  font-size: 16px;
  font-weight: 800;
  margin-bottom: 6px;
  color: var(--accent-2); /* purple accent */
}
.footer-col ul {
  list-style: none;
  padding: 0; margin: 0;
}
.footer-col ul li {
  margin-bottom: 6px;
}
.footer-col a {
  color: var(--ink);
  text-decoration: none;
}
.footer-col a:hover {
  color: var(--accent);
}
.tagline {
  font-size: 14px;
  color: var(--muted);
}
.footer-bottom {
  text-align: center;
  margin-top: 14px; /* reduced gap */
  font-size: 13px;
  color: var(--muted);
}
</style>
