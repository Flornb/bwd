<?php
/**
 * Recibe el formulario de presupuesto: te lo manda por email y lo guarda en app/storage/quotes.csv.
 * Responde JSON si viene por fetch (JS), o redirige si el navegador no tiene JS.
 */
require __DIR__ . '/../app/bootstrap.php';

$isAjax = ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'fetch';

function reply(bool $ok, string $msg, bool $isAjax): void
{
    if ($isAjax) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($ok ? 200 : 422);
        echo json_encode(['ok' => $ok, 'message' => $msg], JSON_UNESCAPED_UNICODE);
    } else {
        header('Location: ./?enviado=' . ($ok ? '1' : '0') . '#presupuesto');
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ./#presupuesto');
    exit;
}

// Honeypot: los bots completan el campo oculto.
if (!empty($_POST['website'])) {
    reply(true, '¡Gracias! Te respondo pronto.', $isAjax);
}
if (!csrf_check()) {
    reply(false, 'La sesión expiró. Recargá la página e intentá de nuevo.', $isAjax);
}

$clean = fn(string $k, int $max) => trim(mb_substr(strip_tags((string) ($_POST[$k] ?? '')), 0, $max));
$data = [
    'name'    => $clean('name', 80),
    'email'   => $clean('email', 120),
    'country' => $clean('country', 60),
    'phone'   => $clean('phone', 30),
    'product' => $clean('product', 40),
    'plan'    => $clean('plan', 20),
    'budget'  => $clean('budget', 40),
    'message' => $clean('message', 3000),
];

if ($data['name'] === '' || $data['message'] === '' || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    reply(false, 'Revisá nombre, email y mensaje.', $isAjax);
}
if (!isset($PRODUCTS[$data['product']])) {
    $data['product'] = 'otro';
}
if ($data['product'] !== 'mantenimiento') {
    $data['plan'] = '';
}

$productName = $PRODUCTS[$data['product']]['name'] ?? 'Otro';
store_line('quotes.csv', [date('c'), $data['name'], $data['email'], $data['country'], $data['phone'], $productName, $data['plan'], $data['budget'], $data['message']]);

$body = "Nuevo pedido de presupuesto\n\n"
    . "Nombre: {$data['name']}\nEmail: {$data['email']}\nPaís: {$data['country']}\nWhatsApp: {$data['phone']}\n"
    . "Servicio: {$productName}" . ($data['plan'] ? " ({$data['plan']})" : '') . "\n"
    . "Presupuesto estimado: {$data['budget']}\n\n{$data['message']}\n\n"
    . "Para cobrarle, generá el link en " . base_url('admin.php');
notify_owner('Presupuesto: ' . $productName . ' – ' . $data['name'], $body, $data['email']);

reply(true, '¡Gracias, ' . $data['name'] . '! Te respondo en menos de 48 h hábiles.', $isAjax);
