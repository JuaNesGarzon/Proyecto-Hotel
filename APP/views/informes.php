<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../../public/images/logo1.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <title>Informes Financieros - Hotel Deja Vu</title>
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
    <div class="container mx-auto px-4 py-8 text-white">
        <h1 class="text-3xl font-playfair font-bold mb-8">Informes Financieros</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8 text-white">
            <div class="bg-white/10 backdrop-blur-lg p-6 rounded-2xl shadow-lg text-white">
                <h2 class="text-xl font-semibold mb-4 text-white">Ingresos Mensuales</h2>
                <canvas class="w-full h-96 text-white" id="incomeChart"></canvas>
            </div>
            <div class="bg-white/10 backdrop-blur-lg p-6 rounded-2xl shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Gastos Mensuales</h2>
                <canvas id="expensesChart"></canvas>
            </div>
            <div class="bg-white/10 backdrop-blur-lg p-6 rounded-2xl shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Beneficios Mensuales</h2>
                <canvas id="profitChart"></canvas>
            </div>
        </div>

        <div class="bg-white/10 backdrop-blur-lg p-6 rounded-2xl shadow-lg mb-8">
            <h2 class="text-xl font-semibold mb-4">Generar Informe</h2>
            <form id="reportForm" class="flex items-center space-x-4">
                <select id="month" name="month" class="bg-black/50 border border-white/20 rounded-xl px-3 py-2 text-white">
                    <option class="bg-primary/10 text-black" value="1">Enero</option>
                    <option class="bg-primary/10 text-black" value="2">Febrero</option>
                    <option class="bg-primary/10 text-black" value="3">Marzo</option>
                    <option class="bg-primary/10 text-black" value="4">Abril</option>
                    <option class="bg-primary/10 text-black" value="5">Mayo</option>
                    <option class="bg-primary/10 text-black" value="6">Junio</option>
                    <option class="bg-primary/10 text-black" value="7">Julio</option>
                    <option class="bg-primary/10 text-black" value="8">Agosto</option>
                    <option class="bg-primary/10 text-black" value="9">Septiembre</option>
                    <option class="bg-primary/10 text-black" value="10">Octubre</option>
                    <option class="bg-primary/10 text-black" value="11">Noviembre</option>
                    <option class="bg-primary/10 text-black" value="12">Diciembre</option>
                </select>
                <select id="year" name="year" class="bg-black/50 border border-white/20 rounded-xl px-3 py-2 text-white">
                    <?php
                    $currentYear = date('Y');
                    for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
                        echo "<option value=\"$i\">$i</option>";
                    }
                    ?>
                </select>
                <button type="submit" class="bg-white text-primary px-4 py-2 rounded-xl hover:bg-white/90 transition-colors font-semibold">
                    Generar Informe
                </button>
            </form>
        </div>

        <a href="indexAdmin.php" class="bg-white text-primary px-4 py-2 rounded-xl hover:bg-white/90 transition-colors font-semibold inline-block">
            Volver
        </a>

        <div id="reportResult" class="bg-white/10 backdrop-blur-lg p-6 rounded-2xl shadow-lg hidden mt-8">
            <h2 class="text-xl font-semibold mb-4">Resultado del Informe</h2>
            <div id="reportData"></div>
            <div class="mt-4 flex gap-4">
                <a id="pdfLink" href="#" class="bg-white text-primary px-4 py-2 rounded-xl hover:bg-white/90 transition-colors font-semibold inline-flex items-center">
                    <i class='bx bxs-file-pdf mr-2'></i>
                    Descargar PDF
                </a>
                <a id="excelLink" href="#" class="bg-white text-primary px-4 py-2 rounded-xl hover:bg-white/90 transition-colors font-semibold inline-flex items-center">
                    <i class='bx bxs-file-export mr-2'></i>
                    Descargar Excel
                </a>
            </div>
        </div>
    </div>

    <script>
        // Function to create a chart
        function createChart(ctx, label, data) {
            return new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    datasets: [{
                        label: label,
                        data: data,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                }
            });
        }

        // Create sample charts (replace with real data later)
        createChart(document.getElementById('incomeChart').getContext('2d'), 'Ingresos', [65, 59, 80, 81, 56, 55, 40, 65, 59, 80, 81, 56]);
        createChart(document.getElementById('expensesChart').getContext('2d'), 'Gastos', [28, 48, 40, 19, 86, 27, 90, 28, 48, 40, 19, 86]);
        createChart(document.getElementById('profitChart').getContext('2d'), 'Beneficios', [37, 11, 40, 62, -30, 28, -50, 37, 11, 40, 62, -30]);

        // Handle form submission
        document.getElementById('reportForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const month = document.getElementById('month').value;
            const year = document.getElementById('year').value;

            fetch('generate_report.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `month=${month}&year=${year}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const reportData = document.getElementById('reportData');
                    reportData.innerHTML = `
                        <p class="text-white">Ingresos: $${data.data.income.toFixed(2)}</p>
                        <p>Gastos: $${data.data.expenses.toFixed(2)}</p>
                        <p>Beneficios: $${data.data.profit.toFixed(2)}</p>
                    `;
                    document.getElementById('reportResult').classList.remove('hidden');
                    document.getElementById('pdfLink').href = `reports/informe_financiero_${month}_${year}.pdf`;
                    document.getElementById('excelLink').href = `reports/informe_financiero_${month}_${year}.xlsx`;
                } else {
                    alert('Error al generar el informe: ' + data.message);
                    console.error('Error:', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al generar el informe: ' + error);
            });
        });
    </script>
</body>
</html>