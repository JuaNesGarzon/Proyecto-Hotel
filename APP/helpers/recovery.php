<? 
include "../config/conexion.php";
$email = $_POST['email'];
$token = random_bytes(5);

include "../controllers/mail_reset.php";
if ($enviado) {
$conexion->query("INSERT INTO tokens (email, token, codigo)
    VALUES ('$email','$token','$codigo')") or die($conexion->error);
    echo  '<p>Verifica tu correo electrónico</p>';
}


?>