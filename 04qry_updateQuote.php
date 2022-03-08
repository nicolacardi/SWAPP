<?include_once("database/databaseii.php");
	
	$ID_alu = $_POST['ID_alu_ret'];
	$annoscolastico_ret = $_POST['annoscolastico_ret'];
	$D = array();
	$C = array();
	$P = array();
	$DataP = array();
	
	for ($x = 1; $x <= 12; $x++) {
		$D[$x] = floatval($_POST[$x.'D']);
	}
	for ($x = 1; $x <= 12; $x++) {
		$C[$x] = floatval($_POST[$x.'C']);
	}
	for ($x = 1; $x <= 12; $x++) {
		$P[$x] = floatval($_POST[$x.'P']);
	}
	
	for ($x = 1; $x <= 12; $x++) {
		$DataEstratta = $_POST[$x."Date"];
		//$DataP[$x] = $_POST[$x."Date"];
		if ($DataEstratta !="") {
		//if ( (isset ($_POST[$x.'Date'])) && !(empty($_POST[$x.'Date'])) ) {
			//$DataP1 = $DataEstratta."/".date("Y"); //serviva nel caso di formato DD/MM 
			$DataP1 = $DataEstratta; //la data arriva qui nel formato dd/mm/yy, ora va trasformata in yyyy-mm-dd
			//$DataP2 = str_replace('/','-', $DataP1); //qui diventa dd-mm-yy
			//$DataP3 = strtotime($DataP2); //qui lascio che venga interpretata come data, e potrebbe anche fallire...
			list($day, $month, $year) = explode('/', $DataP1);
			$DataP3 = strtotime($month."/".$day."/".$year);
			$DataP4 = date('Y-m-d', $DataP3); 
			$DataP[$x] = $DataP4;
		} else {
			$DataP[$x] = '1900-01-01';
		}
	}

	//$return['dt'] = $DataP1;
	$return['D'] = $DataP;
	for ($x = 1; $x <= 12; $x++) {
		$sql = "UPDATE tab_mensilirette SET ".
		"default_ret = ? , ".
		"concordato_ret = ? , ".
		"pagato_ret =  ?, ".
		"datapagato_ret =  ? ".
		" WHERE ID_alu_ret  = ? AND ".
		" mese_ret = ? AND ".
		" annoscolastico_ret = ? ";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "iiisiis", $D[$x], $C[$x] , $P[$x] , $DataP[$x], $ID_alu, $x, $annoscolastico_ret);
		mysqli_stmt_execute($stmt);
	}	
	$return['sql']= $sql;
	echo json_encode($return);
?>
