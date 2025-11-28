<?php

namespace Support\Traits;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
trait GeneratePDF
{
    public function savePDF($path, $data = null)

    /** сохраняем файл PDF */
    {

        $pdf = Pdf::loadView('pdf.invoice', $data);
        $file = $path;
        $tempPath = Storage::disk('public')->path(trim($file));

        $content = $pdf->output();
        return file_put_contents($tempPath, $content);

        //  return $pdf->stream('invoice.pdf');
        // return $pdf->download('invoice.pdf');


    }
}
