<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PdfController extends AbstractController
{
    #[Route('/pdf', name: 'pdf')]
    public function generatePdf(Request $request)
    {
        $html = $request->request->get('html');



        // Instantiate Dompdf with our options
        $dompdf = new Dompdf();

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Stream the generated PDF directly to the browser
        $dompdf->stream("document.pdf", [
            "Attachment" => false
        ]);

        // Ensure that no further script execution can interfere with the PDF
        exit;
    }
}