<?include_once("database/databaseii.php");
	//QUESTA ROUTINE NON VIENE PIU' USATA!!!
	
	//la tabella tab_pagamentialtri contiene la somma
	//di tutti i pagamenti diversi dalle rette
	//questa routine veniva utilizzata per salvarci, insieme alle rette, i valori inseriti, tramite il pulsante salva
	//ora la funzione di salvataggio rimane, tuttavia viene usata SOLO in fase di primo inserimento (durante il calcolo automatico della retta
	//di default e concordata), ma NON viene usata la parte di update della tab_pagamentialtri

	TEST PER ESCLUDERE CHE QUESTA ROUTINE FUNZIONI MAI
	
	//si presume che il record sia già presente in DB: questo perchè DEVE essere stato creato e gestito in fase di creazione della frequenza dell'alunno...
	$ID_alu = $_POST['ID_alu_ret'];
	$annoscolastico_pga = $_POST['annoscolastico_pga'];
	$pagato_pga = $_POST['pagato_pga'];
	$datapagato_pga = $_POST['datapagato_pga'];
	if ($datapagato_pga !="") {
		$DataP1 = $datapagato_pga; //la data arriva qui nel formato dd/mm/yy, ora va trasformata in yyyy-mm-dd
		list($day, $month, $year) = explode('/', $DataP1);
		$DataP3 = strtotime($month."/".$day."/20".$year);
		$DataP = date('Y-m-d', $DataP3); 
	} else {
		$DataP = '1900-01-01';
	}

	$sql = "UPDATE tab_pagamentialtri SET ".
	"pagato_pga = ? , ".
	"datapagato_pga =  ? ".
	" WHERE ID_alu_pga  = ? ".
	" AND annoscolastico_pga = ? ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "isis", $pagato_pga, $DataP, $ID_alu, $annoscolastico_pga);
	mysqli_stmt_execute($stmt);
	$return['sql']= $sql;
	echo json_encode($return);
?>
