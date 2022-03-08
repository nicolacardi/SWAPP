<?
require_once ('fpdf181/fpdf.php');              
require_once ('fpdf181/MC_TABLE.php');          //Estende fpdf
require_once ('fpdf181/MLT.php');               //Estende MC_TABLE
require_once ('fpdf181/Rotate.php');            //Estende MLT
require_once ('fpdf181/SetClassi.php');         //Estende Rotate: in SetClassi ci sono diverse classi Generiche ad esempio c'è WRITEHtml


include_once("database/databaseii.php");
include_once("assets/functions/functions.php");
include_once("assets/functions/ifloggedin.php");
include_once ('iscrizioni/diciture.php');


//Dopo aver caricato le varie classi che si estendono in catena creiamo la classe PDF che useremo: 
// nelle iscrizioni in questa classe inseriamo il footer e header che sono classi SPECIFICHE di questo file.
// TUTTE le altre sono nella catena.
class PDF extends PDF_SetClassiGeneriche {}

include_once("iscrizioni/settings_fpdf_Base.php");

$ID_pag = $_POST['ID_pag'];



include_once("04inc_GetCausaliPagamento.php");
//$causali_pagA = ["non rilevato", "retta", "iscrizione", "donazione", "spese didattiche", "quota associativa", "cauzione"];

$tipi_pagA = ["non rilevato", "bonifico", "contante", "carta di credito", "altro"];
$soggetto_pagA = ["non rilevato", "padre", "madre", "altro"];

$sql = "SELECT ID_pag, importo_pag, data_pag, causale_pag, tipo_pag, soggetto_pag, mese_ret, anno_ret, nome_alu, cognome_alu, nomepadre_fam, cognomepadre_fam, nomemadre_fam, cognomemadre_fam, nricevuta_pag, annoscolastico_pag, cfpadre_fam, cfmadre_fam, indirizzopadre_fam, indirizzomadre_fam, comunepadre_fam, comunemadre_fam, CAPpadre_fam, CAPmadre_fam, provpadre_fam, provmadre_fam, cf_alu, indirizzo_alu, citta_alu, CAP_alu, prov_alu
FROM tab_pagamenti
LEFT JOIN tab_mensilirette ON ID_ret = ID_ret_pag
LEFT JOIN tab_anagraficaalunni ON ID_alu =  ID_alu_pag
LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam 
WHERE ID_pag = ?";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt,  "i", $ID_pag);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $ID_pag, $importo_pag, $data_pag, $causale_pag, $tipo_pag, $soggetto_pag, $mese_ret, $anno_ret, $nome_alu, $cognome_alu, $nomepadre_fam, $cognomepadre_fam, $nomemadre_fam, $cognomemadre_fam, $nricevuta_pag, $annoscolastico_pag, $cfpadre_fam, $cfmadre_fam, $indirizzopadre_fam, $indirizzomadre_fam, $comunepadre_fam, $comunemadre_fam, $CAPpadre_fam, $CAPmadre_fam, $provpadre_fam, $provmadre_fam, $cf_alu, $indirizzo_alu, $citta_alu, $CAP_alu, $prov_alu );

while (mysqli_stmt_fetch($stmt)) {
}


//se nricevuta_pag = 0 allora vado a leggere il numero più alto presente nella tab_pagamenti e vado a fare l'update 
if ($nricevuta_pag == 0) { 
	$sql0 = "SELECT MAX(nricevuta_pag) as maxnricevuta
	FROM tab_pagamenti
	WHERE annoscolastico_pag = ?";
	$stmt0 = mysqli_prepare($mysqli, $sql0);
	mysqli_stmt_bind_param($stmt0,  "s", $annoscolastico_pag);
	mysqli_stmt_execute($stmt0);
	mysqli_stmt_bind_result($stmt0, $maxnricevuta);
	while (mysqli_stmt_fetch($stmt0)) {
	}

	$nricevutaToSet = $maxnricevuta + 1 ;
	$sql1 = "UPDATE tab_pagamenti
	SET nricevuta_pag = ?
	WHERE ID_pag = ?";
	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1,  "ii", $nricevutaToSet, $ID_pag);
	mysqli_stmt_execute($stmt1);

	$nricevuta_pag = $nricevutaToSet;

}





$pdf-> AddPage();


$width =  30;
$positionX= 210 - $width - 10;
$positionY =  5;
$pdf->Image('assets/img/logo/logo'.$_SESSION['codscuola'].'/logodefGrigioScuro.png',$positionX,$positionY, $width);

$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$pdf->SetXY (10,20);

$pdf->SetFont($fontdefault,'',10);
$pdf->Cell(190,6,utf8_decode($ragionesocialescuola), 0 ,1, 'L');
$pdf->Cell(190,6,utf8_decode($indirizzocompletoscuola), 0 ,1, 'L');
$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->SetY ($pdf->GetY()+5);
$pdf->Cell(95,6,"RICEVUTA DI PAGAMENTO # ".$nricevuta_pag. " del ".date("d/m/Y"), 0 ,0, 'L');

$pdf->SetFont($fontdefault,'',10);

$startXInd = 130;
$startYInd = 34;
$startXCau = 10;
$startYCau = 65;

$wInd = 60;
$wCau = 60;
$wImp = 60;
$wAlu = 70;

$pdf->SetXY ($startXInd, $startYInd);


//INDIRIZZO PAGANTE **********************************************************
switch ($soggetto_pag) {
    case 1:
        $pdf->Cell($wInd,6,$nomepadre_fam." ".$cognomepadre_fam, 0 ,1, 'L');
		$pdf->SetX($startXInd);
		$pdf->Cell($wInd,6,$indirizzopadre_fam, 0 ,1, 'L');
		$pdf->SetX($startXInd);
		$pdf->Cell($wInd,6,$CAPpadre_fam." ".$comunepadre_fam. "(".$provpadre_fam.")", 0 ,1, 'L');
		$pdf->SetX($startXInd);
		$pdf->Cell($wInd,6,"C.F.: ".$cfpadre_fam, 0 ,1, 'L');
    break;
    case 2:
        $pdf->Cell($wInd,6,$nomemadre_fam." ".$cognomemadre_fam, 0 ,1, 'L');
		$pdf->SetX($startXInd);
		$pdf->Cell($wInd,6,$indirizzomadre_fam, 0 ,1, 'L');
		$pdf->SetX($startXInd);
		$pdf->Cell($wInd,6,$CAPmadre_fam." ".$comunemadre_fam. "(".$provmadre_fam.")", 0 ,1, 'L');
		$pdf->SetX($startXInd);
		$pdf->Cell($wInd,6,"C.F.: ".$cfmadre_fam, 0 ,1, 'L');
    break;
	case 0:
        $pdf->Cell($wInd,6,$nome_alu." ".$cognome_alu, 0 ,1, 'L');
		$pdf->SetX($startXInd);
		$pdf->Cell($wInd,6,$indirizzo_alu, 0 ,1, 'L');
		$pdf->SetX($startXInd);
		$pdf->Cell($wInd,6,$CAP_alu." ".$citta_alu. "(".$prov_alu.")", 0 ,1, 'L');
		$pdf->SetX($startXInd);
		$pdf->Cell($wInd,6,"C.F.: ".$cf_alu, 0 ,1, 'L');
    break;
    default:
        $pdf->Cell($wInd,6,$soggetto_pagA[$soggetto_pag], 0 ,1, 'L');
}

$pdf->SetXY ($startXInd, $startYInd);
$pdf->Cell($WInd,24,"", 1 ,0, 'C');


//TABELLA PAGAMENTO **********************************************************
$pdf->SetXY ($startXCau, $startYCau);

$pdf->Cell($wCau,6,"CAUSALE", "B" ,0, 'C');
$pdf->Cell($wImp,6,"IMPORTO", "B" ,0, 'C');
$pdf->Cell($wAlu,6,"ALUNNO", "B" ,1, 'C');

if ($causale_pag == 1) {
    $pdf->Cell($wCau,6,$causali_pagA[$causale_pag]." del mese/anno: ".$mese_ret."/".$anno_ret, 0 ,0, 'C');
} else {
    $pdf->Cell($wCau,6,$causali_pagA[$causale_pag], 0 ,0, 'C');
}

$pdf->Cell($wImp,6,$importo_pag, 0 ,0, 'C');
$pdf->Cell($wAlu,6,$nome_alu. " ".$cognome_alu, 0 ,1, 'C');

$pdf->SetXY ($startXCau+$wCau+$wImp, $pdf->GetY());
$pdf->Cell($wAlu,6,"C.F.: ".$cf_alu, 0 ,1, 'C');

$pdf->SetY ($pdf->GetY());
$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$pdf->Cell($wCau,6,"TOTALE", "T" ,0, 'C');
$pdf->Cell($wImp,6,$importo_pag, "T" ,0, 'C');
$pdf->Cell($wAlu,6,"", "T" ,1, 'C');


//MARCA DA BOLLO **********************************************************
$pdf->SetXY ($startXCau+$wCau+$wImp,90);
$pdf->SetFont($fontdefault,'',8);
$pdf->Cell($wAlu,25,"Marca da bollo 2,00 euro", 1 ,0, 'C');


//DICITURE IN CALCE **********************************************************
$pdf->SetXY (10,120);
$pdf->SetFont($fontdefault,'',8);
$pdf->Cell(190,6,"Operazione esente da IVA a norma dell'art. 10 comma 20 del D.P.R. 633 del 26/10/1972 e succ. mod.", 0 ,1, 'C');
$pdf->Cell(190,6,"Da consegnare al socio pagante..", 1 ,0, 'C');


//RIGA TRATTEGGIO **********************************************************
$pdf->SetDrawColor(255,0,0);

$pdf->SetXY (10,130);
$pdf->SetDash(1,1); //5mm on, 5mm off;
$pdf->Cell(190,10,"" , "B" ,0, 'L');
$pdf->SetDash(); //Restore dash
$pdf->SetDrawColor(0,0,0);

$width =  8;
$positionX= 5;
$positionY =  134;

$pdf->Image('assets/img/Icone/scissors.png',$positionX,$positionY, $width);





//Timbro Firme e tratteggi per firme
// $indicetimbro = rand(1,9);
// $width =  20;
// $positionX= 135;
// $positionY = 130;

// $pdf->Image('assets/img/timbri/timbro'.$codscuola.'/timbro'.$indicetimbro.'.png', $positionX, $positionY, $width);

// $pdf->SetFont($fontdefault,'',12);
// $pdf->SetXY (15,$positionY);
// $pdf->Cell(60,10,"Luogo e Data", 0 ,0, 'C');
// $pdf->SetXY (135,$positionY);
// $pdf->Cell(60,10,"La segreteria", 0 ,1, 'C');

// $pdf->SetDash(1,1); //5mm on, 5mm off
// $pdf->SetXY (15,$positionY+10);
// $pdf->Cell(60,10,$li , "B" ,0, 'L');
// $pdf->SetXY (135,$positionY+10);
// $pdf->Cell(60,10,"", "B" ,0, 'C');
// $pdf->SetDash(); //Restore dash
// $pdf->SetTextColor(0,0,0);
// $pdf->SetDrawColor(0,0,0);



$offsetY = 140;
$width =  30;
$positionX= 210 - $width - 10;
$positionY =  5 + $offsetY;
$pdf->Image('assets/img/logo/logo'.$_SESSION['codscuola'].'/logodefGrigioScuro.png',$positionX,$positionY, $width);

$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$pdf->SetXY (10,20+$offsetY);

$pdf->SetFont($fontdefault,'',10);
$pdf->Cell(190,6,$ragionesocialescuola, 0 ,1, 'L');
$pdf->Cell(190,6,$indirizzocompletoscuola, 0 ,1, 'L');
$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->SetY ($pdf->GetY()+5);
$pdf->Cell(95,6,"RICEVUTA DI PAGAMENTO # ".$nricevuta_pag. " del ".date("d/m/Y"), 0 ,0, 'L');

$pdf->SetFont($fontdefault,'',10);

$startXInd = 130;
$startYInd = 34+$offsetY;
$startXCau = 10;
$startYCau = 65+$offsetY;

$wInd = 60;
$wCau = 60;
$wImp = 60;
$wAlu = 70;

$pdf->SetXY ($startXInd, $startYInd);


//INDIRIZZO PAGANTE **********************************************************
switch ($soggetto_pag) {
    case 1:
        $pdf->Cell($wInd,6,$nomepadre_fam." ".$cognomepadre_fam, 0 ,1, 'L');
		$pdf->SetX($startXInd);
		$pdf->Cell($wInd,6,$indirizzopadre_fam, 0 ,1, 'L');
		$pdf->SetX($startXInd);
		$pdf->Cell($wInd,6,$CAPpadre_fam." ".$comunepadre_fam. "(".$provpadre_fam.")", 0 ,1, 'L');
		$pdf->SetX($startXInd);
		$pdf->Cell($wInd,6,"C.F.: ".$cfpadre_fam, 0 ,1, 'L');
    break;
    case 2:
        $pdf->Cell($wInd,6,$nomemadre_fam." ".$cognomemadre_fam, 0 ,1, 'L');
		$pdf->SetX($startXInd);
		$pdf->Cell($wInd,6,$indirizzomadre_fam, 0 ,1, 'L');
		$pdf->SetX($startXInd);
		$pdf->Cell($wInd,6,$CAPmadre_fam." ".$comunemadre_fam. "(".$provmadre_fam.")", 0 ,1, 'L');
		$pdf->SetX($startXInd);
		$pdf->Cell($wInd,6,"C.F.: ".$cfmadre_fam, 0 ,1, 'L');
    break;
    case 0:
        $pdf->Cell($wInd,6,$nome_alu." ".$cognome_alu, 0 ,1, 'L');
		$pdf->SetX($startXInd);
		$pdf->Cell($wInd,6,$indirizzo_alu, 0 ,1, 'L');
		$pdf->SetX($startXInd);
		$pdf->Cell($wInd,6,$CAP_alu." ".$citta_alu. "(".$prov_alu.")", 0 ,1, 'L');
		$pdf->SetX($startXInd);
		$pdf->Cell($wInd,6,"C.F.: ".$cf_alu, 0 ,1, 'L');
    break;

    default:
        $pdf->Cell($wInd,6,$soggetto_pagA[$soggetto_pag], 0 ,1, 'L');
}

$pdf->SetXY ($startXInd, $startYInd);
$pdf->Cell($WInd,24,"", 1 ,0, 'C');

//TABELLA PAGAMENTO **********************************************************
$pdf->SetXY ($startXCau, $startYCau);



$pdf->Cell($wCau,6,"CAUSALE", "B" ,0, 'C');
$pdf->Cell($wImp,6,"IMPORTO", "B" ,0, 'C');
$pdf->Cell($wAlu,6,"ALUNNO", "B" ,1, 'C');

if ($causale_pag == 1) {
    $pdf->Cell($wCau,6,$causali_pagA[$causale_pag]." del mese/anno: ".$mese_ret."/".$anno_ret, 0 ,0, 'C');
} else {
    $pdf->Cell($wCau,6,$causali_pagA[$causale_pag], 0 ,0, 'C');
}

$pdf->Cell($wImp,6,$importo_pag, 0 ,0, 'C');
$pdf->Cell($wAlu,6,$nome_alu. " ".$cognome_alu, 0 ,1, 'C');

$pdf->SetXY ($startXCau+$wCau+$wImp, $pdf->GetY());
$pdf->Cell($wAlu,6,"C.F.: ".$cf_alu, 0 ,1, 'C');

$pdf->SetY ($pdf->GetY());
$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$pdf->Cell($wCau,6,"TOTALE", "T" ,0, 'C');
$pdf->Cell($wImp,6,$importo_pag, "T" ,0, 'C');
$pdf->Cell($wAlu,6,"", "T" ,1, 'C');


//MARCA DA BOLLO **********************************************************
//$pdf->SetXY ($startXCau+$wCau+$wImp,90+$offsetY);
$pdf->SetXY (10,90+$offsetY);
$pdf->SetFont($fontdefault,'',10);
//$pdf->Cell($wAlu,25,"Imposta di bollo assolta sull'originale", 1 ,0, 'C');
$pdf->Cell(190,25,"Imposta di bollo assolta sull'originale", 0 ,0, 'C');

//DICITURE IN CALCE **********************************************************
$pdf->SetXY (10,120+$offsetY);
$pdf->SetFont($fontdefault,'',8);
$pdf->Cell(190,6,"Operazione esente da IVA a norma dell'art. 10 comma 20 del D.P.R. 633 del 26/10/1972 e succ. mod.", 0 ,1, 'C');
$pdf->Cell(190,6,"Da trattenere presso la segreteria", 1 ,0, 'C');







$pdf->Output();
?>

