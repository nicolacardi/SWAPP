<?include_once("database/databaseii.php");
	$ID_mae_tit = $_POST['ID_mae_tit'];
	$cat_tit = $_POST['cat_tit'];
	$ckformagg_tit = $_POST['ckformagg_tit'];
	$nome_tit = $_POST['nome_tit'];
	$desc_tit = $_POST['desc_tit'];
	$data_tit = $_POST['data_tit'];
	$data_tit = date('Y-m-d', strtotime(str_replace('/','-', $data_tit)));
	$scad_tit = $_POST['scad_tit'];
	$scad_tit = date('Y-m-d', strtotime(str_replace('/','-', $scad_tit)));
	
	//verifico se c'è già un corso dello stesso maestro con lo stesso titolo ed a quello cancello la scadenza
	$sql1= "SELECT id_tit FROM tab_titolimaestri WHERE ID_mae_tit = ? AND nome_tit = ? ";
	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1, "is", $ID_mae_tit, $nome_tit);
	mysqli_stmt_execute($stmt1);
	mysqli_stmt_bind_result($stmt1, $id_tit);
	$altricorsi="nessun corso uguale presente";
	$i=0;
	while (mysqli_stmt_fetch($stmt1)) {
		$altricorsi="almeno un altro corso uguale dello stesso maestro: ne cancello la scadenza";
		$i++;
	}
	$return['msgaltricorsi'] = $altricorsi;
	$sql2= "UPDATE tab_titolimaestri SET showscad_tit= 1 WHERE ID_mae_tit = ? AND nome_tit = ? ";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "is", $ID_mae_tit, $nome_tit);
	mysqli_stmt_execute($stmt2);
	
	
	
	
	$sql3 = "INSERT INTO tab_titolimaestri (ID_mae_tit, cat_tit, nome_tit, desc_tit, data_tit, scad_tit, ckformagg_tit) VALUES (?, ?, ?, ?, ?, ?, ?)";
	$stmt3 = mysqli_prepare($mysqli, $sql3);
	mysqli_stmt_bind_param($stmt3, "issssss", $ID_mae_tit, $cat_tit, $nome_tit, $desc_tit, $data_tit, $scad_tit, $ckformagg_tit);
	mysqli_stmt_execute($stmt3);
	$return['msg'] = "Inserimento andata a buon fine";
	$return['sql2'] = $sql2;
    echo json_encode($return);
?>
