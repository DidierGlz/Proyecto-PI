function validateLoginForm(e) {
  const form = e.target;
  const login = form.querySelector('input[name="login"]').value.trim();
  const pwd   = form.querySelector('input[name="password"]').value;

  if (login.length < 3) { alert('El login debe tener al menos 3 caracteres.'); e.preventDefault(); return false; }
  if (pwd.length < 4) { alert('El password debe tener al menos 4 caracteres.'); e.preventDefault(); return false; }
  return true;
}

function togglePwd() {
  const el = document.getElementById('pwd');
  el.type = (el.type === 'password') ? 'text' : 'password';
}
