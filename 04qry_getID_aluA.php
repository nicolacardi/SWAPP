<?	include_once("database/databaseii.php");

	$annoscolastico = $_POST['annoscolastico'];
	$where_hidden = $_POST['where_hidden'];
	//ord_cls ASC, sezione_cla ASC, cognome_alu ASC,


	$sql = "SELECT ID_alu, cognome_alu, nome_alu FROM (tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla ) LEFT JOIN tab_classi ON classe_cla = classe_cls WHERE annoscolastico_cla = ? ".$where_hidden." ORDER BY ord_cls, sezione_cla, cognome_alu, nome_alu;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_alu, $cognome_alu, $nome_alu);
	$ID_aluA = array();
	$cognome_aluA =  array();
	$nome_aluA = array();
	$n=0;
	while (mysqli_stmt_fetch($stmt)) {
		$ID_aluA[$n]= $ID_alu;
		$cognome_aluA[$n] =  $cognome_alu;
		$nome_aluA[$n] = $nome_alu;
		$n++;
	}

	$return['ID_aluA'] = $ID_aluA;
	$return['cognome_aluA'] = $cognome_aluA;
	$return['nome_aluA'] = $nome_aluA;

    echo json_encode($return);
?>
