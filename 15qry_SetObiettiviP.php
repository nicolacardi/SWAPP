<?	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("assets/functions/sqlBuildFunctions.php");

	/* ora costruisco la clasuola ORDER BY sulla base di tutti i valori di ord */
	if (isset ($_POST['ord1'])){
		$ord1 = $_POST['ord1'];
		$ordsql = orderbysql( $ord1, 'codob_obi', $ordsql);
	} 
	if (isset ($_POST['ord2'])){
		$ord2 = $_POST['ord2'];
		$ordsql = orderbysql( $ord2, 'descmateria_mtt', $ordsql);
	} 
	if (isset ($_POST['ord3'])){
		$ord3 = $_POST['ord3'];
		$ordsql = orderbysql( $ord3, 'classe_obd', $ordsql);
	} 
	if (isset ($_POST['ord4'])){
		$ord4 = $_POST['ord4'];
		$ordsql = orderbysql( $ord4, 'desc_obd', $ordsql);
	}
	if (isset ($_POST['ord5'])){
		$ord5 = $_POST['ord5'];
		$ordsql = orderbysql( $ord5, 'ord_obd', $ordsql);
    }

	

	if ($ordsql == '') {
		$ordsql = ' ORDER BY codob_obi, classe_obd, ord_obd';
	} else {
		$ordsql = ' ORDER BY ' .  substr($ordsql, 2) ;
	}


	/* costruisco la clausola FILTER BY sulla base di tutti i valori di fil */
	if (isset ($_POST['fil1'])){
		$fil1 = addslashes($_POST['fil1']);
		$filsql = filterbysqlexplode( $fil1, 'codob_obi', $filsql);
	} 
	if (isset ($_POST['fil2'])){
		$fil2 = addslashes($_POST['fil2']);
		$filsql = filterbysqlexplode( $fil2, 'descmateria_mat', $filsql);
	} 
	if (isset ($_POST['fil3'])){
		$fil3 = addslashes($_POST['fil3']);
		$filsql = filterbysqlexplode( $fil3, 'classe_obd', $filsql);
	}
	if (isset ($_POST['fil4'])){
		$fil4 = addslashes($_POST['fil4']);
		$filsql = filterbysqlexplode( $fil4, 'desc_obd', $filsql);
	} 




$sql= "SELECT ID_obd, codob_obi, descmateria_mat, classe_obd, desc_obd, ord_obd FROM (tab_materievotiobiettividesc LEFT JOIN tab_materievotiobiettivi ON ID_obi = ID_obi_obd) LEFT JOIN tab_materievoti ON ID_mat = ID_mat_obi WHERE 1=1 ".$filsql." ".$ordsql;

	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_obd, $codob_obi, $descmateria_mat, $classe_obd, $desc_obd, $ord_obd);
	$riga =  0;
	while (mysqli_stmt_fetch($stmt))
	{ 	$riga++;?>
		<tr>
			<td style="width:22px;">
				<img title='Duplica Obiettivo per questa classe' class="iconaStd" src='assets/img/Icone/duplicate.svg'' onclick="duplicateObiettivo(<?=$ID_obd?>);">
			</td>
			<td style="width:22px;">
				<img title='Cancella Descrizione Obiettivo per questa classe' class="iconaStd" src='assets/img/Icone/times-circle-solid.svg'' onclick="showModalDeleteThisRecord(<?=$ID_obd?>, 'deleteDescObiettivoP', 'questo obiettivo da questa classe e materia nella pagella', 'ELIMINAZIONE OBIETTIVO DALLA PAGELLA');">
			</td>
			<td style="width:45px;">
				<button  id="goto<?=$ID_obd?>" style="width: 30px; height: 46px; font-size: 12px; "><?=$riga?></button>
			</td>
			<td class="w100px">
				<input class="tablecell6 disab val<?=$ID_obd?> h46" type="text"  id="codob_obi<?=$ID_obd?>" name="codob_obi" value = "<?=$codob_obi?>" onchange="setObiettivoP(<?=$ID_obd?>)" readonly>
			</td>
			<td class="w200px">
				<input class="tablecell6 disab val<?=$ID_obd?> h46" type="text" id="dec_materia_mat<?=$ID_obd?>" name="dec_materia_mat" value = "<?=$descmateria_mat?>" onchange="setObiettivoP(<?=$ID_obd?>)" readonly>
			</td>
			<td class="w100px">
				<input class="tablecell6 disab val<?=$ID_obd?> h46" type="text" id="classe_obd<?=$ID_obd?>" name="classe_obd" value = "<?=$classe_obd?>" onchange="setObiettivoP(<?=$ID_obd?>)">
            </td>
            <td style="width: 420px;">
			<!-- <input class="tablecell6 disab val<?//=$ID_obd?> text-left" type="text" id="desc_obd<?//=$ID_obd?>" name="desc_obd" value = "<?//=$desc_obd?>" onchange="setObiettivoP(<?//=$ID_obd?>)"> -->
                <textarea class="tablecell6 disab val<?=$ID_obd?> text-left" id="desc_obd<?=$ID_obd?>"  style="margin-top: 5px; min-height: 46px; resize: vertical;" onchange="setObiettivoP(<?=$ID_obd?>)"><?=$desc_obd?></textarea>
			</td>
			<td class="w50px">
				<input class="tablecell6 disab val<?=$ID_obd?> h46" type="text" id="ord_obd<?=$ID_obd?>" name="ord_obd" value = "<?=$ord_obd?>" onchange="setObiettivoP(<?=$ID_obd?>)">
            </td>

		</tr>
    <?}

?>
<script>



function setObiettivoP(ID_obd) {
	let classe_obd = $('#classe_obd'+ID_obd).val();
	let desc_obd = $('#desc_obd'+ID_obd).val();
	let ord_obd = $( "#ord_obd"+ID_obd).val();

	postData = { ID_obd: ID_obd, classe_obd: classe_obd, desc_obd: desc_obd, ord_obd: ord_obd};
	console.log ("15qry_SetObiettiviP.php - setObiettivoP - postData a 15qry_updateObiettivoP.php");
	console.log (postData);
	$.ajax({
		type: 'POST',
		url: "15qry_updateObiettivoP.php",
		data: postData,
		dataType: 'json',
		success: function(data){

			// console.log ("15qry_SetObiettiviP.php - setObiettivoP - ritorno da 15qry_updateObiettivoP.php");
			//console.log (data.test);
			requerySetObiettiviP();
		},
		error: function(){
			alert("Errore: contattare l'amministratore fornendo il codice di errore '15qry_SetObiettiviP setObiettivoP'");     
		}
	});
}

</script>

	
