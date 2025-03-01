<?php
// cambiar_estado.php
session_start();
include '../../APP/config/conexion.php';

if (!isset($_SESSION['id_empleado']) || $_SESSION['cargo'] != 2) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_habitacion'])) {
    $id_habitacion = $_POST['id_habitacion'];
    
    // Obtener estado actual
    $sql = "SELECT estado FROM habitaciones WHERE id_habitacion = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_habitacion);
    $stmt->execute();
    $result = $stmt->get_result();
    $habitacion = $result->fetch_assoc();
    
    // Definir el siguiente estado
    $nuevo_estado = match($habitacion['estado']) {
        'disponible' => 'reservada',
        'reservada' => 'ocupada',
        'ocupada' => 'disponible',
        default => 'disponible'
    };
    
    // Actualizar estado
    $sql = "UPDATE habitaciones SET estado = ? WHERE id_habitacion = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("si", $nuevo_estado, $id_habitacion);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Solicitud inválida']);
}