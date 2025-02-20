<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../controllers/huespedController.php';

$huespedController = new HuespedController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if ($huespedController->checkEmailExists($email)) {
        $token = bin2hex(random_bytes(32));
        $expiryTime = date('Y-m-d H:i:s', strtotime('+1 hour'));

        if ($huespedController->storeResetToken($email, $token, $expiryTime)) {
            $mail = new PHPMailer(true);
            try {
                // Configuración del servidor
                $mail->isSMTP();
                $mail->Host       = 'sandbox.smtp.mailtrap.io';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'a0116a95c2abbd';
                $mail->Password   = 'ea4471f39ee5c8';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 2525;

                // Destinatarios
                $mail->setFrom('noreply@hoteldejavu.com', 'Hotel Dejá vu');
                $mail->addAddress($email);

                // Contenido
                $mail->isHTML(true);
                $mail->Subject = 'Recuperación de Contraseña - Hotel Dejá vu';
               // En el archivo recovery.php, dentro del cuerpo del correo electrónico
               $resetUrl = 'http://localhost/hotel-Dej%c3%a1%20vu/reset.php?token=' . urlencode($token);
               $mail->Body = "
               <html>
               <body>
               <h2>Recuperación de Contraseña - Hotel Dejá vu</h2>
               <p>Has solicitado restablecer tu contraseña.</p>
               <p>Haz clic en el siguiente enlace para crear una nueva contraseña:</p>
               <a href='$resetUrl'>
               Restablecer Contraseña
               </a>
               <p>Este enlace expirará en 1 hora.</p>
               </body>
               </html>
            ";

                $mail->send();
                echo "<script>alert('Se ha enviado un enlace de recuperación a tu correo electrónico.'); window.location.href='../form/restablecer.php';</script>";
            } catch (Exception $e) {
                echo "<script>alert('Ha ocurrido un error al enviar el correo. Por favor, intenta de nuevo.'); window.location.href='../form/restablecer.php';</script>";
            }
        } else {
            echo "<script>alert('Ha ocurrido un error. Por favor, intenta de nuevo.'); window.location.href='../form/restablecer.php';</script>";
        }
    } else {
        echo "<script>alert('No se encontró una cuenta asociada a este correo electrónico.'); window.location.href='../form/restablecer.php';</script>";
    }
}