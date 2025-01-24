<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/encriptar_desencriptar.php';

class HuespedController {
    private $conexion;
    private $clave = "d3j4vu_H0t3l";

    private function inicializarConexion() {
        require __DIR__ . '/../config/conexion.php';
        return $conexion;
    }

    public function __construct() {
        $this->conexion =$this->inicializarConexion();
        if (!$this->conexion) {
            die("Error al conectar con la base de datos.");
        }
    }

    public function registrarHuesped($datos) {
        $encriptarDesencriptar = new EncriptarDesencriptar();
        $nombre = htmlspecialchars($datos['nombre']);
        $documento = intval($datos['documento']);
        $telefono = htmlspecialchars($datos['telefono']);
        $nacionalidad = htmlspecialchars($datos['nacionalidad']);
        $correo = filter_var($datos['correo'], FILTER_SANITIZE_EMAIL);
        $contraseña = $encriptarDesencriptar->encrypt($datos['password'], $this->clave);

        // consulta para insertar el usuario

        $query = "SELECT id_huesped FROM huespedes WHERE documento = ? ";
        $stmt = $this->conexion->prepare($query);
        try {
            $stmt->bind_param("i", $documento);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {                    
                return "Ya existe un usuario con ese documento.";
            } else{
                $sql = "INSERT INTO huespedes (nombre, documento, telefono, nacionalidad, correo, contraseña)
                VALUES (?, ?, ?, ?, ?, ?)";
                    
                // Preparar sentencia
                $stmt = $this->conexion->prepare($sql);
                try{
                    $stmt->bind_param("siisss", $nombre, $documento, $telefono, $nacionalidad, $correo, $contraseña);
                    // Ejecutar la consulta y verificar resultados
                    if ($stmt->execute()) {
                        return "Usuario registrado con éxito.";
                    } else {
                        return "Error al registrar el usuario: " . $stmt->error;
                    }
                } catch (Exception $e) {
                    return "Error en la consulta: " . $e->getMessage();
                }
            }
        } catch (Exception $e) {
            return "Error en la consulta: " . $e->getMessage();
        }
    }

    public function iniciarSesion($datos) {
        $encriptarDesencriptar = new EncriptarDesencriptar();
        $correo = filter_var($datos['email'], FILTER_SANITIZE_EMAIL);
        $password = $datos['password'];

        // consulta para buscar el usuario
        $sql = "SELECT id_huesped, nombre, contraseña FROM huespedes WHERE correo = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            return "Error en la preparación de la consulta: " . $this->conexion->error;
        }
        // Ejecutar la consulta y verificar resultados
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $usuario = $result->fetch_assoc();
            $password_db = $encriptarDesencriptar->decrypt($usuario['contraseña'], $this->clave);

            if($password == $password_db){
                $_SESSION['user_id'] = $usuario['id_huesped'];
                $_SESSION['user_name'] = $usuario['nombre'];
                return "Inicio de sesión exitoso. Bienvenido, " . $usuario['nombre'] . "!";
            } else {
                return"La contraseña no es correcta";
            }
        } else {
            return "No se encontró un usuario con ese correo.";
        }
    }
}

$huespedController = new HuespedController();
?>