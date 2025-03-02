<?php
include __DIR__ . '/../config/conexion.php';

if (isset($_GET['id_servicio'])) {
    $id_servicio = $_GET['id_servicio'];
    
    // Obtener la ruta de la imagen antes de eliminar el servicio
    $sql_imagen = "SELECT imagen_path FROM servicios WHERE id_servicio = ?";
    $stmt_imagen = $conexion->prepare($sql_imagen);
    $stmt_imagen->bind_param("i", $id_servicio);
    $stmt_imagen->execute();
    $resultado_imagen = $stmt_imagen->get_result();
    
    if ($resultado_imagen->num_rows > 0) {
        $row_imagen = $resultado_imagen->fetch_assoc();
        $imagen_path = $row_imagen['imagen_path'];
        
        // Eliminar la imagen si existe
        if (!empty($imagen_path) && file_exists(__DIR__ . "/../" . $imagen_path)) {
            unlink(__DIR__ . "/../" . $imagen_path);
        }
    }
    
    // Eliminar el servicio de la base de datos
    $sql = "DELETE FROM servicios WHERE id_servicio = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_servicio);
    
    if ($stmt->execute()) {
        header("Location: ../views/admin/CRUDservicio.php?delete_success=1");
        exit();
    } else {
        header("Location: ../views/admin/CRUDservicio.php?delete_error=" . urlencode($stmt->error));
        exit();
    }
    $stmt->close();
}
?>