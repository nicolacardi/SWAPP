<?	//Questa routine si occupa di pubblicare le intestazioni di tutti i compiti.
	//La tabella di riferimento è tab_compitiverifiche
	//I voti si trovano invece in tab_voticompitiverifiche e se ne occupa 13qry_CompitieVerifiche.php
	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");

	$mostragiudizi = getPar('mostra_giudizi_compiti_verifiche');
	$annoscolastico_cla = $_POST['annoscolastico_cla'];
	$classe_cla = $_POST['classe_cla'];
	$sezione_cla = $_POST['sezione_cla'];
	$ID_mae= $_POST['ID_mae'];
	$date_from = $_POST['date_from'];
	$date_to = $_POST['date_to'];
	//seleziono i valori univoci di ID_cov (compiti e verifiche) per la classe/sezione/annoscolastico. Ad ogni valore corrisponderà una COLONNA
	$sql1 = "SELECT DISTINCT ID_cov, codmat_cov, tipo_cov, data_cov, argomento_cov, ID_mae_cov FROM tab_compitiverifiche WHERE classe_cov = ? AND sezione_cov = ? AND annoscolastico_cov = ? AND ID_mae_cov = ? AND (data_cov >= ? AND data_cov <= ?) ORDER BY codmat_cov, tipo_cov, data_cov";
	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1, "sssiss", $classe_cla, $sezione_cla, $annoscolastico_cla, $ID_mae, $date_from, $date_to);
	mysqli_stmt_execute($stmt1);
	mysqli_stmt_bind_result($stmt1, $ID_cov, $codmat_cov, $tipo_cov, $data_cov, $argomento_cov, $ID_mae_cov);
	$k = 1;?>
		<td>
			<img title="Aggiungi nuovo Compito/Verifica" style="width: 20px; cursor: pointer; margin-top: 50px; margin-left: 5px; margin-bottom: 6px;" src='assets/img/Icone/circle-plus.svg' onclick="showModalAddCompito();">
		</td>
		<td>
			<input class="tablelabel0" style="vertical-align: bottom; max-width:100px; margin-top: 50px; margin-bottom: 6px;" type="text" id="nome_alu" name="nome_alu" value = "NOME" disabled>
		</td>
		<td>
			<input class="tablelabel0"  style="vertical-align: bottom; max-width:100px; margin-top: 50px; margin-bottom: 6px;" type="text" id="cognome_alu" name="cognome_alu" value = "COGNOME" disabled>
		</td>
		<td>
			<input class="tablelabel0" style="vertical-align: bottom; max-width:70px; margin-top: 50px; margin-bottom: 6px;" type="text" id="classe_alu" name="classe_alu" value = "Classe" disabled>
		</td>
		<td>
			<input class="tablelabel0"  style="vertical-align: bottom; max-width:40px; margin-top: 50px; margin-bottom: 6px;" type="text" id="sezione_alu" name="sezione_alu" value = "Sez" disabled>
		</td>
	<?
	while (mysqli_stmt_fetch($stmt1)) {?>
		<?$datashow = substr($data_cov, 8,2)."/".substr($data_cov, 5,2);; ?>
		<td style="width: 40px; height: 80px; text-align: center;">
			<!-- <input class="tablelabel rotate" style="height: 30px; " value="ciao">			 -->
			<textarea class="tablelabel0" style="height: 50px; font-size: 10px; width: 40px; resize:none; cursor: pointer;" type="text"  value = "" onclick="mostraCompito(<?=$ID_cov;?>, '<?=$codmat_cov;?>', '<?=$tipo_cov;?>', '<?=$data_cov;?>', '<?=$argomento_cov;?>' );" readonly><?=$codmat_cov." \n ".$tipo_cov." \n ".$datashow;?></textarea>

			<img title="Elimina Compito/verifica" style="width: 20px; margin-bottom: 5px; cursor: pointer" src='assets/img/Icone/times-circle-solid.svg' onclick="showModalDeleteThisRecord(<?=$ID_cov;?>, '<?=timestamp_to_ggmmaaaa($data_cov);?>');">
			<?if ($mostragiudizi) {?>
				<button class="btnBlu" style="width: 40px; height: 24px;" onclick="mostraGiudizi(<?=$ID_cov;?>, '<?=$codmat_cov;?>', '<?=$tipo_cov;?>', '<?=$data_cov;?>', '<?=$argomento_cov;?>')">abc</button>
			<?}?>

		</td>
	<?
	$k++;
	}
	if ($k !=1) {
	?>
	<td style="vertical-align: top">
		<button class="btnBlu" style="height: 50px; margin-top: 0px" onclick="salvaVoti();">Salva Voti</button>
	</td>
	<?}?>
<script>
	function mostraCompito (ID_cov, codmat_cov, tipo_cov, data_cov, argomento_cov){
		resetModalAddCompito(); 
		$("#ID_cov_new").val(ID_cov);
		let classe_cla = $("#selectclasse option:selected" ).val();
		$("#classe_cov_new").val(classe_cla);
		let sezione_cla = $( "#selectsezione option:selected" ).val();
		$("#sezione_cov_new").val(sezione_cla);
		//console.log(codmat_cov);
		$("#selectmateria_new").val(codmat_cov);
		$("#tipo_cov_new").val(tipo_cov);
		$("#data_cov_new").val(convertDate(data_cov));
		$("#argomento_cov_new").val(argomento_cov);
		$('#modalAddCompito').modal({show: 'true'});
	}
	
	function mostraGiudizi(ID_cov, codmat_cov, tipo_cov, data_cov, argomento_cov) {
		//questa funzione passa a 13qry_getGiudizi annoscolastico, classe, sezione e ID_cov
		//13qry_getGiudizi estrae tutti i nomi dei ragazzi della classe/sezione/anno  e tutti i giudizi e li mette in un html che viene passato al form modale
		//l'html contiene tutto ciò che serve per l'edit e il salvataggio
		let annoscolastico = $( "#selectannoscolastico option:selected" ).val();
		let classe = $("#selectclasse option:selected" ).val();
		let sezione = $( "#selectsezione option:selected" ).val();
		postData = { ID_cov: ID_cov, annoscolastico: annoscolastico, classe: classe, sezione: sezione, codmat_cov: codmat_cov, tipo_cov: tipo_cov, data_cov: data_cov, argomento_cov: argomento_cov};
		//console.log ("13qry_CompitiVerificheColonne.php - mostraGiudizi - postData a 13qry_getGiudizi.php ");
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "13qry_getGiudizi.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#remove-contentGiudizi").html(html);
			},
	        error: function(){
	            alert("Errore: contattare l'amministratore fornendo il codice di errore '13qry_CompitieVerificheColonne ##mostraGiudizi##'");     
	        }
		});

		$('#modalEditGiudizi').modal({show: 'true'});
	}

	function saveGiudizio(ID_cov_vcc, ID_alu_vcc) {
		let giudizio = $("#giudizio_vcc"+ID_alu_vcc ).val();
		if (giudizio != '') {
			postData = { ID_cov_vcc: ID_cov_vcc, ID_alu_vcc: ID_alu_vcc, giudizio: giudizio};
			console.log ("13qry_CompitiVerificheColonne.php - saveGiudizio - postData a 13qry_saveGiudizio.php ");
			console.log (postData);
			$.ajax({
				type: 'POST',
				url: "13qry_saveGiudizio.php",
				data: postData,
				dataType: 'json',
				success: function(data){
					//console.log ("data.test", data.test);
					//TODO attenzione: contemplare il caso in cui si stia salvando un giudizio nullo (cancellazione) attualmente dà un errore
					//perchè però non da' problemi con insertVoto?
					console.log (data);
					if (data.alunnoassente == "1") {
						datacompito = data.datacov;
						anno = datacompito.substring(0, 4);
						mese = datacompito.substring(5, 7);
						giorno = datacompito.substring(8, 10);
						datacompito = giorno+"/"+mese+"/"+anno;
						msg2= "<br><br>Le assenze di classe del mese desiderato sono anche scaricabili da 'Elenco Assenze'<br>nella pagina 'Emissione Documenti'<br><br>Questa è solo una segnalazione - il giudizio verrà comunque salvato.";
						msg3 = $('#nome_alu'+ID_alu_vcc).val()+" "+ $('#cognome_alu'+ID_alu_vcc).val() + " era assente almeno un'ora il "+datacompito + "<br>data in cui per "+ $('#nome_alu'+ID_alu_vcc).val()+" è stato segnato un giudizio in: "+data.materia+"."+data.tipo+msg2;
						$('#titolo01Msg_OK').html('VERIFICA VOTI-ASSENZE');
						$('#msg01Msg_OK').html(msg3);
						$('#modal01Msg_OK').modal('show');
					} else {
						//console.log (data.alunnoassente);
					}
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '13qry_CompitieVerificheColonne ##saveGiudizio##'");     
				}
			});
		}
	}

	function convertDate(dateString){
		let p = dateString.split(/\D/g);
		return [p[2],p[1],p[0] ].join("/");
	}
	


	function salvaVoto () {
		$('.voto_vcc').each(function(){
			let idvoto_vcc = $(this).attr('id');  							//qui c'è scritto "votoID_alu.ID_Compito
			let n = idvoto_vcc.indexOf(".");								//estraggo la posizione del punto
			let ID_alu_vcc = parseInt(idvoto_vcc.substr(4,n-4));			//a sinistra del punto, tolti i primi quattro caratteri c'è ID_alu_vcc
			let ID_cov_vcc = parseInt(idvoto_vcc.substr(n+1));				//a destra c'è l'ID_cov_vcc
			let voto_vcc = $(this).val(); 									//questo è il voto da impostare
			//>>>>>>>>>>>>>>>>>>>>>> a questo punto posso salvare. 
			// opzione 1: cancello tutto e salvo...ma "cosa" cancello?
			// opzione2 scrivo la SQL del tipo IF EXISTS allora update altrimenti INSERT. SOLO SE voto <> ""? 
			// eh no, perchè se uno ha cancellato? dovrei fare che se è "" allora faccio una DELETE...
			//riassumendo: se voto = "" allora DELETE, se <> "" allora SQL dentro la quale c'è l'IF EXISTS
			postData = { ID_alu_vcc: ID_alu_vcc, ID_cov_vcc: ID_cov_vcc, voto_vcc: voto_vcc};
			//console.log ("13CompitieVerificheColonne.php - salvaVoti - postData a 13qry_deleteVoto.php");
			//console.log (postData);
			if ((voto_vcc == "0.0") || (voto_vcc == "")) {
				$.ajax({
					type: 'POST',
					url: "13qry_deleteVoto.php",
					data: postData,
					async: false,
					dataType: 'json',
					success: function(data){
						//console.log ("13CompitieVerificheColonne.php - salvaVoti - ritorno da 13qry_deleteVoto.php");
						//console.log(data.sql);
					},
					error: function(){
						alert("Errore: contattare l'amministratore fornendo il codice di errore '13qry_CompitieVerificheColonne ##salvaVoti##'");     
					}
				});
			} else {
				console.log ("13CompitieVerificheColonne.php - salvaVoti - postData a 13qry_insertVoto.php");
				console.log(postData);
				$.ajax({
					type: 'POST',
					url: "13qry_insertVoto.php",
					data: postData,
					dataType: 'json',
					success: function(data){
						console.log ("13CompitieVerificheColonne.php - salvaVoti - ritorno da 13qry_insertVoto.php");
						console.log(data);
						if (data.alunnoassente == "1") {
							datacompito = data.datacov;
							anno = datacompito.substring(0, 4);
							mese = datacompito.substring(5, 7);
							giorno = datacompito.substring(8, 10);
							datacompito = giorno+"/"+mese+"/"+anno;
							msg2= "<br><br>Le assenze di classe del mese desiderato sono anche scaricabili da 'Elenco Assenze'<br>nella pagina 'Emissione Documenti'<br><br>Questa è solo una segnalazione - il voto verrà comunque salvato.";
							msg3 = $('#nome_alu'+ID_alu_vcc).val()+" "+ $('#cognome_alu'+ID_alu_vcc).val() + " era assente almeno un'ora il "+datacompito + "<br>data in cui per "+ $('#nome_alu'+ID_alu_vcc).val()+" è stato segnato un voto in: "+data.materia+"."+data.tipo+msg2;
							$('#titolo01Msg_OK').html('VERIFICA VOTI-ASSENZE');
							$('#msg01Msg_OK').html(msg3);
							$('#modal01Msg_OK').modal('show');
						} else {
							requery();
						}
					},
					error: function(){
						alert("Errore: contattare l'amministratore fornendo il codice di errore '13qry_CompitieVerificheColonne ##fname##'");     
					}
				});
			}
			//console.log ($(this).attr('id')+" "+ID_alu+" "+ID_cov+" "+voto);
		});
	}


	
	function salvaVoti () {
		$('.voto_vcc').each(function(){
			let idvoto_vcc = $(this).attr('id');  							//qui c'è scritto "votoID_alu.ID_Compito
			let n = idvoto_vcc.indexOf(".");								//estraggo la posizione del punto
			let ID_alu_vcc = parseInt(idvoto_vcc.substr(4,n-4));			//a sinistra del punto, tolti i primi quattro caratteri c'è ID_alu_vcc
			let ID_cov_vcc = parseInt(idvoto_vcc.substr(n+1));				//a destra c'è l'ID_cov_vcc
			let voto_vcc = $(this).val(); 									//questo è il voto da impostare
			//>>>>>>>>>>>>>>>>>>>>>> a questo punto posso salvare. 
			// opzione 1: cancello tutto e salvo...ma "cosa" cancello?
			// opzione2 scrivo la SQL del tipo IF EXISTS allora update altrimenti INSERT. SOLO SE voto <> ""? 
			// eh no, perchè se uno ha cancellato? dovrei fare che se è "" allora faccio una DELETE...
			//riassumendo: se voto = "" allora DELETE, se <> "" allora SQL dentro la quale c'è l'IF EXISTS
			postData = { ID_alu_vcc: ID_alu_vcc, ID_cov_vcc: ID_cov_vcc, voto_vcc: voto_vcc};
			//console.log ("13CompitieVerificheColonne.php - salvaVoti - postData a 13qry_deleteVoto.php");
			//console.log (postData);
			if ((voto_vcc == "0.0") || (voto_vcc == "")) {
				$.ajax({
					type: 'POST',
					url: "13qry_deleteVoto.php",
					data: postData,
					async: false,
					dataType: 'json',
					success: function(data){
						//console.log ("13CompitieVerificheColonne.php - salvaVoti - ritorno da 13qry_deleteVoto.php");
						//console.log(data.sql);
					},
					error: function(){
						alert("Errore: contattare l'amministratore fornendo il codice di errore '13qry_CompitieVerificheColonne ##salvaVoti##'");     
					}
				});
			} else {
				console.log ("13CompitieVerificheColonne.php - salvaVoti - postData a 13qry_insertVoto.php");
				console.log(postData);
				$.ajax({
					type: 'POST',
					url: "13qry_insertVoto.php",
					data: postData,
					dataType: 'json',
					success: function(data){
						console.log ("13CompitieVerificheColonne.php - salvaVoti - ritorno da 13qry_insertVoto.php");
						console.log(data);
						if (data.alunnoassente == "1") {
							datacompito = data.datacov;
							anno = datacompito.substring(0, 4);
							mese = datacompito.substring(5, 7);
							giorno = datacompito.substring(8, 10);
							datacompito = giorno+"/"+mese+"/"+anno;
							msg2= "<br><br>Le assenze di classe del mese desiderato sono anche scaricabili da 'Elenco Assenze'<br>nella pagina 'Emissione Documenti'<br><br>Questa è solo una segnalazione - il voto verrà comunque salvato.";
							msg3 = $('#nome_alu'+ID_alu_vcc).val()+" "+ $('#cognome_alu'+ID_alu_vcc).val() + " era assente almeno un'ora il "+datacompito + "<br>data in cui per "+ $('#nome_alu'+ID_alu_vcc).val()+" è stato segnato un voto in: "+data.materia+"."+data.tipo+msg2;
							$('#titolo01Msg_OK').html('VERIFICA VOTI-ASSENZE');
							$('#msg01Msg_OK').html(msg3);
							$('#modal01Msg_OK').modal('show');
						} else {
							requery();
						}
					},
					error: function(){
						alert("Errore: contattare l'amministratore fornendo il codice di errore '13qry_CompitieVerificheColonne ##fname##'");     
					}
				});
			}
			//console.log ($(this).attr('id')+" "+ID_alu+" "+ID_cov+" "+voto);
		});
	}
</script>