<?include_once("database/databaseii.php");

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
		$ordsql = orderbysql( $ord3, 'tipo_per', $ordsql);
	}
	if (isset ($_POST['ord4'])){
		$ord4 = $_POST['ord4'];
		$ordsql = orderbysql( $ord4, 'in_organico_mae', $ordsql);
	}
	if (isset ($_POST['ord5'])){
		$ord5 = $_POST['ord5'];
		$ordsql = orderbysql( $ord5, 'telefono_mae', $ordsql);
	}
	
	if (isset ($_POST['ord6'])){
		$ord6 = $_POST['ord6'];
		$ordsql = orderbysql( $ord6, 'note_mae', $ordsql);
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
	
	$tipoperA = array(0=>"Maestro", 1=>"Amministratore",  2=>"Segr. o altro");

	//Manteniamo il filtro dell'anno solo per uniformità con qry_AnagraficaPerAnno ma in qs caso non serve a nulla
	$whereannocorrente = "WHERE 1=1 ";
	$sql = "SELECT DISTINCT ID_mae, nome_mae, cognome_mae, tipo_per, in_organico_mae, telefono_mae, note_mae FROM tab_anagraficamaestri ".$whereannocorrente.$ordsql;
	//DA RENDERE PARAMETRICA - DIFFICILE
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_mae, $nome_mae, $cognome_mae, $tipo_per, $in_organico_mae, $telefono_mae, $note_mae);
	$riga =  0;
	while (mysqli_stmt_fetch($stmt)) {
	$riga++;	?>
		<tr>
			<td style="width:20px;">
				<img title="Cancella questo profilo" class="iconaStd" src='assets/img/Icone/times-circle-solid.svg' onclick="showModalDeleteThisRecord(<?=$ID_mae?>, '<?=$nome_mae?>', '<?=$cognome_mae?>');">
			</td>
			<td style="width:30px;">
				<button  id="goto<?=$ID_mae?>" ondblclick="postToSchedaMaestro(<?=$ID_mae?>, '<?=$nome_mae?>', '<?=$cognome_mae?>');" style="width: 30px; font-size: 12px;"><?=$riga?></button>
			</td>
			<td>
				<input class="tablecell6 disab val<?=$ID_mae?>" style="width: 150px;" type="text"  id="nome_mae<?=$ID_mae?>" name="nome_mae" value = "<?=$nome_mae?>" disabled>
			</td>
			<td>
				<input class="tablecell6 disab val<?=$ID_mae?>" style="width: 150px;" type="text" id="cognome_mae<?=$ID_mae?>" name="cognome_mae" value = "<?=$cognome_mae?>" disabled>
			</td>
			<td>
				<input class="tablecell6 disab val<?=$ID_mae?> w100px" type="text" id="tipo_per<?=$ID_mae?>" name="tipo_per" value = "<?=$tipoperA[$tipo_per]?>" disabled>
			</td>
			<td style="text-align: center !important;">
				<input class="tablecell6 disab val<?=$ID_mae?>" style="width: 40px; left-margin: 20px; " type="checkbox" id="in_organico_mae<?=$ID_mae?>" name="in_organico_mae" <?if($in_organico_mae==1){echo ('checked');}?> disabled>
			</td>
			<td>
				<input class="tablecell6 disab val<?=$ID_mae?>" style="width: 115px;" type="text" id="telefono_mae<?=$ID_mae?>" name="telefono_mae" value = "<?=$telefono_mae?>" disabled>
			</td>
			<td>
				<input class="tablecell6 disab val<?=$ID_mae?>" style="width: 457px;" type="text" id="note_mae<?=$ID_mae?>" name="note_mae" value = "<?=$note_mae?>" disabled>
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
