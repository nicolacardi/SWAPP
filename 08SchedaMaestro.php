<?
	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("assets/functions/ifloggedin.php");
	$role_usr = $_SESSION['role_usr'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Scheda Maestro</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
	<meta name=”robots” content=”noindex”>
	<link rel="shortcut icon" href="assets/img/faviconbook.png" type="image/icon">
	<link rel="icon" href="assets/img/faviconbook.png" type="image/icon">
	<script src="assets/jquery/jquery-3.3.1.js" type="text/javascript"></script>
    <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<script src="assets/bootstrap/bootstrap.min.js" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
   	<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">-->
	<link rel="stylesheet" href="assets/croppie/croppie.css" />
	<script src="assets/croppie/croppie.js"></script>
	<link href="assets/datetimepicker/datepicker.css" rel="stylesheet" type="text/css" />
	<script src="assets/moment/moment.js" type="text/javascript"></script>
	<script src="assets/datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
	<script src="assets/functions/functionsJS.js"></script>
	<? $_SESSION['page'] = "Scheda Maestro";?>
</head>

<body>
	<? include("NavBar.php");?>
	<div id="main" >
		<div class="upper">
			<div class="titoloPagina" >
				Scheda Singolo Maestro o Dipendente
				<input id="role_usr" name="role_usr" value= "<?=$role_usr?>" 												hidden>
				<!-- <input id="ID_mae_hidden" 																					hidden> -->
				<input id="ID_mae_det_hidden" name="ID_mae_det_hidden" <? 	if (isset ($_POST['ID_maeDaAltraPag'])) {echo ("value ='".$_POST['ID_maeDaAltraPag']."'");}?> hidden>
				<input id="pagtoshow_hidden" name="pagtoshow_hidden" value="<? if ($role_usr == 3) { echo ("Classi");} else {echo ("DatiAnagrafici");}?>" hidden>
			</div>
			<div class="row">
				<div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-12 col-md-offset-0" style="text-align: center; font-size: 16px;">
					<div class="col-xs-12 col-sm-4 col-sm-offset-2 col-md-2 col-md-offset-4 itemSchedaAnagrafica">
						<div class="row">
							Nome
						</div>
						<div class="row">
							<input style="text-align: center;" class="search-box tablecell2" type="text"  id="nome_mae" name="nome_mae" <? if (isset ($_POST['nome_maeDaAltraPag'])) {echo ("value ='".$_POST['nome_maeDaAltraPag']."'");} ?> onchange="requery();">
						</div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-2 itemSchedaAnagrafica">
						<div class="row">
							Cognome
						</div>
						<div class="row">
							<input style="text-align: center;" class="search-box tablecell2" type="text"  id="cognome_mae" name="cognome_mae" <?	if (isset ($_POST['cognome_maeDaAltraPag'])) { echo ("value ='".$_POST['cognome_maeDaAltraPag']."'");}?> onchange="requery();">
						</div>
					</div>
					<div class=" col-md-12 col-xs-12 itemSchedaAnagrafica" style=" margin-top: -5px; z-index: 15;">
						<div class="col-xs-12 col-md-4 col-md-offset-4" style="position: absolute;  left: 0px; text-align: center; padding:0px; ">
							<div id="showresult" style="text-align: center; cursor: default; z-index: 15;" ></div>
						</div>
					</div>

				</div>
            </div>
			<div class="scroll" id="SchedaMaestro_det">
			</div>
		</div>
	</div>
</body>
</html>


<!--FORM MODALE MODIFICA AFFILIAZIONE MAESTRO *****************************************************************************-->
<div class="modal" id="modalAffiliazione" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px; width: 60%">
			<div class="modal-content">
				<div class="modal-body white">
					<form id="form_Affiliazione" method="post">
						<span class="titoloModal">Affiliazione a socio/socia</span><br>
						<span class="testoModal" id="subtitleAffiliazione"></span>
						<!-- <input id="ID_fam_hidden" value="<?//=$ID_fam_alu?>" hidden> -->
						<input id="padremadre_hidden" hidden>
						<div id="remove-contentAffiliazione" style="text-align: center; margin-top: 20px; "> <!-- START REMOVE CONTENT -->
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
	$(document).ready(function(){
		requery();
	});
		
	$('.search-box').on("keyup input", function(){
		// Get input value on change
		let role_usr = $('#role_usr').val();
		let inputVal = $(this).val();
		let resultDropdown = $("#showresult");
		if(inputVal.length){
			campo = $(this).attr("name");
				$.get("08qry_DropDown.php", {inputVal: inputVal, campo: campo, role_usr: role_usr}).done(function(data){
				// Display the returned data in browser
				resultDropdown.html(data);
				});
		} else {
			resultDropdown.empty();
		}
	});
	
	$(document).on("click", "#showresult p", function(){
		//quando si fa clic sulla dropdown che compare, accade questo
		//si pesca l'ID dalla stringa (che è nascosto)
		//si pesca il nome (prima di -)
		//si pesca il cognome (dopo -)
		selected = $(this).text();
		ID_mae = selected.substr(0,selected.indexOf("+"));
		nome_mae = $("#nomeselected"+ID_mae).val();
		cognome_mae = $("#cognomeselected"+ID_mae).val();
		$("#nome_mae").val(nome_mae);
		$("#cognome_mae").val(cognome_mae);
		$("#ID_mae_det_hidden").val(ID_mae); 
		$(this).parent("#showresult").empty();
		requery();
		//$("#pagtoshow_hidden").val("DatiAnagrafici");

		
	});
	
	$(document).on("click", ".showcomune p", function(){
		//campo = this.name;
		campo = $(this).parent().attr("name");
		selected = $(this).text();
		ID_cap = selected.substr(0,selected.indexOf("+"));
		comuneselected = $("#comuneselected"+ID_cap).val();
		provselected = $("#provselected"+ID_cap).val();
		paeseselected = "Italia";
		CAPselected = $("#CAPselected"+ID_cap).val();
		switch (campo) {
			case "showComuneNascita_new":
				$("#comunenascita_mae_new").val(comuneselected);
				$("#provnascita_mae_new").val(provselected);
				$("#paesenascita_mae_new").val(paeseselected);
			break;
			case "showComuneResidenza_new":
				$("#citta_mae_new").val(comuneselected);
				$("#prov_mae_new").val(provselected);
				$("#paese_mae_new").val(paeseselected);
				$("#CAP_mae_new").val(CAPselected);
			break;
			case "showComuneNascita_det":
				$("#comunenascita_mae_det").val(comuneselected);
				$("#provnascita_mae_det").val(provselected);
				$("#paesenascita_mae_det").val(paeseselected);
			break;
			case "showComuneResidenza_det":
				$("#citta_mae_det").val(comuneselected);
				$("#prov_mae_det").val(provselected);
				$("#paese_mae_det").val(paeseselected);
				$("#CAP_mae_det").val(CAPselected);
			break;
		}
			$(this).parent().empty();
	});
	
	function requery(){
		let ID_mae = $("#ID_mae_det_hidden").val(); 
		postData = { ID_mae : ID_mae };
		$.ajax({
			type: 'POST',
			url: "08qry_SchedaMaestro.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#SchedaMaestro_det").html(html);
				$("#conteggiorecord").html( $("#contarecord_hidden").val());
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '08SchedaMaestro ##fname##'");      
			}
		});
	}




	function showModalAffiliazione(ID_mae) {


		$("#ID_mae_det_hidden").val(ID_mae); 
		// $('#nomesocio').val(nome);
		// $('#cognomesocio').val(cognome);

			$('#nomesocio').val( $('#nome_mae_det').val() );
			$('#cognomesocio').val(  $('#cognome_mae_det').val() );


		postData = { ID_fam_mae_soc : ID_mae, padremadre_soc: "maestro"};
		//console.log ("08SchedaMaestro.php - showModalAffiliazione - postData a 06qry_getSocio.php ");
		//console.log (postData);
		$("#pagtoshow_hidden").val("DatiAnagrafici");

		$.ajax({
			type: 'POST',
			url: "06qry_getSocio.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				console.log ("08SchedaMaestro.php - showModalAffiliazione - ritorno da 06qry_getSocio.php ");
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
				alert("Errore: contattare l'amministratore fornendo il codice di errore '08SchedaMaestro ##eliminaAffiliazione##'");      
			}
		});
	}

	function aggiornaAffiliazione (ID_soc) {

		dataiscrizione_soc = $('#dataiscrizione_soc').val();
		datadisiscrizione_soc= $('#datadisiscrizione_soc').val();
		tipo_soc = $('#selectTipoSoc').val();
		postData = { ID_soc: ID_soc, dataiscrizione_soc: dataiscrizione_soc, datadisiscrizione_soc: datadisiscrizione_soc, tipo_soc: tipo_soc};
		console.log ("08SchedaMaestro.php - aggiornaAffiliazione - postData a 21qry_updateAffiliazione.php ");
		console.log (postData);
		$.ajax({
			type: 'POST',
			url: "21qry_updateAffiliazione.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				console.log ("08SchedaMaestro.php - aggiornaAffiliazione - ritorno da 21qry_updateAffiliazione.php ");
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
				alert("Errore: contattare l'amministratore fornendo il codice di errore '08SchedaMaestro ##aggiornaAffiliazione##'");      
			}
		});
	}

	function inserisciAffiliazione () {

		ID_mae = $('#ID_mae_det_hidden').val();

		dataiscrizione_soc = $('#dataiscrizione_soc').val();
		datadisiscrizione_soc= $('#datadisiscrizione_soc').val();

		postData = { ID_fam_mae: ID_mae, padremadre: "maestro", dataiscrizione_soc: dataiscrizione_soc, datadisiscrizione_soc: datadisiscrizione_soc};
		console.log ("08SchedaMaestro.php - aggiornaAffiliazione - postData a 21qry_insertAffiliazione.php ");
		console.log (postData);
		$.ajax({
			type: 'POST',
			url: "21qry_insertAffiliazione.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				console.log ("08SchedaMaestro.php - aggiornaAffiliazione - ritorno da 21qry_insertAffiliazione.php ");
				console.log (data);
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
				alert("Errore: contattare l'amministratore fornendo il codice di errore '08SchedaMaestro ##inserisciAffiliazione##'");      
			}
		});
	}
	
</script>
