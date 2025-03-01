<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require "../../config/conexion.php";
include __DIR__ . '../../../controllers/huespedController.php';
include ("../../models/deleteHuesped.php");

$loggedIn = !empty($_SESSION['user_id']) && !empty($_SESSION['user_name']);

//Logica de busqueda
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : "";
$sql = "SELECT * FROM huespedes WHERE 
nombre LIKE '%$busqueda%' OR 
apellido LIKE '%$busqueda%' OR 
documento LIKE '%$busqueda%' OR
telefono LIKE '%$busqueda%' OR 
nacionalidad LIKE '%$busqueda%' OR
correo LIKE '%$busqueda%'";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../public/css/CRUDadmin.css">
    <link rel="shortcout icon" href="../../../public/images/logo1.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>CRUD admin</title>
</head>
<body class="bg-blue-900 text-3xl font-['Roboto',_sans-serif]">
<nav class="nav">
        <div class="container">
            <div class="logo">
                <a href="../indexAdmin.php">inicio</a>
            </div>
            <div id="mainListDiv" class="main_list">
                <ul class="navlinks">
                    <li><a href="./CRUDempleado.php">empleados</a></li>
                    <li><a href="./CRUDreserva.php">reservas</a></li>
                    <li><a href="./CRUDhabitacion.php">habitaciones</a></li>
                    <li><a href="./CRUDservicio.php">servicios</a></li>
                </ul>
            </div>
            <span class="navTrigger">
                <i></i>
                <i></i>
                <i></i>
            </span>
        </div>
    </nav>
 
    <script>
    function eliminar() {
      let respuesta = confirm("¿Estás seguro de eliminar?");
      return respuesta;
    }
  </script>
    
    <section class="home pt-40 pb-10 min-h-screen flex flex-col text-xl">
    <h1 class="text-center p-3 text-white text-6xl font-bold font-['Playfair_Display',_serif] mb-8">Huéspedes</h1>
    <hr class="border-t-4 border-white w-1/3 mx-auto mb-12">
    
    <div class="container mx-auto px-4 flex-grow flex flex-col">
        <div class="mb-10 flex justify-between items-center">
            <div class="flex bg-white rounded-lg overflow-hidden shadow-md w-1/2">
                <span class="bg-blue-600 text-white py-4 px-6 text-3xl font-semibold">Buscar:</span>
                <input type="text" id="searchInput" class="flex-grow py-4 px-4 text-2xl focus:outline-none font-light italic" placeholder="Buscar usuarios... " aria-label="Buscar usuarios" aria-describedby="basic-addon1">
            </div>
            <button class="bg-green-500 text-white px-8 py-4 rounded-lg hover:bg-green-600 transition duration-300 text-2xl font-semibold"><a href="../../form/Createhuesped.php">Agregar Huésped</a></button>
        </div>

        <div class="overflow-x-auto bg-blue-150 rounded-lg shadow-lg flex-grow">
            <table class="w-full text-2xl">
                <thead class="bg-blue-700 text-white">
                    <tr>
                        <th class="py-4 px-6 text-left font-semibold">ID</th>
                        <th class="py-4 px-6 text-left font-semibold">Nombre</th>
                        <th class="py-4 px-6 text-left font-semibold">Apellido</th>
                        <th class="py-4 px-6 text-left font-semibold">Documento</th>
                        <th class="py-4 px-6 text-left font-semibold">Telefono</th>
                        <th class="py-4 px-6 text-left font-semibold">Nacionalidad</th>
                        <th class="py-4 px-6 text-left font-semibold">Correo</th>
                        <th class="py-4 px-6 text-left font-semibold">Contraseña</th>
                        <th class="py-4 px-6 text-left font-semibold">Rol</th>
                        <th class="py-4 px-6 text-left font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    <?php while($row = mysqli_fetch_assoc($resultado)): ?>
                        <tr class="border-b border-gray-50 hover:bg-gray-700 ">
                            <td class="py-4 px-6 text-white"><?php echo htmlspecialchars($row['id_huesped']); ?></td>
                            <td class="py-4 px-6 text-white"><?php echo htmlspecialchars($row['nombre']); ?></td>
                            <td class="py-4 px-6 text-white"><?php echo htmlspecialchars($row['apellido']); ?></td>
                            <td class="py-4 px-6 text-white"><?php echo htmlspecialchars($row['documento']); ?></td>
                            <td class="py-4 px-6 text-white"><?php echo htmlspecialchars($row['telefono']); ?></td>
                            <td class="py-4 px-6 text-white"><?php echo htmlspecialchars($row['nacionalidad']); ?></td>
                            <td class="py-4 px-6 text-white"><?php echo htmlspecialchars($row['correo']); ?></td>
                            <td class="py-4 px-6 text-white"><?php echo htmlspecialchars($row['contraseña']); ?></td>
                            <td class="py-4 px-6 text-white"><?php echo htmlspecialchars($row['tipo_huesped'] ?? '1'); ?></td>
                            <td class="py-4 px-6">
                                <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300 mr-2"><a href="../../form/Edithuesped.php?id_huesped=<?= $row['id_huesped'] ?>">Editar</a></button>
                                <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition duration-300"><a onclick="return eliminar()" href="CRUDadmin.php?id_huesped=<?= $row['id_huesped'] ?>">Eliminar</a></button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

    <!-- Jquery needed -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="js/CRUDadmin.js"></script>

    <!-- Function used to shrink nav bar removing paddings and adding black background -->
    <script>
        $(window).scroll(function() {
            if ($(document).scrollTop() > 50) {
                $('.nav').addClass('affix');
                console.log("OK");
            } else {
                $('.nav').removeClass('affix');
            }
        });

        </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const userTableBody = document.getElementById('userTableBody');
    const rows = userTableBody.getElementsByTagName('tr');

    searchInput.addEventListener('keyup', function() {
        const searchTerm = searchInput.value.toLowerCase();

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.getElementsByTagName('td');
            let found = false;

            for (let j = 0; j < cells.length; j++) {
                const cellText = cells[j].textContent.toLowerCase();
                if (cellText.indexOf(searchTerm) > -1) {
                    found = true;
                    break;
                }
            }

            if (found) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
});
    </script>
</body>
</html>