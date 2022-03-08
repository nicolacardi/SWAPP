<?$sql = "SELECT DISTINCT nome_alu, cognome_alu, comunenascita_alu, provnascita_alu, datanascita_alu, citta_alu, prov_alu, cf_alu, mf_alu, desc_cls, sezione_cla  FROM tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu_cla = ID_alu LEFT JOIN tab_classi ON classe_cla = classe_cls WHERE ID_alu = ? AND annoscolastico_cla = ?;";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "is", $ID_alu_cla, $annoscolastico_cla);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $nome_alu, $cognome_alu, $comunenascita_alu, $provnascita_alu, $datanascita_alu, $citta_alu, $prov_alu, $cf_alu, $mf_alu, $desc_cls, $sezione_cla);
while (mysqli_stmt_fetch($stmt)) {
}
if ($mf_alu == "M") {$finmin = "o"; $finMAI = "O";} else {$finmin = "a"; $finMAI = "A";}
if ($aselme_cla == 'AS') { header('Location: 02IMieiAlunni.php'); }

$sql2 = "SELECT codmat_cer, votocertcomp_cer FROM tab_certcompetenze WHERE ID_alu_cer = ? AND annoscolastico_cer = ? ;";
$stmt2 = mysqli_prepare($mysqli, $sql2);
mysqli_stmt_bind_param($stmt2, "is", $ID_alu_cla, $annoscolastico_cla);
mysqli_stmt_execute($stmt2);
mysqli_stmt_bind_result($stmt2, $codmat_cer, $votocertcomp_cer);
mysqli_stmt_store_result($stmt2);
$i=1;
while (mysqli_stmt_fetch($stmt2)) {
	 $votocertcomp_cerA[$i] = $votocertcomp_cer;
     $i++;         
}
//FRONTESPIZIO E RETRO************************************************************************************************************************************
$pdf->AddPage();
include_once("iscrizioni/diciture.php");
include("12stampasoloamministrativiA4.php");

//Rettangolo grande sx
$pdf->SetDrawColor(225,96,3);
$pdf->SetTextColor(225,96,3);
$pdf->Rect(10,10,190,275);
//Rettangolo grande interno tratteggiato sx
$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->Rect(12,12,186,271);
$pdf->SetDash(); //5mm on, 5mm off

//Logo
$width =  75;
$positionX= 210 / 2 - ($width/2);
$positionY =  25;
$pdf->Image('assets/img/logo/logo'.$codscuola.'/logodefArancione.png',$positionX,$positionY, $width);
//Titoli
$pdf->SetFont('TitilliumWeb-SemiBold','',16);


$pdf->SetXY (10,100);
$pdf->Cell(190,10,"CERTIFICAZIONE DELLE COMPETENZE", 0,1, 'C');
$pdf->SetFont($fontdefault,'',16);
$pdf->SetTextColor(0,0,0);
if ($aselme_cla =="EL") {$pdf->Cell(190,10,"al termine della Scuola Primaria", 0,1, 'C');} else {$pdf->Cell(190,10,"al termine del primo ciclo di istruzione", 0,1, 'C');}

$frontespizioELA = array("- Visto il decreto legislativo 13 aprile 2017, n. 62 e, in particolare, l'articolo 9;", "- Visto il decreto ministeriale 3 ottobre 2017, n. 742, concernente l'adozione del modello nazionale di certificazione delle competenze per le scuole del primo ciclo di istruzione;", "- Visti gli atti d'ufficio relativi alle valutazioni espresse in sede di scrutinio finale dagli insegnanti di classe al termine del quinto anno di corso della scuola primaria;", "- Tenuto conto del percorso scolastico quinquennale;");
$pdf->SetFont('TitilliumWeb-SemiBold','',16);
$frontespizioMEA = array("- Visto il decreto legislativo 13 aprile 2017, n. 62 e, in particolare, l'articolo 9;", "- Visto il decreto ministeriale 3 ottobre 2017, n. 742, concernente l'adozione del modello nazionale di certificazione delle competenze per le scuole del primo ciclo di istruzione;", "- Visti gli atti d'ufficio relativi alle valutazioni espresse in sede di scrutinio finale dal Consiglio di classe del terzo anno di corso della scuola secondaria di primo grado;", "- tenuto conto del percorso scolastico ed in riferimento al Profilo dello studente al termine del primo ciclo di istruzione;");
$pdf->SetFont('TitilliumWeb-SemiBold','',16);

$pdf->SetXY (10,130);
$pdf->Cell(190,10,"Il Coordinatore Didattico", 0,1, 'C');
$pdf->SetX (30);
$pdf->SetFont($fontdefault,'',12);
if ($aselme_cla =="EL") {$pdf->Cell(150,10,utf8_decode($frontespizioELA[0]), 0,1, 'L');} else {$pdf->Cell(150,10,utf8_decode($frontespizioMEA[0]), 0,1, 'L');}
$pdf->SetX (30);
if ($aselme_cla =="EL") {$txt=$pdf->MultiCell(150,8,utf8_decode($frontespizioELA[1]), 0,"L",0,2);} else {$txt=$pdf->MultiCell(150,8,utf8_decode($frontespizioMEA[1]), 0,"L",0,2);}
$pdf->SetX (30);
if ($aselme_cla =="EL") {$txt=$pdf->MultiCell(150,8,utf8_decode($frontespizioELA[2]), 0,"L",0,2);} else {$txt=$pdf->MultiCell(150,8,utf8_decode($frontespizioMEA[2]), 0,"L",0,2);}
$pdf->SetX (30);
if ($aselme_cla =="EL") {$txt=$pdf->MultiCell(150,8,utf8_decode($frontespizioELA[3]), 0,"L",0,2);} else {$txt=$pdf->MultiCell(150,8,utf8_decode($frontespizioMEA[3]), 0,"L",0,2);}
$pdf->SetFont('TitilliumWeb-SemiBold','',16);
$pdf->SetXY (10,205);
$pdf->Cell(190,10,"CERTIFICA", 0,1, 'C');
$pdf->SetFont($fontdefault,'',12);
$pdf->SetX (30);
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(150,10,utf8_decode("che l'alunn".$finmin." ".$nome_alu." ".$cognome_alu." - C.F. ".$cf_alu), 0,1, 'C');
$pdf->SetX (30);
$pdf->SetFont($fontdefault,'',12);
if ($provnascita_alu !="") { $comunenascita_alu = $comunenascita_alu ." (".$provnascita_alu.")";}
$pdf->Cell(150,10,"Nat".$finmin." a ".$comunenascita_alu." il ".timestamp_to_ggmmaaaa($datanascita_alu), 0,1, 'C');
$pdf->SetX (30);
$pdf->Cell(150,10,utf8_decode("ha frequentato nell'anno scolastico ".$annoscolastico_cla." la classe ".$desc_cls." sez ". $sezione_cla), 0,1, 'C');
$pdf->SetX (30);
$pdf->Cell(150,10,utf8_decode("ed ha raggiunto i livelli di competenza di seguito illustrati"), 0,1, 'C');

 //FINE FRONTESPIZIO************************************************************************************************************************************
 $pdf->SetDrawColor(0,0,0);
 
  //INIZIO SCRITTURA PAGELLA************************************************************************************************************************************
$pdf->AddPage();

include("12stampasoloamministrativiA4.php");
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(0,0,0);
$pdf->SetX (30);
$pdf->SetY (10);

$w1 = 10;
$w2 = 40;
$w3 = 120;
$w4 = 20;
$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->SetWidths(array(10,40, 120,20));
$pdf->SetAligns(array("C","C", "L","C"));
$pdf->SetBorders(array(1,1,1,1));

$tabcompELA = array("idle", "Competenze chiave europee", "Comunicazione nella madrelingua o lingua di istruzione", "Comunicazione nella lingua straniera", "Competenza matematica e competenze di base in scienza e tecnologia", "Competenze digitali", "Imparare ad imparare", "Competenze sociali e civiche", "Spirito di iniziativa *", "Consapevolezza ed espressione culturale", "L'alunn".$finmin." ha inoltre mostrato significative competenze nello svolgimento di attività scolastiche e/o extrascolastiche, relativamente a:");
$tabcompELA2 = array("idle", "Competenze dal Profilo dello studente al termine del primo ciclo di istruzione", "Ha una padronanza della lingua italiana che gli consente di comprendere enunciati, di raccontare le proprie esperienze e di adottare un registro linguistico appropriato alle diverse situazioni.", "È in grado di sostenere in lingua inglese una comunicazione essenziale in semplici situazioni di vita quotidiana.", "Utilizza le sue conoscenze matematiche e scientifico-tecnologiche per trovare e giustificare soluzioni a problemi reali.", "Usa con responsabilità le tecnologie in contesti comunicativi concreti per ricercare informazioni e per interagire con altre persone, come supporto alla creatività e alla soluzione di problemi semplici.", "Possiede un patrimonio di conoscenze e nozioni di base ed è in grado di ricercare nuove informazioni. Si impegna in nuovi apprendimenti anche in modo autonomo.", "Ha cura e rispetto di sé, degli altri e dell'ambiente. Rispetta le regole condivise e collabora con gli altri. Si impegna per portare a compimento il lavoro iniziato, da solo o insieme agli altri.", "Dimostra originalità e spirito di iniziativa. È in grado di realizzare semplici progetti. Si assume le proprie responsabilità, chiede aiuto quando si trova in difficoltà e sa fornire aiuto a chi lo chiede.", "Si orienta nello spazio e nel tempo, osservando e descrivendo ambienti, fatti, fenomeni e produzioni artistiche.", "Riconosce le diverse identità, le tradizioni culturali e religiose in un'ottica di dialogo e di rispetto reciproco.", "In relazione alle proprie potenzialità e al proprio talento si esprime negli ambiti che gli sono più congeniali: motori, artistici e musicali.");
$tabcompMEA2 = array("idle", "Competenze dal Profilo dello studente al termine del primo ciclo di istruzione", "Ha una padronanza della lingua italiana che gli consente di comprendere e produrre enunciati e testi di una certa complessità, di esprimere le proprie idee, di adottare un registro linguistico appropriato alle diverse situazioni.", "E' in grado di esprimersi in lingua inglese a livello elementare (A2 del Quadro Comune Europeo di Riferimento) e, in una seconda lingua europea, di affrontare una comunicazione essenziale in semplici situazioni di vita quotidiana. Utilizza la lingua inglese anche con le tecnologie dell'informazione e della comunicazione.", "Utilizza le sue conoscenze matematiche e scientifico-tecnologiche per analizzare dati e fatti della realtà e per verificare l'attendibilità di analisi quantitative proposte da altri. Utilizza il pensiero logico-scientifico per affrontare problemi e situazioni sulla base di elementi certi. Ha consapevolezza dei limiti delle affermazioni che riguardano questioni complesse.", "Utilizza con consapevolezza e responsabilità le tecnologie per ricercare, produrre ed elaborare dati e informazioni, per interagire con altre persone, come supporto alla creatività e alla soluzione di problemi.", "Possiede un patrimonio organico di conoscenze e nozioni di base ed è allo stesso tempo capace di ricercare e di organizzare nuove informazioni. Si impegna in nuovi apprendimenti in modo autonomo.", "Ha cura e rispetto di sé e degli altri come presupposto di uno stile di vita sano e corretto. E' consapevole della necessità del rispetto di una convivenza civile, pacifica e solidale. Si impegna per portare a compimento il lavoro iniziato, da solo o insieme ad altri.", "Ha spirito di iniziativa ed è capace di produrre idee e progetti creativi. Si assume le proprie responsabilità, chiede aiuto quando si trova in difficoltà e sa fornire aiuto a chi lo chiede. E' disposto ad analizzare se stesso e a misurarsi con le novità e gli imprevisti.", "Si orienta nello spazio e nel tempo e interpreta i sistemi simbolici e culturali della società.", "Riconosce ed apprezza le diverse identità, le tradizioni culturali e religiose, in un'ottica di dialogo e di rispetto reciproco.", "In relazione alle proprie potenzialità e al proprio talento si esprime negli ambiti che gli sono più congeniali: motori, artistici e musicali.");


$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Row(array("", utf8_decode($tabcompELA[1]), utf8_decode($tabcompELA2[1]), "Livello (1)"));
$pdf->SetFont($fontdefault,'',10);
for ($x = 1; $x <= 7; $x++) {
	if($aselme_cla == "EL") {
		$pdf->Row(array($x, utf8_decode($tabcompELA[$x+1]), utf8_decode($tabcompELA2[$x+1]), $votocertcomp_cerA[$x]));
	} else {
		$pdf->Row(array($x, utf8_decode($tabcompELA[$x+1]), utf8_decode($tabcompMEA2[$x+1]), $votocertcomp_cerA[$x]));
	}
}

$pdf->Cell($w1,10,"", "LTR",0, 'C');
$pdf->Cell($w2,10,"", "LTR",0, 'C');
$pdf->SetXY (10+$w1+$w2,$pdf->GetY());
if($aselme_cla == "EL") {$pdf->MultiCell($w3,5,utf8_decode($tabcompELA2[9]), 1,"L",0,2);} else {$pdf->MultiCell($w3,5,utf8_decode($tabcompMEA2[9]), 1,"L",0,2);}
$pdf->SetXY (10+$w1+$w2+$w3,$pdf->GetY()-10);
$pdf->Cell($w4,10,$votocertcomp_cerA[8], 1,1, 'C');
//
$pdf->Cell($w1,10,"8", "LR",0, 'C');
$pdf->MultiCell($w2,5,utf8_decode($tabcompELA[9]), "LR","L",0,2);
$pdf->SetXY (10+$w1+$w2,$pdf->GetY()-10);
if($aselme_cla == "EL") {$pdf->MultiCell($w3,5,utf8_decode($tabcompELA2[10]), 1,"L",0,2);} else {$pdf->MultiCell($w3,5,utf8_decode($tabcompMEA2[10]), 1,"L",0,2);}
$pdf->SetXY (10+$w1+$w2+$w3,$pdf->GetY()-10);
$pdf->Cell($w4,10,$votocertcomp_cerA[9], 1,1, 'C');
//
$pdf->Cell($w1,10,"", "LBR",0, 'C');
$pdf->Cell($w2,10,"", "LBR",0, 'C');
$pdf->SetXY (10+$w1+$w2,$pdf->GetY());
if($aselme_cla == "EL") {$pdf->MultiCell($w3,5,utf8_decode($tabcompELA2[11]), 1,"L",0,2);} else {$pdf->MultiCell($w3,5,utf8_decode($tabcompMEA2[11]), 1,"L",0,2);}
$pdf->SetXY (10+$w1+$w2+$w3,$pdf->GetY()-10);
$pdf->Cell($w4,10,$votocertcomp_cerA[10], 1,1, 'C');
//
$pdf->Cell($w1,10,"", "LTR",0, 'C');
$pdf->SetXY (10+$w1,$pdf->GetY());
$pdf->MultiCell($w2+$w3+$w4,5,utf8_decode($tabcompELA[10]), "LTR","L",0, 2);
//
$pdf->Cell($w1,10,"9", "LBR",0, 'C');
$pdf->SetXY (10+$w1,$pdf->GetY());
$pdf->Rect(10+$w1,$pdf->GetY()-10,$w2+$w3+$w4,20);
$pdf->MultiCell($w2+$w3+$w4,5,utf8_decode($votocertcomp_cerA[11]), 0,"L",0, 2);

$pdf->SetFont($fontdefault,'',10);
$pdf->Ln(5);
$pdf->Cell(0,10,"* Sense of initiative and entrepreneurship nella Raccomandazione europea e del Consiglio del 18 dicembre 2006 	", 0,0, 'C');

//Timbro Firme e tratteggi per firme Sinistra
$indicetimbro = rand(1,9);
$pdf->Image('assets/img/timbri/timbro'.$codscuola.'/timbro'.$indicetimbro.'.png', (135), 210, 20);
$pdf->SetFont($fontdefault,'',12);
$pdf->SetXY (15,210);
$pdf->Cell(60,10,"Luogo e data", 0 ,1, 'C');
$pdf->SetXY (15,215);
$pdf->SetXY (135,210);
$pdf->Cell(60,10,"Il Coordinatore Didattico", 0 ,1, 'C');
$indicefirma = rand(1,15);
$pdf->Image('assets/img/firmecoordinatori/firme'.$codscuola.'/CoordDidattico'.$aselme_cla.$indicefirma.'.png', (135), 215, 60);

$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->SetXY ((15),220);
$pdf->Cell(60,10,$li.",", "B" ,0, 'L');
$pdf->SetXY ((135),220);
$pdf->Cell(60,10,"", "B" ,0, 'C');
$pdf->SetDash(); //Restore dash
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(0,0,0);


$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->SetXY ((15+210),260);
$pdf->Cell(60,10,"", "B" ,0, 'C');
$pdf->SetXY ((135+210),260);
$pdf->Cell(60,10,"", "B" ,0, 'C');
$pdf->SetDash(); //Restore dash
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(0,0,0);

$pdf->SetXY (10,235);
$pdf->SetWidths(array(30,160));
$pdf->SetAligns(array("L","L"));
$pdf->SetBorders(array("B","B"));
$pdf->SetFont('TitilliumWeb-SemiBold','',8);
$pdf->Row(array("(1) Livello", utf8_decode("Indicatori esplicativi")));
$pdf->SetFont($fontdefault,'',10);
$pdf->Row(array(utf8_decode("A - Avanzato"), utf8_decode("L'alunn".$finmin." svolge compiti e risolve problemi complessi, mostrando padronanza nell'uso delle conoscenze e delle abilità; propone e sostiene le proprie opinioni e assume in modo responsabile decisioni consapevoli.")));
$pdf->Row(array(utf8_decode("B - Intermedio"), utf8_decode("L'alunn".$finmin." svolge compiti e risolve problemi in situazioni nuove, compie scelte consapevoli, mostrando di saper utilizzare le conoscenze e le abilità acquisite.	
")));
$pdf->Row(array(utf8_decode("C - Base"), utf8_decode("L'alunn".$finmin." svolge compiti semplici anche in situazioni nuove, mostrando di possedere conoscenze e abilità fondamentali e di saper applicare basilari regole e procedure apprese.	
")));
$pdf->Row(array(utf8_decode("D - Iniziale"), utf8_decode("L'alunn".$finmin.", se opportunamente guidat".$finmin.", svolge compiti semplici in situazioni note.	
")));
?>