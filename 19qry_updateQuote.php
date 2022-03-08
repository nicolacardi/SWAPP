<?include_once("database/databaseii.php");
	$ID_alu = $_POST['ID_alu']; //E' l'ID dell'alunno che stiamo osservando
	$annoscolastico_ret = $_POST['annoscolastico_ret'];
	
	//trova nome, cognome, ID famiglia e data di nascita di $ID_alu
	$sql = "SELECT nome_alu, cognome_alu, ID_fam_alu, datanascita_alu FROM tab_anagraficaalunni WHERE ID_alu = ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_alu);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $nome_alu, $cognome_alu, $ID_fam_alu, $datanascita_alu );
	while (mysqli_stmt_fetch($stmt)) {
	}
	
	//estraggo tutti gli eventuali fratelli di $ID_alu, escludendo lui dalla query
	$sql = "SELECT ID_alu, datanascita_alu FROM tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla WHERE annoscolastico_cla = ? AND ID_fam_alu = ? AND ID_alu <> ? ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "sii", $annoscolastico_ret, $ID_fam_alu, $ID_alu);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_alufratello, $datanascita_fratello);
	$maggiore = true;
	$fratelli = 1;	//parto comunque da 1, e aggiungo se ci sono ulteriori fratelli
	$gemelli =  false;
	$ID_alugemello = 0;
	while (mysqli_stmt_fetch($stmt)) {
		$fratelli++;
		if ($datanascita_fratello<$datanascita_alu) {$maggiore = false;} 	//confronto la data di nascita per capire se è il maggiore
		if ($datanascita_fratello==$datanascita_alu) { 						//il caso dei gemelli merita attenzione particolarmente
			$gemelli = true;												//se gemelli attivo il flag gemelli
			$ID_alugemello = $ID_alufratello;								//mi segno l'ID del gemello
		}
	}
	//a questo punto $fratelli contiene il numero di fratelli (1 se figlio unico) inoltre $maggiore è true se $ID_alu è il fratello maggiore
	//il caso dei gemelli è molto complesso perchè UNO va segnato con retta piena e UNO no
	
	//estraggo la classe alla quale bisogna iscrivere $ID_alu
	$sql = "SELECT classe_cla FROM tab_classialunni WHERE annoscolastico_cla = ? AND ID_alu_cla = ? ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "si", $annoscolastico_ret, $ID_alu);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $classe_cla );
	while (mysqli_stmt_fetch($stmt)) {
	}

	//estraggo la quotafigliounico e la quotafratello della classe appena estratta dalla tabella delle classi che contiene, appunto anche le quote
	$sql = "SELECT quotafigliounico_cls, quotafratello_cls FROM tab_classi WHERE classe_cls = ?;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $classe_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $quotafigliounico_cls, $quotafratello_cls );
	while (mysqli_stmt_fetch($stmt)) {
	}

	//Si chiamerà $quotacalcolata quella stimata in base alle verifiche di fratelli & C
	//si chiamerà $quotaconcordata quella eventualmente già presente in database A con la quale andremo a confrontare questa quota
	
	//se ha fratelli e non è il maggiore la sua quota calcolata mensile è quella da fratello
	//altrimenti (se figlio unico o maggiore) la sua quota calcolata mensile è quella da figlio unico
	if (($fratelli != 1) && ($maggiore == false)) {
		$quotacalcolataMese = $quotafratello_cls; 		//se ci sono dei fratelli e non è il maggiore prendo come quota quella del minore
	} else {
		$quotacalcolataMese = $quotafigliounico_cls;	//se ci sono dei fratelli ed è il maggiore prendo come quota quella del figlio unico
	}

	//il caso dei gemelli è un po' più complicato e va a sovrascrivere la quotacalcolataMESE appena valutata
	if (($gemelli == true )) {
		//se sono gemelli allora bisogna vedere se è stato già inserito il valore di quotapromessa per il gemello
		$sql = "SELECT quotapromessa_alu FROM ".$_SESSION['databaseB'].".tab_anagraficaalunni WHERE ID_alu = ? ";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "i", $ID_alugemello);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $quotapromessa_alu_gemello);
		while (mysqli_stmt_fetch($stmt)) {
		}

		//se la quota promessa è ancora 0 vuol dire che quello corrente è il primo di due gemelli che sto inserendo
		//quindi va impostata la quota del fratello maggiore e viceversa
		if ($quotapromessa_alu_gemello ==0) {
			$quotacalcolataMese = $quotafigliounico_cls; 	//la quota promessa non è stata ancora inserita in Db B per il gemello: assegno la quota da figlio unico
		} else {
			$quotacalcolataMese = $quotafratello_cls;		//la quota promessa è stata già inserita per il gemello: assegno la quota da secondo fratello
		}
	}

	//$quotacalcolataannua = $quotacalcolata *10 ;
	
	//Tutto quanto sopra potrei anche evitarlo estraendo dal database la somma delle quote default
	//Infatti ogni alunno deve già essere stato "calcolato" prima di lanciargli la mail di iscrizione...
	//Quindi dentro le quote default dovrei già trovare quanto dovuto.
	
	
	//finora ho trovato quotacalcolataMESE in vari modi (figlio unico, fratello minore, gemello...)
	
	//ora estraggo la stessa identica quota dal database A tab_mensilirette dove magari è già stata inserita una quota concordata diversa
	$sql = "SELECT concordato_ret FROM tab_mensilirette WHERE annoscolastico_ret = ? AND ID_alu_ret = ? ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "si", $annoscolastico_ret, $ID_alu);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $concordato_ret);
	$concordato_retTOT = 0;
	$diversidazero = 0;
	while (mysqli_stmt_fetch($stmt)) {
		$concordato_retTOT = $concordato_retTOT + $concordato_ret;
		if ($concordato_ret !=0 ) {$diversidazero++;}
	}


	if ($diversidazero == 12) {
		$ratepromesse_alu = 12;
	} else {
		$ratepromesse_alu = 10;
	}
	
	
	//a questo punto ho quotacalcolataMese che arriva dalla tabella quote
	//e concordato_retTOT che contiene la quota annua eventualmente già presente in database (o sempre presente in database)
	if ($concordato_retTOT != ($quotacalcolataMese*10)) {
		//Se ho trovato delle quote concordate allora la somma di quelle vado ad inserire in databaseB
		$quotacalcolataannua = $concordato_retTOT; //ATTENZIONE!!!!!******PER ORA INIBISCO L'INSERIMENTO DELLE QUOTE CONCORDATE!!!!!*******
		//$quotacalcolataannua = $quotacalcolata*10; //PER ATTIVARE LE QUOTE CONCORDATE COMMENTARE QUESTA LINEA E DECOMMENTARE LA PRECEDENTE!!!
		$quotaconcordata = 1;//COMUNQUE INSERISCO IL FLAG CHE LA QUOTA SAREBBE CONCORDATA
	} else{
		//Altrimenti vado a inserire la quota calcolata in base a tutti gli algoritmi e moltiplicata per 10
		$quotacalcolataannua = $quotacalcolataMese*10;
		$quotaconcordata = 0;
	}
		
	
	
	//aggiorno databaseB con la quota così trovata
	//dunque in databaseB inserisco la quota DEFAULT
	$sql2 = "UPDATE ".$_SESSION['databaseB'].".tab_anagraficaalunni SET quotapromessa_alu = ?, ratepromesse_alu = ? , quotaconcordata_alu = ? WHERE ID_alu = ?;";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "iiii", $quotacalcolataannua, $ratepromesse_alu, $quotaconcordata, $ID_alu);
	mysqli_stmt_execute($stmt2);
	

	
	
	$return['quotacalcolata'] = $quotacalcolataannua;
	$return['quotapromessa_alu_gemello'] = $quotapromessa_alu_gemello;
	$return['concordato_retTOT'] = $concordato_retTOT;
	$return['quotacalcolataMese'] =$quotacalcolataMese;
	$return['impostata'] =  $quotacalcolataannua;
	$return['ID_fam_alu'] = $ID_fam_alu;
	$return['annoscolastico_ret'] = $annoscolastico_ret;
	$return['ID_alu'] = $ID_alu;
	$return['sql'] = $sql;
	$return['maggiore'] = $maggiore;
	$return['datanascita_alu'] = $datanascita_alu;
	$return['datanascita_fratello'] = $datanascita_fratello;
	$return['numfratelli'] = $fratelli;

	$return['classe_cla'] = $classe_cla;
	$return['nome_alu'] = $nome_alu;
	$return['cognome_alu'] = $cognome_alu;
	$return['responso'] = "";
	$return['quotaconcordata'] = $quotaconcordata;
	$return['concordatoretTOT'] =  $concordato_retTOT;
	if (($fratelli != 1) && ($maggiore == false)) {$return['responso'] = ' e questo non è il fratello maggiore';}
	if (($fratelli != 1) && ($maggiore == true)) {$return['responso'] = ' ma questo è il fratello maggiore';}
	

	
	echo json_encode($return);
?>

