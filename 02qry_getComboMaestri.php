<?	include_once("database/databaseii.php");
$annoscolastico_cma = $_POST['annoscolastico_cma'];
$IDmaeTMP = $_POST['IDmaeTMP'];
$nome_mae = $_SESSION['nome_mae'];
$cognome_mae = $_SESSION['cognome_mae'];
//ho messo in una variabile temporanea il valore che ha il maestro
//quindi aggiorno la combo maestri (in quanto potrebbe cambiare con il cambiare dell'anno scolastico!! per questo va aggiornata al cambio anno scolastico)
//rigenerare l'html che determina la combo (con questa routine)
//se c'è nella lista riselezionare IDmaeTMP
//se non c'è selezionare il primo come avviene per default
	



$sql = "SELECT DISTINCT ID_mae FROM tab_anagraficamaestri JOIN tab_classimaestri ON ID_mae = ID_mae_cma WHERE annoscolastico_cma = ?";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cma);	
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $ID_maeSel);
$IDmaeTMPpresente = 0;
while (mysqli_stmt_fetch($stmt)) {
	if ($ID_maeSel == $IDmaeTMP) { $IDmaeTMPpresente = 1;}
}

			// 210207 //MODIFICA TEMPORANEA!!!! finora quando aggiungo un tutor NON creo un suo record. Questo significa che se un maestro fa da tutor in dieci classi ma non è maestro titolare ("tutorato") in nessuna, la select precedente non restituisce alcuna classe, e non è corretto (vedi casi Verona in cui Alessandra Avanzato è seconda firma ovunque ma prima firma mai...)
			// //Andrà modificata la logica: quando un insegnante è Tutor bisogna creare un record in tab_classimaestri (con tutti i crismi del caso) e quindi la select qui sopra sarà sufficiente.
			// //nel transitorio, in attesa di questa modifica, creo una nuova SELECT che guarda ai valori nel campo tutor_cma
			// $sql = "SELECT DISTINCT ID_mae FROM tab_anagraficamaestri JOIN tab_classimaestri ON ID_mae = tutor_cma WHERE annoscolastico_cma = ?";
			// $stmt = mysqli_prepare($mysqli, $sql);
			// mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cma);	
			// mysqli_stmt_execute($stmt);
			// mysqli_stmt_bind_result($stmt, $ID_maeSel);
			// while (mysqli_stmt_fetch($stmt)) {
			// 	if ($ID_maeSel == $IDmaeTMP) { $IDmaeTMPpresente = 1;}
			// }

//a questo punto se IDmaeTMPpresente = 1 significa che il maestro che era selezionato C'E' ANCORA nella nuova combo che sto creando

?>
<div style="text-align: right; margin-right: 5px; margin-top: 5px; font-size: 11px; color: #3c3c3c;" >
	
	<?if ($_SESSION ["role_usr"] > 1){
		echo ("(insegnante ".$nome_mae. " ". $cognome_mae).")";
	} else {

		?>
		
		<select name="selectmaestro"  style="margin-left: 0px"  id="selectmaestro" onchange="copyToHiddenAndSetSession();">
			
			<? $sql = "SELECT DISTINCT ID_mae, nome_mae, cognome_mae FROM tab_anagraficamaestri JOIN tab_classimaestri ON ID_mae = ID_mae_cma WHERE annoscolastico_cma = ? ORDER BY cognome_mae ASC ";
				$ID_maeSelA = array();
				$nome_maeA = array();
				$cognome_maeA = array();
				$stmt = mysqli_prepare($mysqli, $sql);
				mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cma);	
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $ID_maeSel, $nome_mae, $cognome_mae);
				$k=0;
				while (mysqli_stmt_fetch($stmt)) {
					$k++;
					$ID_maeSelA[$k] = $ID_maeSel;
					$nome_maeA[$k] = $nome_mae;
					$cognome_maeA[$k] = $cognome_mae;
				}


				// 210207 //Aggiungo quanto segue TEMPORANEAMENTE fino a che non eseguirò la modifica sopra descritta, aggiungo anche i maestri solo tutor
				// $sql = "SELECT DISTINCT ID_mae, nome_mae, cognome_mae FROM tab_anagraficamaestri JOIN tab_classimaestri ON ID_mae = tutor_cma WHERE annoscolastico_cma = ? ORDER BY cognome_mae ASC ";
				// $stmt = mysqli_prepare($mysqli, $sql);
				// mysqli_stmt_bind_param($stmt, "s", $annoscolastico_cma);	
				// mysqli_stmt_execute($stmt);
				// mysqli_stmt_bind_result($stmt, $ID_maeSel, $nome_mae, $cognome_mae);
				// while (mysqli_stmt_fetch($stmt)) {
				// 	//inserire solo se già non c'è!!!!
				// 	if (!(in_array($ID_maeSel, $ID_maeSelA))) {
				// 		$k++;
				// 		$ID_maeSelA[$k] = $ID_maeSel;
				// 		$nome_maeA[$k] = $nome_mae;
				// 		$cognome_maeA[$k] = $cognome_mae;
				// 	}
				// }

				//ora ciclo nell'array
				
				
				for ($x = 1; $x <= $k; $x++) {
				?>
					<option value="<?=$ID_maeSelA[$x]?>" <?
						if (($IDmaeTMPpresente==0) && ($x==1)) {
							//se IDmaeTMP non c'è più (è stata cambiata la data e nella nuova combo NON C'E' PIU' il maestro che era selezionato) allora seleziono il primo maestro
							echo('selected');
							$_SESSION['ID_mae']= $ID_maeSelA[$x];
						} else if (($IDmaeTMPpresente==1) && ($ID_maeSelA[$x] ==$IDmaeTMP)) {
							//se IDmaeTMP c'è ancora (è stata cambiata la data e nella nuova combo C'E' ANCORA il maestro che era selezionato) allora riseleziono il maestro che era selezionato
							echo('selected');
							$_SESSION['ID_mae']= $ID_maeSelA[$x];
						}
					?>><?=$cognome_maeA[$x]." ".$nome_maeA[$x]?> </option><?
				}?>
		</select>
		
	<?}?>
	<input id="hidden_ID_mae" type="text" value ='<?=$_SESSION['ID_mae'];?>' hidden>
</div>
