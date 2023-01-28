<?
//CONTRIBUTI ************************************************************************************************************************************
$pdf->AddPage();
$pdf->SetLink($link5);
$pdf->SetFont('TitilliumWeb-SemiBold','',16);
$pdf->Cell(0,10,"ALLEGATO D", 0,1, 'C');
$pdf->SetFont('TitilliumWeb-SemiBold','',14);
$pdf->Cell(0,10,"RIPARTIZIONE MENSILE CONTRIBUTO MINIMO", 0,1, 'C');
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(0,5,"SOCI FRUITORI*", 0,1, 'C');
$pdf->Cell(0,5,"ANNO SCOLASTICO ".$_SESSION['annopreiscrizione_fam'], 0,1, 'C');

$pdf->Ln(5);
$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$testo= utf8_decode("Il contributo scolastico è ANNUALE.");
$pdf->Cell(0,5,$testo,0,1, "C");

$testo= utf8_decode("Per agevolare le famiglie può essere ripartito in quote mensili.");
$pdf->Cell(0,5,$testo,0,1, "C");

$pdf->Ln(5);
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(48,7,"", 0,0, 'C');
$pdf->Cell(48,7,"", 'LTR',0, 'C');
$pdf->Cell(23,7,"", 'LTR',0, 'C');
$pdf->Cell(23,7,"Dal", 'LTR',0, 'C');
$pdf->Cell(2,7,"", 0,1, 'C');

$pdf->Cell(48,7,"", 0,0, 'C');
$pdf->Cell(48,7,"", 'LR',0, 'C');
$pdf->Cell(23,7,"Primo Figlio", 'LR',0, 'C');
$pdf->Cell(23,7,"Secondo", 'LR',0, 'C');
$pdf->Cell(2,7,"", 0,1, 'C');

$pdf->Cell(48,7,"", 0,0, 'C');
$pdf->Cell(48,7,"", 'LBR',0, 'C');
$pdf->Cell(23,7,"", 'LBR',0, 'C');
$pdf->Cell(23,7,"Figlio", 'LBR',0, 'C');
$pdf->Cell(2,7,"", 0,1, 'C');

$pdf->Cell(48,7,"", 0,0, 'C');
$pdf->Cell(48,8,"", 1,0, 'C');
$pdf->Cell(46,8,"SUPERIORI", 1,0, 'C', true);
$pdf->Cell(2,8,"", 0,1, 'C');

$pdf->Cell(48,7,"", 0,0, 'C');
$pdf->Cell(48,8,"Settembre", 1,0, 'C');
$pdf->Cell(23,8,"425", 1,0, 'C');
$pdf->Cell(23,8,"350", 1,0, 'C');
$pdf->Cell(2,8,"", 0,1, 'C');

$pdf->Cell(48,7,"", 0,0, 'C');
$pdf->Cell(48,8,"Ottobre", 1,0, 'C');
$pdf->Cell(23,8,"425", 1,0, 'C');
$pdf->Cell(23,8,"350", 1,0, 'C');
$pdf->Cell(2,8,"", 0,1, 'C');

$pdf->Cell(48,7,"", 0,0, 'C');
$pdf->Cell(48,8,"Novembre", 1,0, 'C');
$pdf->Cell(23,8,"425", 1,0, 'C');
$pdf->Cell(23,8,"350", 1,0, 'C');
$pdf->Cell(2,8,"", 0,1, 'C');

$pdf->Cell(48,7,"", 0,0, 'C');
$pdf->Cell(48,8,"Dicembre", 1,0, 'C');
$pdf->Cell(23,8,"425", 1,0, 'C');
$pdf->Cell(23,8,"350", 1,0, 'C');
$pdf->Cell(2,8,"", 0,1, 'C');

$pdf->Cell(48,7,"", 0,0, 'C');
$pdf->Cell(48,8,"Gennaio", 1,0, 'C');
$pdf->Cell(23,8,"425", 1,0, 'C');
$pdf->Cell(23,8,"350", 1,0, 'C');
$pdf->Cell(2,8,"", 0,1, 'C');

$pdf->Cell(48,7,"", 0,0, 'C');
$pdf->Cell(48,8,"Febbraio", 1,0, 'C');
$pdf->Cell(23,8,"425", 1,0, 'C');
$pdf->Cell(23,8,"350", 1,0, 'C');
$pdf->Cell(2,8,"", 0,1, 'C');

$pdf->Cell(48,7,"", 0,0, 'C');
$pdf->Cell(48,8,"Marzo", 1,0, 'C');
$pdf->Cell(23,8,"425", 1,0, 'C');
$pdf->Cell(23,8,"350", 1,0, 'C');
$pdf->Cell(2,8,"", 0,1, 'C');

$pdf->Cell(48,7,"", 0,0, 'C');
$pdf->Cell(48,8,"Aprile", 1,0, 'C');
$pdf->Cell(23,8,"425", 1,0, 'C');
$pdf->Cell(23,8,"350", 1,0, 'C');
$pdf->Cell(2,8,"", 0,1, 'C');

$pdf->Cell(48,7,"", 0,0, 'C');
$pdf->Cell(48,8,"Maggio", 1,0, 'C');
$pdf->Cell(23,8,"425", 1,0, 'C');
$pdf->Cell(23,8,"350", 1,0, 'C');
$pdf->Cell(2,8,"", 0,1, 'C');

$pdf->Cell(48,7,"", 0,0, 'C');
$pdf->Cell(48,8,"Giugno (1)", 1,0, 'C');
$pdf->Cell(23,8,"425", 1,0, 'C');
$pdf->Cell(23,8,"350", 1,0, 'C');
$pdf->Cell(2,8,"", 0,1, 'C');


$pdf->Ln(2);
$pdf->Cell(48,7,"", 0,0, 'C');
$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$pdf->Cell(48,8,"TOTALE ANNUO", 1,0, 'C');
$pdf->Cell(23,8,"4250", 1,0, 'C');
$pdf->Cell(23,8,"3500", 1,0, 'C');
$pdf->Cell(2,8,"", 0,1, 'C');



$pdf->Ln(10);
$pdf->SetFont($fontdefault,'',9);
$testo= utf8_decode("(1) Il saldo spese didattiche va versato entro il 15/06/".$anno2." ed è calcolato sull'effettivo costo che è stato sostenuto dalla classe e per il singolo alunno nel corso dell'anno scolastico");
$pdf->MultiCell(0,5,$testo);

$pdf->Ln(5);
$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$testo= utf8_decode("Le quote vanno versate entro il 5 di ogni mese sul conto BCC Roma");
$pdf->Cell(0,5,$testo,0,1, "C");

$testo= utf8_decode("IBAN: IT76 F083 2712 1000 0000 0800 907");
$pdf->Cell(0,5,$testo,0,1,"C");


$pdf->SetFont($fontdefault,'',12);
$testo= utf8_decode("intestato a ARCA Educazione Cooperativa Sociale");
$pdf->MultiCell(0,5,$testo, 0, "C");

$pdf->Ln(2);
$pdf->SetFont($fontdefault,'',10);
$testo= utf8_decode("Indicare come causale ''Contributo supporto alla didattica per 'Nome e Cognome Alunno' 'mese/periodo di riferimento' ''");
$pdf->MultiCell(0,5,$testo, 0, "C");


?>
