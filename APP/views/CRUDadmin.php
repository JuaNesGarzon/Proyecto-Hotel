<?php 
require "../config/conexion.php";

//Logica de busqueda
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : "";
$sql = "SELECT * FROM usuarios WHERE 
nombre LIKE '%$busqueda%' OR 
apellido LIKE '%$busqueda%' OR 
celular LIKE '%$busqueda%' OR 
correo LIKE '%$busqueda%'";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD admin</title>
</head>
<body>
    <h1>hola</h1>

    <div class="container-fluid row">
    <div class="d-flex justify-content-center">
        <table class="table table-bordered border-primary table-striped text-center">
            <thead class="bg-info">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Celular</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Contraseña</th>
                    <th scope="col">Rol</th>
                    <th scope="col">AGREGAR/EDITAR/ELIMINAR</th>
                </tr>
            </thead>
</body>
</html>