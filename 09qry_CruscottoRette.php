<?	include_once("database/databaseii.php");
	$annoscolastico_cla = $_POST['annoscolastico'];
	$listaattesa = $_POST['listaattesa'];
	if ($listaattesa != "All") {
		$wherelistaattesa = " AND listaattesa_cla = ".$listaattesa." ";
	} else {
		$wherelistaattesa = " ";
	}
	$TOTDefault_ret = array ();
	$TOTConcordato_ret = array ();
	$TOTPagato_ret = array();
	$TOTPagato_retFin =  array();
	$TOTyrDefault_ret = 0;
	$TOTyrConcordato_ret = 0;
	$TOTyrPagato_ret = 0;
	$TOTyrPagato_retFin = 0;
	for ($x = 1; $x <= 12; $x++) {

		// $sql1 = "SELECT
 
		// SUM(JOIN2.concordato_ret) AS 'TOTConcordato_ret', 
		// SUM(JOIN2.default_ret) AS 'TOTDefault_ret',  
		// SUM(JOIN2.SommaPagato) AS 'TOTPagato_ret'
		// FROM
		// (SELECT DISTINCT annoscolastico_ret, mese_ret, ID_ret, concordato_ret, default_ret, pagamenti.pagato AS SommaPagato FROM tab_mensilirette 
    	// 	LEFT JOIN (SELECT ID_ret_pag, SUM(importo_pag) AS pagato FROM `tab_pagamenti` GROUP BY ID_ret_pag ) AS pagamenti
		// 	ON pagamenti.ID_ret_pag = ID_ret 
		// 	LEFT JOIN tab_classialunni ON ID_alu_ret = ID_alu_cla
		// 	WHERE annoscolastico_ret = ? AND mese_ret = ? ".$wherelistaattesa." )
    	// AS JOIN2

		//  ";

	

		
		$sql1 = "SELECT SUM(default_ret) AS 'TOTDefault_ret', SUM(concordato_ret) AS 'TOTConcordato_ret', SUM(pagato_ret) AS 'TOTPagato_ret' FROM tab_mensilirette LEFT JOIN tab_classialunni ON ID_alu_ret = ID_alu_cla AND annoscolastico_ret = annoscolastico_cla WHERE annoscolastico_ret = ? AND mese_ret = ? ".$wherelistaattesa;
		
		//QUERY PARAMETRICA DA FARE - DIFFICILE
		$stmt1 = mysqli_prepare($mysqli, $sql1);
		mysqli_stmt_bind_param($stmt1, "si", $annoscolastico_cla, $x);
		mysqli_stmt_execute($stmt1);
		mysqli_stmt_bind_result($stmt1, $TOTDefault_retTMP, $TOTConcordato_retTMP, $TOTPagato_retTMP);
		while (mysqli_stmt_fetch($stmt1)) {
			$TOTDefault_ret[$x]  = $TOTDefault_retTMP;
			$TOTyrDefault_ret = $TOTyrDefault_ret + $TOTDefault_retTMP;
			$TOTConcordato_ret[$x]  = $TOTConcordato_retTMP;
			$TOTyrConcordato_ret = $TOTyrConcordato_ret + $TOTConcordato_retTMP;
			$TOTPagato_ret[$x]  = $TOTPagato_retTMP;
			$TOTyrPagato_ret = $TOTyrPagato_ret + $TOTPagato_retTMP;
		}
	}
	//trovo l'anno1 di annoscolastico_ret
	$sql2 = "SELECT anno1_asc, anno2_asc FROM tab_anniscolastici WHERE annoscolastico_asc = ? ";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "s", $annoscolastico_cla);
	mysqli_stmt_execute($stmt2);
	mysqli_stmt_bind_result($stmt2, $anno1_asc, $anno2_asc);
	while (mysqli_stmt_fetch($stmt2)) {
	}
	for ($x = 1; $x <= 12; $x++) {
		// $sql1 = "SELECT SUM(pagato_ret) AS 'TOTPagato_retFin' FROM tab_mensilirette LEFT JOIN tab_classialunni ON ID_alu_ret = ID_alu_cla AND annoscolastico_ret = annoscolastico_cla WHERE annoscolastico_ret = ? AND MONTH(datapagato_ret) = ? AND YEAR(datapagato_ret) = ? ".$wherelistaattesa;

		$sql1 = "SELECT SUM(importo_pag) AS 'TOTPagato_retFin' FROM tab_pagamenti JOIN tab_mensilirette ON ID_ret = ID_ret_pag LEFT JOIN tab_classialunni ON ID_alu_ret = ID_alu_cla AND annoscolastico_ret = annoscolastico_cla WHERE MONTH(data_pag) = ? AND YEAR(data_pag) = ? ".$wherelistaattesa;
		//QUERY PARAMETRICA DA FARE - DIFFICILE
		$stmt1 = mysqli_prepare($mysqli, $sql1);
		if ($x>8) {
			mysqli_stmt_bind_param($stmt1, "ii", $x, $anno1_asc);
		} else {
			mysqli_stmt_bind_param($stmt1, "ii", $x, $anno2_asc);
		}
		mysqli_stmt_execute($stmt1);
		mysqli_stmt_bind_result($stmt1, $TOTPagato_retFinTMP);
		while (mysqli_stmt_fetch($stmt1)) {
			if (is_null($TOTPagato_retFinTMP)) { $TOTPagato_retFinTMP = 0 ;}
			$TOTPagato_retFin[$x]  = $TOTPagato_retFinTMP;
			$TOTyrPagato_retFin = $TOTyrPagato_retFin + $TOTPagato_retFinTMP;
		}
	}
	$return['TOTDefault_ret'] = $TOTDefault_ret;
	$return['TOTConcordato_ret'] = $TOTConcordato_ret;
	$return['TOTPagato_ret'] = $TOTPagato_ret;
	$return['TOTPagato_retFin'] = $TOTPagato_retFin;
	$return['TOTyrDefault_ret'] = $TOTyrDefault_ret;
	$return['TOTyrConcordato_ret'] = $TOTyrConcordato_ret;
	$return['TOTyrPagato_ret'] = $TOTyrPagato_ret;
	$return['test']=$TOTPagato_retFin ;
	echo json_encode($return);
?>
