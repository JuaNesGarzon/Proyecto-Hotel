<!-- Createservicio.php -->
<?php
include __DIR__ . '/../config/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Agregar Servicio - Hotel Deja Vu</title>
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
    <div class="w-full max-w-md mx-auto pt-16 pb-8 px-4">
        <a href="javascript:history.back()" class="mb-6 inline-flex items-center text-white hover:text-coral transition-colors">
            <i class='bx bx-left-arrow-alt text-2xl mr-2'></i> Volver
        </a>
        <form method="POST" action="../models/addServicio.php" enctype="multipart/form-data" class="bg-white/10 backdrop-blur-lg rounded-xl shadow-lg p-8">
            <h3 class="text-3xl font-playfair font-bold text-white mb-6 text-center">Agregar Servicio</h3>
            
            <?php if(isset($_GET['success'])): ?>
            <div class="bg-green-500 bg-opacity-80 text-white p-3 rounded-lg mb-4">
                Servicio agregado correctamente.
            </div>
            <?php endif; ?>
            
            <?php if(isset($_GET['error'])): ?>
            <div class="bg-red-500 bg-opacity-80 text-white p-3 rounded-lg mb-4">
                Error: <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
            <?php endif; ?>
            
            <div class="space-y-4">
                <div>
                    <label for="nombreServicio" class="block text-white mb-1 font-medium">Nombre del servicio:</label>
                    <input type="text" name="nombreServicio" id="nombreServicio" class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-coral" required>
                </div>
                <div>
                    <label for="tipoServicio" class="block text-white mb-1 font-medium">Tipo de servicio:</label>
                    <select name="tipoServicio" id="tipoServicio" class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white focus:outline-none focus:ring-2 focus:ring-coral" required>
                        <option class="bg-primary" value="Alimentos">Alimentos</option>
                        <option class="bg-primary" value="Bebidas">Bebidas</option>
                        <option class="bg-primary" value="Spa">Spa</option>
                        <option class="bg-primary" value="Limpieza">Limpieza</option>
                        <option class="bg-primary" value="Transporte">Transporte</option>
                        <option class="bg-primary" value="Entretenimiento">Entretenimiento</option>
                        <option class="bg-primary" value="Otro">Otro</option>
                    </select>
                </div>
                <div>
                    <label for="descripcion" class="block text-white mb-1 font-medium">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" rows="3" class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-coral" required></textarea>
                </div>
                <div>
                    <label for="costo" class="block text-white mb-1 font-medium">Costo:</label>
                    <input type="number" step="0.01" name="costo" id="costo" class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-coral" required>
                </div>
            </div>

            <button type="submit" name="enviar" value="ok" class="w-full bg-coral text-primary font-bold py-3 px-4 rounded-xl hover:bg-coral/80 transition-colors mt-6 flex items-center justify-center">
                <i class='bx bx-plus mr-2'></i> Agregar Servicio
            </button>
        </form>
    </div>
    
    <script>
        function previewImage(input) {
            var preview = document.getElementById('image-preview');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        }
    </script>
</body>
</html>