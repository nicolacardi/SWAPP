<?	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	/* ora costruisco la clasuola ORDER BY sulla base di tutti i valori di ord */
	if (isset ($_POST['ord1'])){
		$ord1 = $_POST['ord1'];
		$ordsql = orderbysql( $ord1, 'annoscolastico_paa', $ordsql);
	} 
	if (isset ($_POST['ord2'])){
		$ord2 = $_POST['ord2'];
		$ordsql = orderbysql( $ord2, 'parname_paa', $ordsql);
	} 
	if (isset ($_POST['ord3'])){
		$ord3 = $_POST['ord3'];
		$ordsql = orderbysql( $ord3, 'val_paa', $ordsql);
    } 
    if (isset ($_POST['ord4'])){
		$ord4 = $_POST['ord4'];
		$ordsql = orderbysql( $ord4, 'val2_paa', $ordsql);
    } 
    if (isset ($_POST['ord5'])){
		$ord5 = $_POST['ord5'];
		$ordsql = orderbysql( $ord5, 'tipovoti_paa', $ordsql);
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
		$ordsql = ' ORDER BY annoscolastico_paa, parname_paa ';
	} else {
		$ordsql = ' ORDER BY ' .  substr($ordsql, 2) .' , annoscolastico_paa, parname_paa ';
	}
	$sql = "SELECT ID_paa, annoscolastico_paa, parname_paa, val_paa, val2_paa, tipovoti_paa, nchar_paa FROM tab_parametrixanno ".$ordsql;
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_paa, $annoscolastico_paa, $parname_paa, $val_paa, $val2_paa, $tipovoti_paa, $nchar_paa );
	$riga =  0;
	while (mysqli_stmt_fetch($stmt))
	{ 	$riga++;?>
		<tr>
			<td style="width:22px;">
				<!-- <img title='Cancella Utente <?//=$login_usr?>' class="iconaStd" src='assets/img/Icone/times-circle-solid.svg'' onclick="deleteLogin(<?//=$ID_usr?>);"> -->
			</td>
			<td style="width:22px;">
			</td>
			<td style="width:45px;">
				<button  id="goto<?=$ID_paa?>" style="width: 30px; font-size: 12px;"><?=$riga?></button>
            </td>
            <td>
				<input class="tablecell6 disab w100px" type="text"  id="annoscolastico_paa<?=$ID_paa?>" value = "<?=$annoscolastico_paa?>" disabled>
			</td>
			<td>
				<input class="tablecell6 disab w150px" type="text"  id="parname_paa<?=$ID_paa?>" value = "<?=$parname_paa?>" onchange="setValoreParA(<?=$ID_paa?>)">
			</td>
			<td>
				<input class="tablecell6 disab w50px" type="text" id="val_paa<?=$ID_paa?>" value = "<?=$val_paa?>" onchange="setValoreParA(<?=$ID_paa?>)" >
            </td>
            <td>
				<input class="tablecell6 disab w50px" type="text" id="val2_paa<?=$ID_paa?>" value = "<?=$val2_paa?>" onchange="setValoreParA(<?=$ID_paa?>)" >
			</td>
            <td>
				<input class="tablecell6 disab w80px" type="text" id="tipovoti_paa<?=$ID_paa?>" value = "<?=$tipovoti_paa?>" onchange="setValoreParA(<?=$ID_paa?>)" >
			</td>
			<td>
				<input class="tablecell6 disab w80px" type="text" id="nchar_paa<?=$ID_paa?>" value = "<?=$nchar_paa?>" onchange="setValoreParA(<?=$ID_paa?>)" >
			</td>
		</tr>
	<?}?>
<script>

	function setValoreParA(ID_paa) {
		let val_paa = $('#val_paa'+ID_paa).val();
		let val2_paa = $('#val2_paa'+ID_paa).val();
        let parname_paa = $('#parname_paa'+ID_paa).val();
        let tipovoti_paa = $('#tipovoti_paa'+ID_paa).val();
		let nchar_paa = $('#nchar_paa'+ID_paa).val();
		postData = { ID_paa: ID_paa, parname_paa: parname_paa, val_paa: val_paa, val2_paa: val2_paa, tipovoti_paa: tipovoti_paa, nchar_paa: nchar_paa};
		console.log ("15qry_SetParametriA.php - setValoreParA - postData a 15qry_updateParametroA.php");
		console.log (postData);
		$.ajax({
			type: 'POST',
			url: "15qry_updateParametroA.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				 //console.log ("15qry_SetParametriA.php - setValoreParA - ritorno da 15qry_updateParametroA.php");
                 //console.log (data.test);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '15qry_SetParametriA ##fname##'");     
			}
		});
	}

</script>
