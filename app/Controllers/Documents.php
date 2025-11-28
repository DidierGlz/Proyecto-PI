<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use TCPDF;

class Documents extends BaseController
{
    public function index()
    {
        return view('layout/header')
             . view('documents/index')
             . view('layout/footer');
    }

    // ========= WORD =========
    public function word()
    {
        $users = model(UserModel::class)->orderBy('id', 'ASC')->findAll();

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Portada sencilla
        $section->addTitle('Reporte de usuarios', 1);
        $section->addText('Materia: Lenguajes de programación Back End');
        $section->addText('Actividad: Modelo Vista Controlador – Documentos');
        $section->addText('Alumno: Néstor Didier Lino González');
        $section->addText('Fecha: ' . date('d/m/Y'));
        $section->addTextBreak(2);

        // Tabla
        $table = $section->addTable([
            'borderSize' => 6,
            'borderColor' => '999999',
            'cellMargin' => 80,
        ]);

        // Encabezados
        $table->addRow();
        $table->addCell(800)->addText('ID');
        $table->addCell(2500)->addText('Nombre');
        $table->addCell(2000)->addText('Login');

        foreach ($users as $u) {
            $table->addRow();
            $table->addCell(800)->addText((string)$u['id']);
            $table->addCell(2500)->addText($u['name']);
            $table->addCell(2000)->addText($u['login']);
        }

        // Salida
        $fileName = 'reporte_usuarios_' . date('Ymd_His') . '.docx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename="'.$fileName.'"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save('php://output');
        exit;
    }

    // ========= EXCEL =========
    public function excel()
    {
        $users = model(UserModel::class)->orderBy('id', 'ASC')->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Usuarios');

        // Encabezados
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nombre');
        $sheet->setCellValue('C1', 'Login');

        $row = 2;
        foreach ($users as $u) {
            $sheet->setCellValue('A'.$row, $u['id']);
            $sheet->setCellValue('B'.$row, $u['name']);
            $sheet->setCellValue('C'.$row, $u['login']);
            $row++;
        }

        // Auto ancho columnas
        foreach (range('A', 'C') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $fileName = 'reporte_usuarios_' . date('Ymd_His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$fileName.'"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    // ========= PDF =========
    public function pdf()
    {
        $users = model(UserModel::class)->orderBy('id', 'ASC')->findAll();

        // Crear PDF
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('CodeIgniter 4');
        $pdf->SetAuthor('Néstor Didier Lino González');
        $pdf->SetTitle('Reporte de usuarios');
        $pdf->SetMargins(15, 20, 15);
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->AddPage();

        $html = '<h1 style="text-align:center;">Reporte de usuarios</h1>';
        $html .= '<p><strong>Materia:</strong> Lenguajes de programación Back End<br>';
        $html .= '<strong>Actividad:</strong> Modelo Vista Controlador – Documentos<br>';
        $html .= '<strong>Alumno:</strong> Néstor Didier Lino González<br>';
        $html .= '<strong>Fecha:</strong> ' . date('d/m/Y') . '</p>';
        $html .= '<br>';

        $html .= '<table border="1" cellpadding="4">
                    <thead>
                      <tr style="background-color:#f0f0f0;">
                        <th width="40">ID</th>
                        <th width="90">Login</th>
                        <th width="120">Nombre</th>
                      </tr>
                    </thead>
                    <tbody>';

        foreach ($users as $u) {
            $html .= '<tr>
                        <td>'.$u['id'].'</td>
                        <td>'.htmlspecialchars($u['login']).'</td>
                        <td>'.htmlspecialchars($u['name']).'</td>
                      </tr>';
        }

        $html .= '</tbody></table>';

        $pdf->writeHTML($html, true, false, true, false, '');

        $fileName = 'reporte_usuarios_' . date('Ymd_His') . '.pdf';
        $pdf->Output($fileName, 'D'); // 'D' = descargar
        exit;
    }
}
