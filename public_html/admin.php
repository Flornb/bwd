<?php
/**
 * Panel privado para generar links de pago de presupuestos.
 * Entrás con la contraseña de app/config.php (admin_password_hash).
 */
require __DIR__ . '/../app/bootstrap.php';
header('X-Robots-Tag: noindex');
$csrf = csrf_token(); // inicia la sesión

$hash = (string) cfg('admin_password_hash');
$error = '';
$link = '';

// Ayuda para generar el hash (solo funciona en tu PC, nunca en el servidor publicado).
$isLocal = in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true);
if ($isLocal && isset($_POST['make_hash'])) {
    $link = password_hash((string) $_POST['make_hash'], PASSWORD_DEFAULT);
}

if (isset($_GET['salir'])) {
    $_SESSION = [];
    session_destroy();
    header('Location: admin.php');
    exit;
}

if (isset($_POST['password']) && csrf_check()) {
    usleep(400000); // frena intentos por fuerza bruta
    if ($hash !== '' && password_verify((string) $_POST['password'], $hash)) {
        session_regenerate_id(true);
        $_SESSION['admin'] = true;
    } else {
        $error = 'Contraseña incorrecta.';
    }
}

$logged = !empty($_SESSION['admin']);

if ($logged && isset($_POST['amount']) && csrf_check()) {
    $ref = preg_replace('/[^A-Za-z0-9\-]/', '', strtoupper((string) $_POST['ref'])) ?: 'P' . date('ymdHi');
    $amount = (float) str_replace(',', '.', (string) $_POST['amount']);
    $currency = preg_replace('/[^A-Z]/', '', strtoupper((string) $_POST['currency'])) ?: cfg('currency');
    $desc = trim(mb_substr(strip_tags((string) $_POST['desc']), 0, 100));
    if ($amount <= 0 || $desc === '') {
        $error = 'Completá monto y detalle.';
    } else {
        $link = make_payment_link($ref, $amount, $currency, $desc);
        store_line('links.csv', [date('c'), $ref, $amount, $currency, $desc, trim((string) ($_POST['client'] ?? ''))]);
    }
}

$title = 'Panel';
require __DIR__ . '/../app/views/layout_top.php';
?>
<?php if (!$logged): ?>
  <h1>Panel</h1>
  <?php if ($hash === ''): ?>
    <p class="muted">Todavía no configuraste la contraseña (admin_password_hash en app/config.php).</p>
    <?php if ($isLocal): ?>
      <form method="post" class="form">
        <label>Escribí tu contraseña para generar el hash<input type="password" name="make_hash" required></label>
        <button class="btn" type="submit">Generar hash</button>
      </form>
      <?php if ($link): ?><p>Copiá esto en config.php:</p><textarea class="copy" readonly rows="3"><?= e($link) ?></textarea><?php endif; ?>
    <?php endif; ?>
  <?php else: ?>
    <form method="post" class="form">
      <input type="hidden" name="csrf" value="<?= e($csrf) ?>">
      <label>Contraseña<input type="password" name="password" required autofocus></label>
      <button class="btn btn--block" type="submit">Entrar</button>
      <?php if ($error): ?><p class="form__status is-error"><?= e($error) ?></p><?php endif; ?>
    </form>
  <?php endif; ?>
<?php else: ?>
  <h1>Generar link de pago</h1>
  <p class="muted">Para presupuestos a acordar, mantenimiento o el 50% final. El link queda firmado: el cliente no puede cambiar el monto.</p>
  <form method="post" class="form">
    <input type="hidden" name="csrf" value="<?= e($csrf) ?>">
    <div class="form__row">
      <label>N° de presupuesto<input name="ref" placeholder="P-0001" maxlength="20"></label>
      <label>Cliente (solo para tu registro)<input name="client" maxlength="80"></label>
    </div>
    <label>Detalle que verá el cliente<input name="desc" required maxlength="100" placeholder="Tienda online – anticipo 50%"></label>
    <div class="form__row">
      <label>Monto<input name="amount" required inputmode="decimal" placeholder="750"></label>
      <label>Moneda<input name="currency" value="<?= e(cfg('currency')) ?>" maxlength="3"></label>
    </div>
    <button class="btn" type="submit">Generar link</button>
    <?php if ($error): ?><p class="form__status is-error"><?= e($error) ?></p><?php endif; ?>
  </form>
  <?php if ($link): ?>
    <p><strong>Link listo para enviar:</strong></p>
    <textarea class="copy" readonly rows="4" onclick="this.select()"><?= e($link) ?></textarea>
    <p><a class="link" href="<?= e($link) ?>" target="_blank">Ver cómo lo ve el cliente</a></p>
  <?php endif; ?>
  <?php if (!link_secret_ready()): ?><p class="notice notice--warn">Falta definir link_secret en app/config.php: hasta entonces los links no se pueden pagar.</p><?php endif; ?>
  <?php if (!payments_enabled()): ?><p class="notice notice--warn">Ojo: dLocal Go todavía no está configurado. El link se ve, pero el pago no se puede completar.</p><?php endif; ?>
  <p><a class="link" href="?salir=1">Salir</a></p>
<?php endif; ?>
<?php require __DIR__ . '/../app/views/layout_bottom.php'; ?>
