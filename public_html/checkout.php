<?php
/**
 * Pago de productos con precio fijo (ej. Página simple).
 * El precio sale SIEMPRE de app/products.php, nunca del formulario.
 */
require __DIR__ . '/../app/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_check()) {
    header('Location: ./');
    exit;
}

$id = (string) ($_POST['product'] ?? '');
$product = $PRODUCTS[$id] ?? null;
if (!$product || $product['mode'] !== 'fixed') {
    header('Location: ./#servicios');
    exit;
}

if (!payments_enabled()) {
    require __DIR__ . '/../app/views/payments_soon.php';
    exit;
}

$percent = (int) ($product['deposit_percent'] ?? 100);
$amount = round((float) $product['price'] * $percent / 100, 2);
$orderId = 'BWD-' . date('ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));
$label = $product['name'] . ($percent < 100 ? " (anticipo {$percent}%)" : '');

try {
    $payment = dlocal()->createPayment([
        'amount'           => $amount,
        'currency'         => cfg('currency'),
        'order_id'         => $orderId,
        'description'      => $label,
        'success_url'      => base_url('gracias.php?orden=' . urlencode($orderId)),
        'back_url'         => base_url('?estado=cancelado'),
        'notification_url' => base_url('webhook.php'),
    ]);
    store_line('payments.csv', [date('c'), 'created', $orderId, $payment['id'] ?? '', $amount, cfg('currency'), $label]);
    header('Location: ' . $payment['redirect_url']);
} catch (Throwable $ex) {
    error_log('[BWD checkout] ' . $ex->getMessage());
    header('Location: ./?estado=error');
}
