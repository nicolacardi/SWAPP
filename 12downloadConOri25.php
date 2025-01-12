<?


	
$sql = "SELECT data_cor, ";

for ($i = 1; $i<=8; ++$i) {
	$sql = $sql."area".$i."_cor, ";
}

for ($i = 1; $i<=5; ++$i) {
	$sql = $sql."atti".$i."_cor, ";
}

$sql = $sql." altreatti_cor,";

for ($x = 1; $x <= 3; $x++) {
	$sql = $sql." certi".$x."_cor,";
}

for ($i = 1; $i<=4; ++$i) {
	$sql = $sql."scuola".$i."_cor, ";
}
for ($i = 1; $i<=4; ++$i) {
	$sql = $sql."tiposcuola".$i."_cor, ";
}

$sql = $sql ." altrecerti_cor, nome_alu, cognome_alu FROM tab_consorientativo25 LEFT JOIN tab_anagraficaalunni ON ID_alu_cor = ID_alu ".
"WHERE ID_alu_cor = ? AND annoscolastico_cor = ?";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "is", $ID_alu_cla, $annoscolastico_cla);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $data_cor, $area1_cor, $area2_cor, $area3_cor, $area4_cor, $area5_cor, $area6_cor, $area7_cor, $area8_cor, $atti1_cor, $atti2_cor, $atti3_cor, $atti4_cor, $atti5_cor, $altreatti_cor, $certi1_cor, $certi2_cor, $certi3_cor, $scuola1_cor, $scuola2_cor, $scuola3_cor, $scuola4_cor, $tiposcuola1_cor, $tiposcuola2_cor, $tiposcuola3_cor, $tiposcuola4_cor, $altrecerti_cor, $nome_alu, $cognome_alu);
$k = 0;
while (mysqli_stmt_fetch($stmt)) {
		$k = 1;
}


//FRONTESPIZIO************************************************************************************************************************************
$pdf->AddPage();

include("12stampasoloamministrativiA4.php");


//Rettangolo grande
$pdf->SetDrawColor(220,29,36);
$pdf->Rect(10,10,190,275);
//Rettangolo grande interno tratteggiato
$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->Rect(12,12,186,271);
$pdf->SetDash(); //5mm on, 5mm off
//Logo
$width =  75;
$positionX= 210 / 2 - ($width/2);
$positionY =  25;
$pdf->Image('assets/img/logo/logo'.$codscuola.'/logodefRosso.png',$positionX,$positionY, $width);
//Titoli

$pdf->SetTextColor(220,29,36);
$pdf->SetXY (10,100);

$pdf->SetFont($fontdefault,'',16);
$pdf->Cell(0,8,utf8_decode("CONSIGLIO DI ORIENTAMENTO"), 0 ,1, 'C');
$pdf->Cell(0,8,utf8_decode("per la prosecuzione del percorso di istruzione e formazione"), 0 ,1, 'C');
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(0,6,utf8_decode("formulato dal Consiglio di classe nei confronti di"), 0,1, 'C');
$pdf->SetFont($fontdefault,'',16);
$pdf->Cell(0,10,utf8_decode($nome_alu." ".$cognome_alu), 0,1, 'C');
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(0,10,utf8_decode("Anno scolastico: ".$annoscolastico_cla." - Classe Terza / Sez.A"), 0,1, 'C');

$pdf->Cell(0,6,utf8_decode("allo scopo di supportare l'alunno/a nella scelta del percorso di istruzione e formazione"), 0,1, 'C');
$pdf->Cell(0,6,utf8_decode("anche ai fini dell'assolvimento dell'obbligo di istruzione"), 0,1, 'C');
$pdf->Cell(0,6,utf8_decode(" e del diritto-dovere all'istruzione e formazione"), 0,1, 'C');



$pdf->Ln(10);

//Timbro Firme e tratteggi per firme
$indicetimbro = rand(1,9);
$pdf->Image('assets/img/timbri/timbro'.$codscuola.'/timbro'.$indicetimbro.'.png', 135, 250, 20);
$pdf->SetFont($fontdefault,'',12);
$pdf->SetXY (15,250);
$pdf->Cell(60,10,"Luogo e Data", 0 ,0, 'C');
$pdf->SetXY (135,250);
$pdf->Cell(60,10,"Il Coordinatore Didattico", 0 ,1, 'C');
$indicefirma = rand(1,15);
$pdf->Image('assets/img/firmecoordinatori/firme'.$codscuola.'/CoordDidatticoME'.$indicefirma.'.png', 135, 255, 60);

$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->SetXY (15,260);
$pdf->Cell(60,10,$li.", ".timestamp_to_ggmmaaaa($data_cor), "B" ,0, 'L');
$pdf->SetXY (135,260);
$pdf->Cell(60,10,"", "B" ,0, 'C');
$pdf->SetDash(); //Restore dash
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(0,0,0);
 //FINE FRONTESPIZIO************************************************************************************************************************************

 //PAGINA CONS ORIENTATIVO************************************************************************************************************************************
$pdf->AddPage();

include("12stampasoloamministrativiA4.php");
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(0,0,0);
$pdf->SetX (30);
$pdf->SetY (10);




//******************************************************************************
$pdf->SetFont('TitilliumWeb-SemiBold','',10);


$imgsquare = 'assets/img/square.png';
$imgsquarecrossed = 'assets/img/squarecrossed.png';


$pdf->Ln(3);

$pdf->Cell(0,5,utf8_decode("Nel percorso scolastico e formativo compiuto nella scuola secondaria di primo grado l'alunno/a"), 0,1, 'C');
$pdf->Cell(0,5,utf8_decode("ha mostrato particolare interesse per le seguenti aree:"), 0,1, 'C');
$pdf->SetFont($fontdefault,'',12);

if ($area1_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+25, $pdf->GetY()+1,5);
$pdf->SetX (40);
$pdf->Cell(30,7,"umanistica",0,0,"L");

if ($area2_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
$pdf->SetX (95);
$pdf->Cell(30,7,"linguistica",0,0,"L");

if ($area8_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
$pdf->SetX (150);
$pdf->Cell(30,7,"sportivo-motoria",0,1,"L");

if ($area4_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+25, $pdf->GetY()+1,5);
$pdf->SetX (40);
$pdf->Cell(30,7,"tecnico-pratica",0,0,"L");

if ($area5_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
$pdf->SetX (95);
$pdf->Cell(30,7,"digitale",0,0,"L");

if ($area6_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
$pdf->SetX (150);
$pdf->Cell(30,7,"artistico-espressiva",0,1,"L");

if ($area7_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+25, $pdf->GetY()+1,5);
$pdf->SetX (40);
$pdf->Cell(30,7,"musicale",0,0,"L");

if ($area3_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
$pdf->SetX (95);
$pdf->Cell(95,7,"matematico-scientifico-tecnologica",0,1,"L");

//*********************************************


$pdf->Ln(3);
$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,5,utf8_decode("L'alunno/a ha avuto modo di sviluppare specifiche competenze grazie allo svolgimento"), "T",1, 'C');
$pdf->Cell(0,5,utf8_decode("di attività extrascolastiche attinenti ai seguenti ambiti:"), 0,1, 'C');
$pdf->SetFont($fontdefault,'',12);

if ($atti1_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+25, $pdf->GetY()+1,5);
$pdf->SetX (40);
$pdf->Cell(30,7,"culturali e artistiche",0,0,"L");

if ($atti2_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
$pdf->SetX (95);
$pdf->Cell(30,7,"musicali",0,0,"L");

if ($atti3_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
$pdf->SetX (150);
$pdf->Cell(30,7,"sportive",0,1,"L");

if ($atti4_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+25, $pdf->GetY()+1,5);
$pdf->SetX (40);
$pdf->Cell(30,7,"attivita' di cittadinanza attiva e volontariato",0,1,"L");

if ($atti5_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+25, $pdf->GetY()+1,5);
$pdf->SetX (40);
$pdf->Cell(60,7,"altre attivita'",0,0,"L");
$pdf->Cell(90,7,utf8_decode($altreatti_cor),1,1,"L");

//*********************************************

$pdf->Ln(3);
$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,5,utf8_decode("L'alunno/a ha conseguito fino alla data di espressione del presente consiglio di orientamento le seguenti certificazioni:"), "T",1, 'C');
// $pdf->Cell(0,6,utf8_decode(""), 0,1, 'C');
$pdf->SetFont($fontdefault,'',12);

if ($certi1_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+25, $pdf->GetY()+1,5);
$pdf->SetX (40);
$pdf->Cell(30,7,"certificazione linguistica",0,1,"L");

if ($certi2_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+25, $pdf->GetY()+1,5);
$pdf->SetX (40);
$pdf->Cell(30,7,"certificazione informatica",0,1,"L");

if ($certi3_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+25, $pdf->GetY()+1,5);
$pdf->SetX (40);
$pdf->Cell(60,7,"certificazione di altro tipo",0,0,"L");
$pdf->Cell(90,7,utf8_decode($altrecerti_cor),1,1,"L");


//******************************
// $pdf->SetFont($fontdefault,'',12);
// $pdf->Ln(5);
// $pdf->Cell(0,6,utf8_decode("In base a quanto sopra evidenziato, al percorso formativo compiuto dall'alunno/a"), 0,1, 'C');
// $pdf->Cell(0,6,utf8_decode("al rendimento scolastico globale ed alle competenze evidenziate nell'arco del triennio"), 0,1, 'C');
// $pdf->SetFont('TitilliumWeb-SemiBold','',12);
// $pdf->Cell(0,8,utf8_decode("il Consiglio di Classe formula il seguente consiglio orientativo **:"), 0,1, 'C');
// $pdf->SetFont($fontdefault,'',12);

// $pdf->SetX (35);
// $pdf->Cell(70,7,"",0,0,"L");
// $pdf->Cell(90,7,"Tipologia",0,1,"C");


// if ($scuola1_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
// $pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
// $pdf->SetX (35);
// $pdf->Cell(70,7,"istruzione Liceale",0,0,"L");
// $pdf->Cell(90,7,$tiposcuola1_cor,1,1,"L");

// if ($scuola2_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
// $pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
// $pdf->SetX (35);
// $pdf->Cell(70,7,"istruzione Professionale",0,0,"L");
// $pdf->Cell(90,7,$tiposcuola2_cor,1,1,"L");

// if ($scuola3_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
// $pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
// $pdf->SetX (35);
// $pdf->Cell(70,7,"istruzione Tecnica",0,0,"L");
// $pdf->Cell(90,7,$tiposcuola3_cor,1,1,"L");

// if ($scuola4_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
// $pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
// $pdf->SetX (35);
// $pdf->Cell(70,7,"Istr./Form. professionale regionale",0,0,"L");
// $pdf->Cell(90,7,$tiposcuola4_cor,1,1,"L");





$row = 4; 
$pdf->SetFont($fontdefault,'',12);
$pdf->Ln(5);



$pdf->SetFont($fontdefault,'',12);
$commento = "Tenendo conto di quanto sopra, del percorso di studi realizzato, degli interessi e delle attitudini dimostrate, delle competenze acquisite nei percorsi scolastici ed extrascolastici, si consiglia per la prosecuzione degli studi l'iscrizione al seguente percorso scolastico e formativo:";
$pdf->MultiCell(0,6,utf8_decode($commento),0,'J');

$pdf->Ln(3);
$pdf->SetX (10);
$pdf->SetFont('TitilliumWeb-SemiBold','',11);
if ($scuola1_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX(), $pdf->GetY()+0.6,5);
$pdf->SetX (10);
if ($scuola1_cor == 1) {$pdf->SetTextColor(0,0,0);} else {$pdf->SetTextColor(150,150,150);}
$pdf->Cell(190,6,"       ISTRUZIONE LICEALE", 1 ,1, 'L');
$pdf->SetFont('TitilliumWeb-Italic','',9);
$descScuola= "I percorsi liceali forniscono allo studente gli strumenti culturali e metodologici affinchè egli sia in grado di porsi, di fronte alle situazioni, ai fenomeni e ai problemi con atteggiamento razionale, creativo, progettuale e critico e possa acquisire conoscenze, abilità e competenze sia adeguate al proseguimento degli studi di ordine superiore e all'inserimento nella vita sociale e nel mondo del lavoro, sia coerenti con le capacità e le scelte personali.";

$pdf->MultiCell(0,$row,utf8_decode($descScuola),1,'J');
$pdf->SetFont('TitilliumWeb-SemiBold','',11);
$pdf->Cell(190,6,"Indirizzo: ".utf8_decode($tiposcuola1_cor),1,1,"L");

$pdf->Ln(3);
$pdf->SetFont('TitilliumWeb-SemiBold','',11);
if ($scuola2_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX(), $pdf->GetY()+0.6,5);
$pdf->SetX (10);
if ($scuola2_cor == 1) {$pdf->SetTextColor(0,0,0);} else {$pdf->SetTextColor(150,150,150);}
$pdf->Cell(190,6,"       ISTRUZIONE PROFESSIONALE", 1 ,1, 'L');
$pdf->SetFont('TitilliumWeb-Italic','',9);
$descScuola= "Il sistema dell'istruzione professionale ha la finalità di formare la studentessa e lo studente ad arti, mestieri e professioni strategici per l'economia del Paese per un saper fare di qualità comunemente denominato «Made in Italy», nonchè di garantire che le competenze acquisite nei percorsi di istruzione professionale consentano una facile transizione nel mondo del lavoro e delle professioni e il proseguimento degli studi di ordine superiore e di favorire, altresì, la transizione nel mondo del lavoro e delle professioni, anche con riferimento alle tecnologie previste dal Piano nazionale Industria 4.0.";

$pdf->MultiCell(0,$row,utf8_decode($descScuola),1,'J');
$pdf->SetFont('TitilliumWeb-SemiBold','',11);
$pdf->Cell(190,6,"Indirizzo: ".utf8_decode($tiposcuola2_cor),1,1,"L");


$pdf->Ln(3);
$pdf->SetFont('TitilliumWeb-SemiBold','',11);
if ($scuola3_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX(), $pdf->GetY()+0.6,5);
$pdf->SetX (10);
if ($scuola3_cor == 1) {$pdf->SetTextColor(0,0,0);} else {$pdf->SetTextColor(150,150,150);}
$pdf->Cell(190,6,"       ISTRUZIONE TECNICA", 1 ,1, 'L');
$pdf->SetFont('TitilliumWeb-Italic','',9);
$descScuola= "L'identità degli istituti tecnici si caratterizza per una solida base culturale di carattere scientifico, tecnologico e giuridico-economico in linea con le indicazioni dell'Unione europea, costruita attraverso lo studio, l’approfondimento e l’applicazione di linguaggi e metodologie di carattere generale e specifico. In connessione con il tessuto socio-economico-produttivo dei territori e in coerenza con i settori fondamentali per lo sviluppo economico e produttivo del Paese, con particolare riferimento all’innovazione digitale e alla valorizzazione del Made in Italy, l'identità degli istituti tecnici realizza l'obiettivo di far acquisire agli studenti, in relazione all'esercizio di professioni tecniche, competenze linguistiche, storiche, giuridico-economiche, matematiche, scientifico-tecnologiche, tecnico-professionali e trasversali finalizzate all'inserimento nel mondo del lavoro e delle professioni e all'accesso all'università e all'istruzione tecnologica superiore.";

$pdf->MultiCell(0,$row,utf8_decode($descScuola),1,'J');
$pdf->SetFont('TitilliumWeb-SemiBold','',11);
$pdf->Cell(190,6,"Indirizzo e Settore: ".utf8_decode($tiposcuola3_cor),1,1,"L");

$pdf->Ln(3);
$pdf->SetFont('TitilliumWeb-SemiBold','',11);
if ($scuola4_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX(), $pdf->GetY()+0.6,5);
$pdf->SetX (10);
if ($scuola4_cor == 1) {$pdf->SetTextColor(0,0,0);} else {$pdf->SetTextColor(150,150,150);}
$pdf->Cell(190,6,"       ISTRUZIONE E FORMAZIONE PROFESSIONALE REGIONALE", 1 ,1, 'L');
$pdf->SetFont('TitilliumWeb-Italic','',9);
$descScuola= "I percorsi di Istruzione e Formazione Professionale (IeFP) sono pensati per gli studenti che intendano acquisire una preparazione specifica per l'ingresso nel mondo del lavoro e consentono di affiancare, alle tradizionali conoscenze teoriche, una forte componente pratica attraverso lezioni svolte da esperti dei vari settori, attività laboratoriali e opportunità di tirocini in contesti lavorativi e aziendali. I percorsi IeFP permettono di ottenere una qualifica professionale immediatamente spendibile nel mercato del lavoro, che tuttavia non preclude la possibilità di proseguire il percorso di studi nella formazione professionale o nella scuola.";

$pdf->MultiCell(0,$row,utf8_decode($descScuola),1,'J');
$pdf->SetFont('TitilliumWeb-SemiBold','',11);
$pdf->Cell(190,6,"Settore: ".utf8_decode($tiposcuola4_cor),1,1,"L");





?>