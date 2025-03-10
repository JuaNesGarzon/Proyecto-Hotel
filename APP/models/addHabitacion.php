<?php
include __DIR__ . '/../config/conexion.php';

$mensaje = "";

if (!empty($_POST['enviar'])) {
    if (!empty($_POST['numero_habitacion']) && !empty($_POST['tipo']) && !empty($_POST['precio']) && !empty($_POST['estado']) && !empty($_POST['numero_personas']) && !empty($_POST['descripcion'])) {
        $numero_habitacion = $_POST['numero_habitacion'];
        $tipo = $_POST['tipo'];
        $precio = $_POST['precio'];
        $estado = $_POST['estado'];
        $numero_personas = $_POST['numero_personas'];
        $descripcion = $_POST['descripcion'];

        // Manejo de la imagen
        $imagen_path = null;
        if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            // Definir la ruta de la carpeta de imágenes
            // IMPORTANTE: Esta carpeta debe existir y tener permisos de escritura
            $target_dir = __DIR__ . "/../public/images/habitaciones/";
            
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
                        $imagen_path = "public/images/habitaciones/" . $new_filename;
                        
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

        $sql = "INSERT INTO habitaciones (numero_habitacion, tipo, precio, estado, numero_personas, descripcion, imagen_path) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("isdsiss", $numero_habitacion, $tipo, $precio, $estado, $numero_personas, $descripcion, $imagen_path);

        if ($stmt->execute()) {
            header("Location: ../views/CRUD/CRUDhabitacion.php?success=1");
            $mensaje = '<div id="successMessage" class="fixed top-0 left-0 right-0 bg-green-500 text-white p-4 text-center transform -translate-y-full transition-transform duration-500 ease-in-out">Registro exitoso</div>';
            exit();
        } else {
            header("Location: ../form/Createhabitacion.php?error=" . urlencode($stmt->error));
            exit();
        }
        $stmt->close();
    } else {
        header("Location: ../form/Createhabitacion.php?error=campos_vacios");
        exit();
    }
}
?>