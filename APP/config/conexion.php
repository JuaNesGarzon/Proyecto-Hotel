<?php 
$conexion;

$db_host = "localhost";
$db_name = "hotel_dejavu";
$db_user = "root";
$db_pass = "";

try {
    $conexion = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }
} catch (Throwable $th) {
    echo $th->getMessage();
    exit();
}
?>