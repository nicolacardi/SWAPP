<?
//CONTRIBUTI ************************************************************************************************************************************
$pdf->AddPage();
$pdf->SetLink($link5);
$pdf->SetFont('TitilliumWeb-SemiBold','',16);
$pdf->Cell(0,10,"ALLEGATO D", 0,1, 'C');
$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$pdf->Cell(0,10,"ORARI ANNO SCOLASTICO ".$_SESSION['annopreiscrizione_fam'], 0,1, 'C');
$pdf->SetFont($fontdefault,'',9);

// $pdf->SetWidths(array(40, 75, 75));
// $pdf->Row(array("ASILO", "DA LUNEDI "));

$w1 = 55;
$w2 = 60;
$w3 = 75;



$pdf->Cell($w1,5,"ASILO", 1,0, 'L');
$pdf->Cell($w2,5,utf8_decode("DA LUNEDÌ A VENERDÌ"), 0,0, 'L');
$pdf->Cell($w3,5,"dalle ore 8:00 alle ore 14:50", 0,1, 'L');


$pdf->Cell(0,1,"", "B",1, 'L');

$pdf->Ln(1);

// $pdf->Cell($w1,5,"", 0,0, 'L');
// $pdf->Cell($w2,5,"", 0,0, 'L');

// $pdf->SetFont($fontdefault,'',7);
// $pdf->Cell($w3,5,"", 0,1, 'L');
// $pdf->SetFont($fontdefault,'',9);

// $pdf->Cell(0,1,"", "B",1, 'L');

// $pdf->Ln(1);

$pdf->Cell($w1,5,"SCUOLA PRIMARIA", 1,0, 'L');
$pdf->Cell($w2,5,"", 0,0, 'L');
$pdf->Cell($w3,5,"", 0,1, 'L');

$pdf->Ln(1);

$pdf->SetFont('TitilliumWeb-SemiBold','',9);
$pdf->Cell($w1,5,"CLASSI I, II", 0,0, 'L');
$pdf->SetFont($fontdefault,'',9);
$pdf->Cell($w2,5,utf8_decode("LUNEDÌ, MARTEDÌ, GIOVEDÌ, VENERDÌ"), 0,0, 'L');
$pdf->Cell($w3,5,"dalle ore 8:00 alle ore 13:20", 0,1, 'L');

$pdf->Cell($w1,5,"", 0,0, 'L');
$pdf->Cell($w2,5,"", 0,0, 'L');
$pdf->Cell($w3,5,utf8_decode("possibilità di 'doposcuola' fino alle ore 15:00"), 0,1, 'L');

$pdf->Cell($w1,5,"", 0,0, 'L');
$pdf->Cell($w2,5,utf8_decode("MERCOLEDÌ"), 0,0, 'L');
$pdf->Cell($w3,5,"dalle ore 8:00 alle ore 15:00", 0,1, 'L');

$pdf->Ln(1);

$pdf->SetFont('TitilliumWeb-SemiBold','',9);
$pdf->Cell($w1,5,"CLASSI III, IV", 0,0, 'L');
$pdf->SetFont($fontdefault,'',9);

$pdf->Cell($w2,5,utf8_decode("MARTEDÌ, MERCOLEDÌ, GIOVEDÌ"), 0,0, 'L');
$pdf->Cell($w3,5,"dalle ore 8:00 alle ore 15:00", 0,1, 'L');

$pdf->Cell($w1,5,"", 0,0, 'L');
$pdf->Cell($w2,5,utf8_decode("LUNEDÌ, VENERDÌ"), 0,0, 'L');
$pdf->Cell($w3,5,"dalle ore 8:00 alle ore 13:20", 0,1, 'L');

$pdf->Cell($w1,5,"", 0,0, 'L');
$pdf->Cell($w2,5,"", 0,0, 'L');
$pdf->Cell($w3,5,utf8_decode("possibilità di 'doposcuola' fino alle ore 15:00"), 0,1, 'L');

$pdf->Ln(1);

$pdf->SetFont('TitilliumWeb-SemiBold','',9);
$pdf->Cell($w1,5,"CLASSE V", 0,0, 'L');
$pdf->SetFont($fontdefault,'',9);

$pdf->Cell($w2,5,utf8_decode("DA LUNEDÌ A VENERDÌ"), 0,0, 'L');
$pdf->Cell($w3,5,"dalle ore 8:00 alle ore 15:00", 0,1, 'L');

$pdf->Cell(0,1,"", "B",1, 'L');

$pdf->Ln(1);

$pdf->Cell($w1,5,utf8_decode("SCUOLA SECONDARIA DI I° GRADO"), 1,0, 'L');
$pdf->Cell($w2,5,"", 0,0, 'L');
$pdf->Cell($w3,5,"", 0,1, 'L');

$pdf->Ln(1);

$pdf->SetFont('TitilliumWeb-SemiBold','',9);
$pdf->Cell($w1,5,"CLASSI VI, VII, VIII", 0,0, 'L');
$pdf->SetFont($fontdefault,'',9);

$pdf->Cell($w2,5,utf8_decode("DA LUNEDÌ A VENERDÌ"), 0,0, 'L');
$pdf->Cell($w3,5,"dalle ore 8:00 alle ore 15:00", 0,1, 'L');

$pdf->Cell(0,1,"", "B",1, 'L');
$pdf->Ln(1);

$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$testo= "CONTRIBUTO SCOLASTICO ANNUALE PROVVISORIO E MODALITÀ DI PAGAMENTO A.S.". $_SESSION['annopreiscrizione_fam'];
$pdf->Cell(0,5,utf8_decode($testo), 0,1, 'C');

$fontsizedefault = 10;
$pdf->SetFont($fontdefault,'',$fontsizedefault);

$w1 = 95;
$w2 = 95;

$pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
$pdf->Cell($w1,5,"- ASILO (pasti compresi)", 0,0, 'L');
$pdf->SetFont($fontdefault,'',$fontsizedefault);
$pdf->Cell($w2,5,"euro 4.008 + 330 di iscrizione", 0,1, 'L');

$pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
$pdf->Cell($w1,5,"- SCUOLA PRIMARIA (pasti esclusi)", 0,0, 'L');
$pdf->SetFont($fontdefault,'',$fontsizedefault);
$pdf->Cell($w2,5,"euro 4.068 + 330 di iscrizione", 0,1, 'L');

$pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
$pdf->Cell($w1,5,utf8_decode("- SCUOLA SECONDARIA DI I° GRADO (pasti esclusi)"), 0,0, 'L');
$pdf->SetFont($fontdefault,'',$fontsizedefault);
$pdf->Cell($w2,5,"euro 4.260 + 330 di iscrizione", 0,1, 'L');

$pdf->Ln(1);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,5,utf8_decode("Modalità di pagamento"), 0,1, 'L');
$pdf->SetFont($fontdefault,'',$fontsizedefault);
$rowH = 5;

$testo= "a) iscrizione entro il ".$scadiscrizione.$anno1." a mezzo bonifico bancario (in caso di nuova iscrizione contestuale alla data d'accettazione)";
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$rowH,$testo);

$testo= "b) in un'unica soluzione  entro il ".$scadiscrizione.$anno1." a mezzo bonifico bancario*";
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$rowH,$testo);


$testo= "c) iscrizione entro il ".$scadiscrizione.$anno1." e importo dell'intero contributo entro il ".$scadrataunicaDDMM.$anno1." a mezzo bonifico bancario";
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$rowH,$testo);

$testo= "d) iscrizione entro il ".$scadiscrizione.$anno1." a mezzo bonifico bancario e 12 rate tramite addebito SDD (ex RID) il giorno 10 di ogni mese da settembre a agosto.";
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$rowH,$testo);

$testo= "e) in caso di necessità diverse modalità di pagamento potranno essere concordate richiedendo un apposito colloquio al Consiglio di Amministrazione";
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$rowH,$testo);

$pdf->Ln(1);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,$rowH,utf8_decode("Importo delle 12 rate mensili"), 0,1, 'L');
$pdf->SetFont($fontdefault,'',$fontsizedefault);

$pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
$pdf->Cell($w1,$rowH,"- ASILO", 0,0, 'L');
$pdf->SetFont($fontdefault,'',$fontsizedefault);
$pdf->Cell($w2,$rowH,"euro 334", 0,1, 'L');

$pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
$pdf->Cell($w1,$rowH,"- SCUOLA PRIMARIA", 0,0, 'L');
$pdf->SetFont($fontdefault,'',$fontsizedefault);
$pdf->Cell($w2,$rowH,"euro 339", 0,1, 'L');

$pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
$pdf->Cell($w1,$rowH,utf8_decode("- SCUOLA SECONDARIA DI I° GRADO"), 0,0, 'L');
$pdf->SetFont($fontdefault,'',$fontsizedefault);
$pdf->Cell($w2,$rowH,"euro 355", 0,1, 'L');

$pdf->Cell(0,1,"", "B",1, 'L');

$pdf->Ln(1);

$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$testo= "DOPO SCUOLA - RETTE ANNUALI ". $_SESSION['annopreiscrizione_fam'];
$pdf->Cell(0,5,utf8_decode($testo), 0,1, 'C');

$pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
$pdf->Cell($w1,5,"- 1 rientro settimanale", 0,0, 'L');
$pdf->SetFont($fontdefault,'',$fontsizedefault);
$pdf->Cell($w2,5,"euro 360/anno - euro 40/rata mensile", 0,1, 'L');

$pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
$pdf->Cell($w1,5,"- 2 rientri settimanali", 0,0, 'L');
$pdf->SetFont($fontdefault,'',$fontsizedefault);
$pdf->Cell($w2,5,"euro 630/anno - euro 70/rata mensile", 0,1, 'L');

$pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
$pdf->Cell($w1,5,"- 3 rientri settimanali", 0,0, 'L');
$pdf->SetFont($fontdefault,'',$fontsizedefault);
$pdf->Cell($w2,5,"euro 900/anno - euro 100/rata mensile", 0,1, 'L');

$pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
$pdf->Cell($w1,5,"- 4 rientri settimanali", 0,0, 'L');
$pdf->SetFont($fontdefault,'',$fontsizedefault);
$pdf->Cell($w2,5,"euro 900/anno - euro 100/rata mensile", 0,1, 'L');

$pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
$pdf->Cell($w1,5,utf8_decode("- occasionale"), 0,0, 'L');
$pdf->SetFont($fontdefault,'',$fontsizedefault);
$pdf->Cell($w2,5,"euro 15/giorno", 0,1, 'L');

$testo= "la frequenza concordata ad inizio anno, salvo giustificati motivi, si intende per l'intero anno scolastico. La fattura è annuale, il pagamento mensile, entro il 10 del mese a mezzo bonifico bancario da ottobre a giugno";
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->Cell(0,1,"", "B",1, 'L');

$pdf->Ln(1);


$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$testo= "SERVIZIO MENSA";
$pdf->Cell(0,5,utf8_decode($testo), 0,1, 'C');

$pdf->SetFont($fontdefault,'',$fontsizedefault);
$testo= "Per le classi della primaria e della secondaria è possibile avvalersi del servizio mensa su richiesta. Il menù proposto è di tipo vegetariano, le materie prime sono biologiche e vengono quotidianamente preparate dal centro cottura NaturaSì di Villafranca. Il costo a pasto è di euro 6,00. Per usufruirne è necessario compilare l'appostio modulo definendo così preventivamente la frequenza di cui si intende avvalersi e acquistare preventivamente i blocchetti da 10 buoni presso la Segreteria. Per la prima classe il pasto a scuola rientra tra le attività pedagogico-sociali a conclusione della giornata scolastica e può essere anche portato a casa";
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

?>
