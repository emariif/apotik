<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;

class SatuanController extends Controller
{
    public function generatePdf() {
        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadHTML('<h1>Test</h1>');
        // return $pdf->download();
        $pdf = Pdf::loadView('owner.index');
        return $pdf->download();
    }
}
