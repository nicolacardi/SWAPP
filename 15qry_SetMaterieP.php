<?	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("assets/functions/sqlBuildFunctions.php");

	/* ora costruisco la clasuola ORDER BY sulla base di tutti i valori di ord */
	if (isset ($_POST['ord1'])){
		$ord1 = $_POST['ord1'];
		$ordsql = orderbysql( $ord1, 'codmat_mat', $ordsql);
	} 
	if (isset ($_POST['ord2'])){
		$ord2 = $_POST['ord2'];
		$ordsql = orderbysql( $ord2, 'descmateria_mtt', $ordsql);
	} 
	if (isset ($_POST['ord3'])){
		$ord3 = $_POST['ord3'];
		$ordsql = orderbysql( $ord3, 'aselme_mat', $ordsql);
	} 
	if (isset ($_POST['ord4'])){
		$ord4 = $_POST['ord4'];
		$ordsql = orderbysql( $ord4, 'tipodoc_mat', $ordsql);
	}
	if (isset ($_POST['ord5'])){
		$ord5 = $_POST['ord5'];
		$ordsql = orderbysql( $ord5, 'ord_mat', $ordsql);
    }

	

	if ($ordsql == '') {
		$ordsql = ' ORDER BY tipodoc_mat, ord_mat';
	} else {
		$ordsql = ' ORDER BY ' .  substr($ordsql, 2) ;
	}


	/* costruisco la clausola FILTER BY sulla base di tutti i valori di fil */
	if (isset ($_POST['fil1'])){
		$fil1 = addslashes($_POST['fil1']);
		$filsql = filterbysqlexplode( $fil1, 'codmat_mat', $filsql);
	} 
	if (isset ($_POST['fil2'])){
		$fil2 = addslashes($_POST['fil2']);
		$filsql = filterbysqlexplode( $fil2, 'descmateria_mat', $filsql);
	} 
	if (isset ($_POST['fil3'])){
		$fil3 = addslashes($_POST['fil3']);
		$filsql = filterbysqlexplode( $fil3, 'aselme_mat', $filsql);
	}
	if (isset ($_POST['fil4'])){
		$fil4 = addslashes($_POST['fil4']);
		$filsql = filterbysqlexplode( $fil4, 'tipodoc_mat', $filsql);
	} 




$sql= "SELECT ID_mat, codmat_mat, descmateria_mat, aselme_mat, tipodoc_mat, ord_mat, contaobiettivi.n FROM tab_materievoti LEFT JOIN (SELECT ID_mat_obi, COUNT(*) AS n FROM tab_materievotiobiettivi GROUP BY ID_mat_obi) contaobiettivi ON tab_materievoti.ID_mat = contaobiettivi.ID_mat_obi WHERE 1 = 1 ".$filsql." ".$ordsql;
	//$sql = "SELECT ID_mat, codmat_mat, descmateria_mat, aselme_mat, tipodoc_mat, ord_mat FROM tab_materievoti LEFT JOIN tab_materievotiobiettivi ON ID_mat = ID_mat_obi WHERE 1 = 1 ".$filsql." ".$ordsql;
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_mat, $codmat_mat, $descmateria_mat, $aselme_mat, $tipodoc_mat, $ord_mat, $n_obiettivi);
	$riga =  0;
	while (mysqli_stmt_fetch($stmt))
	{ 	$riga++;?>
		<tr>
			<td style="width:22px;">
				<img title='Cancella Materia' class="iconaStd" src='assets/img/Icone/times-circle-solid.svg'' onclick="showModalDeleteThisRecord(<?=$ID_mat?>, 'deleteMateriaP', 'questa materia dalla pagella', 'ELIMINAZIONE MATERIA DALLA PAGELLA');">
			</td>
			<td style="width:45px;">
				<button  id="goto<?=$ID_mat?>" style="width: 30px; font-size: 12px;"><?=$riga?></button>
			</td>
			<td class="w100px">
				<input class="tablecell6 disab val<?=$ID_mat?>" type="text"  id="codmat_mat<?=$ID_mat?>" name="codmat_mat" value = "<?=$codmat_mat?>" onchange="setMateriaP(<?=$ID_mat?>)">
			</td>
			<td class="w200px">
				<input class="tablecell6 disab val<?=$ID_mat?>" type="text" id="descmateria_mat<?=$ID_mat?>" name="descmateria_mat" value = "<?=$descmateria_mat?>" onchange="setMateriaP(<?=$ID_mat?>)">
			</td>
			<td class="w100px">
                <select name="selectaselme_mat" class="w100" id="selectaselme_mat<?=$ID_mat?>" onchange="setMateriaP(<?=$ID_mat?>)">
					<option value="-" <?if($tipodoc_mat > 10) {echo('selected');}?>>-</option> <!--aselme nel caso di certificazione delle competenze non serve-->
					<option value="AS" <?if($aselme_mat == 'AS') {echo('selected');}?>>Asilo</option>
                    <option value="EL" <?if($aselme_mat == 'EL') {echo('selected');}?>>Elementari</option>
                    <option value="ME" <?if($aselme_mat == 'ME') {echo('selected');}?>>Medie</option>
					<option value="SU" <?if($aselme_mat == 'SU') {echo('selected');}?>>Superiori</option>
                 </select>
            </td>
            <td style="width: 120px;">
                <select name="selecttipodoc_mat" class="w100" id="selecttipodoc_mat<?=$ID_mat?>" onchange="setMateriaP(<?=$ID_mat?>)">
                    <option value="1" <?if($tipodoc_mat == '1') {echo('selected');}?>>Pagella Tipo 1</option>
                    <option value="2" <?if($tipodoc_mat == '2') {echo('selected');}?>>Pagella Tipo 2</option>
					<option value="3" <?if($tipodoc_mat == '3') {echo('selected');}?>>Pagella Tipo 3</option>
					<option value="4" <?if($tipodoc_mat == '4') {echo('selected');}?>>Pagella Tipo 4</option>
					<option value="5" <?if($tipodoc_mat == '5') {echo('selected');}?>>Pagella Tipo 5</option>
					<option value="6" <?if($tipodoc_mat == '6') {echo('selected');}?>>Pagella Tipo 6</option>	
					<option value="11" <?if($tipodoc_mat == '11') {echo('selected');}?>>Cert. Competenze</option>
                 </select>
			</td>
			<td class="w50px">
				<input class="tablecell6 disab val<?=$ID_mat?>" type="text" id="ord_mat<?=$ID_mat?>" name="ord_mat" value = "<?=$ord_mat?>" onchange="setMateriaP(<?=$ID_mat?>)">
            </td>
			<td style="width: 60px;">
				<input class="tablecell6 disab val<?=$ID_mat?>" type="text" id="Obiettivi<?=$ID_mat?>" name="ord_mat" value = "<?=$n_obiettivi?>" readonly>
            </td>
			<td style="width:22px;">
				<img title='Inserisci Codici Obiettivi <?=$ID_mat?>' class="iconaStd" src='assets/img/Icone/circle-plus-blue.svg'' onclick="showModalInsertCodiciObiettivi(<?=$ID_mat?>);">
			</td>

		</tr>
    <?}

?>
<script>



	function setMateriaP(ID_mat) {
		let codmat_mat = $('#codmat_mat'+ID_mat).val();
		let descmateria_mat = $('#descmateria_mat'+ID_mat).val();
		let aselme_mat = $( "#selectaselme_mat"+ID_mat+" option:selected" ).val();
		let tipodoc_mat = $( "#selecttipodoc_mat"+ID_mat+" option:selected" ).val();
		//TUTTO DA SISTEMARE: non può funzionare così
		//if (tipodoc_mat == 3) {aselme_mat = aselme_mat.charAt(0)+"C";}
		let ord_mat = $('#ord_mat'+ID_mat).val();

		postData = { ID_mat: ID_mat, codmat_mat: codmat_mat, descmateria_mat: descmateria_mat, aselme_mat: aselme_mat, tipodoc_mat: tipodoc_mat, ord_mat: ord_mat};
		// console.log ("15qry_SetMaterieP.php - setMateriaP - postData a 15qry_updateMateriaP.php");
		// console.log (postData);
		$.ajax({
			type: 'POST',
			url: "15qry_updateMateriaP.php",
			data: postData,
			dataType: 'json',
			success: function(data){
                console.log (data.test);
				requerySetMaterieP();
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '15qry_SetMaterieP ##fname##'");     
			}
		});
	}

</script>

	
