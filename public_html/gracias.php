<?php
require __DIR__ . '/../app/bootstrap.php';
$order = substr(preg_replace('/[^A-Za-z0-9\-]/', '', (string) ($_GET['orden'] ?? '')), 0, 40);
$title = '¡Gracias!';
require __DIR__ . '/../app/views/layout_top.php';
?>
  <h1>¡Gracias por tu pago!</h1>
  <?php if ($order): ?><p class="eyebrow">Orden <?= e($order) ?></p><?php endif; ?>
  <p>Apenas se confirme, te escribo para coordinar los próximos pasos. Si pagaste con un medio en efectivo o transferencia, la confirmación puede demorar unas horas.</p>
  <a class="btn" href="./">Volver al inicio</a>
<?php require __DIR__ . '/../app/views/layout_bottom.php'; ?>
