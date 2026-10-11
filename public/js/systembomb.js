// Semana 3: interacción JavaScript, DOM y eventos.
document.addEventListener('DOMContentLoaded', () => {
  const menu = document.getElementById('menu-toggle');
  const aside = document.getElementById('sidebar');
  menu?.addEventListener('click', () => {
    const open = aside.classList.toggle('sidebar-open');
    menu.setAttribute('aria-expanded', String(open));
  });
  document.querySelectorAll('form[data-confirm]').forEach(form => {
    form.addEventListener('submit', event => {
      if (!window.confirm(form.dataset.confirm || '¿Confirmar operación?')) event.preventDefault();
    });
  });
});
