<?include_once("database/databaseii.php");
	$ID_pag = $_POST['ID_pag'];

	$sql1 = "DELETE FROM tab_pagamenti WHERE ID_pag = ? ;";
	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1, "i", $ID_pag);
	mysqli_stmt_execute($stmt1);

	$causale_pag = $_POST['causale_pag'];
	$ID_ret_pag = $_POST['ID_ret_pag'];

	//Porto qui dentro l'update della tabella tab_mensilirette
	if ($causale_pag == 1) {

		//ora SE causale_pag = 1 (si tratta delle rette di un mese) calcolo il nuovo totale e faccio l'update in tabella tab_mensilirette
		$sql2 = "SELECT SUM(importo_pag) as totalePag FROM tab_pagamenti WHERE ID_ret_pag = ? ";
		$stmt2 = mysqli_prepare($mysqli, $sql2);
		mysqli_stmt_bind_param($stmt2, "i", $ID_ret_pag);
		mysqli_stmt_execute($stmt2);
		mysqli_stmt_bind_result($stmt2, $totalePag);
		while (mysqli_stmt_fetch($stmt2)) {
		}

		$sql3 = "UPDATE tab_mensilirette SET pagato_ret = ? WHERE ID_ret = ?";
		$stmt3 = mysqli_prepare($mysqli, $sql3);
		mysqli_stmt_bind_param($stmt3, "ii", $totalePag, $ID_ret_pag);	
		mysqli_stmt_execute($stmt3);

	}


	$return['test'] = $sql1;
    echo json_encode($return);
?>
