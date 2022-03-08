<?	include_once("database/databaseii.php");
	$step = $_POST['step'];
	$idpersonale_ver = $_POST['idpersonale_ver'];
	$idpersonale_verA = explode(",", $idpersonale_ver);
	if ($idpersonale_ver == "") { $idpersonale_verA = array(); }?>
	<select id="selectPersonale<?=$step?>" class="selectpicker multiselect-ui form-control" data-size="6" multiple="multiple" data-selected-text-format="count" multiple data-actions-box="true">
		<? $sql = "SELECT id_mae, nome_mae, cognome_mae FROM tab_anagraficamaestri WHERE in_organico_mae = 1 OR tipo_per = 1 ORDER BY cognome_mae";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $id_mae, $nome_mae, $cognome_mae);
		while (mysqli_stmt_fetch($stmt)) {
		?> <option value="<?=$id_mae?>" <?if (in_array($id_mae, $idpersonale_verA )) {echo ('selected');}?>><?=$cognome_mae." ".$nome_mae;?></option><?
		}?>
	</select>
<script>
	$(document).ready(function(){
		$('.selectpicker').selectpicker();
	});
</script>
	