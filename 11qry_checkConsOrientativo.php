<?include_once("database/databaseii.php");
	
	//in questa pagina viene ricevuto in input il nome del maestro
	
	//si estrae se il maestro è maestri di classe in classe VIII nell'anno corrente PRIMA CONDIZIONE
	//si estrae se la data è prossima o successiva alle scadenze SECONDA CONDIZIONE
	//si verifica se sono attive le scadenze da parametri TERZA CONDIZIONE
	//si verifica se i documenti richiesti sono già stati tutti compilatI o no QUARTA CONDIZIONE
	//se tutte le condizioni sono VERE allora si mostra il modal form scrivendo in hiddenConsOrientativo un numero diverso da zero
	
	$todaydate = date("Y-m-d");
	$ID_mae_cma = $_POST['ID_mae_ora'];
	$annoscolastico_cma = $_SESSION['anno_corrente'];
	$giorniWarningConsOrientativo = $_SESSION["giorniWarningConsOrientativo"]; //relativo alla sola classe VIII
	
	//PRIMA CONDIZIONE
	$sql = "SELECT classe_cma, ruolo_cma FROM tab_classimaestri WHERE annoscolastico_cma = ? AND ID_mae_cma = ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "si", $annoscolastico_cma, $ID_mae_cma);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $classe_cma, $ruolo_cma);
	$V = 0;
	$VIII = 0;
	while (mysqli_stmt_fetch($stmt)) {
		if ($classe_cma == "VIII" && $ruolo_cma = "CLA") { $VIII = 1;}
	}

	//SECONDA CONDIZIONE E TERZA CONDIZIONE
	$sql2 = "SELECT datafine_asc FROM tab_anniscolastici WHERE annoscolastico_asc = ?";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "s", $annoscolastico_cma);
	mysqli_stmt_execute($stmt2);
	mysqli_stmt_bind_result($stmt2, $datafine_asc);
	while (mysqli_stmt_fetch($stmt2)) {
	}
	$diff = abs(strtotime($datafine_asc) - strtotime($todaydate));
	?>
	<!-- <div>Mancano <?//=$diff/86400?> giorni al termine dell'anno scolastico</div> -->

	<?
	$viciniAFineScuola = 0;
	//ecco il check della seconda  e terza condizione
	if ($diff < 86400*$giorniWarningConsOrientativo && $giorniWarningConsOrientativo != 0) { 
		//il numero di giorni scritti in database in tab_parametri è la soglia di vicinanza alla data fine scuola
		//se impostata a zero non mostra il warning
		$viciniAFineScuola = 1;
	}

	//QUARTA CONDIZIONE vado a cercarla solo se le altre sono vere altrimenti non serve
	if ($viciniAFineScuola == 1 && ($VIII == 1) ) {
		$sql4 = "SELECT ID_cor, ID_alu, nome_alu, cognome_alu FROM ((tab_anagraficaalunni LEFT JOIN tab_consorientativo ON ID_alu_cor = ID_alu) ". 
		" LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla)".
		" WHERE annoscolastico_cla = ? AND classe_cla = 'VIII'";
		$stmt4 = mysqli_prepare($mysqli, $sql4);
		mysqli_stmt_bind_param($stmt4, "s", $annoscolastico_cma);
		mysqli_stmt_execute($stmt4);
		mysqli_stmt_bind_result($stmt4, $ID_cor, $ID_alu, $nome_alu, $cognome_alu);
		$aluIncompletiCOrientativo = array();
		$NaluIncompletiCOrientativo = 0;
		while (mysqli_stmt_fetch($stmt4)) {
			if ($ID_cor == '') {
				$NaluIncompletiCOrientativo++;
				//se non è già aggiunto: nella select c'è un record per ogni ID_alu quindi non serve l'if come nel caso della cert Competenze
				//in cui c'erano + record per ogni ID_alu
				$aluIncompletiCOrientativo[$NaluIncompletiCOrientativo] = $nome_alu." ".$cognome_alu;
			}
		}
		//a questo punto ho un array di nomi dei ragazzi di VIII che non hanno un consiglio orientativo compilato

		if ($NaluIncompletiCOrientativo !=0 ) {?>
			<div>E' necessario compilare nella sezione "I miei alunni" </div>
			<div>il CONSIGLIO ORIENTATIVO per i seguenti alunni di classe VIII</div>
			<br>
			<table id="tabellaCertCompetenze" class="center" style="width: 250px; margin:auto;">
			<?foreach($aluIncompletiCOrientativo as $value) {?>
				<tr >
				<td style="border: 1px solid grey">
					<?=$value?>
				</td>
				</tr>	
			<?}?>
			</table>
		<?}
	}?>
	<div><input id="hiddenConsOrientativo" value="<?echo($NaluIncompletiCOrientativo);?>" hidden></div>