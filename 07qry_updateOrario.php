<?include_once("database/databaseii.php");
	//classe_ora: classe_ora, sezione_ora: sezione_ora, dateGGHH: dateGGHH, GH : GH
	$classe_ora = $_POST['classe_ora'];
	$sezione_ora = $_POST['sezione_ora'];
	$GH = $_POST['GH']; //in questo array sono contenute le materie selezionate per ciascun giorno/ora
	$epocaA = $_POST['epocaA'];
	$dateGGHH = $_POST['dateGGHH'];
	$numore = $_POST['numore'];
	//$numore = 7;
	//dateGH da 1 a 5 contiene le date
	//GH ha un indice j da 1 a 5 per le date e un indice i da 1 a numore per le ore
	$x = 0;
	$y = 0;
	for ($i = 1; $i <= $numore; $i++) {
		for ($j = 1; $j <= 5; $j++) {
			$codmat_ora = $GH[$j*10+$i];
			if($epocaA[$j*10+$i] == "true") { $epoca = 1;} else { $epoca = 0;};
			//if ($codmat_ora == "nomat") {
				//se trova nomat non deve scrivere nulla in database*************************
			//} else {
				//mi serve l'anno perchè ID_mae dipende anche dall'anno scolastico!
				//in alternativa serve una select anno scolastico ma non avrebbe senso: a cosa serve selezionare l'anno scolastico se già ho la data?
				//per ora scrivo '2018-19'
				$dataj = $dateGGHH[$j];
				$annoj = substr($dataj,0,4);
				$mesej = substr($dataj,5,2);
				if (intval($mesej) < 8) {$annoj = intval($annoj) -1;}
				$annojsucc=$annoj+1;
				$annojsucc = strval($annojsucc);
				$annojsucc = substr($annojsucc, -2);
				$annoscolastico_cma = $annoj."-".$annojsucc;
				//trovo l'ID_mae da inserire o aggiornare
				$sql = "SELECT ID_mae_cma FROM tab_classimaestri WHERE tutordi_cma =  0  AND classe_cma = ? AND sezione_cma = ? AND annoscolastico_cma = ? AND codmat_cma = ? ;";
				$stmt = mysqli_prepare($mysqli, $sql);
				mysqli_stmt_bind_param($stmt, "ssss", $classe_ora, $sezione_ora, $annoscolastico_cma, $codmat_ora);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $ID_mae_cma);
				$maestri=0;
				while (mysqli_stmt_fetch($stmt)) {
					$maestri++;
				}
				if ($maestri == 0) {
					//non ci sono maestri inseriti per questa materia quindi non vado a inserire nulla
					//$nome_maeA[$j*10+$i] = " ";
					//$cognome_maeA[$j*10+$i] = " ";
					$ID_mae_cma = 0;
				}
				//trovo se già ci sono record per la classe la sezione l'ora e la data valorizzati in questo ciclo
				$sql1 = "SELECT ID_ora, codmat_ora, IDfirmatutor_ora, secondomaestro_ora FROM tab_orario WHERE classe_ora = '".$classe_ora."' AND sezione_ora ='".$sezione_ora."' AND ora_ora = ".$i." AND data_ora = '".$dateGGHH[$j]."' ";
				$stmt1 = mysqli_prepare($mysqli, $sql1);
				mysqli_stmt_execute($stmt1);
				mysqli_stmt_bind_result($stmt1, $ID_ora, $codmat_oraPrec, $IDfirmatutor_ora, $secondomaestro_ora);
				$orari = 0;
				mysqli_stmt_store_result($stmt1);
				while (mysqli_stmt_fetch($stmt1)) {
					$orari++;
					//se la materia che vado ad inserire  è diversa dalla precedente (codmat_oraPrec<> codmat_ora) 
					//se non è nomat
					//se la riga che sto oservando non è quella di un secondomaestro ######### NO! QUESTA CONDIZIONE NO PERCHè SE E' IL TUTOR DI UN SECONDO MAESTRO??
					//allora devo cancellare l'eventuale tutor presente, che ha proprio ID = IDfirmatuttor_ora
					//altrimenti rischio di trovarmi con un tutor per esempio di matematica , ma con l'ora di italiano...situazione che determina un'impasse
					//in quanto il tutor non si può più nemmeno vedere ma c'è e quindi il bollino resta rosso: in sostanza non si può nè togliere nè modificare il bollino rosso, almeno per la parte di tutoraggio
					if (($codmat_oraPrec != $codmat_ora) &&  ($codmat_ora != 'nomat') && ($IDfirmatutor_ora != 0)) {
						$cambiomateriaA[$x] = $codmat_ora;
						$cancelloIDoraA[$x] = $IDfirmatutor_ora;
						$x++;
	
							$sql3 = "DELETE FROM tab_orario WHERE ID_ora = ? ;";
							$stmt3 = mysqli_prepare($mysqli, $sql3);
							mysqli_stmt_bind_param($stmt3, "i", $IDfirmatutor_ora);
							mysqli_stmt_execute($stmt3);

							$sql3 = "UPDATE tab_orario SET IDfirmatutor_ora = 0 WHERE ID_ora = ? ;";
							$stmt3 = mysqli_prepare($mysqli, $sql3);
							mysqli_stmt_bind_param($stmt3, "i", $ID_ora);
							mysqli_stmt_execute($stmt3);
	
					}


				}



				//se non ce ne sono è una insert
				if ($orari == 0) {
					//$sql2 ="INSERT INTO tab_orario (data_ora, ora_ora, codmat_ora, classe_ora, sezione_ora, ID_mae_ora, secondomaestro_ora) ".
					//" VALUES ('".$dateGGHH[$j]."', ".$i.", '".$codmat_ora."', '".$classe_ora."', '".$sezione_ora."', ".$ID_mae_cma." , 0) ;";
					$sql2 ="INSERT INTO tab_orario (data_ora, epoca_ora, ora_ora, codmat_ora, classe_ora, sezione_ora, ID_mae_ora, secondomaestro_ora) ".
					" VALUES ('".$dateGGHH[$j]."', ".$epoca.", ".$i.", '".$codmat_ora."', '".$classe_ora."', '".$sezione_ora."', ".$ID_mae_cma." , 0) ;";
				} else {
				//altrimenti è una UPDATE
					//$sql2 ="UPDATE tab_orario SET codmat_ora = '".$codmat_ora."' , ID_mae_ora = ".$ID_mae_cma.
					//" WHERE secondomaestro_ora = 0 AND classe_ora = '".$classe_ora."' AND sezione_ora ='".$sezione_ora."' AND ora_ora = ".$i." AND data_ora = '".$dateGGHH[$j]."' ;";
					$sql2 ="UPDATE tab_orario SET codmat_ora = '".$codmat_ora."' , ID_mae_ora = ".$ID_mae_cma." , epoca_ora = ".$epoca.
					" WHERE secondomaestro_ora = 0 AND classe_ora = '".$classe_ora."' AND sezione_ora ='".$sezione_ora."' AND ora_ora = ".$i." AND data_ora = '".$dateGGHH[$j]."' ;";
				}
				$stmt2 = mysqli_prepare($mysqli, $sql2);
				mysqli_stmt_execute($stmt2);
				$return['test'] = $cambiomateriaA;
				$return['test1'] = $cancelloIDoraA;
				
				$return['ID_mae_cma'] = $ID_mae_cma;
				//$return['nome_maeA'] = $nome_maeA;
				//$return['cognome_maeA'] = $cognome_maeA;
			//}
		}
	}
	echo json_encode($return);
?>
