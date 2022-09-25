<?	include_once("database/databaseii.php");
	$ID_soc = $_POST['ID_soc'];

	$dataiscrizione_soc = $_POST['dataiscrizione_soc'];
    $datadisiscrizione_soc = $_POST['datadisiscrizione_soc'];

	if ($dataiscrizione_soc != '') {
		$dataiscrizione_soc = date('Y-m-d', strtotime(str_replace('/','-', $dataiscrizione_soc)));
	} else {
		$dataiscrizione_soc = NULL;
	}

	if ($datadisiscrizione_soc != '') {
		$datadisiscrizione_soc = date('Y-m-d', strtotime(str_replace('/','-', $datadisiscrizione_soc)));
	} else {
		$datadisiscrizione_soc = NULL;
	}

	$tipo_soc = intval($_POST["tipo_soc"]); 

    $sql = "UPDATE tab_anagraficasoci SET dataiscrizione_soc = ?, datadisiscrizione_soc = ?, tipo_soc = ?  WHERE ID_soc  = ? ;";

    $stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ssii", $dataiscrizione_soc, $datadisiscrizione_soc, $tipo_soc, $ID_soc);

    mysqli_stmt_execute($stmt);

	$ID_fam = $_POST['ID_fam'];
	//devo anche andare ad aggiornare in database B
	if ($ID_fam != '') {	
		
		$sql3 = "SELECT padremadre_soc FROM tab_anagraficasoci WHERE ID_soc = ?";
		$stmt3 = mysqli_prepare($mysqli, $sql3);
		mysqli_stmt_bind_param($stmt3, "i", $ID_soc);
		mysqli_stmt_execute($stmt3);
		mysqli_stmt_bind_result($stmt3, $pm);
		while (mysqli_stmt_fetch($stmt3)) {
		}

		$sql2 = "UPDATE ".$_SESSION['databaseB'].".tab_famiglie SET socio".$pm."_fam = 1 WHERE ID_fam = ?;";
		$stmt2 = mysqli_prepare($mysqli, $sql2);
		mysqli_stmt_bind_param($stmt2, "i", $ID_fam);
		mysqli_stmt_execute($stmt2);
	}

	$return['msg'] = "Dati del socio aggiornati";
	$return['test'] = $sql2;	
	$return['dataiscrizione_soc']= $dataiscrizione_soc;
	$return['datadisiscrizione_soc']= $datadisiscrizione_soc;
	$return['tipo_soc']= $tipo_soc;
	echo json_encode($return);
?>
