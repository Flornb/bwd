<?php
require __DIR__ . '/../app/bootstrap.php';
$csrf = csrf_token();
$status = $_GET['estado'] ?? '';
$wa = (string) cfg('whatsapp');
$ig = (string) cfg('instagram');
?>
<!doctype html>
<html lang="es" class="no-js">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e(cfg('site_name')) ?> · Páginas web, tiendas online y software a medida</title>
  <meta name="description" content="Diseño y desarrollo de páginas web, tiendas online y software web a medida. Trabajamos con clientes de todo el mundo y aceptamos pagos internacionales con tarjeta.">
  <meta property="og:title" content="<?= e(cfg('site_name')) ?>">
  <meta property="og:description" content="Páginas web, tiendas online y software a medida.">
  <meta property="og:image" content="<?= e(base_url('assets/img/logo.png')) ?>">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/styles.css?v=4">
</head>
<body>
<div class="progress" aria-hidden="true"></div>
<div class="cursor-glow" aria-hidden="true"></div>

<header class="nav" id="top">
  <div class="wrap nav__inner">
    <a href="#top" class="nav__brand" aria-label="Inicio">
      <img src="assets/img/monogram.png" alt="" width="48" height="30">
      <span>Bohn <em>Web Design</em></span>
    </a>
    <button class="nav__toggle" aria-label="Abrir menú" aria-expanded="false">
      <span></span><span></span>
    </button>
    <nav class="nav__links">
      <a href="#servicios">Servicios</a>
      <a href="#proceso">Cómo trabajo</a>
      <a href="#pagos">Pagos</a>
      <a href="#presupuesto" class="btn btn--small">Pedir presupuesto</a>
    </nav>
  </div>
</header>

<main>
  <?php if (($_GET['enviado'] ?? '') === '1'): ?>
    <div class="notice wrap">¡Gracias! Recibí tu consulta y te respondo pronto.</div>
  <?php endif; ?>
  <?php if ($status === 'cancelado'): ?>
    <div class="notice notice--warn wrap">El pago fue cancelado. Si tuviste algún problema, escribime y lo resolvemos.</div>
  <?php elseif ($status === 'error'): ?>
    <div class="notice notice--warn wrap">No pudimos iniciar el pago en este momento. Probá de nuevo en unos minutos o escribime.</div>
  <?php endif; ?>

  <section class="hero">
    <canvas class="hero__canvas" aria-hidden="true"></canvas>
    <div class="wrap hero__inner">
      <div class="hero__text">
        <p class="eyebrow reveal"><span class="pulse-dot"></span>Diseño & desarrollo web</p>
        <h1 class="reveal">Tu presencia online,<br><span class="typer" data-words="hecha a medida.|que vende.|que trabaja por vos.|lista para el mundo.">hecha a medida.</span></h1>
        <p class="lead reveal">Páginas web, tiendas online y software para negocios de cualquier país. Diseño cuidado, código propio y pagos internacionales con tarjeta.</p>
        <div class="hero__cta reveal">
          <a href="#servicios" class="btn magnetic">Ver servicios</a>
          <a href="#presupuesto" class="btn btn--ghost magnetic">Contame tu proyecto</a>
        </div>
      </div>
      <div class="hero__art reveal">
        <div class="showcase" data-active="0">
          <div class="laptop tilt" aria-hidden="true">
            <div class="laptop__screen">
              <div class="mini-bar"><i></i><i></i><i></i><span class="mini-url">lumenestudio.com</span></div>
              <div class="screens">
                <!-- 1. Landing -->
                <div class="scr scr--landing is-active">
                  <div class="m-nav"><b>Lumen</b><span></span><span></span><span></span></div>
                  <div class="m-hero">
                    <div><small>Estudio de arquitectura</small><strong>Espacios que<br>inspiran.</strong><em>Agendá una visita</em></div>
                    <div class="m-photo"></div>
                  </div>
                  <div class="m-cols"><span></span><span></span><span></span></div>
                </div>
                <!-- 2. Tienda -->
                <div class="scr scr--shop">
                  <div class="m-nav"><b>Aura</b><span></span><span></span><span class="m-cart">🛒 2</span></div>
                  <div class="m-grid">
                    <div class="m-prod"><i class="p1"></i><span>Vela Ámbar</span><b>USD 18</b></div>
                    <div class="m-prod"><i class="p2"></i><span>Difusor Rosa</span><b>USD 32</b></div>
                    <div class="m-prod"><i class="p3"></i><span>Set Spa</span><b>USD 45</b></div>
                  </div>
                  <div class="m-pay">✓ Pago aprobado · Visa •••• 4242</div>
                </div>
                <!-- 3. Software -->
                <div class="scr scr--app">
                  <div class="m-side"><b>Nova</b><span class="on"></span><span></span><span></span><span></span></div>
                  <div class="m-dash">
                    <div class="m-kpis"><div><small>Ventas hoy</small><b>$ 482k</b></div><div><small>Turnos</small><b>36</b></div><div><small>Clientes</small><b>1.204</b></div></div>
                    <div class="m-chart"><i style="--h:40%"></i><i style="--h:65%"></i><i style="--h:50%"></i><i style="--h:80%"></i><i style="--h:60%"></i><i style="--h:92%"></i><i style="--h:74%"></i></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="laptop__base"></div>
          </div>
          <div class="phone" aria-hidden="true">
            <div class="phone__screen">
              <div class="pscr is-active"><div class="m-photo"></div><strong>Espacios que inspiran.</strong><em>Agendá una visita</em></div>
              <div class="pscr"><i class="p2"></i><span>Difusor Rosa</span><b>USD 32</b><em>Comprar</em></div>
              <div class="pscr"><small>Turnos hoy</small><b class="big">36</b><div class="m-chart"><i style="--h:50%"></i><i style="--h:80%"></i><i style="--h:65%"></i><i style="--h:95%"></i></div></div>
            </div>
          </div>
          <div class="float-chip chip--1" aria-hidden="true">🔒 Pagos seguros</div>
          <div class="float-chip chip--3" aria-hidden="true">📱 Perfecta en celular</div>
        </div>
        <div class="showcase__tabs" role="tablist" aria-label="Ejemplos de trabajos">
          <button role="tab" aria-selected="true" data-i="0">Página web</button>
          <button role="tab" aria-selected="false" data-i="1">Tienda online</button>
          <button role="tab" aria-selected="false" data-i="2">Software</button>
          <span class="showcase__bar"><i></i></span>
        </div>
      </div>
    </div>
    <a href="#servicios" class="scroll-hint" aria-label="Bajar"><span></span></a>
  </section>

  <div class="marquee" aria-label="Lo que incluye trabajar conmigo">
    <div class="marquee__track">
      <?php
      $icon = [
          'lock'  => '<rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/>',
          'card'  => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 10h18M7 15h3"/>',
          'sync'  => '<path d="M20 11a8 8 0 0 0-14.9-3M4 4v4h4M4 13a8 8 0 0 0 14.9 3M20 20v-4h-4"/>',
          'star'  => '<path d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1 6.2L12 17.3 6.5 20.2l1-6.2L3 9.6l6.2-.9z"/>',
          'phone' => '<rect x="7" y="2" width="10" height="20" rx="2"/><path d="M11 18h2"/>',
          'search'=> '<circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>',
          'bolt'  => '<path d="M13 2 4 14h7l-1 8 9-12h-7z"/>',
          'globe' => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 0 1 0 18M12 3a14 14 0 0 0 0 18"/>',
          'chat'  => '<path d="M21 12a8 8 0 0 1-11.6 7.1L4 21l1.9-5.4A8 8 0 1 1 21 12z"/>',
          'shield'=> '<path d="M12 3 4 6v6c0 5 3.4 8.3 8 9 4.6-.7 8-4 8-9V6z"/><path d="m9 12 2 2 4-4"/>',
      ];
      $benefits = [
          ['card', 'Plataforma de pagos segura'],
          ['sync', 'Mantenimiento y actualizaciones'],
          ['shield', 'Seguridad y certificado SSL'],
          ['star', 'Presencia profesional'],
          ['phone', 'Se ve perfecto en celulares'],
          ['search', 'Preparada para Google'],
          ['bolt', 'Carga rápida'],
          ['globe', 'Cobros desde cualquier país'],
          ['chat', 'Soporte personalizado'],
          ['lock', 'Tu dominio y tus datos son tuyos'],
      ];
      for ($i = 0; $i < 2; $i++): foreach ($benefits as [$ic, $label]): ?>
        <span<?= $i ? ' aria-hidden="true"' : '' ?>><svg viewBox="0 0 24 24" aria-hidden="true"><?= $icon[$ic] ?></svg><?= e($label) ?></span>
      <?php endforeach; endfor; ?>
    </div>
  </div>

  <section class="stats">
    <div class="wrap stats__grid">
      <div class="stat reveal"><strong data-count="100" data-suffix="%">0</strong><span>código propio, sin plantillas</span></div>
      <div class="stat reveal"><strong data-count="48" data-suffix=" h">0</strong><span>para recibir tu presupuesto</span></div>
      <div class="stat reveal"><strong data-count="24" data-suffix="/7">0</strong><span>cobros online con tarjeta</span></div>
      <div class="stat reveal"><strong data-count="4" data-suffix="">0</strong><span>servicios para crecer</span></div>
    </div>
  </section>

  <section class="section" id="servicios">
    <div class="wrap">
      <header class="section__head reveal">
        <p class="eyebrow">Servicios</p>
        <h2>Elegí cómo empezar</h2>
        <p>Los proyectos a medida se cotizan según alcance. Te envío un presupuesto y un link de pago seguro.</p>
      </header>

      <div class="cards">
        <?php foreach ($PRODUCTS as $id => $p): ?>
          <article class="card tilt spot reveal<?= !empty($p['featured']) ? ' card--featured' : '' ?>">
            <?php if (!empty($p['featured'])): ?><span class="card__badge">Más pedido</span><?php endif; ?>
            <h3><?= e($p['name']) ?></h3>
            <p class="card__tagline"><?= e($p['tagline']) ?></p>

            <div class="card__price">
              <?php if ($p['mode'] === 'fixed'): ?>
                <strong><?= e(money((float) $p['price'])) ?></strong>
                <small>pago único · <?= (int) $p['deposit_percent'] ?>% para comenzar</small>
              <?php else: ?>
                <strong>A presupuesto</strong>
                <small><?= isset($p['plans']) ? 'planes mensuales y anuales' : 'según alcance del proyecto' ?></small>
              <?php endif; ?>
            </div>

            <ul class="card__list">
              <?php foreach ($p['features'] as $f): ?><li><?= e($f) ?></li><?php endforeach; ?>
            </ul>

            <?php if ($p['mode'] === 'fixed'): ?>
              <form action="checkout.php" method="post" class="card__action">
                <input type="hidden" name="csrf" value="<?= e($csrf) ?>">
                <input type="hidden" name="product" value="<?= e($id) ?>">
                <button class="btn btn--block" type="submit">
                  Reservar · <?= e(money((float) $p['price'] * $p['deposit_percent'] / 100)) ?>
                </button>
                <a href="#presupuesto" class="link" data-product="<?= e($id) ?>">Prefiero consultar antes</a>
              </form>
            <?php else: ?>
              <div class="card__action">
                <a href="#presupuesto" class="btn btn--block<?= empty($p['featured']) ? ' btn--ghost' : '' ?>" data-product="<?= e($id) ?>">Pedir presupuesto</a>
              </div>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section build">
    <div class="wrap">
      <header class="section__head reveal">
        <p class="eyebrow">Software web</p>
        <h2>Lo que tu negocio necesita, en un solo sistema</h2>
        <p>Desarrollo herramientas a medida que te ahorran tiempo y te dan control. Algunas ideas:</p>
      </header>
    </div>
    <?php $mods = ["Turnos y reservas online", "Gestión de clientes", "Control de stock", "Catálogo online", "Panel de ventas", "Facturación y presupuestos", "Pedidos por WhatsApp", "Área de clientes", "Reportes y métricas", "Formularios a medida", "Inscripciones y cursos", "Multi-sucursal"];
    foreach ([$mods, array_reverse($mods)] as $row => $list): ?>
      <div class="build__row<?= $row ? ' build__row--rev' : '' ?>">
        <div class="build__track">
          <?php for ($i = 0; $i < 2; $i++): foreach ($list as $m): ?><span<?= $i ? ' aria-hidden="true"' : '' ?>><?= e($m) ?></span><?php endforeach; endfor; ?>
        </div>
      </div>
    <?php endforeach; ?>
    <div class="wrap build__cta reveal">
      <a href="#presupuesto" class="btn magnetic" data-product="software-web">Contame qué necesitás automatizar</a>
    </div>
  </section>

  <section class="section section--dark" id="proceso">
    <div class="wrap">
      <header class="section__head reveal">
        <p class="eyebrow">Cómo trabajo</p>
        <h2>Simple, claro y por etapas</h2>
      </header>
      <div class="steps-wrap">
      <div class="steps__line" aria-hidden="true"><i></i></div>
      <ol class="steps">
        <li class="reveal"><span>01</span><h3>Me contás tu idea</h3><p>Completás el formulario y coordinamos una charla para definir alcance, tiempos y estilo.</p></li>
        <li class="reveal"><span>02</span><h3>Presupuesto y anticipo</h3><p>Recibís un presupuesto detallado y un link de pago. Con el 50% arrancamos.</p></li>
        <li class="reveal"><span>03</span><h3>Diseño y desarrollo</h3><p>Te muestro avances, ajustamos juntos y revisamos la versión final.</p></li>
        <li class="reveal"><span>04</span><h3>Publicación</h3><p>Con el 50% restante publico tu sitio en tu dominio. Si querés, sigo cuidándolo con mantenimiento.</p></li>
      </ol>
      </div>

      <div class="modes reveal">
        <div>
          <h3>Desarrollo sin mantenimiento</h3>
          <p>Valor único, en dos pagos (50% inicio, 50% previo a publicar). Sin soporte posterior.</p>
        </div>
        <div>
          <h3>Desarrollo + mantenimiento</h3>
          <p>Desarrollo inicial a valor reducido y una cuota mensual, con un mínimo de 6 meses. Renovación anual en 1 o 2 cuotas.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="section" id="pagos">
    <div class="wrap pay reveal">
      <div>
        <p class="eyebrow">Pagos internacionales</p>
        <h2>Pagás desde cualquier país</h2>
        <p>Los cobros se procesan con <strong>dLocal Go</strong>: tarjeta de crédito, débito y medios de pago locales de tu país, en un checkout seguro. Nunca vemos ni guardamos los datos de tu tarjeta.</p>
      </div>
      <div class="pay__box">
        <h3>¿Ya tenés tu presupuesto?</h3>
        <p>Usá el link de pago que te envié por email o WhatsApp. Ahí vas a ver el detalle y el monto acordado antes de pagar.</p>
        <a href="#presupuesto" class="link">¿No lo encontrás? Escribime</a>
      </div>
    </div>
  </section>

  <section class="section section--tint" id="presupuesto">
    <div class="wrap quote">
      <header class="section__head reveal">
        <p class="eyebrow">Presupuesto</p>
        <h2>Contame tu proyecto</h2>
        <p><span class="free-badge">Primera consulta sin cargo</span><br>Te respondo en menos de 48 horas hábiles con una propuesta.</p>
      </header>

      <form class="form reveal" action="presupuesto.php" method="post" novalidate>
        <input type="hidden" name="csrf" value="<?= e($csrf) ?>">
        <div class="hp" aria-hidden="true"><label>Empresa web <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

        <div class="form__row">
          <label>Nombre<input type="text" name="name" required maxlength="80" autocomplete="name"></label>
          <label>Email<input type="email" name="email" required maxlength="120" autocomplete="email"></label>
        </div>
        <div class="form__row">
          <label>País<input type="text" name="country" maxlength="60" autocomplete="country-name"></label>
          <label>WhatsApp (opcional)<input type="tel" name="phone" maxlength="30" autocomplete="tel"></label>
        </div>
        <div class="form__row">
          <label>Servicio
            <select name="product" required>
              <?php foreach ($PRODUCTS as $id => $p): ?>
                <option value="<?= e($id) ?>"><?= e($p['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </label>
          <label class="plan-field" hidden>Plan de mantenimiento
            <select name="plan">
              <?php foreach ($PRODUCTS['mantenimiento']['plans'] as $k => $label): ?>
                <option value="<?= e($k) ?>"><?= e($label) ?></option>
              <?php endforeach; ?>
            </select>
          </label>
          <label>Presupuesto estimado (opcional)
            <select name="budget">
              <option value="">Prefiero no decir</option>
              <option>Menos de USD 500</option>
              <option>USD 500 – 1.500</option>
              <option>USD 1.500 – 5.000</option>
              <option>Más de USD 5.000</option>
            </select>
          </label>
        </div>
        <label>¿Qué necesitás?<textarea name="message" rows="5" required maxlength="3000" placeholder="Contame sobre tu negocio, qué querés lograr y si tenés referencias o plazos."></textarea></label>

        <button class="btn" type="submit">Enviar consulta</button>
        <p class="form__status" role="status" aria-live="polite"></p>
      </form>
    </div>
  </section>
</main>

<footer class="footer">
  <div class="wrap footer__inner">
    <img src="assets/img/logo.png" alt="Bohn Web Design" width="160" height="89">
    <div class="footer__links">
      <a href="mailto:<?= e(cfg('contact_email')) ?>"><?= e(cfg('contact_email')) ?></a>
      <?php if ($wa !== ''): ?><a href="https://wa.me/<?= e($wa) ?>" target="_blank" rel="noopener">WhatsApp</a><?php endif; ?>
      <?php if ($ig !== ''): ?><a href="https://instagram.com/<?= e($ig) ?>" target="_blank" rel="noopener">Instagram</a><?php endif; ?>
    </div>
    <p>© <?= date('Y') ?> <?= e(cfg('site_name')) ?></p>
  </div>
</footer>

<?php if ($wa !== ''): ?>
  <a class="wa-float" href="https://wa.me/<?= e($wa) ?>" target="_blank" rel="noopener" aria-label="Escribime por WhatsApp">
    <svg viewBox="0 0 24 24" width="26" height="26" aria-hidden="true"><path fill="currentColor" d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2Zm0 18.2a8.2 8.2 0 0 1-4.2-1.2l-.3-.2-3 .8.8-2.9-.2-.3A8.2 8.2 0 1 1 12 20.2Zm4.5-6.1c-.2-.1-1.5-.7-1.7-.8-.2-.1-.4-.1-.6.1l-.8 1c-.1.2-.3.2-.5.1a6.7 6.7 0 0 1-3.3-2.9c-.2-.4.2-.4.7-1.3.1-.2 0-.3 0-.4l-.8-1.8c-.2-.5-.4-.4-.6-.4h-.5a1 1 0 0 0-.7.3 3 3 0 0 0-.9 2.2 5.2 5.2 0 0 0 1.1 2.7 11.8 11.8 0 0 0 4.5 4c1.7.7 2.3.8 3.1.6.5-.1 1.5-.6 1.7-1.2.2-.6.2-1.1.1-1.2l-.8-.3Z"/></svg>
  </a>
<?php endif; ?>

<script src="assets/js/main.js?v=3" defer></script>
</body>
</html>
