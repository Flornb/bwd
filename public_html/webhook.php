<?php
/**
 * dLocal Go avisa acá cuando cambia el estado de un pago.
 * No confiamos en lo que llega: con el payment_id consultamos el estado real a la API.
 */
require __DIR__ . '/../app/bootstrap.php';

$payload = json_decode((string) file_get_contents('php://input'), true) ?: $_POST;
$paymentId = (string) ($payload['payment_id'] ?? $payload['id'] ?? '');

if ($paymentId === '' || !payments_enabled()) {
    http_response_code(400);
    exit;
}

try {
    $p = dlocal()->getPayment($paymentId);
    $status = (string) ($p['status'] ?? 'UNKNOWN');
    store_line('payments.csv', [date('c'), $status, $p['order_id'] ?? '', $paymentId, $p['amount'] ?? '', $p['currency'] ?? '', $p['description'] ?? '']);

    if ($status === 'PAID') {
        notify_owner(
            'Pago recibido: ' . ($p['order_id'] ?? $paymentId),
            "Entró un pago por dLocal Go.\n\nOrden: " . ($p['order_id'] ?? '') . "\nMonto: " . ($p['amount'] ?? '') . ' ' . ($p['currency'] ?? '')
            . "\nDetalle: " . ($p['description'] ?? '') . "\nID dLocal: {$paymentId}"
        );
    }
    http_response_code(200);
    echo 'OK';
} catch (Throwable $ex) {
    error_log('[BWD webhook] ' . $ex->getMessage());
    http_response_code(500); // dLocal Go reintenta
}
