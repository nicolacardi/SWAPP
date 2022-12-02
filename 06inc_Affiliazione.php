<?
	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("assets/functions/ifloggedin.php");
?>


<!--FORM MODALE MODIFICA AFFILIAZIONE PADRE o MADRE *****************************************************************************-->
<div class="modal" id="modalAffiliazione" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px; width: 60%">
			<div class="modal-content">
				<div class="modal-body white">
					<form id="form_Affiliazione" method="post">
						<span class="titoloModal">Affiliazione a socio/socia</span><br>

						<input id="ID_fam_hidden" 		hidden>
						<input id="padremadre_hidden" 	hidden>
						<div id="remove-contentAffiliazione" style="text-align: center; margin-top: 20px; "> <!-- START REMOVE CONTENT -->
							<span class="testoModal" id="subtitleDuringImport"></span>
							<span class="testoModal" id="subtitleAffiliazione"></span>
							<div class="row">
								<div class="col-md-3">
								</div>
								<div class="col-md-3">
									Nome
								</div>
								<div class="col-md-3">
									Cognome
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
								</div>
								<div class="col-md-3">
									<input class="tablecell5" type="text"  id="nomesocio" name="nomesocio" readonly>
								</div>
								<div class="col-md-3">
									<input class="tablecell5" type="text"  id="cognomesocio" name="cognomesocio" readonly>
								</div>
							</div>
							<div class="row mt10">
								<div class="col-md-3">
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6">
								Tipo di Socio
								</div>
							</div>
							<div class="row">
								<select name="selectTipoSoc "  id="selectTipoSoc">
									<option value="0" <?if ($tipo_soc_det == 0) {echo ("selected");}?>>Fruitore</option>
									<option value="1" <?if ($tipo_soc_det == 1) {echo ("selected");}?>>Lavoratore</option>
									<option value="2" <?if ($tipo_soc_det == 2) {echo ("selected");}?>>Volontario</option>
									<option value="3" <?if ($tipo_soc_det == 3) {echo ("selected");}?>>Altro</option>
								</select>
                    		</div>

							<div class="row">
								<div class="col-md-3">
								</div>
								<div class="col-md-3">
									Data Iscrizione
								</div>
								<div class="col-md-3">
									Data Disiscrizione
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
								</div>
								<div class="col-md-3 center">
									<input type="text" class="tablecell5 datepicker"  id="dataiscrizione_soc"  maxlength="10" name="dataiscrizione_soc">
								</div>
								<div class="col-md-3 center">
									<input type="text" class="tablecell5 datepicker"  id="datadisiscrizione_soc"  maxlength="10" name="datadisiscrizione_soc">
								</div>
							</div>
						</div>


							
						<div class="alert alert-success" id="alertContAffiliazione" style="display:none; margin-top:10px;">
							<h4 id="alertMsgAffiliazione" style="text-align:center;">
							  Modifica affiliazione completata con successo!
							</h4>
						</div>
						<div class="modal-footer" >
							<button type="button" id="btn_cancelAffiliazione" class="btnBlu pull-left" style="width:25%;" data-dismiss="modal" onclick="hideAffiliazione()">Annulla</button>
							<button type="button" id="btn_deleteAffiliazione" class="btnBlu center" style="width:25%;" onclick="eliminaAffiliazione();" >Elimina Affiliazione</button>
							<button type="button" id="btn_OKAffiliazione" class="btnBlu pull-right" style="width:25%;" onclick="aggiornaAffiliazione();" >Aggiorna Affiliazione</button>

						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<!--FINE FORM MODALE AFFILIAZIONE PADRE O MADRE ************************************************************************-->


<script>

	function showModalAffiliazione(ID_fam, padremadre) {
		console.log (padremadre, $('#nomepadre_fam_det').val());
		$('#padremadre_hidden').val(padremadre);
		$('#ID_fam_hidden').val(ID_fam);

		if (padremadre == 'padre') {
			$('#nomesocio').val( $('#nomepadre_fam_det').val() );
			$('#cognomesocio').val(  $('#cognomepadre_fam_det').val() );
		}

		if (padremadre == 'madre') {
			$('#nomesocio').val( $('#nomemadre_fam_det').val() );
			$('#cognomesocio').val(  $('#cognomemadre_fam_det').val() );
		}

		postData = { ID_fam_mae_soc : ID_fam, padremadre_soc: padremadre};
		console.log ("06inc_Affiliazione.php - showModalAffiliazione - postData a 06qry_getSocio.php ");
		console.log (postData);
		$("#pagtoshow_hidden").val("Dati"+padremadre.charAt(0).toUpperCase() + padremadre.slice(1));

		$.ajax({
			type: 'POST',
			url: "06qry_getSocio.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				console.log ("06SchedaAlunno.php - showModalAffiliazione - ritorno da 06qry_getSocio.php ");
				console.log (data);
				

				if (data.ID_soc !=0) {
					$('#selectTipoSoc').val(data.tipo_soc);
					//se l'affiliazione è stata inserita per errore devo dare possibilità di CANCELLARLA di brutto
					//ma devo anche dare la possibilità di AGGIORNARLA se invece uno ha interrotto l'affiliazione inserendo una data di uscita
					$('#dataiscrizione_soc').val(data.dataiscrizione_soc);
					$('#datadisiscrizione_soc').val(data.datadisiscrizione_soc);
					$('#subtitleAffiliazione').html("Stai modificando una affiliazione esistente<br>E' fortemente sconsigliato ELIMINARE una affiliazione<br>salvo che sia stata inserita per errore<br>In tutti gli altri casi modificare la data di affiliazione o inserire una data di termine dell'affiliazione<br>NB: la modifica dell'affiliazione verrà salvata anche se non si preme 'Salva Modifiche Anagrafica'")
					
					$("#btn_cancelAffiliazione").html('Annulla');
					$("#btn_cancelAffiliazione").show();
					$("#btn_cancelAffiliazione").addClass('pull-left');

					$("#btn_deleteAffiliazione").attr("onclick","eliminaAffiliazione("+data.ID_soc+");");
					$("#btn_deleteAffiliazione").show();

					$("#btn_OKAffiliazione").attr("onclick","aggiornaAffiliazione("+data.ID_soc+");");
					$("#btn_OKAffiliazione").html('Aggiorna Affiliazione');
					$("#btn_OKAffiliazione").show();

					$("#alertContAffiliazione").removeClass('alert-success');
					$("#alertContAffiliazione").addClass('alert-danger');
					$("#alertContAffiliazione").hide();

					$("#remove-contentAffiliazione").show();



					$('#modalAffiliazione').show();
				} else {
					$('#selectTipoSoc').val(0);
					$('#datadisiscrizione_soc').val("");
					//non è socio attualmente

					//nella data di affiliazione inserisco per default quella odierna ma modificabile
					$('#subtitleAffiliazione').html("Stai inserendo una nuova affiliazione<br>NB: la modifica dell'affiliazione verrà salvata anche se non si preme 'Salva Modifiche Anagrafica'");
					let datam = moment(new Date()).format("DD/MM/YYYY");
					$('#dataiscrizione_soc').val(datam);

					$("#btn_cancelAffiliazione").html('Annulla');
					$("#btn_cancelAffiliazione").addClass('pull-left');
					$("#btn_cancelAffiliazione").show();

					$("#btn_deleteAffiliazione").hide();

					$("#btn_OKAffiliazione").attr("onclick","inserisciAffiliazione();");
					$("#btn_OKAffiliazione").html('Inserisci');
					$("#btn_OKAffiliazione").show();

					$("#alertContAffiliazione").removeClass('alert-success');
					$("#alertContAffiliazione").addClass('alert-danger');
					$("#alertContAffiliazione").hide();

					$("#remove-contentAffiliazione").show();

					$('#modalAffiliazione').show();
				}

			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore 'showModalAffiliazione'");      
			}
		});

	}

	function hideAffiliazione () {
		$('#modalAffiliazione').hide();
		requery();
	}

	function eliminaAffiliazione (ID_soc) {


		postData = { ID_soc: ID_soc};
		$.ajax({
			type: 'POST',
			url: "20qry_deleteAnagraficaSocio.php",
			data: postData,
			dataType: 'json',
			success: function(){

				$("#remove-contentAffiliazione").slideUp();
				$("#alertMsgAffiliazione").html('Socio/a eliminato/a!');
				$("#alertContAffiliazione").removeClass('alert-danger');
				$("#alertContAffiliazione").addClass('alert-success');
				$("#alertContAffiliazione").show();

				$("#btn_cancelAffiliazione").removeClass('pull-left');
				$("#btn_cancelAffiliazione").html('Chiudi');
				$("#btn_OKAffiliazione").hide();
				$("#btn_deleteAffiliazione").hide();
				requery();
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '06SchedaAlunno ##eliminaAffiliazione##'");      
			}
		});
	}

	function aggiornaAffiliazione (ID_soc) {

		ID_fam = $('#ID_fam_hidden').val();

		dataiscrizione_soc = $('#dataiscrizione_soc').val();
		datadisiscrizione_soc= $('#datadisiscrizione_soc').val();
		tipo_soc = $('#selectTipoSoc').val();
		postData = { ID_fam: ID_fam, ID_soc: ID_soc, dataiscrizione_soc: dataiscrizione_soc, datadisiscrizione_soc: datadisiscrizione_soc, tipo_soc: tipo_soc};
		console.log ("06inc_Affiliazione.php - aggiornaAffiliazione - postData a 21qry_updateAffiliazione.php ");
		console.log (postData);
		$.ajax({
			type: 'POST',
			url: "21qry_updateAffiliazione.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				console.log ("06inc_Affiliazione.php - aggiornaAffiliazione - ritorno da 21qry_updateAffiliazione.php ");
				console.log (data);
				$("#remove-contentAffiliazione").slideUp();
				$("#alertMsgAffiliazione").html('Socio/a aggiornato/a!');
				$("#alertContAffiliazione").removeClass('alert-danger');
				$("#alertContAffiliazione").addClass('alert-success');
				$("#alertContAffiliazione").show();

				$("#btn_cancelAffiliazione").removeClass('pull-left');
				$("#btn_cancelAffiliazione").html('Chiudi');
				$("#btn_OKAffiliazione").hide();
				$("#btn_deleteAffiliazione").hide();
				requery();
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '06SchedaAlunno ##aggiornaAffiliazione##'");      
			}
		});
	}

	function inserisciAffiliazione () {

		ID_fam = $('#ID_fam_hidden').val();
		padremadre = $('#padremadre_hidden').val();

		dataiscrizione_soc = $('#dataiscrizione_soc').val();
		datadisiscrizione_soc= $('#datadisiscrizione_soc').val();

		postData = { ID_fam_mae: ID_fam, padremadre: padremadre, dataiscrizione_soc: dataiscrizione_soc, datadisiscrizione_soc: datadisiscrizione_soc};
		//console.log ("06inc_Affiliazione.php - inserisciAffiliazione - postData a 21qry_insertAffiliazione.php ");
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "21qry_insertAffiliazione.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				// console.log ("06inc_Affiliazione.php - inserisciAffiliazione - ritorno da 21qry_insertAffiliazione.php ");
				// console.log (data);
				$("#remove-contentAffiliazione").slideUp();
				$("#alertMsgAffiliazione").html('Affiliazione Socio/a inserita!');
				$("#alertContAffiliazione").removeClass('alert-danger');
				$("#alertContAffiliazione").addClass('alert-success');
				$("#alertContAffiliazione").show();

				$("#btn_cancelAffiliazione").removeClass('pull-left');
				$("#btn_cancelAffiliazione").html('Chiudi');
				$("#btn_OKAffiliazione").hide();
				$("#btn_deleteAffiliazione").hide();
				requery();
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '06SchedaAlunno ##inserisciAffiliazione##'");      
			}
		});
	}


</script>
