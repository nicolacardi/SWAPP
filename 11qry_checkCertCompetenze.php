<?include_once("database/databaseii.php");
	
	//in questa pagina viene ricevuto in input il nome del maestro
	
	//si estrae se il maestro è maestri di classe in classe V o in classe VIII nell'anno corrente PRIMA CONDIZIONE
	//si estrae se la data è prossima o successiva alle scadenze SECONDA CONDIZIONE
	//si verifica se sono attive le scadenze da parametri TERZA CONDIZIONE
	//si verifica se i documenti richiesti sono già stati tutti compilatI o no QUARTA CONDIZIONE
	//se tutte le condizioni sono VERE allora si mostra il modal form scrivendo in hiddenCertCompetenze un numero diverso da zero
	
	$todaydate = date("Y-m-d");
	$ID_mae_cma = $_POST['ID_mae_ora'];
	$annoscolastico_cma = $_SESSION['anno_corrente'];
	$giorniWarningCertCompetenze = $_SESSION["giorniWarningCertCompetenze"]; //relativo alla classe V e VIII
	
	//PRIMA CONDIZIONE
	$sql = "SELECT classe_cma, ruolo_cma FROM tab_classimaestri WHERE annoscolastico_cma = ? AND ID_mae_cma = ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "si", $annoscolastico_cma, $ID_mae_cma);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $classe_cma, $ruolo_cma);
	$V = 0;
	$VIII = 0;
	while (mysqli_stmt_fetch($stmt)) {
		if ($classe_cma == "V" && $ruolo_cma = "CLA") { $V = 1;}
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
	if ($diff < 86400*$giorniWarningCertCompetenze && $giorniWarningCertCompetenze != 0) { 
		//il numero di giorni scritti in database in tab_parametri è la soglia di vicinanza alla data fine scuola
		//se impostata a zero non mostra il warning
		$viciniAFineScuola = 1;
	}

	//QUARTA CONDIZIONE vado a cercarla solo se le altre sono vere
	if ($viciniAFineScuola == 1 && ($V ==1 || $VIII == 1) ) {
		//il maestro insegna in classe V o VIII andiamo a vedere se sono compilate le certificazioni delle competenze
		$sql3 = "SELECT ID_alu, nome_alu, cognome_alu, votocertcomp_cer FROM (tab_certcompetenze LEFT JOIN ".
		"tab_anagraficaalunni ON ID_alu_cer = ID_alu) WHERE annoscolastico_cer = ? AND classe_cer = ? AND votocertcomp_cer = '' ORDER BY ID_alu";
		$stmt3 = mysqli_prepare($mysqli, $sql3);
		mysqli_stmt_bind_param($stmt3, "ss", $annoscolastico_cma, $classe_cma);
		mysqli_stmt_execute($stmt3);
		mysqli_stmt_bind_result($stmt3, $ID_alu, $nome_alu, $cognome_alu, $votocertcomp_cer);

		$aluIncompletiCCompetenze = array();
		$NaluIncompletiCCompetenze = 0;
		$ID_alu_prec = 0;

		while (mysqli_stmt_fetch($stmt3)) {
			
			if ($ID_alu != $ID_alu_prec) {
				$NaluIncompletiCCompetenze++;
				//se non è già aggiunto (a questo serve l'if qui sopra in quanto la select è ordinata per ID_alu, lo aggiungo
				$aluIncompletiCCompetenze[$NaluIncompletiCCompetenze] = $nome_alu." ".$cognome_alu;
			}
			$ID_alu_prec = $ID_alu;
		}
		//a questo punto ho un array di nomi dei ragazzi che hanno almeno un voto mancante in certificazione delle competenze, che si tratti di V o di VIII
		//se l'array non è vuoto lo scrivo nell'html
		if ($NaluIncompletiCCompetenze !=0 ) {?>

			<div>E' necessario compilare nella sezione "I miei alunni" </div>
			<div>la CERTIFICAZIONE DELLE COMPETENZE per i seguenti alunni di classe <?=$classe_cma?></div>
			<br>
			<table id="tabellaCertCompetenze" class="center" style="width: 250px; margin:auto;">
			<?foreach($aluIncompletiCCompetenze as $value) {?>
				<tr >
					<td style="border: 1px solid grey">
						<?=$value?>
					</td>
				</tr>	
			<?}?>
			</table>
		<?}
	}?>
	<div><input id="hiddenCertCompetenze" value="<?echo($NaluIncompletiCCompetenze);?>" hidden></div>