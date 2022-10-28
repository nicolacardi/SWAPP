	
<?	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	$ID_mae_ora = $_POST['ID_mae_ora'];
	$datagg[1] = $_POST['datalunedi'];
	$datagg[2] = date('Y-m-d',strtotime("+1 day", strtotime($datagg[1])));
	$datagg[3] = date('Y-m-d',strtotime("+2 day", strtotime($datagg[1])));
	$datagg[4] = date('Y-m-d',strtotime("+3 day", strtotime($datagg[1])));
	$datagg[5] = date('Y-m-d',strtotime("+4 day", strtotime($datagg[1])));
	//$codmat_mttA = array();
	//$descmateria_mtt = array();
	$giorni = array("lun", "mar", "mer", "gio", "ven");
	$ID_oraA = array();
	$data_oraA = array();
	$ora_oraA = array();
	$codmat_oraA = array();
	$classe_oraA = array();
	$sezione_oraA =array();
	$assente_oraA = array();
	$supplente_oraA = array();
	$cemateriaA = array();
	$ore_orario = intval($_SESSION['ore_orario']);

	$sql = "SELECT ID_ore, orainizio_ore, orafine_ore FROM tab_ore ORDER BY N_ore";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_ore, $orainizio_ore, $orafine_ore);
	$orariA = array("idle");
	while (mysqli_stmt_fetch($stmt)) {
		$orainizio_ore = substr($orainizio_ore, 0, strlen($orainizio_ore)-3);
		$orafine_ore = substr($orafine_ore, 0, strlen($orafine_ore)-3);
		array_push($orariA, $orainizio_ore."-".$orafine_ore) ;
	}
		
	//$orariA = array("idle", "8.05-9.15", "9.15-10.15", "10.45-11.35", "11.35-12.25", "12.25-13-15", "13.15-14.05", "14.05-14.55");
	$dateSeq = array("idle", $datagg[1], $datagg[2], $datagg[3], $datagg[4], $datagg[5]);
	$argomento_oraA = array();
	//inizializzo la matrice
	//5 giorni
	for ($j = 1; $j <= 5; $j++) {
		//6 ore
		for ($x = 1; $x <= $ore_orario; $x++) {
			//tutte queste matrici hanno indici 11,12,13,14,15,16,17....21,22,23,24,25,26,27 ecc...quindi la decina indica il giorno, l'unità l'ora
			$ID_oraA[$j*10+$x] = 0;
			$data_oraA[$j*10+$x] = '';
			$ora_oraA[$j*10+$x] = 0;
			$codmat_oraA[$j*10+$x] = '-';
			$classe_oraA[$j*10+$x] = '';
			$sezione_oraA[$j*10+$x] = '';
			$assente_oraA[$j*10+$x] = '';
			$supplente_oraA[$j*10+$x] = '';
			$cemateriaA[$j*10+$x] = ''; //questa matrice verrà popolata di 0 e 1 a seconda che non ci sia alcuna materia o ci sia almeno una materia assegnata
		}
	}
	
	
	//come prima cosa verifico se in ogni ora c'è una materia: perchè se c'è devo fare comparire l'icona grigia per le supplenze, se non c'è devo fare comparire un trattino.
	$sql = "SELECT ID_ora, data_ora, ora_ora, descmateria_mtt, classe_ora, sezione_ora FROM tab_orario LEFT JOIN tab_materie ON codmat_ora = codmat_mtt WHERE (data_ora BETWEEN ? AND ?)";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ss", $datagg[1], $datagg[5]);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_ora, $data_ora, $ora_ora, $codmat_ora, $classe_ora, $sezione_ora);
	while (mysqli_stmt_fetch($stmt)) {
		for ($j = 1; $j <= 5; $j++) {
			if ($data_ora == $datagg[$j]) {$giorno = $j;}
		}
		if (($codmat_ora != '') && ($codmat_ora != 'nomat')) { $cemateriaA[$giorno*10+$ora_ora] = 1; }
		
	}
	
	
	//ora invece estraggo le ore DEL MAESTRO per colorarle
	$sql = "SELECT ID_ora, data_ora, ora_ora, descmateria_mtt, classe_ora, sezione_ora, firma_mae_ora, argomento_ora, assente_ora, supplente_ora FROM tab_orario LEFT JOIN tab_materie ON codmat_ora = codmat_mtt WHERE (data_ora BETWEEN ? AND ?) AND (ID_mae_ora = ? OR supplente_ora = ?) ORDER BY data_ora, ora_ora";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ssii", $datagg[1], $datagg[5], $ID_mae_ora, $ID_mae_ora);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_ora, $data_ora, $ora_ora, $codmat_ora, $classe_ora, $sezione_ora, $firma_mae_ora, $argomento_ora, $assente_ora, $supplente_ora);
	mysqli_stmt_store_result($stmt);

	while (mysqli_stmt_fetch($stmt)) {
		//metto tutto in una specie di matrice a due dimensioni: giorno+ora
		$j = array_search($data_ora, $dateSeq);
		$x = $ora_ora;
		$ID_oraA[$j*10+$x] = $ID_ora;
		$data_oraA[$j*10+$x] = $data_ora;
		$ora_oraA[$j*10+$x] = $ora_ora;
		$codmat_oraA[$j*10+$x] = $codmat_ora;
		
		$classe_oraA[$j*10+$x] = '';
		//può accadere che un maestro abbia una pluriclasse. In questo caso desidero scrivere non la classe ma una stringa che concateni tutte le classi che lui ha in quella data e in quell'ora.
		//per quei casi serve, all'interno di questa while, prevedere una ulteriore SELECT con il valore corrente di data_ora e di ora_ora.
		//normalmente questa nuova SELECT restituirà una sola classe, ma per i maestri che ne hanno più nella stessa ora di una ne restituirà la concatenazione
		$sql2 = "SELECT classe_ora, sezione_ora FROM tab_orario LEFT JOIN tab_materie ON codmat_ora = codmat_mtt WHERE (data_ora = ? AND ora_ora = ?) AND (ID_mae_ora = ? OR supplente_ora = ?) ORDER BY classe_ora";
		$stmt2 = mysqli_prepare($mysqli, $sql2);
		mysqli_stmt_bind_param($stmt2, "siii", $data_ora, $ora_ora, $ID_mae_ora, $ID_mae_ora);
		mysqli_stmt_execute($stmt2);
		mysqli_stmt_bind_result($stmt2, $classe_ora2, $sezione_ora2);
		$n = 0;
		while (mysqli_stmt_fetch($stmt2)) {
			$n++;
			$classe_oraA[$j*10+$x] = $classe_oraA[$j*10+$x]." ".$classe_ora2." ".$sezione_ora2;
		}
		
		
		//$classe_oraA[$j*10+$x] = $classe_ora;
		
		$sezione_oraA[$j*10+$x] = $sezione_ora;
		$firma_mae_oraA[$j*10+$x] = $firma_mae_ora;
		$argomento_oraA[$j*10+$x] = $argomento_ora;
		$assente_oraA[$j*10+$x] = $assente_ora;
		$supplente_oraA[$j*10+$x] = $supplente_ora;
	}
	for ($x = 1; $x <= $ore_orario; $x++) { ?>
	<tr>
		<td>
			<input class="tablelabel0" style="height: 65px; background-image: url('assets/img/backgroundcell2.jpg') !important; margin-bottom: 1px; " type="text" value = "<?=$x?>^ ora  [<?=$orariA[$x]?>]" readonly>
		</td>
		<?
		//una colonna per ogni giorno
		for ($j = 1; $j <= 5; $j++) { ?>
			<td  style="width: 138px; border-bottom: 1px grey solid;">
				<textarea style="text-align: center; background: transparent; border: transparent; resize: none; font-size:11px; line-height: 1; overflow: hidden;" name="classe_sezione_ora" id="<? echo ("classe_sezione_ora".$j.$x) ?>" readonly><? echo ($classe_oraA[$j*10+$x]."\n");?><?=$codmat_oraA[$j*10+$x]?></textarea>
				<!--<input style="text-align: center; background: transparent; border: transparent; " name="classe_sezione_ora" id="<? //echo ("classe_sezione_ora".$j.$x) ?>" value ="<? //echo ($classe_oraA[$j*10+$x]." ".$sezione_oraA[$j*10+$x]);?>" readonly>-->
				<!--<input style="text-align: center; background: transparent; border: transparent; font-size: 10px; " name="codmat_ora" id="<? //echo ("codmat_ora".$j.$x) ?>" value ="<? //=$codmat_oraA[$j*10+$x]?>" readonly>-->

				<?
				if ($cemateriaA[$j*10+$x] !=0) {
					if ($codmat_oraA[$j*10+$x] == "-") {
						//caso in cui non sono sostituito nè sostituente
						?> 
						<img title="Io sono supplente di..." style="width: 30px; cursor: pointer;" src='assets/img/Icone/exchange.svg'  onclick="showModalIoSostituisco(<?="'".$dateSeq[$j]."', ".$x?>);">
					<?} else {
						if ($assente_oraA[$j*10+$x] == "0") {
							//caso in cui ho la mia materia e non c'è alcun supplente
							?> <div id="FirmaDigitale" title ="<?=$argomento_oraA[$j*10+$x]?>" style="cursor: pointer;" onclick="showModalFirma(<?=$ID_oraA[$j*10+$x].", 'firma".$j.$x."'"?>);">
								<img id="firma<?=$j?><?=$x?>" style="width: 30px;" src="<?switch ($firma_mae_oraA[$j*10+$x]){case 0:echo 'assets/img/Icone/user-check-solid-red.svg';break;case 1:echo 'assets/img/Icone/user-check-solid-green.svg';break;case 2:echo 'assets/img/Icone/user-check-solid-yellow.svg';break;}?>">
							</div>
						<?} else {
							//caso in cui sono sostituito o sostituente
							if ($supplente_oraA[$j*10+$x] == $ID_mae_ora) {
								//io sono sostituente
								?>
								<div id="FirmaDigitale" title ="<?=$argomento_oraA[$j*10+$x]?>" style="cursor: pointer;" onclick="showModalFirma(<?=$ID_oraA[$j*10+$x].", 'firma".$j.$x."'"?>);">
								<img id="firma<?=$j?><?=$x?>" style="width: 30px;" src="<?switch ($firma_mae_oraA[$j*10+$x]){case 0:echo 'assets/img/Icone/user-check-solid-red.svg';break;case 1:echo 'assets/img/Icone/user-check-solid-green.svg';break;case 2:echo 'assets/img/Icone/user-check-solid-yellow.svg';break;}?>">
								</div>
								<img title="Supplenza" style="float:left; margin-left: 30px; margin-top: -20px; width: 16px;" src='assets/img/Icone/sync-alt-solid.svg'>
								<?
								
							} else {
								//io sono sostituito
								?>
								<div id="FirmaDigitale" title ="<?=$argomento_oraA[$j*10+$x]?>" style="cursor: pointer;" onclick="showModalFirma(<?=$ID_oraA[$j*10+$x].", 'firma".$j.$x."'"?>);">
								<img id="firma<?=$j?><?=$x?>" style="width: 30px;" src="<?switch ($firma_mae_oraA[$j*10+$x]){case 0:echo 'assets/img/Icone/user-check-solid-red.svg';break;case 1:echo 'assets/img/Icone/user-check-solid-green.svg';break;case 2:echo 'assets/img/Icone/user-check-solid-yellow.svg';break;}?>">
								</div>
								<img title="Supplenza" style="float:left; margin-left: 30px; margin-top: -20px; width: 16px;" src='assets/img/Icone/sync-alt-solid.svg'>
								<?
								
							}
						}
					}
				} else {?>
					
				<?}?>
			</td>
		<?}?>
	</tr>
	<? } ?>
<script>
	
	function showModalFirma (ID_ora, firmaid) {

		
		IP_client = $('#IP_Client').val(); //questo è l'indirizzo del computer in uso
		IP_authorized = $('#IP_Authorized').val(); //questo è l'indirizzo consentito - oppure '' se tutti sono consentiti
		role_usr = $('#role_usr').val();
		//colorefirma = $('#'+firmaid).css('color');
		srcfirma = $('#'+firmaid).attr("src");
		//if (colorefirma == "rgb(0, 128, 0)") {firmato="VERDE";}
		//if (colorefirma == "rgb(255, 0, 0)") {firmato="ROSSO";}
		//if (colorefirma == "rgb(255, 187, 6)") {firmato="GIALLO";}
		if (srcfirma.includes("green")) {firmato="VERDE";}
		if (srcfirma.includes("red")) {firmato="ROSSO";}
		if (srcfirma.includes("yellow")) {firmato="GIALLO";}
		//console.log ("colorefirma"+colorefirma);
		let OKaFirma = 1;
		if (firmato =="ROSSO") {
			if ((role_usr == 0) || (IP_client == IP_authorized || (IP_authorized == ""))) {
				OKaFirma = 1;
			} else {
				OKaFirma = 0;
			}
		} else {
			OKaFirma = 1;
		}
		
		//OKaFirma = 1; //PER ORA INIBISCO IL CONTROLLO (SERVE PER I VIDEO)
		//console.log ('IP_client: '+IP_client);
		//console.log ('role_usr: '+role_usr);
		//console.log ('colorefirma: '+colorefirma);
		//console.log ('firmato: '+firmato);
		//console.log ('OKaFirma: '+OKaFirma);
		if (OKaFirma == 1) {
			postData = { ID_ora : ID_ora };
			$.ajax({
				type: 'POST',
				url: "11qry_getDatiPerFirma.php",
				data: postData,
				dataType: 'json',
				success: function(data){
					
					let dataLezione = data.data_ora;
					let oraLezione = data.orafine_ore;
					//let dataLezioneSplit = dataLezione.split("-");
					//let dataLezioneDate = new Date(dataLezioneSplit[0], dataLezioneSplit[1] - 1, dataLezioneSplit[2]);
					

					//estraggo la data e ora DEL SERVER, in quanto se facessi un'estrazione della data e ora del computer uno potrebbe regolarsela a piacere
					$.ajax({
						type: 'POST',
						async: false,
						url: "getServerDate.php",
						dataType: 'json',
						success: function(data){
							currentDate = data.yr+"-"+data.mnt+"-"+data.dt;
							currentTime = data.hrs+":"+data.mns+":"+data.scd;
						},
						error: function(){
							alert("Errore: contattare l'amministratore fornendo il codice di errore '11qry_Ilmioregistro getServerDate'");     
						}
					});
					// Wed Nov 03 2021 17:15:45 GMT+0100 (Ora standard dell’Europa centrale)


					// console.log ('dataLezione:'+dataLezione);
					// console.log ('oraLezione:'+oraLezione);

					// console.log("currentDate (server)", currentDate);
					// console.log("currentTime (server)", currentTime);
					 
					if (dataLezione > currentDate) {
						$('#titolo01Msg_OK').html('FIRMA REGISTRO');
						$('#msg01Msg_OK').html("Si possono firmare le presenze solo di date passate");
						$('#modal01Msg_OK').modal('show');
					} else {
						if ((dataLezione == currentDate) && (oraLezione  > currentTime)) {
							$('#titolo01Msg_OK').html('FIRMA REGISTRO');
							$('#msg01Msg_OK').html("Si possono firmare le presenze del giorno solo di ore già trascorse");
							$('#modal01Msg_OK').modal('show');
						} else {
							$('#modalnome_mae').val(data.nome_mae);
							$('#modalcognome_mae').val(data.cognome_mae);
							$('#modalhidden_ID_mae_ora').val(data.ID_mae_ora);
							if (data.assente_ora == 1) {
								$('#assente_ora').prop('checked', true);
							}else {
								$('#assente_ora').prop('checked', false);
							}
							$("#selectSupplente").val(data.supplente_ora);
							$('#modaldescmateria_mtt').val(data.descmateria_mtt);
							$('#modalclassesezione_ora').val(data.classe_ora+" "+data.sezione_ora);
							$('#modalargomento_ora').val(data.argomento_ora);
							$('#modalcompitiassegnati_ora').val(data.compitiassegnati_ora);
							requery();
							//metto sul pulsante di chiusura del form modale la funzione saveFirma con l'ID_ora corretto
							$('#btn_OKFirma').attr('onclick','saveFirma_ChiudiModal('+ID_ora+', 0)');
							//console.log (data.data_ora);
							//console.log (data.ora_ora);
							//qui devo popolare la selectSupplente con i maestri disponibili solamente
							postData1 = { ora_ora : data.ora_ora, data_ora : data.data_ora , supplente_ora : data.supplente_ora};
							//console.log("11qry_Ilmioregistro.php - showModalFirma - postData a 11qry_getMaestriNonImpegnati.php");
							//console.log (postData1);
							$.ajax({
								type: 'POST',
								async: false,
								url: "11qry_getMaestriNonImpegnati.php",
								data: postData1,
								dataType: 'html',
								success: function(html){
									//console.log (html);
									$("#selectSupplentiContainer").html(html);
								},
								error: function(){
									alert("Errore: contattare l'amministratore fornendo il codice di errore '11qry_Ilmioregistro ##fname##'");     
								}
							});
							showhideSupplente();
							$("#alertFirma").removeClass('alert-success');
							$("#alertFirma").addClass('alert-danger');
							$("#alertFirma").hide();
							$("#remove-contentFirma").show();
							$("#btn_cancelFirma").html('Annulla');
							$('#btn_OKFirma').show();

							// $("#alertIoSostituisco").removeClass('alert-success');
							// $("#alertIoSostituisco").addClass('alert-danger');
							// $("#alertIoSostituisco").hide();
							// $("#remove-contentIoSostituisco").show();
							// $("#btn_cancelIoSostituisco").html('Annulla');
							// $('#btn_OKIoSostituisco').show();


							$('#modalFirmaDigitale').modal({show: 'true'});
						}
					}

					

					
					
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '11qry_Ilmioregistro ##fname##'");      
				}
			});
		} else {
			$('#titolo01Msg_OK').html('FIRMA REGISTRO');
			$('#msg01Msg_OK').html("La firma elettronica della lezione<br>è consentita soltanto dai computer autorizzati");
			$('#modal01Msg_OK').modal('show');
		}
	}
	
	function str_pad(n) {
		return String("00" + n).slice(-2);
	}
	
	function showModalIoSostituisco (data_ora, ora_ora) {
		IP_client = $('#IP_Client').val();
		
		role_usr = $('#role_usr').val();
		//colorefirma = $('#'+firmaid).css('color');
		//if (colorefirma == "rgb(0, 128, 0)") {firmato="VERDE";}
		//if (colorefirma == "rgb(255, 0, 0)") {firmato="ROSSO";}
		//if (colorefirma == "rgb(255, 187, 6)") {firmato="GIALLO";}
		//let OKaFirma = 1;
		//if (firmato =="ROSSO") {
		if ((role_usr == 0) || (IP_client == '37.117.168.239')) {
			OKaFirma = 1;
		} else {
			OKaFirma = 0;
		}
		
		OKaFirma = 1; //PER ORA INIBISCO IL CONTROLLO (SERVE PER I VIDEO)
		//} else {
			//OKaFirma = 1;
		//}
		//console.log ('IP_client: '+IP_client);
		//console.log ('role_usr: '+role_usr);
		//console.log ('OKaFirma: '+OKaFirma);
		if (OKaFirma == 1) {
		
			postData1 = {ora_ora : ora_ora, data_ora : data_ora};
			//console.log("11qry_Ilmioregistro.php - showModalIoSostituisco - postData a 11qry_getLezionidiQuestora.php");
			//console.log (postData1);
			$.ajax({
				type: 'POST',
				async: false,
				url: "11qry_getLezionidiQuestora.php",
				data: postData1,
				dataType: 'html',
				success: function(html){
					let parts = data_ora.split("-");
					let year = parseInt(parts[0], 10);
					let month = str_pad(parseInt(parts[1], 10));
					let day = str_pad(parseInt(parts[2], 10));
					let dateddmmyyyy = (day+"/"+month+"/"+year);
					//$('#btn_OKIoSostituisco').attr('onclick','deleteFirma_ChiudiModal()'); //ID_ora va valorizzato onchange della select
					$('#modalDataIoHoSostituito').html(dateddmmyyyy);
					$('#modalOraIoHoSostituito').html(ora_ora);
					$("#selectLezionidiQuestOraContainer").html(html);
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '11Ilmioregistro ##fname##'");     
				}
			});
			

			$("#alertIoSostituisco").removeClass('alert-success');
			$("#alertIoSostituisco").addClass('alert-danger');
			$("#alertIoSostituisco").hide();
			
			$("#modalargomento_oraIoSost").val("");
			$("#modalcompitiassegnati_oraIoSost").val("");

			$("#remove-contentIoSostituisco").show();
			$("#btn_cancelIoSostituisco").html('Annulla');
			$('#btn_OKIoSostituisco').show();


			$('#modalIoSostituisco').modal({show: 'true'});
		} else {
			$('#titolo01Msg_OK').html('FIRMA REGISTRO');
			$('#msg01Msg_OK').html("La firma elettronica della lezione<br>è consentita soltanto dai computer autorizzati");
			$('#modal01Msg_OK').modal('show');
		}
	}
	
	
</script>
