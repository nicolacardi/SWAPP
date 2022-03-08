<?include_once("database/databaseii.php");
	$annoscolastico_asc = $_POST['annoscolastico_cma'];?>
	<select name="selectquadrimestre"  id="selectquadrimestre" onchange="requery();">
		<?
		$sql = "SELECT datainizio_asc, datafinequadrimestre1_asc, datafine_asc FROM tab_anniscolastici WHERE annoscolastico_asc  = ?";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "s", $annoscolastico_asc);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $datainizio_asc, $datafinequadrimestre1_asc, $datafine_asc);
		while (mysqli_stmt_fetch($stmt)) {
		?>
		<option value="<? echo ($datainizio_asc." ".$datafinequadrimestre1_asc) ?>">1^ Quadrimestre</option>
		<option value="<? echo ($datafinequadrimestre1_asc." ".$datafine_asc) ?>">2^ Quadrimestre</option><?
		}?>
	</select>
