<?include_once("database/databaseii.php");
	$annoscolastico_cla = $_POST['annoscolastico_cla'];
	$sezione_cla = $_POST['sezione_cla'];
	$classe_cla = $_POST['classe_cla'];
	$idalunni_ver = $_POST['idalunni_ver'];
	$idalunni_verA = explode(",", $idalunni_ver);
	if ($idalunni_ver == "") { $idalunni_verA = array(); }
?>
	<span id="labelGenitori">Alunni i cui genitori erano  presenti</span><br>
	<!--<span style="font-size: 9px;">(usare ctrl o SHIFT per selezioni multiple)</span>-->
	<select id="selectGenitori" class="multiselect-ui form-control selectpicker" multiple="multiple" data-selected-text-format="count" multiple data-actions-box="true">
		<?
		$sql = "SELECT DISTINCT id_alu, nome_alu, cognome_alu FROM tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla WHERE annoscolastico_cla = ? AND classe_cla = ? AND sezione_cla = ? AND (listaattesa_cla = 0) ";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "sss", $annoscolastico_cla, $classe_cla, $sezione_cla);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $id_alu, $nome_alu, $cognome_alu);
		$i = 0;
		while (mysqli_stmt_fetch($stmt)) {
			?>
			<option value="<?=$id_alu?>" <?if (in_array($id_alu, $idalunni_verA )) {echo ('selected');}?>><?=$nome_alu." ".$cognome_alu?></option><?
			$i++;
		}?>
	</select>
<script>
	$(document).ready(function(){
		$('.selectpicker').selectpicker();
	});
</script>