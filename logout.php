<?php
session_start();
session_unset();
session_destroy();
header("Location: ../APP/form/formulario.php");
exit;
?>