<?	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("assets/functions/ifloggedin.php");
	include_once("classi/alunni.php");?>
	
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Compiti e Verifiche</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
	<link href="assets/datetimepicker/datepicker.css" rel="stylesheet" type="text/css" />
	<script src="assets/moment/moment.js" type="text/javascript"></script>
	<script src="assets/datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
	<? $_SESSION['page'] = "Compiti e Verifiche";?>
</head>

<body style="overflow: auto;">
	<? include("NavBar.php"); ?>
	<div id="main">
		<? include_once("assets/functions/lowreswarning.html"); ?>
		<div class="highres">
			<input id="hidden_tipoUser" type="text" value ='<?=$_SESSION ['role_usr'];?>' style="margin-left: 70px" hidden>
			<input id="hidden_ID_mae" type="text" value ='<?=$_SESSION['ID_mae'];?>' style="margin-left: 70px" hidden>
			<div id="combomaestri">
				
			</div>
			<? //include("assets/functions/combomaestroCompitieVerifiche.php"); ?>
			<div class="titoloPagina" >
				Compiti e Verifiche
			</div>
			<div class="ml50">
				<input id="pswOperazioni1" value="<?=$_SESSION['pswOperazioni1']?>" hidden>
			</div>
			<div align="center">
				<table id="Selectvarie" style="margin-left: 55px; ">
					<tr>
						<td class="center">
							anno scolastico
						</td>
						<td class="center">
							Quadrimestre
						</td>
						<td class="center">
							Classe
						</td>
						<td class="center">
							Sezione
						</td>
					</tr>
					<tr>
						<td>
							<select name="selectannoscolastico w100px"  style="margin-left: 0px"  id="selectannoscolastico" onchange="popolaComboMaestri(); changedAnnoscolastico();">
								<?foreach (GetArrayAnniScolasticiFrequentati() as $alunno) {
									?> <option value="<? echo ($alunno->annoscolastico_cla) ?>"  <? if ($alunno->annoscolastico_cla == $_SESSION["anno_corrente"]) { echo 'selected';}	?>><? echo ($alunno->annoscolastico_cla) ?></option><?
								}?>
							</select>
						</td>
						<td style="max-width:150px;" id="selectQuadrimestreContainer">
						</td>
						<td style="text-align: center;" id="selectClasseContainer">
						</td>
						<td style="text-align: center; max-width:70px;">
							<select name="selectsezione"  style="width:40px;"  id="selectsezione" onchange="requery();">
								<option value="A" selected>A</option>
								<option value="B">B</option>
								<option value="C">C</option>	
							</select>
						</td>
					</tr>
				</table>
			</div>
			<table id="tabellaIMieiAlunni" style="margin-left: 55px; ">
				<thead>
					
					<tr>
						<td colspan="5" style="height: 10px"></td>
					</tr>
					<tr>
						<td>
							
						</td>
						<td>
						</td>
						<td>
						</td>
						<td>
						</td>
						<td>
						</td>
						<td style="text-align: center;">
							
						</td>
					</tr>
					<tr id="colonneCompiti">
					</tr>
				</thead>
				<tbody id="maintable">
				</tbody>
			</table>
		</div>
	</div>
	<!--*******************************************MODAL FORM ADD COMPITO-->
	<div class="modal" id="modalAddCompito" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px; width: 50%">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_AddCompito" method="post">
						<span class="titoloModal">Inserimento nuovo Compito o Verifica</span>
						<div class="alert alert-success" id="alertaggiungi" style="display:none;">
							<div id="alertmsg">
							  Inserimento completato con successo!
							</div>
						</div>
						<div id="remove-content" style="text-align: center; margin-top: 20px; "> <!-- START REMOVE CONTENT -->
							<div class="row">
								<div class="col-md-2" style="text-align: center;">
									classe
								</div>
								<div class="col-md-2" style="text-align: center;">
									sezione
								</div>
								<div class="col-md-3" style="text-align: center;">
									materia
								</div>
								<div class="col-md-2" style="text-align: center;">
									tipo
								</div>
								<div class="col-md-3" style="text-align: center;">
									data
								</div>
							</div>
							<div class="row">
								<div class="col-md-2">
									<input class="tablecell5" style="text-align: center;" type="text"  id="ID_cov_new" name="ID_cov" hidden>
									<input class="tablecell5" style="text-align: center;" type="text"  id="classe_cov_new" name="classe_cov_new" disabled>
								</div>
								<div class="col-md-2">
									<input class="tablecell5" style="text-align: center;" type="text"  id="sezione_cov_new" name="sezione_cov_new" disabled>
								</div>
								<div class="col-md-3" id="selectMaterieNewContainer" style="text-align: center;">

								</div>
								<div class="col-md-2">
									<input class="tablecell5" style="text-align: center;" type="text"  id="tipo_cov_new" name="tipo_cov_new" maxlength = 3>
								</div>
								<div class="col-md-3" style="text-align: center;">
									<input class="datepicker tablecell2 dpd" type="text"  id = "data_cov_new" name="data_cov_new" value = "" style="text-align: center;" required onkeydown="return false;">
								</div>
							</div>
							<div class="row" style="margin-bottom:20px;">
								<div class="col-md-12" style="margin-top:30px;">
									Descrizione argomento
									<br>
									<textarea class="tablecell5 w100" type="text"  id="argomento_cov_new" name="argomento_cov_new"></textarea>
								</div>
							</div>							
						</div> <!-- END REMOVE CONTENT -->
						<div class="modal-footer">
							<button type="button" id="btn_cancel1" class="btnBlu pull-left" style="width:40%;" data-dismiss="modal">Annulla</button>
							<button type="button" id="btn_OK1" class="btnBlu pull-right" style="width:40%;" onclick="salvaCompito();">Procedi</button>
						</div>
					</form>
				</div>
			</div><!-- fine modal-content -->
		</div><!-- fine modal-dialog -->
	</div>

	<div class="modal" id="modalEditGiudizi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px; width: 50%">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_EditGiudizi" method="post">
						<span class="titoloModal">Modifica Giudizi</span>
						<div id="remove-contentGiudizi" style="text-align: center; margin-top: 5px; "> <!-- START REMOVE CONTENT -->
								
						</div> <!-- END REMOVE CONTENT -->
						<div class="alert alert-success" id="alertaggiungi" style="display:none;">
							<div id="alertmsgGiudizi">
							  Inserimento completato con successo!
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" id="btn_cancelGiudizi" class="btnBlu" style="width:40%;" data-dismiss="modal">Chiudi</button>
							<!-- <button type="button" id="btn_OKGiudizi" class="btnBlu pull-right" style="width:40%;" onclick="salvaGiudizi();">Procedi</button> -->
						</div>
					</form>
				</div>
			</div><!-- fine modal-content -->
		</div><!-- fine modal-dialog -->
	</div>



</body>
</html>

<script>

	$(document).ready(function(){
		//console.log ("lancio changedAnnoScoladtico");
		popolaComboMaestri();
		//copyToHiddenAndSetSession();
		changedAnnoscolastico();
		moment.locale('en', {
          week: { dow: 1 }
        });
		$('.dpd').datetimepicker({
			pickTime: false, 
			format: "DD/MM/YYYY",
            weekStart: 1
            //format: "DD/MM"
		});

	});
	
	function popolaComboMaestri() {
		annoscolastico_cma = $( "#selectannoscolastico option:selected" ).val();
		postData = { annoscolastico_cma: annoscolastico_cma};
		$.ajax({
			async: false,
			type: 'POST',
			url: "13qry_getComboMaestri.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#combomaestri").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '13CompitieVerifiche ##fname##'");     
			}
			
		});
	}
	
	function changedAnnoscolastico () {
		let annoscolastico_cma = $( "#selectannoscolastico option:selected" ).val();

		let ID_maeSession = $('#hidden_ID_mae').val();
		let ID_maeSelect = $('#selectmaestro').val();
		let tipoUser = $( "#hidden_tipoUser" ).val();

		if (tipoUser == 0 || tipoUser == 1) {
			//in questo caso l'ID_mae da guardare è quello della Select
			ID_mae = ID_maeSelect;
		} else {
			ID_mae = ID_maeSession;
		}

		postData = { annoscolastico_cma: annoscolastico_cma, ID_mae: ID_mae};
		//console.log ("13CompitieVerifiche.php - changedAnnoScolastico - postData a  13qry_getSelectClassi.php");
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "13qry_getSelectClassi.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				//console.log ("13CompitieVerifiche.php - changedAnnoScolastico - lancio di  13get_SelectQuadrimestre.php");
				$("#selectClasseContainer").html(html);
				$.ajax({
					type: 'POST',
					url: "13qry_getSelectQuadrimestre.php",
					data: postData,
					dataType: 'html',
					success: function(html){
						//console.log ("13CompitieVerifiche.php - changedAnnoScolastico - lancio di  13get_SelectMaterie.php");
						$("#selectQuadrimestreContainer").html(html);
						$.ajax({
							type: 'POST',
							url: "13qry_getSelectMaterie.php",
							data: postData,
							dataType: 'html',
							success: function(html){
								//console.log ("13CompitieVerifiche.php - changedAnnoScolastico - lancio di  requery.php");
								$("#selectMaterieNewContainer").html(html);
								requery();
							},
							error: function(){
								alert("Errore: contattare l'amministratore fornendo il codice di errore '13CompitieVerifiche ##fname##'");     
							}
						});
					},
					error: function(){
						alert("Errore: contattare l'amministratore fornendo il codice di errore '13CompitieVerifiche ##fname##'");     
					}
				});
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '13CompitieVerifiche ##fname##'");     
			}
		});
	}

	function requery(){

		let ID_maeSession = $('#hidden_ID_mae').val();
		let ID_maeSelect = $('#selectmaestro').val();
		let tipoUser = $( "#hidden_tipoUser" ).val();
		if (tipoUser == 0 || tipoUser == 1) {
			//in questo caso l'ID_mae da guardare è quello della Select
			ID_mae = ID_maeSelect;
		} else {
			ID_mae = ID_maeSession;
		}

		let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();
		let classe_cla = $( "#selectclasse option:selected" ).val();
		let sezione_cla = $( "#selectsezione option:selected" ).val();
		let date_quadrimestre = $( "#selectquadrimestre option:selected" ).val();
		let date_from = date_quadrimestre.substr (0,10);
		let date_to = date_quadrimestre.substr (11,20);
		postData = { annoscolastico_cla: annoscolastico_cla, classe_cla : classe_cla, sezione_cla: sezione_cla, ID_mae: ID_mae, date_from: date_from, date_to: date_to};
		//console.log ("13CompitieVerifiche.php - requery - postData a 13qry_CompitiVerificheColonne.php");
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "13qry_CompitieVerificheColonne.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				//console.log ("13CompitieVerifiche.php - requery - ritorno html da 13qry_CompitiVerificheColonne.php");
				//console.log (html);
				$("#colonneCompiti").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '13CompitieVerifiche ##fname##'");     
			}
		});	

		postData2 = {annoscolastico_cla: annoscolastico_cla, classe_cla : classe_cla, sezione_cla: sezione_cla, ID_mae: ID_mae, date_from: date_from, date_to: date_to};
		//console.log ("13CompitieVerifiche.php - requery - postData a 13qry_CompitiVerifiche.php");
		//console.log (postData2);
		$.ajax({
			type: 'POST',
			url: "13qry_CompitieVerifiche.php",
			data: postData2,
			dataType: 'html',
			success: function(html){
				//console.log ("13CompitieVerifiche.php - requery - ritorno html da 13qry_CompitiVerifiche.php");
				//console.log (html);
				$("#maintable").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '13CompitieVerifiche ##fname##'");     
			}
		});
	}
	
	function showModalAddCompito (){
		resetModalAddCompito();
		$('#form_AddCompito')[0].reset();
		let classe_cla = $("#selectclasse option:selected" ).val();
		$("#classe_cov_new").val(classe_cla);
		let sezione_cla = $( "#selectsezione option:selected" ).val();
		$("#sezione_cov_new").val(sezione_cla);
		$('#modalAddCompito').modal({show: 'true'});
	}
	





	function resetModalAddCompito() {
		$('#form_AddCompito')[0].reset();
		$("#remove-content").show();
		$("#alertaggiungi").addClass('alert-danger');
		$("#alertaggiungi").removeClass('alert-success');
		$("#alertmsg").html('Compito inserito!');
		$("#alertaggiungi").hide();
		$("#btn_cancel1").html('Annulla');
		$("#btn_cancel1").addClass('pull-left');
		$("#btn_OK1").show();
	}
	
	function salvaCompito(){
		data_cov = $('#data_cov_new').val();
		if (data_cov=="") {
			$("#alertaggiungi").removeClass('alert-success');
			$("#alertaggiungi").addClass('alert-danger');
			$("#alertmsg").html('la data è obbligatoria!');
			$("#alertaggiungi").show();
		} else {
			let postData = $("#form_AddCompito").serializeArray();
			let classe_cla = $("#selectclasse option:selected" ).val();
			postData.push( {name: "classe_cla", value: classe_cla}  );
			let sezione_cla = $( "#selectsezione option:selected" ).val();
			postData.push( {name: "sezione_cla", value: sezione_cla}  );
			let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();
			postData.push( {name: "annoscolastico_cla", value: annoscolastico_cla}  );

			let ID_maeSession = $('#hidden_ID_mae').val();
			let ID_maeSelect = $('#selectmaestro').val();
			let tipoUser = $( "#hidden_tipoUser" ).val();
			if (tipoUser == 0 || tipoUser == 1) {
				//in questo caso l'ID_mae da guardare è quello della Select
				ID_mae = ID_maeSelect;
			} else {
				ID_mae = ID_maeSession;
			}

			postData.push( {name: "ID_mae", value: ID_mae}  );

			//console.log ("13CompitieVerifiche.php - salvaCompito - postData a 13qry_insertCompito.php");
			//console.log (postData);
			$.ajax(
			{
				url : "13qry_insertCompito.php",
				type: "POST",
				data : postData,
				dataType: "json",
				success:function(data) {
					console.log (data.sql);
					$("#remove-content").slideUp();
					$("#alertaggiungi").removeClass('alert-danger');
					$("#alertaggiungi").addClass('alert-success');
					$("#alertmsg").html('Compito inserito!');
					$("#alertaggiungi").show();
					$("#btn_cancel1").html('Chiudi');
					$("#btn_cancel1").removeClass('pull-left');
					$("#btn_goto1").show();
					$("#btn_OK1").hide();
					requery();
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '13CompitieVerifiche ##fname##'");     
				}
			});
		}
	}
	
	function copyToHiddenAndSetSession () {
		// let ID_mae = $('#selectmaestro').val();
		// $('#hidden_ID_mae').val(ID_mae);
		// postData = { ID_mae : ID_mae };
		// $.ajax({
		// 	type: 'POST',
		// 	url: "11qry_SetSessionID_mae.php",
		// 	data: postData,
		// 	dataType: 'json',
		// 	success: function(data){
		// 	}
		// });
		
	}




//Routine per la scrittura dei voti
	$('.voto_vcc').keyup(function (event) {
		let $this = $(this);
		let str = $this.val();
		$this.val(str.replace(",,", ","));
		if ((str < 1 || str > 10) && str.length != 0) {
			if (str < 1) {
				$this.val(1);
			}
			if (str > 10) {
				$this.val(10);
			}
		}
		//console.log (str.length);
		//console.log($this.val());
		if ( str.length > 3) {
			event.preventDefault();
		}
		
	});
	
	//metto sia la funzione keyup sia la funzione change e fanno la stessa cosa: solo così vedo che non va in errore lasciandosi scappare qualche caso
	$('.voto_vcc').change(function () {
		let $this = $(this);
		let str = $this.val();
		$this.val(str.replace(",,", ","));
		if ((str < 1 || str > 10) && str.length != 0) {
			if (str < 1) {
				$this.val(1);
			}
			if (str > 10) {
				$this.val(10);
			}
		}
		//console.log (str.length);
		//console.log($this.val());
		if ( str.length > 3) {
			event.preventDefault();
		}

	});

	function isNumberKey(evt){
         let charCode = (evt.which) ? evt.which : event.keyCode;
		 console.log (charCode);
        // if (charCode > 31 && (charCode < 48 || charCode > 57)){
		if (charCode < 32 || (charCode >47 && charCode < 58) || charCode == 44){
            return true;
         } else {
			return false;
		}
    }

	function requeryDettaglio(ID_alu){	
		coloraRighe (ID_alu);
	}

	function coloraRighe(ID_alu){
		//pulisco colore delle celle di tutte le righe
		$('#tabellaIMieiAlunni tbody tr:even td .tablecell3').css('background-color', '#e0e0e0').css('color', '#474747');
		$('#tabellaIMieiAlunni tbody tr:odd td .tablecell3').css('background-color', '#fff').css('color', '#474747');
		$('.val'+ID_alu).css('background-color', '#289bce').css('color', '#fff');
	}

	function showModalDeleteThisRecord(ID_cov, data_cov) {
		console.log (data_cov);
			$('#msg03Msg_OKCancelPsw').html("Sei sicuro di voler eliminare il compito del "+data_cov +"?<br><br> digitare la password e confermare");
			$("#btn_OK03Msg_OKCancelPsw").attr("onclick","deleteThisRecord("+ID_cov+");");
			$("#btn_OK03Msg_OKCancelPsw").show();
			$("#titolo03Msg_OKCancelPsw").html('ELIMINAZIONE COMPITO');
			$("#btn_cancel03Msg_OKCancelPsw").html('Annulla');
			$("#remove-content03Msg_OKCancelPsw").show();
			$("#alertCont03Msg_OKCancelPsw").removeClass('alert-success');
			$("#alertCont03Msg_OKCancelPsw").addClass('alert-danger');
			$("#alertCont03Msg_OKCancelPsw").hide();
			$("#passwordDelete").val("");
			$('#modal03Msg_OKCancelPsw').modal('show');
	}
	
	function deleteThisRecord (ID_cov) {
		let psw = $("#passwordDelete").val();
		let pswOperazioni1 = $("#pswOperazioni1").val();
		if (psw == null || psw == "" || psw !=pswOperazioni1 ) {
			$("#alertMsg03Msg_OKCancelPsw").html('Password Errata!');
			$("#alertCont03Msg_OKCancelPsw").show();
		}	else  {
			postData = { ID_cov: ID_cov};
			$.ajax({
				type: 'POST',
				url: "13qry_deleteCompitoeVoti.php",
				data: postData,
				dataType: 'json',
				success: function(){
					$("#remove-content03Msg_OKCancelPsw").slideUp();
					$("#alertMsg03Msg_OKCancelPsw").html('Compito eliminato!');
					$("#alertCont03Msg_OKCancelPsw").removeClass('alert-danger');
					$("#alertCont03Msg_OKCancelPsw").addClass('alert-success');
					$("#alertCont03Msg_OKCancelPsw").show();
					$("#btn_cancel03Msg_OKCancelPsw").html('Chiudi');
					$("#btn_OK03Msg_OKCancelPsw").hide();
					requery();
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '13CompitieVerifiche ##fname##'");     
				}
			});
		}
	}

</script>