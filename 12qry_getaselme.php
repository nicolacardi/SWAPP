<?include_once("database/databaseii.php");
$classe_cls = $_POST['classe_cls'];
$sql = "SELECT aselme_cls FROM tab_classi WHERE classe_cls = ? ";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "s", $classe_cls);	
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $aselme_cls);
mysqli_stmt_store_result($stmt);
while (mysqli_stmt_fetch($stmt)) {}

$return['aselme_cls'] = $aselme_cls;

echo json_encode($return);
?>
