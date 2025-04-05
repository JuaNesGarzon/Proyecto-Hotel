<?php 
session_start();
require __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../controllers/encriptar_desencriptar.php';

if (isset($_SESSION['id_empleado'])) {
    if ($_SESSION['cargo'] == 1) {
        header("location:../views/indexAdmin.php");
    }
    else if ($_SESSION['cargo'] == 2) {
        header("location:../views/indexRecepcion.php");
    }
    else if ($_SESSION['cargo'] == 3) {
        header("location:../views/indexManteni.php");
    }
    else if ($_SESSION['cargo'] == 4) {
        header("location:../views/indexAseo.php");
    }
    else {
        header("location: formEmpleado.php");
        return "no se encontro el empleado";
    }
    exit();
}

$error = "";

if (isset($_POST['correo']) && isset($_POST['contraseña'])) {
    $correo = $_POST['correo'];
    $password_ingresado = $_POST['contraseña'];
    
    // Inicializar la clase de encriptación
    $encriptarDesencriptar = new EncriptarDesencriptar();
    $clave = "d3j4vu_H0t3l"; // Misma clave que se usa para huéspedes
    
    // Consulta preparada para evitar inyección SQL
    $sql = "SELECT id_empleado, nombre, apellido, cargo, correo, contraseña FROM empleados WHERE correo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $fila = $result->fetch_assoc();
        
        // Desencriptar la contraseña almacenada
        $password_desencriptado = $encriptarDesencriptar->decrypt($fila['contraseña'], $clave);
        
        // Comparar con la contraseña ingresada
        if ($password_ingresado == $password_desencriptado) {
            $_SESSION['id_empleado'] = $fila['id_empleado'];
            $_SESSION['nombre'] = $fila['nombre'];
            $_SESSION['cargo'] = $fila['cargo'];

            if ($fila['cargo'] == 1) {
                header("location:../views/indexAdmin.php");
            } else if ($fila['cargo'] == 2) {
                header("location:../views/indexRecepcion.php");
            } else if ($fila['cargo'] == 3) {
                header("location:../views/indexManteni.php");
            } else if ($fila['cargo'] == 4) {
                header("location:../views/indexAseo.php");
            } else {
                header("location: formEmpleado.php");
                $error = "No se encontró el empleado";
            }
            exit();
        } else { 
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "No se encontró el empleado";
    }
    $stmt->close();
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../public/css/empleados.css">
    <link rel="shortcout icon" href="../../public/images/logo1.ico">
    <title>Inicio sesión empleados</title>
    <style>
        .error-message {
            background-color: rgba(255, 0, 0, 0.7);
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="background-slider">
        <div class="slide"></div>
    </div>
    <div class="sign-in" id="sign-in">
    <div class="form-information">
        <h1><strong>Ingreso de Empleados</strong></h1>
        
        <?php if (!empty($error)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form id="sign-up-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="input-group">
                <i class='bx bx-envelope'></i>
                <input type="email" name="correo" placeholder="Correo electrónico" required />
            </div>
            <div class="input-group">
                <i class='bx bx-lock'></i>
                <input type="password" id="passwordInput" name="contraseña" placeholder="Contraseña" required />
                <i class='bx bx-hide password-toggle' id="togglePassword" style="cursor: pointer;"></i>
            </div>
            <button type="submit" name="iniciar_sesion" value="iniciar sesion">Iniciar Sesión</button>
        </form>
    </div>
    </div>

    <div class="back">
        <a href="./formulario.php">Volver</a>
    </div>

    <script src="../../public/js/script1.js"></script>
</body>
</html>