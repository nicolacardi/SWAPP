<?include_once("database/databaseii.php");

	$ID_alu_lda = $_POST['ID_alu_lda'];
	$annoscolastico_lda = $_POST['annoscolastico_lda'];
	$classe_lda = $_POST['classe_lda'];
	$sezione_lda = $_POST['sezione_lda'];
	
	$dataStep0 = $_POST['dataStep0'];


	if ($dataStep0 != "") { 
		$dataStep0 = str_replace('/', '-', $dataStep0);
		$dataStep0 = date('Y-m-d', strtotime($dataStep0));
	} else {
		$dataStep0 = '1900-01-01';
	}

	$modalita0_lda = $_POST['modalita0_lda'];
	
	$noteFinali = addslashes($_POST['noteFinali']);
	
	$accolto = intval($_POST['accolto']);

	
	//verifico se c'è già un primo inserimento per l'alunno ID_alu_cla perchè questo determina se si tratta di una UPDATE o di una INSERT
	
	$sql = "SELECT ID_lda FROM tab_listadattesa WHERE ID_alu_lda = ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_alu_lda);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_lda);
	$k=0;
	while (mysqli_stmt_fetch($stmt)) {						
	$k++;
	}
				
	if ($k != 0) {
		//caso update
		$sql1 = "UPDATE tab_listadattesa SET
		ID_alu_lda = ?,
		annoscolastico_lda =?,
		classe_lda = ?,
		sezione_lda = ?,
		notefinali_lda = ?,
		data0_lda = ?,
		modalita0_lda = ?,
		
		accolto_lda = ?
		WHERE ID_lda = ? ";


		$stmt1 = mysqli_prepare($mysqli, $sql1);
		mysqli_stmt_bind_param($stmt1, "issssssii", $ID_alu_lda, $annoscolastico_lda, $classe_lda, $sezione_lda, $noteFinali, $dataStep0, $modalita0_lda,  $accolto, $ID_lda);	
		mysqli_stmt_execute($stmt1);
	} else {
		$sql1 = "INSERT INTO tab_listadattesa (
		ID_alu_lda, 
		annoscolastico_lda, 
		classe_lda, 
		sezione_lda, 
		notefinali_lda, 
		data0_lda,
        modalita0_lda, 
		accolto_lda) 
		VALUES (?, 
		?, 
		?, 
		?, 
		?, 
		?, 
		?, 
		?)";


		$stmt1 = mysqli_prepare($mysqli, $sql1);
		mysqli_stmt_bind_param($stmt1, "issssssi", $ID_alu_lda, $annoscolastico_lda, $classe_lda, $sezione_lda, $noteFinali, $dataStep0, $modalita0_lda, $accolto);
		mysqli_stmt_execute($stmt1);
	}
	


	$return['sql'] = $sql;
	$return['sql1'] = $sql1;
	$return['test'] = $k;
	$return['test2'] = $incontrocon1;

     echo json_encode($return);
?>
