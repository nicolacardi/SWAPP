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
	



$sql = "SELECT DISTINCT ID_mae FROM tab_anagraficamaestri JOIN tab_classimaestri ON ID_mae = ID_mae_cma WHERE annoscolastico_cma = '".$annoscolastico_cma."'";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $ID_maeSel);
$IDmaeTMPpresente = 0;
while (mysqli_stmt_fetch($stmt)) {
	if ($ID_maeSel == $IDmaeTMP) { $IDmaeTMPpresente = 1;}
}
//a questo punto se IDmaeTMPpresente significa che il maestro che era selezionato C'E' ANCORA nella nuova combo che sto creando

?>
<div style="text-align: center; font-size: 14px; color: #3c3c3c;" >
	
	<?if ($_SESSION ["role_usr"] > 1){
		echo ("(insegnante ".$nome_mae. " ". $cognome_mae).")";
	} else {

		?>
		
		<select name="selectmaestro"  style="margin-left: 0px"  id="selectmaestro" onchange="copyToHiddenAndSetSession(); PopolaSelectClasse(); PopolaSelectAlunno(); Popola_tipopagella();">
			
			<? $sql = "SELECT DISTINCT ID_mae, nome_mae, cognome_mae FROM tab_anagraficamaestri JOIN tab_classimaestri ON ID_mae = ID_mae_cma WHERE annoscolastico_cma = '".$annoscolastico_cma."' ORDER BY cognome_mae ASC ";
				$stmt = mysqli_prepare($mysqli, $sql);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $ID_maeSel, $nome_mae, $cognome_mae);
				$k=0;
				
				while (mysqli_stmt_fetch($stmt)) {
				?>
					<option value="<?=$ID_maeSel?>" <?
						if (($IDmaeTMPpresente==0) && ($k==0)) {
							//se IDmaeTMP non c'è più (è stata cambiata la data e nella nuova combo NON C'E' PIU' il maestro che era selezionato) allora seleziono il primo maestro
							echo('selected');
							$_SESSION['ID_mae']= $ID_maeSel;
						} else if (($IDmaeTMPpresente==1) && ($ID_maeSel ==$IDmaeTMP)) {
							//se IDmaeTMP c'è ancora (è stata cambiata la data e nella nuova combo C'E' ANCORA il maestro che era selezionato) allora riseleziono il maestro che era selezionato
							echo('selected');
							$_SESSION['ID_mae']= $ID_maeSel;
						}
					?>><?=$cognome_mae." ".$nome_mae?> </option><?
					$k++;
				}?>
		</select>
		
	<?}?>
	<input id="hidden_ID_mae" type="text" value ='<?=$_SESSION['ID_mae'];?>' hidden>
</div>
