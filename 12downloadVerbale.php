<?
require_once ('fpdf181/fpdf.php');              
require_once ('fpdf181/MC_TABLE.php');          //Estende fpdf
require_once ('fpdf181/MLT.php');               //Estende MC_TABLE
require_once ('fpdf181/Rotate.php');            //Estende MLT
require_once ('fpdf181/SetClassi.php');         //Estende Rotate: in SetClassi ci sono diverse classi Generiche ad esempio c'è WRITEHtml

include_once("database/databaseii.php");
include_once("assets/functions/functions.php");
include_once("assets/functions/ifloggedin.php");

class PDF extends PDF_SetClassiGeneriche {}

include_once("iscrizioni/settings_fpdf_Base.php");


$codscuola = $_SESSION['codscuola'];
$num_ver = $_POST['num_ver'];



//anzitutto estraggo le informazioni generali, che sono (errore di progettazione) ripetute in tutti i record che afferiscono allo stesso verbale
//queste sono informazioni di testata che consentono di scrivere i titoli in ogni pagina

$sql = "SELECT ID_ver, num_ver, tipo_ver, numtipo_ver, data_ver, ora_ver, iddocenti_ver, idalunni_ver, invitatiult_ver, titolo_ver, annoscolastico_ver, classe_ver, aselme_cls FROM tab_verbali LEFT JOIN tab_classi ON classe_ver =  classe_cls WHERE num_ver = ".$num_ver.";";
//QUERY PARAMETRICA DA FARE
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
mysqli_stmt_bind_result($stmt, $ID_ver, $num_ver, $tipo_ver, $numtipo_ver, $data_ver, $ora_ver, $iddocenti_ver, $idalunni_ver, $invitatiult_ver, $titolo_ver, $annoscolastico_ver, $classe_ver, $aselme_cls );
while (mysqli_stmt_fetch($stmt)) {
}

switch ($tipo_ver) {
case 1:
	$titoloToWrite =  "CONSIGLIO DI CLASSE n.".$numtipo_ver;
	break;
case 2:
	$titoloToWrite =  "RIUNIONE CON I GENITORI n.".$numtipo_ver;
	break;
case 3:
	$titoloToWrite =  "INCONTRO DEL COLLEGIO DOCENTI n.".$numtipo_ver;
	break;
case 4:
	$titoloToWrite =  "CONSIGLIO DI CLASSE VALUTATIVO n.".$numtipo_ver;
	break;
default:        
}




//FRONTESPIZIO************************************************************************************************************************************
$pdf->AddPage();
//Rettangolo grande


$pdf->SetDrawColor(0,55,135);
$pdf->Rect(10,10,190,275);
//Rettangolo grande interno tratteggiato
$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->Rect(12,12,186,271);
$pdf->SetDash(); //5mm on, 5mm off
//Logo
$width =  75;
$positionX= 210 / 2 - ($width/2);
$positionY =  25;
$pdf->Image('assets/img/logo/logo'.$codscuola.'/logodefBlu.png',$positionX,$positionY, $width);
//Titoli
$pdf->SetFont('TitilliumWeb-SemiBold','',16);
$pdf->SetTextColor(0,55,135);
$pdf->SetXY (0,100);
$pdf->Cell(210,10,utf8_decode("Verbale di riunione"), 0,1, 'C');
$pdf->SetFont($fontdefault,'',12);
//$pdf->Cell(0,10,utf8_decode($desc_cls. " - Sez. ".$sezione_ora), 0,1, 'C');
$pdf->Cell(0,10,"Anno scolastico: ".$annoscolastico_ver, 0,1, 'C');
$pdf->SetFont($fontdefault,'',14);
$pdf->Cell(0,10,"Classe: ".$classe_ver, 0,1, 'C');
$pdf->Cell(190,10,$titoloToWrite, 0 ,1, 'C');



$pdf->Ln(10);

//Timbro Firme e tratteggi per firme
$indicetimbro = rand(1,9);
$pdf->Image('assets/img/timbri/timbro'.$codscuola.'/timbro'.$indicetimbro.'.png', 135, 250, 20);
$pdf->SetFont($fontdefault,'',12);
//$pdf->SetXY (15,250);
//$pdf->Cell(60,10,"Luogo e Data", 0 ,0, 'C');
$pdf->SetXY (135,250);
$pdf->Cell(60,10,"Il Coordinatore Didattico", 0 ,1, 'C');
$indicefirma = rand(1,15);
$pdf->Image('assets/img/firmecoordinatori/firme'.$codscuola.'/CoordDidattico'.$aselme_cls.$indicefirma.'.png', 135, 255, 60);

$pdf->SetDash(1,1); //5mm on, 5mm off
//$pdf->SetXY (15,260);
//$pdf->Cell(60,10,"Padova,", "B" ,0, 'L');
$pdf->SetXY (135,260);
$pdf->Cell(60,10,"", "B" ,0, 'C');
$pdf->SetDash(); //Restore dash
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(0,0,0);
 //FINE FRONTESPIZIO************************************************************************************************************************************

$pdf->AddPage();
$pdf->SetFont('TitilliumWeb-SemiBold','',14);
$pdf->SetXY(10,10);
$pdf->Cell(190,10,$titoloToWrite, 0 ,1, 'C');

$pdf->SetFont($fontdefault,'',9);
//$text = "Vengono riportati, in sintesi, gli aspetti più significativi degli argomenti trattati nel corso degli incontri periodici dei docenti contitolari di classe. In particolare vengono annotate le decisioni assunte in ordine alla regolazione della pianificazione \ndell'attività educativa nelle sue varie articolazioni, compresa la verifica del funzionamento delle classi.";
//$txt=$pdf->MultiCell(190,4,utf8_decode($text),1,'C',0,5);
$pdf->SetFont('TitilliumWeb-SemiBold','',14);
$pdf->Cell(190,12,"Classe: ".$classe_ver, 1 ,1, 'C');
//$pdf->Cell(190,12,"Titolo dell'incontro: ".$titolo_ver, 1 ,1, 'C');
$pdf->SetFont($fontdefault,'',10);
$pdf->Cell(190,8,"Data dell'incontro: ".(timestamp_to_ggmmaaaa($data_ver)."  - Ora dell'incontro: ".date( 'G:i', strtotime($ora_ver) )), 1 ,1, 'C');

if ($iddocenti_ver == "") { $nummaestri = 0; $elencomaestri = " nessuno";} else{
	$iddocenti_ver = str_replace(' ', '', $iddocenti_ver);
	$idmaestri_verA = explode(',',$iddocenti_ver);
	$nummaestri = count($idmaestri_verA);
	$elencomaestri = "";
	for ($nummaestro = 0; $nummaestro < $nummaestri; $nummaestro++) {
		$idmaestro =  intval($idmaestri_verA[$nummaestro]);
        $sql = "SELECT nome_mae, cognome_mae FROM tab_anagraficamaestri WHERE id_mae = ".$idmaestro.";";
        //QUERY PARAMETRICA DA FARE
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		mysqli_stmt_bind_result($stmt, $nome_mae, $cognome_mae);
		while (mysqli_stmt_fetch($stmt)) {
		}
		$elencomaestri = $elencomaestri.", ".$nome_mae." ".$cognome_mae;
	}
	$elencomaestri = substr($elencomaestri, 1);
}
$pdf->SetFont('TitilliumWeb-SemiBold','',11);
$pdf->Cell(190,6,"Docenti presenti: (".$nummaestri.")", "LTR" ,1, 'C');
$pdf->SetFont($fontdefault,'',9);
$txt=$pdf->MultiCell(190,6,utf8_decode($elencomaestri),"LBR",'C',0,5);

if ($idalunni_ver == "") { $numalunni = 0; $elencoalunni = " nessuno";} else{
	$idalunni_ver = str_replace(' ', '', $idalunni_ver);
	$idalunni_verA = explode(',',$idalunni_ver);
	$numalunni = count($idalunni_verA);
	$elencoalunni = " ";
	for ($numalunno = 0; $numalunno < $numalunni; $numalunno++) {
		$idalunno =  intval($idalunni_verA[$numalunno]);
		$sql = "SELECT nome_alu, cognome_alu FROM tab_anagraficaalunni WHERE id_alu = ".$idalunno.";";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		mysqli_stmt_bind_result($stmt, $nome_alu, $cognome_alu);
		while (mysqli_stmt_fetch($stmt)) {
		}
		$elencoalunni = $elencoalunni.", ".$nome_alu." ".$cognome_alu;
	}
	$elencoalunni = substr($elencoalunni, 1);
}

$pdf->SetFont('TitilliumWeb-SemiBold','',11);
if ($tipo_ver == 2) {
    $pdf->Cell(190,6,"Alunni i cui genitori erano presenti: (".$numalunni.")", "LTR" ,1, 'C');
    $pdf->SetFont($fontdefault,'',9); 
    $txt=$pdf->MultiCell(190,6,utf8_decode($elencoalunni),"LBR",'C',0,5);
}

if ($invitatiult_ver != "") {
	$pdf->SetFont('TitilliumWeb-SemiBold','',11);
	$pdf->Cell(190,6,"Ulteriori Invitati:", "LTR" ,1, 'C');
	$pdf->SetFont($fontdefault,'',9); 
	$txt=$pdf->MultiCell(190,6,utf8_decode($invitatiult_ver),"LBR",'C',0,5);
}
$pdf-> Ln(5);


$pdf-> Ln(5);
// $pdf->SetFont('TitilliumWeb-SemiBold','',11);
// $w1 = 55; //larghezza colonna1
// $w2 = 80; //larghezza colonna2
// $w3 = 55; //larghezza colonna3
// $h1 = 4; //altezza riga dentro le Multicell
// $lmaxpossibili = 29;
// $pdf->Cell($w1,6,"ARGOMENTO TRATTATO", 1 ,0, 'C');
// $pdf->Cell($w2,6,"TEMATICHE AFFRONTATE", 1 ,0, 'C');
// $pdf->Cell($w3,6,"DECISIONI ASSUNTE", 1 ,1, 'C');

$pdf->SetFont($fontdefault,'',10);
//successivamente estraggo le informazioni che invece cambiano e record per record vado a scriverle
$sql = "SELECT argnum_ver, argomento_ver, tematiche_ver, decisioni_ver FROM tab_verbali WHERE num_ver = ".$num_ver.";";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
mysqli_stmt_bind_result($stmt, $argnum_ver, $argomento_ver, $tematiche_ver, $decisioni_ver);


// $pdf->tablewidths = array($w1, $w2, $w3);			  
// while (mysqli_stmt_fetch($stmt)) {	
// 	$data[] = array(utf8_decode($argomento_ver), utf8_decode($tematiche_ver), utf8_decode($decisioni_ver));
// }
		  
while (mysqli_stmt_fetch($stmt)) {	
	$pdf->SetFont('TitilliumWeb-SemiBold','',11);

	$pdf->SetFillColor(160,160,160);
	$pdf->SetTextColor(255,255,255);

	$pdf->Cell(190,6,"ARGOMENTO TRATTATO", 1 ,1, 'C', true);
	$pdf->SetTextColor(0,0,0);
	//$pdf->SetFont($fontdefault,'',11);
	$txt=$pdf->MultiCell(190,6,utf8_decode(stripslashes($argomento_ver)),"LBR",'C',0,5);

	$pdf->SetFont('TitilliumWeb-SemiBold','',11);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(190,6,"TEMATICHE AFFRONTATE", 1 ,1, 'C', true);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont($fontdefault,'',10);
	$txt=$pdf->MultiCell(190,5,utf8_decode(stripslashes($tematiche_ver)),"LBR",'J',0,5);

	if ($decisioni_ver != '') {
		$pdf->SetFont('TitilliumWeb-SemiBold','',11);
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(190,6,"DECISIONI ASSUNTE", 1 ,1, 'C', true);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont($fontdefault,'',10);
		$txt=$pdf->MultiCell(190,5,utf8_decode(stripslashes($decisioni_ver)),"LBR",'J',0,5);
	}

	$txt=$pdf->MultiCell(190,6,"",0,'C',0,5);
}

if ($tipo_ver == 4) {
	include_once ('12inc_SinotticoPagelle.php');
}

//$pdf->morepagestable($data);


$pdf->Output();?>