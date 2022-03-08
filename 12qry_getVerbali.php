<?	include_once("database/databaseii.php");
	$annoscolastico_ver = $_POST['annoscolastico_ver'];
	$sezione_ver = $_POST['sezione_ver'];
	$classe_ver = $_POST['classe_ver']; ?>
	<select id="selectverbale" style="width: 342px; ">
		<?
		$sql = "SELECT DISTINCT num_ver, tipo_ver, numtipo_ver, titolo_ver FROM tab_verbali WHERE annoscolastico_ver = ? AND classe_ver = ? AND sezione_ver = ? ORDER BY tipo_ver";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "sss", $annoscolastico_ver, $classe_ver, $sezione_ver);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $num_ver, $tipo_ver, $numtipo_ver, $titolo_ver);
		$i = 0;
		while (mysqli_stmt_fetch($stmt)) {
			switch ($tipo_ver) {
				case 1:
					$titoloToWrite =  " Cons.Classe n.".$numtipo_ver;
					break;
				case 2:
					$titoloToWrite =  " Riun. con i Gen. n.".$numtipo_ver;
					break;
				case 3:
					$titoloToWrite =  " Coll. Docenti n.".$numtipo_ver;
					break;
				default:        
				}


			?>
			<option value="<?=$num_ver?>"><?=$titoloToWrite." - Verb.# ".$num_ver."-'".$titolo_ver."'"?></option><?
			$i++;
		}?>
	</select>