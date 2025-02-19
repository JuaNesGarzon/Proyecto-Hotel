<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcout icon" href="../../public/images/logo1.ico">
    <title>Restablecer Contraseña</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gradient-to-br from-gray-700 to-gray-900">
    <div class="bg-white/20 backdrop-blur-lg p-8 rounded-2xl shadow-lg w-96 text-center">
        <h2 class="text-2xl font-bold text-white mb-4">Restablecer Contraseña</h2>
        <form action="../helpers/recovery.php" method="POST" class="space-y-4">
            <div class="relative">
                <input type="email" name="email" placeholder="Correo electrónico" required
                    class="w-full p-3 pl-10 rounded-lg bg-white/50 text-gray-900 focus:ring-2 focus:ring-coral-500 outline-none">
                <svg class="absolute left-3 top-3 w-6 h-6 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m8 0H8m8 0H8m-4 8h16a2 2 0 002-2V6a2 2 0 00-2-2H4a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16M4 8h16M4 12h16M4 16h16" />
                </svg>
                Restablecer
            </button>
        </form>
        <a href="formulario.php" class="mt-4 inline-block text-400 hover:text-white bg-amber-700 py-2 px-4 rounded-lg">← Volver al registro</a>
    </div>
</body>
</html>
