<?include_once("database/databaseii.php");

$sql = "SELECT MAX(ord_cls) as Maxord_cls FROM tab_classi;";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $Maxord_cls);
while (mysqli_stmt_fetch($stmt)) {
}

$return['maxOrd_cls']= $Maxord_cls;
//$_SESSION['tipopagellaME'] = $val_paa;
echo json_encode($return);
?>

