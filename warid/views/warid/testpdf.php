<?php

// Include the main TCPDF library (search for installation path).
require __DIR__ . '/../../../vendor/reno/tcpdf/tcpdf.php';

ob_end_clean();
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// This method has several options, check the source code documentation for more information.
$pdf->AddPage();


// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+