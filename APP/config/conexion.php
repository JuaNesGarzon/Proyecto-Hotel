<?php 
$conexion;

$host = "localhost";
$db = "hotel_dejavu";
$name = "root";
$pass = "";

echo 'conexion exitosa';

try {
    $conexion = new mysqli($db, $name, $pass, $host);
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }
} catch (Throwable $th) {
    echo $th->getMessage();
    exit();
}
?>