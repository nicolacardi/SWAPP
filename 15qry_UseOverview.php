<?	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	/* ora costruisco la clausola ORDER BY sulla base di tutti i valori di ord */
	if (isset ($_POST['ord1'])){
		$ord1 = $_POST['ord1'];
		$ordsql = orderbysql( $ord1, 'login_usr', $ordsql);
	} 
	if (isset ($_POST['ord2'])){
		$ord2 = $_POST['ord2'];
		$ordsql = orderbysql( $ord2, 'role_usr', $ordsql);
	} 
	if (isset ($_POST['ord3'])){
		$ord3 = $_POST['ord3'];
		$ordsql = orderbysql( $ord3, 'accessnumber_usr', $ordsql);
	} 
	if (isset ($_POST['ord4'])){
		$ord4 = $_POST['ord4'];
		$ordsql = orderbysql( $ord4, 'currlogon_usr', $ordsql);
	}
	if (isset ($_POST['ord5'])){
		$ord5 = $_POST['ord5'];
		$ordsql = orderbysql( $ord5, 'nonmostrarepiu_usr', $ordsql);
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
		$ordsql = ' ORDER BY accessnumber_usr DESC, currlogon_usr, login_usr ';
	} else {
		$ordsql = ' ORDER BY ' .  substr($ordsql, 2) ;
	}
	$sql = "SELECT ID_usr, login_usr, role_usr, accessnumber_usr, currlogon_usr, nonmostrarepiu_usr FROM tab_users ".$ordsql;
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_usr, $login_usr, $role_usr, $accessnumber_usr, $currlogon_usr, $nonmostrarepiu_usr );
	$riga =  0;
	while (mysqli_stmt_fetch($stmt))
	{ 	$riga++;?>
		<tr>
			<td style="width:22px;">
				<img title='Cancella Utente <?=$login_usr?>' class="iconaStd" src='assets/img/Icone/times-circle-solid.svg'' onclick="showModalDeleteThisRecord(<?=$ID_usr?>, 'deleteLogin', 'questo utente', 'ELIMINAZIONE UTENTE');">
			</td>
			<td style="width:22px;">
				<img title='Modifica Password' class="iconaStd" src='assets/img/Icone/unlock-solid.svg' onclick="showModalChgPsw(<?=$ID_usr?>, '<?=$login_usr?>');" >
			</td>
			<td style="width:45px;">
				<button  id="utente<?=$ID_usr?>" style="width: 30px; font-size: 12px;"><?=$riga?></button>
			</td>
			<td>
				<input class="tablecell6 disab" style="width: 150px;" type="text"  id="login_usr<?=$ID_usr?>" value = "<?=$login_usr?>" disabled>
			</td>
			<td>
				<input class="tablecell6 disab w100px" type="text" id="role_usr<?=$ID_usr?>" value = "<?=$role_usr?>" disabled>
			</td>
			<td>
				<input class="tablecell6 disab" style="width: 70px;" type="text" id="accessnumber_usr<?=$ID_usr?>" value = "<?=$accessnumber_usr?>" disabled>
			</td>
			<td>
				<input class="tablecell6 disab" style="width: 170px;" type="text" id="currlogon_usr<?=$ID_usr?>" value = "<?=$currlogon_usr?>" disabled>
			</td>
			<td>
				<input class="tablecell6 disab w100px" type="checkbox" id="nonmostrarepiu_usr<?=$ID_usr?>" <?if ($nonmostrarepiu_usr == 1) {echo("checked");}?> onclick="SetNonMostrarePiu(<?=$ID_usr?>);">
			</td>
		</tr>
	<?}?>

	
<script>
	



	
	function SetNonMostrarePiu (ID_usr) {
		if (ID_usr == 0) {
			nonmostrarepiu_usr = 0;
		} else {
			nonmostrarepiu_usr = $("#nonmostrarepiu_usr"+ID_usr).is(":checked");
			if (nonmostrarepiu_usr) {nonmostrarepiu_usr=1;} else {nonmostrarepiu_usr=0;}
		}
		postData = { ID_usr: ID_usr, nonmostrarepiu_usr: nonmostrarepiu_usr };
		console.log (postData);
		$.ajax({
			type: 'POST',
			url: "15qry_updateNonMostrarePiu.php",
			data: postData,
			dataType: 'json',
			success: function(){
				requeryUseOverview();
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '15qry_UseOverview ##fname##'");     
			}
		});
		
	}
	

	

</script>
