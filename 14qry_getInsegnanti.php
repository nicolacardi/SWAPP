<?include_once("database/databaseii.php");
	$iddocenti_ver = $_POST['iddocenti_ver'];
	$iddocenti_verA = explode(",", $iddocenti_ver);
	if ($iddocenti_ver == "") { $iddocenti_verA = array(); }
?>
	<span>Membri Collegio presenti</span><br>
	<!--<span style="font-size: 9px;">(usare ctrl o SHIFT per selezioni multiple)</span>-->
	<!--data-max-options="5" per settare numero massimo -->
	<select id="selectInsegnanti" style="height: 80px;" class="selectpicker multiselect-ui form-control" multiple="multiple" data-selected-text-format="count" multiple data-actions-box="true">
		<? $sql = "SELECT id_mae, nome_mae, cognome_mae FROM tab_anagraficamaestri ORDER BY cognome_mae";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $id_mae, $nome_mae, $cognome_mae);
		while (mysqli_stmt_fetch($stmt)) {
		?> <option value="<?=$id_mae?>" <?if (in_array($id_mae, $iddocenti_verA )) {echo ('selected');}?>><?=$cognome_mae." ".$nome_mae;?></option><?
		}?>
	</select>
<script>
	$(document).ready(function(){
		$('.selectpicker').selectpicker();
	});
</script>
	