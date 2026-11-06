<?php
declare(strict_types=1);

// Carga config.php si existe; si no, el ejemplo (modo demo, sin pagos activos).
$configFile = __DIR__ . '/config.php';
$CONFIG = require (is_file($configFile) ? $configFile : __DIR__ . '/config.example.php');
$PRODUCTS = require __DIR__ . '/products.php';

require __DIR__ . '/DlocalGo.php';

const STORAGE_DIR = __DIR__ . '/storage';

function cfg(string $key, $default = null)
{
    global $CONFIG;
    $value = $CONFIG;
    foreach (explode('.', $key) as $part) {
        if (!is_array($value) || !array_key_exists($part, $value)) {
            return $default;
        }
        $value = $value[$part];
    }
    return $value;
}

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function money(float $amount, ?string $currency = null): string
{
    $currency = $currency ?: cfg('currency', 'USD');
    $decimals = floor($amount) == $amount ? 0 : 2;
    return $currency . ' ' . number_format($amount, $decimals, ',', '.');
}

function payments_enabled(): bool
{
    return cfg('dlocal.api_key') !== '' && cfg('dlocal.secret_key') !== '';
}

function dlocal(): DlocalGo
{
    return new DlocalGo(cfg('dlocal.api_key'), cfg('dlocal.secret_key'), cfg('dlocal.env', 'sandbox'));
}

function base_url(string $path = ''): string
{
    return rtrim((string) cfg('base_url'), '/') . '/' . ltrim($path, '/');
}

/** Guarda una línea en app/storage/<file> (fuera del webroot). */
function store_line(string $file, array $row): void
{
    if (!is_dir(STORAGE_DIR)) {
        @mkdir(STORAGE_DIR, 0750, true);
    }
    $fh = @fopen(STORAGE_DIR . '/' . $file, 'a');
    if ($fh) {
        fputcsv($fh, $row);
        fclose($fh);
    }
}

function notify_owner(string $subject, string $body, ?string $replyTo = null): void
{
    $to = (string) cfg('contact_email');
    if ($to === '' || str_contains($to, 'tudominio')) {
        return;
    }
    $headers = [
        'From: ' . cfg('site_name') . ' <' . $to . '>',
        'Content-Type: text/plain; charset=UTF-8',
    ];
    if ($replyTo && filter_var($replyTo, FILTER_VALIDATE_EMAIL)) {
        $headers[] = 'Reply-To: ' . $replyTo;
    }
    @mail($to, '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, implode("\r\n", $headers));
}

/* ---------- Links de pago firmados (presupuestos "a acordar") ---------- */

function link_secret_ready(): bool
{
    $secret = (string) cfg('link_secret');
    return strlen($secret) >= 24 && !str_starts_with($secret, 'CAMBIAR');
}

function payment_link_signature(string $ref, string $amount, string $currency, string $desc): string
{
    return hash_hmac('sha256', implode('|', [$ref, $amount, $currency, $desc]), (string) cfg('link_secret'));
}

function make_payment_link(string $ref, float $amount, string $currency, string $desc): string
{
    $amountStr = number_format($amount, 2, '.', '');
    $query = http_build_query([
        'ref'  => $ref,
        'amt'  => $amountStr,
        'cur'  => $currency,
        'desc' => $desc,
        'sig'  => payment_link_signature($ref, $amountStr, $currency, $desc),
    ]);
    return base_url('pagar.php?' . $query);
}

/** Devuelve los datos del link si la firma es válida, o null si fue alterado. */
function read_payment_link(array $q): ?array
{
    foreach (['ref', 'amt', 'cur', 'desc', 'sig'] as $k) {
        if (!isset($q[$k]) || !is_string($q[$k])) {
            return null;
        }
    }
    $expected = payment_link_signature($q['ref'], $q['amt'], $q['cur'], $q['desc']);
    if (!link_secret_ready() || !hash_equals($expected, $q['sig']) || !is_numeric($q['amt']) || (float) $q['amt'] <= 0) {
        return null;
    }
    return ['ref' => $q['ref'], 'amount' => (float) $q['amt'], 'currency' => $q['cur'], 'desc' => $q['desc']];
}

/* ---------- Protección básica de formularios ---------- */

function csrf_token(): string
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

function csrf_check(): bool
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    return isset($_POST['csrf'], $_SESSION['csrf']) && hash_equals($_SESSION['csrf'], (string) $_POST['csrf']);
}
