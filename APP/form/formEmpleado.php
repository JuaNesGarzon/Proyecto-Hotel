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
    <title>Inicio sesión empleados</title>
</head>
<body>
    <div class="background-slider">
        <div class="slide"></div>
    </div>
    <div class="sign-in" id="sign-in">
    <div class="form-information">
    <form id="sign-up-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="input-group">
            <i class='bx bx-envelope'></i>
            <input type="email" name="email" placeholder="Correo electrónico" required />
        </div>
        <div class="input-group">
            <i class='bx bx-lock'></i>
            <input type="password" id="passwordLogin" name="password" placeholder="Contraseña" required/>
            <i class='bx bx-hide password-toggle' id="togglePasswordLogin"></i>
        </div>
        <button type="submit" name="iniciar_sesion" value="iniciar sesion">Iniciar Sesión</button>
    </form>
</div>
    </div>

    <div class="back">
        <a href="./formulario.php">Volver</a>
    </div>

    <script src="./script.js"></script>
</body>
</html>