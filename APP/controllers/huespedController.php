<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/conexion.php';

class HuespedController {
    private $conexion;

    public function __construct() {
        $this->conexion =$this->inicializarConexion();
        if (!$this->conexion) {
            die("Error al conectar con la base de datos.");
        }
    }

    private function inicializarConexion() {
        require __DIR__ . '/../config/conexion.php';
        return $conexion;
    }

    public function registrarHuesped($datos) {
        $nombre = htmlspecialchars($datos['nombre']);
        $documento = intval($datos['documento']);
        $telefono = intval($datos['telefono']);
        $nacionalidad = htmlspecialchars($datos['nacionalidad']);
        $correo = filter_var($datos['correo'], FILTER_SANITIZE_EMAIL);
        $contraseña = password_hash($datos['contraseña'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO huespedes (nombre, documento, telefono, nacionalidad, correo, contraseña)
                VALUES (?, ?, ?, ?, ?, ?)";
                
        // Preparar sentencia
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            return "Error en la preparación de la consulta: " . $this->conexion->error;
        }

        $stmt->bind_param("siisss", $nombre, $documento, $telefono, $nacionalidad, $correo, $contraseña);
        // Ejecutar la consulta y verificar resultados
        if ($stmt->execute()) {
            return "Usuario registrado con éxito.";
        } else {
            return "Error al registrar el usuario: " . $stmt->error;
        }
    }

    public function iniciarSesion($datos) {
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

            if (password_verify($password, $usuario['contraseña'])) {
                $_SESSION['user_id'] = $usuario['id_huesped'];
                $_SESSION['user_name'] = $usuario['nombre'];
                return "Inicio de sesión exitoso. Bienvenido, " . $usuario['nombre'] . "!";
            } else {
                return "Contraseña incorrecta.";
            }
        } else {
            return "No se encontró un usuario con ese correo.";
        }
    }
}

$huespedController = new HuespedController();
?>