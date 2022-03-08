<?include_once("database/databaseii.php");
	$ID_alu_vcc = intval($_POST['ID_alu_vcc']);
	$ID_cov_vcc = intval($_POST['ID_cov_vcc']);
	$voto_vcc = $_POST['voto_vcc'];
	
	//verifico anzitutto che l'alunno non fosse assente il giorno della verifica
	if ($voto_vcc != "") {
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
					// //REPLACE works exactly like INSERT,
					// //except that if an old row in the table has the same value as a new row for a PRIMARY KEY or a UNIQUE index,
					// //the old row is deleted before the new row is inserted.
					// //in questa tabella la primary key è data da ID_alu_vcc + ID_cov_vcc
					// $sql1 = "REPLACE INTO tab_voticompitiverifiche VALUES (?, ?, ?); ";
					// //$return['sql1'] = $sql1."-".$ID_alu_vcc."-".$ID_cov_vcc."-".$voto_vcc;
					// $stmt1 = mysqli_prepare($mysqli, $sql1);
					// mysqli_stmt_bind_param($stmt1, "iii", $ID_alu_vcc, $ID_cov_vcc, $voto_vcc );
					// mysqli_stmt_execute($stmt1);
	
	$sql2 = "SELECT ID_cov_vcc FROM tab_voticompitiverifiche WHERE ID_alu_vcc = ? AND ID_cov_vcc = ?";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "ii", $ID_alu_vcc, $ID_cov_vcc );
	mysqli_stmt_execute($stmt2);
	mysqli_stmt_bind_result($stmt2, $ID_cov_vccB);
	$record = 0 ;
	while (mysqli_stmt_fetch($stmt2)) {
		$record++;
	}

	$voto_vcc = floatval($voto_vcc); //VA TRASFORMATO DA STRINGA A DECIMALE: ATTENZIONE poi va caricato con mysqli_stmt_bind_param: "d"

	if ($record == 0) {
		$sql4 = "INSERT INTO tab_voticompitiverifiche SET voto_vcc = ?, ID_alu_vcc = ?, ID_cov_vcc = ? ;";
		$stmt4 = mysqli_prepare($mysqli, $sql4);
		mysqli_stmt_bind_param($stmt4, "dii", $voto_vcc, $ID_alu_vcc, $ID_cov_vcc );	
		mysqli_stmt_execute($stmt4);
	} else {
		$sql3 = "UPDATE tab_voticompitiverifiche SET voto_vcc = ? WHERE ID_alu_vcc = ? AND ID_cov_vcc = ?";
		$stmt3 = mysqli_prepare($mysqli, $sql3);
		mysqli_stmt_bind_param($stmt3, "dii", $voto_vcc, $ID_alu_vcc, $ID_cov_vcc );	
		mysqli_stmt_execute($stmt3);
	}
	
	echo json_encode($return);
?>
