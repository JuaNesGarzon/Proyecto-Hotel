<?php
session_start();
include __DIR__ . '/../../APP/controllers/huespedController.php';

$mensaje = ""; // inicializamos la variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['registrarse'])) {
        $mensaje = $huespedController->registrarHuesped($_POST);
    } else if (isset($_POST['iniciar_sesion'])) {
        $mensaje = $huespedController->iniciarSesion($_POST);
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
        <script>
            alert("<?php echo addslashes($mensaje); ?>");
        </script>
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
                        <i class='bx bxs-user bx-tada bx-flip-vertical'></i>
                        <input type="text" name="nombre" placeholder="nombre" required/>
                    </label>
                    <label>
                        <i class='bx bxs-user bx-tada bx-flip-vertical'></i>
                        <input type="text" name="apellido" placeholder="apellido" required/>
                    </label>
                    <label>
                        <i class='bx bx-id-card bx-tada bx-rotate-90'></i>
                        <input type="number" name="documento" placeholder="documento" required/>
                    </label>
                    <label>
                        <i class='bx bx-phone bx-tada bx-rotate-90'></i>
                        <input type="tel" name="telefono" placeholder="telefono" required/>
                    </label>
                    <label>
                        <i class='bx bxs-user bx-tada bx-flip-vertical'></i>
                        <input type="text" name="nacionalidad" placeholder="Nacionalidad" required/>
                    </label>
                    <label>
                        <i class='bx bx-envelope bx-tada bx-rotate-90'></i>
                        <input type="email" name="correo" placeholder="correo electronico" required/>
                    </label>
                    <label>
                        <i class='bx bx-lock bx-tada bx-rotate-90'></i>
                        <span>crea una contraseña</span>
                        <input type="password" id="passwordRegister" name="password" placeholder="contraseña" maxlength="10" required/>
                        <i class='bx bx-hide password-toggle bx-tada' id="togglePasswordRegister"></i>
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
                    <i class='bx bxl-gmail bx-tada'></i>
                    <i class='bx bxl-facebook bx-flip-vertical bx-tada'></i>
                    <i class='bx bxl-instagram bx-tada bx-flip-vertical'></i>
                </div>
                <form id="sign-up-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <label>
                        <i class='bx bx-envelope bx-tada bx-rotate-90'></i>
                        <input type="email" name="email" placeholder="correo electronico" required/>
                    </label>
                    <label>
                        <i class='bx bx-lock bx-tada bx-rotate-90'></i>
                        <input type="password" id="passwordLogin" name="password" placeholder="contraseña" required/>
                        <i class='bx bx-hide password-toggle' id="togglePasswordLogin"></i>
                    </label>
                    <a href="restablecer.php">Olvide mi contraseña</a>
                    <button type="submit" name="iniciar_sesion" value="iniciar sesion">iniciar sesion</button>
                </form>
            </div>
        </div> 
    </div>

    <script src="script.js"></script>
</body>
</html>
