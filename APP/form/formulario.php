<?php
session_start();
include __DIR__ . '/../../APP/controllers/huespedController.php';

$mensaje = ""; // inicializamos la variable
$tipoMensaje = ""; // para determinar el color del mensaje (success, error, warning)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['registrarse'])) {
        $resultado = $huespedController->registrarHuesped($_POST);
        // Determinar el tipo de mensaje
        if (strpos($resultado, "éxito") !== false) {
            $tipoMensaje = "success";
        } else if (strpos($resultado, "Error") !== false) {
            $tipoMensaje = "error";
        } else {
            $tipoMensaje = "warning";
        }
        $mensaje = $resultado;
    } else if (isset($_POST['iniciar_sesion'])) {
        $resultado = $huespedController->iniciarSesion($_POST);
        // Determinar el tipo de mensaje
        if (strpos($resultado, "éxito") !== false) {
            $tipoMensaje = "success";
        } else if (strpos($resultado, "Error") !== false) {
            $tipoMensaje = "error";
        } else {
            $tipoMensaje = "warning";
        }
        $mensaje = $resultado;
    }
}
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
    <link rel="stylesheet" type="text/css" href="style_registro.css">
    <link rel="shortcout icon" href="../../public/images/logo1.ico">
    <title>login_register</title>
</head>
<body>
    <?php if (!empty($mensaje)): ?>
        <div id="notification" style="
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
            padding: 15px 20px;
            border-radius: 20px;
            box-shadow: 0 5px 7px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            max-width: 350px;
            font-family: 'Montserrat', sans-serif;
            animation: fadeIn 0.5s ease-out;
            <?php if ($tipoMensaje === "success"): ?>
                background-color: #33423a;
                color: white;
                border: 2px solid #1a231e;
            <?php elseif ($tipoMensaje === "error"): ?>
                background-color: #e74c3c;
                color: white;
                border: 2px solid #c0392b;
            <?php else: ?>
                background-color: coral;
                color: black;
                border: 2px solid #e67e22;
            <?php endif; ?>
        ">
            <i class='bx 
                <?php 
                if ($tipoMensaje === "success") echo "bx-check-circle";
                else if ($tipoMensaje === "error") echo "bx-x-circle";
                else echo "bx-error";
                ?>' style="margin-right: 12px; font-size: 24px;"></i>
            <span style="font-size: 14px;"><?php echo $mensaje; ?></span>
            <i class='bx bx-x' style="margin-left: 12px; cursor: pointer; font-size: 20px;" onclick="closeNotification()"></i>
        </div>
    <?php endif; ?>

    <div class="admin-button">
        <a href="./formEmpleado.php">Ingreso administrativo</a>
    </div>

    <div class="background-slider">
        <div class="slide"></div>
    </div>

    <!-- formulario registro  -->
    <div class="container register">
        <div class="overlay" id="overlay">
            <div class="sign-in" id="sign-in">
                <h2>Bienvenido</h2>
                <p>inicia sesion aqui</p>
                <button type="submit" value="iniciar sesion" id="sign-in"> iniciar sesion</button>
            </div>
        </div>    
        <div class="form-information">
            <div class="form-information-child">
                <h2>crear una cuenta</h2>
                <form id="sign-up-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <label>
                    <i class='bx bxs-user' ></i>
                        <input type="text" name="nombre" placeholder="nombre" required/>
                    </label>
                    <label>
                    <i class='bx bxs-user' ></i>
                        <input type="text" name="apellido" placeholder="apellido" required/>
                    </label>
                    <label>
                    <i class='bx bxs-id-card' ></i>
                        <input type="number" name="documento" placeholder="documento" required/>
                    </label>
                    <label>
                    <i class='bx bxs-phone' ></i>
                        <input type="tel" name="telefono" placeholder="telefono" required/>
                    </label>
                    <label>
                    <i class='bx bxs-user' ></i>
                        <input type="text" name="nacionalidad" placeholder="Nacionalidad" required/>
                    </label>
                    <label>
                    <i class='bx bxs-envelope' ></i>
                        <input type="email" name="correo" placeholder="correo electronico" required/>
                    </label>
                    <label>
                    <i class='bx bxs-lock' ></i>
                        <span>crea una contraseña</span>
                        <input type="password" id="passwordRegister" name="password" placeholder="contraseña" maxlength="10" required/>
                        <i class='bx bx-hide password-toggle' id="togglePasswordRegister"></i>
                    </label>
                    <button type="submit" name="registrarse" value="registrarse">registrarse</button>
                </form>
            </div>
        </div>
    </div>

    <!-- formulario inicio sesion  -->
    <div class="container login hide">
        <div class="overlay" id="overlay">
            <div class="sign-in" id="sign-in">
                <h2>¡Hola de nuevo!</h2>
                <p>Registrate aqui para hacer parte de nosotros</p>
                <button type="submit" value="iniciar sesion" id="sign-up"> registrarse</button>
            </div>
        </div>    
        <div class="form-information">
            <div class="form-information-child">
                <h2>ingresa tu cuenta</h2>
                <div class="icon">
                <i class='bx bxl-gmail' ></i>
                <i class='bx bxl-facebook' ></i>
                <i class='bx bxl-instagram' ></i>
                </div>
                <form id="sign-up-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <label>
                    <i class='bx bxs-envelope' ></i>
                        <input type="email" name="email" placeholder="correo electronico" required/>
                    </label>
                    <label>
                    <i class='bx bxs-lock' ></i>
                        <input type="password" id="passwordLogin" name="password" placeholder="contraseña" maxlength="10" required/>
                        <i class='bx bx-hide password-toggle' id="togglePasswordLogin"></i>
                    </label>
                    <a href="restablecer.php">Olvide mi contraseña</a>
                    <button type="submit" name="iniciar_sesion" value="iniciar sesion">iniciar sesion</button>
                </form>
            </div>
        </div> 
    </div>

    <script src="script.js"></script>
    <script>
        // Función para cerrar la notificación
        function closeNotification() {
            const notification = document.getElementById('notification');
            if (notification) {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    notification.style.display = 'none';
                }, 500);
            }
        }

        // Cerrar automáticamente después de 5 segundos
        if (document.getElementById('notification')) {
            setTimeout(closeNotification, 5000);
        }

        // Añadir animación de entrada
        document.head.insertAdjacentHTML('beforeend', `
            <style>
                @keyframes fadeIn {
                    from {
                        opacity: 0;
                        transform: translateX(100%);
                    }
                    to {
                        opacity: 1;
                        transform: translateX(0);
                    }
                }
            </style>
        `);
    </script>
</body>
</html>