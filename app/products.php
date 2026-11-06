<?php
/**
 * Catálogo. Para cambiar textos o el precio de la Página simple, editá acá.
 *
 * mode:
 *   'fixed' -> precio fijo, se paga directo desde la web (anticipo según deposit_percent).
 *   'quote' -> a presupuesto: el cliente pide cotización, vos le mandás un link de pago firmado.
 */
return [
    'pagina-simple' => [
        'name'     => 'Página simple',
        'tagline'  => 'Landing, portfolio o presentación',
        'mode'     => 'fixed',
        'price'    => 290,          // USD. Anticipo 50% = USD 145
        'deposit_percent' => 50,    // 50% al inicio, 50% antes de publicar (según tus Condiciones)
        'features' => [
            'Hasta 2 secciones',
            'Diseño responsive a medida',
            'Formulario de contacto y WhatsApp',
            'SEO básico y velocidad optimizada',
            'Publicación en tu dominio',
        ],
    ],
    'ecommerce' => [
        'name'     => 'Tienda online',
        'tagline'  => 'E-commerce listo para vender',
        'mode'     => 'quote',
        'featured' => true,
        'features' => [
            'Hasta 4 secciones + tienda',
            'Catálogo, carrito y checkout',
            'Pasarela de pagos internacional',
            'Panel para cargar productos',
            'Capacitación de uso',
        ],
    ],
    'software-web' => [
        'name'     => 'Software web',
        'tagline'  => 'Dashboards y sistemas a medida',
        'mode'     => 'quote',
        'features' => [
            'Relevamiento de tu proceso',
            'Paneles, reportes y usuarios',
            'Integraciones con otras herramientas',
            'Desarrollo por etapas',
            'Como complemento de tu web o independiente',
        ],
    ],
    'mantenimiento' => [
        'name'     => 'Mantenimiento',
        'tagline'  => 'Tu web siempre al día',
        'mode'     => 'quote',
        'plans'    => [
            'mensual' => 'Plan mensual (mínimo 6 meses)',
            'anual'   => 'Plan anual con promo (1 o 2 cuotas)',
        ],
        'features' => [
            'Actualizaciones y cambios de contenido',
            'Copias de seguridad',
            'Monitoreo y soporte',
            'Desarrollo inicial a valor reducido',
        ],
    ],
];
