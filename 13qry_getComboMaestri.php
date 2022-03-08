<?	include_once("database/databaseii.php");
$annoscolastico_cma = $_POST['annoscolastico_cma'];
$nome_mae = $_SESSION['nome_mae'];
$cognome_mae = $_SESSION['cognome_mae'];
?>
<div style="text-align: center; font-size: 14px; color: #3c3c3c;" >
	<?if ($_SESSION ["role_usr"] > 1){
		echo ("(insegnante ".$nome_mae. " ". $cognome_mae).")";
	} else {
		?>
		<select name="selectmaestro"  style="margin-left: 0px"  id="selectmaestro" onchange="copyToHiddenAndSetSession(); changedAnnoscolastico();">
			<? $sql = "SELECT DISTINCT ID_mae, nome_mae, cognome_mae FROM tab_anagraficamaestri JOIN tab_classimaestri ON ID_mae = ID_mae_cma WHERE annoscolastico_cma = '".$annoscolastico_cma."' ORDER BY cognome_mae ASC ";
			$stmt = mysqli_prepare($mysqli, $sql);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $ID_mae, $nome_mae, $cognome_mae);
			$k=0;
			while (mysqli_stmt_fetch($stmt)) {
			?>
				<option value="<?=$ID_mae?>" 
				<?//if ($ID_mae == $_SESSION['ID_mae']) {echo ('selected');}?>  
				><?=$cognome_mae." ".$nome_mae?> </option><?
				$k++;
			}?>
		</select>
	<?}?>
</div>
