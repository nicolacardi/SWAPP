<?include_once("database/databaseii.php");

	$ID_alu_lda = $_POST['ID_alu_lda'];
	$annoscolastico_lda = $_POST['annoscolastico_lda'];
	$classe_lda = $_POST['classe_lda'];
	$sezione_lda = $_POST['sezione_lda'];
	
	$dataStep0 = $_POST['dataStep0'];
	$dataStep1 = $_POST['dataStep1'];
	$dataStep2 = $_POST['dataStep2'];
	$dataStep3 = $_POST['dataStep3'];

	if ($dataStep0 != "") { 
		$dataStep0 = str_replace('/', '-', $dataStep0);
		$dataStep0 = date('Y-m-d', strtotime($dataStep0));
	} else {
		$dataStep0 = '1900-01-01';
	}

	$modalita0_lda = $_POST['modalita0_lda'];
	
	if ($dataStep1 != "") { 
		$dataStep1 = str_replace('/', '-', $dataStep1);
		$dataStep1 = date('Y-m-d', strtotime($dataStep1));
	} else {
		$dataStep1 = '1900-01-01';
	}
	
	if ($dataStep2 != "") { 
		$dataStep2 = str_replace('/', '-', $dataStep2);
		$dataStep2 = date('Y-m-d', strtotime($dataStep2));
	} else {
		$dataStep2 = '1900-01-01';
	}

	if ($dataStep3 != "") { 
		$dataStep3 = str_replace('/', '-', $dataStep3);
		$dataStep3 = date('Y-m-d', strtotime($dataStep3));
	} else {
		$dataStep3 = '1900-01-01';
	}
	
	
	$noteStep1 = addslashes($_POST['noteStep1']);
	$noteStep2 = addslashes($_POST['noteStep2']);
	$noteStep3 = addslashes($_POST['noteStep3']);
	
	if ( !empty($_POST['incontrocon1'])) {
		$incontrocon1 = implode(",", $_POST['incontrocon1']);
	}
	if ( !empty($_POST['incontrocon2'])) {
		$incontrocon2 = implode(",", $_POST['incontrocon2']);
	}
	if ( !empty($_POST['incontrocon3'])) {
		$incontrocon3 = implode(",", $_POST['incontrocon3']);
	}
	
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
		data1_lda = ?,
		incontrocon1_lda = ?,
		note1_lda = ?,
		data2_lda = ?,
		incontrocon2_lda = ?,
		note2_lda = ?,
		data3_lda = ?,
		incontrocon3_lda = ?,
		note3_lda = ?,		
		accolto_lda = ?
		WHERE ID_lda = ? ";

		// $sqlx = "UPDATE tab_listadattesa SET
		// ID_alu_lda = ".$ID_alu_lda.",
		// annoscolastico_lda ='".$annoscolastico_lda."',
		// classe_lda = '".$classe_lda."',
		// sezione_lda = '".$sezione_lda."',
		// notefinali_lda = '".$noteFinali."',
		// data0_lda = '".$dataStep0."',
		// modalita0_lda = '".$modalita0_lda."',
		// data1_lda = '".$dataStep1."',
		// incontrocon1_lda = '".$incontrocon1."',
		// note1_lda = '".$noteStep1."',
		// data2_lda = '".$dataStep2."',
		// incontrocon2_lda = '".$incontrocon2."',
		// note2_lda = '".$noteStep2."',
		// data3_lda = '".$dataStep3."',
		// incontrocon3_lda = '".$incontrocon3."',
		// note3_lda = '".$noteStep3."',		
		// accolto_lda = ".$accolto."
		// WHERE ID_lda = ? ";

		$stmt1 = mysqli_prepare($mysqli, $sql1);
		//mysqli_stmt_bind_param($stmt1, "i", $ID_lda);
		mysqli_stmt_bind_param($stmt1, "isssssssssssssssii", $ID_alu_lda, $annoscolastico_lda, $classe_lda, $sezione_lda, $noteFinali, $dataStep0, $modalita0_lda, $dataStep1, $incontrocon1, $noteStep1, $dataStep2, $incontrocon2, $noteStep2, $dataStep3, $incontrocon3, $noteStep3, $accolto, $ID_lda);	
		mysqli_stmt_execute($stmt1);
	} else {
		//caso insert
		// $sql1 = "INSERT INTO tab_listadattesa (
		// ID_alu_lda,
		// annoscolastico_lda, 
		// classe_lda, 
		// sezione_lda, 
		// notefinali_lda, 
		// data0_lda, modalita0_lda, 
		// data1_lda, 
		// incontrocon1_lda, 
		// note1_lda, 
		// data2_lda, 
		// incontrocon2_lda, 
		// note2_lda, 
		// data3_lda, 
		// incontrocon3_lda, 
		// note3_lda, 
		// accolto_lda) 
		// VALUES (".$ID_alu_lda.", '".$annoscolastico_lda."', '".$classe_lda."', '".$sezione_lda."', '".$noteFinali."', '".$dataStep0."', '".$modalita0_lda."', '".$dataStep1."', '".$incontrocon1."', '".$noteStep1."', '".$dataStep2."', '".$incontrocon2."', '".$noteStep2."', '".$dataStep3."', '".$incontrocon3."', '".$noteStep3."', ".$accolto.")";
		$sql1 = "INSERT INTO tab_listadattesa (
		ID_alu_lda, 
		annoscolastico_lda, 
		classe_lda, 
		sezione_lda, 
		notefinali_lda, 
		data0_lda, modalita0_lda, 
		data1_lda, 
		incontrocon1_lda, 
		note1_lda, 
		data2_lda, 
		incontrocon2_lda, 
		note2_lda, 
		data3_lda, 
		incontrocon3_lda, 
		note3_lda, 
		accolto_lda) 
		VALUES (?, 
		?, 
		?, 
		?, 
		?, 
		?, 
		?, 
		?, 
		?, 
		?, 
		?, 
		?, 
		?, 
		?, 
		?, 
		?, 
		?)";

		// $sql1 = "INSERT INTO tab_listadattesa (
		// 	ID_alu_lda, 
		// 	annoscolastico_lda, 
		// 	classe_lda, 
		// 	sezione_lda, 
		// 	notefinali_lda, 
		// 	data0_lda, modalita0_lda, 
		// 	data1_lda, 
		// 	incontrocon1_lda, 
		// 	note1_lda, 
		// 	data2_lda, 
		// 	incontrocon2_lda, 
		// 	note2_lda, 
		// 	data3_lda, 
		// 	incontrocon3_lda, 
		// 	note3_lda, 
		// 	accolto_lda) 
		// 	VALUES (".$ID_alu_lda.", 
		// 	'".$annoscolastico_lda."', 
		// 	'".$classe_lda."', 
		// 	'".$sezione_lda."', 
		// 	'".$noteFinali."', 
		// 	'".$dataStep0."', 
		// 	'".$modalita0_lda."', 
		// 	'".$dataStep1."', 
		// 	'".$incontrocon1."', 
		// 	'".$noteStep1."', 
		// 	'".$dataStep2."', 
		// 	'".$incontrocon2."', 
		// 	'".$noteStep2."', 
		// 	'".$dataStep3."', 
		// 	'".$incontrocon3."', 
		// 	'".$noteStep3."', 
		// 	".$accolto.")";


		$stmt1 = mysqli_prepare($mysqli, $sql1);
		mysqli_stmt_bind_param($stmt1, "isssssssssssssssi", $ID_alu_lda, $annoscolastico_lda, $classe_lda, $sezione_lda, $noteFinali, $dataStep0, $modalita0_lda, $dataStep1, $incontrocon1, $noteStep1, $dataStep2, $incontrocon2, $noteStep2, $dataStep3, $incontrocon3, $noteStep3, $accolto);
		mysqli_stmt_execute($stmt1);
	}
	


	$return['sql'] = $sql;
	$return['sql1'] = $sql1;
	$return['test'] = $k;
	$return['test2'] = $incontrocon1;

     echo json_encode($return);
?>
