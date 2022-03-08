<?
//CONTRIBUTI ************************************************************************************************************************************
$pdf->AddPage();
$pdf->SetLink($link5);
$pdf->SetFont('TitilliumWeb-SemiBold','',16);
$pdf->Cell(0,10,"ALLEGATO D", 0,1, 'C');
$pdf->SetFont('TitilliumWeb-SemiBold','',14);
$pdf->Cell(0,10,"RIPARTIZIONE MENSILE CONTRIBUTO SCOLASTICO MINIMO", 0,1, 'C');
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(0,5,"SOCI FRUITORI*", 0,1, 'C');
$pdf->Cell(0,5,"ANNO SCOLASTICO ".$_SESSION['annopreiscrizione_fam'], 0,1, 'C');

$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(48,7,"", 'LTR',0, 'C');
$pdf->Cell(23,7,"", 'LTR',0, 'C');
$pdf->Cell(23,7,"Dal", 'LTR',0, 'C');
$pdf->Cell(2,7,"", 0,0, 'C');
$pdf->Cell(23,7,"", 'LTR',0, 'C');
$pdf->Cell(23,7,"Dal", 'LTR',0, 'C');
$pdf->Cell(2,7,"", 0,0, 'C');
$pdf->Cell(23,7,"", 'LTR',0, 'C');
$pdf->Cell(23,7,"Dal", 'LTR',1, 'C');

$pdf->Cell(48,7,"", 'LR',0, 'C');
$pdf->Cell(23,7,"Primo Figlio", 'LR',0, 'C');
$pdf->Cell(23,7,"Secondo", 'LR',0, 'C');
$pdf->Cell(2,7,"", 0,0, 'C');
$pdf->Cell(23,7,"Primo Figlio", 'LR',0, 'C');
$pdf->Cell(23,7,"Secondo", 'LR',0, 'C');
$pdf->Cell(2,7,"", 0,0, 'C');
$pdf->Cell(23,7,"Primo Figlio", 'LR',0, 'C');
$pdf->Cell(23,7,"Secondo", 'LR',1, 'C');

$pdf->Cell(48,7,"", 'LBR',0, 'C');
$pdf->Cell(23,7,"", 'LBR',0, 'C');
$pdf->Cell(23,7,"Figlio", 'LBR',0, 'C');
$pdf->Cell(2,7,"", 0,0, 'C');
$pdf->Cell(23,7,"", 'LBR',0, 'C');
$pdf->Cell(23,7,"Figlio", 'LBR',0, 'C');
$pdf->Cell(2,7,"", 0,0, 'C');
$pdf->Cell(23,7,"", 'LBR',0, 'C');
$pdf->Cell(23,7,"Figlio", 'LBR',1, 'C');

$pdf->Cell(48,8,"", 1,0, 'C');
$pdf->Cell(46,8,"MATERNA", 1,0, 'C', true);
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(46,8,"ELEMENTARI", 1,0, 'C', true);
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(46,8,"MEDIE", 1,1, 'C', true);

$pdf->Cell(48,8,"Settembre", 1,0, 'C');
$pdf->Cell(23,8,"365", 1,0, 'C');
$pdf->Cell(23,8,"325", 1,0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"435", 1,0, 'C');
$pdf->Cell(23,8,"395", 1,0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"450", 1,0, 'C');
$pdf->Cell(23,8,"415", 1,1, 'C');

$pdf->Cell(48,8,"Ottobre", 1,0, 'C');
$pdf->Cell(23,8,"365", 1,0, 'C');
$pdf->Cell(23,8,"325", 1,0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"435", 1,0, 'C');
$pdf->Cell(23,8,"395", 1,0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"450", 1,0, 'C');
$pdf->Cell(23,8,"415", 1,1, 'C');

$pdf->Cell(48,8,"Novembre", 1,0, 'C');
$pdf->Cell(23,8,"365", 1,0, 'C');
$pdf->Cell(23,8,"325", 1,0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"435", 1,0, 'C');
$pdf->Cell(23,8,"395", 1,0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"450", 1,0, 'C');
$pdf->Cell(23,8,"415", 1,1, 'C');

$pdf->Cell(48,8,"Dicembre", 1,0, 'C');
$pdf->Cell(23,8,"365", 1,0, 'C');
$pdf->Cell(23,8,"325", 1,0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"435", 1,0, 'C');
$pdf->Cell(23,8,"395", 1,0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"450", 1,0, 'C');
$pdf->Cell(23,8,"415", 1,1, 'C');

$pdf->Cell(48,8,"Gennaio (1)", 1,0, 'C');
$pdf->Cell(23,8,"365", 1,0, 'C');
$pdf->Cell(23,8,"325", 1,0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"435", 1,0, 'C');
$pdf->Cell(23,8,"395", 1,0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"450", 1,0, 'C');
$pdf->Cell(23,8,"415", 1,1, 'C');

$pdf->Cell(48,8,"Febbraio", 1,0, 'C');
$pdf->Cell(23,8,"365", 1,0, 'C');
$pdf->Cell(23,8,"325", 1,0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"435", 1,0, 'C');
$pdf->Cell(23,8,"395", 1,0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"450", 1,0, 'C');
$pdf->Cell(23,8,"415", 1,1, 'C');

$pdf->Cell(48,8,"Marzo", 1,0, 'C');
$pdf->Cell(23,8,"365", 1,0, 'C');
$pdf->Cell(23,8,"325", 1,0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"435", 1,0, 'C');
$pdf->Cell(23,8,"395", 1,0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"450", 1,0, 'C');
$pdf->Cell(23,8,"415", 1,1, 'C');

$pdf->Cell(48,8,"Aprile", 1,0, 'C');
$pdf->Cell(23,8,"365", 1,0, 'C');
$pdf->Cell(23,8,"325", 1,0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"435", 1,0, 'C');
$pdf->Cell(23,8,"395", 1,0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"450", 1,0, 'C');
$pdf->Cell(23,8,"415", 1,1, 'C');

$pdf->Cell(48,8,"Maggio", 1,0, 'C');
$pdf->Cell(23,8,"365", 1,0, 'C');
$pdf->Cell(23,8,"325", 1,0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"435", 1,0, 'C');
$pdf->Cell(23,8,"395", 1,0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"450", 1,0, 'C');
$pdf->Cell(23,8,"415", 1,1, 'C');

$pdf->Cell(48,8,"Giugno (2)", 1,0, 'C');
$pdf->Cell(23,8,"365", 1,0, 'C');
$pdf->Cell(23,8,"325", 1,0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"435", 1,0, 'C');
$pdf->Cell(23,8,"395", 1,0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"450", 1,0, 'C');
$pdf->Cell(23,8,"415", 1,1, 'C');

$pdf->Ln(2);

$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$pdf->Cell(48,8,"TOTALE ANNUO", "LTR",0, 'C');
$pdf->Cell(23,8,"3650", "LTR",0, 'C');
$pdf->Cell(23,8,"3250", "LTR",0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"4350", "LTR",0, 'C');
$pdf->Cell(23,8,"3950", "LTR",0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"4500", "LTR",0, 'C');
$pdf->Cell(23,8,"4150", "LTR",1, 'C');

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(48,4,"Senza Iscrizione", "LBR",0, 'C');
$pdf->Cell(23,4,"", "LBR",0, 'C');
$pdf->Cell(23,4,"", "LBR",0, 'C');
$pdf->Cell(2,4,"", 0,0, 'C');
$pdf->Cell(23,4,"", "LBR",0, 'C');
$pdf->Cell(23,4,"", "LBR",0, 'C');
$pdf->Cell(2,4,"", 0,0, 'C');
$pdf->Cell(23,4,"", "LBR",0, 'C');
$pdf->Cell(23,4,"", "LBR",1, 'C');

$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(48,8,"Iscrizione (1)", 1,0, 'C');
$pdf->Cell(23,8,"85", 1,0, 'C');
$pdf->Cell(23,8,"85", 1,0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"85", 1,0, 'C');
$pdf->Cell(23,8,"85", 1,0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"85", 1,0, 'C');
$pdf->Cell(23,8,"85", 1,1, 'C');

$pdf->Ln(2);

$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$pdf->Cell(48,8,"TOTALE ANNUO", "LTR",0, 'C');
$pdf->Cell(23,8,"3735", "LTR",0, 'C');
$pdf->Cell(23,8,"3335", "LTR",0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"4435", "LTR",0, 'C');
$pdf->Cell(23,8,"4035", "LTR",0, 'C');
$pdf->Cell(2,8,"", 0,0, 'C');
$pdf->Cell(23,8,"4585", "LTR",0, 'C');
$pdf->Cell(23,8,"4235", "LTR",1, 'C');


$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(48,4,"Con Iscrizione", "LBR",0, 'C');
$pdf->Cell(23,4,"", "LBR",0, 'C');
$pdf->Cell(23,4,"", "LBR",0, 'C');
$pdf->Cell(2,4,"", 0,0, 'C');
$pdf->Cell(23,4,"", "LBR",0, 'C');
$pdf->Cell(23,4,"", "LBR",0, 'C');
$pdf->Cell(2,4,"", 0,0, 'C');
$pdf->Cell(23,4,"", "LBR",0, 'C');
$pdf->Cell(23,4,"", "LBR",1, 'C');

$pdf->Ln(5);
$pdf->SetFont($fontdefault,'',10);
$testo= utf8_decode("(1) La quota d'iscrizione per l'anno successivo va versata a gennaio");
$pdf->Cell(0,5,$testo,0,1, "L");

$testo= utf8_decode("(2) Il saldo spese didattiche va versato a Giugno ed è calcolato sull'effettivo costo sostenuto dalla classe e dal singolo alunno nel corso dell'anno");
$pdf->MultiCell(0,5,$testo);

$pdf->Ln(5);
$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$testo= utf8_decode("Le quote vanno versate entro il 5 di ogni mese sul conto Banca Etica");
$pdf->Cell(0,5,$testo,0,1, "C");

$testo= utf8_decode("IBAN: IT92 C050 1812 1010 000 1142 6830");
$pdf->Cell(0,5,$testo,0,1,"C");

$pdf->Ln(20);

$pdf->SetFont($fontdefaultc,'',10);
$testo= utf8_decode("*Nel caso di fruitori non soci richiedere in segreteria la tabella ''Contributo scolastico minimo fruitori non soci''");
$pdf->MultiCell(0,5,$testo);

?>
