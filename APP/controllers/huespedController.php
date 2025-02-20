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
        $apellido = htmlspecialchars($datos['apellido']);
        $documento = intval($datos['documento']);
        $telefono = htmlspecialchars($datos['telefono']); 
        $nacionalidad = htmlspecialchars($datos['nacionalidad']);
        $correo = filter_var($datos['correo'], FILTER_SANITIZE_EMAIL);

        if(strlen($datos['password']) > 10){
            return "La contraseña debe tener menos de 10 caracteres.";
        }
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
                $sql = "INSERT INTO huespedes (nombre, apellido, documento, telefono, nacionalidad, correo, contraseña)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
                    
                // Preparar sentencia
                $stmt = $this->conexion->prepare($sql);
                try{
                    $stmt->bind_param("sssisss", $nombre, $apellido, $documento, $telefono, $nacionalidad, $correo, $contraseña);
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
        $correo = trim(filter_var($datos['email'], FILTER_SANITIZE_EMAIL));
        $password = trim($datos['password']);

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
                header("Location: ../../public/index.php");
                exit();
            } else {
                return"La contraseña no es correcta";
            }
        } else {
            return "No se encontró un usuario con ese correo.";
        }
    }

    public function checkEmailExists($email) {
        $sql = "SELECT id_huesped FROM huespedes WHERE correo = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
    
    public function storeResetToken($email, $token, $expiryTime) {
        $sql = "INSERT INTO reset_tokens (email, token, expiry_time) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE token = ?, expiry_time = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sssss", $email, $token, $expiryTime, $token, $expiryTime);
        return $stmt->execute();
    }
    
    public function verifyResetToken($token) {
        $sql = "SELECT email FROM reset_tokens WHERE token = ? AND expiry_time > NOW()";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            error_log("Error en la preparación de la consulta: " . $this->conexion->error);
            return false;
        }
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        $isValid = $result->num_rows > 0;
        if (!$isValid) {
            error_log("Token no válido o expirado: " . $token);
        }
        return $isValid;
    }
    
    public function updatePassword($token, $password) {
        // Primero, verificamos si el token es válido
        if (!$this->verifyResetToken($token)) {
            error_log("Token inválido o expirado: " . $token);
            return false;
        }
    
        $sql = "SELECT email FROM reset_tokens WHERE token = ? AND expiry_time > NOW()";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            error_log("Error en la preparación de la consulta: " . $this->conexion->error);
            return false;
        }
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            error_log("No se encontró un token válido");
            return false;
        }
        $row = $result->fetch_assoc();
        $email = $row['email'];
    
        $encriptarDesencriptar = new EncriptarDesencriptar();
        $encryptedPassword = $encriptarDesencriptar->encrypt($password, $this->clave);
    
        $updateSql = "UPDATE huespedes SET contraseña = ? WHERE correo = ?";
        $updateStmt = $this->conexion->prepare($updateSql);
        if (!$updateStmt) {
            error_log("Error en la preparación de la consulta de actualización: " . $this->conexion->error);
            return false;
        }
        $updateStmt->bind_param("ss", $encryptedPassword, $email);
        $success = $updateStmt->execute();
    
        if ($success) {
            $deleteSql = "DELETE FROM reset_tokens WHERE email = ?";
            $deleteStmt = $this->conexion->prepare($deleteSql);
            $deleteStmt->bind_param("s", $email);
            $deleteStmt->execute();
        } else {
            error_log("Error al actualizar la contraseña: " . $updateStmt->error);
        }
    
        return $success;
    }
}

$huespedController = new HuespedController();
?>