<?	include_once("database/databaseii.php");
	$inputVal= $_REQUEST['inputVal'];
	//$sql = "SELECT `ID_cap`, `comune_cap`, `provincia_cap`, `CAP_cap` FROM `tab_CAP` WHERE comune_cap LIKE '%".$inputVal."%' ";
	$sql = "SELECT `ID_cap`, `comune_cap`, `provincia_cap`, `CAP_cap` FROM `tab_CAP` WHERE comune_cap LIKE CONCAT('%',?,'%') ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $inputVal );
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_cap, $comune_cap, $provincia_cap, $CAP_cap);
	mysqli_stmt_store_result($stmt);
	while (mysqli_stmt_fetch($stmt)) {
		echo "<p><span hidden>".$ID_cap."+</span><input id='comuneselected".$ID_cap."' style=' cursor: pointer; width: 90%; text-align: center; background-color: transparent; border: 0px;;' value=\"".($comune_cap)."\"><input id='provselected".$ID_cap."' value=\"".($provincia_cap)."\" hidden><input id='CAPselected".$ID_cap."' value=\"".($CAP_cap)."\" hidden></p>";
	}
?>
