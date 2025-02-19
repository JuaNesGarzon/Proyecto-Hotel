<?php
// Varios destinatarios
$para  = $email . ', '; // atención a la coma
// $para .= 'susy1505@gmail.com';

// título
$título = 'Rstablecer contraseña hotel deja vu';
$codigo = rand(1000, 9999);

// mensaje
$mensaje = '
<html>
<head>
  <title>Restablecer </title>
</head>
<body>
  <h1>Hotel deja vu</h1>
  <p>Restablecer contraseña</p>
  <p>Tu código es: <b>' . $codigo . '</b></p>
  <p></a href="http://localhost/hotel-Dej%C3%A1%20vu/APP/form/restablecer.php?email= '.$email.'&token= '.$token.'">Verifica tu correo electrónico</a></p>
  <p>Si no has solicitado esto, ignora este correo.</p>
</body>
</html>
';

// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Cabeceras adicionales
// $cabeceras .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
// $cabeceras .= 'From: Recordatorio <cumples@example.com>' . "\r\n";
// $cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
// $cabeceras .= 'Bcc: birthdaycheck@example.com' . "\r\n";

// Enviarlo

$enviado = false;
if (mail($para, $título, $mensaje, $cabeceras)) {
    $enviado = true;
}
mail($para, $título, $mensaje, $cabeceras);
?>