<?include_once("database/databaseii.php");
    $ID_alu = $_POST['ID_alu'];
    $tipo = $_POST['tipo'];
    $sottotipo = $_POST['sottotipo'];
    $nomescuola = $_POST['nomescuola'];
    $votoLicenzaMedia = $_POST['votoLicenzaMedia'];
    
    //INSERT in tab_consorientativo
    
	$sql = "UPDATE tab_anagraficaalunni SET ".
	" tiposcuolasucc_alu = ? ,".
	" sottotiposcuolasucc_alu = ?,".
	" nomescuolasucc_alu = ? ,".
    " votoesamiVIII_alu = ?".
    " WHERE ID_alu = ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ssssi", $tipo, $sottotipo, $nomescuola, $votoLicenzaMedia, $ID_alu);	
	mysqli_stmt_execute($stmt);
	$return['test'] = $sql;
	echo json_encode($return);
?>
