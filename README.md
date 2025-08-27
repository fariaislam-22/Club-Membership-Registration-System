
# ULAB Club Membership App (PHP + MySQL)

This is a simple, **secure-by-default** web app that lets students:
- Browse available clubs
- Register as a member of **one** club
- View their membership details

Tech stack: HTML, CSS, JavaScript, PHP (sessions), MySQL (PDO).

## Quick Start (XAMPP/LAMP/WAMP)
1. Copy the folder `ulab_club_app/` into your server root (e.g., `htdocs/` for XAMPP).
2. Create the database:
   - Open phpMyAdmin → import `init.sql` **or**
   - Run in MySQL client: `SOURCE init.sql;`
3. Configure DB in `config/db.php` if your credentials differ.
4. Visit: `http://localhost/ulab_club_app/index.php`

## Default Tables
- `students(student_id PK, name, email)`
- `clubs(id PK, name, description)`
- `memberships(id PK, student_id FK UNIQUE, club_id FK, created_at)`
  - UNIQUE(student_id) ensures **one club per student**.

## Security Highlights
- Sessions configured with strict cookies and `session_regenerate_id()` on sign-in.
- All SQL uses prepared statements via PDO.
- Simple CSRF token for POST forms.
- Server-side validation on critical actions.

## Pages
- `/index.php` — Welcome & navigation
- `/register.php` — Collects student info (name, ID, email) and logs them in (session)
- `/clubs.php` — Browse clubs & join exactly **one**
- `/my_membership.php` — See your membership details
- `/logout.php` — Ends the session

## Styling & UX
- Modern dark theme with green accents
- Client-side validation and small interactions in `assets/app.js`

