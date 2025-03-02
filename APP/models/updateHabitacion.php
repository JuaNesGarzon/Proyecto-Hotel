<?php
include __DIR__ . '/../config/conexion.php';

$mensaje = "";

if (!empty($_POST['enviar'])) {
    if (!empty($_POST['id_habitacion']) && !empty($_POST['numero_habitacion']) && !empty($_POST['tipo']) && !empty($_POST['precio']) && !empty($_POST['estado']) && !empty($_POST['numero_personas']) && !empty($_POST['descripcion'])) {
        $id_habitacion = $_POST['id_habitacion'];
        $numero_habitacion = $_POST['numero_habitacion'];
        $tipo = $_POST['tipo'];
        $precio = $_POST['precio'];
        $estado = $_POST['estado'];
        $numero_personas = $_POST['numero_personas'];
        $descripcion = $_POST['descripcion'];

        // Obtener la imagen actual
        $sql_imagen = "SELECT imagen_path FROM habitaciones WHERE id_habitacion = ?";
        $stmt_imagen = $conexion->prepare($sql_imagen);
        $stmt_imagen->bind_param("i", $id_habitacion);
        $stmt_imagen->execute();
        $resultado_imagen = $stmt_imagen->get_result();
        $row_imagen = $resultado_imagen->fetch_assoc();
        $imagen_path = $row_imagen['imagen_path'];

        // Manejo de la imagen
        if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            // Definir la ruta de la carpeta de imágenes
            $target_dir = __DIR__ . "/../public/images/habitaciones/";
            
            // Crear el directorio si no existe
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            
            $file_extension = pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
            $new_filename = uniqid() . '.' . $file_extension;
            $target_file = $target_dir . $new_filename;
            
            // Verificar si es una imagen real
            $check = getimagesize($_FILES["imagen"]["tmp_name"]);
            if($check !== false) {
                // Permitir ciertos formatos de archivo
                if($file_extension == "jpg" || $file_extension == "png" || $file_extension == "jpeg" || $file_extension == "gif" ) {
                    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
                        // Eliminar la imagen anterior si existe
                        if(!empty($imagen_path) && file_exists(__DIR__ . "/../" . $imagen_path)) {
                            unlink(__DIR__ . "/../" . $imagen_path);
                        }
                        
                        // Guardar la ruta relativa para acceder desde el navegador
                        $imagen_path = "public/images/" . $new_filename;
                        
                        // Para depuración
                        error_log("Imagen actualizada correctamente a: " . $target_file);
                        error_log("Ruta guardada en BD: " . $imagen_path);
                    } else {
                        error_log("Error al mover el archivo subido. Error: " . $_FILES["imagen"]["error"]);
                    }
                } else {
                    error_log("Formato de archivo no permitido. Solo se permiten JPG, JPEG, PNG y GIF.");
                }
            } else {
                error_log("El archivo no es una imagen válida.");
            }
        }

        $sql = "UPDATE habitaciones SET numero_habitacion = ?, tipo = ?, precio = ?, estado = ?, numero_personas = ?, descripcion = ?, imagen_path = ? WHERE id_habitacion = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("isdsissi", $numero_habitacion, $tipo, $precio, $estado, $numero_personas, $descripcion, $imagen_path, $id_habitacion);

        if ($stmt->execute()) {
            header("Location: ../views/CRUD/CRUDhabitacion.php?success=1");
            $mensaje = '<div id="successMessage" class="fixed top-0 left-0 right-0 bg-green-500 text-white p-4 text-center transform -translate-y-full transition-transform duration-500 ease-in-out">modificacion exitosa</div>';
            exit();
        } else {
            header("Location: ../form/Edithabitacion.php?id_habitacion=" . $id_habitacion . "&error=" . urlencode($stmt->error));
            exit();
        }
        $stmt->close();
    } else {
        header("Location: ../form/Edithabitacion.php?id_habitacion=" . $_POST['id_habitacion'] . "&error=campos_vacios");
        exit();
    }
} else {
    header("Location: ../views/admin/CRUDhabitacion.php");
    exit();
}
?>