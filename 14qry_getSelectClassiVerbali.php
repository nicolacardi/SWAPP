<?include_once("database/databaseii.php");
	$ID_mae = intval($_POST ['ID_mae']);
	$annoscolastico_cma = $_POST['annoscolastico_cma'];
?>
	<select name="selectclasse"   id="selectclasse" onchange="changedClasse();">
		<?
		$sql = "SELECT DISTINCT classe_cma, sezione_cma, desc_cls, ord_cls FROM tab_classimaestri LEFT JOIN tab_classi ON classe_cma = classe_cls WHERE ID_mae_cma = ? AND annoscolastico_cma = ? ORDER BY ord_cls";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "is", $ID_mae, $annoscolastico_cma);	
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $classe_cma, $sezione_cma, $desc_cls, $ord_cls);
		$i = 0;
		$classiA = array();
		$desc_clsA =  array();
		while (mysqli_stmt_fetch($stmt)) {
			$i++;
			$classiA[$i] = $classe_cma;
			$desc_clsA[$i] = $desc_cls;
		}

		// 210207 //MODIFICA TEMPORANEA VEDI ANCHE ALTROVE
		// $sql = "SELECT DISTINCT classe_cma, sezione_cma, desc_cls, ord_cls FROM tab_classimaestri LEFT JOIN tab_classi ON classe_cma = classe_cls WHERE tutor_cma = ? AND annoscolastico_cma = ? ORDER BY ord_cls";
		// $stmt = mysqli_prepare($mysqli, $sql);
		// mysqli_stmt_bind_param($stmt, "is", $ID_mae, $annoscolastico_cma);	
		// mysqli_stmt_execute($stmt);
		// mysqli_stmt_bind_result($stmt, $classe_cma, $sezione_cma, $desc_cls, $ord_cls);
		// while (mysqli_stmt_fetch($stmt)) {
		// 	if (!(in_array($classe_cma, $classiA))) {
		// 		$i++;
		// 		$classiA[$i] =  $classe_cma;
		// 		$desc_clsA[$i] = $desc_cls;
		// 	}
		// }




		for ($x = 1; $x <= $i; $x++) {
			?>
			<option value="<?=$classiA[$x]?>" <?if ($x==1) {echo ('selected');}?>><?=$desc_clsA[$x]?></option><?
		}?>
	</select>
<?//print_r($classiA);?>
<?//echo($i);?>
<?//echo($sql);?>
<?//echo($ID_mae);?>


