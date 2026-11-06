# Bohn Web Design — sitio

Single page en PHP + JS + CSS planos, con mini tienda de 4 servicios y pagos por dLocal Go.

## Estructura

```
app/                 <- privado, va FUERA de public_html en Hostinger
  config.example.php    copialo como config.php y completalo (no se versiona)
  products.php          catálogo: textos y precio de la Página simple
  bootstrap.php         funciones comunes
  DlocalGo.php          conexión con la API de dLocal Go
  views/                plantillas de páginas internas
  storage/              presupuestos, pagos y links generados (CSV)
public_html/         <- lo único público
  index.php             la single page
  checkout.php          cobra productos de precio fijo (anticipo 50%)
  pagar.php             cobra presupuestos con link firmado
  presupuesto.php       recibe el formulario
  admin.php             panel privado para generar links de pago
  webhook.php           dLocal Go avisa acá cuando entra un pago
  gracias.php           página de pago exitoso
```

## Cómo se cobra

| Servicio | Cómo paga el cliente |
|---|---|
| Página simple (precio fijo) | Botón "Reservar" en la web: paga el 50% con tarjeta. El 50% final, con link desde /admin.php |
| E-commerce, Software web, Mantenimiento | Pide presupuesto. Vos generás en /admin.php un link con el monto acordado y se lo mandás. El link está firmado: si alguien toca el monto, deja de funcionar |

También podés seguir usando los links de pago del propio dashboard de dLocal Go; los de /admin.php tienen la ventaja de quedar con tu marca y registrados en app/storage.

## Probar en tu PC

Con PHP instalado: `php -S localhost:8000 -t public_html` y abrí http://localhost:8000

## Subir a Hostinger

1. En hPanel creá el sitio y conectá el dominio de nic.ar (en nic.ar delegá los DNS a `ns1.dns-parking.com` y `ns2.dns-parking.com`, o los que te indique Hostinger).
2. Con el Administrador de archivos, en `domains/TU-DOMINIO/`:
   - el contenido de `public_html/` va dentro de `public_html/`
   - la carpeta `app/` va al lado de `public_html/` (no adentro)
3. Copiá `app/config.example.php` como `app/config.php` y completá email, dominio, `link_secret` y la contraseña del panel.
4. Activá SSL gratuito en hPanel.
5. Pagos: cargá las claves de **sandbox** de dLocal Go, probá una compra con tarjeta de prueba, y recién ahí cambiá a `'env' => 'live'` con las claves reales.
   En el dashboard de dLocal Go poné como URL de notificación `https://TU-DOMINIO/webhook.php`.
