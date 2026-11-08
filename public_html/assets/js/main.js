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

// ================= v2: efectos interactivos =================
(() => {
  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const finePointer = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
  const root = document.documentElement;

  // Retraso escalonado para elementos que aparecen juntos
  document.querySelectorAll('.cards, .steps, .stats__grid, .hero__text').forEach((group) => {
    group.querySelectorAll('.reveal').forEach((el, i) => el.style.setProperty('--d', `${i * 0.12}s`));
  });

  // Barra de progreso + línea del proceso
  const stepsWrap = document.querySelector('.steps-wrap');
  const onScroll = () => {
    const max = root.scrollHeight - innerHeight;
    root.style.setProperty('--p', max > 0 ? (scrollY / max).toFixed(4) : 0);
    if (stepsWrap) {
      const r = stepsWrap.getBoundingClientRect();
      const t = Math.min(1, Math.max(0, (innerHeight * 0.8 - r.top) / (r.height + innerHeight * 0.3)));
      stepsWrap.style.setProperty('--line', t.toFixed(3));
    }
  };
  addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  // Brillo que sigue al cursor
  if (finePointer && !reduce) {
    addEventListener('pointermove', (e) => {
      root.style.setProperty('--mx', `${e.clientX}px`);
      root.style.setProperty('--my', `${e.clientY}px`);
    }, { passive: true });
  }

  // Texto que se escribe y borra en el título
  const typer = document.querySelector('.typer');
  if (typer && !reduce) {
    const words = typer.dataset.words.split('|');
    let w = 0, c = words[0].length, deleting = true;
    const tick = () => {
      const word = words[w];
      typer.textContent = word.slice(0, c);
      if (deleting) {
        c--;
        if (c < 0) { deleting = false; w = (w + 1) % words.length; c = 0; }
        setTimeout(tick, 45);
      } else {
        c++;
        if (c > words[w].length) { deleting = true; c = words[w].length; setTimeout(tick, 2200); return; }
        setTimeout(tick, 85);
      }
    };
    setTimeout(tick, 2600);
  }

  // Código que se escribe solo en la ventana del hero
  const codeEl = document.querySelector('.code-typer');
  if (codeEl) {
    const lines = [
      ['c', '// tu web, a medida'],
      ['k', 'const ', 'f', 'web', '', ' = ', 'f', 'crear', '', '({'],
      ['', '  diseño: ', 's', '"único"', '', ','],
      ['', '  velocidad: ', 's', '"⚡ máxima"', '', ','],
      ['', '  pagos: ', 's', '"🌎 internacionales"', '', ','],
      ['', '  responsive: ', 'k', 'true', '', ','],
      ['', '});'],
      ['f', 'web', '', '.', 'f', 'publicar', '', '(); ', 'c', '// ✨'],
    ];
    const html = lines.map((parts) => {
      let out = '';
      for (let i = 0; i < parts.length; i += 2) {
        const cls = parts[i], txt = parts[i + 1].replace(/&/g, '&amp;').replace(/</g, '&lt;');
        out += cls ? `<span class="${cls}">${txt}</span>` : txt;
      }
      return out;
    });
    if (reduce) {
      codeEl.innerHTML = html.join('\n');
    } else {
      // Escribe carácter por carácter respetando los colores
      const tmp = document.createElement('div');
      let line = 0;
      const typeLine = () => {
        if (line >= html.length) {
          setTimeout(() => { codeEl.innerHTML = ''; line = 0; typeLine(); }, 5000);
          return;
        }
        tmp.innerHTML = html[line];
        const nodes = [...tmp.childNodes].map((n) => ({ cls: n.nodeType === 1 ? n.className : '', txt: n.textContent }));
        const lineEl = document.createElement('span');
        codeEl.appendChild(lineEl);
        let n = 0, ch = 0, cur = null;
        const step = () => {
          if (n >= nodes.length) { codeEl.appendChild(document.createTextNode('\n')); line++; setTimeout(typeLine, 180); return; }
          if (ch === 0) { cur = document.createElement('span'); if (nodes[n].cls) cur.className = nodes[n].cls; lineEl.appendChild(cur); }
          const chars = [...nodes[n].txt];
          cur.textContent += chars[ch++] ?? '';
          if (ch >= chars.length) { n++; ch = 0; }
          setTimeout(step, 28 + Math.random() * 40);
        };
        step();
      };
      setTimeout(typeLine, 900);
    }
  }

  // Contadores animados
  const counters = document.querySelectorAll('[data-count]');
  const runCounter = (el) => {
    const end = +el.dataset.count, suffix = el.dataset.suffix || '';
    if (reduce) { el.textContent = end + suffix; return; }
    const t0 = performance.now(), dur = 1600;
    const frame = (t) => {
      const k = Math.min(1, (t - t0) / dur), eased = 1 - Math.pow(1 - k, 3);
      el.textContent = Math.round(end * eased) + suffix;
      if (k < 1) requestAnimationFrame(frame);
    };
    requestAnimationFrame(frame);
  };
  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver((ents) => ents.forEach((en) => {
      if (en.isIntersecting) { runCounter(en.target); io.unobserve(en.target); }
    }), { threshold: 0.6 });
    counters.forEach((c) => io.observe(c));
  } else counters.forEach(runCounter);

  if (!finePointer || reduce) return;

  // Inclinación 3D y reflejo en tarjetas y ventana de código
  document.querySelectorAll('.tilt').forEach((el) => {
    const max = el.classList.contains('browser') ? 10 : 7;
    el.addEventListener('pointermove', (e) => {
      const r = el.getBoundingClientRect();
      const x = (e.clientX - r.left) / r.width, y = (e.clientY - r.top) / r.height;
      el.style.transform = `rotateY(${(x - 0.5) * max}deg) rotateX(${(0.5 - y) * max}deg) translateY(-4px)`;
      el.style.setProperty('--sx', `${x * 100}%`);
      el.style.setProperty('--sy', `${y * 100}%`);
    });
    el.addEventListener('pointerleave', () => { el.style.transform = ''; });
  });

  // Botones "magnéticos"
  document.querySelectorAll('.magnetic').forEach((b) => {
    b.addEventListener('pointermove', (e) => {
      const r = b.getBoundingClientRect();
      b.style.transform = `translate(${(e.clientX - r.left - r.width / 2) * 0.25}px, ${(e.clientY - r.top - r.height / 2) * 0.35}px)`;
    });
    b.addEventListener('pointerleave', () => { b.style.transform = ''; });
  });
})();

// Fondo de partículas conectadas en el hero (reacciona al mouse)
(() => {
  const canvas = document.querySelector('.hero__canvas');
  if (!canvas || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  const ctx = canvas.getContext('2d');
  const hero = canvas.parentElement;
  const mouse = { x: -9999, y: -9999 };
  let w, h, dpr, pts = [], running = true;

  const resize = () => {
    dpr = Math.min(devicePixelRatio || 1, 2);
    w = hero.clientWidth; h = hero.clientHeight;
    canvas.width = w * dpr; canvas.height = h * dpr;
    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    const n = Math.round(Math.min(90, (w * h) / 16000));
    pts = Array.from({ length: n }, () => ({
      x: Math.random() * w, y: Math.random() * h,
      vx: (Math.random() - 0.5) * 0.35, vy: (Math.random() - 0.5) * 0.35, r: Math.random() * 1.8 + 0.8,
    }));
  };

  const draw = () => {
    if (!running) return;
    ctx.clearRect(0, 0, w, h);
    const link = 130;
    for (const p of pts) {
      p.x += p.vx; p.y += p.vy;
      if (p.x < 0 || p.x > w) p.vx *= -1;
      if (p.y < 0 || p.y > h) p.vy *= -1;
      const dx = p.x - mouse.x, dy = p.y - mouse.y, d = Math.hypot(dx, dy);
      if (d > 0 && d < 140) { p.x += dx / d * 1.2; p.y += dy / d * 1.2; } // se apartan del cursor
    }
    for (let i = 0; i < pts.length; i++) {
      const a = pts[i];
      for (let j = i + 1; j < pts.length; j++) {
        const b = pts[j], d = Math.hypot(a.x - b.x, a.y - b.y);
        if (d < link) {
          ctx.strokeStyle = `rgba(168, 101, 109, ${(1 - d / link) * 0.35})`;
          ctx.lineWidth = 1;
          ctx.beginPath(); ctx.moveTo(a.x, a.y); ctx.lineTo(b.x, b.y); ctx.stroke();
        }
      }
      const md = Math.hypot(a.x - mouse.x, a.y - mouse.y);
      if (md < 200) {
        ctx.strokeStyle = `rgba(168, 101, 109, ${(1 - md / 200) * 0.5})`;
        ctx.beginPath(); ctx.moveTo(a.x, a.y); ctx.lineTo(mouse.x, mouse.y); ctx.stroke();
      }
      ctx.fillStyle = 'rgba(168, 101, 109, .7)';
      ctx.beginPath(); ctx.arc(a.x, a.y, a.r, 0, Math.PI * 2); ctx.fill();
    }
    requestAnimationFrame(draw);
  };

  hero.addEventListener('pointermove', (e) => {
    const r = canvas.getBoundingClientRect();
    mouse.x = e.clientX - r.left; mouse.y = e.clientY - r.top;
  });
  hero.addEventListener('pointerleave', () => { mouse.x = mouse.y = -9999; });
  addEventListener('resize', resize);
  // Pausa la animación cuando el hero no se ve (ahorra batería)
  new IntersectionObserver(([en]) => {
    const was = running; running = en.isIntersecting;
    if (running && !was) requestAnimationFrame(draw);
  }).observe(hero);
  resize();
  draw();
})();

// Vitrina de la portada: rota entre Página web, Tienda y Software
(() => {
  const show = document.querySelector('.showcase');
  if (!show) return;
  const tabs = [...document.querySelectorAll('.showcase__tabs button')];
  const scr = [...show.querySelectorAll('.scr')];
  const pscr = [...show.querySelectorAll('.pscr')];
  const url = show.querySelector('.mini-url');
  const bar = document.querySelector('.showcase__bar i');
  const urls = ['lumenestudio.com', 'tiendaaura.com', 'app.novagestion.com'];
  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const DUR = 5000;
  let i = 0, timer;

  const go = (n) => {
    i = (n + scr.length) % scr.length;
    [scr, pscr].forEach((list) => list.forEach((el, k) => el.classList.toggle('is-active', k === i)));
    tabs.forEach((t, k) => t.setAttribute('aria-selected', String(k === i)));
    url.style.opacity = 0;
    setTimeout(() => { url.textContent = urls[i]; url.style.opacity = 1; }, 250);
    if (bar && !reduce) { bar.classList.remove('run'); void bar.offsetWidth; bar.style.setProperty('--dur', DUR + 'ms'); bar.classList.add('run'); }
  };
  const start = () => { if (reduce) return; clearInterval(timer); timer = setInterval(() => go(i + 1), DUR); };

  tabs.forEach((t) => t.addEventListener('click', () => { go(+t.dataset.i); start(); }));
  show.addEventListener('pointerenter', () => { clearInterval(timer); bar?.classList.remove('run'); });
  show.addEventListener('pointerleave', () => { go(i); start(); });
  go(0);
  start();
})();
