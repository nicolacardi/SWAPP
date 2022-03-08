<? 
	include_once("../database/databaseBii.php");

    $genitore = $_POST['genitore'];
    $ID_fam = $_POST[''];
    $ckmadreesclusadanucleo_fam = $_POST['ckmadreesclusadanucleo_fam'];
    $ckpadreesclusodanucleo_fam = $_POST['ckpadreesclusodanucleo_fam'];

    if ($genitore == "padre") {
        $sql2 = "UPDATE tab_famiglie SET ckpadreesclusodanucleo_fam = ?  WHERE ID_fam = ". $_SESSION['ID_fam'];
        $stmt2 = mysqli_prepare($mysqli, $sql2);
        mysqli_stmt_bind_param($stmt2, "i", $ckpadreesclusodanucleo_fam);
    } else {
        $sql2 = "UPDATE tab_famiglie SET ckmadreesclusadanucleo_fam = ?  WHERE ID_fam = ". $_SESSION['ID_fam'];
        $stmt2 = mysqli_prepare($mysqli, $sql2);
        mysqli_stmt_bind_param($stmt2, "i", $ckmadreesclusadanucleo_fam);

    }

	
	mysqli_stmt_execute($stmt2);

	$return['sql'] = $sql2;
	echo json_encode($return);
    
?>