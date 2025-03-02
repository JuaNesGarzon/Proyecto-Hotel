<?php
include __DIR__ . '/../config/conexion.php';

if (!empty($_POST['enviar'])) {
    if (!empty($_POST['nombreServicio']) && !empty($_POST['tipoServicio']) && !empty($_POST['descripcion']) && !empty($_POST['costo'])) {
        $nombreServicio = $_POST['nombreServicio'];
        $tipoServicio = $_POST['tipoServicio'];
        $descripcion = $_POST['descripcion'];
        $costo = $_POST['costo'];

        // Manejo de la imagen
        $imagen_path = null;
        if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            // Definir la ruta de la carpeta de imágenes
            // IMPORTANTE: Esta carpeta debe existir y tener permisos de escritura
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
                        // Guardar la ruta relativa para acceder desde el navegador
                        $imagen_path = "public/images/servicios/" . $new_filename;
                        
                        // Para depuración
                        error_log("Imagen subida correctamente a: " . $target_file);
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

        // Verificar si la columna imagen_path existe en la tabla servicios
        $check_column = "SHOW COLUMNS FROM servicios LIKE 'imagen_path'";
        $column_result = mysqli_query($conexion, $check_column);
        
        if(mysqli_num_rows($column_result) == 0) {
            // La columna no existe, hay que crearla
            $add_column = "ALTER TABLE servicios ADD COLUMN imagen_path VARCHAR(255) NULL AFTER costo";
            mysqli_query($conexion, $add_column);
        }

        $sql = "INSERT INTO servicios (nombreServicio, tipoServicio, descripcion, costo, imagen_path) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssds", $nombreServicio, $tipoServicio, $descripcion, $costo, $imagen_path);

        if ($stmt->execute()) {
            header("Location: ../views/admin/CRUDservicio.php?success=1");
            exit();
        } else {
            header("Location: ../form/Createservicio.php?error=" . urlencode($stmt->error));
            exit();
        }
        $stmt->close();
    } else {
        header("Location: ../form/Createservicio.php?error=campos_vacios");
        exit();
    }
}
?>