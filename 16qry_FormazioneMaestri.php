<?
	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");

	for ($x = 1; $x <= 6; $x++) {
		if (isset ($_POST['campo'.$x])) {
			$campoName[$x] = $_POST['campo'.$x];
		}
	}
	
	if (isset ($_POST['ord1'])){
		$ord1 = $_POST['ord1'];
		$ordsql = orderbysql( $ord1, 'nome_mae', $ordsql);
	}
	if (isset ($_POST['ord2'])){
		$ord2 = $_POST['ord2'];
		$ordsql = orderbysql( $ord2, 'cognome_mae', $ordsql);
	}
	if (isset ($_POST['ord3'])){
		$ord3 = $_POST['ord3'];
		$ordsql = orderbysql( $ord3, 'cat_tit', $ordsql);
	}
	if (isset ($_POST['ord4'])){
		$ord4 = $_POST['ord4'];
		$ordsql = orderbysql( $ord4, 'nome_tit', $ordsql);
	}
	if (isset ($_POST['ord5'])){
		$ord5 = $_POST['ord5'];
		$ordsql = orderbysql( $ord5, 'data_tit', $ordsql);
	}
	
	if (isset ($_POST['ord6'])){
		$ord6 = $_POST['ord6'];
		$ordsql = orderbysql( $ord6, 'scad_tit', $ordsql);
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
		$ordsql = ' ORDER BY cognome_mae ';
	} else {
		$ordsql = ' ORDER BY ' .  substr($ordsql, 2) ;
	}
	
	
	// ora costruisco la clasuola FILTER BY sulla base di tutti i valori di fil
	for ($x = 1; $x <= 6; $x++) {
	if (isset ($_POST['fil'.$x]))
		{
			$fil[$x] = $_POST['fil'.$x];
			$filsql = filterbysql( $fil[$x], $campoName[$x], $filsql);
		}
	}
	
	function filterbysql ($fil, $campo, $filsq) {
		switch ($fil) {
			case '' :
				break;
		
			default :
				//Se viene inserito un = altrimenti è un LIKE
				if (substr($fil,0,1) == '=') {
				$filsq = $filsq . " AND ". $campo. " = \"". substr($fil, 1) ."\" ";
				} else {
				$filsq = $filsq . " AND ". $campo. " LIKE \"%". $fil ."%\" ";
				}
				break;

		}
		return $filsq;
	}

	$filsql = " WHERE in_organico_mae = 1 ".$filsql;
	//echo $filsql;
	$sql = "SELECT DISTINCT ID_mae, nome_mae, cognome_mae, ID_tit, cat_tit, nome_tit, desc_tit, data_tit, scad_tit, showscad_tit, ckformagg_tit FROM tab_titolimaestri LEFT JOIN tab_anagraficamaestri ON ID_mae = ID_mae_tit ".$filsql.$ordsql;
	//QUERY PARAMETRICA DA FARE - DIFFICILE
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_mae, $nome_mae, $cognome_mae, $ID_tit, $cat_tit, $nome_tit, $desc_tit, $data_tit, $scad_tit, $showscad_tit, $ckformagg_tit);
	$riga =  0;
	$arr = array("idle", "Diploma", "Laurea", "Seminario Waldorf", "Aggiornamenti Waldorf", "Altra Formazione Pedagogica", "Sicurezza", "Privacy", "Altro");
	while (mysqli_stmt_fetch($stmt)) {
	$riga++;
	
	$cat_titN = array_search($cat_tit, $arr);
	echo ($cat_titN);
	?>
	
	
		<tr>
			<td style="width:22px;">
				<img title="Cancella questo titolo" class="iconaStd" src='assets/img/Icone/times-circle-solid.svg' onclick="showModalDeleteThisRecord(<?=$ID_tit?>, '<?=$nome_mae?>', '<?=$cognome_mae?>');">

			</td>
			<td style="width:40px;">
				<button  id="goto<?=$ID_mae?>" ondblclick="postToSchedaMaestro(<?=$ID_mae?>, '<?=$nome_mae?>', '<?=$cognome_mae?>');" style="width: 30px; font-size: 12px;"><?=$riga?></button>
			</td>
			<td>
				<input class="tablecell6 disab val<?=$ID_mae?> w100px" type="text"  id="nome_mae<?=$ID_mae?>" name="nome_mae" value = "<?=$nome_mae?>" disabled>
			</td>
			<td>
				<input class="tablecell6 disab val<?=$ID_mae?> w100px" type="text" id="cognome_mae<?=$ID_mae?>" name="cognome_mae" value = "<?=$cognome_mae?>" disabled>
			</td>
			<td>
				<input class="tablecell6 disab val<?=$ID_mae?> catForm<?=$cat_titN?>" style="width: 180px;" type="text" id="cat_tit<?=$ID_mae?>" name="cat_tit" value = "<?=$cat_tit?>" disabled>
			</td>
			<td>
				<input class="tablecell6 disab val<?=$ID_mae?>" style="width: 70px;" type="text" id="formagg_tit<?=$ID_mae?>" name="form_agg_tit" value = "<?=$ckformagg_tit?>" disabled>
			</td>
			<td>
				<input class="tablecell6 disab val<?=$ID_mae?>" style="width: 390px;" type="text" id="nome_tit<?=$ID_mae?>" name="nome_tit" value = "<?=$nome_tit?>" disabled>
			</td>
			<td>
				<input class="tablecell6 disab val<?=$ID_mae?>" style="width: 115px;" type="text" id="data_tit<?=$ID_mae?>" name="data_tit" value = "<?if ($data_tit!= "1970-01-01") { echo(timestamp_to_ggmmaaaa($data_tit)) ;}?>" disabled>
			</td>
			<td>
				<input class="tablecell6 disab val<?=$ID_mae?>" style="width: 115px;" type="text" id="scad_tit<?=$ID_mae?>" name="scad_tit" value = "<?if (!($scad_tit == '1970-01-01') &&($showscad_tit != 1)) { echo(timestamp_to_ggmmaaaa($scad_tit)) ;}?>" disabled>
			</td>
		</tr>
	<?}?>
<script>


	
	function postToSchedaMaestro(ID, nome, cognome) {
		
		let form = $(document.createElement('form'));
		$(form).attr("action", "08SchedaMaestro.php");
		$(form).attr("method", "POST");
		$(form).css("display", "none");
	
		let input_IDmae = $("<input>")
		.attr("type", "text")
		.attr("name", "ID_maeDaAltraPag")
		.val(ID);
		$(form).append($(input_IDmae));
		
		let input_nomemae = $("<input>")
		.attr("type", "text")
		.attr("name", "nome_maeDaAltraPag")
		.val(nome);
		$(form).append($(input_nomemae));
		
		let input_cognomemae = $("<input>")
		.attr("type", "text")
		.attr("name", "cognome_maeDaAltraPag")
		.val(cognome);
		$(form).append($(input_cognomemae));
		
		form.appendTo( document.body );
		$(form).submit();
	}
</script>
