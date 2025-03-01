<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use FPDF;

// Conexión a la base de datos
$conn = new mysqli("localhost", "usuario", "contraseña", "hotel_dejavu");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

function generateMonthlyReport($month, $year) {
    global $conn;
    
    // Consulta para obtener ingresos
    $incomeQuery = "SELECT SUM(s.costo) as total_income
                    FROM reservas r
                    JOIN reservaservicio rs ON r.id_reserva = rs.id_reserva
                    JOIN servicios s ON rs.id_servicio = s.id_servicio
                    WHERE MONTH(r.fecha_inicio) = ? AND YEAR(r.fecha_inicio) = ?";
    
    $stmt = $conn->prepare($incomeQuery);
    if (!$stmt) {
        die("Error en la preparación de la consulta de ingresos: " . $conn->error);
    }
    $stmt->bind_param("ii", $month, $year);
    $stmt->execute();
    $incomeResult = $stmt->get_result()->fetch_assoc();
    $totalIncome = $incomeResult['total_income'] ?? 0;

    // Consulta para obtener gastos
    $expensesQuery = "SELECT SUM(amount) as total_expenses
                      FROM expenses
                      WHERE MONTH(date) = ? AND YEAR(date) = ?";
    
    $stmt = $conn->prepare($expensesQuery);
    if (!$stmt) {
        die("Error en la preparación de la consulta de gastos: " . $conn->error);
    }
    $stmt->bind_param("ii", $month, $year);
    $stmt->execute();
    $expensesResult = $stmt->get_result()->fetch_assoc();
    $totalExpenses = $expensesResult['total_expenses'] ?? 0;

    $profit = $totalIncome - $totalExpenses;

    return [
        'income' => $totalIncome,
        'expenses' => $totalExpenses,
        'profit' => $profit
    ];
}

function generatePDFReport($data, $month, $year) {
    try {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, "Informe Financiero para $month/$year", 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, "Ingresos Totales: $" . number_format($data['income'], 2), 0, 1);
        $pdf->Cell(0, 10, "Gastos Totales: $" . number_format($data['expenses'], 2), 0, 1);
        $pdf->Cell(0, 10, "Beneficio: $" . number_format($data['profit'], 2), 0, 1);
        $pdf->Output('F', "reports/informe_financiero_{$month}_{$year}.pdf");
    } catch (Exception $e) {
        error_log("Error generando PDF: " . $e->getMessage());
        throw $e;
    }
}

function generateExcelReport($data, $month, $year) {
    try {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', "Informe Financiero para $month/$year");
        $sheet->setCellValue('A2', 'Ingresos Totales');
        $sheet->setCellValue('B2', $data['income']);
        $sheet->setCellValue('A3', 'Gastos Totales');
        $sheet->setCellValue('B3', $data['expenses']);
        $sheet->setCellValue('A4', 'Beneficio');
        $sheet->setCellValue('B4', $data['profit']);

        $writer = new Xlsx($spreadsheet);
        $writer->save("reports/informe_financiero_{$month}_{$year}.xlsx");
    } catch (Exception $e) {
        error_log("Error generando Excel: " . $e->getMessage());
        throw $e;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $month = $_POST['month'];
        $year = $_POST['year'];
        $reportData = generateMonthlyReport($month, $year);
        generatePDFReport($reportData, $month, $year);
        generateExcelReport($reportData, $month, $year);
        echo json_encode(['success' => true, 'data' => $reportData]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método de solicitud inválido']);
}