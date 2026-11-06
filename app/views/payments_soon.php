<?php
// Se muestra mientras no estén cargadas las claves de dLocal Go en app/config.php.
$title = 'Pago online próximamente';
require __DIR__ . '/layout_top.php';
?>
  <h1>El pago online se está activando</h1>
  <p>Muy pronto vas a poder pagar con tarjeta desde acá. Mientras tanto, escribime y te envío un link de pago directo.</p>
  <a class="btn" href="./#presupuesto">Escribirme</a>
<?php require __DIR__ . '/layout_bottom.php'; ?>
