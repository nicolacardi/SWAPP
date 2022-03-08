<?	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("classi/alunni.php");

	$ID_mae = $_POST['ID_mae'];
	$annoscolastico_cla = $_POST['annoscolastico_cla'];
	
	for ($x = 1; $x <= 4; $x++) {
		$campo[$x] = $_POST['campo'][$x];
		//se il campo è del tipo tab_classialunni.classe_cla devo estrarre solo la seconda parte
		if (strpos($campo[$x], '.')) {$campo[$x] = substr($campo[$x], strrpos($campo[$x], '.') + 1);}
	}


		//devo passare alla classe alunni le classi scolastiche (e sezioni) del maestro in quest'anno: vado ad estrarle e le inserisco nel filtro del campo 3 e 4
		$classiA = array();
		$sezioniA =  array();
		$sql = "SELECT DISTINCT classe_cma, sezione_cma, vede_mae FROM tab_classimaestri LEFT JOIN tab_anagraficamaestri ON ID_mae_cma = ID_mae WHERE ID_mae_cma = ? AND annoscolastico_cma = ?";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "is", $ID_mae, $_POST['annoscolastico_cla']);	
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $classe_cma, $sezione_cma, $vede_mae);
		mysqli_stmt_store_result($stmt);
		$n = 0;
		while (mysqli_stmt_fetch($stmt)) {
			$n++;
			//Gli Array $classiA[] e $sezioniA[] contengono le combinazioni classe/sezione da mostrare
			$classiA[$n] =  $classe_cma;
			$sezioniA[$n] = $sezione_cma;
		}


		//nel caso in cui $vede_mae = 2 devo mostrare TUTTE le classi, quindi i due array vado a RIFARLI includendo tutte le classi dell'anno (asili esclusi)

		if ($vede_mae == 2) {
			//vuoto i due array appena creati e li riempio di nuovo con tutte le classi
			$classiA = array();
			$sezioniA = array();
			$sql = "SELECT DISTINCT classe_cma, sezione_cma FROM tab_classimaestri LEFT JOIN tab_classi ON classe_cls = classe_cma WHERE annoscolastico_cma = ? AND aselme_cls <> 'AS'";
			$stmt = mysqli_prepare($mysqli, $sql);
			mysqli_stmt_bind_param($stmt, "s", $_POST['annoscolastico_cla']);	
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $classe_cma, $sezione_cma);
			$n = 0;
			while (mysqli_stmt_fetch($stmt)) {
				$n++;
				//Gli Array $classiA[] e $sezioniA[] contengono le combinazioni classe/sezione da mostrare
				$classiA[$n] =  $classe_cma;
				$sezioniA[$n] = $sezione_cma;
			}
		}
		//fil[3] è il filtro classe		

		$fil[3] = "";
		for ($x = 1; $x <= $n; $x++) {
			$fil[3] = $fil[3].",".$classiA[$x]; //creo il filtro con l'elenco delle classi estratte
		}



		//******NON E' PERFETTA QELLA CHE SEGUE MA VA QUASI BENE */
		//arriva $_POST['fil'][3] che è ciò che è stato scritto
		//devo:
		//togliere l'eventuale =
		//creare un array a partire dal fatto che potrebbe essere scritto con delle virgole
		$FilterClasse = $_POST['fil'][3];
		if ($FilterClasse != '') {
			$FilterClasseBackup = $FilterClasse;
			if (substr($FilterClasseBackup, 0, 1) == "=") { $FilterClasse = substr($FilterClasse, 1); }
			$FilterClasseA = explode(",",$FilterClasse);
			//a questo punto ho classiA che contiene tutte le classi e FilterClasseA che contiene quelle che sono state digitate
			//devo confrontare FilterClasseA con classiA: e togliere eventuali classi che NON siano comprese in classiA
			//per ogni elemento di quelli scritti nel filtro...
			 foreach ($FilterClasseA as $ClasseSingola) {
			 	//se NON lo trovo nell'elenco delle classi consentite
			 	 if (!in_array($ClasseSingola, $classiA)) {
			 	 	//lo tolgo (cioè trovo in che posizione sta....e ne  faccio lo splice.)
			 	 	//array_splice($FilterClasseA, array_search($ClasseSingola, $FilterClasseA));
					$FilterClasseA[array_search($ClasseSingola, $FilterClasseA)] = "@";  //FACCIO ANDARE IN ERRORE QUESTA RICERCA
			 	 }
			 } 
			 $str = implode (",", $FilterClasseA);
			 if (substr($FilterClasseBackup, 0, 1) == "="  && $str != '') { $str = "=".$str;}
			 $str = "=".$str; 
			 $_POST['fil'][3] = $str;
		}


		if ($_POST['fil'][3] == '') {
			$_POST['fil'][3] = "=".substr($fil[3], 1) ; //se non c'è filtro uso l'elenco classi estratte
		}
		
		$fil[4] = "";
		for ($x = 1; $x <= $n; $x++) {
			$fil[4] = $fil[4].",".$sezioniA[$x]; 
		}
		if ($_POST['fil'][4] == '') {
			$_POST['fil'][4] = "=".substr($fil[4], 1) ;
		}

		?>
		<tr>
		<td>
	
			<?//echo(json_encode($_POST['ID_mae']))?>
			
			<?//=print_r($_POST['fil']);?>
		</td>
		</tr>
	<?
	
	//su richiesta di maestra Edith (03/02/19) torno a mostrare gli alunni ritirati

	$riga =  0;

	foreach (GetAlunniPerAnno ($_POST['campo'], 4, $_POST['ord'], $_POST['fil'], $_POST['annoscolastico_cla'], 0) as $alunno) {
		$riga++;
		if ($alunno->emailpadre_fam!="") {$emailtotale =  $emailtotale.",".$alunno->emailpadre_fam;}
		if ($alunno->emailmadre_fam!="") {$emailtotale =  $emailtotale.",".$alunno->emailmadre_fam;}
		?>
		<tr>
			<td style="width: 40px;">
			<?//=$alunno->test?>
			<?//print_r($FilterClasseA)?>
			
			<?//print_r($classiA)?>
				<button  class="fs12 center w90" id="button_<?=$alunno->ID_alu?>" name="alu<?=$ID_alu?>" ><?=$riga?></button>
			</td>
			<td class="w120px">
				<input class="tablecell3 disab val<? echo($alunno->ID_alu) ?> w100" type="text" name="nome_alu" value = "<?=$alunno->nome_alu?>" disabled>
			</td>
			<td class="w120px">
				<input class="tablecell3 disab val<? echo($alunno->ID_alu) ?> w100" type="text" name="cognome_alu" value = "<?=$alunno->cognome_alu?>" disabled>
			</td>
			<td class="w100px">
				<input class="tablecell3 disab val<? echo($alunno->ID_alu) ?> w100" type="text" name="classe_cla" value = "<?=$alunno->classe_cla?>" disabled>
			</td>
			<td style="width:60px;">
				<input class="tablecell3 disab val<? echo($alunno->ID_alu) ?> w100" type="text" name="sezione_cla" value = "<?=$alunno->sezione_cla?>" disabled>
			</td>
		</tr>
	<?}?>
		
	<tr>
		<td>
			<input id="contarecord_hidden" 		value = "<?=$riga?>" 		hidden>
		</td>
	</tr>

<script>
	$(document).ready(function(){
	});
	
	
</script>