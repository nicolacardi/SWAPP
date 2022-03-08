<?	include_once("database/databaseii.php");
	$ID_ora = $_POST['ID_ora'];
	$sql = "SELECT nome_mae, cognome_mae, classe_ora, sezione_ora, ID_mae_ora, descmateria_mtt, data_ora, ora_ora, assente_ora, supplente_ora, argomento_ora, compitiassegnati_ora, orainizio_ore, orafine_ore FROM ((tab_orario LEFT JOIN tab_anagraficamaestri ON ID_mae_ora = ID_mae) LEFT JOIN tab_materie ON codmat_ora = codmat_mtt ) LEFT JOIN tab_ore ON ora_ora = N_ore WHERE ID_ora = ?; ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_ora);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $nome_mae, $cognome_mae, $classe_ora, $sezione_ora, $ID_mae_ora, $descmateria_mtt, $data_ora, $ora_ora, $assente_ora, $supplente_ora, $argomento_ora, $compitiassegnati_ora, $orainizio_ore, $orafine_ore);
	$classi_ora = "";
	while (mysqli_stmt_fetch($stmt)) {

	}
	
	$classe_ora = "";
	$sezione_ora = "";
	//può accadere che un maestro abbia una pluriclasse. In questo caso desidero scrivere non la classe ma una stringa che concateni tutte le classi che lui ha in quella data e in quell'ora.
	//per quei casi serve, all'interno di questa while, prevedere una ulteriore SELECT con il valore corrente di data_ora e di ora_ora.
	//normalmente questa nuova SELECT restituirà una sola classe, ma per i maestri che ne hanno più nella stessa ora di una ne restituirà la concatenazione
	$sql2 = "SELECT classe_ora, sezione_ora FROM tab_orario LEFT JOIN tab_materie ON codmat_ora = codmat_mtt WHERE (data_ora = ? AND ora_ora = ?) AND (ID_mae_ora = ? OR supplente_ora = ?) ORDER BY classe_ora";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "siii", $data_ora, $ora_ora, $ID_mae_ora, $ID_mae_ora);
	mysqli_stmt_execute($stmt2);
	mysqli_stmt_bind_result($stmt2, $classe_ora2, $sezione_ora2);
	while (mysqli_stmt_fetch($stmt2)) {
		$classe_ora = $classe_ora." ".$classe_ora2." ".$sezione_ora2;
	}
		
		
		$return['nome_mae'] = $nome_mae;
		$return['cognome_mae'] = $cognome_mae;
		$return['classe_ora'] = $classe_ora;
		$return['sezione_ora'] = $sezione_ora;
		$return['ID_mae_ora'] = $ID_mae_ora;
		$return['descmateria_mtt'] = $descmateria_mtt;
		$return['data_ora'] = $data_ora;
		$return['ora_ora'] = $ora_ora;
		$return['orainizio_ore'] = $orainizio_ore;
		$return['orafine_ore'] = $orafine_ore;
		$return['assente_ora'] = $assente_ora;
		$return['supplente_ora'] = $supplente_ora;
		$return['argomento_ora'] = $argomento_ora;
		$return['compitiassegnati_ora'] = $compitiassegnati_ora;	
    echo json_encode($return);
?>
