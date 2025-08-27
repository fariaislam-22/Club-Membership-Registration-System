
# Short Answers (CO1–CO3)

## 1) PHP sessions: security & efficiency (CO1, 8 marks)
- **Server-side storage**: Session data (e.g., `$_SESSION['student']`) lives on the server, avoiding exposure/modification risks of client-side cookies. In our app, we store `student_id`, `name`, and `email` after registration.
- **Safe identifiers**: We call `session_regenerate_id(true)` on sign-in to mitigate **session fixation**. Cookies are `HttpOnly` and `SameSite=Lax`, reducing XSS/CSRF attack surfaces (see `config/sessions.php`).
- **CSRF protection**: We generate a per-session token (`$_SESSION['csrf_token']`) and verify it for POST forms (e.g., club join), blocking forged requests.
- **Efficiency**: Sessions avoid repeated DB queries. Once signed in, we can read `$_SESSION['student']` instead of hitting the database on every page. We still validate critical transitions server-side.

**Code references**: `config/sessions.php`, `register.php`, `clubs.php`, `my_membership.php`.

## 2) Why MySQL? Limits & mitigations (CO2, 8 marks)
- **Strengths**: Relational schema fits structured data (students, clubs, memberships) with **foreign keys** and a **UNIQUE constraint** for “one club per student”. **PDO prepared statements** give safe, composable queries; **transactions** keep updates atomic (e.g., joining a club).
- **Limits**:
  - **Scalability**: Heavy read/write spikes may need read replicas or caching.
  - **Rigid schema**: Frequent shape changes require migrations. For small feature changes we can use additional tables or nullable columns.
  - **Text search**: MySQL LIKE filtering is basic. We added a simple client-side filter; at larger scale consider **FULLTEXT** indexes or an external search engine.
- **Mitigations used**: Proper indexing (PK/FK/UNIQUE), short transactions around membership updates, and clear constraints for data integrity. The app is easily containerized for horizontal scaling later.

**Code references**: `init.sql`, `config/db.php`, `clubs.php` (transaction + upsert).

## 3) Ethics of third‑party resources (CO3, 8 marks)
- **Considerations**: License compatibility (MIT/BSD/Apache vs restrictive), attribution requirements, avoiding copy‑paste of proprietary code/assets, and transparency in documentation.
- **Our approach**: We used **no external libraries** in production code to keep licensing simple. If we add assets/libraries (e.g., icons, fonts), we will keep a `CREDITS.md` listing source, author, license, and link. We ensure **proper citation** in the report and comments (e.g., noting when code patterns inspired by docs). We also avoid pasting code verbatim without checking license and providing attribution.

**Practices**: Minimal dependencies, explicit credits, and consistent plagiarism checks for documentation and code comments.
