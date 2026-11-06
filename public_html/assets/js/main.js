// Bohn Web Design — interacciones de la single page (JS plano, sin librerías)
document.documentElement.classList.remove('no-js');
(() => {
  const nav = document.querySelector('.nav');
  const toggle = document.querySelector('.nav__toggle');

  // Menú móvil
  toggle?.addEventListener('click', () => {
    const open = nav.classList.toggle('is-open');
    toggle.setAttribute('aria-expanded', String(open));
  });
  document.querySelectorAll('.nav__links a').forEach((a) =>
    a.addEventListener('click', () => {
      nav.classList.remove('is-open');
      toggle?.setAttribute('aria-expanded', 'false');
    })
  );

  // Borde del header al hacer scroll
  const onScroll = () => nav?.classList.toggle('is-scrolled', window.scrollY > 10);
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  // Aparición suave de secciones
  const items = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver((entries) => {
      entries.forEach((en) => {
        if (en.isIntersecting) {
          en.target.classList.add('is-visible');
          io.unobserve(en.target);
        }
      });
    }, { threshold: 0.12 });
    items.forEach((el) => io.observe(el));
  } else {
    items.forEach((el) => el.classList.add('is-visible'));
  }

  // Formulario de presupuesto
  const form = document.querySelector('#presupuesto form');
  if (!form) return;
  const productSelect = form.querySelector('select[name="product"]');
  const planField = form.querySelector('.plan-field');
  const status = form.querySelector('.form__status');

  const syncPlan = () => { planField.hidden = productSelect.value !== 'mantenimiento'; };
  productSelect.addEventListener('change', syncPlan);
  syncPlan();

  // Los botones "Pedir presupuesto" preseleccionan el servicio
  document.querySelectorAll('[data-product]').forEach((btn) =>
    btn.addEventListener('click', () => {
      productSelect.value = btn.dataset.product;
      syncPlan();
      setTimeout(() => form.querySelector('input[name="name"]').focus({ preventScroll: true }), 600);
    })
  );

  form.addEventListener('submit', async (ev) => {
    ev.preventDefault();
    status.classList.remove('is-error');
    if (!form.checkValidity()) {
      status.textContent = 'Revisá nombre, email y mensaje.';
      status.classList.add('is-error');
      form.reportValidity();
      return;
    }
    const btn = form.querySelector('button[type="submit"]');
    btn.disabled = true;
    status.textContent = 'Enviando…';
    try {
      const res = await fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: { 'X-Requested-With': 'fetch' },
      });
      const data = await res.json();
      status.textContent = data.message;
      status.classList.toggle('is-error', !data.ok);
      if (data.ok) form.reset(), syncPlan();
    } catch {
      status.textContent = 'No se pudo enviar. Escribime por email o WhatsApp.';
      status.classList.add('is-error');
    } finally {
      btn.disabled = false;
    }
  });
})();
