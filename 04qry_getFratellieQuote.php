<?include_once("database/databaseii.php");
	$ID_alu = $_POST['ID_alu'];
	$annoscolastico_ret = $_POST['annoscolastico_ret'];
	//la seguente variabile $quote_fratelli_diverse è un parametro impostato a 'no' oppure a 'si' in tab_parametri
	//viene estratto in index e messo in $_SESSION['quote_fratelli_diverse']
	//poi viene messo in un campo hidden che ha id= 'quote_fratelli_diverse'
	//viene quindi estratto da 04qry_Rette.php e passato a 04qry_getFratellieQuote.php
	//qui va utilizzato per dire se i fratelli (pur avendo quota ridotta)
	//hanno tra loro quota diversa ('si'/caso Padova) oppure quota uguale ('no'/caso Cittadella)
	$quote_fratelli_diverse = $_POST['quote_fratelli_diverse'];
	$sql = "SELECT nome_alu, cognome_alu, ID_fam_alu, datanascita_alu FROM tab_anagraficaalunni WHERE ID_alu = ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_alu);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $nome_alu, $cognome_alu, $ID_fam_alu, $datanascita_alu );
	while (mysqli_stmt_fetch($stmt)) {
	}
	
	//estraggo ora tutti gli eventuali fratelli di ID_alu, escludendo lui dalla query
	$sql = "SELECT ID_alu, nome_alu, datanascita_alu FROM tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla WHERE annoscolastico_cla = ? AND ID_fam_alu = ? AND ID_alu <> ? ORDER BY nome_alu";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "sii", $annoscolastico_ret, $ID_fam_alu, $ID_alu);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_alufratello, $nome_alufratello, $datanascita_fratello );
	$maggiore = true;
	$fratelli = 1;	
	$gemelli = false;
	$gemelloA = true;
	while (mysqli_stmt_fetch($stmt)) {
		$fratelli++;
		if ($datanascita_fratello<$datanascita_alu) {$maggiore = false;}
		if ($datanascita_fratello==$datanascita_alu) { 						//il caso dei gemelli merita attenzione particolarmente
			$gemelli = true;												//se c'è anche solo un gemello attivo il flag gemelli
			//scelgo che c'è UN gemello che fa da gemelloA, è quello che ha il primo nome in ordine alfabetico
			//questo è un ciclo sui gemelli, quindi devo modificare in $gemelloA = false SE se ne trova anche uno solo con un nome alfabeticamente prima di nome_alu
			if (strcmp($nome_alu, $nome_alufratello) > 0) { $gemelloA = $gemelloA && false; }
			//$ID_alugemello = $ID_alufratello;								//l'ID del gemello non mi serve
		}
	}
	
	//estraggo la classe alla quale è iscritto $ID_alu
	$sql = "SELECT classe_cla FROM tab_classialunni WHERE annoscolastico_cla = ? AND ID_alu_cla = ? ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "si", $annoscolastico_ret, $ID_alu);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $classe_cla );
	while (mysqli_stmt_fetch($stmt)) {
	}

	//estraggo la quotafigliounico e la quotafratello della classe appena estratta dalla tabella delle classi che contiene, appunto, anche le quote
	$sql = "SELECT quotafigliounico_cls, quotafratello_cls FROM tab_classi WHERE classe_cls = ?;";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $classe_cla);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $quotafigliounico_cls, $quotafratello_cls );
	while (mysqli_stmt_fetch($stmt)) {
	}


	if ($quote_fratelli_diverse == 'si') {
		//caso Padova: il maggiore ha una quota diversa dagli altri
		if (($fratelli != 1) && ($maggiore == false)) {$quotacalcolata = $quotafratello_cls; $test = 1;} else {$quotacalcolata = $quotafigliounico_cls; $test = 2;}

		//per il solo gemelloA (il primo in ordine alfabetico) imposto la quota figlio unico
		if ($fratelli !=1 && $gemelli == true) {
			if ($gemelloA == true) {$quotacalcolata = $quotafigliounico_cls; $test = 4;} else { $quotacalcolata = $quotafratello_cls; $test = 3;}
		} 

	} else {
		//caso Cittadella: tutti i fratelli hanno una quota uguale
		if ($fratelli != 1) {$quotacalcolata = $quotafratello_cls; $test= 5;} else {$quotacalcolata = $quotafigliounico_cls; $test = 6;}
	}
	
	$return['gemelli'] = $gemelli;
	$return['test'] = $test;
	$return['maggiore'] = $maggiore;
	$return['datanascita_alu'] = $datanascita_alu;
	$return['datanascita_fratello'] = $datanascita_fratello;
	$return['numfratelli'] = $fratelli;
	$return['gemelli'] = $gemelli;
	$return['gemelloA'] = $gemelloA;
	$return['quotacalcolata'] = $quotacalcolata*10;
	$return['classe_cla'] = $classe_cla;
	$return['nome_alu'] = $nome_alu;
	$return['cognome_alu'] = $cognome_alu;
	$return['responso'] = "";
	if (($fratelli != 1) && ($maggiore == false)) {$return['responso'] = ' (e questo non è il fratello maggiore)';}
	if (($fratelli != 1) && ($maggiore == true)) {$return['responso'] = ' (e questo è il fratello maggiore)';}
	if (($fratelli != 1) && ($gemelli == true) && ($gemelloA== true)) {$return['responso'] = ', ci sono dei gemelli e questo è il primo fratello; ';}
	if (($fratelli != 1) && ($gemelli == true) && ($gemelloA== false)) {$return['responso'] = ', ci sono dei gemelli e questo non è il primo fratello; ';}

	echo json_encode($return);
?>

