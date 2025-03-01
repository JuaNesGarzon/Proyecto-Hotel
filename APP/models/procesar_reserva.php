<?php
session_start();
include '../../APP/config/conexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_huesped = $_SESSION['user_id'];
    $check_in = $_POST['check-in'];
    $check_out = $_POST['check-out'];
    $guests = $_POST['guests'];
    $room_type = $_POST['room-type'];
    $servicios = isset($_POST['servicios']) ? $_POST['servicios'] : [];

    // Insertar la reserva
    $sql_reserva = "INSERT INTO reservas (fecha_inicio, fecha_salida, estado, numero_huespedes, tipo_habitacion, id_huesped, roles_huespedes_id_rol) 
                    VALUES (?, ?, 'confirmada', ?, ?, ?, 2)";
    
    $stmt = $conexion->prepare($sql_reserva);
    $stmt->bind_param("ssisi", $check_in, $check_out, $guests, $room_type, $id_huesped);
    
    if ($stmt->execute()) {
        $id_reserva = $conexion->insert_id;

        // Actualizar el rol del huésped
        $sql_update_rol = "UPDATE huespedes SET tipo_huesped = 2 WHERE id_huesped = ?";
        $stmt_update = $conexion->prepare($sql_update_rol);
        $stmt_update->bind_param("i", $id_huesped);
        $stmt_update->execute();

        // Insertar servicios adicionales
        $costo_total = 0;
        foreach ($servicios as $id_servicio) {
            $sql_costo = "SELECT costo FROM servicios WHERE id_servicio = ?";
            $stmt_costo = $conexion->prepare($sql_costo);
            $stmt_costo->bind_param("i", $id_servicio);
            $stmt_costo->execute();
            $result_costo = $stmt_costo->get_result();
            $costo = $result_costo->fetch_assoc()['costo'];
            $costo_total += $costo;

            $sql_reserva_servicio = "INSERT INTO reservaservicio (costo_total, id_servicio, id_reserva) VALUES (?, ?, ?)";
            $stmt_servicio = $conexion->prepare($sql_reserva_servicio);
            $stmt_servicio->bind_param("dii", $costo, $id_servicio, $id_reserva);
            $stmt_servicio->execute();
        }

        // Redirigir al recibo
        header("Location: ../views/recibo.php?id_reserva=$id_reserva");
        exit();
    } else {
        echo "Error al procesar la reserva: " . $conexion->error;
    }
}