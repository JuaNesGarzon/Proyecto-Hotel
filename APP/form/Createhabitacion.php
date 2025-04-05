<!-- Createhabitacion.php -->
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
    <title>Agregar Habitación - Hotel Deja Vu</title>
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
    <style>
        #image-preview {
            max-width: 100%;
            max-height: 200px;
            margin-top: 10px;
            display: none;
        }
    </style>
</head>
<body class="min-h-screen bg-primary font-montserrat text-white">
    <div class="w-full max-w-md mx-auto pt-16 pb-8 px-4">
        <a href="javascript:history.back()" class="mb-6 inline-flex items-center text-white hover:text-coral transition-colors">
            <i class='bx bx-left-arrow-alt text-2xl mr-2'></i> Volver
        </a>
        <form method="POST" action="../models/addHabitacion.php" enctype="multipart/form-data" class="bg-white/10 backdrop-blur-lg rounded-xl shadow-lg p-8">
            <h3 class="text-3xl font-playfair font-bold text-white mb-6 text-center">Agregar Habitación</h3>
            
            <?php if(isset($_GET['success'])): ?>
            <div class="bg-green-500 bg-opacity-80 text-white p-3 rounded-lg mb-4">
                Habitación agregada correctamente.
            </div>
            <?php endif; ?>
            
            <?php if(isset($_GET['error'])): ?>
            <div class="bg-red-500 bg-opacity-80 text-white p-3 rounded-lg mb-4">
                Error: <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
            <?php endif; ?>
            
            <div class="space-y-4">
                <div>
                    <label for="numero_habitacion" class="block text-white mb-1 font-medium">Número de habitación:</label>
                    <input type="number" name="numero_habitacion" id="numero_habitacion" class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-coral" required>
                </div>
                <div>
                    <label for="tipo" class="block text-white mb-1 font-medium">Tipo:</label>
                    <select name="tipo" id="tipo" class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white focus:outline-none focus:ring-2 focus:ring-coral" required>
                        <option class="bg-primary" value="individual">Individual</option>
                        <option class="bg-primary" value="doble">Doble</option>
                        <option class="bg-primary" value="suite">Suite</option>
                        <option class="bg-primary" value="familiar">Familiar</option>
                    </select>
                </div>
                <div>
                    <label for="precio" class="block text-white mb-1 font-medium">Precio:</label>
                    <input type="number" step="0.01" name="precio" id="precio" class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-coral" required>
                </div>
                <div>
                    <label for="estado" class="block text-white mb-1 font-medium">Estado:</label>
                    <select name="estado" id="estado" class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white focus:outline-none focus:ring-2 focus:ring-coral" required>
                        <option class="bg-primary" value="disponible">Disponible</option>
                        <option class="bg-primary" value="ocupada">Ocupada</option>
                        <option class="bg-primary" value="mantenimiento">Mantenimiento</option>
                    </select>
                </div>
                <div>
                    <label for="numero_personas" class="block text-white mb-1 font-medium">Capacidad:</label>
                    <input type="number" name="numero_personas" id="numero_personas" class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-coral" required>
                </div>
                <div>
                    <label for="descripcion" class="block text-white mb-1 font-medium">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" rows="3" class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-coral" required></textarea>
                </div>
                <div>
                    <label for="imagen" class="block text-white mb-1 font-medium">Imagen:</label>
                    <input type="file" name="imagen" id="imagen" class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white focus:outline-none focus:ring-2 focus:ring-coral" accept="image/*" onchange="previewImage(this)">
                    <img id="image-preview" src="#" alt="Vista previa de la imagen" />
                </div>
            </div>

            <button type="submit" name="enviar" value="ok" class="w-full bg-coral text-primary font-bold py-3 px-4 rounded-xl hover:bg-coral/80 transition-colors mt-6 flex items-center justify-center">
                <i class='bx bx-plus-circle mr-2'></i> Agregar Habitación
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