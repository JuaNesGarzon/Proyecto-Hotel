<?php
include __DIR__ . '/../config/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Agregar Habitación</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
        #image-preview {
            max-width: 100%;
            max-height: 200px;
            margin-top: 10px;
            display: none;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-400 via-pink-500 to-red-500 flex items-center justify-center p-5">
    <div class="w-full max-w-md">
        <a href="javascript:history.back()" class="mb-4 inline-flex items-center text-white hover:text-gray-200 transition-colors">
            <i class='bx bx-left-arrow-alt text-2xl mr-2'></i> Volver
        </a>
        <form method="POST" action="../models/addHabitacion.php" enctype="multipart/form-data" class="bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg rounded-xl shadow-lg p-8">
            <h3 class="text-3xl font-bold text-white mb-6 text-center">Agregar habitación</h3>
            
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
                    <label for="numero_habitacion" class="block text-gray-200 mb-1">Número de habitación:</label>
                    <input type="number" name="numero_habitacion" id="numero_habitacion" class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300" required>
                </div>
                <div>
                    <label for="tipo" class="block text-gray-200 mb-1">Tipo:</label>
                    <select name="tipo" id="tipo" class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300" required>
                        <option class ="bg-black" value="individual">Individual</option>
                        <option class ="bg-black" value="doble">Doble</option>
                        <option class ="bg-black" value="suite">Suite</option>
                        <option class ="bg-black"value="familiar">Familiar</option>
                    </select>
                </div>
                <div>
                    <label for="precio" class="block text-gray-200 mb-1">Precio:</label>
                    <input type="number" step="0.01" name="precio" id="precio" class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300" required>
                </div>
                <div>
                    <label for="estado" class="block text-gray-200 mb-1">Estado:</label>
                    <select name="estado" id="estado" class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300" required>
                        <option class ="bg-black" value="disponible">Disponible</option>
                        <option class ="bg-black" value="ocupada">Ocupada</option>
                        <option class ="bg-black" value="mantenimiento">Mantenimiento</option>
                    </select>
                </div>
                <div>
                    <label for="numero_personas" class="block text-gray-200 mb-1">Capacidad:</label>
                    <input type="number" name="numero_personas" id="numero_personas" class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300" required>
                </div>
                <div>
                    <label for="descripcion" class="block text-gray-200 mb-1">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" rows="3" class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300" required></textarea>
                </div>
                <div>
                    <label for="imagen" class="block text-gray-200 mb-1">Imagen:</label>
                    <input type="file" name="imagen" id="imagen" class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300" accept="image/*" onchange="previewImage(this)">
                    <img id="image-preview" src="#" alt="Vista previa de la imagen" />
                </div>
            </div>

            <button type="submit" name="enviar" value="ok" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg mt-6 transition-colors flex items-center justify-center">
                <i class='bx bx-plus mr-2'></i> Agregar Habitación
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