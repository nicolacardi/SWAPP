<?	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	$annoscolastico_ver = $_POST['annoscolastico_ver'];
	$classe_selezionata = $_POST['classe_selezionata'];
	$sezione_selezionata = $_POST['sezione_selezionata'];
	$ID_mae= $_POST['ID_mae'];

	//**************** per fase test e vedere se ci stanno le stringhe

function generateRandomString($testlength) {

    $characters = '                    0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $testlength; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
//****************+ fine test


	
	//$sql = "SELECT DISTINCT num_ver, tipo_ver, titolo_ver, data_ver, classe_ver FROM tab_verbali WHERE annoscolastico_ver = ? AND ((classe_ver = ? AND sezione_ver = ? ) OR (tipo_ver = 3) OR (CONCAT(',',iddocenti_ver,',') LIKE '%,".$ID_mae.",%')) ORDER BY data_ver";
	//In questo modo vengono mostrati anche i verbali in cui un maestro è stato INVITATO ma la classe non è sua
	//Tolgo la visibilità sui verbali a cui uno è stato invitato
	
	if ($ID_mae == "0") { //questa if servirebbe /MA NON VIENE USATA AL MOMENTO quando si volesse selezionare TUTTI i verbali. In verità è vero che funziona: si possono elencare tutti i verbali.
		//tuttavia una volta elencati non si possono aprire in quanto selezionando "tutti" non si popola la combo classe (ovviamente) e quindi non si riesce ad aprire un singolo verbale
		//in quanto l'apertura di un singolo verbale fa affidamento proprio sulla combo classe e sulla combo sezione. Andrebbe modificato radicalmente...va riprogettato
		$sql = "SELECT DISTINCT num_ver, tipo_ver, titolo_ver, data_ver, classe_ver FROM tab_verbali WHERE annoscolastico_ver = ? ORDER BY data_ver";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "s", $annoscolastico_ver);	
	} else {
		$sql = "SELECT DISTINCT num_ver, tipo_ver, titolo_ver, data_ver, classe_ver FROM tab_verbali WHERE annoscolastico_ver = ? AND ((classe_ver = ? AND sezione_ver = ? ) OR (tipo_ver = 3)) ORDER BY data_ver";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "sss", $annoscolastico_ver, $classe_selezionata, $sezione_selezionata);	
	}
	mysqli_stmt_bind_result($stmt, $num_ver, $tipo_ver, $titolo_ver, $data_ver, $classe_ver);
	$stmt->execute();
	$riga =  0;
	while (mysqli_stmt_fetch($stmt)) {
		$riga++;
		$tipiverbaliA = array("idle", "Consiglio di classe", "Riunione con Genitori", "Consiglio d'Istituto", "Consiglio valutativo");
		?>
		<tr>
			<td>
				<img title="Elimina Intero Verbale" class="iconaStd" src='assets/img/Icone/times-circle-solid.svg' onclick="showModalDeleteThisRecord(<?=$num_ver?>, '<?=timestamp_to_ggmmaaaa($data_ver);?>');">
			</td>
			<td style="width: 80px; ">
				
				<button  style="width: 80%;" id="riga<?=$riga?>" name="ver<?=$num_ver;?>" onclick="showModalVerbale(<?=$num_ver;?>);" ><?=$riga;?></button>
				<?/*?><input class="tablecell3 disab qryimieialunni val<?=$ID_alu;?>" style="width: 30%;" type="text"  value = "<?=$ID_alu;?>" disabled><?*/?>
			</td>
			<td>
				<input class="tablecell3 disab val<?=$num_ver;?>" style="text-align: center; width: 100%;" type="text"  name="num_ver" value = "<?=$num_ver;?>" disabled>
			</td>
			<td>
				<input class="tablecell3 disab val<?=$num_ver;?> tipoverb<?=$tipo_ver?> w100" type="text"  name="tipo_ver" value = "<?=$tipiverbaliA[$tipo_ver];?>" disabled>
			</td>
			<td>
				<input class="tablecell3 disab val<?=$num_ver;?> w100" type="text"  name="titolo_ver" value = "<?=stripslashes($titolo_ver);?>" disabled>
			</td>
			<td>
				<input class="tablecell3 disab val<?=$num_ver;?> w100" type="text" name="data_ver" value = "<?=timestamp_to_ggmmaaaa($data_ver);?>" disabled>
			</td>
			<td>
				<input class="tablecell3 disab val<?=$num_ver;?> w100" type="text" name="classe_ver" value = "<? if ($tipo_ver !=3) {echo ($classe_ver);} else { echo('-');} ?>" disabled>
			</td>
		</tr>
	<?}?>
	<tr>
		<td>
			<input id="contarecord_hidden" value = "<?=$riga?>" hidden>
		</td>
	</tr>

<script>
	
	function requeryDettaglio(ID_ver){
		//popola il modal form con i dati di ID_ver selezionato e lo mostra
		$('#modalAddVerbale').modal({show: 'true'});
	}
	
</script>