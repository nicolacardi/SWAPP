<?	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	/* ora costruisco la clasuola ORDER BY sulla base di tutti i valori di ord */
	if (isset ($_POST['ord1'])){
		$ord1 = $_POST['ord1'];
		$ordsql = orderbysql( $ord1, 'parname_par', $ordsql);
	} 
	if (isset ($_POST['ord2'])){
		$ord2 = $_POST['ord2'];
		$ordsql = orderbysql( $ord2, 'val_par', $ordsql);
	} 
	if (isset ($_POST['ord3'])){
		$ord3 = $_POST['ord3'];
		$ordsql = orderbysql( $ord3, 'descrizione', $ordsql);
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
		$ordsql = ' ORDER BY ID_par';
	} else {
		$ordsql = ' ORDER BY ' .  substr($ordsql, 2) ;
	}
	$sql = "SELECT ID_par, parname_par, val_par, descrizione FROM tab_parametri ".$ordsql;
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_par, $parname_par, $val_par, $descrizione );
	$riga =  0;
	while (mysqli_stmt_fetch($stmt))
	{ 	$riga++;?>
		<tr>
			<td style="width:22px;">
				<!-- <img title='Cancella Utente <?//=$login_usr?>' style="width: 20px; cursor: pointer" src='assets/img/Icone/times-circle-solid.svg'' onclick="deleteLogin(<?//=$ID_usr?>);"> -->
			</td>
			<td style="width:22px;">
			</td>
			<td style="width:45px;">
				<button  id="goto<?=$ID_par?>" style="width: 30px; font-size: 12px;"><?=$riga?></button>
			</td>
			<td>
				<input class="tablecell6 disab w200px" type="text"  id="parname_par<?=$ID_par?>" value = "<?=$parname_par?>" disabled>
			</td>
			<td>
				<input class="tablecell6 disab" style="width: 300px;" type="text" id="val_par<?=$ID_par?>" value = "<?=$val_par?>" onchange="setValorePar(<?=$ID_par?>);" >
			</td>
			<td>
				<input class="tablecell6 disab" style="padding-left: 4px; padding-right: 5px; text-align: left; width: 300px; font-size: 10px; height: 24px;" type="text" id="descrizione<?=$ID_par?>" title = "<?=utf8_decode($descrizione)?>" value = "<?=utf8_decode($descrizione)?>" onchange="setValorePar(<?=$ID_par?>)">
				
			</td>
		</tr>
	<?}?>
<script>

	function setValorePar(ID_par) {
		let val_par = $('#val_par'+ID_par).val();
		let descrizione = $('#descrizione'+ID_par).val();
		let par_name = $('#parname_par'+ID_par).val();
		postData = { ID_par: ID_par, par_name: par_name, val_par: val_par, descrizione: descrizione};
		//  console.log ("15qry_SetParametri.php - setValorePar - postData a 15qry_updateParametro.php");
		//  console.log (postData);
		$.ajax({
			type: 'POST',
			url: "15qry_updateParametro.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				//  console.log ("15qry_SetParametri.php - setValorePar - ritorno da 15qry_updateParametro.php");
                //  console.log (data.test);
				$.ajax({
					type: 'POST',
					url: "setSessionParPage.php",
					data: postData,
					dataType: 'json',
					success: function(data){
					}
				});

			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '15qry_SetParametri ##fname##'");     
			}
		});
	}

</script>
