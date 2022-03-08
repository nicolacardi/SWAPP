<?
require_once ('fpdf181/fpdf.php');              
require_once ('fpdf181/MC_TABLE.php');          //Estende fpdf
require_once ('fpdf181/MLT.php');               //Estende MC_TABLE
require_once ('fpdf181/Rotate.php');            //Estende MLT
require_once ('fpdf181/SetClassi.php');         //Estende Rotate: in SetClassi ci sono diverse classi Generiche ad esempio c'è WRITEHtml


include_once("database/databaseii.php");
include_once("assets/functions/functions.php");
include_once("assets/functions/ifloggedin.php");


//Dopo aver caricato le varie classi che si estendono in catena creiamo la classe PDF che useremo: 
// nelle iscrizioni in questa classe inseriamo il footer e header che sono classi SPECIFICHE di questo file.
// TUTTE le altre sono nella catena.
class PDF extends PDF_SetClassiGeneriche {}

include_once("iscrizioni/settings_fpdf_Base.php");


$annoscolastico_ret = $_POST['annoscolastico'];
$ID_fam = $_POST['ID_fam'];

//FRONTESPIZIO************************************************************************************************************************************
$pdf->AddPage('L');
//Logo
$width =  30;
$positionX= 297 - $width - 10;
$positionY =  5;

$pdf->Image('assets/img/logo/logo'.$_SESSION['codscuola'].'/logodefGrigioScuro.png',$positionX,$positionY, $width);
//Titoli
$pdf->SetTextColor(0,0,0);
$pdf->SetXY (0,10);
$pdf->SetFont($fontdefault,'',8);

// $sql3 = "SELECT DISTINCT ID_alu_ret, nome_alu, cognome_alu, annoscolastico_ret, classe_cla, sezione_cla, mese_ret, default_ret, concordato_ret, pagato_ret, datapagato_ret, pagato_pga, datapagato_pga, ord_mese, ord_cls, cognomepadre_fam, cognomemadre_fam FROM
// ((((tab_mensilirette LEFT JOIN tab_anagraficaalunni ON ID_alu = ID_alu_ret) 
// LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla AND annoscolastico_ret = annoscolastico_cla )
// LEFT JOIN tab_pagamentialtri ON ID_alu = ID_alu_pga AND annoscolastico_pga = annoscolastico_cla)
// LEFT JOIN tab_classi ON classe_cla = classe_cls)
// LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam
// WHERE annoscolastico_ret = ? AND ID_fam_alu = ? ORDER BY ID_alu_ret, annoscolastico_ret ASC, ord_mese ;";

// $sql3 = "SELECT ID_alu_ret, nome_alu, cognome_alu, annoscolastico_ret, classe_cla, sezione_cla, mese_ret, default_ret, concordato_ret, pagato_ret, pagato_pga, ord_mese, ord_cls, cognomepadre_fam, cognomemadre_fam, commento_com FROM
// tab_mensilirette LEFT JOIN tab_anagraficaalunni ON ID_alu = ID_alu_ret
// LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla AND annoscolastico_ret = annoscolastico_cla 
// LEFT JOIN tab_pagamentialtri ON ID_alu = ID_alu_pga AND annoscolastico_pga = annoscolastico_cla
// LEFT JOIN tab_classi ON classe_cla = classe_cls
// LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam
// LEFT JOIN tab_compensazionifamiglie ON ID_fam = ID_fam_com AND annoscolastico_com = ? 
// WHERE annoscolastico_ret = ? AND ID_fam_alu = ? ORDER BY ID_alu_ret, annoscolastico_ret ASC, ord_mese ;";


$sql3 = "SELECT ID_alu_ret, nome_alu, cognome_alu, annoscolastico_ret, classe_cla, sezione_cla, mese_ret, default_ret, concordato_ret, pagato_ret, TotPagato, ord_mese, ord_cls, cognomepadre_fam, cognomemadre_fam, commento_com FROM
tab_mensilirette LEFT JOIN tab_anagraficaalunni ON ID_alu = ID_alu_ret
LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla AND annoscolastico_ret = annoscolastico_cla 
LEFT JOIN (SELECT ID_alu_pag, annoscolastico_pag , SUM(importo_pag) as TotPagato FROM tab_pagamenti WHERE causale_pag <> 1 GROUP BY ID_alu_pag, annoscolastico_pag) AS altripag ON altripag.ID_alu_pag = ID_alu AND altripag.annoscolastico_pag = annoscolastico_ret
LEFT JOIN tab_classi ON classe_cla = classe_cls
LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam
LEFT JOIN tab_compensazionifamiglie ON ID_fam = ID_fam_com AND annoscolastico_com = ? 
WHERE annoscolastico_ret = ? AND ID_fam_alu = ? ORDER BY ID_alu_ret, annoscolastico_ret ASC, ord_mese ;";


$stmt3 = mysqli_prepare($mysqli, $sql3);
mysqli_stmt_bind_param($stmt3, "ssi", $annoscolastico_ret, $annoscolastico_ret, $ID_fam );
mysqli_stmt_execute($stmt3);
mysqli_stmt_bind_result($stmt3, $ID_alu_ret, $nome_alu, $cognome_alu, $annoscolastico_ret, $classe_cla, $sezione_cla, $mese_ret, $default_ret, $concordato_ret, $pagato_ret, $pagato_pga, $ord_mese, $ord_cls, $cognomepadre_fam, $cognomemadre_fam, $commento_com);
$riga = 0;//riga equivale al numero del record che si sta guardando della tabella rette
$j = 0; //j è un numero che cresce di una unità ogni volta che scrivo un alunno.
$wstart = 10;
$hstartTit = 35;
$hstart = 45;
$hgap = 20; //distanza tra un alunno e il successivo in altezza
$wnome = 25;
$wcognome = 25;
$wclasse = 10;
$wsezione = 10;
$wstartquote =  $wstart + $wnome + $wcognome + $wclasse + $wsezione;
$wintestazione = 15;
$wquote = 13;
$h =5;

$mesiA = ["SET", "OTT", "NOV", "DIC", "GEN", "FEB", "MAR", "APR", "MAG", "GIU", "LUG", "AGO"];




$pdf->SetFont('TitilliumWeb-SemiBold','',8);

$pdf->SetFillColor(50,50,50);
$pdf->SetTextColor(255,255,255);

$pdf->SetY ($hstartTit);
$currY = ($pdf->GetY());
$pdf->SetX ($wstart);
$pdf->Cell($wnome,$h,"NOME", 1 ,1, 'C', true);
$pdf->SetXY ($wstart + $wnome, $currY);
$pdf->Cell($wcognome,$h,"COGNOME", 1 ,1, 'C', true);
$pdf->SetXY ($wstart + $wnome + $wcognome, $currY);
$pdf->Cell($wclasse,$h,"CL.", 1 ,1, 'C', true);
$pdf->SetXY ($wstart + $wnome + $wcognome + $wclasse, $currY);
$pdf->Cell($wsezione,$h,"SEZ.", 1 ,1, 'C', true);

$pdf->SetXY ($wstartquote, $currY);
$pdf->Cell($wintestazione,$h,'TIPO', 1 ,0, 'L', true);


$pdf->SetXY ($wstartquote + $wintestazione, $currY);

$pdf->Cell($wquote,$h,"ALTRO", 1 ,1, 'C', true);



$pdf->SetFillColor(24,150,120);
for ($mese = 1; $mese <= 12; $mese++) {
	$pdf->SetXY ($wstartquote + $wintestazione + $wquote * $mese, $currY);
	$pdf->Cell($wquote,$h,$mesiA[$mese-1], 1 ,1, 'C', true);
}

$pdf->SetXY ($wstartquote + $wintestazione + $wquote * 13 +2, $currY);
$pdf->Cell($wquote,$h,"TOT", 1 ,1, 'R', true);
$pdf->SetFont($fontdefault,'',8);


$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0,0);

while (mysqli_stmt_fetch($stmt3)) {
	$riga++;

	// if ($datapagato_ret=="0000-00-00" || $datapagato_ret=="1900-01-01" || $datapagato_ret == NULL ) {
	// 	$datapagato = "";
	// } else {
	// 	$datapagato = timestamp_to_ggmmaa($datapagato_ret);
	// }
	
	
	// if ($datapagato_pga=="0000-00-00"|| $datapagato_pga=="1900-01-01" || $datapagato_pga == NULL) {
	// 	$datapagatoI = "";
	// } else {
	// 	$datapagatoI = timestamp_to_ggmmaa($datapagato_pga);
	// }
	
	

	if (fmod($riga-1, 12)==0) {
		//azzero i totali di riga
		//apre la riga ogni 12 record
		$TOTD = 0;
		$TOTC = 0;
		$TOTP = 0;
		$pdf->SetY ($hstart + $hgap*$j);
		$j = $j+1;
		
		
		$currY = ($pdf->GetY());
		$pdf->SetX ($wstart);
		$pdf->Cell($wnome,$h*3,$nome_alu, 1 ,1, 'C');
		$pdf->SetXY ($wstart + $wnome, $currY);
		$pdf->Cell($wcognome,$h*3,$cognome_alu, 1 ,1, 'C');
		$pdf->SetXY ($wstart + $wnome + $wcognome, $currY);
		$pdf->Cell($wclasse,$h*3,$classe_cla, 1 ,1, 'C');
		$pdf->SetXY ($wstart + $wnome + $wcognome + $wclasse, $currY);
		$pdf->Cell($wsezione,$h*3,$sezione_cla, 1 ,1, 'C');

		
		$pdf->SetXY ($wstartquote, $currY);
		$pdf->Cell($wintestazione,$h,'Default', 1 ,0, 'L');
		$pdf->SetxY ($wstartquote, $currY + $h);
		$pdf->Cell($wintestazione,$h,'Concordato', 1 ,1, 'L');
		$pdf->SetXY ($wstartquote, $currY + 2 * $h);
		$pdf->Cell($wintestazione,$h,'Pagato', 1 ,1, 'L');
		$pdf->SetXY ($wstartquote, $currY + 3 * $h);
		
		//$pdf->Cell($wintestazione,$h,'Data Pag.', 1 ,1, 'L');
		
		$pdf->SetXY ($wstartquote + $wintestazione, $currY + 2 * $h);
		if(fmod($pagato_pga, 1) !== 0.00){
			$pdf->Cell($wquote,$h,$pagato_pga, 1 ,1, 'C');
		} else {
			$pdf->Cell($wquote,$h,intval($pagato_pga), 1 ,1, 'C');
		}
		$pdf->SetXY ($wstartquote + $wintestazione, $currY + 3 * $h);
		$pdf->SetFont($fontdefault,'',6);
		//$pdf->Cell($wquote,$h,$datapagatoI, 1 ,1, 'C');
		$pdf->SetFont($fontdefault,'',8);
	}
	// Ho scritto l'intestazione (con nome cognome ecc) ora scrivo le quote
	$pdf->SetXY ($wstartquote + $wintestazione + $wquote * $riga, $currY);
	$pdf->Cell($wquote,$h,$default_ret, 1 ,1, 'R');
	$pdf->SetXY ($wstartquote + $wintestazione + $wquote * $riga, $currY + $h);
	if ($concordato_ret < $default_ret) {
		$pdf->SetFillColor(226,172,20);
		$pdf->SetTextColor(255,255,255);
	}
	$pdf->Cell($wquote,$h,$concordato_ret, 1 ,1, 'R', true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetXY ($wstartquote + $wintestazione + $wquote * $riga, $currY + 2 * $h);
	if ($pagato_ret < $concordato_ret) {
		$pdf->SetFillColor(204,37,27);
		$pdf->SetTextColor(255,255,255);
	}
	$pdf->Cell($wquote,$h,$pagato_ret, 1 ,1, 'R', true);

	$pdf->SetXY ($wstartquote + $wintestazione + $wquote * $riga, $currY + 3 * $h);
	$pdf->SetFont($fontdefault,'',6);
	//$pdf->Cell($wquote,$h,$datapagato, 1 ,1, 'R', true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont($fontdefault,'',8);


	$TOTD =  $TOTD + floatval($default_ret);
	$TOTC =  $TOTC + floatval($concordato_ret);
	$TOTP =  $TOTP + floatval($pagato_ret);

	if ($riga == 12) {
		$pdf->SetXY ($wstartquote + $wintestazione + $wquote * 13+2, $currY);
		$pdf->Cell($wquote,$h,$TOTD, 1 ,1, 'R');
		$pdf->SetXY ($wstartquote + $wintestazione + $wquote * 13+2, $currY + $h);
		$pdf->Cell($wquote,$h,$TOTC, 1 ,1, 'R');
		$pdf->SetXY ($wstartquote + $wintestazione + $wquote * 13+2, $currY + 2 * $h);
		$pdf->Cell($wquote,$h,$TOTP, 1 ,1, 'R');
		$riga = 0;
	}

}

$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$pdf->SetXY (0,10);
$pdf->Cell(297,10,"SITUAZIONE QUOTE FAMIGLIA: " . $cognomepadre_fam."-".$cognomemadre_fam. " AL ". date("d/m/Y"), 0 ,1, 'C');
$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->SetXY (0,18);
$pdf->Cell(297,10,"Anno Scolastico: " . $annoscolastico_ret, 0 ,1, 'C');

$pdf->SetXY (10,174);
$pdf->SetFont($fontdefault,'',8);
$pdf->Cell(277,5,"Note (eventuali) ", 0 ,1, 'C');
$pdf->SetXY (10,179);
$pdf->MultiCell(277,10,utf8_decode($commento_com),0,'C');
$pdf->SetXY (10,179);
$pdf->Cell(277,10,"", 1 ,1, 'C');







include_once("04inc_GetCausaliPagamento.php");
//$causali_pagA = ["non rilevata", "retta", "iscrizione", "donazione", "spese didattiche", "quota associativa", "cauzione"];

$tipi_pagA = ["non rilevata", "bonifico", "contante", "carta di credito", "altro"];
$soggetto_pagA = ["non rilevato", "padre", "madre", "altro"];

//ELENCO PAGAMENTI RETTE
$pdf->AddPage("L");


// //trova data inizio anno scolastico
// $sql = "SELECT datainizio_asc FROM tab_anniscolastici WHERE annoscolastico_asc = ? ";
// $stmt = mysqli_prepare($mysqli, $sql);
// mysqli_stmt_bind_param($stmt, "s", $annoscolastico);
// mysqli_stmt_execute($stmt);
// mysqli_stmt_bind_result($stmt, $annoscolastico_asc);
// while (mysqli_stmt_fetch($stmt)) {
// }


//INTESTAZIONE E INTESTAZIONI COLONNE
$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$pdf->SetXY (0,10);
$pdf->Cell(297,10,"Elenco Pagamenti Rette FAMIGLIA: " . $cognomepadre_fam."-".$cognomemadre_fam. " al ". date("d/m/Y")." - a.s. ".$annoscolastico_ret, 0 ,1, 'C');
$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->SetXY (10,20);
$pdf->Cell(30,10,"Nome Alunno", 0 ,0, 'C');
$pdf->Cell(30,10,"Cognome Alunno", 0 ,0, 'C');
$pdf->Cell(40,10,"Causale", 0 ,0, 'C');
$pdf->Cell(20,10,"Mese", 0 ,0, 'C');
$pdf->Cell(20,10,"Anno", 0 ,0, 'C');
$pdf->Cell(20,10,"Importo", 0 ,0, 'C');
$pdf->Cell(30,10,"Data", 0 ,0, 'C');
$pdf->Cell(30,10,"Modalita'", 0 ,0, 'C');
$pdf->Cell(40,10,"Effettuato da", 0 ,0, 'C');

$pdf->SetXY (10,25);
$pdf->Cell(30,10,"", "B" ,0, 'C');
$pdf->Cell(30,10,"", "B" ,0, 'C');
$pdf->Cell(40,10,"", "B" ,0, 'C');
$pdf->Cell(20,10,"", "B" ,0, 'C');
$pdf->Cell(20,10,"", "B" ,0, 'C');
$pdf->Cell(20,10,"Euro", 0 ,0, 'C');
$pdf->Cell(30,10,"Pagamento", "B" ,0, 'C');
$pdf->Cell(30,10,"Pagamento", "B" ,0, 'C');
$pdf->Cell(40,10,"", "B" ,0, 'C');



$sql = "SELECT ID_alu, ID_pag, importo_pag, data_pag, causale_pag, tipo_pag, soggetto_pag, mese_ret, anno_ret, nome_alu, cognome_alu, nomepadre_fam, cognomepadre_fam, nomemadre_fam, cognomemadre_fam 
FROM tab_pagamenti
LEFT JOIN tab_mensilirette ON ID_ret = ID_ret_pag
LEFT JOIN tab_anagraficaalunni ON ID_alu =  ID_alu_pag
LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam 
WHERE ID_fam = ? AND annoscolastico_pag = ?
ORDER BY ID_alu, data_pag, anno_ret, mese_ret
";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt,  "is", $ID_fam, $annoscolastico_ret);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $ID_alu, $ID_pag, $importo_pag, $data_pag, $causale_pag, $tipo_pag, $soggetto_pag, $mese_ret, $anno_ret, $nome_alu, $cognome_alu, $nomepadre_fam, $cognomepadre_fam, $nomemadre_fam, $cognomemadre_fam );


$hriga = 5;
$riga = 6;
$pdf->SetFont($fontdefault,'',8);


while (mysqli_stmt_fetch($stmt)) {




	if ($riga*$hriga > 175) {
		$pdf->AddPage("L");
		//INTESTAZIONE E INTESTAZIONI COLONNE
		$pdf->SetFont('TitilliumWeb-SemiBold','',12);
		$pdf->SetXY (0,10);
		$pdf->Cell(297,10,"Elenco Pagamenti Rette FAMIGLIA: " . $cognomepadre_fam."-".$cognomemadre_fam. " al ". date("d/m/Y")." - a.s. ".$annoscolastico_ret, 0 ,1, 'C');
		$pdf->SetFont('TitilliumWeb-SemiBold','',10);
		$pdf->SetXY (10,20);
		$pdf->Cell(30,10,"Nome Alunno", 0 ,0, 'C');
		$pdf->Cell(30,10,"Cognome Alunno", 0 ,0, 'C');
		$pdf->Cell(40,10,"Causale", 0 ,0, 'C');
		$pdf->Cell(20,10,"Mese", 0 ,0, 'C');
		$pdf->Cell(20,10,"Anno", 0 ,0, 'C');
		$pdf->Cell(20,10,"Importo", 0 ,0, 'C');
		$pdf->Cell(30,10,"Data", 0 ,0, 'C');
		$pdf->Cell(30,10,"Modalita'", 0 ,0, 'C');
		$pdf->Cell(40,10,"Effettuato da", 0 ,0, 'C');

		$pdf->SetXY (10,25);
		$pdf->Cell(30,10,"", "B" ,0, 'C');
		$pdf->Cell(30,10,"", "B" ,0, 'C');
		$pdf->Cell(40,10,"", "B" ,0, 'C');
		$pdf->Cell(20,10,"", "B" ,0, 'C');
		$pdf->Cell(20,10,"", "B" ,0, 'C');
		$pdf->Cell(20,10,"Euro", 0 ,0, 'C');
		$pdf->Cell(30,10,"Pagamento", "B" ,0, 'C');
		$pdf->Cell(30,10,"Pagamento", "B" ,0, 'C');
		$pdf->Cell(40,10,"", "B" ,0, 'C');
		$pdf->SetFont($fontdefault,'',8);
		$riga = 7;
		
		//$page = $page +1;
	} else {
		$riga = $riga + 1;
	}
	
	$pdf->SetXY (10,$riga*$hriga);
	if ($nome_alu <> $nome_alu_prec) {
		$pdf->Cell(30,$hriga,$nome_alu, "T" ,0, 'C');
		$pdf->Cell(30,$hriga,$cognome_alu, "T" ,0, 'C');
	}
	$pdf->SetXY (70,$riga*$hriga);
	$pdf->Cell(40,$hriga,$causali_pagA[$causale_pag], "T" ,0, 'C');
	$pdf->Cell(20,$hriga,$mese_ret, "T" ,0, 'C');
	$pdf->Cell(20,$hriga,$anno_ret, "T" ,0, 'C');
	$pdf->Cell(20,$hriga,$importo_pag, "T" ,0, 'C');
	$pdf->Cell(30,$hriga,timestamp_to_ggmmaaaa($data_pag), "T" ,0, 'C');
	$pdf->Cell(30,$hriga,$tipi_pagA[$tipo_pag], "T" ,0, 'C');

	switch ($soggetto_pag) {
		case 1:
			$pdf->Cell(40, $hriga, $nomepadre_fam." ".$cognomepadre_fam, "T" ,0, 'C');
		break;
		case 2:
			$pdf->Cell(40, $hriga, $nomemadre_fam." ".$cognomemadre_fam, "T" ,0, 'C');
		break;
		default:
			$pdf->Cell(40, $hriga, $soggetto_pagA[$soggetto_pag], "T" ,0, 'C');
	}


	//$pdf->Cell(40,$hriga,$soggetto_pagA[$soggetto_pag], "T" ,0, 'C');


	$nome_alu_prec = $nome_alu;
}




$pdf->Output();