<?php
include __DIR__ . '../../APP/config/conexion.php';

// Obtener filtros
$precio = isset($_GET['precio']) ? intval($_GET['precio']) : 0;
$capacidad = isset($_GET['numero_personas']) ? intval($_GET['numero_personas']) : '';
$tipo = isset($_GET['tipo']) ? $conexion->real_escape_string($_GET['tipo']) : '';

// Construir la consulta SQL con filtros
$sql = "SELECT * FROM habitaciones WHERE estado = 'disponible'";
$params = [];
$types = "";

if ($precio > 0) {
    $sql .= " AND precio <= ?";
    $params[] = $precio;
    $types .= "i";
}
if ($capacidad) {
    $sql .= " AND numero_personas = ?";
    $params[] = $capacidad;
    $types .= "i";
}
if ($tipo) {
    $sql .= " AND tipo = ?";
    $params[] = $tipo;
    $types .= "s";
}

$stmt = $conexion->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$imagenes_dir = "../public/images/habitaciones/";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitaciones - Hotel Deja Vu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../public/images/logo1.ico">
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
    <header class="bg-primary/90 backdrop-blur-lg fixed top-0 left-0 right-0 z-50">
        <div class="container mx-auto px-4 py-6 flex justify-between items-center">
            <h1 class="text-3xl font-playfair font-bold">Hotel Deja Vu</h1>
            <a href="index.php" class="bg-coral text-primary font-bold py-2 px-4 rounded-2xl hover:bg-coral/70 transition duration-300">Volver al Inicio</a>
        </div>
    </header>

    <main class="pt-24">
        <div class="container mx-auto px-4">
            <h2 class="text-5xl font-playfair font-bold text-center mb-12">Nuestras Habitaciones</h2>

            <form action="" method="GET" class="mb-12 bg-white/10 backdrop-blur-lg p-6 rounded-2xl shadow-xl">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="precio" class="block mb-2 font-semibold">Precio máximo:</label>
                        <select id="precio" name="precio" class="w-full p-2 rounded-xl bg-white/10 border border-white/20">
                            <option class="bg-primary/10 text-black" value="">Todos los precios</option>
                            <option class="bg-primary/10 text-black" value="150000" <?php echo $precio == 150000 ? 'selected' : ''; ?>>150.000</option>
                            <option class="bg-primary/10 text-black" value="250000" <?php echo $precio == 250000 ? 'selected' : ''; ?>>250.000</option>
                            <option class="bg-primary/10 text-black" value="350000" <?php echo $precio == 350000 ? 'selected' : ''; ?>>350.000</option>
                        </select>
                    </div>
                    <div>
                        <label for="capacidad" class="block mb-2 font-semibold">Capacidad:</label>
                        <select id="capacidad" name="numero_personas" class="w-full p-2 rounded-xl bg-white/10 border border-white/20">
                            <option class="bg-primary/10 text-black" value="">Todas</option>
                            <option class="bg-primary/10 text-black" value="2" <?php echo $capacidad == 2 ? 'selected' : ''; ?>>2 personas</option>
                            <option class="bg-primary/10 text-black" value="4" <?php echo $capacidad == 4 ? 'selected' : ''; ?>>4 personas</option>
                        </select>
                    </div>
                    <div>
                        <label for="tipo" class="block mb-2 font-semibold">Tipo de habitación:</label>
                        <select id="tipo" name="tipo" class="w-full p-2 rounded-xl bg-white/10 border border-white/20">
                            <option class="bg-primary/10 text-black" value="">Todas</option>
                            <option class="bg-primary/10 text-black" value="individual" <?php echo $tipo == 'individual' ? 'selected' : ''; ?>>Individual</option>
                            <option class="bg-primary/10 text-black" value="doble" <?php echo $tipo == 'doble' ? 'selected' : ''; ?>>Doble</option>
                            <option class="bg-primary/10 text-black" value="suite" <?php echo $tipo == 'suite' ? 'selected' : ''; ?>>Suite</option>
                            <option class="bg-primary/10 text-black" value="familiar" <?php echo $tipo == 'familiar' ? 'selected' : ''; ?>>Familiar</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="mt-6 bg-coral text-primary font-bold py-2 px-4 rounded-xl hover:bg-coral/70 transition duration-300">Filtrar</button>
            </form>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $imagen = $imagenes_dir . $row['numero_habitacion'] . '.jpg';
                        if (!file_exists($imagen)) {
                            $imagen = $imagenes_dir . '../../images/Diapositiva6.jpg';
                        }
                        ?>
                        <div class="bg-white/10 backdrop-blur-lg rounded-2xl overflow-hidden shadow-2xl transform hover:scale-105 transition duration-300">
                            <img src="<?php echo $imagen; ?>" alt="<?php echo htmlspecialchars($row['tipo']); ?>" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($row['tipo']); ?> <?php echo htmlspecialchars($row['numero_habitacion']); ?></h3>
                                <p class="text-white/80 mb-4"><?php echo htmlspecialchars($row['descripcion']); ?></p>
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold">$<?php echo number_format($row['precio'], 0, ',', '.'); ?> / noche</span>
                                    <span class="bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full">Capacidad: <?php echo htmlspecialchars($row['numero_personas']); ?></span>
                                </div>
                                <?php if ($row['estado'] == 'disponible') { ?>
                                    <a href="reservar.php?id=<?php echo $row['id_habitacion']; ?>&numero=<?php echo $row['numero_habitacion']; ?>" class="mt-4 block w-full bg-coral text-primary text-center font-bold py-2 px-4 rounded-xl hover:bg-coral/70 transition duration-300">Reservar</a>
                                <?php } else { ?>
                                    <button class="mt-4 w-full bg-white/20 text-white/50 font-bold py-2 px-4 rounded-xl cursor-not-allowed" disabled>No disponible</button>
                                <?php } ?>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p class='text-center text-xl col-span-3'>No se encontraron habitaciones que coincidan con los criterios de búsqueda.</p>";
                }
                ?>
            </div>
        </div>
    </main>

    <footer class="bg-white/10 backdrop-blur-lg text-white py-8 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 Hotel Deja Vu. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>

<?php
$stmt->close();
$conexion->close();
?>