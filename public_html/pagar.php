<?php
/**
 * Pago de presupuestos "a acordar".
 * El link lo generás en /admin.php y va firmado: si alguien cambia el monto en la URL, no funciona.
 */
require __DIR__ . '/../app/bootstrap.php';

$src = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;
$link = read_payment_link($src);

if ($link && $_SERVER['REQUEST_METHOD'] === 'POST' && csrf_check()) {
    if (!payments_enabled()) {
        require __DIR__ . '/../app/views/payments_soon.php';
        exit;
    }
    $orderId = $link['ref'] . '-' . strtoupper(bin2hex(random_bytes(2)));
    try {
        $payment = dlocal()->createPayment([
            'amount'           => $link['amount'],
            'currency'         => $link['currency'],
            'order_id'         => $orderId,
            'description'      => $link['desc'],
            'success_url'      => base_url('gracias.php?orden=' . urlencode($orderId)),
            'back_url'         => base_url('?estado=cancelado'),
            'notification_url' => base_url('webhook.php'),
        ]);
        store_line('payments.csv', [date('c'), 'created', $orderId, $payment['id'] ?? '', $link['amount'], $link['currency'], $link['desc']]);
        header('Location: ' . $payment['redirect_url']);
    } catch (Throwable $ex) {
        error_log('[BWD pagar] ' . $ex->getMessage());
        header('Location: ./?estado=error');
    }
    exit;
}

$csrf = csrf_token();
$title = $link ? 'Pagar presupuesto' : 'Link no válido';
require __DIR__ . '/../app/views/layout_top.php';
?>
<?php if (!$link): ?>
  <h1>Este link no es válido</h1>
  <p>Puede que esté incompleto o haya sido modificado. Escribime y te envío uno nuevo.</p>
  <a class="btn" href="./#presupuesto">Contactarme</a>
<?php else: ?>
  <p class="eyebrow">Presupuesto <?= e($link['ref']) ?></p>
  <h1><?= e($link['desc']) ?></h1>
  <p class="amount"><?= e(money($link['amount'], $link['currency'])) ?></p>
  <form method="post">
    <?php foreach (['ref', 'amt', 'cur', 'desc', 'sig'] as $k): ?>
      <input type="hidden" name="<?= $k ?>" value="<?= e($src[$k]) ?>">
    <?php endforeach; ?>
    <input type="hidden" name="csrf" value="<?= e($csrf) ?>">
    <button class="btn btn--block" type="submit">Pagar con tarjeta</button>
  </form>
  <p class="muted">Pago seguro procesado por dLocal Go. Podés pagar con tarjeta o medios locales de tu país.</p>
<?php endif; ?>
<?php require __DIR__ . '/../app/views/layout_bottom.php'; ?>
