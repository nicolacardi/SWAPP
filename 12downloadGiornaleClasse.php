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

$annoscolastico = $_POST['annoscolastico'];
$classe_ora = $_POST['classe_ora'];
$sezione_ora = $_POST['sezione_ora'];
$settimane = $_POST['settimane'];
$datalunedi = $_POST['datalunedi'];
$paginauno = $_POST['paginauno'];
$codscuola = $_SESSION['codscuola'];

$datavenerdi = date('Y-m-d',strtotime("+4 day", strtotime($datalunedi)));

$sql2 = "SELECT desc_cls, aselme_cls  FROM tab_classi WHERE classe_cls = ? ";
$stmt2 = mysqli_prepare($mysqli, $sql2);
mysqli_stmt_bind_param($stmt2, "s", $classe_ora);
mysqli_stmt_execute($stmt2);
mysqli_stmt_bind_result($stmt2, $desc_cls, $aselme_cls);
while (mysqli_stmt_fetch($stmt2)) {
}

//FRONTESPIZIO************************************************************************************************************************************
$pdf->AddPage();
//Rettangolo grande
$pdf->SetDrawColor(24,126,13);
$pdf->Rect(10,10,190,275);
//Rettangolo grande interno tratteggiato
$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->Rect(12,12,186,271);
$pdf->SetDash(); //5mm on, 5mm off
//Logo
$width =  75;
$positionX= 210 / 2 - ($width/2);
$positionY =  25;
$pdf->Image('assets/img/logo/logo'.$codscuola.'/logodefVerde.png',$positionX,$positionY, $width);
//Titoli
$pdf->SetFont('TitilliumWeb-SemiBold','',16);
$pdf->SetTextColor(24,126,13);
$pdf->SetXY (0,100);
$pdf->Cell(210,10,utf8_decode("Giornale della Classe"), 0,1, 'C');
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(0,10,utf8_decode($desc_cls. " - Sez. ".$sezione_ora), 0,1, 'C');
$pdf->Cell(0,10,"Anno scolastico: ".$annoscolastico, 0,1, 'C');

switch ($aselme_cls) {
	case "AS" :
		//non possibile
		break;
	case "EL" :
		$pdf->Cell(0,10,"- Scuola Primaria -", 0,1, 'C');
		break;
	case "ME" :
		$pdf->Cell(0,10,"- Scuola Secondaria di primo grado -", 0,1, 'C');
		break;
	case "SU" :
		$pdf->Cell(0,10,"- Scuola Secondaria di secondo grado -", 0,1, 'C');
		break;
}





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
//pagina bianca
$pdf->AddPage();

//pagina intermedia
$pdf->AddPage();
$pdf->SetFont('TitilliumWeb-SemiBold','',16);
$pdf->SetTextColor(24,126,13);
$pdf->SetXY (0,100);
$pdf->SetDrawColor(24,126,13);
$pdf->Rect(50,90,110,40);
$pdf->SetDrawColor(0,0,0);
$pdf->Cell(210,10,utf8_decode("Giornale della Classe"), 0,1, 'C');
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(0,10,utf8_decode($desc_cls. " - Sez. ".$sezione_ora), 0,1, 'C');
$pdf->SetTextColor(0,0,0);


$pdf->SetFont($fontdefault,'',10);
for ($settimana = 1; $settimana <= $settimane; $settimana++) {
	//ora devo settare la data iniziale <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
	$datagg[1] = date('Y-m-d',strtotime("+".(($settimana-1)*7)." day", strtotime($datalunedi)));
	$datagg[2] = date('Y-m-d',strtotime("+1 day", strtotime($datagg[1])));
	$datagg[3] = date('Y-m-d',strtotime("+2 day", strtotime($datagg[1])));
	$datagg[4] = date('Y-m-d',strtotime("+3 day", strtotime($datagg[1])));
	$datagg[5] = date('Y-m-d',strtotime("+4 day", strtotime($datagg[1])));

	$dateSeq = array($datagg[1], $datagg[2], $datagg[3], $datagg[4], $datagg[5]);
	//Aggiungo pagina dispari
	
	$pdf->AddPage();
	
	$startY =  30;
	$spacedayY =  40;
	$gapY = 5;
	$numeroore = 10;
	$spacemateriaY = $spacedayY/$numeroore;
	$w1 = 10; //data
	$w2 = 7; //numero materia
	$w3 = 36; //materia
	$w4 = 36; //docente
	$w5 = 101; //tutor/docente2
	$w6 = 0; //materia2
	//costruisco lo schema con il ciclo for seguente
	$giorniA = array("  LUNEDI", "  MARTEDI", " MERCOLEDI", "  GIOVEDI", "  VENERDI");
	$pdf->SetFont($fontdefault,'',7.5);
	$pdf->SetXY(10,$startY-2*$spacemateriaY);
	$pdf->Cell($w1+$w2+$w3+$w4+$w5,$spacemateriaY,'(*) ora di supplenza', 0 ,0, 'C');
	$pdf->SetXY(10,$startY-$spacemateriaY);
	$pdf->Cell($w1,$spacemateriaY,'GIORNO', 1 ,0, 'C');
	$pdf->Cell($w2,$spacemateriaY,'ORA', 1 ,0, 'C');
	$pdf->SetFont($fontdefault,'',10);
	$pdf->Cell($w3,$spacemateriaY,'MATERIA', 1 ,0, 'C');
	$pdf->Cell($w4,$spacemateriaY,'DOCENTE', 1 ,0, 'C');
	$pdf->Cell($w5,$spacemateriaY,'ALTRE MATERIE e TUTORING', 1 ,0, 'C');
	//$pdf->Cell($w6,$spacemateriaY,'MATERIA altro docente', 1 ,0, 'C');
	for ($giorno = 0; $giorno <=4; $giorno++) {
		$Nomegiorno = $giorniA[$giorno];
		for ($ora = 1; $ora <=$numeroore; $ora++) {
			$pdf->SetDrawColor(200,200,200);
			$pdf->SetDash(1,1); //5mm on, 5mm off
			$y = $startY + $spacedayY*($giorno) + $gapY* ($giorno) + ($ora -1)*$spacemateriaY;
			$pdf->SetXY($w1,$y);
			$pdf->SetFont($fontdefault,'',8);
			if ($ora == 1) {$pdf->Cell($w1,$spacemateriaY,substr($datagg[$giorno+1],8,2)."/".substr($datagg[$giorno+1],5,2), "B" ,0, 'C');} else {$pdf->Cell($w1,$spacemateriaY,substr($Nomegiorno,$ora-1,1), 0 ,0, 'C');}
			$pdf->SetFont($fontdefault,'',10);
			$pdf->Cell($w2,$spacemateriaY,$ora, "B" ,0, 'C');
			$pdf->Cell($w3,$spacemateriaY,'', "B" ,0, 'C');
			$pdf->Cell($w4,$spacemateriaY,'', "B" ,0, 'C');
			$pdf->Cell($w5,$spacemateriaY,'', "B" ,0, 'C');
			//$pdf->Cell($w6,$spacemateriaY,'', "B" ,0, 'C');
			$pdf->SetDash(); //
		}
		$pdf->SetDrawColor(0,0,0);
		$y = $startY + $spacedayY*($giorno) + $gapY* ($giorno);
		$pdf->SetXY($w1,$y);
		$pdf->Cell($w1,$spacemateriaY*$numeroore,'', 1 ,0, 'C');
		$pdf->Cell($w2,$spacemateriaY*$numeroore,'', 1 ,0, 'C');
		$pdf->Cell($w3,$spacemateriaY*$numeroore,'', 1 ,0, 'C');
		$pdf->Cell($w4,$spacemateriaY*$numeroore,'', 1 ,0, 'C');
		$pdf->Cell($w5,$spacemateriaY*$numeroore,'', 1 ,0, 'C');
		//$pdf->Cell($w6,$spacemateriaY*$numeroore,'', 1 ,0, 'C');
	}
	//fine costruzione schema
	
	//numero di pagina
	$pdf->SetXY(10,260);
	$pdf->Cell($w1+$w2+$w3,8,"dal ".timestamp_to_ggmmaaaa($datalunedi)." al ".timestamp_to_ggmmaaaa($datagg[5]), 1 ,0, 'C');
	//$pdf->Cell($w1,8,($paginauno -1 + $settimana*2-1), 1 ,0, 'C');
	$pdf->Cell($w4,8,'', 0 ,0, 'C');
	$pdf->Cell($w5,8,"Classe ".$desc_cls. " - Sez. ".$sezione_ora, 'B' ,0, 'C');

	
	//Estrazione e scrittura dei dati ********************************************************************
	$sql = "SELECT data_ora, ora_ora, descmateria_mtt, nome_mae, cognome_mae, argomento_ora, compitiassegnati_ora, assente_ora, secondomaestro_ora FROM (tab_orario LEFT JOIN tab_anagraficamaestri ON maestroreale_ora = ID_mae) LEFT JOIN tab_materie ON codmat_ora = codmat_mtt WHERE data_ora BETWEEN ? AND  ? AND classe_ora = ? AND sezione_ora = ? AND firma_mae_ora <> 0 ORDER BY data_ora, ora_ora;";
	
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ssss", $datagg[1], $datagg[5], $classe_ora, $sezione_ora);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	mysqli_stmt_bind_result($stmt, $data_ora, $ora_ora, $descmateria_mtt, $nome_mae, $cognome_mae, $argomento_ora, $compitiassegnati_ora, $assente_ora, $secondomaestro_ora);

	
	while (mysqli_stmt_fetch($stmt)) {
		//estraggo le assenze del giorno e ne faccio una stringa sola
			// $sql2 = "SELECT nome_alu, cognome_alu  FROM (tab_assenze LEFT JOIN tab_anagraficaalunni ON ID_alu_ass = ID_alu) LEFT JOIN tab_classialunni ON ID_alu_cla = ID_alu_ass WHERE annoscolastico_cla = ? AND data_ass = ? AND ora_ass = ? AND classe_cla = ? AND sezione_cla = ? ORDER BY cognome_alu, nome_alu";
			// $stmt2 = mysqli_prepare($mysqli, $sql2);
			// mysqli_stmt_bind_param($stmt2, "ssiss", $annoscolastico, $data_ora, $ora_ora, $classe_ora, $sezione_ora);
			// mysqli_stmt_execute($stmt2);
			// mysqli_stmt_store_result($stmt2);
			// mysqli_stmt_bind_result($stmt2, $nome_alu, $cognome_alu);
			// $alunniassenti = "";
			// $alunni = 0;
			// while (mysqli_stmt_fetch($stmt2)) {
			// 	$alunniassenti = $alunniassenti.", ".substr($nome_alu,0,1).".".$cognome_alu;
			// 	$alunni++;
			// }
			// if ($alunniassenti !="") {$alunniassenti = substr($alunniassenti, 1);}
		
		$j = array_search($data_ora, $dateSeq); //$j dice se si tratta della prima, seconda, terza, quarta o quinta data
		
		$y = $startY + $spacedayY*$j + $gapY* $j + ($ora_ora -1)*$spacemateriaY;
		
		
		if ($assente_ora == 1) {
			$nomecognome_mae = $nome_mae." ".$cognome_mae." (*)";
		} else {
			$nomecognome_mae =  $nome_mae." ".$cognome_mae;
		}
		if ($secondomaestro_ora == 0) {
			$pdf->SetXY(10+$w1+$w2,$y);
			$pdf->Cell($w3,$spacemateriaY,$descmateria_mtt, 0 ,0, 'C');	
			$pdf->Cell($w4,$spacemateriaY,$nomecognome_mae, 0 ,0, 'C');
			
		} else {
			//nel caso di secondo maestro potrebbe essercene anche un terzo o quarto...
			//qui si può inserire UNA sola firma...allora scelgo di procedere in questo modo:
			//se c'è un solo secondo maestro scrivo quello che sia tutor o no
			//se c'è più di un secondomaestro scrivo solo quello che non è tutor, se c'è, dando priorità alla divisione delle classi
			$sql3 = "SELECT codmat_ora, descmateria_mtt, nome_mae, cognome_mae, assente_ora, secondomaestro_ora FROM (tab_orario LEFT JOIN tab_anagraficamaestri ON maestroreale_ora = ID_mae) LEFT JOIN tab_materie ON codmat_ora = codmat_mtt WHERE data_ora = ? AND ora_ora = ? AND classe_ora = ? AND sezione_ora = ? AND firma_mae_ora <> 0 ORDER BY data_ora, ora_ora;";

			$stmt3 = mysqli_prepare($mysqli, $sql3);
			mysqli_stmt_bind_param($stmt3, "siss", $data_ora, $ora_ora, $classe_ora, $sezione_ora);
			mysqli_stmt_execute($stmt3);
			mysqli_stmt_bind_result($stmt3, $codmat_oraB, $descmateria_mttB, $nome_maeB, $cognome_maeB, $assente_oraB, $secondomaestro_oraB);
			//$ceTutor = 0;
			$ClasseDivisa = 0;
			$test = '';
			$nomecognomeMateriaB = '';
			while (mysqli_stmt_fetch($stmt3)) {
				
				//Volendo dare priorità a una seconda materia rispetto al tutoring:
				// if ($codmat_oraB != "TUX" && $secondomaestro_oraB == 1) { 
				// 	$ClasseDivisa = 1;
				// 	$nome_mae = $nome_maeB;
				// 	$cognome_mae = $cognome_maeB;
				// 	if ($assente_oraB == 1) {
				// 		$nomecognome_mae = $nome_maeB." ".$cognome_maeB." (*)";
				// 	} else {
				// 		$nomecognome_mae =  $nome_maeB." ".$cognome_maeB;
				// 	}
				// 	$descmateria_mtt =  $descmateria_mttB;
				// }

				//if ($descmateria_mtt == "TUX") { $ceTutor = 1;}
				if ($assente_oraB == 1) {
						$nomecognome_maeB = $nome_maeB." ".$cognome_maeB." (*)";
				 	} else {
				 		$nomecognome_maeB =  $nome_maeB." ".$cognome_maeB;
				 	}
				if ($secondomaestro_oraB != 0) {
					$nomecognomeMateriaB = $nomecognomeMateriaB.$nomecognome_maeB."-".$descmateria_mttB."     ";
				}
			}
			
			$pdf->SetFont($fontdefault,'',8);
			$pdf->SetXY(10+$w1+$w2+$w3+$w4,$y);
			$pdf->Cell($w5,$spacemateriaY,$nomecognomeMateriaB, 0 ,0, 'C');
			//$pdf->Cell($w6,$spacemateriaY,$descmateria_mtt, 0 ,0, 'C');
			$pdf->SetFont($fontdefault,'',10);	
			
		}
		// $pdf->Cell($w5,$spacemateriaY,$alunniassenti, 0 ,0, 'L'); non si scrivono più qui gil alunni assenti
		// $pdf->SetFont($fontdefault,'',10);
	
	}
	$pdf->SetFont($fontdefault,'',10);
	//aggiungo pagina pari e rilancio la query per estrarre stavolta i compiti assegnati
	$pdf->AddPage();
	
	$w6 = 190;
	//costruisco lo schema con il ciclo for seguente
	$pdf->SetXY(10,$startY-$spacemateriaY);
	$pdf->Cell($w6,$spacemateriaY,'ARGOMENTI TRATTATI e COMPITI ASSEGNATI', 1 ,0, 'C');

	for ($giorno = 0; $giorno <=4; $giorno++) {
		$Nomegiorno = $giorniA[$giorno];
		for ($ora = 1; $ora <=$numeroore; $ora++) {
			$pdf->SetDrawColor(200,200,200);
			$pdf->SetDash(1,1); //5mm on, 5mm off
			$y = $startY + $spacedayY*($giorno) + $gapY* ($giorno) + ($ora -1)*$spacemateriaY;
			$pdf->SetXY(10,$y);
			$pdf->Cell($w6,$spacemateriaY,'', "B" ,0, 'C');
			$pdf->SetDash(); //
		}
		$pdf->SetDrawColor(0,0,0);
		$y = $startY + $spacedayY*($giorno) + $gapY* ($giorno);
		$pdf->SetXY($w1,$y);
		$pdf->Cell($w6,$spacemateriaY*$numeroore,'', 1 ,0, 'C');
	}
	//fine costruzione schema
	
	//$pdf->SetXY(190,260);
	//$pdf->Cell($w1,8,($paginauno -1 + $settimana*2), 1 ,0, 'C');


	
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	$argomentoecompiti = '';
	$ora_ora_prec = 0;
	$data_ora_prec = 0;
	$n = 0;

	//Il difficile algoritmo che segue era così, ma non teneva conto dei doppi maestri
	// mysqli_stmt_execute($stmt);
	// mysqli_stmt_store_result($stmt);
	// $argomentoecompiti = '';
	// while (mysqli_stmt_fetch($stmt)) {
	// 	if ($ora_ora != $ora_ora_prec) {$argomentoecompiti = '';}
	// 	$pdf->SetFont($fontdefault,'',9);
	// 	$j = array_search($data_ora, $dateSeq); //$j dice se si tratta della prima, seconda, terza, quarta o quinta data
	// 	$y = $startY + $spacedayY*$j + $gapY* $j + ($ora_ora -1)*$spacemateriaY;
	// 	$pdf->SetXY(10,$y);
		
	// 	if ($compitiassegnati_ora != "") {
	// 		$compitiassegnati_ora = " - PER CASA: ".$compitiassegnati_ora;
	// 	}
	// 	$argomentoecompiti = utf8_decode($argomentoecompiti.$argomento_ora.$compitiassegnati_ora."     ");
	// 	//se più di 130 caratteri riduco il font
	// 	if (strlen($argomentoecompiti) > 130) {
	// 		$pdf->SetFont($fontdefault,'',7);
	// 	}
	// 	//se più di 165 caratteri taglio il testo e aggiungo ...
	// 	if (strlen($argomentoecompiti) > 165) {
	// 		$argomentoecompiti = substr ($argomentoecompiti, 0, 165)."...";
	// 	}
	// 	$pdf->Cell($w6,$spacemateriaY,$argomentoecompiti, 0 ,0, 'L');
	// 	$ora_ora_prec = $ora_ora;
	// }







	while (mysqli_stmt_fetch($stmt)) {

		//questa routine è molto complicata dal fatto che ci sono i doppi maestri e questo fa sì che per ogni ID ci possano essere più ora_ora.
		//poichè devo scrivere in quel caso la concatenazione degli argomento e compiti questo lo posso fare SOLO quando sono all' "ULTIMO" dei record con lo stesso valore ora_ora (ovviamente nella stessa data).
		//quindi devo scrivere nella cella solo quando mi accorgo che ora_ora != ora_ora_prec, cioè al "record successivo"
		//questo rende tutto molto molto complicato, anche stabilire a quale coordinata y si deve scrivere non è affatto semplice
		//inoltre in uscita dal ciclo while devo scrivere l'ultimo record perchè non viene altrimenti scritto essendo il ciclo concepito come sopra descritto
		//in alternativa dovrei per ogni record sapere quanti ce ne sono con quello stesso valore di ora_ora, annidando una sql dentro questa sql...
		//embra stare in piedi come è qui scritta

		$n++;

		$pdf->SetFont($fontdefault,'',9);
		$j = array_search($data_ora_prec, $dateSeq); //$j dice se si tratta della prima, seconda, terza, quarta o quinta data
		$y = $startY + $spacedayY*$j + $gapY* $j + ($ora_ora_prec -1)*$spacemateriaY;
		//$y è la prossima coordinata verticale
		//viene costruita a partire da
		//startY che è lo spazio Y lasciato in alto
		//spacedayY è lo spazio riservato ad ogni giorno
		//gapY è lo spazio tra i giorni
		//spacemateriaY è l'altezza di ogni riga

		$pdf->SetXY(10,$y);
		if ($compitiassegnati_ora != "") {
			$compitiassegnati_ora = " - PER CASA: ".$compitiassegnati_ora;
		}

		if ($ora_ora != $ora_ora_prec && $n!=1) {
			//scarico il precedente
			//se più di 130 caratteri riduco il font
			if (strlen($parkedArgomentoeCompiti) > 130) {
				$pdf->SetFont($fontdefault,'',7);
			}
				
			//se più di 176 caratteri taglio il testo e aggiungo ...
			if (strlen($parkedArgomentoeCompiti) > 176) {
				$parkedArgomentoeCompiti = substr ($parkedArgomentoeCompiti, 0, 176)."...";
			}
			$pdf->Cell($w6,$spacemateriaY,utf8_decode($parkedArgomentoeCompiti), 0 ,0, 'L');
			$parkedArgomentoeCompiti = $argomento_ora.$compitiassegnati_ora. "    ";
			//$parkedArgomentoeCompiti = $ora_ora;
		} else {
			$pdf->SetFont($fontdefault,'',9);
			//unisco al precedente e tengo, non scarico, scaricherò al turno in cui ora_ora <> ora_ora_prec
			$parkedArgomentoeCompiti= $parkedArgomentoeCompiti.$argomento_ora.$compitiassegnati_ora;
			//$parkedArgomentoeCompiti= $parkedArgomentoeCompiti.$ora_ora;
		}

		$ora_ora_prec = $ora_ora;
		$data_ora_prec = $data_ora;
	}

	//in uscita inserisco l'ultimo
	$y = $startY + $spacedayY*$j + $gapY* $j + ($ora_ora -1)*$spacemateriaY;
	$pdf->SetXY(10,$y);
	if (strlen($parkedArgomentoeCompiti) > 130) {
		$pdf->SetFont($fontdefault,'',7);
	}
		
	//se più di 165 caratteri taglio il testo e aggiungo ...
	if (strlen($parkedArgomentoeCompiti) > 180) {
		$parkedArgomentoeCompiti = substr ($parkedArgomentoeCompiti, 0, 180)."...";
	}
	$pdf->Cell($w6,$spacemateriaY,utf8_decode($parkedArgomentoeCompiti), 0 ,0, 'L');

	$pdf->SetXY(140,260);
	$pdf->Cell($w1+$w2+$w3,8,"dal ".timestamp_to_ggmmaaaa($datalunedi)." al ".timestamp_to_ggmmaaaa($datagg[5]), 1 ,0, 'C');
	
	
	
	//Timbro Firme e tratteggi per firme
	$wfirma = 60;
	$xfirma = (210-$wfirma)/2;
	$indicetimbro = rand(1,9);
	$pdf->Image('assets/img/timbri/timbro'.$codscuola.'/timbro'.$indicetimbro.'.png', $xfirma, 250, 20);
	$pdf->SetFont($fontdefault,'',10);
	$pdf->SetXY ($xfirma,250);
	$pdf->Cell($wfirma,10,"Il Coordinatore Didattico", 0 ,1, 'C');
	$pdf->SetXY ($xfirma,260);
	$pdf->Cell($wfirma,8,"", "B" ,1, 'C');
	$indicefirma = rand(1,15);
	$pdf->Image('assets/img/firmecoordinatori/firme'.$codscuola.'/CoordDidattico'.$aselme_cls.$indicefirma.'.png', $xfirma, 255, 60);
}
	


//pagina bianca
$pdf->AddPage();
	
//Seconda di Copertina ************************************************************************************************************************************
$pdf->AddPage();
$pdf->SetDrawColor(24,126,13);
$pdf->Rect(10,10,190,275);
$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->Rect(12,12,186,271);
$pdf->SetDash();
$pdf->SetTextColor(24,126,13);

//Intestazione Scuola
$pdf->SetFont('TitilliumWeb-SemiBold','',16);
include("12intestazionescuolaA3.php");

$pdf->Output();
?>