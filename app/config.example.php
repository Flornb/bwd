<?php
/**
 * Configuración de Bohn Web Design.
 *
 * 1. Copiá este archivo como config.php (en esta misma carpeta /app).
 * 2. Completá tus datos. config.php NUNCA se sube a GitHub (está en .gitignore)
 *    y vive FUERA de public_html, así nadie lo puede abrir desde el navegador.
 */
return [
    'site_name'     => 'Bohn Web Design',
    'base_url'      => 'https://bohnwebdesign.com.ar',   // sin barra final
    'contact_email' => 'hola@bohnwebdesign.com.ar',      // donde te llegan los presupuestos y pagos
    'whatsapp'      => '',                           // ej: 5491112345678 (vacío = no se muestra)
    'instagram'     => '',                           // ej: bohnwebdesign

    // Moneda en la que cobrás a clientes del exterior.
    'currency' => 'USD',

    // dLocal Go: claves en Dashboard > Integraciones > API.
    // Mientras api_key esté vacío, los botones de pago se muestran
    // pero avisan que el pago online todavía no está activo.
    'dlocal' => [
        'env'        => 'sandbox',   // 'sandbox' para pruebas, 'live' para cobrar de verdad
        'api_key'    => '',
        'secret_key' => '',
    ],

    // Clave para firmar los links de pago de presupuestos.
    // Poné un texto largo y aleatorio (ej. 40+ caracteres). Si lo cambiás,
    // los links que ya enviaste dejan de funcionar.
    'link_secret' => 'CAMBIAR-esto-por-un-texto-largo-y-aleatorio',

    // Contraseña del panel /admin.php (para generar links de pago).
    // Generá el hash con:  php -r "echo password_hash('TU_CLAVE', PASSWORD_DEFAULT);"
    // o pegá la clave en /admin.php?hash=1 en tu PC local.
    'admin_password_hash' => '',
];
