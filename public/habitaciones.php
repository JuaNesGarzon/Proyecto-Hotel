<?php
// habitaciones.php

// Conexión a la base de datos
include __DIR__ . '../../APP/config/conexion.php';

// Obtener filtros
$precio_min = isset($_GET['precio_min']) ? $_GET['precio_min'] : 0;
$precio_max = isset($_GET['precio_max']) ? $_GET['precio_max'] : 1000000;
$capacidad = isset($_GET['numero_personas']) ? $_GET['numero_personas'] : '';
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';

// Construir la consulta SQL con filtros
$sql = "SELECT * FROM habitaciones WHERE precio >= $precio_min AND precio <= $precio_max";
if ($capacidad) {
    $sql .= " AND numero_personas = $capacidad";
}
if ($tipo) {
    $sql .= " AND tipo = '$tipo'";
}

$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitaciones - Hotel Deja Vu</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Dancing+Script&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Playfair Display', serif;
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
        }
        .dancing-script {
            font-family: 'Dancing Script', cursive;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-yellow-200 to-pink-200">
    <header class="bg-white bg-opacity-80 shadow-md">
        <div class="container mx-auto px-4 py-6 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800">Hotel Deja Vu</h1>
            <a href="index.php" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded transition duration-300">Volver al Inicio</a>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <h2 class="text-4xl font-bold text-center mb-8 dancing-script">Nuestras Habitaciones</h2>

        <form action="" method="GET" class="mb-8 bg-white bg-opacity-80 p-4 rounded-lg shadow-md">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="precio_min" class="block mb-2">Precio mínimo:</label>
                    <input type="number" id="precio_min" name="precio_min" value="<?php echo $precio_min; ?>" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label for="precio_max" class="block mb-2">Precio máximo:</label>
                    <input type="number" id="precio_max" name="precio_max" value="<?php echo $precio_max; ?>" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label for="capacidad" class="block mb-2">Capacidad:</label>
                    <select id="capacidad" name="capacidad" class="w-full p-2 border rounded">
                        <option value="">Todas</option>
                        <option value="2" <?php echo $capacidad == '2' ? 'selected' : ''; ?>>2 personas</option>
                        <option value="4" <?php echo $capacidad == '4' ? 'selected' : ''; ?>>4 personas</option>
                    </select>
                </div>
                <div>
                    <label for="tipo" class="block mb-2">Tipo de habitación:</label>
                    <select id="tipo" name="tipo" class="w-full p-2 border rounded">
                        <option value="">Todas</option>
                        <option value="individual" <?php echo $tipo == 'individual' ? 'selected' : ''; ?>>Individual</option>
                        <option value="doble" <?php echo $tipo == 'doble' ? 'selected' : ''; ?>>Doble</option>
                        <option value="suite" <?php echo $tipo == 'suite' ? 'selected' : ''; ?>>Suite</option>
                        <option value="familiar" <?php echo $tipo == 'familiar' ? 'selected' : ''; ?>>Familiar</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-300">Filtrar</button>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    ?>
                    <div class="bg-white rounded-lg overflow-hidden shadow-lg">
                        <img src="<?php echo $row['imagen']; ?>" alt="<?php echo $row['tipo']; ?>" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2"><?php echo $row['tipo']; ?> <?php echo $row['numero_habitacion']; ?></h3>
                            <p class="text-gray-600 mb-4"><?php echo $row['descripcion']; ?></p>
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-lg font-bold">$<?php echo number_format($row['precio'], 2); ?> / noche</span>
                                <span class="bg-blue-100 text-blue-800 text-sm font-semibold px-2.5 py-0.5 rounded">Capacidad: <?php echo $row['numero_personas']; ?></span>
                            </div>
                            <?php if ($row['estado'] == 'disponible') { ?>
                                <a href="reservar.php?id=<?php echo $row['id_huesped']; ?>" class="block w-full bg-green-500 hover:bg-green-600 text-white text-center font-bold py-2 px-4 rounded transition duration-300">Reservar</a>
                            <?php } else { ?>
                                <button class="w-full bg-gray-300 text-gray-600 font-bold py-2 px-4 rounded cursor-not-allowed" disabled>No disponible</button>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p class='text-center text-xl'>No se encontraron habitaciones que coincidan con los criterios de búsqueda.</p>";
            }
            ?>
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 Hotel Deja Vu. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>

<?php
$conexion->close();
?>