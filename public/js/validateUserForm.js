function validateUserForm(e) {
  const form = e.target;
  const name = form.querySelector('input[name="name"]').value.trim();
  const login = form.querySelector('input[name="login"]').value.trim();
  const pwd   = form.querySelector('input[name="password"]').value;

  if (name.length < 3) { alert('El nombre debe tener al menos 3 caracteres.'); e.preventDefault(); return false; }
  if (login.length < 3) { alert('El login debe tener al menos 3 caracteres.'); e.preventDefault(); return false; }
  if (pwd && pwd.length > 0 && pwd.length < 4) { alert('El password debe tener al menos 4 caracteres.'); e.preventDefault(); return false; }
  return true;
}
