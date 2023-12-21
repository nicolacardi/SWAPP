<? 
$pdf->SetXY (10, 10);
$pdf->Cell(190,10,utf8_decode("Rilevazione dei progressi nello sviluppo personale e sociale dell'alunno"), 1,0, 'C', 1);
$pdf->SetXY (10,23);
$pdf->Rect(10,23,190,100);
$pdf->SetFont($fontdefault,'',10);
if ($quadrimestre == 1) {$giuquad_cla = $giuquad1_cla;} else {$giuquad_cla = $giuquad2_cla;}
$pdf->MultiCell(190,6,utf8_decode(str_replace("\\n", "\r", $giuquad_cla)), 0, "J");
?>