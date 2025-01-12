<?	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	//questa routine serve per
	//1. verificare se la materia selezionata per la data selezionata e per l'ora selezionata appartiene a un maestro che in quella circostanza è già occupato
	//2. estrarre il nome del maestro e scriverlo sotto la select
	$codmat_mtt = $_POST['codmat_mtt'];
	$classe_ora = $_POST['classe_ora'];
	$sezione_ora = $_POST['sezione_ora'];
	$dataGG = $_POST['dataGG'];
	$ora = $_POST['ora'];
	$dataj = $dataGG;
	
	$annoscolastico_cma = getAnnoScolastico($dataj);

	//trovo il maestro per la materia in questione (usando quindi anche l'anno scolastico, la classe e la sezione)	
	//NB non devo "beccare" un maestro che sia tutor: come primo maestro mettiamo quello titolare, il tutor rappresenta il "secondo".
	$sql1 = "SELECT ID_mae_cma, nome_mae, cognome_mae FROM tab_classimaestri LEFT JOIN tab_anagraficamaestri ON ID_mae = ID_mae_cma WHERE classe_cma = ? AND sezione_cma = ? AND annoscolastico_cma = ? AND tutordi_cma = 0 AND codmat_cma = ? ;";
	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1, "ssss", $classe_ora, $sezione_ora, $annoscolastico_cma, $codmat_mtt);
	mysqli_stmt_execute($stmt1);
	mysqli_stmt_bind_result($stmt1, $ID_mae_cma, $nome_mae, $cognome_mae);
	$maestri = 0;
	while (mysqli_stmt_fetch($stmt1)) {
		$maestri++;
	}
	if ($maestri == 0 ) {
		$return['responso'] = "NO_1";
		$return['msg'] = "Maestro non ancora assegnato alla materia selezionata in classe ".$classe_ora." ".$sezione_ora ;
	} else {
		//se è stato trovato un maestro vedo se non è già impegnato in altra classe
		 $sql2 = "SELECT ID_ora, codmat_ora, classe_ora, sezione_ora FROM tab_orario WHERE ID_mae_ora  = ? AND data_ora  = ? AND ora_ora = ? ;";
		$stmt2 = mysqli_prepare($mysqli, $sql2);
		mysqli_stmt_bind_param($stmt2, "isi", $ID_mae_cma, $dataGG, $ora);
		mysqli_stmt_execute($stmt2);
		mysqli_stmt_bind_result($stmt2, $ID_ora, $codmat_ora, $classe_oraPrec, $sezione_oraPrec);
		$ID_ora = 0;
		while (mysqli_stmt_fetch($stmt2)) {
			$ID_ora++;
		}
		if ($ID_ora != 0) {
			$return['responso'] = "NO_2";
			$msg = "Il maestro ".$nome_mae." ".$cognome_mae." è già impegnato in classe ".$classe_oraPrec." ".$sezione_oraPrec;
			//$msg = $msg."<br><br>Procedere solamente nel caso in cui il maestro insegni 'contemporaneamente' in classe  ".$classe_ora." ".$sezione_ora;
			//$msg = $msg."<br><br>Cioè nel caso in cui le classi siano unite per quest'ora";
			$return['msg'] = $msg;
			//per l'ulteriore maestro non mostro tutto il messaggio ma solo una parte
			//$msg2 = "Il maestro ".$nome_mae." ".$cognome_mae." \n è già impegnato almeno in classe ".$classe_oraPrec." ".$sezione_oraPrec;
			$return['msg2'] = $msg2;
		} else {
			$return['msg'] = "Maestro disponibile in quest'ora";
			$return['responso'] = "OK";
		}
	}
	$return['ID_mae_ora'] = $ID_mae_cma;
	$return['nome_cognome_mae'] = $nome_mae." ".$cognome_mae;
	$return['test'] = $sql1;
    echo json_encode($return);
?>
