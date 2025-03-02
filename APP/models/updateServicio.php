<?php
include __DIR__ . '/../config/conexion.php';

if (!empty($_POST['enviar'])) {
    if (!empty($_POST['id_servicio']) && !empty($_POST['nombreServicio']) && !empty($_POST['tipoServicio']) && !empty($_POST['descripcion']) && !empty($_POST['costo'])) {
        $id_servicio = $_POST['id_servicio'];
        $nombreServicio = $_POST['nombreServicio'];
        $tipoServicio = $_POST['tipoServicio'];
        $descripcion = $_POST['descripcion'];
        $costo = $_POST['costo'];

        // Verificar si la columna imagen_path existe en la tabla servicios
        $check_column = "SHOW COLUMNS FROM servicios LIKE 'imagen_path'";
        $column_result = mysqli_query($conexion, $check_column);
        
        if(mysqli_num_rows($column_result) == 0) {
            // La columna no existe, hay que crearla
            $add_column = "ALTER TABLE servicios ADD COLUMN imagen_path VARCHAR(255) NULL AFTER costo";
            mysqli_query($conexion, $add_column);
        }

        // Obtener la imagen actual
        $sql_imagen = "SELECT imagen_path FROM servicios WHERE id_servicio = ?";
        $stmt_imagen = $conexion->prepare($sql_imagen);
        $stmt_imagen->bind_param("i", $id_servicio);
        $stmt_imagen->execute();
        $resultado_imagen = $stmt_imagen->get_result();
        $row_imagen = $resultado_imagen->fetch_assoc();
        $imagen_path = $row_imagen['imagen_path'];

        // Manejo de la imagen
        if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            // Definir la ruta de la carpeta de imágenes
            $target_dir = __DIR__ . "/../public/images/servicios/";
            
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
                        $imagen_path = "public/images/servicios/" . $new_filename;
                        
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

        $sql = "UPDATE servicios SET nombreServicio = ?, tipoServicio = ?, descripcion = ?, costo = ?, imagen_path = ? WHERE id_servicio = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssdsi", $nombreServicio, $tipoServicio, $descripcion, $costo, $imagen_path, $id_servicio);

        if ($stmt->execute()) {
            header("Location: ../views/admin/CRUDservicio.php?success=1");
            exit();
        } else {
            header("Location: ../form/Editservicio.php?id_servicio=" . $id_servicio . "&error=" . urlencode($stmt->error));
            exit();
        }
        $stmt->close();
    } else {
        header("Location: ../form/Editservicio.php?id_servicio=" . $_POST['id_servicio'] . "&error=campos_vacios");
        exit();
    }
} else {
    header("Location: ../views/admin/CRUDservicio.php");
    exit();
}
?>