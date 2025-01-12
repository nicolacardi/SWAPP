<?
require_once ('fpdf181/fpdf.php');              
require_once ('fpdf181/MC_TABLE.php');          //Estende fpdf
require_once ('fpdf181/MLT.php');               //Estende MC_TABLE
require_once ('fpdf181/Rotate.php');            //Estende MLT
require_once ('fpdf181/SetClassi.php');         //Estende Rotate: in SetClassi ci sono diverse classi Generiche ad esempio c'è WRITEHtml

include_once("database/databaseii.php");
include_once("assets/functions/functions.php");
include_once("assets/functions/ifloggedin.php");

//Header e Footer
class PDF extends PDF_SetClassiGeneriche {}

include_once("iscrizioni/settings_fpdf_Base.php");
$mostragiudizi = getPar('mostra_giudizi_compiti_verifiche');
$annoscolastico_cla = $_POST['annoscolastico_cla'];
$codscuola = $_SESSION['codscuola'];

$sqlM = "SELECT nome_mae, cognome_mae FROM tab_anagraficamaestri WHERE ID_mae  = ?";
$stmtM = mysqli_prepare($mysqli, $sqlM);
mysqli_stmt_bind_param($stmtM, "i", $_POST['ID_mae']);
mysqli_stmt_execute($stmtM);
mysqli_stmt_bind_result($stmtM, $nome_mae, $cognome_mae);
while (mysqli_stmt_fetch($stmtM)) {}

$nore = intval($_SESSION['ore_orario']);

//FRONTESPIZIO************************************************************************************************************************************
	$NUMpagina = 0;
	$pdf->AddPage();
	$NUMpagina++;
	//Rettangolo grande
	$pdf->SetDrawColor(91,42,127);
	$pdf->Rect(10,10,190,275);
	//Rettangolo grande interno tratteggiato
	$pdf->SetDash(1,1); //5mm on, 5mm off
	$pdf->Rect(12,12,186,271);
	$pdf->SetDash(); //5mm on, 5mm off
	//Logo
	$width =  75;
	$positionX= 210 / 2 - ($width/2);
	$positionY =  25;
	$pdf->Image('assets/img/logo/logo'.$codscuola.'/logodefViolaScuro.png',$positionX,$positionY, $width);
	//Titoli
	$pdf->SetFont($fontdefault,'',16);
	$pdf->SetTextColor(92,42,127);
	$pdf->SetXY (0,100);
	$pdf->Cell(210,10,utf8_decode("Giornale dell'Insegnante"), 0,1, 'C');
	$pdf->Cell(0,10,$nome_mae." ".$cognome_mae, 0,1, 'C');
	$pdf->Cell(0,10,"Anno Scolastico: ".$annoscolastico_cla, 0,1, 'C');


	$pdf->Ln(10);

	//Timbro Firme e tratteggi per firme
	$indicetimbro = rand(1,9);
	$pdf->Image('assets/img/timbri/timbro'.$codscuola.'/timbro'.$indicetimbro.'.png', 135, 250, 20);
	$pdf->SetFont($fontdefault,'',12);
	//$pdf->SetXY (15,250);
	//$pdf->Cell(60,10,"Data e Luogo", 0 ,0, 'C');
	$pdf->SetXY (135,250);
	$pdf->Cell(60,10,"Firma dell'Insegnante", 0 ,1, 'C');
	$indicefirma = rand(1,10);
	$firmamaestroimg = 'assets/img/firmemaestri/firmemaestri'.$codscuola.'/'.strtolower($nome_mae).strtolower($cognome_mae).'/'.strtolower($nome_mae).strtolower($cognome_mae).$indicefirma.'.png';
	$firmamaestroimg = str_replace(' ', '', $firmamaestroimg);
	if (file_exists($firmamaestroimg)) {
		$pdf->Image($firmamaestroimg, 135, 255, 60);
	}
	$pdf->SetDash(1,1); //5mm on, 5mm off
	//$pdf->SetXY (15,260);
	//$pdf->Cell(60,10,"", "B" ,0, 'C');
	$pdf->SetXY (135,260);
	$pdf->Cell(60,10,"", "B" ,0, 'C');
	$pdf->SetDash(); //Restore dash
//FINE FRONTESPIZIO************************************************************************************************************************************
 
$classe_cla = $_POST['classe_cla'];
$sezione_cla = $_POST['sezione_cla'];

$ID_mae = $_POST['ID_mae'];
$ID_covA = array();
$codmat_covA = array();
$tipocovA = array();
$datacov = array();
$argomento_covA = array();
$ID_aluA = array();

//pagina intermedia
$pdf->AddPage();
$NUMpagina++;
//INIZIO PAGINA MATERIE *******************************************************************************************************************
	$pdf->AddPage();
	$NUMpagina++;
	$pdf->SetXY (0,40);
	$pdf->SetDrawColor(91,42,127);


	$sql3 = "SELECT ID_cma, annoscolastico_cma, ruolo_cma, codmat_cma, descmateria_mtt, classe_cma, sezione_cma, aselme_cls, desc_cls  ".
	" FROM (tab_classimaestri LEFT JOIN tab_materie ON codmat_cma = codmat_mtt) LEFT JOIN tab_classi ON classe_cma = classe_cls ".
	" WHERE codmat_mtt <> 'ESE' AND codmat_mtt <> 'XX2' AND ID_mae_cma = ? AND annoscolastico_cma = ? ORDER BY  ord_cls ASC, descmateria_mtt ASC;";
	$stmt3 = mysqli_prepare($mysqli, $sql3);
	mysqli_stmt_bind_param($stmt3, "is", $ID_mae, $annoscolastico_cla);
	mysqli_stmt_execute($stmt3);
	mysqli_stmt_bind_result($stmt3, $ID_cma, $annoscolastico_cma, $ruolo_cma, $codmat_cma, $descmateria_mat, $classe_cma, $sezione_cma, $aselme_cls, $desc_cls);


	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(210,10,utf8_decode("anno scolastico ".$annoscolastico_cla), 0,1, 'C');
	$pdf->Cell(0,10,utf8_decode("MATERIE INSEGNATE"), 0,1, 'C');
	$w1 = 80;
	$w2 = 30;
	$w3 = 15;
	$w4 = 55;
	$startleft =  (210 - ($w1+$w2+$w3+$w4))/2;
	$pdf->SetXY ($startleft,60);
	$pdf->Cell($w1,10,"Materia", 1 ,0, 'C');
	$pdf->Cell($w2,10,"Classe", 1 ,0, 'C');
	$pdf->Cell($w3,10,"Sez.", 1 ,0, 'C');
	$pdf->Cell($w4,10,"Scuola", 1 ,1, 'C');

	$k=0;
	while (mysqli_stmt_fetch($stmt3)) {
		$k++;

		$pdf->SetXY ($startleft,62+$k*8);
		$pdf->Cell($w1,8,$descmateria_mat, 1 ,0, 'C');
		$pdf->Cell($w2,8,$desc_cls, 1 ,0, 'C');
		$pdf->Cell($w3,8,$sezione_cma, 1 ,0, 'C');
		

		switch ($aselme_cls) {
			case "AS" :
				//non possibile
				break;
			case "EL" :
				$pdf->Cell($w4,8,"Scuola Primaria", 1 ,1, 'C');
				break;
			case "ME" :
				$pdf->Cell($w4,8,utf8_decode("Scuola Secondaria di I°Grado"), 1 ,1, 'C');
				break;
			case "SU" :
				$pdf->Cell($w4,8,"Scuola Secondaria di II°Grado", 1 ,1, 'C');
				break;
		}


	}



	//$pdf->SetFont($fontdefault,'',12);
	//$indicetimbro = rand(1,9);
	//$pdf->Image('assets/img/timbri/timbro'.$codscuola.'/timbro'.$indicetimbro.'.png', 135, 250, 20);
	//$pdf->SetXY (15,250);
	//$pdf->Cell(60,10,"Data e Luogo", 0 ,0, 'C');
	//$pdf->SetXY (135,250);
	//$pdf->Cell(60,10,"Firma dell'Insegnante", 0 ,1, 'C');

	//$pdf->SetDash(1,1); //5mm on, 5mm off
	//$pdf->SetXY (15,260);
	//$pdf->Cell(60,10,"", "B" ,0, 'C');
	//$pdf->SetXY (135,260);
	//$pdf->Cell(60,10,"", "B" ,0, 'C');
	//$pdf->SetDash(); //Restore dash

//FINE PAGINA MATERIE *******************************************************************************************************************

//INIZIO PAGINA ORARIO *******************************************************************************************************************
	$pdf->AddPage();
	$NUMpagina++;
	$pdf->SetFont($fontdefault,'',14);
	$pdf->SetFillColor(91,42,127);
	$pdf->SetTextColor(255,255,255);

	$startY = 50;
	$pdf->SetXY (45,$startY-10);
	//titolo della tabella
	$pdf->Cell(150,10,"Orario di insegnamento", 1 ,0, 'C', true);

	$pdf->SetFont($fontdefault,'',12);
	//prima riga
	$giorni = array("idle", "lunedì", "martedì", "mercoledì", "giovedì", "venerdì", "sabato", "domenica");
	for ($j = 0; $j <= 4; $j++) {
		$pdf->SetXY (45 + $j*30, $startY);
		$pdf->Cell(30,10,utf8_decode($giorni[$j+1]), 1 ,0, 'C', true);
	}

	//$nore = 7 ; //valore che arriva dalla variabile di sessione ore_orario a sua volta pescato in tab_parametri
	//griglia base
	for ($j = 0; $j <= 4; $j++) {
		for ($ora = 1; $ora <= $nore; $ora++){
			$pdf->SetXY (45 + $j*30, $startY -10+ $ora*20);
			$pdf->Cell(30,20,"", 1 ,0, 'C');
		}
	}

	//$pdf->SetXY (45,$startY+10);
	//$pdf->Cell(150,140,"", 1 ,0, 'C');

	//da modificare pescandoli dalla tabella in modo che solo lì vengono inseriti
	//$orariA = array("idle", "8.05 - 9.15", "9.15 - 10.15", "10.45 - 11.45", "11.35 - 12.25", "12.25 - 13-15", "13.15 - 14.05", "14.05 - 14.55", "15.05 - 15.55");

	$sql = "SELECT ID_ore, orainizio_ore, orafine_ore, desc_ore FROM tab_ore ORDER BY N_ore";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_ore, $orainizio_ore, $orafine_ore, $desc_ore);
	$orariA = array("idle");
	//$desc_oreA= array("idle");

	while (mysqli_stmt_fetch($stmt)) {
		//$orainizio_ore = substr($orainizio_ore, 0, strlen($orainizio_ore)-3);
		//$orafine_ore = substr($orafine_ore, 0, strlen($orafine_ore)-3);
		
		array_push($orariA, substr($desc_ore, 7 )) ;
		//array_push($desc_oreA, $desc_ore);
	}



	$pdf->SetDrawColor(255,255,255);

	//prima colonna a sinistra
	for ($j = 1; $j <= $nore; $j++) {
		$pdf->SetXY (10, $j*20+$startY-10);
		$pdf->Cell(35,10,$orariA[$j], "LTR" ,0, 'C', true);
	}
	for ($j = 1; $j <= $nore; $j++) {
		$pdf->SetXY (10, $j*20+$startY);
		$pdf->Cell(35,10,"", "LBR" ,0, 'C', true);
	}

	$pdf->SetDrawColor(91,42,127);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(91,42,127);
	$pdf->SetFont($fontdefault,'',10);

	//devo trovare una settimana di "campionamento" dove andare a guardare all'orario: scelgo non la prima settimana dell'anno, nemmeno la seconda ma la terza, dal lunedi al venerdi.
	//quindi guardo in tab_anniscolastici la data di inizio, e trovo non il lunedi successivo ma due lunedi successivi (INTERVAL(16...)...) come datefrom
	//$sql = "SELECT datainizio_asc FROM tab_anniscolastici WHERE annoscolastico_asc = ?";
	//trovo la prima data del quadrimestre. Con la complessa sql qui sotto si ricava la data del PROSSIMO LUNEDI RISPETTO ALLA DATA DI INIZIO DELL'ANNO (che si trova in tab_anniscolastici).
	//$sql = "SELECT DATE_ADD(datainizio_asc, INTERVAL (9 - IF(DAYOFWEEK(datainizio_asc)=1, 8, DAYOFWEEK(datainizio_asc))) DAY) AS NEXTMONDAY FROM tab_anniscolastici WHERE annoscolastico_asc = ?" ;
	//trovo la prima data del quadrimestre. Con la complessa sql qui sotto si ricava la data di DUE LUNEDI SUCCESSIVI RISPETTO ALLA DATA DI INIZIO DELL'ANNO (che si trova in tab_anniscolastici).
	$sql = "SELECT DATE_ADD(datainizio_asc, INTERVAL (23 - IF(DAYOFWEEK(datainizio_asc)=1, 8, DAYOFWEEK(datainizio_asc))) DAY) AS NEXTMONDAY FROM tab_anniscolastici WHERE annoscolastico_asc = ?" ;
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $datefrom);
	while (mysqli_stmt_fetch($stmt)) {
	}
	$date = strtotime($datefrom);
	$date = strtotime("+4 day", $date);
	$dateto = date('Y-m-d', $date); //data di fine 'campionamento' per la scrittura dell'orario

	//$spreadsheet->getActiveSheet()->SetCellValue("A1", $_SESSION['anno_corrente']. " ".$datefrom." ". $dateto);
	//vengono incluse sia le ore come primo amestro che come secondo maestro
	$colonna = ["idle", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB"];
	$sql = "SELECT ID_ora, epoca_ora, data_ora, ora_ora, codmat_ora, classe_ora, sezione_ora, ID_mae_ora, firma_mae_ora, assente_ora, supplente_ora, datafirma_ora, argomento_ora, compitiassegnati_ora, ".
	" CONCAT (nome_mae , ' ', cognome_mae) as nomecognome_mae, descmateria_mtt, ID_mtt ".
	" FROM (tab_orario LEFT JOIN tab_anagraficamaestri ON ID_mae_ora = ID_mae) ".
	" LEFT JOIN tab_materie ON codmat_ora = codmat_mtt ".
	" WHERE (data_ora BETWEEN ? AND ? ) AND ID_mae = ? ORDER BY nomecognome_mae, data_ora, ora_ora";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ssi", $datefrom, $dateto, $ID_mae);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_ora, $epoca_ora, $data_ora, $ora_ora, $codmat_ora, $classe_ora, $sezione_ora, $ID_mae_ora, $firma_mae_ora, $assente_ora, $supplente_ora, $datafirma_ora, $argomento_ora, $compitiassegnati_ora, $nomecognome_mae, $descmateria_mtt, $ID_mtt); 
	$nomecognome_mae = preg_replace('/[^A-Za-z0-9\-]/', '', $nomecognome_mae); 
	$data_ora_prec = "1999-01-01";
	$colonna_indice = 1;
	$datagg[1] = $datefrom;
	$datagg[2] = date('Y-m-d',strtotime("+1 day", strtotime($datagg[1])));
	$datagg[3] = date('Y-m-d',strtotime("+2 day", strtotime($datagg[1])));
	$datagg[4] = date('Y-m-d',strtotime("+3 day", strtotime($datagg[1])));
	$datagg[5] = date('Y-m-d',strtotime("+4 day", strtotime($datagg[1])));

	while (mysqli_stmt_fetch($stmt)) {
			//if ($data_ora != $data_ora_prec) { $colonna_indice++;}

			for ($x = 1; $x <= 5; $x++) {
				if ($datagg[$x] == $data_ora)
				{
					$colonna_indice = $x;
				}
			}
			if ($epoca_ora ==1 ) { $descmateria_mtt = "EPOCA";}
			$pdf->SetXY ($colonna_indice*30+15,20*$ora_ora+40);
			$pdf->SetDash(1,1); //5mm on, 5mm off
			$pdf->Cell(30,10,"classe ".$classe_ora, "B" ,0, 'C');
			$pdf->SetDash(); //Reset Dash
			$pdf->SetXY ($colonna_indice*30+15,20*$ora_ora+50);
			$pdf->Cell(30,10,$descmateria_mtt, 0 ,0, 'C');

			//$data_ora_prec = $data_ora;
	}
//FINE PAGINA ORARIO *******************************************************************************************************************

//INIZIO PAGINA VOTAZIONI **************************************************************************************************************

	//Bisogna ciclare su tutte le classi seguite dal maestro
	$sql05 = "SELECT DISTINCT classe_cma, sezione_cma FROM tab_classimaestri WHERE annoscolastico_cma = ? AND ID_mae_cma = ? ORDER BY classe_cma";
	$stmt05 = mysqli_prepare($mysqli, $sql05);
	mysqli_stmt_bind_param($stmt05, "si", $annoscolastico_cla, $ID_mae);
	mysqli_stmt_execute($stmt05);
	mysqli_stmt_bind_result($stmt05, $classe_cla, $sezione_cla);
	mysqli_stmt_store_result($stmt05);
	while (mysqli_stmt_fetch($stmt05)) {

		//verifico quante sono le pagine: estraggo intanto quanti sono i compiti nell'anno scolastico, per la classe di questo ciclo for, per l'ID_mae_cov
		$sql1 = "SELECT DISTINCT ID_cov, codmat_cov, tipo_cov, data_cov, argomento_cov, descmateria_mtt, codmat_mtt FROM tab_compitiverifiche LEFT JOIN tab_materie ON codmat_mtt =  codmat_cov WHERE classe_cov = ? AND sezione_cov = ? AND annoscolastico_cov = ? AND ID_mae_cov = ? ORDER BY codmat_cov, tipo_cov, data_cov";
		$stmt1 = mysqli_prepare($mysqli, $sql1);
		mysqli_stmt_bind_param($stmt1, "sssi", $classe_cla, $sezione_cla, $annoscolastico_cla, $ID_mae);
		mysqli_stmt_execute($stmt1);
		mysqli_stmt_bind_result($stmt1, $ID_cov, $codmat_cov, $tipo_cov, $data_cov, $argomento_cov, $descmateria_mtt, $codmat_mtt);
		mysqli_stmt_store_result($stmt1);
		$Ncompiti = mysqli_stmt_num_rows ($stmt1);

		//ora divido $compiti per $ncolonne e trovo quante $pagine dovrò emettere prendendo la parte intera del risultato + 1
		//poi costruisco un ciclo for con $pagina che va da 1 a $pagine e per ciascuna inserisco tutti i valori dal record numero $ncolonne*($pagina-1) a $ncolonne*($pagina).
		//***************Variabili di base per griglia*****************
		$startYOrVoti = 60;
		$startYOrGiudizi = 20;
		$cellH = 5; 				//altezza di ogni riga a partire dalla seconda
		$cellHIntest = 20; 			//altezza riga date (Voti)
		$cellHGiu = 8; 				//altezza di ogni riga a partire dalla seconda per pagine Giudizi
		$cellHArg = 7; 				//altezza box Argomento
		$cellHTitolo = 10; 			//altezza box classe Giudizi
		$cellW = 7.5; 				//larghezza delle celle con i voti
		$cellWGiu = 142.5;			//larghezza box Giudizi
		$col1 = 7;					//larghezza colonna numeri
		$col2 = 35;					//larghezza colonna nomi Cognomi
		$ncolonne = 20;

		$pagine = intval($Ncompiti / $ncolonne) ;
		if (($Ncompiti % $ncolonne) !=0) {$pagine = $pagine +1;}

		for ($pagina = 1; $pagina<=$pagine; $pagina++) {
			$pdf->AddPage();
			$NUMpagina++;
			
			//***************SCHEMA, SCRITTE DI BASE*****************
			
			//***************Titolo Classe*****************
			$pdf->SetFont($fontdefault,'',12);
			$pdf->Cell(0,10,"classe: ".$classe_cla." ".$sezione_cla, 0,1, 'C', true);

			//*****************Due celle con scritte*****************
			$pdf->SetFont($fontdefault,'',10);
			$pdf-> setXY(10, 30);								//posizionamento
			$testo = "Le rilevazioni si basano sugli obiettivi previsti per ciascuna disciplina/attività. Si possono annotare gli esiti delle osservazioni e delle prove (prove oggettive, interrogazioni e altri accertamenti, test di profitto...) effettuate per ogni alunno, sia a livello collettivo che individuale";
			$pdf->SetWidths(array($col1+$col2,$ncolonne*$cellW)); //uso multicell wrappable
			$pdf->Row(array("RILEVAZIONI PERIODICHE SUI PROCESSI DI APPRENDIMENTO", utf8_decode($testo)));
			
			//*****************Riga delle date*****************
			$pdf-> setXY(10, $startYOrVoti);					//posizionamento
			
			$pdf->Cell($col1,$cellHIntest,"", 0 ,0, 'C');		//Cella vuota sopra i numeri
			$pdf->Cell($col2,$cellHIntest,"Alunno", 0 ,0, 'C');	//Cella con scritta "Alunno"
			for ($j = 1; $j <= $ncolonne; $j++) {				//Griglia vuota date
				$pdf->Cell($cellW,$cellHIntest,"", 1 ,0, 'C');
			}
			
			//*****************Griglia vuota a partire dalla riga successiva alle date*****************
			$startY = $startYOrVoti + $cellHIntest;						
			for ($i = 1; $i <=33 ;$i++) {
				$pdf-> setXY(10, $startY);						//posizionamento
				$pdf->Cell($col1,$cellH,"", 1 ,0, 'C');			//cella per Numero
				$pdf->Cell($col2,$cellH,"", 1 ,0, 'C');			//cella per Nome e Cognome
				for ($j = 1; $j <= $ncolonne; $j++) {			//griglia per voti
					$pdf->Cell($cellW,$cellH,"", 1 ,0, 'C');
				}
				$startY = $startY+$cellH;
			}
			
			//*****************Riga delle materie - Contorno*****************
			$pdf-> setXY($col1+$col2+10, $startYOrVoti-10);		//posizionamento
			$pdf->Cell($ncolonne*$cellW,10,"", 1 ,0, 'C');		//cella materie
			//****************FINE SCHEMA DI BASE*********************
			
			
			
			//****************CONTENUTI********************
			//Ora inizio a popolare con i contenuti
			$startY = 45;
			//--------------metto in vari array i valori dei compiti del maestro/classe/sezione/annoscolastico (MA SERVE?)-------------
			$sql1 = "SELECT DISTINCT ID_cov, codmat_cov, tipo_cov, data_cov, argomento_cov, descmateria_mtt, codmat_mtt FROM tab_compitiverifiche LEFT JOIN tab_materie ON codmat_mtt =  codmat_cov WHERE classe_cov = ? AND sezione_cov = ? AND annoscolastico_cov = ? AND ID_mae_cov = ? ORDER BY codmat_cov, tipo_cov, data_cov";
			$stmt1 = mysqli_prepare($mysqli, $sql1);
			mysqli_stmt_bind_param($stmt1, "sssi", $classe_cla, $sezione_cla, $annoscolastico_cla, $ID_mae);
			mysqli_stmt_execute($stmt1);
			
			mysqli_stmt_bind_result($stmt1, $ID_cov, $codmat_cov, $tipo_cov, $data_cov, $argomento_cov, $descmateria_mtt, $codmat_mtt);
			$compiti = 1;
			$tipoback = " ";
			$codmat_mttback = " ";
			
			$currX1 = $col1+$col2+10;
			$currX2 = $col1+$col2+10;
			
			while (mysqli_stmt_fetch($stmt1)) {
				//c'è una riga per ogni compito, dunque inserisco in un array ID_covA gli ID dei compiti
				$ID_covA[$compiti]= $ID_cov;
				if (($compiti>(($pagina-1)*$ncolonne)) && ($compiti <=($pagina*$ncolonne))){
					$pdf->SetFont($fontdefault,'',9);
					//****************Inserisco le date RUOTATE****************
					$x = ($compiti-(intval(($compiti-1) / $ncolonne))*$ncolonne)*$cellW+$col1+$col2+9; //tolgo da $compito tutti i multipli di $ncolonne compiti che ci possono stare dentro
					
					$pdf->RotatedText($x,$startY+33,$data_cov,90);		//Data Ruotata
					
					//****************Riga delle descrizioni delle materie****************
					$pdf->SetFont($fontdefault,'',6);
					$pdf-> SetXY($currX1, $startY+5);					//posizionamento
					$cambiomat = 0;
					if ($codmat_mtt != $codmat_mttback) {				//codice materia
						$pdf->Cell($cellW, $cellH, $codmat_mtt ,"L",0,"L");
						$cambiomat = 1;
					} else {
						$pdf->Cell($cellW, $cellH, "" ,0,0,"L");
					}
					$codmat_mttback = $codmat_mtt;
					$currX1 = ($pdf-> GetX());
					
					//****************Riga delle descrizioni dei sottotipi****************
					$pdf-> SetXY($currX2, $startY+10);					//posizionamwnto
					if ($tipo_cov != $tipoback) {						//sottotipo
						$pdf->Cell($cellW, $cellH, $tipo_cov ,"L",0,"L");
					} else {
						
						if ($cambiomat ==1) {$pdf->Cell($cellW, $cellH, "" ,"L",0,"L");} else {$pdf->Cell($cellW, $cellH, "" ,0,0,"L");}
					}
					$currX2 = ($pdf-> GetX());
					$tipoback = $tipo_cov;
				
					//--------------------Ora popolo i vari Array che poi andranno riversati NON SERVER IN VERITA'----------------
					//$codmat_covA[$compiti] = $codmat_cov;
					//$tipocovA[$compiti] = $tipo_cov;
					//$datacov[$compiti] = $data_cov;
					//$argomento_covA[$compiti] = $argomento_cov;
				}
				$compiti++;
			}
			
			
			$pdf->SetFont($fontdefault,'',10);
			//--------------metto in vari array i valori degli alunni della classe (non serve qui filtrare anche sul maestro)---------------
			$sql2 = "SELECT DISTINCT ID_alu, nome_alu, cognome_alu FROM (tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) WHERE annoscolastico_cla = ? AND classe_cla = ? AND sezione_cla = ? AND listaattesa_cla = 0 ORDER BY cognome_alu";
			$stmt2 = mysqli_prepare($mysqli, $sql2);
			mysqli_stmt_bind_param($stmt2, "sss", $annoscolastico_cla, $classe_cla, $sezione_cla);
			mysqli_stmt_execute($stmt2);
			mysqli_stmt_bind_result($stmt2, $ID_alu, $nome_alu, $cognome_alu);
			$alunni = 1;
			
			while (mysqli_stmt_fetch($stmt2)) {
				//****************Nomi e Cognomi Alunni****************
				$ID_aluA[$alunni]= $ID_alu;
				$pdf-> setXY($col1 + 4, $startY+30+$alunni*$cellH);			//posizionamento
				$pdf->Cell($cellW -2, $cellH, $alunni ,0,0,"R");			//numero alunni
				$pdf-> setXY($col1 +10, $startY+30+$alunni*$cellH);			//posizionamento
				if (strlen( $nome_alu." ".$cognome_alu) > 21) {				//nome e cognome
					$pdf->Cell($cellW, $cellH, substr($nome_alu." ".$cognome_alu, 0, 20)."..." ,0,0,"L");
				} else {
					$pdf->Cell($cellW, $cellH, $nome_alu." ".$cognome_alu ,0,0,"L");
				}
				$alunni++;
			}
			$pdf->SetFont($fontdefault,'',9);
			//ora compito per compito entro dentro tab_voticompitiverifiche e estraggo i voti da mettere nell'excel. Sembra la modalità più SICURA per non sbagliare con indici vari visto che molti compiti potrebbero non avere ancora valutazione (-> in tab_voticompitiverifiche non ci sarebbe un record per ogni alunno!)
			//se questa modalità risultasse onerosa si può anche estrarre tutti i valori dei voti e mettere ANCHE QUESTI in array (dei quali alcuni valori saranno nulli) e poi popolare il file excel ciclando sugli array
			//$pdf->Cell(20,20,"alunni".$alunni, 1 ,0, 'C');
			//$pdf->Cell(20,30,"pagina".$pagina, 1 ,0, 'C');
			//$pdf->Cell(20,40,"ncolonne".$ncolonne, 1 ,0, 'C');
			

			for ($compito = 1+($pagina-1)*$ncolonne; $compito <= min(($pagina*$ncolonne),($compiti-1)); $compito++) {
				$row =  ($rigabase+4);
				$top = 80;
				for ($alunno = 1; $alunno <= ($alunni-1); $alunno++) {
					$voto_vcc = "";
					$sql3 = "SELECT voto_vcc FROM tab_voticompitiverifiche WHERE ID_cov_vcc = ?  AND id_alu_vcc = ? ";
					$stmt3 = mysqli_prepare($mysqli, $sql3);
					mysqli_stmt_bind_param($stmt3, "ii", $ID_covA[$compito], $ID_aluA[$alunno]);
					mysqli_stmt_execute($stmt3);
					mysqli_stmt_bind_result($stmt3, $voto_vcc);
					while (mysqli_stmt_fetch($stmt3)) {
					}
					if ($voto_vcc != "") {
						//**************Voti Compiti per ciascun alunno****************
						
						$x = ($compito-(intval(($compito-1) / $ncolonne))*$ncolonne)*$cellW+$col1+$col2+4; //tolgo da $compito tutti i multipli di $ncolonne compiti che ci possono stare dentro
						
						$pdf-> setXY($x, $top);								//posizionamento
						if ($voto_vcc == '10.0') { $voto_vcc = 10;}
						$pdf->Cell($cellW-1, $cellH, $voto_vcc,0,0,"C"); 	//voto
					}
					$top = $top + $cellH;
				}
			}
		
			
			//------------FIRME------------------

			$pdf->SetFont($fontdefault,'',12);
			$indicetimbro = rand(1,9);
			$pdf->Image('assets/img/timbri/timbro'.$codscuola.'/timbro'.$indicetimbro.'.png', 135, 250, 20);
			$pdf->SetXY (15,250);
			$pdf->Cell(60,10,"Data e Luogo", 0 ,0, 'C');
			$pdf->SetXY (135,250);
			$pdf->Cell(60,10,"Firma dell'Insegnante", 0 ,1, 'C');
			
			$pdf->SetDash(1,1); //5mm on, 5mm off
			$pdf->SetXY (15,260);
			$pdf->Cell(60,10,"", "B" ,0, 'C');
			$pdf->SetXY (135,260);
			$pdf->Cell(60,10,"", "B" ,0, 'C');
			$pdf->SetDash(); //Restore dash

			//pagina intermedia
			$pdf->AddPage();
			$NUMpagina++;

		}







		//Sono dentro un ciclo PER OGNI CLASSE
		//ora per ogni compito di questa classe va creata una pagina con i giudizi

		if ($mostragiudizi == 1) {

			//verifico quante sono le pagine: estraggo intanto quanti sono i compiti nell'anno scolastico, per la classe di questo ciclo for, per l'ID_mae_cov
			$sql1 = "SELECT DISTINCT ID_cov, codmat_cov, tipo_cov, data_cov, argomento_cov, descmateria_mtt, codmat_mtt FROM tab_compitiverifiche LEFT JOIN tab_materie ON codmat_mtt =  codmat_cov WHERE classe_cov = ? AND sezione_cov = ? AND annoscolastico_cov = ? AND ID_mae_cov = ? ORDER BY codmat_cov, tipo_cov, data_cov";
			$stmt1 = mysqli_prepare($mysqli, $sql1);
			mysqli_stmt_bind_param($stmt1, "sssi", $classe_cla, $sezione_cla, $annoscolastico_cla, $ID_mae);
			mysqli_stmt_execute($stmt1);
			mysqli_stmt_bind_result($stmt1, $ID_cov, $codmat_cov, $tipo_cov, $data_cov, $argomento_cov, $descmateria_mtt, $codmat_mtt);
			mysqli_stmt_store_result($stmt1);
			while (mysqli_stmt_fetch($stmt1)) {
			
				$pdf->AddPage();

				//***************SCHEMA, SCRITTE DI BASE*****************
				
				//***************Titolo Classe*****************
				$pdf->SetFont($fontdefault,'',12);
				$pdf->Cell(0,$cellHTitolo,"classe: ".$classe_cla." ".$sezione_cla, 0,1, 'C', true);
				
				//*****************Riga intestazione *****************
				$pdf-> setXY(10, $startYOrGiudizi);					//posizionamento
				
				$pdf->Cell($col1,$cellHArg,"", 0 ,0, 'C');			//Cella vuota sopra al numero
				$pdf->Cell($col2,$cellHArg,"Alunno", 0 ,0, 'C');	//Cella con scritta "Alunno"
				$pdf->Cell($cellW,$cellHArg,"", 0 ,0, 'C');			//Cella vuota sopra al voto
				$pdf->Cell($cellWGiu,$cellHArg,"", 1 ,0, 'C');		//Cella per Titolo Compito e data
				
				//*****************Griglia vuota a partire dalla riga successiva alle intestazioni*****************
				$startY = $startYOrGiudizi+$cellHArg;
				for ($i = 1; $i <=28 ;$i++) {
					$pdf-> setXY(10, $startY);						//posizionamento
					
					$pdf->Cell($col1,$cellHGiu,"", 1 ,0, 'C');		//cella per Numero
					$pdf->Cell($col2,$cellHGiu,"", 1 ,0, 'C');		//cella per Nome Cognome
					$pdf->Cell($cellW,$cellHGiu,"", 1 ,0, 'C');		//cella per voto
					$pdf->Cell($cellWGiu,$cellHGiu,"", 1 ,0, 'C');	//cella per giudizio
					$startY = $startY+$cellHGiu;
				}
				
				//****************FINE SCHEMA DI BASE*********************
				//****************CONTENUTI ******************************
				$pdf->SetFont($fontdefault,'',10);

				$pdf-> setXY(10+$col1+$col2+$cellW, $startYOrGiudizi); 												//posizionamento
				$pdf->Cell($cellWGiu,$cellHArg,$argomento_cov." del ".timestamp_to_ggmmaaaa($data_cov), 1 ,0, 'C');	//argomento
				$startY = 2;

				mysqli_stmt_execute($stmt2);
				mysqli_stmt_store_result($stmt2);
				$alunni = 1;
				while (mysqli_stmt_fetch($stmt2)) {
					//****************Nomi e Cognomi Alunni****************
					$ID_aluA[$alunni]= $ID_alu;
					$pdf-> setXY($col1 + 4, $startY+$cellHTitolo+$cellHArg+$alunni*$cellHGiu);		//posizionamento
					$pdf->Cell($cellW -2, $cellHGiu, $alunni ,0,0,"R");								//numero alunno
					$pdf-> setXY($col1 +10, $startY+$cellHTitolo+$cellHArg+$alunni*$cellHGiu);		//posizionamento
					if (strlen( $nome_alu." ".$cognome_alu) > 21) {									//nome e cognome
						$pdf->Cell($col2, $cellHGiu, substr($nome_alu." ".$cognome_alu, 0, 20)."..." ,0,0,"L");
					} else {
						$pdf->Cell($col2, $cellHGiu, $nome_alu." ".$cognome_alu ,0,0,"L");
						
					}

					$sql03 = "SELECT voto_vcc, giudizio_vcc FROM tab_voticompitiverifiche WHERE ID_cov_vcc = ?  AND ID_alu_vcc = ? ";
					$stmt03 = mysqli_prepare($mysqli, $sql03);
					mysqli_stmt_bind_param($stmt03, "ii", $ID_cov, $ID_alu);
					mysqli_stmt_execute($stmt03);
					mysqli_stmt_bind_result($stmt03, $voto_vcc, $giudizio_vcc);
					while (mysqli_stmt_fetch($stmt03)) {
						if ($voto_vcc == '10.0') { $voto_vcc = 10;}
						$pdf->Cell($cellW, $cellHGiu, $voto_vcc,0,0,"L"); 							//voto
						$pdf->SetFont($fontdefault,'',8);

						$pdf->MultiCell($cellWGiu,4,utf8_decode($giudizio_vcc),0,'L');				//giudizio
						$pdf->SetFont($fontdefault,'',10);
					}

					$alunni++;
				}
				//****************FINE CONTENUTI **************************
			}

		}

	}
//FINE VOTAZIONI


//ARGOMENTI TRATTATI*******************************

	$sql25 = "SELECT datainizio_asc, datafine_asc FROM tab_anniscolastici WHERE annoscolastico_asc = ? ";
	$stmt25 = mysqli_prepare ($mysqli, $sql25);
	mysqli_stmt_bind_param($stmt25, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt25);
	mysqli_stmt_bind_result($stmt25, $datainizio_asc, $datafine_asc);
	while (mysqli_stmt_fetch($stmt25)) {
	}

	$sql3 = "SELECT data_ora, ora_ora, codmat_ora, descmateria_mtt, classe_ora, sezione_ora, firma_mae_ora, assente_ora, supplente_ora, maestroreale_ora, argomento_ora, compitiassegnati_ora FROM tab_orario LEFT JOIN tab_materie ON codmat_ora = codmat_mtt WHERE id_mae_ora = ? AND (data_ora >= ? AND data_ora <= ? ) ORDER BY classe_ora, data_ora, classe_ora";

	$stmt3 = mysqli_prepare($mysqli, $sql3);
	mysqli_stmt_bind_param($stmt3, "iss", $ID_mae, $datainizio_asc, $datafine_asc);
	mysqli_stmt_execute($stmt3);
	mysqli_stmt_bind_result($stmt3, $data_ora, $ora_ora, $codmat_ora, $descmateria_mtt, $classe_ora, $sezione_ora, $firma_mae_ora, $assente_ora, $supplente_ora, $maestroreale_ora, $argomento_ora, $compitiassegnati_ora);

	$pdf->SetWidths(array(25, 10, 10, 30, 95)); 

	$cellH = 5;
	$topstart = 40;
	$top = $topstart;
	$left = 20;
	$pageH = 250;
	$pdf->SetFont($fontdefault,'',10);
	$pdf->AddPage();
	$pdf->SetXY (0,10);
	$pdf->Cell(210,10,"Argomenti Insegnati", 0 ,0, 'C');
	$NUMpagina++;
	$pdf->SetXY (0,260);
	$pdf->Cell(210,10,$NUMpagina, 0 ,0, 'C');
	$pdf-> setXY($left, $top);
	$pdf->Row(array('DATA', 'CL.', 'ASS.', 'MATERIA', 'ARGOMENTO INSEGNATO'));
	$pdf->SetFont($fontdefault,'',10);
	$pdf-> setX($left);

	while (mysqli_stmt_fetch($stmt3)) {
		if ($assente_ora == 1) {$assenza = "X";} else {$assenza="";}
		$pdf->Row(array($data_ora, $classe_ora, $assenza, $descmateria_mtt, utf8_decode($argomento_ora)));
		$currY = ($pdf-> GetY());
		if ($currY >= $pageH) {
			$pdf->AddPage();
			$pdf->SetXY (0,10);
			$pdf->SetFont($fontdefault,'',10);
			$pdf->Cell(210,10,"Argomenti Insegnati", 0 ,0, 'C');
			$NUMpagina++;
			$pdf->SetXY (0,260);
			$pdf->Cell(210,10,$NUMpagina, 0 ,0, 'C');
			$top = $topstart;
			$pdf-> setXY($left, $top);
			$pdf->SetFont($fontdefault,'',8);
			$pdf->Row(array('DATA', 'CL.', 'ASS.', 'MATERIA', 'ARGOMENTO INSEGNATO'));
			$pdf->SetFont($fontdefault,'',10);
			$currY = ($pdf-> GetY());
			$top = $currY;
		} else {
			$top = $currY;
		}
		$pdf-> setXY($left, $top);
	}

//FINE ARGOMENTI TRATTATI






////FINE PAGINA/E *****************************************************************************************************************************************
//pagina front e della seconda di Copertina (vuota)
$pdf->AddPage();
//Seconda di Copertina ************************************************************************************************************************************
$pdf->AddPage();
$pdf->SetDrawColor(91,42,127);
$pdf->Rect(10,10,190,275);
$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->Rect(12,12,186,271);
$pdf->SetDash();
$pdf->SetTextColor(92,42,127);

//Intestazione Scuola
$pdf->SetFont('TitilliumWeb-SemiBold','',16);
include("12intestazionescuolaA3.php");


$pdf->Output();
?>










