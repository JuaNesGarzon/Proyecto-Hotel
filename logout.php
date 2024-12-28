<?php
session_start();
session_destroy();
header("Location: form/formulario.php");
exit();
?>