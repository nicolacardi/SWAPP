<?	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	/* ora costruisco la clasuola ORDER BY sulla base di tutti i valori di ord */
	if (isset ($_POST['ord1'])){
		$ord1 = $_POST['ord1'];
		$ordsql = orderbysql( $ord1, 'codmat_mtt', $ordsql);
	} 
	if (isset ($_POST['ord2'])){
		$ord2 = $_POST['ord2'];
		$ordsql = orderbysql( $ord2, 'descmateria_mtt', $ordsql);
	} 
	if (isset ($_POST['ord3'])){
		$ord3 = $_POST['ord3'];
		$ordsql = orderbysql( $ord3, 'as_mtt', $ordsql);
	} 
	if (isset ($_POST['ord4'])){
		$ord4 = $_POST['ord4'];
		$ordsql = orderbysql( $ord4, 'el_mtt', $ordsql);
	}
	if (isset ($_POST['ord5'])){
		$ord5 = $_POST['ord5'];
		$ordsql = orderbysql( $ord5, 'me_mtt', $ordsql);
    }
	if (isset ($_POST['ord6'])){
		$ord6 = $_POST['ord6'];
		$ordsql = orderbysql( $ord6, 'su_mtt', $ordsql);
    }
    if (isset ($_POST['ord7'])){
		$ord7 = $_POST['ord7'];
		$ordsql = orderbysql( $ord7, 'ord_mtt', $ordsql);
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
		$ordsql = ' ORDER BY ord_mtt, descmateria_mtt';
	} else {
		$ordsql = ' ORDER BY ' .  substr($ordsql, 2) ;
	}
	$sql = "SELECT ID_mtt, codmat_mtt, descmateria_mtt, as_mtt, el_mtt, me_mtt, su_mtt, ord_mtt FROM tab_materie ".$ordsql;
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_mtt, $codmat_mtt, $descmateria_mtt, $as_mtt, $el_mtt, $me_mtt, $su_mtt, $ord_mtt );
	$riga =  0;
	while (mysqli_stmt_fetch($stmt))
	{ 	$riga++;?>
		<tr>
			<td style="width:22px;">
				<img title='Cancella Materia <?=$ID_mtt?>' class="iconaStd" src='assets/img/Icone/times-circle-solid.svg'' onclick="showModalDeleteThisRecord(<?=$ID_mtt?>, 'deleteMateria', 'questa materia', 'ELIMINAZIONE MATERIA');">
			</td>
			<td style="width:45px;">
				<button  id="goto<?=$ID_mtt?>" style="width: 30px; font-size: 12px;"><?=$riga?></button>
			</td>
			<td>
				<input class="tablecell6 disab val<?=$ID_mtt?> w100px" type="text"  id="codmat_mtt<?=$ID_mtt?>" name="codmat_mtt" value = "<?=$codmat_mtt?>" onchange="setMateria(<?=$ID_mtt?>)">
			</td>
			<td>
				<input class="tablecell6 disab val<?=$ID_mtt?> w200px" type="text" id="descmateria_mtt<?=$ID_mtt?>" name="descmateria_mtt" value = "<?=$descmateria_mtt?>" onchange="setMateria(<?=$ID_mtt?>)">
			</td>
			<td>
				<input class="tablecell6 disab val<?=$ID_mtt?> w50px" type="checkbox" id="as_mtt<?=$ID_mtt?>" name="as_mtt" <?if ($as_mtt == 1) { echo ("checked");}?> onchange="setMateria(<?=$ID_mtt?>)">
			</td>
			<td>
				<input class="tablecell6 disab val<?=$ID_mtt?> w50px" type="checkbox" id="el_mtt<?=$ID_mtt?>" name="el_mtt" <?if ($el_mtt == 1) { echo ("checked");}?> onchange="setMateria(<?=$ID_mtt?>)">
			</td>
            <td>
				<input class="tablecell6 disab val<?=$ID_mtt?> w50px" type="checkbox" id="me_mtt<?=$ID_mtt?>" name="me_mtt" <?if ($me_mtt == 1) { echo ("checked");}?> onchange="setMateria(<?=$ID_mtt?>)">
			</td>
			<td>
				<input class="tablecell6 disab val<?=$ID_mtt?> w50px" type="checkbox" id="su_mtt<?=$ID_mtt?>" name="su_mtt" <?if ($su_mtt == 1) { echo ("checked");}?> onchange="setMateria(<?=$ID_mtt?>)">
			</td>
			<td>
				<input class="tablecell6 disab val<?=$ID_mtt?> w50px" type="text" id="ord_mtt<?=$ID_mtt?>" name="ord_mtt" value = "<?=$ord_mtt?>" onchange="setMateria(<?=$ID_mtt?>)" onchange="setMateria(<?=$ID_mtt?>)">
			</td>
		</tr>
    <?}

?>
<script>


	

	function setMateria(ID_mtt) {
		let codmat_mtt = $('#codmat_mtt'+ID_mtt).val();
		let descmateria_mtt = $('#descmateria_mtt'+ID_mtt).val();
		let as_mttBool = $('#as_mtt'+ID_mtt).is(":checked");
		if (as_mttBool) {as_mtt = 1;} else {as_mtt = 0}
		let el_mttBool = $('#el_mtt'+ID_mtt).is(":checked");
		if (el_mttBool) {el_mtt = 1;} else {el_mtt = 0}
		let me_mttBool = $('#me_mtt'+ID_mtt).is(":checked");
		if (me_mttBool) {me_mtt = 1;} else {me_mtt = 0}
		let su_mttBool = $('#su_mtt'+ID_mtt).is(":checked");
		if (su_mttBool) {su_mtt = 1;} else {su_mtt = 0}
		let ord_mtt = $('#ord_mtt'+ID_mtt).val();
		postData = { ID_mtt: ID_mtt, codmat_mtt: codmat_mtt, descmateria_mtt: descmateria_mtt, as_mtt: as_mtt, el_mtt: el_mtt, me_mtt: me_mtt, su_mtt: su_mtt, ord_mtt: ord_mtt};
		console.log ("15qry_SetMaterie.php - setMateria - postData a 15qry_updateMateria.php");
		console.log (postData);
		$.ajax({
			type: 'POST',
			url: "15qry_updateMateria.php",
			data: postData,
			dataType: 'json',
			success: function(data){
                console.log (data.test);
				requerySetMaterie();
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '15qry_SetMaterie ##fname##'");     
			}
		});
	}

</script>

	
