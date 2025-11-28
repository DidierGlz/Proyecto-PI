function confirmDelete(e) {
  if (!confirm('¿Eliminar este usuario?')) {
    e.preventDefault();
    return false;
  }
  return true;
}
