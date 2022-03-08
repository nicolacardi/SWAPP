<?include_once("database/databaseii.php");
	$classe = $_POST['classe'];
	$sezione = $_POST['sezione'];
	if ($classe == '0') { $classeAND = '';} else { $classeAND = " AND classe_ora  = '".$classe."'";}
	if ($sezione == '0') { $sezioneAND = '';} else { $sezioneAND = " AND sezione_ora  = '".$sezione."'";}
	//unico parametro la prima data (quella del lunedi) della settimana in cui devo copiare la precedente
	$lunediCopiaA= $_POST['copiaA'];
	$venerdiCopiaA = date('Y-m-d',strtotime("+4 day", strtotime($lunediCopiaA)));
	$lunediCopiaDa = $_POST['copiaDa'];
	//$lunediPrec = date('Y-m-d',strtotime("-7 day", strtotime($lunediCorr)));
	//$venerdiPrec = date('Y-m-d',strtotime("-3 day", strtotime($lunediCorr)));
	
	//prima cancello tutto quello che c'è in ogni singolo giorno della settimana corrente, così poi posso fare una INSERT e non devo preoccuparmi se si tratta di una UPDATE
	$sql1 = "DELETE FROM tab_orario WHERE data_ora BETWEEN ? AND ? ".$classeAND.$sezioneAND;
	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1, "ss", $lunediCopiaA, $venerdiCopiaA);
	mysqli_stmt_execute($stmt1);

	//ora copio e incollo cambiando la data tutti gli orari che ci sono
	for ($giorno = 0; $giorno <= 4; $giorno++) {
		$giornoCopiaDa = date('Y-m-d',strtotime("+".$giorno." day", strtotime($lunediCopiaDa)));
		$giornoCopiaA = date('Y-m-d',strtotime("+".$giorno." day", strtotime($lunediCopiaA)));
		$sql2 = "INSERT INTO tab_orario (data_ora, ora_ora, epoca_ora, codmat_ora, classe_ora, sezione_ora, ID_mae_ora, firma_mae_ora, datafirma_ora, argomento_ora, compitiassegnati_ora, secondomaestro_ora)
		 SELECT '".$giornoCopiaA."', ora_ora, epoca_ora, codmat_ora, classe_ora, sezione_ora, ID_mae_ora, '0', '1900-01-01', '', '', secondomaestro_ora 
		 FROM tab_orario WHERE data_ora = ? ".$classeAND.$sezioneAND;
		$stmt2 = mysqli_prepare($mysqli, $sql2);
		mysqli_stmt_bind_param($stmt2, "s", $giornoCopiaDa);
		mysqli_stmt_execute($stmt2);
	}

	//BONIFICA IDtutor_ora

	//ora devo occuparmi del fatto che nei record incollati POTREBBERO esserci dei tutoring, i quali hanno questa particolarità:
	//nel record della materia principale c'è l'ID del record di tab_orario dove sta il tutor
	//esempio
	// ID_ora	codmat_ora 	..	.. tutorID_ora
	// 12560	MAT						13158
	// .....
	// 13158	TUX						0
	// dunque torno nella settimana appena incollata e pesco i record con materia = TUX
	// allora ne prendo l'ID e lo vado a scrivere in tutorID_ora dello stesso giorno, stessa ora, stessa classe, stessa sezione ma con secondomaestro_ora = 0

	//poichè la classe a volte non viene passata uso la stessa LIKE per estrarre i dati
	//ma poi faccio l'UPDATE per forza di cose con la classe/sezione appena estratta

	$bonificaLunedi = date('Y-m-d',strtotime($lunediCopiaA));
	$bonificaVenerdi = date('Y-m-d',strtotime("+4 day", strtotime($lunediCopiaA)));
	$sql3 = "SELECT ID_ora, codmat_ora, data_ora, ora_ora, classe_ora, sezione_ora FROM tab_orario WHERE (data_ora BETWEEN ? AND ? ) AND codmat_ora = 'TUX' ".$classeAND.$sezioneAND;
	$stmt3 = mysqli_prepare($mysqli, $sql3);
	mysqli_stmt_bind_param($stmt3, "ss", $bonificaLunedi, $bonificaVenerdi);
	mysqli_stmt_bind_result($stmt3, $ID_ora, $codmat_ora, $data_ora, $ora_ora, $classe_ora, $sezione_ora);
	mysqli_stmt_execute($stmt3);
	mysqli_stmt_store_result ($stmt3);
	$n=0;
	while (mysqli_stmt_fetch($stmt3)) {
		$sql4 = "UPDATE tab_orario SET IDfirmatutor_ora = ".$ID_ora." WHERE data_ora = ? AND ora_ora = ? AND secondomaestro_ora = 0 AND classe_ora = ? AND sezione_ora = ?";
		$stmt4 = mysqli_prepare($mysqli, $sql4);
		mysqli_stmt_bind_param($stmt4, "siss", $data_ora, $ora_ora, $classe_ora, $sezione_ora);
		mysqli_stmt_execute($stmt4);
		$stmtA [$n] = $sql4;
		$datiA [$n] = $data_ora.".".$ora_ora.".".$classe_ora.".".$sezione_ora;
		$n++;
	}


	$return['test0'] = $sql1;
	$return['test'] = $sql2;
	
	$return['test2'] = $giornoCopiaDa;
	echo json_encode($return);
		
?>
