<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PermohonanPDFController extends Controller
{
    public function downloadPDF($id_permohonan)
    {
        $permohonan = Permohonan::with(['ulasans'])->findOrFail($id_permohonan);
        
        $pdf = PDF::loadView('pdf.permohonan_detail', compact('permohonan'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif'
            ]);
        
        $filename = 'Permohonan_' . $permohonan->id_permohonan . '_' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }
}