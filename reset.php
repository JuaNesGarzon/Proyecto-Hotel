<?php
$token = isset($_GET['token']) ? $_GET['token'] : '';
if (empty($token)) {
    die('Token no proporcionado');
}
header("Location: APP/form/nueva-contrasena.php?token=" . urlencode($token));
exit();