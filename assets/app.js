
document.addEventListener('DOMContentLoaded', () => {
  // Client side validation for register form
  const reg = document.getElementById('registerForm');
  if (reg) {
    reg.addEventListener('submit', (e) => {
      const name = reg.querySelector('input[name="name"]');
      const sid = reg.querySelector('input[name="student_id"]');
      const email = reg.querySelector('input[name="email"]');
      let valid = true;

      if (!name.value || name.value.trim().length < 2) { valid = false; name.classList.add('err'); }
      if (!sid.value || !/^[A-Za-z0-9\-]{4,20}$/.test(sid.value)) { valid = false; sid.classList.add('err'); }
      if (!email.value || !/^\S+@\S+\.\S+$/.test(email.value)) { valid = false; email.classList.add('err'); }

      if (!valid) {
        e.preventDefault();
        alert('Please provide valid Name, Student ID (4–20 chars), and Email.');
      }
    });
  }

  // Club search filter
  const search = document.getElementById('clubSearch');
  const list = document.getElementById('clubList');
  if (search && list) {
    search.addEventListener('input', () => {
      const q = search.value.trim().toLowerCase();
      list.querySelectorAll('.club-card').forEach(card => {
        const name = card.getAttribute('data-name') || '';
        card.style.display = name.includes(q) ? '' : 'none';
      });
    });
  }
});
