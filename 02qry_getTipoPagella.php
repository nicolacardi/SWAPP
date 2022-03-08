<?	include_once("database/databaseii.php");
//riceve in input SOLO l'anno scolastico e restituisce il tipo di pagella per le elementari e il tipo di pagella per le medie
$annoscolastico = $_POST['annoscolastico'];
$sql = "SELECT val_paa FROM tab_parametrixanno WHERE annoscolastico_paa = ? AND parname_paa = 'tipopagella_EL'";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "s", $annoscolastico);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $val_paa);
while (mysqli_stmt_fetch($stmt))
{}
$return['tipopagellaEL']= $val_paa;
//$_SESSION['tipopagellaEL'] = $val_paa;
$sql = "SELECT val_paa FROM tab_parametrixanno WHERE annoscolastico_paa = ? AND parname_paa = 'tipopagella_ME'";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "s", $annoscolastico);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $val_paa);
while (mysqli_stmt_fetch($stmt))
{}
$return['tipopagellaME']= $val_paa;
//$_SESSION['tipopagellaME'] = $val_paa;
echo json_encode($return);
?>

