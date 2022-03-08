<?include_once("database/databaseii.php");
	$ID_alu_cla = $_POST['ID_alu_cla'];
	$annoscolastico_cla = $_POST['annoscolastico_cla'];
	$dataUscita_cla = $_POST['dataUscita_cla'];
	$dataUscita_cla = date('Y-m-d', strtotime(str_replace('/','-', $dataUscita_cla)));
	$return['result']= "NOTOK";
	$sql4 = "UPDATE tab_classialunni SET ritirato_cla = 1, dataritiro_cla = ? WHERE annoscolastico_cla = ? AND ID_alu_cla = ? ";
	$stmt4 = mysqli_prepare($mysqli, $sql4);
	mysqli_stmt_bind_param($stmt4, "ssi", $dataUscita_cla, $annoscolastico_cla, $ID_alu_cla);
	mysqli_stmt_execute($stmt4);
	$return['msg'] = "Impostazione Uscita in corso d'anno andata a buon fine";
    echo json_encode($return);
?>
