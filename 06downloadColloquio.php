<?
require_once ('fpdf181/fpdf.php');              
require_once ('fpdf181/MC_TABLE.php');          //Estende fpdf
require_once ('fpdf181/MLT.php');               //Estende MC_TABLE
require_once ('fpdf181/Rotate.php');            //Estende MLT
require_once ('fpdf181/SetClassi.php');         //Estende Rotate: in SetClassi ci sono diverse classi Generiche ad esempio c'è WRITEHtml

include_once("database/databaseii.php");
include_once("assets/functions/functions.php");
include_once("assets/functions/ifloggedin.php");

class PDF extends PDF_SetClassiGeneriche {


	// Page footer
	function Footer()
	{
		include("iscrizioni/diciture.php");
		$this->SetFont('TitilliumWeb-ExtraLight','',9);
        $this->Line(10, 244, 200, 244);

		$this->SetY(-50);
        $this->Cell(90,4,utf8_decode("Firme dei rappresentanti della scuola"),0,0,'C');
        $this->SetX(110);
        $this->Cell(90,4,utf8_decode("Firme dei genitori presenti"),0,1,'C');
        $this->Rect(10,245,90,30);
        $this->Rect(110,245,90,30);
        $this->SetY(-20);
		//Piè di pagina
		$this->SetTextColor(100,100,100);
		$this->Cell(0,4,utf8_decode($nomescuola),0,1,'L');
		$this->SetFont('TitilliumWeb-ExtraLight','',8);
		$this->Cell(0,4,utf8_decode($ragionesocialescuola),0,1,'L');
		$this->Cell(0,4,utf8_decode($indirizzocompletoscuola),0,1,'L');
		$this->Cell(0,4,utf8_decode($datiscuola),0,0,'L');
		// Page number		
		$this->Cell(0,10,'Pagina '.$this->PageNo().' di {nb}',0,0,'C');

	}


}

include_once("iscrizioni/settings_fpdf_Base.php");
include_once("iscrizioni/diciture.php");

$codscuola = $_SESSION['codscuola'];
$num_ver = $_POST['num_ver'];
$ID_clq =  $_POST['ID_clq'];

//FRONTESPIZIO************************************************************************************************************************************
$pdf->AddPage();
//Rettangolo grande
$pdf->SetDrawColor(0,55,135);

$pdf->SetAutoPageBreak(true,50);



$width =  25;
$positionX= 170;
$positionY =  10;
$pdf->Image('assets/img/logo/logo'.$codscuola.'/logodefBlu.png',$positionX,$positionY, $width);
$pdf->SetFont('TitilliumWeb-SemiBold','',16);




$sql = "SELECT data_clq, incontrocon_clq, note_clq, ckpadre_clq, ckmadre_clq, richiestoda_clq, tipo_clq, cognome_fam, nomemadre_fam, cognomemadre_fam, nomepadre_fam, cognomepadre_fam FROM tab_colloquifam LEFT JOIN tab_famiglie ON ID_fam_clq =  ID_fam WHERE ID_clq= ?;";
//QUERY PARAMETRICA DA FARE
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "i", $ID_clq);
mysqli_stmt_execute($stmt);
//mysqli_stmt_store_result($stmt);
mysqli_stmt_bind_result($stmt, $data_clq, $incontrocon_clq, $note_clq, $ckpadre_clq, $ckmadre_clq, $richiestoda_clq, $tipo_clq, $cognome_fam, $nomemadre_fam, $cognomemadre_fam, $nomepadre_fam, $cognomepadre_fam );

while (mysqli_stmt_fetch($stmt)) {

}


$pdf->SetXY (10,30);
$pdf->Cell(190,10,"Verbale di Colloquio con la famiglia ".$cognome_fam, 0,1, 'C');
$pdf->SetFont($fontdefault,'',13);
$pdf->Cell(190,10,"Presso la ".$nomescuola, 0,1, 'C');
$pdf->SetFont($fontdefault,'',10);
$pdf->SetX (15);
if($richiestoda_clq == 1) { $richiestoda = "Scuola";} else {$richiestoda = "Famiglia";}

$pdf->Cell(60,10,"Colloquio richiesto dalla ".$richiestoda, "T",0, 'C');
$pdf->Cell(60,10,"Data: ".timestamp_to_ggmmaaaa($data_clq), "T",0, 'C');

switch ($tipo_clq) {
    case 1:
        $tipo = "Pedagogico";
        break;
    case 2:
        $tipo = "Amministrativo";
        break;
    case 3:
        $tipo = "Medico";
        break;
    case 0:
        $tipo = "Altro";
        break;
}
$pdf->Cell(60,10,"Tipo Colloquio: ".$tipo, "T",1, 'C');




if ($incontrocon_clq == "") {
     $nummaestri = 0; $elencomaestri = " nessuno";
} else{
	$incontrocon_clq = str_replace(' ', '', $incontrocon_clq);
	$idmaestri_verA = explode(',',$incontrocon_clq);
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
$pdf->Cell(190,6,"Per la scuola presenti: (".$nummaestri.")", "LTR" ,1, 'C');
$pdf->SetFont($fontdefault,'',12);
$txt=$pdf->MultiCell(190,6,utf8_decode($elencomaestri),"LBR",'C',0,5);

$pdf->SetFont('TitilliumWeb-SemiBold','',11);
if ($ckpadre_clq == 1) { $padremadre = "    padre: ".$nomepadre_fam." ".$cognomepadre_fam; $numgenitori = 1;}
if ($ckmadre_clq == 1) { $padremadre = $padremadre."    madre: ".$nomemadre_fam." ".$cognomemadre_fam; $numgenitori = $numgenitori +1;}

$pdf->SetXY (10,$pdf->GetY() +8);

$pdf->Cell(190,6,"Per la famiglia presenti: (".$numgenitori.")", "LTR" ,1, 'C');
$pdf->SetFont($fontdefault,'',12);
$txt=$pdf->MultiCell(190,6,utf8_decode($padremadre),"LBR",'C',0,5);

$pdf->SetXY (10,$pdf->GetY() +8);

if (strlen($note_clq) > 2500) {
    $note_clq1= substr($string,0,2500);
}
//$pdf->Rect(10,100,190,150);
$txt=$pdf->MultiCell(190,6,utf8_decode($note_clq),1,'J',0,5);
$y = $pdf->GetY();


$pdf->Output();?>