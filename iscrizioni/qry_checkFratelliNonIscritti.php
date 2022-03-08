<? 
	include_once("../database/databaseBii.php");

    //estraggo tutti i fratelli in database B e verifico se sono tutti non iscritti.
    //se lo sono stoppo tutto
	
    //estraggo ID_fam_alu
    $sql = "SELECT ID_fam_alu FROM tab_anagraficaalunni WHERE ID_alu = ? ";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param ( $stmt, "i", $_POST['ID_alu']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $ID_fam_alu);
    while (mysqli_stmt_fetch($stmt)) {
    }
    
    //conto quanti dei fratelli della famiglia sono iscritti
    $sql = "SELECT ID_alu FROM tab_anagraficaalunni WHERE ID_fam_alu = ? AND noniscritto_alu = 0";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param ( $stmt, "i", $ID_fam_alu);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $ID_alu);
    $iscritti = 0;
    while (mysqli_stmt_fetch($stmt)) {
        $iscritti++;
    }
    $return['iscritti'] = $iscritti;

    $return['sql'] = $sql;

	echo json_encode($return);
    
?>