<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require "../../config/conexion.php";
include("../../models/deleteServicio.php");

$loggedIn = !empty($_SESSION['user_id']) && !empty($_SESSION['user_name']);

// Lógica de búsqueda
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : "";
$sql = "SELECT * FROM servicios WHERE 
        nombreServicio LIKE '%$busqueda%' OR 
        tipoServicio LIKE '%$busqueda%' OR 
        descripcion LIKE '%$busqueda%' OR
        costo LIKE '%$busqueda%'";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../public/images/logo1.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Administración de Servicios - Hotel Deja Vu</title>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'coral': '#ff7f50',
                        'primary': '#33423a'
                    },
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif'],
                        'playfair': ['Playfair Display', 'serif']
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-primary font-montserrat text-white">
    <!-- Navbar -->
    <nav class="bg-primary/90 backdrop-blur-lg fixed top-0 left-0 right-0 z-50">
        <div class="container mx-auto px-4 py-6 flex justify-between items-center">
            <h1 class="text-3xl font-playfair font-bold">Hotel Deja Vu</h1>
            <div class="flex space-x-6">
                <a href="../indexAdmin.php" class="text-white hover:text-coral transition-colors duration-300">Inicio</a>
                <a href="./CRUDempleado.php" class="text-white hover:text-coral transition-colors duration-300">Empleados</a>
                <a href="./CRUDadmin.php" class="text-white hover:text-coral transition-colors duration-300">Huéspedes</a>
                <a href="./CRUDhabitacion.php" class="text-white hover:text-coral transition-colors duration-300">Habitaciones</a>
            </div>
        </div>
    </nav>
 
    <script>
    function eliminar() {
      let respuesta = confirm("¿Estás seguro de eliminar este servicio?");
      return respuesta;
    }
    </script>
    
    <main class="pt-28 pb-10 container mx-auto px-4">
        <h1 class="text-5xl font-playfair font-bold text-center mb-6">Administración de Servicios</h1>
        <p class="text-center text-white/70 mb-12 max-w-2xl mx-auto">Gestiona los servicios ofrecidos por el Hotel Deja Vu.</p>
        
        <div class="mb-10 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="w-full md:w-2/3 flex bg-white/10 backdrop-blur-lg rounded-xl overflow-hidden shadow-lg">
                <span class="bg-coral text-primary py-3 px-6 font-semibold">Buscar:</span>
                <input type="text" id="searchInput" class="w-full py-3 px-4 bg-transparent text-white placeholder-white/50 focus:outline-none" placeholder="Buscar servicios..." aria-label="Buscar servicios">
            </div>
            <a href="../../form/Createservicio.php" class="w-full md:w-auto bg-coral text-primary font-bold py-3 px-6 rounded-xl hover:bg-coral/70 transition duration-300 text-center">
                <i class='bx bx-plus-circle mr-2'></i>Agregar Servicio
            </a>
        </div>

        <div class="overflow-x-auto bg-white/10 backdrop-blur-lg rounded-xl shadow-xl">
            <table class="w-full">
                <thead class="bg-coral/20 border-b border-white/10">
                    <tr>
                        <th class="py-4 px-6 text-left font-semibold">ID</th>
                        <th class="py-4 px-6 text-left font-semibold">Nombre</th>
                        <th class="py-4 px-6 text-left font-semibold">Tipo</th>
                        <th class="py-4 px-6 text-left font-semibold">Descripción</th>
                        <th class="py-4 px-6 text-left font-semibold">Costo</th>
                        <th class="py-4 px-6 text-left font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody id="servicioTableBody">
                    <?php while($row = mysqli_fetch_assoc($resultado)): ?>
                        <tr class="border-b border-white/10 hover:bg-white/5 transition duration-150">
                            <td class="py-4 px-6"><?php echo htmlspecialchars($row['id_servicio']); ?></td>
                            <td class="py-4 px-6"><?php echo htmlspecialchars($row['nombreServicio']); ?></td>
                            <td class="py-4 px-6"><?php echo htmlspecialchars($row['tipoServicio']); ?></td>
                            <td class="py-4 px-6"><?php echo htmlspecialchars(substr($row['descripcion'], 0, 50)) . '...'; ?></td>
                            <td class="py-4 px-6">$<?php echo htmlspecialchars($row['costo']); ?></td>
                            <td class="py-4 px-6 flex gap-2">
                                <a href="../../form/Editservicio.php?id_servicio=<?= $row['id_servicio'] ?>" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300 inline-flex items-center">
                                    <i class='bx bx-edit-alt mr-1'></i> Editar
                                </a>
                                <a onclick="return eliminar()" href="CRUDservicio.php?id_servicio=<?= $row['id_servicio'] ?>" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300 inline-flex items-center">
                                    <i class='bx bx-trash mr-1'></i> Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white/10 backdrop-blur-lg text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 Hotel Deja Vu. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const servicioTableBody = document.getElementById('servicioTableBody');
            const rows = servicioTableBody.getElementsByTagName('tr');

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