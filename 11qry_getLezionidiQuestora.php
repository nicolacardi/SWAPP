<? include_once("database/databaseii.php");
$data_ora = $_POST ['data_ora'];
$ora_ora = $_POST['ora_ora'];
$ID_mae_ora_NEW = $_SESSION['ID_mae'];
?>
	<select id="selectLezionidiQuestOra" style="margin-left:0px;" onchange="updateBtnOK2();">
		<option value="0" selected>-NESSUNA-</option>
		<?;
		$sql = "SELECT ID_ora, ID_mae_ora, classe_ora, sezione_ora, data_ora, ora_ora, codmat_ora, descmateria_mtt, nome_mae, cognome_mae FROM (tab_orario LEFT JOIN tab_materie ON codmat_ora = codmat_mtt LEFT JOIN tab_anagraficamaestri ON ID_mae = ID_mae_ora) LEFT JOIN tab_classi ON classe_ora = classe_cls WHERE data_ora = ? AND ora_ora = ? AND codmat_ora <> 'XX1' AND codmat_ora <> 'XX3' AND codmat_ora <> 'XX2' AND codmat_ora <> 'nom' AND firma_mae_ora = 0 ORDER BY ord_cls";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "si", $data_ora, $ora_ora);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $ID_ora, $ID_mae_ora, $classe_ora, $sezione_ora, $data_ora, $ora_ora, $codmat_ora, $descmateria_mtt, $nome_mae, $cognome_mae);
		while (mysqli_stmt_fetch($stmt)) {
		?> <option value="<?=$ID_ora."-".$ID_mae_ora?>"><?=" ".$classe_ora." ".$sezione_ora." - ".$descmateria_mtt." - maestro ".$nome_mae." ".$cognome_mae;?></option><?
		}?>
	</select>

<script>
	
	
	function updateBtnOK2(){
		let ID_ora_ID_mae_ora = $('#selectLezionidiQuestOra').val();
		let parts = ID_ora_ID_mae_ora.split("-");
		let ID_ora = parseInt(parts[0], 10);
		let ID_mae_ora = parseInt(parts[1], 10);
		//let ID_mae_ora = $('#hiddenmodalIoSostituiscoID_mae_ora').val();
		$('#btn_OKIoSostituisco').attr('onclick','saveFirma_ChiudiModal('+ID_ora+' , '+ID_mae_ora+')');
	}
</script>