<?include_once("database/databaseii.php");
	$ID_mae = intval($_POST ['ID_mae']);
	$annoscolastico_cma = $_POST['annoscolastico_cma'];?>
	<select name="selectmateria_new"   id="selectmateria_new" onchange="requery();">
		<?
		$sql = "SELECT DISTINCT codmat_cma, descmateria_mtt FROM tab_classimaestri LEFT JOIN tab_materie ON codmat_mtt = codmat_cma WHERE ID_mae_cma = ? AND annoscolastico_cma = ?";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "is", $ID_mae, $annoscolastico_cma);	
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $codmat_cma, $descmateria_mtt);
		$i = 0;
		while (mysqli_stmt_fetch($stmt)) {
			?>
			<option value="<?=$codmat_cma?>" <?if ($i==0) {echo ('selected');}?>><?=$descmateria_mtt?></option><?
			$i++;
		}?>
	</select>
