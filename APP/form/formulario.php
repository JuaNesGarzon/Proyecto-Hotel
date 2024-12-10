<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="style_registro.css">
    <title>login_register</title>
</head>
<body>
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
            <div class="icon">
            <i class='bx bxl-gmail bx-tada' ></i>
            <i class='bx bxl-facebook bx-flip-vertical bx-tada' ></i>
            <i class='bx bxl-instagram bx-tada bx-flip-vertical' ></i>
            </div>
            <form id="sign-up-form" action="index.php" method="post">
        <label>
        <i class='bx bxs-user bx-tada bx-flip-vertical' ></i>
        <input type="text" placeholder="nombre completo"/>
        </label>
        <label>
        <i class='bx bx-id-card bx-tada bx-rotate-90' ></i>
        <input type="number" placeholder="documento"/>
        </label>
        <label>
        <i class='bx bx-phone bx-tada bx-rotate-90' ></i>
        <input type="number" placeholder="telefono"/>
        </label>
        <label>
        <i class='bx bxs-user bx-tada bx-flip-vertical' ></i>
        <input type="text" placeholder="Nacionalidad"/>
        </label>
        <label>
        <i class='bx bx-envelope bx-tada bx-rotate-90' ></i>
        <input type="email" placeholder="correo electronico"/>
        </label>
        <label>
        <i class='bx bx-lock bx-tada bx-rotate-90' ></i>
        <input type="password" placeholder="contraseña"/>
        </label>
        <button type="submit" value="registrarse">registrarse</button>
      </form>
        </div>
    </div>
</div>


<!-- formulario inicio sesion  -->

 <div class="container login hide">
    <div class="overlay" id="overlay">
         <div class="sign-in" id="sign-in">
         <h2>¡Hola de nuevo!</h2>
         <p>Inicia sesion con tus datos</p>
         <button type="submit" value="iniciar sesion" id="sign-up"> registrarse</button>

        </div>
    </div>    
    <div class="form-information">
        <div class="form-information-child">
            <h2>ingresa tu cuenta</h2>
            <div class="icon">
            <i class='bx bxl-gmail bx-tada' ></i>
            <i class='bx bxl-facebook bx-flip-vertical bx-tada' ></i>
            <i class='bx bxl-instagram bx-tada bx-flip-vertical' ></i>
            </div>
            <form id="sign-up-form" action="index.php" method="post">
        <label>
        <i class='bx bx-envelope bx-tada bx-rotate-90' ></i>
        <input type="email" placeholder="correo electronico"/>
        </label>
        <label>
        <i class='bx bx-lock bx-tada bx-rotate-90' ></i>
        <input type="password" placeholder="contraseña"/>
        </label>
        <button type="submit" value="iniciar sesion">iniciar sesion</button>
      </form>
        </div>
    </div> 
</div>
<script src="script.js"></script>
</body>
</html>