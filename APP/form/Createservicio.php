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
    <title>Agregar Servicio</title>
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
        <form method="POST" action="../models/addServicio.php" enctype="multipart/form-data" class="bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg rounded-xl shadow-lg p-8">
            <h3 class="text-3xl font-bold text-white mb-6 text-center">Agregar servicio</h3>
            
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
                    <label for="nombreServicio" class="block text-gray-200 mb-1">Nombre del servicio:</label>
                    <input type="text" name="nombreServicio" id="nombreServicio" class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300" required>
                </div>
                <div>
                    <label for="tipoServicio" class="block text-gray-200 mb-1">Tipo de servicio:</label>
                    <select name="tipoServicio" id="tipoServicio" class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300" required>
                        <option class="bg-black" value="Alimentos">Alimentos</option>
                        <option class="bg-black" value="Bebidas">Bebidas</option>
                        <option class="bg-black" value="Spa">Spa</option>
                        <option class="bg-black" value="Limpieza">Limpieza</option>
                        <option class="bg-black" value="Transporte">Transporte</option>
                        <option class="bg-black" value="Entretenimiento">Entretenimiento</option>
                        <option class="bg-black" value="Otro">Otro</option>
                    </select>
                </div>
                <div>
                    <label for="descripcion" class="block text-gray-200 mb-1">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" rows="3" class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300" required></textarea>
                </div>
                <div>
                    <label for="costo" class="block text-gray-200 mb-1">Costo:</label>
                    <input type="number" step="0.01" name="costo" id="costo" class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300" required>
                </div>
            </div>

            <button type="submit" name="enviar" value="ok" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg mt-6 transition-colors flex items-center justify-center">
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