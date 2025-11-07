<?php
// app/Actions/ExportRecoveryCodes.php

namespace App\Actions;

use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportRecoveryCodes
{
    public function toCsv(array $codes): string
    {
        $csv = "Code de récupération,Date de génération\n";
        $date = now()->format('Y-m-d H:i:s');
        
        foreach ($codes as $code) {
            $csv .= "{$code},{$date}\n";
        }

        return $csv;
    }

    public function toMarkdown(array $codes): string
    {
        $md = "# Codes de Récupération Agrospace\n\n";
        $md .= "**Date de génération :** " . now()->format('d/m/Y H:i:s') . "\n\n";
        $md .= "## 🔑 Vos codes de récupération\n\n";
        $md .= "⚠️ **Important :** Conservez ces codes en lieu sûr. Chaque code ne peut être utilisé qu'une seule fois.\n\n";
        
        foreach ($codes as $index => $code) {
            $md .= ($index + 1) . ". `{$code}`\n";
        }

        $md .= "\n---\n";
        $md .= "*Généré par Agrospace - Plateforme Agropastorale*\n";

        return $md;
    }
    /*
    public function toPdf(array $codes, string $userName): string
    {
        $data = [
            'codes' => $codes,
            'userName' => $userName,
            'date' => now()->format('d/m/Y H:i:s'),
        ];

        $pdf = Pdf::loadView('pdf.recovery-codes', $data);
        
        return $pdf->download('agrospace-recovery-codes.pdf');
    }

    public function toXlsx(array $codes): string
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // En-têtes
        $sheet->setCellValue('A1', 'Code de Récupération');
        $sheet->setCellValue('B1', 'Date de Génération');
        $sheet->setCellValue('C1', 'Statut');

        // Style des en-têtes
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);
        $sheet->getStyle('A1:C1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF22c55e');

        // Données
        $row = 2;
        foreach ($codes as $code) {
            $sheet->setCellValue("A{$row}", $code);
            $sheet->setCellValue("B{$row}", now()->format('Y-m-d H:i:s'));
            $sheet->setCellValue("C{$row}", 'Non utilisé');
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'C') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = storage_path('app/public/recovery-codes-' . time() . '.xlsx');
        $writer->save($filename);

        return $filename;
    }*/
}