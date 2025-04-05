<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../controllers/huespedController.php';

$huespedController = new HuespedController();
$mensaje = "";
$token = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $token = isset($_GET['token']) ? $_GET['token'] : '';
    if (empty($token)) {
        die('Token no proporcionado en la URL');
    }
    if (!$huespedController->verifyResetToken($token)) {
        $mensaje = "El enlace de recuperación es inválido o ha expirado.";
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = isset($_POST['token']) ? $_POST['token'] : '';
    if (empty($token)) {
        die('Token no proporcionado en el formulario');
    }
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    
    if ($password !== $confirmPassword) {
        $mensaje = "Las contraseñas no coinciden.";
    } elseif ($huespedController->updatePassword($token, $password)) {
        $mensaje = "Tu contraseña ha sido restablecida correctamente.";
        header("Refresh:3; url=formulario.php");
    } else {
        $mensaje = "Ha ocurrido un error al restablecer la contraseña.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../public/images/logo1.ico">
    <title>Nueva Contraseña</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'coral': '#ff7f50',
                        'primary': '#33423a'
                    },
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif'],
                        'playfair': ['Playfair Display', 'serif']
                    }
                }
            }
        }
    </script>
</head>
<body class="flex items-center justify-center h-screen bg-primary font-montserrat">
    <div class="bg-white/10 backdrop-blur-lg p-8 rounded-2xl shadow-lg w-96 text-center">
        <h2 class="text-2xl font-playfair font-bold text-white mb-4">Nueva Contraseña</h2>
        <?php if (!empty($mensaje)): ?>
            <p class="text-white mb-4"><?php echo $mensaje; ?></p>
        <?php endif; ?>
        <?php if (empty($mensaje) || $mensaje === "Las contraseñas no coinciden."): ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="space-y-4">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <div class="relative">
                    <input type="password" name="password" placeholder="Nueva contraseña" required
                        class="w-full p-3 pl-10 rounded-lg bg-white/10 text-white placeholder-white/70 focus:ring-2 focus:ring-white/30 outline-none">
                    <svg class="absolute left-3 top-3 w-6 h-6 text-white/70" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <div class="relative">
                    <input type="password" name="confirm_password" placeholder="Confirmar contraseña" required
                        class="w-full p-3 pl-10 rounded-lg bg-white/10 text-white placeholder-white/70 focus:ring-2 focus:ring-white/30 outline-none">
                    <svg class="absolute left-3 top-3 w-6 h-6 text-white/70" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <button type="submit"
                    class="w-full bg-coral/60 text-primary font-bold py-2 px-4 rounded-lg hover:bg-coral transition-colors flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16M4 8h16M4 12h16M4 16h16" />
                    </svg>
                    Cambiar Contraseña
                </button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>