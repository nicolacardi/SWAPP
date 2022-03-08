<?	

	include_once("database/databaseii.php");
	$annoscolastico_cla = $_POST['annoscolastico_cla'];
	$classe_cla = $_POST['classe_cla'];
	$sezione_cla = $_POST['sezione_cla'];
	$ID_mae = $_POST['ID_mae'];
	
	$date_from = $_POST['date_from'];
	$date_to = $_POST['date_to'];
	$ID_covA = array();
	$ID_aluA = array();
	$nome_aluA = array();
	$cognome_aluA = array();
	$voto_vccA = array();




	//seleziono i valori univoci di ID_cov (compiti e verifiche) per la classe/sezione/annoscolastico entro le date del quadrimestre
	$sql1 = "SELECT ID_cov, codmat_cov, tipo_cov, data_cov FROM tab_compitiverifiche WHERE classe_cov = ? AND sezione_cov = ? AND annoscolastico_cov = ? AND ID_mae_cov = ? AND (data_cov >= ? AND data_cov <= ?) ORDER BY codmat_cov, tipo_cov, data_cov";
	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1, "sssiss", $classe_cla, $sezione_cla, $annoscolastico_cla, $ID_mae, $date_from, $date_to);
	mysqli_stmt_execute($stmt1);
	mysqli_stmt_bind_result($stmt1, $ID_cov, $codmat_cov, $tipo_cov, $data_cov);
	mysqli_stmt_store_result($stmt1);
	$compito = 1;
	
	while (mysqli_stmt_fetch($stmt1)) {
		$ID_covA[$compito]= $ID_cov;	//matrice degli ID dei compiti
		$sql2 = "SELECT ID_alu, voto_vcc 
		FROM (tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) LEFT JOIN tab_voticompitiverifiche ON ID_alu = ID_alu_vcc AND ID_cov_vcc = ?
		WHERE annoscolastico_cla = ? AND classe_cla = ? AND sezione_cla = ? AND listaattesa_cla = 0 ORDER BY cognome_alu, nome_alu";
		$stmt2 = mysqli_prepare($mysqli, $sql2);
		mysqli_stmt_bind_param($stmt2, "isss", $ID_cov, $annoscolastico_cla, $classe_cla, $sezione_cla);
		mysqli_stmt_execute($stmt2);
		mysqli_stmt_bind_result($stmt2, $ID_alu, $voto_vcc);
		$alunno = 1;
		while (mysqli_stmt_fetch($stmt2)) {
			$voto_vccA[$compito][$alunno] = $voto_vcc; //costruisco una matrice del tipo voto_vcc[progressivocompito] [progressivoalunno]
			$alunno++;
		}
		$compito++;
	}


	$sql3 = "SELECT ID_alu, nome_alu, cognome_alu
	FROM (tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla)
	WHERE annoscolastico_cla = ? AND classe_cla = ? AND sezione_cla = ? AND listaattesa_cla = 0 ORDER BY cognome_alu, nome_alu";
	$stmt3 = mysqli_prepare($mysqli, $sql3);
	mysqli_stmt_bind_param($stmt3, "sss", $annoscolastico_cla, $classe_cla, $sezione_cla);
	mysqli_stmt_execute($stmt3);
	mysqli_stmt_bind_result($stmt3, $ID_alu, $nome_alu, $cognome_alu);
	$alunno = 1;
	while (mysqli_stmt_fetch($stmt3)) {
		$ID_aluA[$alunno] = $ID_alu;
		$nome_aluA[$alunno] = $nome_alu;
		$cognome_aluA[$alunno] = $cognome_alu;
		$alunno++;
	}


	$alunni = $alunno - 1;
	$compiti = $compito -1;	
?>
	<?
	for ($alunno = 1; $alunno <= $alunni ; $alunno++) {

	?>
		<tr>
			<td style="width: 40px;">
				<button  style="width: 80%;" id="riga<?=$alunno?>" name="alu<?=$ID_aluA[$alunno];?>"onclick="requeryDettaglio(<?=$ID_aluA[$alunno];?>);" ><?=$alunno;?></button>				
			</td>
			<td>
				<input class="tablecell3 disab" style="max-width:100px; " type="text"  id="nome_alu<?=$ID_aluA[$alunno]?>" name="nome_alu" value = "<?=$nome_aluA[$alunno];?>" disabled>
			</td>
			<td>
				<input class="tablecell3 disab" style="max-width:100px;" type="text" id="cognome_alu<?=$ID_aluA[$alunno]?>" name="cognome_alu" value = "<?=$cognome_aluA[$alunno];?>" disabled>
			</td>
			<td>
				<input class="tablecell3 disab" style="max-width:70px; text-align: center;" type="text" name="classe_cla" value = "<?=$classe_cla;?>" disabled>
			</td>
			<td style="width:30px;">
				<input class="tablecell3 disab" style="max-width:40px; text-align: center" type="text" name="sezione_cla" value = "<?=$sezione_cla;?>" disabled>
				<input id = "aselme<?=$ID_aluA[$alunno];?>" value = "<?=$aselme_cla;?>" hidden>
			</td>
			<?
			//devo creare e mostrare i compiti SOLO se sono del maestro corrente/loggato
			for ($compito = 1; $compito <= $compiti; $compito++) {?>
				<td style="width:40px;">
					<input type="number" min="0" max = "10" max-length = "3" class="tablecell3 disab voto_vcc" style="text-align: right; width: 40px;" id="voto<?=$ID_aluA[$alunno]?>.<?=$ID_covA[$compito]?>" name="voto_vcc" value = "<?=$voto_vccA[$compito][$alunno]?>" onkeypress="return isNumberKey(event)">
				</td>
			<?}?>

			<td>
			</td>
		</tr>
	<?}?>
	<tr>
		<td>
			<input id="contarecord_hidden" value = "<?=$alunno?>" hidden>
		</td>
		<td>
		</td>
	</tr>
