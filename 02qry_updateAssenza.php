<?include_once("database/databaseii.php");

	//questa routine va a impostare come ASSENTE o PRESENTE l'alunno per tutto il giorno,
	//dall'ora che viene passata in avanti
	$data_ass = $_POST['data_ass'];
	$ora_ass_da = $_POST['ora_ass'];
	$ID_alu_ass =  $_POST['ID_alu_ass'];
	$annoscolastico = $_POST['annoscolastico'];
	$assDAD = $_POST['assDAD'];
	

//ESTRAZIONE ORE DA AGGIORNARE ********************************/
//estraggo la classe e sezione
	$sql2 = "SELECT classe_cla, sezione_cla FROM tab_classialunni 
	WHERE ID_alu_cla = ? 
	AND annoscolastico_cla = ? ;";
	
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "is", $ID_alu_ass, $annoscolastico);	
	mysqli_stmt_execute($stmt2);
	mysqli_stmt_bind_result($stmt2, $classe_cla, $sezione_cla);
	while (mysqli_stmt_fetch($stmt2)) {
	}

	//ora che ho classe e sezione vado a trovare in tab_orario quali ore ci sono in quella data
	//ATTENZIONE ALLE ORE CON DOPPIO MAESTRO O TUTOR!!! per questo si fa una DISTINCT su ora_ora, infatti le ore di tutoraggio o doppie comunque hanno la stessa ora_ora:
	//la distinct fa sì che se ne calcoli una sola
	$sql3 = "SELECT DISTINCT ora_ora FROM tab_orario
	WHERE classe_ora = ? 
	AND sezione_ora = ? 
	AND data_ora = ? ;";
	
	$stmt3 = mysqli_prepare($mysqli, $sql3);
	mysqli_stmt_bind_param($stmt3, "sss", $classe_cla, $sezione_cla, $data_ass);	
	mysqli_stmt_execute($stmt3);
	mysqli_stmt_bind_result($stmt3, $ora_ora);
	$ore=0;
	$oreA = array();
	while (mysqli_stmt_fetch($stmt3)) {
		//per le ore da rendere assenti/presenti inserisco in un array di n (= ore) elementi il numero delle ore, ad esempio: $oreA = [3,5,7] con $ore = 3.
		if ($ora_ora >= $ora_ass_da) {array_push($oreA,$ora_ora);} 			
		$ore++;
	}
//FINE ESTRAZIONE ORE DA AGGIORNARE ****************************/

		//trova se c'è già un record (assenza o DAD) per l'ora "da"
		$sql = "SELECT ID_ass, tipo_ass FROM tab_assenze 
		WHERE 
		ID_alu_ass = ? 
		AND data_ass = ? 
		AND ora_ass = ? ";
		
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "isi", $ID_alu_ass, $data_ass, $ora_ass_da);	
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $ID_ass, $tipo_ass);
		$c = 0;
		while (mysqli_stmt_fetch($stmt)) {
			$c++;
		}		


		//le possibilità sono:

		//è presente no DAD ->    c=0

		//è presente in DAD	->    c<>0  tipo_ass ==2

		//è assente ->			  c<>0  tipo_ass ==0

		if ($assDAD == 0) {  //assDAD == 0 significa che sto impostando una assenza o presenza: -> lavoro su tutti i record da quell'ora in avanti

			//INTANTO CANCELLO TUTTE LE ASSENZE E LE DAD DA QUEST'ORA IN AVANTI
			$sql1 = "DELETE FROM tab_assenze 
			WHERE 
			ID_alu_ass = ? 
			AND data_ass = ? 
			AND ora_ass >= ? ";
			$stmt1 = mysqli_prepare($mysqli, $sql1);
			mysqli_stmt_bind_param($stmt1, "isi", $ID_alu_ass, $data_ass, $ora_ass_da);	
			mysqli_stmt_execute($stmt1);



			if ($c == 0) {  					//attualmente era presente ma non in DAD nell'ora "da" -> imposto l'assenza da quest'ora in avanti
				foreach ($oreA as $ora_ass) {
					$sql = "INSERT INTO tab_assenze 
					SET 
					tipo_ass = ?,
					ID_alu_ass = ?, 
					data_ass = ?, 
					ora_ass = ? ";
					$stmt = mysqli_prepare($mysqli, $sql);
					mysqli_stmt_bind_param($stmt, "iisi", $assDAD, $ID_alu_ass, $data_ass, $ora_ass);	
					mysqli_stmt_execute($stmt);
				}
			}
	
	
			if ($c != 0 && $tipo_ass == 2) {  	//attualmente era presente e in DAD nell'ora "da" -> imposto l'assenza da quest'ora in avanti
				foreach ($oreA as $ora_ass) {
					$sql = "INSERT INTO tab_assenze 
					SET 
					tipo_ass = ?,
					ID_alu_ass = ?, 
					data_ass = ?, 
					ora_ass = ? ";
					$stmt = mysqli_prepare($mysqli, $sql);
					mysqli_stmt_bind_param($stmt, "iisi", $assDAD, $ID_alu_ass, $data_ass, $ora_ass);	
					mysqli_stmt_execute($stmt);
				}
			}
	
			if ($c != 0 && $tipo_ass == 0) {  	//attualmente era assente nell'ora "da" -> non devo fare nulla, ho già eliminato l'assenza
	
			}
			
		}


		if ($assDAD == 2) {  //assDAD == 2 significa che sto impostando una DAD o togliendola: -> lavoro sulla sola ora che sto modificando

			//INTANTO CANCELLO TUTTE LE ASSENZE E LE DAD DELLA SOLA ORA "DA"
			$sql1 = "DELETE FROM tab_assenze 
			WHERE 
			ID_alu_ass = ? 
			AND data_ass = ? 
			AND ora_ass = ? ";
			$stmt1 = mysqli_prepare($mysqli, $sql1);
			mysqli_stmt_bind_param($stmt1, "isi", $ID_alu_ass, $data_ass, $ora_ass_da);	
			mysqli_stmt_execute($stmt1);


			if ($c == 0) {  					//attualmente era presente ma non in DAD nell'ora "DA" -> imposto la DAD in quest'ora
				$sql = "INSERT INTO tab_assenze 
				SET 
				tipo_ass = ?,
				ID_alu_ass = ?, 
				data_ass = ?, 
				ora_ass = ? ";
				$stmt = mysqli_prepare($mysqli, $sql);
				mysqli_stmt_bind_param($stmt, "iisi", $assDAD, $ID_alu_ass, $data_ass, $ora_ass_da);	
				mysqli_stmt_execute($stmt);
			}
	
	
			if ($c != 0 && $tipo_ass == 2) {  	//attualmente era presente e in DAD nell'ora "DA" -> non devo fare nulla , ho già eliminato la DAD con la DELETE
			}
	
			if ($c != 0 && $tipo_ass == 0) {  	//attualmente era assente nell'ora "DA" -> imposto la DAD in quest'ora
				$sql = "INSERT INTO tab_assenze 
				SET 
				tipo_ass = ?,
				ID_alu_ass = ?, 
				data_ass = ?, 
				ora_ass = ? ";
				$stmt = mysqli_prepare($mysqli, $sql);
				mysqli_stmt_bind_param($stmt, "iisi", $assDAD, $ID_alu_ass, $data_ass, $ora_ass_da);	
				mysqli_stmt_execute($stmt);
			}
			
		}



//***************************COSI FUNZIONA MA LAVORA SU TUTTE LE ORE SUCCESSIVE SIA PER ASSENZA CHE PER DAD->NON VA BENE*/



		// $sql1 = "DELETE FROM tab_assenze 
		// WHERE 
		// ID_alu_ass = ? 
		// AND data_ass = ? 
		// AND ora_ass >= ? ";
		// $stmt1 = mysqli_prepare($mysqli, $sql1);
		// mysqli_stmt_bind_param($stmt1, "isi", $ID_alu_ass, $data_ass, $ora_ass_da);	
		// mysqli_stmt_execute($stmt1);


		
		// if ($c == 0) {  					//attualmente è presente non in DAD
		// 	if ($assDAD == 0) { 			//->voglio metterlo assente
		// 		foreach ($oreA as $ora_ass) {
		// 			$sql = "INSERT INTO tab_assenze 
		// 			SET 
		// 			tipo_ass = ?,
		// 			ID_alu_ass = ?, 
		// 			data_ass = ?, 
		// 			ora_ass = ? ";
		// 			$stmt = mysqli_prepare($mysqli, $sql);
		// 			mysqli_stmt_bind_param($stmt, "iisi", $assDAD, $ID_alu_ass, $data_ass, $ora_ass);	
		// 			mysqli_stmt_execute($stmt);
		// 		}

		// 	} else {						//->voglio metterlo in DAD
		// 		foreach ($oreA as $ora_ass) {
		// 			$sql = "INSERT INTO tab_assenze 
		// 			SET 
		// 			tipo_ass = ?,
		// 			ID_alu_ass = ?, 
		// 			data_ass = ?, 
		// 			ora_ass = ? ";
		// 			$stmt = mysqli_prepare($mysqli, $sql);
		// 			mysqli_stmt_bind_param($stmt, "iisi", $assDAD, $ID_alu_ass, $data_ass, $ora_ass);	
		// 			mysqli_stmt_execute($stmt);
		// 		}
		// 	}

		// }


		// if ($c != 0 && $tipo_ass == 2) {  	//attualmente è in DAD
		// 	if ($assDAD == 0) { 			//voglio metterlo assente
		// 		foreach ($oreA as $ora_ass) {
		// 			$sql = "INSERT INTO tab_assenze 
		// 			SET 
		// 			tipo_ass = ?,
		// 			ID_alu_ass = ?, 
		// 			data_ass = ?, 
		// 			ora_ass = ? ";
		// 			$stmt = mysqli_prepare($mysqli, $sql);
		// 			mysqli_stmt_bind_param($stmt, "iisi", $assDAD, $ID_alu_ass, $data_ass, $ora_ass);	
		// 			mysqli_stmt_execute($stmt);
		// 		}

		// 	} else {						//voglio togliere la DAD-> metterlo presente non in DAD
		// 		//OK non devo fare nulla
		// 	}

		// }

		// if ($c != 0 && $tipo_ass == 0) {  	//attualmente è assente
		// 	if ($assDAD == 0) { 			//voglio metterlo presente non in DAD
		// 		//OK non devo fare nulla
		// 	} else {						//voglio metterlo in DAD
		// 		foreach ($oreA as $ora_ass) {
		// 			$sql = "INSERT INTO tab_assenze 
		// 			SET 
		// 			tipo_ass = ?,
		// 			ID_alu_ass = ?, 
		// 			data_ass = ?, 
		// 			ora_ass = ? ";
		// 			$stmt = mysqli_prepare($mysqli, $sql);
		// 			mysqli_stmt_bind_param($stmt, "iisi", $assDAD, $ID_alu_ass, $data_ass, $ora_ass);	
		// 			mysqli_stmt_execute($stmt);
		// 		}
		// 	}

		// }


	


	$return['sql'] = $sql3;
	$return['classe'] = $classe_cla;
	$return['sezione'] = $sezione_cla;
	$return['ore'] = $oreA;

	
	echo json_encode($return);
?>
