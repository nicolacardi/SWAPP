<? include_once("database/databaseii.php");
$data_ora = $_POST ['data_ora'];
$ora_ora = $_POST['ora_ora'];
$supplente_ora = $_POST['supplente_ora'];
?>
	<select id="selectSupplente" style="margin-left:0px;">
		<option value="0" selected>-selezione supplente-</option>
		<?
		//$sql = "SELECT DISTINCT id_mae, nome_mae, cognome_mae FROM tab_anagraficamaestri LEFT JOIN tab_orario ON ID_mae = ID_mae_ora WHERE tipo_per = 0 AND NOT (data_ora = '".$data_ora."' AND ora_ora = ".$ora_ora.") ORDER BY cognome_mae";
		$sql = "SELECT ID_mae, nome_mae, cognome_mae FROM tab_anagraficamaestri WHERE tipo_per = 0 AND ID_mae NOT IN (SELECT DISTINCT id_mae FROM tab_anagraficamaestri LEFT JOIN tab_orario ON ID_mae = ID_mae_ora WHERE tipo_per = 0 AND (data_ora = ? AND ora_ora = ?)) AND in_organico_mae = 1 ORDER BY `tab_anagraficamaestri`.`cognome_mae` ASC";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "si", $data_ora, $ora_ora);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $id_mae, $nome_mae, $cognome_mae);
		while (mysqli_stmt_fetch($stmt)) {
		?> <option value="<?=$id_mae?>" <?if ($id_mae == $supplente_ora) {echo("selected");}?>><?=$cognome_mae." ".$nome_mae;?></option><?
		}?>
	</select>
