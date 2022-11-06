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
			<td>
				<img title="Allegati" class="iconaStdH" src='assets/img/Icone/attachments.svg' onclick="showLinks('tab_verbali', <?=$num_ver;?>);">
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

	function showLinks (tab_lnk, IDext_lnk) {

		//carica i link
		postData = { tab_lnk: tab_lnk, IDext_lnk : IDext_lnk};
		//console.log ("14qry_Verbali.php - showLinks - postData a 14qry_getComboMaestri.php");
		//console.log (postData);
		$.ajax({
			async: false,
			type: 'POST',
			url: "14qry_getLinks.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				//console.log (html);
				//li mette nell'html di remove-contentLinksVerbale

				$("#remove-contentLinksVerbale").html(html);
				$("#btn_OKModalLinksVerbale").attr("onclick","salvaLinks('tab_verbali',"+IDext_lnk+");");

				
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '14qry_Verbali  ##showLinks##'");     
			}
		});
		$('#modalLinksVerbale').modal({show: 'true'});
	}
	

	function eliminaLink(tab_lnk, IDext_lnk, ID_lnk) {
        postData = {ID_lnk: ID_lnk};
		// console.log ("14qry_Verbali.php - eliminaLink - postData a 14qry_deleteLink.php");
		// console.log (postData);
		$.ajax({
			url : "14qry_deleteLink.php",
			type: "POST",
			data : postData,
			dataType: "json",
			success:function(){

				//console.log ("14qry_Verbali.php - eliminaLink - ritorno da 14qry_deleteLink.php");
				
				showLinks(tab_lnk, IDext_lnk);
			}
		});
	}

	function salvaLinks(tab_lnk, IDext_lnk) {
		
		titolo_lnk = $('#titolo_lnk_new').val();
		link_lnk = $('#link_lnk_new').val();

		postData = {titolo_lnk: titolo_lnk, link_lnk: link_lnk, tab_lnk: tab_lnk, IDext_lnk: IDext_lnk};
		console.log ("14qry_Verbali.php - salvaLinks - postData a 14qry_insertLink.php");
		console.log (postData);
		$.ajax({
			url : "14qry_insertLink.php",
			type: "POST",
			data : postData,
			dataType: "json",
			success:function(){
				showLinks(tab_lnk, IDext_lnk);

				//dopo aver fatto la insert mi occupo delle n update
			}
		});

		linkN_hidden = $('#linkN_hidden').val();
		
		for (let i = 1; i <= linkN_hidden; i++) {
			ID_lnk = $('#ID_lnk'+i).val();
			titolo_lnk = $('#titolo_lnk'+i).val();
			link_lnk = $('#link_lnk'+i).val();
			postData = {ID_lnk: ID_lnk, titolo_lnk: titolo_lnk, link_lnk: link_lnk};

			console.log ("14qry_Verbali.php - salvaLinks - postData a 14qry_updateLink.php");
			console.log (postData);
			$.ajax({
				url : "14qry_updateLink.php",
				type: "POST",
				data : postData,
				dataType: "json",
				success:function(){
					
				}
			});

		}
		showLinks(tab_lnk, IDext_lnk);
		
	}

</script>