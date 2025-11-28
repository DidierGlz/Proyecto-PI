function validateImageForm(e) {
  const form = e.target;
  const title = form.querySelector('input[name="title"]').value.trim();
  const fileInput = form.querySelector('input[name="image"]');

  if (title.length < 3) {
    alert('El título debe tener al menos 3 caracteres.');
    e.preventDefault();
    return false;
  }
  if (!fileInput.files || fileInput.files.length === 0) {
    alert('Selecciona una imagen.');
    e.preventDefault();
    return false;
  }
  return true;
}

function confirmDeleteImage(e) {
  if (!confirm('¿Eliminar esta imagen? Esta acción no se puede deshacer.')) {
    e.preventDefault();
    return false;
  }
  return true;
}
