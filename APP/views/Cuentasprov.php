<?php
include __DIR__ . '/../config/conexion.php';
session_start();

// Verificar si el usuario ha iniciado sesión y tiene permisos de administrador
if (!isset($_SESSION['id_empleado']) || $_SESSION['cargo'] != 1) {
    header("Location: ../form/formEmpleado.php");
    exit();
}

// Obtener facturas de proveedores
$sql = "SELECT fp.*, p.nombre as nombre_proveedor 
        FROM facturas_proveedores fp 
        JOIN proveedores p ON fp.id_proveedor = p.id_proveedor 
        ORDER BY fp.fecha_vencimiento ASC";
$result = $conexion->query($sql);

// Procesar el pago de una factura
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pagar_factura'])) {
    $id_factura = $_POST['id_factura'];
    $monto_pagado = $_POST['monto_pagado'];
    $fecha_pago = date('Y-m-d');
    
    // Insertar el pago
    $sql_pago = "INSERT INTO pagos_proveedores (id_factura, fecha_pago, monto_pagado, metodo_pago) 
                 VALUES (?, ?, ?, 'Transferencia')";
    $stmt = $conexion->prepare($sql_pago);
    $stmt->bind_param("isd", $id_factura, $fecha_pago, $monto_pagado);
    $stmt->execute();
    
    // Actualizar el estado de la factura
    $sql_update = "UPDATE facturas_proveedores SET estado = 'pagada' WHERE id_factura = ?";
    $stmt = $conexion->prepare($sql_update);
    $stmt->bind_param("i", $id_factura);
    $stmt->execute();
    
    // Recargar la página para mostrar los cambios
    header("Location: CuentasProv.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuentas de Proveedores - Hotel Deja Vu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../../public/images/logo1.ico">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
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
<body class="bg-primary font-montserrat text-white">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-playfair font-bold mb-6 text-center">Cuentas de Proveedores</h1>
        
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl overflow-hidden shadow-lg">
            <table class="min-w-full">
                <thead class="bg-white/5 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left">Proveedor</th>
                        <th class="py-3 px-4 text-left">Número de Factura</th>
                        <th class="py-3 px-4 text-left">Fecha de Emisión</th>
                        <th class="py-3 px-4 text-left">Fecha de Vencimiento</th>
                        <th class="py-3 px-4 text-left">Monto</th>
                        <th class="py-3 px-4 text-left">Estado</th>
                        <th class="py-3 px-4 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-white/90">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="border-b border-white/10 hover:bg-white/5">
                            <td class="py-3 px-4"><?php echo htmlspecialchars($row['nombre_proveedor']); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($row['numero_factura']); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($row['fecha_emision']); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($row['fecha_vencimiento']); ?></td>
                            <td class="py-3 px-4">$<?php echo number_format($row['monto'], 2); ?></td>
                            <td class="py-3 px-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?php echo $row['estado'] == 'pagada' ? 'bg-green-500/20 text-green-200' : 
                                        ($row['estado'] == 'vencida' ? 'bg-red-500/20 text-red-200' : 'bg-yellow-500/20 text-yellow-200'); ?>">
                                    <?php echo ucfirst($row['estado']); ?>
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <?php if ($row['estado'] == 'pendiente'): ?>
                                    <form method="POST" class="inline">
                                        <input type="hidden" name="id_factura" value="<?php echo $row['id_factura']; ?>">
                                        <input type="hidden" name="monto_pagado" value="<?php echo $row['monto']; ?>">
                                        <button type="submit" name="pagar_factura" class="bg-white text-primary font-bold py-1 px-2 rounded-xl text-xs hover:bg-white/90 transition-colors">
                                            Registrar Pago
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-8">
            <a href="indexAdmin.php" class="bg-white text-primary px-4 py-2 rounded-xl hover:bg-white/90 transition-colors font-semibold inline-block">
                Volver
            </a>
        </div>
    </div>
</body>
</html>

