<?include_once("database/databaseii.php");
	$ID_tit = $_POST['ID_tit'];
	$nome_tit = $_POST['nome_tit'];
	$desc_tit = $_POST['desc_tit'];
	$data_tit = $_POST['data_tit'];
	$data_tit = date('Y-m-d', strtotime(str_replace('/','-', $data_tit)));
	$scad_tit = $_POST['scad_tit'];
	$scad_tit = date('Y-m-d', strtotime(str_replace('/','-', $scad_tit)));
	$ckformagg_tit = $_POST['ckformagg_tit'];
	$sql2 = "UPDATE tab_titolimaestri SET nome_tit = ?, desc_tit = ? , data_tit = ?, scad_tit = ?, ckformagg_tit = ? WHERE ID_tit = ?";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "sssssi", $nome_tit, $desc_tit, $data_tit, $scad_tit, $ckformagg_tit, $ID_tit);
	mysqli_stmt_execute($stmt2);
	//$return['msg'] = "Inserimento andata a buon fine";
	//$return['sql2'] = $sql2;
    echo json_encode($return);
?>
