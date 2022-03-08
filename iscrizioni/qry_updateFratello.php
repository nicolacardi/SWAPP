<? 
	include_once("../database/databaseBii.php");

	if ($_POST['ckNonIscritto'] == 'on') {
		//devo solo aggiornare campo NONiscritto che in seguito servirà, non devo aggiornare dati dell'alunno (anche perchè potrebbero essercene di vuoti)********
		$sql = "UPDATE tab_anagraficaalunni SET noniscritto_alu = 1 WHERE ID_alu = ? ";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param ( $stmt, "i", $_POST['ID_alu'] );
		mysqli_stmt_execute($stmt);
		$return['sql'] = $sql;
		$return['array'] = "array: non iscritto";	//uno dei tre campi non è stato compilato, come mando un messaggio di errore?
		$return['array2'] = "array2: non iscritto";
	} else {
		$nomecampoA = array(
		"ID_alu", 
		"nome_alu",
		"cognome_alu",
		"comunenascita_alu",
		"provnascita_alu",
		"paesenascita_alu",
		"cittadinanza_alu",
		"datanascita_alu",
		"cf_alu", 
		"indirizzo_alu",
		"citta_alu",
		"prov_alu",
		"paese_alu",
		"CAP_alu",
		"disabilita_alu",
		"DSA_alu",
		"ckprivacy1_alu",
		"ckprivacy2_alu",
		"ckprivacy3_alu",
		"ckautfoto_alu",
		"ckautmateriale_alu",
		"ckautuscite_alu",
		"scuolaprovenienza_alu",
		"indirizzoscproven_alu",
		"ckautuscitaautonoma_alu",
		"ckdoposcuola_alu",
		"ckreligione_alu",
		"altreligione_alu",
		"ckmensa_alu",
		"cktrasportopubblico_alu" 
	
	);
	
	
		$campiN = count($nomecampoA);
		
		$valcampo = array();

		for ($x = 1; $x < ($campiN); $x++) {
			$valcampo[$x] = $_POST[$nomecampoA[$x]];
			// i campi data hanno bisogno di un trattamento particolare
			if (substr ($nomecampoA[$x], 0, 4)  == "data") {$valcampo[$x] = date('Y-m-d', strtotime(str_replace('/','-', $valcampo[$x])));} //qui va convertita la data
			//e anche le input di tipo checkbox in quanto queste in un form serialized restituiscono on se sono checked e non restituiscono NIENTE altrimenti (ma si può!)
			if ($nomecampoA[$x] == "disabilita_alu") {
				if ($valcampo[$x] == 'on') { $valcampo[$x] = "1" ;} else { $valcampo[$x] = "0"; }
			}
			if ($nomecampoA[$x] == "DSA_alu") {
				if ($valcampo[$x] == 'on') { $valcampo[$x] = "1" ;} else { $valcampo[$x] = "0"; }
			} 
			//infine può accadere che vi siano dei campi di tipo radio button NON visibili in base alle opzioni di iscrizione.
			//quelli visibili vengono tutti filtrati, nel senso che non ce ne possono essere di non compilati perchè il check viene eseguito in CheckBeforeFormNext
			//Nei casi di campi non visibili qui arriva NULL. In questo caso vado a settare 0. Lo stesso faccio se il valore è -1: salvo 0.

			if (substr ($nomecampoA[$x], 0, 2)  == "ck") {
				if ($valcampo[$x] == NULL) { $valcampo[$x] = "0"; }
			}

			$setstring = $setstring. $nomecampoA[$x]." = ? , ";
		}
		$setstring = substr($setstring, 0, -2);
		
		// nome_alu = ? , cognome_alu = ? , comunenascita_alu = ? , provnascita_alu = ? , paesenascita_alu = ? , datanascita_alu = ? , cf_alu = ? , indirizzo_alu = ? , citta_alu = ? , prov_alu = ? , paese_alu = ? , CAP_alu = ? , disabilita_alu = ? , DSA_alu = ? , ckprivacy1_alu = ? , ckprivacy2_alu = ? , ckprivacy3_alu = ? , ckautfoto_alu = ? , ckautmateriale_alu = ? , ckautuscite_alu = ? , scuolaprovenienza_alu = ? , indirizzoscproven_alu = ? 


		$sql = "UPDATE tab_anagraficaalunni SET ". $setstring. " , noniscritto_alu = 0 WHERE ID_alu = ". $_POST['ID_alu'];
		//QUERY PARAMETRICA DA FARE
		$stmt = mysqli_prepare($mysqli, $sql);
		//call_user_func("mysqli_stmt_bind_param", $stmt, "isssssssssssssssi", $valcampo[$x]);
		// mysqli_stmt_bind_param ( $stmt, "ssssssssssssssssssssss", $valcampo[1], $valcampo[2], $valcampo[3], $valcampo[4], $valcampo[5], $valcampo[6], $valcampo[7], $valcampo[8], $valcampo[9], $valcampo[10], $valcampo[11], $valcampo[12], $valcampo[13], $valcampo[14], $valcampo[15], $valcampo[16], $valcampo[17], $valcampo[18], $valcampo[19], $valcampo[20] , $valcampo[21], $valcampo[22]);

		mysqli_stmt_bind_param ( $stmt, "sssssssssssssiiiiiiiissiiiiii", $valcampo[1], $valcampo[2], $valcampo[3], $valcampo[4], $valcampo[5], $valcampo[6], $valcampo[7], $valcampo[8], $valcampo[9], $valcampo[10], $valcampo[11], $valcampo[12], $valcampo[13], $valcampo[14], $valcampo[15], $valcampo[16], $valcampo[17], $valcampo[18], $valcampo[19], $valcampo[20] , $valcampo[21], $valcampo[22], $valcampo[23], $valcampo[24], $valcampo[25], $valcampo[26], $valcampo[27], $valcampo[28], $valcampo[29]);
		mysqli_stmt_execute($stmt);
		$return['sql'] = $sql;
		$return['array'] = $valcampo;	//uno dei tre campi non è stato compilato, come mando un messaggio di errore?
		$return['array2'] = $nomecampoA;
		$return['test'] = $setstring;
		$return['test2'] = $valcampo[13];
	}


	echo json_encode($return);
    
?>