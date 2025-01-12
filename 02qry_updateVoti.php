<?include_once("database/databaseii.php");
	
	//non so come facesse funzionare MA non essendoci più i tappi 
	//non andava a verificare se i voti già c'erano e come faceva a inserirne uno nuovo se non c'era?
	//ho aggiunto tutto il controllo del fatto che il record  in tab_classialunnivoti ci sia o meno
	//a seconda di quello che trova si comporta
	
	$ID_alu_cla = $_POST['ID_alu_cla'];
	$annoscolastico_cla = $_POST['annoscolastico_cla'];
	$codmat_cla =  $_POST['codmat_cla'];
	$quadrimestre = $_POST['quadrimestre'];
	$vot_cla = $_POST['vot_cla'];
	$classe_cla = $_POST['classe_cla'];
	$sezione_cla = $_POST['sezione_cla'];
	$aselme_cla = $_POST['aselme_cla'];

	if ($vot_cla == "") { $vot_cla = "0";}
	
	$giu_cla = addslashes($_POST['giu_cla']);
	$commento_cla = addslashes($_POST['commento_cla']);
	$ggassenza_cla = $_POST['ggassenza_cla'];
	$datapagella_cla = $_POST['datapagella_cla'];
	$datapagella_cla = date('Y-m-d', strtotime(str_replace('/','-', $datapagella_cla)));
	$hafreq_cla = $_POST['hafreq_cla'];
	$ammesso_cla= $_POST['ammesso_cla'];
	$giuquad_cla= addslashes($_POST['giuquad_cla']);
	
	
	//UPDATE di tab_classialunnivoti   e se il voto non c'è?????? una volta c'erano i tappi e adesso???? devo fare un check e stabilire se devo inserire un record!!!
	//e per i voti obiettivi? stessa cosa

	$ID_cla = 0;
	$sql = "SELECT ID_cla FROM tab_classialunnivoti WHERE ID_alu_cla = ? AND annoscolastico_cla = ? AND codmat_cla = ? ;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "iss", $ID_alu_cla, $annoscolastico_cla, $codmat_cla);	
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_cla);
	while (mysqli_stmt_fetch($stmt)) {
	}

	if ($ID_cla == 0) {
		$sql2 = "INSERT INTO tab_classialunnivoti SET ".
		" vot".$quadrimestre."_cla = '".$vot_cla."' ,".
		" giu".$quadrimestre."_cla = '".$giu_cla."' ,".
		" commento".$quadrimestre."_cla = '". $commento_cla."' ,".
		" ID_alu_cla =". $ID_alu_cla." ,".
		" annoscolastico_cla ='". $annoscolastico_cla."' , ".
		" codmat_cla ='". $codmat_cla."' ,".
		" classe_cla ='". $classe_cla."' ,".
		" sezione_cla ='". $sezione_cla."' ,".
		" aselme_cla ='". $aselme_cla."' ;";
		$stmt2 = mysqli_prepare($mysqli, $sql2);
		mysqli_stmt_execute($stmt2);
	} else {
		$sql2 = "UPDATE tab_classialunnivoti SET ".
		" vot".$quadrimestre."_cla = '".$vot_cla."' ,".
		" giu".$quadrimestre."_cla = '".$giu_cla."' ,".
		" commento".$quadrimestre."_cla = '". $commento_cla."' ".
		" WHERE ID_cla = ? ";
		$stmt2 = mysqli_prepare($mysqli, $sql2);
		mysqli_stmt_bind_param($stmt2, "i", $ID_cla);	
		mysqli_stmt_execute($stmt2);
	}
	
	//UPDATE di tab_classialunni
	if ($quadrimestre == 2) {
		//se è il secondo quadrimestre che sto aggiornando devo inserire anche il valore di hafreq_cla e ammesso_cla
		$updateAdd = " hafreq_cla = ".$hafreq_cla." , ".
		" ammesso_cla = ".$ammesso_cla." , ";
	} else {
		$updateAdd = "";

	}
	
	$sq1 = "UPDATE tab_classialunni SET ".
	$updateAdd.
	" datapagella".$quadrimestre."_cla = '". $datapagella_cla."' , ".
	" ggassenza".$quadrimestre."_cla = ". $ggassenza_cla." , ".
	" giuquad".$quadrimestre."_cla = '". $giuquad_cla."' ".
	" WHERE ID_alu_cla = ? ".
	" AND annoscolastico_cla = ? ";

	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1, "is", $ID_alu_cla, $annoscolastico_cla);	
	mysqli_stmt_execute($stmt1);

	$return['sql'] = $sql;
	$return['sql2'] = $sql2;
	$return['sql1'] = $sql1;
	// $return['sql1'] = $sql1;
	$return['ID_cla']= $ID_cla;
	// $return['annoscolastico_cla']= $annoscolastico_cla;
	// $return['codmat_cla']= $codmat_cla;
	// $return['quadrimestre']= $quadrimestre;
	// $return['vot_cla']= $vot_cla;
	// $return['giu_cla']= $giu_cla;
	// $return['commento_cla']= $commento_cla;
	// $return['datapagella']= $datapagella_cla;
	// $return['hafreq_cla']= $hafreq_cla;

	
	echo json_encode($return);
?>
