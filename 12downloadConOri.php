<?$metododescA=array("E18"=>"efficace e autonomo","K18"=>"autonomo","E20"=>"non ancora autonomo","K20"=>"non sempre produttivo","E22"=>"con buone competenze di manualità","E24"=>"creativo e capace di suggerire soluzioni proprie","E26"=>"collaborativo e capace di lavorare nel gruppo");

$interessedescA=array("E31"=>"costante","H31"=>"responsabile","K31"=>"settoriale","E33"=>"incostante","H33"=>"superficiale","K33"=>"scarso");
	
$sql = "SELECT metodo_cor, interesse_cor, data_cor, ";

for ($i = 1; $i<=11; ++$i) {
	$sql = $sql."area".$i."_cor, ";
}
for ($i = 1; $i<=4; ++$i) {
	$sql = $sql."scuola".$i."_cor, ";
}
for ($i = 1; $i<=4; ++$i) {
	$sql = $sql."tiposcuola".$i."_cor, ";
}

$sql = $sql ." attitudini_cor, nome_alu, cognome_alu FROM tab_consorientativo LEFT JOIN tab_anagraficaalunni ON ID_alu_cor = ID_alu ".
"WHERE ID_alu_cor = ? AND annoscolastico_cor = ?";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "is", $ID_alu_cla, $annoscolastico_cla);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $metodo_cor, $interesse_cor, $data_cor, $area1_cor, $area2_cor, $area3_cor, $area4_cor, $area5_cor, $area6_cor, $area7_cor, $area8_cor, $area9_cor, $area10_cor, $area11_cor, $scuola1_cor, $scuola2_cor, $scuola3_cor, $scuola4_cor, $tiposcuola1_cor, $tiposcuola2_cor, $tiposcuola3_cor, $tiposcuola4_cor, $attitudini_cor, $nome_alu, $cognome_alu);
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
$pdf->SetFont($fontdefault,'',16);
$pdf->SetTextColor(220,29,36);
$pdf->SetXY (0,100);
$pdf->Cell(210,10,utf8_decode("Consiglio Orientativo"), 0,1, 'C');
$pdf->Cell(0,10,$nome_alu." ".$cognome_alu, 0,1, 'C');
$pdf->Cell(0,10,"Anno scolastico: ".$annoscolastico_cla, 0,1, 'C');


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

$pdf->SetFont($fontdefault,'',16);
$pdf->Cell(0,8,utf8_decode("Consiglio di orientamento per il futuro percorso di studi"), 0 ,1, 'C');
$pdf->SetFont($fontdefault,'',12);

$pdf->Cell(0,10,utf8_decode("Alunno/a: ".$nome_alu." ".$cognome_alu." - Anno scolastico: ".$annoscolastico_cla." - Classe Terza / Sez.A"), 0,1, 'C');
$pdf->Cell(0,6,utf8_decode("Il Consiglio di Classe nell'ambito delle attività di orientamento, al fine di aiutare"), 0,1, 'C');
$pdf->Cell(0,6,utf8_decode("l'alunno/a nella scelta scolastica successiva, comunica quanto segue:"), 0,1, 'C');

//******************************************************************************
$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$pdf->Ln(5);
$pdf->Cell(0,8,utf8_decode("L'alunno/a mostra un metodo di lavoro *:"), 0,1, 'C');
$pdf->SetFont($fontdefault,'',12);

$metododescA=array("1"=>"efficace e autonomo","2"=>"autonomo","3"=>"non ancora autonomo","4"=>"non sempre produttivo","5"=>"con buone competenze di manualità","6"=>"creativo e capace di suggerire soluzioni proprie","7"=>"collaborativo e capace di lavorare nel gruppo");
	
$interessedescA=array("1"=>"costante","2"=>"responsabile","3"=>"settoriale","4"=>"incostante","5"=>"superficiale","6"=>"scarso");

$opzioneMetodo = array_search($metodo_cor, $metododescA);

$opzioneInteresse = array_search($interesse_cor, $interessedescA);

$imgsquare = 'assets/img/square.png';
$imgsquarecrossed = 'assets/img/squarecrossed.png';

if ($opzioneMetodo == "1") {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+25, $pdf->GetY()+1,5);
$pdf->SetX (40);
$pdf->Cell(60,7,"Efficace ed autonomo",0,0,"L");

if ($opzioneMetodo == "2") {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+25, $pdf->GetY()+1,5);
$pdf->SetX (130);
$pdf->Cell(95,7,"Autonomo",0,1,"L");

if ($opzioneMetodo == "3") {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+25, $pdf->GetY()+1,5);
$pdf->SetX (40);
$pdf->Cell(60,7,"Non ancora autonomo",0,0,"L");

if ($opzioneMetodo == "4") {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+25, $pdf->GetY()+1,5);
$pdf->SetX (130);
$pdf->Cell(95,7,"Non sempre produttivo",0,1,"L");

if ($opzioneMetodo == "5") {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+25, $pdf->GetY()+1,5);
$pdf->SetX (40);
$pdf->Cell(60,7,utf8_decode("Con buone competenze di manualità"),0,1,"L");

if ($opzioneMetodo == "6") {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+25, $pdf->GetY()+1,5);
$pdf->SetX (40);
$pdf->Cell(60,7,utf8_decode("Creativo e capace di suggerire soluzioni proprie"),0,1,"L");

if ($opzioneMetodo == "7") {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+25, $pdf->GetY()+1,5);
$pdf->SetX (40);
$pdf->Cell(60,7,utf8_decode("Collaborativo e capace di lavorare nel gruppo"),0,1,"L");

//******************************************************************************

$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$pdf->Ln(5);
$pdf->Cell(0,8,utf8_decode("L'alunno/a ha mostrato interesse e impegno nelle attività scolastiche in modo *:"), 0,1, 'C');
$pdf->SetFont($fontdefault,'',12);

if ($opzioneInteresse == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+25, $pdf->GetY()+1,5);
$pdf->SetX (40);
$pdf->Cell(30,7,"Costante",0,0,"L");

if ($opzioneInteresse == 2) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
$pdf->SetX (95);
$pdf->Cell(30,7,"Responsabile",0,0,"L");

if ($opzioneInteresse == 3) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
$pdf->SetX (150);
$pdf->Cell(95,7,"Settoriale",0,1,"L");

if ($opzioneInteresse == 4) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+25, $pdf->GetY()+1,5);
$pdf->SetX (40);
$pdf->Cell(30,7,"Incostante",0,0,"L");

if ($opzioneInteresse == 5) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
$pdf->SetX (95);
$pdf->Cell(30,7,"Superficiale",0,0,"L");

if ($opzioneInteresse == 6) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
$pdf->SetX (150);
$pdf->Cell(95,7,"Scarso",0,1,"L");

//***************************************************************
$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$pdf->Ln(5);
$pdf->Cell(0,8,utf8_decode("L'alunno/a ha mostrato preferenze nelle seguenti aree di apprendimento **:"), 0,1, 'C');
$pdf->SetFont($fontdefault,'',12);

if ($area1_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+25, $pdf->GetY()+1,5);
$pdf->SetX (40);
$pdf->Cell(30,7,"Artistico",0,0,"L");

if ($area2_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
$pdf->SetX (95);
$pdf->Cell(30,7,"Tecnico",0,0,"L");

if ($area3_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
$pdf->SetX (150);
$pdf->Cell(95,7,"Scientifico",0,1,"L");

if ($area4_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+25, $pdf->GetY()+1,5);
$pdf->SetX (40);
$pdf->Cell(30,7,"Sociale",0,0,"L");

if ($area5_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
$pdf->SetX (95);
$pdf->Cell(30,7,"Agro-Ambientale",0,0,"L");

if ($area6_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
$pdf->SetX (150);
$pdf->Cell(95,7,"Educativo",0,1,"L");

if ($area7_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+25, $pdf->GetY()+1,5);
$pdf->SetX (40);
$pdf->Cell(30,7,"Economico",0,0,"L");

if ($area8_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
$pdf->SetX (95);
$pdf->Cell(30,7,"Artigianale",0,0,"L");

if ($area9_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
$pdf->SetX (150);
$pdf->Cell(95,7,"Umanistico",0,1,"L");

if ($area10_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+25, $pdf->GetY()+1,5);
$pdf->SetX (40);
$pdf->Cell(30,7,"Linguistico",0,0,"L");

if ($area11_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
$pdf->SetX (95);
$pdf->Cell(30,7,"Musicale",0,0,"L");
//*********************************************

$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$pdf->Ln(5);
$pdf->Cell(0,8,utf8_decode("L'alunno ha mostrato specifiche attitudini, ottenendo prestazioni"), 0,1, 'C');
$pdf->Cell(0,8,utf8_decode(" particolarmente positive, nelle aree disciplinari:"), 0,1, 'C');
$pdf->SetFont($fontdefault,'',12);

//$pdf->Cell(0,7,$attitudini_cor,1,0,"C");
$pdf->MultiCell(0,11,utf8_decode($attitudini_cor), 1, "C");


//*********************************************
$pdf->SetFont($fontdefault,'',12);
$pdf->Ln(5);
$pdf->Cell(0,6,utf8_decode("In base a quanto sopra evidenziato, al percorso formativo compiuto dall'alunno/a"), 0,1, 'C');
$pdf->Cell(0,6,utf8_decode("al rendimento scolastico globale ed alle competenze evidenziate nell'arco del triennio"), 0,1, 'C');
$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$pdf->Cell(0,8,utf8_decode("il Consiglio di Classe formula il seguente consiglio orientativo **:"), 0,1, 'C');
$pdf->SetFont($fontdefault,'',12);

$pdf->SetX (35);
$pdf->Cell(50,7,"",0,0,"L");
$pdf->Cell(90,7,"Tipologia",0,1,"C");


if ($scuola1_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
$pdf->SetX (35);
$pdf->Cell(50,7,"un Liceo",0,0,"L");
$pdf->Cell(90,7,$tiposcuola1_cor,1,1,"L");

if ($scuola2_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
$pdf->SetX (35);
$pdf->Cell(50,7,"un Ist. Professionale",0,0,"L");
$pdf->Cell(90,7,$tiposcuola2_cor,1,1,"L");

if ($scuola3_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
$pdf->SetX (35);
$pdf->Cell(50,7,"un Ist. Tecnico",0,0,"L");
$pdf->Cell(90,7,$tiposcuola3_cor,1,1,"L");

if ($scuola4_cor == 1) {$img = $imgsquarecrossed;} else {$img = $imgsquare;}
$pdf->Image($img,$pdf->GetX()+20, $pdf->GetY()+1,5);
$pdf->SetX (35);
$pdf->Cell(50,7,"Istr. e Form. professionale",0,0,"L");
$pdf->Cell(90,7,$tiposcuola4_cor,1,1,"L");


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
 //FINE PAGINA CONS ORIENTATIVO************************************************************************************************************************************

?>