<?	include_once("database/databaseii.php");
	$annoscolastico_cla = $_POST['annoscolastico'];
	$listaattesa = $_POST['listaattesa'];
	$data_limite_re = $_POST['data_limite_re'];
	$primo_giorno_re = $_POST['primo_giorno_re'];
	if ($listaattesa != "All") {
		$wherelistaattesa = " AND listaattesa_cla = ".$listaattesa." ";
	} else {
		$wherelistaattesa = " ";
	}
	$nomeclasse = array ();
	$nomesezione = array();
	$numeroalunni = array();
	$numeroalunniprima = array();
	$numeroalunniprima_2 = array();
	$numeroalunniannore = array();
	$numeromaschi = array();
	$numerofemmine = array();
	$aselme = array();
	$sql3 = "SELECT DISTINCT ID_fam FROM ((tab_anagraficaalunni LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam) LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) WHERE ritirato_cla = 0 AND annoscolastico_cla = ? ".$wherelistaattesa;
	//QUERY PARAMETRICA DA FARE - DIFFICILE
	$stmt3 = mysqli_prepare($mysqli, $sql3);
	mysqli_stmt_bind_param($stmt3, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt3);
	mysqli_stmt_bind_result($stmt3, $ID_famTMP);
	mysqli_stmt_store_result($stmt3);
	$j=0;
	while (mysqli_stmt_fetch($stmt3)) {
		$j++;
	}
	$return['numerofamiglie'] = $j;
	$sql4 = "SELECT anno1_asc, anno2_asc FROM tab_anniscolastici WHERE annoscolastico_asc = ?";
	$stmt4 = mysqli_prepare($mysqli, $sql4);
	mysqli_stmt_bind_param($stmt4, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt4);
	mysqli_stmt_bind_result($stmt4, $anno1_asc, $anno2_asc);
	while (mysqli_stmt_fetch($stmt4)) {
	}
	$annofinoal = intval($anno1_asc) - 5;
	//$datafinoal = $annofinoal."-05-31";
	$datafinoal = $annofinoal.$data_limite_re;
	$dataannore = $annofinoal."-12-31";
	$annofinoal_2 = intval($anno1_asc) - 4;
	$datafinoal_2 = $annofinoal_2.$data_limite_re;
	//la seguente query dava un problema risolvibile includendo ord_cls nei campi della select
	//si tratta probbailmente di un'impostazione di mysql ossia: ONLY_FULL_GROUP_BY è enabled
	//come spiegato qui
	// https://stackoverflow.com/questions/43584361/select-list-this-is-incompatible-with-distinct-in-my-sql
	//ecco i settings che verifico
	//in localhost dove tutto funziona:
	//in phpmyadmin con SELECT @@sql_mode ottengo : NO_ENGINE_SUBSTITUTION
	//in aruba mysql dove non funziona il risultato della stessa operazione è:
	//ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION
	//di questi il primo setting impedisce che le distinct funzionino se nella select list non si includono ANCHE i campi della order by
	//si può risolvere globalmente con SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));, ma poichè a me non funziona
	//l'unica è includere nella SELECT DISTINCT i campi che sono nella clausola ORDER BY ricordandosi però di inserire tali campi anche nella successiva mysqli_stmt_bind_result


	$sql = "SELECT DISTINCT classe_cla, sezione_cla, aselme_cla, ord_cls FROM tab_classialunni LEFT JOIN tab_classi ON classe_cla = classe_cls WHERE annoscolastico_cla = ? ".$wherelistaattesa." ORDER BY ord_cls, sezione_cla";
	//QUERY PARAMETRICA DA FARE - DIFFICILE
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $classe_cla, $sezione_cla, $aselme_cla, $ord_clsTMP);
	mysqli_stmt_store_result($stmt);
	$i=0;
	while (mysqli_stmt_fetch($stmt)) {
		$sql2 = "SELECT DISTINCT ID_alu_cla, datanascita_alu, classe_cla, mf_alu FROM tab_classialunni LEFT JOIN tab_anagraficaalunni ON ID_alu = ID_alu_cla WHERE ritirato_cla = 0 AND annoscolastico_cla =  ? AND classe_cla = ? AND sezione_cla = ? ".$wherelistaattesa;
		//QUERY PARAMETRICA DA FARE - DIFFICILE
		$stmt2 = mysqli_prepare($mysqli, $sql2);
		mysqli_stmt_bind_param($stmt2, "sss", $annoscolastico_cla, $classe_cla, $sezione_cla);	
		mysqli_stmt_execute($stmt2);
		mysqli_stmt_bind_result($stmt2, $ID_alu_cla, $datanascita_alu, $classe_cla, $mf_alu);
		mysqli_stmt_store_result($stmt2);
		$j=0;
		$prima = 0;
		$prima_2 = 0;
		$annore = 0;
		$maschi = 0;
		$femmine = 0;
		while (mysqli_stmt_fetch($stmt2)) {
			if (($classe_cla == "ASILO" || $classe_cla =="NIDO") && (strtotime($datanascita_alu) <= strtotime($datafinoal))) {$prima++;}
			if (($classe_cla == "ASILO" || $classe_cla =="NIDO") && (strtotime($datanascita_alu) > strtotime($datafinoal)) && (strtotime($datanascita_alu) <= strtotime($dataannore))) {$annore++;}
			if (($classe_cla == "ASILO" || $classe_cla =="NIDO") && (strtotime($datanascita_alu) > strtotime($datafinoal)) && (strtotime($datanascita_alu) <= strtotime($datafinoal_2))) {$prima_2++;}

			if (($mf_alu == "M")) {$maschi++;}
			if (($mf_alu == "F")) {$femmine++;}
			$j++;
		}
		$numeroalunni[$i] = $j;
		$numeromaschi[$i] = $maschi;
		$numerofemmine[$i] = $femmine;
		$numeroalunniprima [$i] = $prima;
		$numeroalunniprima_2 [$i] = $prima_2;
		$numeroalunniannore [$i] = $annore;
		$nomeclasse[$i] = $classe_cla;
		$nomesezione[$i] = $sezione_cla;
		$aselme[$i] = $aselme_cla;
		$i++;
	}
	$return['numeroclassi'] = $i-1;
	$return['numeroalunni'] = $numeroalunni;
	$return['numeromaschi'] = $numeromaschi;
	$return['numerofemmine'] = $numerofemmine;
	$return['numeroalunniprima'] = $numeroalunniprima;
	$return['numeroalunniprima_2'] = $numeroalunniprima_2;
	$return['numeroalunniannore'] = $numeroalunniannore;
	$return['nomeclasse'] = $nomeclasse;
	$return['nomesezione'] = $nomesezione;
	$return['aselme'] = $aselme;
	$return['test'] = $sql;
	echo json_encode($return);
?>
