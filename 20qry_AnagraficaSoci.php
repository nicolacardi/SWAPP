<?include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	if (isset ($_POST['ord1'])){
		$ord1 = $_POST['ord1'];
		$ordsql = orderbysql( $ord1, 'nome_soc', $ordsql);
	}
	if (isset ($_POST['ord2'])){
		$ord2 = $_POST['ord2'];
		$ordsql = orderbysql( $ord2, 'cognome_soc', $ordsql);
	}
	if (isset ($_POST['ord3'])){
		$ord3 = $_POST['ord3'];
		$ordsql = orderbysql( $ord3, 'tipo_soc', $ordsql);
	}
	if (isset ($_POST['ord4'])){
		$ord4 = $_POST['ord4'];
		$ordsql = orderbysql( $ord4, 'dataiscrizione_soc', $ordsql);
	}
	if (isset ($_POST['ord5'])){
		$ord5 = $_POST['ord5'];
		$ordsql = orderbysql( $ord5, 'datadisiscrizione_soc', $ordsql);
	}


	function orderbysql ($ord, $campo, $ordsq) {
		switch ($ord) {
			case '--' :
				break;
			case 'az' :
				$ordsq = $ordsq . ' , '. $campo. ' '. 'ASC ' ;
				break;
			case 'za':
				$ordsq = $ordsq . ' , '. $campo. ' '. 'DESC ' ;
				break;
		}
		return $ordsq;
	}
		
	if ($ordsql == '') {
		$ordsql = ' ORDER BY cognome_soc ';
	} else {
		$ordsql = ' ORDER BY ' .  substr($ordsql, 2) ;
	}
	
	$tiposocA = array(0=>"Fruitore", 1=>"Lavoratore",  2=>"Volontario", 3=>"Altro");

	//Manteniamo il filtro dell'anno solo per uniformità con qry_AnagraficaPerAnno ma in qs caso non serve a nulla
	$whereannocorrente = "WHERE 1=1 ";
	$sql = "SELECT ID_soc, nome_soc, cognome_soc, tipo_soc, dataiscrizione_soc, datadisiscrizione_soc FROM tab_anagraficasoci ".$whereannocorrente.$ordsql;
	//DA RENDERE PARAMETRICA - DIFFICILE
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_soc, $nome_soc, $cognome_soc, $tipo_soc, $dataiscrizione_soc, $datadisiscrizione_soc);
	$riga =  0;

	while (mysqli_stmt_fetch($stmt)) {
	$riga++;	?>
		<tr>
			<td style="width:20px;">
				<img title="Cancella questo profilo" class="iconaStd" src='assets/img/Icone/times-circle-solid.svg' onclick="showModalDeleteThisRecord(<?=$ID_soc?>, '<?=$nome_soc?>', '<?=$cognome_soc?>');">
			</td>
			<td style="width:30px;">
				<button  id="goto<?=$ID_soc?>" ondblclick="postToSchedaSocio(<?=$ID_soc?>, '<?=$nome_soc?>', '<?=$cognome_soc?>');" style="width: 30px; font-size: 12px;"><?=$riga?></button>
			</td>
			<td>
				<input class="tablecell6 disab val<?=$ID_soc?>" style="width: 200px;" type="text"  id="nome_soc<?=$ID_soc?>" name="nome_soc" value = "<?=$nome_soc?>" disabled>
			</td>
			<td>
				<input class="tablecell6 disab val<?=$ID_soc?>" style="width: 200px;" type="text" id="cognome_soc<?=$ID_soc?>" name="cognome_soc" value = "<?=$cognome_soc?>" disabled>
			</td>
			<td>
				<input class="tablecell6 disab val<?=$ID_soc?> w150px" type="text" id="tipo_soc<?=$ID_soc?>" name="tipo_psoc" value = "<?=$tiposocA[$tipo_soc]?>" disabled>
			</td>
            <td>
				<input class="tablecell6 disab val<?=$ID_soc?> w150px" type="text" id="dataiscrizione_soc<?=$ID_soc?>" name="dataiscrizione_soc" value = "<?=timestamp_to_ggmmaaaa($dataiscrizione_soc);?>" disabled>
			</td>
			<td>
				<input class="tablecell6 disab val<?=$ID_soc?> w150px" type="text" id="datadisiscrizione_soc<?=$ID_soc?>" name="datadisiscrizione_soc" value = "<?=timestamp_to_ggmmaaaa($datadisiscrizione_soc);?>" disabled>
			</td>
		</tr>
	<?}?>
<script>


	
	function postToSchedaSocio(ID, nome, cognome) {
		
		let form = $(document.createElement('form'));
		$(form).attr("action", "21SchedaSocio.php");
		$(form).attr("method", "POST");
		$(form).css("display", "none");
	
		let input_IDmae = $("<input>")
		.attr("type", "text")
		.attr("name", "ID_socDaAltraPag")
		.val(ID);
		$(form).append($(input_IDmae));
		
		let input_nomemae = $("<input>")
		.attr("type", "text")
		.attr("name", "nome_socDaAltraPag")
		.val(nome);
		$(form).append($(input_nomemae));
		
		let input_cognomemae = $("<input>")
		.attr("type", "text")
		.attr("name", "cognome_socDaAltraPag")
		.val(cognome);
		$(form).append($(input_cognomemae));
		
		form.appendTo( document.body );
		$(form).submit();
	}
</script>
