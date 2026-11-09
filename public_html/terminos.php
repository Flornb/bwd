<?php
require __DIR__ . '/../app/bootstrap.php';
$b = $BUSINESS;
$email = (string) cfg('contact_email');
$simple = $PRODUCTS['pagina-simple'];
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Términos y condiciones · <?= e(cfg('site_name')) ?></title>
  <meta name="description" content="Cómo se contratan los servicios de <?= e(cfg('site_name')) ?>: proceso, pagos, plazos, cancelaciones, reembolsos y privacidad.">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/styles.css?v=5">
</head>
<body>
<header class="nav is-scrolled">
  <div class="wrap nav__inner">
    <a href="./" class="nav__brand" aria-label="Inicio">
      <img src="assets/img/monogram.png" alt="" width="48" height="30">
      <span>Bohn <em>Web Design</em></span>
    </a>
    <a href="./" class="btn btn--small btn--ghost">Volver al sitio</a>
  </div>
</header>

<main class="legal">
  <p class="eyebrow">Información legal</p>
  <h1>Términos y condiciones del servicio</h1>
  <p class="updated">Última actualización: 09/11/2026</p>

  <p>Estos términos explican cómo funcionan los servicios de diseño y desarrollo web que ofrece <strong><?= e(cfg('site_name')) ?></strong>, cómo se contratan y qué condiciones aplican. Al pedir un presupuesto o realizar un pago en este sitio, aceptás estas condiciones.</p>

  <nav class="toc" aria-label="Contenido">
    <ol>
      <li><a href="#responsable">Quién presta el servicio</a></li>
      <li><a href="#servicios">Servicios</a></li>
      <li><a href="#contratacion">Cómo se contrata</a></li>
      <li><a href="#precios">Precios y pagos</a></li>
      <li><a href="#modalidades">Modalidades: con o sin mantenimiento</a></li>
      <li><a href="#entrega">Plazos, revisiones y entrega</a></li>
      <li><a href="#cancelaciones">Cancelaciones y reembolsos</a></li>
      <li><a href="#propiedad">Propiedad del sitio y contenidos</a></li>
      <li><a href="#privacidad">Privacidad de tus datos</a></li>
      <li><a href="#contacto">Contacto y jurisdicción</a></li>
    </ol>
  </nav>

  <h2 id="responsable">1. Quién presta el servicio</h2>
  <p>Los servicios son prestados por <strong><?= e($b['legal_name']) ?></strong>, <?= e($b['tax_label']) ?> <?= e($b['tax_id']) ?>, con domicilio en <?= e($b['city']) ?>, bajo el nombre comercial <?= e(cfg('site_name')) ?>. Contacto: <a href="mailto:<?= e($email) ?>"><?= e($email) ?></a><?= $b['phone'] !== '' ? ' · ' . e($b['phone']) : '' ?>.</p>

  <h2 id="servicios">2. Servicios</h2>
  <p>Todos los servicios son <strong>personalizados</strong>: se diseñan y desarrollan a medida de cada cliente. No se venden productos físicos ni plantillas descargables.</p>
  <ul>
    <li><strong>Página simple</strong> (landing, presentación, invitación o portfolio): hasta 2 secciones. Precio fijo publicado: <?= e(money((float) $simple['price'])) ?>.</li>
    <li><strong>Tienda online (e-commerce)</strong>: hasta 4 secciones, tienda online y pasarela de pagos. Precio según presupuesto, con valor de referencia publicado en el sitio.</li>
    <li><strong>Software web</strong>: plataformas, paneles (dashboards) y sistemas a medida. Puede contratarse como complemento de una web o de forma independiente, y se desarrolla por etapas mensuales. Precio según presupuesto.</li>
    <li><strong>Mantenimiento</strong>: actualizaciones, cambios de contenido, copias de seguridad, monitoreo y soporte. Plan mensual o anual, según presupuesto.</li>
  </ul>

  <h2 id="contratacion">3. Cómo se contrata</h2>
  <ol>
    <li><strong>Consulta:</strong> completás el formulario del sitio o escribís por mail. La primera consulta no tiene costo.</li>
    <li><strong>Propuesta:</strong> te envío un presupuesto por escrito con alcance, cantidad de secciones, funcionalidades, plazos y precio. Para la Página simple el precio es el publicado.</li>
    <li><strong>Aceptación y anticipo:</strong> el proyecto comienza al recibir el pago del anticipo, que se abona desde el sitio o con un link de pago personal.</li>
    <li><strong>Desarrollo:</strong> comparto avances y realizamos ajustes según lo acordado.</li>
    <li><strong>Revisión final y publicación:</strong> con tu aprobación y el pago del saldo, el sitio se publica en tu dominio.</li>
  </ol>

  <h2 id="precios">4. Precios y pagos</h2>
  <ul>
    <li>Los precios se expresan en <strong>dólares estadounidenses (USD)</strong>, salvo que el presupuesto indique otra moneda.</li>
    <li>Los pagos se procesan a través de <strong>dLocal Go</strong>, que acepta tarjetas de crédito, débito y medios de pago locales según el país del cliente. <?= e(cfg('site_name')) ?> no recibe ni almacena los datos de tu tarjeta.</li>
    <li>Los desarrollos se abonan en dos partes: <strong>50% al inicio</strong> y <strong>50% en la revisión final</strong>, antes de la publicación.</li>
    <li>Los servicios a presupuesto se pagan con un link de pago personal, enviado por mail o WhatsApp, que muestra el detalle y el monto acordado.</li>
    <li>El presupuesto tiene la vigencia indicada en él. Si no se indica, rige por 15 días.</li>
    <li>No incluye, salvo que el presupuesto diga lo contrario: el costo del dominio, el hosting, licencias de terceros, ni las comisiones de las plataformas de pago que use el cliente en su propio sitio.</li>
  </ul>

  <h2 id="modalidades">5. Modalidades: con o sin mantenimiento</h2>
  <p><strong>Desarrollo sin mantenimiento mensual:</strong> valor único por el desarrollo del sitio, con vigencia de hasta 2 años, abonado en dos etapas (50% al inicio, 50% en la revisión final). No incluye mantenimiento ni soporte posterior a la publicación.</p>
  <p><strong>Desarrollo con mantenimiento mensual:</strong> el desarrollo inicial tiene un valor reducido y se complementa con una cuota mensual. Requiere un <strong>compromiso mínimo de 6 meses</strong>. El mantenimiento es un servicio continuo, independiente de la cantidad de cambios solicitados en un mes determinado.</p>
  <p><strong>Renovaciones anuales:</strong> se realizan mediante un pago único anual, que puede abonarse en una o dos cuotas según lo acordado.</p>

  <h2 id="entrega">6. Plazos, revisiones y entrega</h2>
  <ul>
    <li>Los plazos se fijan en cada presupuesto y empiezan a correr cuando se recibe el anticipo y el material necesario (textos, imágenes, logos, accesos).</li>
    <li>Las demoras en el envío de material o en las aprobaciones del cliente extienden los plazos en la misma medida.</li>
    <li>Cada proyecto incluye las rondas de ajustes indicadas en el presupuesto. Los cambios que excedan el alcance acordado se presupuestan aparte.</li>
    <li>Si el cliente no responde durante 60 días corridos, el proyecto se considera pausado y su reactivación puede requerir un nuevo presupuesto.</li>
  </ul>

  <h2 id="cancelaciones">7. Cancelaciones y reembolsos</h2>
  <p>Por tratarse de servicios personalizados, se aplican estas reglas:</p>
  <ul>
    <li><strong>Antes de comenzar:</strong> si cancelás dentro de las 48 horas posteriores al pago del anticipo y todavía no se inició el trabajo, se reintegra el 100% del anticipo.</li>
    <li><strong>Con el trabajo iniciado:</strong> el anticipo no es reembolsable, porque cubre el trabajo de diseño y desarrollo ya realizado. Se entrega al cliente lo producido hasta ese momento.</li>
    <li><strong>Saldo final:</strong> solo se abona con la aprobación de la revisión final. Si el sitio no se aprueba porque no cumple lo acordado en el presupuesto, se corrige sin costo adicional.</li>
    <li><strong>Mantenimiento:</strong> podés darlo de baja con 30 días de aviso, una vez cumplido el compromiso mínimo de 6 meses. No se reintegran los meses ya abonados.</li>
    <li>Los reembolsos que correspondan se realizan por el mismo medio de pago utilizado, dentro de los 10 días hábiles de acordados. Los tiempos de acreditación dependen de dLocal Go y del emisor de la tarjeta.</li>
    <li>Para cancelar o pedir un reembolso, escribí a <a href="mailto:<?= e($email) ?>"><?= e($email) ?></a> indicando tu nombre y número de orden o presupuesto.</li>
  </ul>

  <h2 id="propiedad">8. Propiedad del sitio y contenidos</h2>
  <ul>
    <li>Una vez abonado el total, el sitio desarrollado y su diseño pertenecen al cliente.</li>
    <li>El dominio se registra a nombre del cliente siempre que sea posible.</li>
    <li>El cliente es responsable de tener los derechos sobre los textos, imágenes y marcas que entrega para el sitio.</li>
    <li><?= e(cfg('site_name')) ?> puede mostrar el trabajo realizado en su portfolio, salvo que el cliente pida lo contrario por escrito.</li>
  </ul>

  <h2 id="privacidad">9. Privacidad de tus datos</h2>
  <ul>
    <li>Los datos que ingresás en el formulario (nombre, email, país, teléfono y mensaje) se usan solo para responder tu consulta y gestionar el servicio. No se venden ni se comparten con terceros.</li>
    <li>Los datos de pago los procesa directamente dLocal Go, según sus propias políticas de seguridad y privacidad.</li>
    <li>Podés pedir que se corrijan o eliminen tus datos escribiendo a <a href="mailto:<?= e($email) ?>"><?= e($email) ?></a>, conforme a la Ley 25.326 de Protección de Datos Personales de Argentina.</li>
  </ul>

  <h2 id="contacto">10. Contacto y jurisdicción</h2>
  <p>Ante cualquier duda o reclamo, escribí a <a href="mailto:<?= e($email) ?>"><?= e($email) ?></a>. Te respondo en un plazo máximo de 48 horas hábiles. Estas condiciones se rigen por las leyes de la República Argentina, y cualquier controversia se somete a los tribunales ordinarios de la ciudad de Córdoba.</p>

  <p style="margin-top:3rem"><a href="./#presupuesto" class="btn">Pedir presupuesto</a></p>
</main>

<footer class="footer">
  <div class="wrap footer__legal" style="border-top:0;margin-top:0;padding-top:0">
    <p><?= e(cfg('site_name')) ?> · <?= e($b['legal_name']) ?> · <?= e($b['tax_label']) ?> <?= e($b['tax_id']) ?> · <?= e($b['city']) ?> · <a href="mailto:<?= e($email) ?>"><?= e($email) ?></a></p>
  </div>
</footer>
</body>
</html>
