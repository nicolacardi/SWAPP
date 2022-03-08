<?include_once("database/databaseii.php");
	$ID_alu_cla = $_POST['ID_alu_cla'];
	$annoscolastico_cla = $_POST['annoscolastico_cla'];
	$classe_cla = $_POST['classe_cla'];
	$sezione_cla = $_POST['sezione_cla'];
	$aselme_cla = $_POST['aselme_cla'];
	$codmat_cla =  $_POST['codmat_cla'];
	$quadrimestre = $_POST['quadrimestre'];
	$vot_cla = $_POST['vot_cla'];
	if ($vot_cla == "") { $vot_cla = "0";}
	//$giu_cla = addslashes(str_replace("‘", "'", str_replace("’", "'", $_POST['giu_cla'])));
	$giu_cla = addslashes(str_replace("”", "''", str_replace("“", "''", str_replace("‘", "'", str_replace("’", "'", $_POST['giu_cla'])))));

	//se il giudizio finisce con un a capo devo toglierlo, ma siccome ho messo anche addslashes mi ritrovo in quel caso con \\n alla fine quindi tolgo tutto se c'è.
	//$giu_cla = rtrim($giu_cla, "\\n");
	;
	$commento_cla = addslashes($_POST['commento_cla']);
	$ggassenza_cla = $_POST['ggassenza_cla'];
	$datapagella_cla = $_POST['datapagella_cla'];
	$datapagella_cla = date('Y-m-d', strtotime(str_replace('/','-', $datapagella_cla)));
	$hafreq_cla = $_POST['hafreq_cla'];
	$votofinale_cla = $_POST['votofinale_cla'];
	$ammesso_cla= $_POST['ammesso_cla'];
	
	$giuquad_cla = addslashes(str_replace("”", "''", str_replace("“", "''", str_replace("‘", "'", str_replace("’", "'", $_POST['giuquad_cla'])))));
	//Era una semplice UPDATE in tab_classialunnivoti in quanto all'atto dell'iscrizione venivano inseriti tanti record quante le materie:
	//Ora diventa INSERT/UPDATE a seconda che ci sia già o no il record

	$sql3 = "SELECT ID_cla from tab_classialunnivoti WHERE ".
	" ID_alu_cla = ? ".
	" AND annoscolastico_cla = ? ".
	" AND codmat_cla = ? ";
	$stmt3 = mysqli_prepare($mysqli, $sql3);
	mysqli_stmt_bind_param($stmt3, "iss", $ID_alu_cla, $annoscolastico_cla, $codmat_cla);	
	mysqli_stmt_execute($stmt3);
	mysqli_stmt_bind_result($stmt3, $ID_cla);
	$n = 0;
	while (mysqli_stmt_fetch($stmt3)) {
		$n++;
	}

	if ($n == 0) {
		$sql4 = "INSERT INTO tab_classialunnivoti (id_alu_cla, classe_cla, sezione_cla, annoscolastico_cla, aselme_cla, codmat_cla, ".
		" vot".$quadrimestre."_cla ,".
		" giu".$quadrimestre."_cla ,".
		" commento".$quadrimestre."_cla )".
		" VALUES (? , ? , ? , ? , ? , ? , ? , ? , ?)";
		$stmt4 = mysqli_prepare($mysqli, $sql4);
		mysqli_stmt_bind_param($stmt4, "issssssss", $ID_alu_cla, $classe_cla, $sezione_cla, $annoscolastico_cla, $aselme_cla, $codmat_cla, $vot_cla, $giu_cla, $commento_cla);	
		mysqli_stmt_execute($stmt4);
		$return['test'] = $sql4." ".$ID_alu_cla." ".$classe_cla." ".$sezione_cla." ".$annoscolastico_cla." ".$aselme_cla." ".$codmat_cla." ".$vot_cla." ".$giu_cla." ".$commento_cla;
	} else {
		$sql2 = "UPDATE tab_classialunnivoti SET ".
		" vot".$quadrimestre."_cla = '".$vot_cla."' ,".
		" giu".$quadrimestre."_cla = '".$giu_cla."' ,".
		" commento".$quadrimestre."_cla = '". $commento_cla."' ".
		" WHERE ID_alu_cla = ? ".
		" AND annoscolastico_cla = ? ".
		" AND codmat_cla = ? ";
		$stmt2 = mysqli_prepare($mysqli, $sql2);
		mysqli_stmt_bind_param($stmt2, "iss", $ID_alu_cla, $annoscolastico_cla, $codmat_cla);	
		mysqli_stmt_execute($stmt2);
		$return['test'] = $sql2." ".$ID_alu_cla." ".$annoscolastico_cla." ".$codmat_cla;
	}
	//UPDATE di tab_classialunni
	if ($quadrimestre == 2) {
		//se è il secondo quadrimestre che sto aggiornando devo inserire anche il valore di hafreq_cla e ammesso_cla
		$updateAdd = " hafreq_cla = ".$hafreq_cla." , ".
		" ammesso_cla = ".$ammesso_cla." , ".
		" votofinale_cla = ".$votofinale_cla." , ";
	} else {
		$updateAdd = "";
	}
	$sql = "UPDATE tab_classialunni SET ".
	$updateAdd.
	" datapagella".$quadrimestre."_cla = '". $datapagella_cla."' , ".
	" ggassenza".$quadrimestre."_cla = ". $ggassenza_cla." , ".
	" giuquad".$quadrimestre."_cla = '". $giuquad_cla."' ".
	" WHERE ID_alu_cla = ? ".
	" AND annoscolastico_cla = ? ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "is", $ID_alu_cla, $annoscolastico_cla);	
	mysqli_stmt_execute($stmt);
	$return['n'] = $n;
	$return['sql2'] = $sql2;
	$return['ID_alu_cla']= $ID_alu_cla;
	$return['annoscolastico_cla']= $annoscolastico_cla;
	$return['codmat_cla']= $codmat_cla;
	$return['quadrimestre']= $quadrimestre;
	$return['vot_cla']= $vot_cla;
	$return['giu_cla']= $giu_cla;
	$return['commento_cla']= $commento_cla;
	$return['datapagella']= $datapagella_cla;
	$return['hafreq_cla']= $hafreq_cla;
	echo json_encode($return);
?>
