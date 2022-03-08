<?	include_once("database/databaseii.php");
$classe_cls = $_POST['classe_cls'];

$sql = "SELECT aselme_cls FROM tab_classi WHERE classe_cls = ? ";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "s", $classe_cls);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $aselme_cls );
while (mysqli_stmt_fetch($stmt)) {
}
?>

<?
switch ($aselme_cls) {
	case "AS" :
		$campo = 'as_mtt';
		break;
	case "EL" :
		$campo = 'el_mtt';
		break;
	case "ME" :
		$campo = 'me_mtt';
		break;
	case "SU" :
		$campo = 'su_mtt';
		break;
}
//$sql = "SELECT codmat_mtt, descmateria_mtt FROM tab_materie ORDER BY ord_mtt";
//$sql1 = "SELECT codmat_mtt, descmateria_mtt FROM tab_materie WHERE codmat_mtt <> 'TUX' AND aselme_mtt LIKE CONCAT('%',?,'%')  ORDER BY ord_mtt";
$sql1 = "SELECT codmat_mtt, descmateria_mtt FROM tab_materie WHERE codmat_mtt <> 'TUX' AND ".$campo." = 1  ORDER BY descmateria_mtt";
$stmt1 = mysqli_prepare($mysqli, $sql1);
//mysqli_stmt_bind_param($stmt1, "s", $aselme_cls);
mysqli_stmt_execute($stmt1);
mysqli_stmt_bind_result($stmt1, $codmat_mtt, $descmateria_mtt );
while (mysqli_stmt_fetch($stmt1)) {
	?> <option value="<?=($codmat_mtt) ?>"><?=($descmateria_mtt)?></option><?
}?>


