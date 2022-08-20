<?	include_once("database/databaseii.php");
$dataperanno = $_POST['dataperanno']; //questa è la prima data della tabella: su questa base aggiorno anche la combo di scelta dei maestri
$IDmaeTMP = $_POST['IDmaeTMP'];
$nome_mae = $_SESSION['nome_mae'];
$cognome_mae = $_SESSION['cognome_mae'];
//ho messo in una variabile temporanea il valore che ha il maestro
//quindi aggiorno la combo maestri (in quanto potrebbe cambiare con il cambiare dell'ora!! per questo va aggiornata al setdates)
//rigenerare l'html che determina la combo (con questa routine)
//se c'è nella lista riselezionare IDmaeTMP
//se non c'è selezionare il primo come avviene per default
	

//trovo a quale anno scolastico fa riferimento la data selezionata
///estraggo l'anno e APPARTENGONO ALL'ANNO TUTTE//nella tabella tab_anniscolastici avrei le date di inizio e fine anno scolastico, e potrei utilizzare quelle, tuttavia cosa succede se le date di inizio e fine
//(come accade) non coprono l'anno intero? Cioè se la data che cerco è il 10/08 dell'anno a quale anno apparterrà?
//scelgo CONVENZIONALMENTE che IN QUESTO CASO (non nel caso del calcolo delle assenze) l' "anno scolastico" inizi il 01/09/xxxx e termini il 31/08/xxxx+1
//in questo caso il 10/08/2010, per esempio, apparterrà all'anno 2009-2010

$anno = substr($dataperanno, 0, 4);
if (substr($dataperanno,5,1)=="0") {
	$mese = substr($dataperanno, 6, 1);
} else {
	$mese = substr($dataperanno, 5, 2);
}
if ($mese < 9) {
	$annoscolastico_cma = ($anno -1)."-".substr($anno, 2,2);
} else {
	$annoscolastico_cma = ($anno)."-".substr(($anno+1), 2,2);
}




$sql1 = "SELECT DISTINCT ID_mae FROM tab_anagraficamaestri JOIN tab_classimaestri ON ID_mae = ID_mae_cma WHERE annoscolastico_cma = '".$annoscolastico_cma."'";
//QUERY PARAMETRICA DA FARE
$stmt1 = mysqli_prepare($mysqli, $sql1);
mysqli_stmt_execute($stmt1);
mysqli_stmt_bind_result($stmt1, $ID_maeSel);
$IDmaeTMPpresente = 0;
while (mysqli_stmt_fetch($stmt1)) {
	if ($ID_maeSel == $IDmaeTMP) { $IDmaeTMPpresente = 1;}
}
//a questo punto se IDmaeTMPpresente significa che il maestro che era selezionato C'E' ANCORA nella nuova combo che sto creando




?>
<div style="text-align: center; font-size: 14px; color: #3c3c3c;" >
	
	<?if ($_SESSION ["role_usr"] > 1){
		echo ("(insegnante ".$nome_mae. " ". $cognome_mae).")";
	} else {
		?>
		<?echo("maestri del ".$annoscolastico_cma);?>
		<select name="selectmaestro"  style="margin-left: 0px"  id="selectmaestro" onchange="copyToHiddenAndSetSession();">

			<? $sql = "SELECT DISTINCT ID_mae, nome_mae, cognome_mae FROM tab_anagraficamaestri JOIN tab_classimaestri ON ID_mae = ID_mae_cma WHERE annoscolastico_cma = '".$annoscolastico_cma."' ORDER BY cognome_mae ASC ";
			//QUERY PARAMETRICA DA FARE
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