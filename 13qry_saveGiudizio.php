<?
    include_once("database/databaseii.php");

	$ID_alu_vcc = intval($_POST['ID_alu_vcc']);
	$ID_cov_vcc = intval($_POST['ID_cov_vcc']);
	$giudizio = $_POST['giudizio'];

	//verifico anzitutto che l'alunno non fosse assente il giorno della verifica
	if ($giudizio != "") {
		$sql2 = "SELECT data_cov, codmat_cov, tipo_cov, argomento_cov FROM tab_compitiverifiche WHERE id_cov = ?; ";
		$stmt2 = mysqli_prepare($mysqli, $sql2);
		mysqli_stmt_bind_param($stmt2, "i", $ID_cov_vcc );
		mysqli_stmt_execute($stmt2);
		mysqli_stmt_bind_result($stmt2, $data_cov, $codmat_cov, $tipo_cov, $argomento_cov);
		while (mysqli_stmt_fetch($stmt2)) {
		}
		$return['datacov'] = $data_cov;
		$return['materia'] = $codmat_cov;
		$return['tipo'] = $tipo_cov;
		//ora data_cov è la data del compito
		$sql3 = "SELECT id_ass FROM tab_assenze WHERE tipo_ass = 0 AND id_alu_ass = ? AND data_ass  = ?; ";
		$stmt3 = mysqli_prepare($mysqli, $sql3);
		mysqli_stmt_bind_param($stmt3, "is", $ID_alu_vcc, $data_cov );
		mysqli_stmt_execute($stmt3);
		mysqli_stmt_bind_result($stmt3, $id_ass);
		$assenze = 0 ;
		while (mysqli_stmt_fetch($stmt3)) {
			$assenze++;
		}
		if ($assenze !=0) {
			$return['alunnoassente'] = 1;
		} else {
			$return['alunnoassente'] = 0;
		}
		//$return['voto'] = $voto_vcc;
	}

	
	$sql2 = "SELECT ID_cov_vcc FROM tab_voticompitiverifiche WHERE ID_alu_vcc = ? AND ID_cov_vcc = ?";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "ii", $ID_alu_vcc, $ID_cov_vcc );
	mysqli_stmt_execute($stmt2);
	mysqli_stmt_bind_result($stmt2, $ID_cov_vcc);
	$record = 0 ;
	while (mysqli_stmt_fetch($stmt2)) {
		$record++;
	}

	if ($record == 0) {
		$sql3 = "INSERT INTO tab_voticompitiverifiche 
		SET giudizio_vcc = ?, 
		ID_alu_vcc = ?, 
		ID_cov_vcc = ? ";
		$stmt3 = mysqli_prepare($mysqli, $sql3);
		mysqli_stmt_bind_param($stmt3, "sii", $giudizio, $ID_alu_vcc, $ID_cov_vcc );	
		mysqli_stmt_execute($stmt3);
	} else {
		$sql3 = "UPDATE tab_voticompitiverifiche
		SET giudizio_vcc = ? 
		WHERE ID_alu_vcc = ? AND ID_cov_vcc = ?";
		$stmt3 = mysqli_prepare($mysqli, $sql3);
		mysqli_stmt_bind_param($stmt3, "sii", $giudizio, $ID_alu_vcc, $ID_cov_vcc );	
		mysqli_stmt_execute($stmt3);
	}
	
	echo json_encode($return);
?>
