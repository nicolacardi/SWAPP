<?//RICHIESTA DIETA SPECIALE ************************************************************************************************************************************
$pdf->AddPage();
$pdf->SetLink($link6);
$pdf->SetFont('TitilliumWeb-SemiBold','',16);
$pdf->Cell(0,10,"ALLEGATO E", 0,1, 'C');

$pdf->Cell(0,10,"MODULO RICHIESTA DI DIETA SPECIALE PER MOTIVI SANITARI", 0,1, 'C');
$pdf->SetFont('TitilliumWeb-SemiBold','',16);
$pdf->Cell(0,10,"PER IL SERVIZIO DI REFEZIONE SCOLASTICA", 0,1, 'C');


$pdf->Ln(10);
$pdf->SetFont('TitilliumWeb-ExtraLight','',14);
$testo= utf8_decode("Il/la sottoscritto/a (nome e cognome)   ....................................................................................................................");
$pdf->Cell(0,10,$testo,0,1, "C");

$testo= utf8_decode("genitore (o esercitante la potestà genitoriale) del/la bambino/a   ..............................................................");
$pdf->Cell(0,10,$testo,0,1, "C");

$testo= utf8_decode("nato/a ..................................... il ........................... residente a  ........................................................................................");
$pdf->Cell(0,10,$testo,0,1, "C");

$testo= utf8_decode("via/piazza  ................................................................................................................................................................................");
$pdf->Cell(0,10,$testo,0,1, "C");

$testo= utf8_decode("tel. abitazione n° ............................................................. tel.ufficio/cellulare ............................................................");
$pdf->Cell(0,10,$testo,0,1, "C");

$testo= utf8_decode("che frequenta la classe ..................... della ".$nomecittascuola." per l'a.s. ".$annoscolastico);
$pdf->Cell(0,10,$testo,0,1, "C");

$pdf->Ln(5);

$pdf->SetFont('TitilliumWeb-SemiBold','',16);
$pdf->Cell(0,10,"CHIEDE",0,1, "C");

$pdf->SetFont('TitilliumWeb-ExtraLight','',14);
$testo= utf8_decode("la somministrazione al\alla proprio\a figlio\a  di  (barrare la casella interessata):");
$pdf->Cell(0,10,$testo,0,1, "L");

$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$imgsquare = '../assets/img/square.png';
$pdf->Cell(95,10,$pdf->Image($imgsquare,$pdf->GetX(), $pdf->GetY()+2,5)."     Dieta speciale per allergia o intolleranza alimentare",0,1,"L"); 

$pdf->SetFont('TitilliumWeb-ExtraLight','',14);
$testo="a tal fine si allega:
- Certificato del medico curante con diagnosi ed elenco alimenti da escludere dall'alimentazione

";
$pdf->SetFont($fontdefault,'',12);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$imgsquare = '../assets/img/square.png';
$pdf->Cell(95,10,$pdf->Image($imgsquare,$pdf->GetX(), $pdf->GetY()+2,5)."     Dieta speciale per la celiachia",0,1,"L"); 

$pdf->SetFont('TitilliumWeb-ExtraLight','',14);
$testo="a tal fine si allega:
- certificazione del medico curante con diagnosi

";
$pdf->SetFont($fontdefault,'',12);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$imgsquare = '../assets/img/square.png';
$pdf->Cell(95,10,$pdf->Image($imgsquare,$pdf->GetX(), $pdf->GetY()+2,5)."     Dieta speciale per altre condizioni permanenti",0,1,"L"); 

$pdf->SetFont('TitilliumWeb-ExtraLight','',14);
$testo="a tal fine si allega:
- Certificazione del medico curante con diagnosi ed elenco alimenti da escludere dall'alimentazione";
$pdf->SetFont($fontdefault,'',12);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);



$pdf->AddPage();

$testo= "INFORMATIVA Al SENSI DELL'ART. 13 D. LGS. 196/2OO3 IN RELAZIONE AL MODULO DI RICHIESTA DIETE SPECIALI

Gentile Signore/a,
desideriamo informarla che il D.Lgs. 196 del 30 giugno 2003 ''Codice in materia di protezione dati personali'' prevede la tutela delle persone e di altri soggetti rispetto al trattamento dei dati personali.
Secondo la normativa indicata tale trattamento sarà improntato ai principi di correttezza, liceità e trasparenza e di tutela della sua riservatezza e dei suoi diritti. Pertanto, ai sensi dell'art.13 del D.Lgs. 196/2003, le forniamo le seguenti informazioni:
1) i dati da lei forniti verranno trattati per la seguente finalità: somministrazione di dieta speciale o dieta di transizione, adattamento della tabella dietetica del centro cottura, interventi di sorveglianza nutrizionale da parte del Servizio Igiene Alimenti e Nutrizione della ASL competente per territorio;
2) il trattamento sarà effettuato con le seguenti modalità: manuale/informatizzato;
3) il conferimento dei dati è obbligatorio al fine di predisporre la dieta speciale o la dieta di transizione;
4) il diniego a fornire i dati personali e a sottoscrivere il consenso non consentirà di predisporre a suo figlio\a la dieta;
5) i dati saranno utilizzati dai dipendenti comunali incaricati del trattamento, dal personale della ditta gestore del servizio di ristorazione presso le scuole, dal personale sanitario del Servizio Igiene Alimenti e Nutrizione della ASL competente per territorio;
6) il trattamento effettuato su tali dati sensibili sarà compreso nei limiti indicati dal Garante per finalità di carattere istituzionale;
7) i dati non saranno oggetto di diffusione;
8) in ogni momento potrà esercitare i suoi diritti nei confronti del titolare del trattamento, ai sensi dell'ari. 7 del D.Lgs. 196/2003;
9) il titolare del trattamento è la ".$nomecittascuola;

$pdf->SetFont($fontdefault,'',11);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,6,$testo);

$pdf->Ln(8);
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(90,5,"Firma del padre/tutore* (leggibile)",0,0,'L');
$pdf->Cell(100,5,"","B",1);
$pdf->SetFont($fontdefault,'',8);
$pdf->Cell(90,5,"(* ove presente)",0,1,'L');
$pdf->Ln(4);
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(90,5,"Firma della madre/tutrice* (leggibile)",0,0,'L');
$pdf->Cell(100,5,"","B",1);
$pdf->SetFont($fontdefault,'',8);
$pdf->Cell(90,5,"(* ove presente)",0,1,'L');
$pdf->SetFont($fontdefault,'',12);
$pdf->Ln(4);
$pdf->Cell(90,5,"Data e luogo",0,0,'L');
$pdf->Cell(100,5,"","B",1);

$pdf->Ln(20);
$pdf->SetFont('TitilliumWeb-SemiBold','',14);
$testo="Istruzioni per la riconsegna del modulo";
$pdf->SetFont($fontdefault,'',12);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-ExtraLight','',14);
$testo="La richiesta, con allegato il certificato del medico curante ed elenco alimenti da escludere dalla dieta, deve essere recapitata alla Segreteria della Scuola.";
$pdf->SetFont($fontdefault,'',12);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);
?>
