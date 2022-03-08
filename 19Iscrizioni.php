<?
	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("assets/functions/ifloggedin.php");
	include_once("classi/alunni.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Iscrizioni</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name=”robots” content=”noindex”>
	<link rel="shortcut icon" href="assets/img/faviconbook.png" type="image/icon">
	<link rel="icon" href="assets/img/faviconbook.png" type="image/icon">
	<script src="assets/jquery/jquery-3.3.1.js" type="text/javascript"></script>
    <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<script src="assets/bootstrap/bootstrap.min.js" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="assets/datetimepicker/datepicker.css" rel="stylesheet" type="text/css" />
	<script src="assets/moment/moment.js" type="text/javascript"></script>
	<script src="assets/datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
    <link rel="stylesheet" href="assets/bootstrap-select/bootstrap-select.css">
	<script src="assets/bootstrap-select/bootstrap-select.js"></script>
	<script src="assets/functions/functionsJS.js"></script>

	<? $_SESSION['page'] = "Iscrizioni";?>
</head>

<body>

	<? include("NavBar.php"); ?>
	<div id="main" >
		<? include_once("assets/functions/lowreswarning.html"); ?>
	
		<div class="upper highres">

			<!-- <div id="rightmenu" class="rightmenu fs12" style="position: fixed; display: none;" onclick="hideRightMenu()">
				<input class="rightmenuinput w120px"  id="rightmenuinput"	value="" readonly>
			</div>	 -->


			<div class="titoloPagina" >
				Iscrizioni
			</div>
			<div class="sottotitoloPagina" >
				(pagina dedicata alla gestione dell'invio delle pre-iscrizioni e raccolta dei risultati)
			</div>
			<div class="ml50">
				<input id="quote_fratelli_diverse" 	class="ml50" value="<?=$_SESSION['quote_fratelli_diverse']?>" 	hidden>
				<input id="pswOperazioni0" 			class="ml50" value="<?=$_SESSION['pswOperazioni0']?>" 			hidden>
				<input id="pswOperazioni1" 			class="ml50" value="<?=$_SESSION['pswOperazioni1']?>"			hidden>

			</div>
			<div class="frameXlDownload">
				<div class="row center">
					download excel
				</div>
				<div>
					<select class="selectXl" id="selectDownloadExcel">
						<option value="DownloadExcelPreIscritti">Tutti i Pre-iscritti</option>
						<option value="DownloadExcelCompilati">Dati compilati Finora</option>
					</select>
					<img onclick="DownloadExcel()" class="miniButtonXl" src='assets/img/Icone/logoexcel2019.svg'>
				</div>
			</div>

			<div class="frameTopLeft" style="padding-left: 20px;">
				<div class="row mt5">
					<!-- <input id="annoscolastico" value="<?//=$_SESSION['anno_iscrizioni']?>" readonly> -->
					
					<select name="selectannoscolastico"  style="width: 140px;"  id="selectannoscolastico" onchange="requery();">
							<?foreach (GetArrayAnniScolasticiFrequentati() as $alunno) {?>
								<option value="<?=$alunno->annoscolastico_cla?>"
									<?if ($alunno->annoscolastico_cla == $_SESSION['anno_iscrizioni']) { 
										echo 'selected';
									}?>
								>
									<?=$alunno->annoscolastico_cla?>
								</option>
							<?}?>
					</select>

					<input class="tablecell5" type="text"  id="databaseA_hidden" name="databaseA" value = "<?=$_SESSION['databaseA']?>" hidden>
					<input id="URLiscrizioni_hidden" name="URLiscrizioni_hidden" value="<?=getPar('URLiscrizioni');?>" hidden>
					a.s.
				</div>

				<div class="row mt5">
					<select name="selectlistaattesa"  style="width: 140px;  margin-left: 0px"  id="selectlistaattesa" onchange="requery();">
						<option value="0" 	<? if (isset ($_POST['listaattesaDaCruscotto']) && ($_POST['listaattesaDaCruscotto'] == '0'  )){ echo 'selected';} else if (!(isset ($_POST['listaattesaDaCruscotto']))) { echo 'selected';} ?> >Nascondi lista d'attesa</option>
						<option value="1" 	<? if (isset ($_POST['listaattesaDaCruscotto']) && ($_POST['listaattesaDaCruscotto'] == '1'  )){ echo 'selected';}?> >Solo lista D'Attesa</option>
						<option value="All" <? if (isset ($_POST['listaattesaDaCruscotto']) && ($_POST['listaattesaDaCruscotto'] == 'All')){ echo 'selected';}?>>Mostra Tutti</option>
					</select>
				</div>

			</div>

			
			
			<div style="text-align: left;">
				<table id="tabellaIscrizioni" style="margin-left: 50px; margin-top: 20px; display: inline-block;">
					<thead style="margin-bottom: 0px;">
						<tr>
							<th style="width:40px;">
								<!-- <img title="Iscrizione al volo" class="iconaStd" class="hideonsmalldevices" src='assets/img/Icone/circle-plus.svg' onclick="showModalAddIscrizioneAlVolo();"> -->
							</th>
							<th>
								<input class="tablelabel4" style="width:120px" type="text" id="nome_alu" name="nome_alu" value = "NOME" disabled>
							</th>
							<th>
								<input class="tablelabel4"  style="width:120px" type="text" id="cognome_alu" name="cognome_alu" value = "COGNOME" disabled>
							</th>
							<th>
								<input class="tablelabel4"  style="width:90px" type="text" id="classe_cla" name="classe_cla" value = "CLASSE" disabled>
							</th>
							<th>
								<input class="tablelabel4"  style="width:50px" type="text" id="sezione_cla" name="sezione_cla" value = "SEZ." disabled>
							</th>
							<!-- <th>
								<input class="tablelabel4"  style="width:90px" type="text" id="annoscolastico_cla" name="annoscolastico_cla" value = "A.S." disabled>
							</th> -->
							<th>
								<button class="ordinabutton w100" style="width: 90px; height: 24px;" onclick="showModalInviaMailATutti()" >
									<img title="Invia email a Tutti" style="width: 55px; cursor: pointer" src='assets/img/Icone/multi-envelope-regular.svg'>
								</button>
								<!-- <input class="tablelabel4"  style="width:90px" type="text" value = "INVIA MAIL" disabled> -->
							</th>
							<th>
								<input class="tablelabel4"  style="width:20px" type="text" value = "X" disabled>
							</th>
							<th>
								<input class="tablelabel4 w80px"  type="text" id="mailinviate_fam" name="mailinviate_fam" value = "Mail Inviate" disabled>
							</th>
							<th>
								<input class="tablelabel4 w100px" type="text" id="login_fam" name="login_fam" value = "Login" disabled>
							</th>
							<th>
								<input class="tablelabel4 w60px"  type="text" id="login_fam" name="login_fam" value = "Set Psw" disabled>
							</th>
							<th>
								<img style="position: relative; float: left;  width: 20px; cursor: pointer;  z-index: 15; " src='assets/img/Icone/unlock.svg'>
							</th>
							<th>
								<input class="tablelabel4"  style="width:90px" type="text" id="loginusata_fam" name="loginusata_fam" value = "Login usata" disabled>
							</th>
							<th>
								<input class="tablelabel4"  style="width:90px" type="text" id="iscrcompleta_fam" name="iscrcompleta_fam" value = "Iscrizione%" disabled>
							</th>
							<th>
								<button class="ordinabutton" style="width: 60px; padding: 0px; height: 24px;" onclick="downloadModuloIscrizione(10000000);" >
									<img title="Stampa Modulo Vuoto" style="width: 23px; cursor: pointer" src='assets/img/Icone/EmissioneDocumentiBlackBlank.svg'>
								</button>
							</th>
							<th>
								<input class="tablelabel4"  style="width:80px" type="text" value = "Recupera" disabled>
							</th>
							<th>
								<input class="tablelabel4"  style="width:80px" type="text" value = "Recuperato" disabled>
							</th>
							<th>
								<input class="tablelabel4"  style="width:80px" type="text" value = "Iscrizione" disabled>
							</th>

						</tr>
						<tr>
							<th>
								<span id="conteggiorecord"></span>
							</th>
							<th>
								<button id="ordinacampo1" class="ordinabutton" onclick="ordina(1);" style="font-size:8px">--</button>
								<input class="tablecell3 filtercell" style="width:90px" type="text"  onchange="requery();" id="filter1" name="filter1">				
							</th>
							<th>
								<button id="ordinacampo2" class="ordinabutton" onclick="ordina(2);" style="font-size:8px">--</button>
								<input class="tablecell3 filtercell" style="width:90px" type="text"  onchange="requery();" id="filter2" name="filter2">				
							</th>
							<th>
								<button id="ordinacampo3" class="ordinabutton" onclick="ordina(3);" style="font-size:8px">--</button>
								<input class="tablecell3 filtercell" style="width:60px" type="text"  onchange="requery();" id="filter3" name="filter3">
							</th>
							<th>
								<button id="ordinacampo4" class="ordinabutton" onclick="ordina(4);" style="font-size:8px">--</button>
								<input class="tablecell3 filtercell" style="width:20px" type="text"  onchange="requery();" id="filter4" name="filter4">
							</th>
							<!-- <th> -->
								<!--<button id="ordinacampo5" class="ordinabutton" onclick="ordina(5);" style="font-size:8px">--</button>
								<input class="tablecell3 filtercell" style="width:60px" type="text"  onchange="requery();" id="filter5" name="filter5">-->
							<!-- </th> -->
							<th>
								<!--<input id="allckbox" type="checkbox" onclick="ckboxtutti();" style="margin-left: 3px;">-->
								<button id="inviaAtutti" class="inviaAtutti" onclick="inviaATutti();" style="display: none; font-size: 10px; width: 100%;">INVIA A TUTTI</button>
							</th>
							<th>
							</th>
							<th>
							</th>
							<th>
							</th>
							<th>
							</th>
							<th>
							</th>
							<th>
							</th>
							<th>
								<button id="ordinacampo5" class="ordinabutton" onclick="ordina(5);" style="font-size:8px">--</button>
							</th>
							<th>
								<button class="ordinabutton" style="width: 60px; padding: 0px; height: 24px;" onclick="downloadModuliAnno();" >
									<img title="Stampa Tutti i Moduli" style="width: 35px; cursor: pointer" src='assets/img/Icone/EmissioneDocumentiBlackMultiplo.svg'>
								</button>
							</th>
							<th>
							</th>
							<th>
							</th>
							<th>
								<button id="ordinacampo6" class="ordinabutton" onclick="ordina(6);" style="font-size:8px">--</button>
							</th>
						</tr>
					</thead>
					<tbody id="maintable">
					</tbody>
				</table>
			</div>
		</div>
		
		<div class="lower highres">
			<hr style="height: 12px;   border: 0;   box-shadow: inset 0 12px 12px -12px rgba(0, 0, 0, 0.5); margin-bottom: 0px; margin-top: 0px;">
			<div id="alunnodettaglio">
			</div>
		</div>
		
	</div>
	

	<div class="modal" id="modalImportazione" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
		<div class="modal-dialog" style="font-size:14px; width: 80%">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_Importazione" method="post">
						<span class="titoloModal">Dettagli Importazione</span><br>
						
						<div class="alert alert-danger" id="alertaggiungiImportazione" style="display:none; margin-top:10px; padding: 10px;">
							<h5 id="alertmsgImportazione" style="text-align:center;"> 
							  Importazione completata con successo!
							</h5>
						</div>
						<div id="remove-contentImportazione" style="text-align: center; margin-top: 10px; "> <!-- START REMOVE CONTENT -->
						
							<div class="col-md-10 col-md-offset-1" id="importazioneeconfronto">
								
							</div>
						</div> <!-- END REMOVE CONTENT -->
						<div class="modal-footer">
							<button type="button" id="btn_cancel1Importazione" class="btnBlu pull-left" style="width:40%;" data-dismiss="modal">Annulla</button>
							<button type="button" id="btn_OK1Importazione" class="btnBlu pull-right" style="width:40%;" onclick="ImportaSelezionati();">Importa (solo iscritti)</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>




<!--*******************************************MODAL CHG PSW************************************-->
<div class="modal" id="modalChgPsw" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<span class="titoloModal">MODIFICA PASSWORD</span><br>
					<span class="titoloModal">per utente</span>
					<div id="modalChgPsw-testo">
					</div>
					<div id="remove-contentChgPsw" style="text-align: center; margin-top: 10px; ">
						<div class="row">
							<div class="col-md-4">
							</div>
							<div class="col-md-4">
								<input class="tablecell5" type="text"  id="usr_new_hidden" maxlength="50" name="usr_new_hidden" hidden>
								<input class="tablecell5" type="text"  id="psw_new" maxlength="50" name="psw_new">
							</div>
						</div>
					</div>
					<div class="alert alert-success" id="alertChgPsw" style="display:none; margin-top:10px;">
						<h4 id="alertmsgChgPsw" style="text-align:center;"> 
							Modifica Password<br>completata con successo
						</h4>

					</div>
					<div class="modal-footer">
						<button type="button" id="btn_CancelChgPsw" class="btnBlu" style="width:40%;" data-dismiss="modal">Annulla</button>
						<button type="button" id="btn_OKChgPsw" class="btnBlu" style="width:40%;" onclick="setNewPsw();" >Procedi</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<!--*******************************************FINE MODAL CHG PSW*******************************-->


<!--***************************************FORM MODALE INSERIMENTO NUOVA ANAGRAFICA ALUNNO **************************************************-->
	
	<div class="modal" id="ModalAddIscrizioneAlVolo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px; width: 70%">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_AddAlunnoAlVolo" method="post">
						<span class="titoloModal">Inserimento iscrizione "al volo"</span><br>

						<div id="remove-content" style="text-align: center; margin-top: 10px; "> <!-- START REMOVE CONTENT -->
							<span style="width:70%; font-size: 14px; color: red;">NB: Utilizzare questa modalità solo per nuovi iscritti non già presenti in anagrafica!</span><br>
							<span style="width:70%; font-size: 14px; color: red;">Questa modalità non è da utilizzare per inserire alunni in lista d'attesa.</span>
							<div class="row">
								<div class="col-md-3">
									<input class="tablecell5" type="text"  id="IDAnagraficaAppenaInseritaHidden" name="IDAnagraficaAppenaInseritaHidden" hidden>
									
								</div>
								<div class="col-md-3" style="text-align: center;">
									nome
								</div>
								<div class="col-md-3" style="text-align: center;">
									cognome
									<br>
									<span style="font-size: 12px">(NB: uguale al cognome del padre)</span>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
								</div>
								<div class="col-md-3" style="text-align: center;">
									<input class="tablecell5" type="text"  id="nome_alu_new" name="nome_alu_new" required>
								</div>
								<div class="col-md-3" style="text-align: center;">
									<input class="tablecell5" type="text"  id="cognome_alu_new" name="cognome_alu_new" required>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
								</div>
								<div class="col-md-3" style="text-align: center;">
									Data di Nascita
								</div>
								<div class="col-md-1" style="text-align: center;">
									
								</div>
								<div class="col-md-1" style="text-align: center;">
									M/F
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
								</div>
								<div class="col-md-3" style="text-align: center;">
									<input class="tablecell5 datepicker" type="text"  id="datanascita_alu_new" name="datanascita_alu_new" required>
								</div>
								<div class="col-md-1" style="text-align: center;">
									
								</div>
								<div class="col-md-1" style="text-align: center;">
									<input class="tablecell5" type="text"  id="mf_alu_new" name="mf_alu_new" maxlength="1" required>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12" style="text-align: center; margin-top: 15px; ">
									<select id="selectFamiglia" name="selectFamiglia"  onchange="aggiornaCognomeModal('daform');">
										<? $sql = "SELECT ID_fam, cognomepadre_fam, cognomemadre_fam FROM tab_famiglie ORDER BY cognomepadre_fam";
											$stmt = mysqli_prepare($mysqli, $sql);
											mysqli_stmt_execute($stmt);
											mysqli_stmt_bind_result($stmt, $ID_fam, $cognomepadre_fam, $cognomemadre_fam);
											?> <option value="none" selected>-NUOVA FAMIGLIA-</option> <?
											while (mysqli_stmt_fetch($stmt)) {
											?> <option value="<?=$ID_fam?>" ><?=$cognomepadre_fam." - ".$cognomemadre_fam?></option><?
											}?>
									</select>
								</div>
								<div class="col-md-12" style= "margin-top: 0px; margin-bottom: 10px; font-size: 12px;">
										(Selezionare dalla casella a discesa se si tratta di un fratello/sorella di altro alunno già in anagrafica)
								</div>
							</div>
							<div class="row">
								<div class="col-md-3 center">
									
								</div>
								<div class="col-md-3 center">
									email mamma
								</div>
								<div class="col-md-3 center">
									email papà
								</div>
							</div>
							<div class="row">
								<div class="col-md-3 center">
									
								</div>
								<div class="col-md-3 center">
									<input type="text"  class="tablecell5"  id="emailmadre_fam_new" name="emailmadre_fam_new">
								</div>
								<div class="col-md-3 center">
									<input type="text"  class="tablecell5"  id="emailpadre_fam_new" name="emailpadre_fam_new">
								</div>
							</div>				
							<br>
							Selezionare l'anno scolastico al quale si desidera iscrivere l'alunno/a.
							<br>
							
							<input type="text"  class="tablecell5" style="text-align: center; width:120px""  id="modalannoscolastico_cla" name="modalannoscolastico_cla" value = "<?=$_SESSION['anno_prossimo']?>" disabled>
		
							<br>
							<br>
							Selezionare la classe alla quale si desidera iscrivere l'alunno/a.
							<br>
							<select name="selectclasse_modal"  style="margin-top: 5px;"  id="selectclasse_modal">
								<? $sql3 = "SELECT classe_cls FROM tab_classi";
									$stmt3 = mysqli_prepare($mysqli, $sql3);
									mysqli_stmt_execute($stmt3);
									mysqli_stmt_bind_result($stmt3, $classe_cls);
									while (mysqli_stmt_fetch($stmt3)) {
									?> <option value="<?=$classe_cls?>"><?=$classe_cls?></option><?
									}?>
							</select>
							<br>
							<br>
							Selezionare la sezione alla quale si desidera iscrivere l'alunno/a.
							<br>
							<select name="selectsezione_modal"  style="margin-top: 5px;"  id="selectsezione_modal">
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="C">C</option>
							</select>
							<br>
						</div> <!-- END REMOVE CONTENT -->
						
						<div class="alert alert-success" id="alertaggiungi" style="display:none; margin-top:10px;">
							<h4 id="alertmsg" style="text-align:center;"> 
							  Iscrizione completata con successo!
							</h4>
						</div>
						
						<div class="modal-footer" >
							<button type="button" id="btn_cancel1" class="btnBlu pull-left" style="width:30%;" data-dismiss="modal">Annulla</button>
							<!--<button type="button" id="btn_goto1" class="btnBlu pull-right" style="width:30%; display: none;" onclick="postToSchedaAlunnoNuovo();" >Vai alla Scheda</button>-->
							<button type="button" id="btn_OK1" class="btnBlu pull-right" style="width:30%;" onclick="addAnagraficaAndIscrizione();" >Invia Mail</button>
						</div>
					</form>
				</div>
			</div><!-- fine modal-content -->
		</div><!-- fine modal-dialog -->
	</div>
	<!--***************************************FINE FORM MODALE INSERIMENTO NUOVA ANAGRAFICA ALUNNO **********************************************-->
	





</body>
</html>

<script>

	
	$(document).ready(function(){
		$('.datepicker').datetimepicker({
			pickTime: false, 
			format: "DD/MM/YYYY",
            weekStart: 1
		});
		resetResolution();
		requery();
	});
	


	function resetResolution () {
		let offset = $("#tabellaIscrizioni > tbody").offset();
		$('#tabellaIscrizioni > tbody').css('max-height', (($(window).height())-offset.top-30)+'px');
	}
	
	function ordina(x) {
		let az_za_ord = $('#ordinacampo'+x).text();
		if (az_za_ord == 'az') { $('#ordinacampo'+x).text('za'); }
		if (az_za_ord == 'za') { $('#ordinacampo'+x).text('--'); }
		if (az_za_ord == '--') { $('#ordinacampo'+x).text('az'); }
		requery();
	}
	
	function requery(){
		//Valore del filtro
		let ord1 = $('#ordinacampo1').text();
		let ord2 = $('#ordinacampo2').text();
		let ord3 = $('#ordinacampo3').text();
		let ord4 = $('#ordinacampo4').text();
		let ord5 = $('#ordinacampo5').text();
		let ord6 = $('#ordinacampo6').text();

		//Tipo di filtro (az, za o --)
		let fil1 = $('#filter1').val();
		let fil2 = $('#filter2').val();
		let fil3 = $('#filter3').val();
		let fil4 = $('#filter4').val();
		//let fil5 = $('#filter5').val();

		//altre variabili
		let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();
		//let annoscolastico_cla = $( "#annoscolastico" ).val();
		let selectlistaattesa = document.getElementById("selectlistaattesa");
		let listaattesa = selectlistaattesa.options[selectlistaattesa.selectedIndex].value;
		$("#allckbox").prop('checked', false);
		nome_alu = $("#databaseA_hidden").val()+".tab_anagraficaalunni.nome_alu";
		cognome_alu = $("#databaseA_hidden").val()+".tab_anagraficaalunni.cognome_alu";
		postData = { campo1 : nome_alu, campo2: cognome_alu, campo3: "classe_cla", campo4: "sezione_cla", campo5: "iscrizionecompleta_fam", campo6: "pagato_pga", ord1: ord1, ord2: ord2, ord3: ord3, ord4: ord4, ord5: ord5, ord6: ord6, fil1: fil1, fil2: fil2, fil3: fil3, fil4: fil4, listaattesa: listaattesa, annoscolastico_cla: annoscolastico_cla };
		//   console.log ("19Iscrizioni.php - requery - postData a 19qry_Iscrizioni.php");
		//   console.log (postData);
		$.ajax({
			type: 'POST',
			url: "19qry_Iscrizioni.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				//console.log ("19Iscrizioni.php - requery - ritorno da 19qry_Iscrizioni.php");
				//console.log (html);
				$("#maintable").html(html);
				$("#conteggiorecord").html( $("#contarecord_hidden").val());
				//aggiornaEvidenzaAlunniNuovi();
				// console.log ("19Iscrizioni.php - requery - ritorno da 19qry_Iscrizioni.php");
				// console.log ("aggiornato");
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '19Iscrizioni ##fname## requery'");     
			}
		});
	}

	
	//IMPORTANTE: SEMBRA CHE VENGA PRIMA ESEGUITA N VOLTE LA PARTE FINO ALLA CHIAMATA DI 01qry_Promuovi.php e SOLO DOPO VENGANO LANCIATE LE PROMOZIONI VERE E PROPRIE!!!!!!!!
	//E' IMPORTANTE DA SAPERE PERCHE' L'ORDINE IN CUI VENGONO FATTE LE COSE E' BIZZARRO!!!

	function ckboxtutti (){
		for (i = 1; i < (($("#contarecord_hidden").val())+1); i++) {
			$('#'+i+"ck").prop("checked", $("#allckbox").prop('checked'));
		}
	}
	
	function DownloadExcel() {
		let downloadType = $( "#selectDownloadExcel option:selected" ).val();
		window[downloadType]();
	}

	function DownloadExcelPreIscritti() {
		let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();
		//let annoscolastico_cla = $( "#annoscolastico" ).val();
		window.location.href='19downloadExcel.php?annoscolastico_cla='+annoscolastico_cla;
	}
	
	function DownloadExcelCompilati (){

		let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();
		//let annoscolastico_cla = $( "#annoscolastico" ).val();
		window.location.href='19downloadExcelCompilati.php?annoscolastico_cla='+annoscolastico_cla;
	}
	
	//function aggiornaEvidenzaAlunniNuovi() {
	//	let checkBox = document.getElementById("evidenzaAlunniNuovi");
	//	if (checkBox.checked == true){
	//		$(".alunnoritirato").css("background-color", "red").css("color", "white");
	//		$(".alunnonuovo").css("background-color", "#10a03c").css("color", "white");
	//	} else {
	//		$(".alunnoritirato").css("background-color", "").css("color", "");
	//		$(".alunnonuovo").css("background-color", "").css("color", "");
	//	}
	//}
	
	function ImportaSelezionati() {





		let postData = $("#form_Importazione").serializeArray();
		let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();
		//let annoscolastico_cla = $( "#annoscolastico" ).val();
		//Devo ancora calcolare la quota di default usando la 04qry_getFratellieQuote, tuttavia in quel contesto la calcolo per un certo ID_alu
		//in questo caso invece devo calcolarla per "i figli di una famiglia"...IMPOSSIBILE adattare la stessa routine!

		
		postData.push( {name: "annoscolasticoprox", value: annoscolastico_cla});
		console.log ("19Iscrizioni.php - ImportaSelezionati - postData a 19qry_Importa.php")
		console.log (postData);

		$.ajax({
			type: 'POST',
			url: "19qry_Importa.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				// console.log ("19Iscrizioni.php - ImportaSelezionati - ritorno da 19qry_Importa.php")
				//console.log(data.sql3);
				// console.log(data.importato);
				//   console.log(data.test);
				//   console.log(data.test2);
				//   console.log (data.test3);
				$("#remove-contentImportazione").slideUp();
				$("#alertaggiungiImportazione").removeClass('alert-danger');
				$("#alertaggiungiImportazione").addClass('alert-success');
				$("#alertmsgImportazione").html("Importazione avvenuta! I dati selezionati per questa famiglia, sono ora in SWAPP!");
				$("#alertaggiungiImportazione").show();
				$("#btn_cancel1Importazione").removeClass('pull-left');
				$("#btn_cancel1Importazione").html('Chiudi');
				$("#btn_OK1Importazione").hide();
				requery();
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '19Iscrizioni ##fname##' ImportaSelezionati");     
			}
		});
	}
	
	function showModalAddIscrizioneAlVolo(){
		$("#remove-content").show();
		$("#alertaggiungi").hide();
		$("#btn_cancel1").html('Annulla');
		$("#btn_cancel1").addClass('pull-left');
		$("#btn_OK1").show();
		$('#ModalAddIscrizioneAlVolo').modal('show');	
	}



	// function controllaDataNascita (data, annomin, annomax) {
	// 	if ((data != "") && (data != null)) {
	// 		let datam = moment(data, "DD-MM-YYYY" );
	// 		let annom = moment(datam).year();
	// 		//console.log (data);
	// 		if ((datam.isValid()) && (annom > annomin) && (annom < annomax) ) { return true; } else { return false;}
	// 	} else {
	// 		return true;
	// 	}
	// }
	
	function aggiornaCognomeModal(modalita) {
		
		let selectfamigliaTMP = document.getElementById("selectFamiglia");
		let ID_fam = selectfamigliaTMP.options[selectfamigliaTMP.selectedIndex].value;
		if (ID_fam != 'none') {
			ID_fam = parseInt(ID_fam);
			postData = { ID_fam: ID_fam };
			$.ajax({
				type: 'POST',
				url: "00qry_getDatiFamiglia.php",
				data: postData,
				dataType: 'json',
				success: function(data){
					$("#cognome_alu_new").val(data.cognomepadre_fam);
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '19Iscrizioni ##fname##aggiornaCognomeModal'");     
				}
			});
		} else {
			//se è stata selezionata una NUOVA famiglia allora i campi vanno puliti
			if (modalita != "justbeforeinsert") {
				//solo nel caso in cui io stia azionando questa routine appena prima di procedere, NON DEVO azzerare il campo cognome_alu (perchè magari già compilato manualmente)
				//se invece questa routine viene azionata dal change della select allora, quando si seleziona NUOVA famiglia si deve azzeare il campo cognome_alu
				$("#cognome_alu_new").val("");
			}
		}
	}
	
	
	function addAnagraficaAndIscrizione () {
		let datanascita_alu = $('#datanascita_alu_new').val();
		if (controllaDataNascita(datanascita_alu, 1990, 2050)){
		} else {
			$("#alertaggiungi").removeClass('alert-success');
			$("#alertaggiungi").addClass('alert-danger');
			$("#alertmsg").html('verificare la data inserita');
			$("#alertaggiungi").show();
			return;
		}
		let mf_alu = $('#mf_alu_new').val();
		let nome_alu = $('#nome_alu_new').val();
		let cognome_alu = $('#cognome_alu_new').val();
		let emailpadre_fam = $('#emailpadre_fam_new').val();
		let emailmadre_fam = $('#emailmadre_fam_new').val();
		aggiornaCognomeModal("justbeforeinsert"); //questa routine sostituisce al cognome_alu il cognome della famiglia selezionata (per sicurezza che ci sia coerenza)
		//Se è stata selezionata una NUOVA FAMIGLIA non fa nulla.
		if ((nome_alu =='') || (cognome_alu =='') || (datanascita_alu == "") || (mf_alu == "") || (emailpadre_fam=='' && emailmadre_fam=='')) {
				$("#alertaggiungi").removeClass('alert-success');
				$("#alertaggiungi").addClass('alert-danger');
				$("#alertmsg").html('Tutti i valori sono necessari incluso almeno un indirizzo e-mail');
				$("#alertaggiungi").show();
			} else{
				$("#alertaggiungi").hide();
			let postData = $("#form_AddAlunnoAlVolo").serializeArray();
			// console.log (postData);
			
			$.ajax({
				url : "00qry_checkIfAnagraficaDuplicate.php",
				type: "POST",
				data : postData,
				dataType: "json",
				success:function(data1) {
					if (data1.test != 0) {
						$("#alertaggiungi").removeClass('alert-success');
						$("#alertaggiungi").addClass('alert-danger');
						$("#alertmsg").html(nome_alu+" "+cognome_alu+" già presente in anagrafica. Se omonimo modificare il nome scrivendo ad es. 'Mario Rossi2'.");
						$("#alertaggiungi").show();
					} else {
						$.ajax({
							url : "19qry_insertAnagraficaAlVolo.php",
							type: "POST",
							data : postData,
							dataType: "json",
							success:function(data2) {
								// console.log (data2.ID);
								// console.log (data2.ID_fam);
								//console.log(data2.sql);
								$("#IDAnagraficaAppenaInseritaHidden").val(data2.ID);
								$('#ID_fam_alu_hidden').val(data2.ID_fam);
								//ora devo iscrivere l'alunno alla classe selezionata
								let ListaDAttesa = false;
								let ID_alu_cla = data2.ID;
								let annoscolastico_asc =  $("#modalannoscolastico_cla").val();
								let classe_cla =  $("#selectclasse_modal").val();
								let sezione_cla =  $("#selectsezione_modal").val();
								let bocciato= false;
								postData = { ID_alu_cla: ID_alu_cla, annoscolastico_asc: annoscolastico_asc, classe_cla: classe_cla, sezione_cla: sezione_cla, bocciato: bocciato, ListaDAttesa: ListaDAttesa};
									//console.log (postData);
									$.ajax({
									type: 'POST',
									url: "06qry_insertAnnoScolastico.php",
									data: postData,
									dataType: 'json',
									success: function(data3){
										//console.log (data3.result);
										if (data3.result == 'OK') {
											$("#remove-content").slideUp();
											$("#alertaggiungi").removeClass('alert-danger');
											$("#alertaggiungi").addClass('alert-success');
											$("#alertmsg").html('Inserimento in anagrafica di '+nome_alu+' '+cognome_alu+' completato con successo.<br>'+ data3.msg+'<br> email inviata/e');
											$("#alertaggiungi").show();
											$("#btn_cancel1").html('Chiudi');
											$("#btn_cancel1").removeClass('pull-left');
											$("#btn_OK1").hide();
											
											inviamail();
											//requery();
										} else {
											$("#alertmsg").html('OOps! Qualcosa non ha funzionato<br>'+ data3.msg);
										}
									}
								});
							},
							error: function(){
								alert("Errore: contattare l'amministratore fornendo il codice di errore '19Iscrizioni ##fname##addAnagraficaAndIscrizione'");     
							}
						});
					}
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '19Iscrizioni ##fname##addAnagraficaAndIscrizione'");     
				}
			});
			
			
			
		}
	}
	
	function modalShowStatus(msg){
		//$("#statusIscrizioni").html(msg);
		$('#titolo01Msg_OK').html('STATUS ISCRIZIONI');
		$('#msg01Msg_OK').html(msg);
		$('#modal01Msg_OK').modal('show');
		//$('#modalShowStatus').modal('show');	
	}


	function showModalDeleteThisRecord(ID_fam_alu, nome_alu, cognome_alu) {
			$('#msg03Msg_OKCancelPsw').html("Sei sicuro di voler eliminare l'alunno/a "+nome_alu+" "+cognome_alu+" <br>e la sua famiglia dal database delle Iscrizioni?<br><br>Verranno eliminati la username della famiglia, <br>e tutti i dati già eventualmente inseriti in fase di iscrizione<br>Inoltre verranno eliminati anche eventuali fratelli.<br><br>L'eliminazione riguarda SOLO i dati inseriti nel database iscrizioni e non i dati di SWAPP.<br><br> Per procedere digitare la password e confermare");
			$("#btn_OK03Msg_OKCancelPsw").attr("onclick","deleteThisRecord("+ID_fam_alu+");");
			$("#btn_OK03Msg_OKCancelPsw").show();
			$("#titolo03Msg_OKCancelPsw").html('ELIMINA ISCRIZIONE ALUNNO e FAMIGLIA');
			$("#btn_cancel03Msg_OKCancelPsw").html('Annulla');
			$("#remove-content03Msg_OKCancelPsw").show();
			$("#alertCont03Msg_OKCancelPsw").removeClass('alert-success');
			$("#alertCont03Msg_OKCancelPsw").addClass('alert-danger');
			$("#alertCont03Msg_OKCancelPsw").hide();
			$("#passwordDelete").val("");
			$('#modal03Msg_OKCancelPsw').modal('show');
	}

	function deleteThisRecord(ID_fam_alu){
		
		let psw = $("#passwordDelete").val();
		let pswOperazioni1 = $("#pswOperazioni1").val();
		if (psw == null || psw == "" || psw !=pswOperazioni1 ) {
			$("#alertMsg03Msg_OKCancelPsw").html('Password Errata!');
			$("#alertCont03Msg_OKCancelPsw").show();
		}	else  {	
			 postData = { ID_fam_alu : ID_fam_alu};
			 console.log (postData);
			$.ajax({
				type: 'POST',
				url: "19qry_deleteFromDBB_fam.php",
				data: postData,
				dataType: 'json',
				success: function(data){
					$("#remove-content03Msg_OKCancelPsw").slideUp();
					$("#alertMsg03Msg_OKCancelPsw").html('Alunno e famiglia eliminati!');
					$("#alertCont03Msg_OKCancelPsw").removeClass('alert-danger');
					$("#alertCont03Msg_OKCancelPsw").addClass('alert-success');
					$("#alertCont03Msg_OKCancelPsw").show();
					$("#btn_cancel03Msg_OKCancelPsw").html('Chiudi');
					$("#btn_OK03Msg_OKCancelPsw").hide();

					requery();
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '19Iscrizioni ##fname##deleteThisRecord'");     
				}
			});
		}
	}
	

	function showModalChgPsw(ID_usr, login_usr) {
		$('#modalChgPsw-testo').html(login_usr);
		$('#psw_new').val('');
		$('#usr_new_hidden').val(ID_usr);
		$('#alertChgPsw').removeClass('alert-danger');
		$('#alertChgPsw').addClass('alert-success');
		$("#alertChgPsw").hide();
		$("#btn_CancelChgPsw").html('Annulla');
		$("#btn_OKChgPswr").show();
		$("#remove-contentChgPsw").show();
		$('#modalChgPsw').modal({show: 'true'});
	}

	function setNewPsw () {
		let ID_usr = $('#usr_new_hidden').val();
		let password = $('#psw_new').val();
		validazione = checkPassword(password);
		if  (validazione[1] == "NO") {
			$("#alertChgPsw").removeClass('alert-success');
			$("#alertChgPsw").addClass('alert-danger');
			$("#alertmsgChgPsw").html(validazione[2]);
			$("#alertChgPsw").show();
		} else {
			postData = { ID_usr: ID_usr, psw: password};
			console.log ("19qry_UseOverview.php - setNewPsw - postData a 19qry_updatePasswordusr.php");
			console.log (postData);
			$.ajax({
				type: 'POST',
				url: "19qry_updatePasswordusr.php",
				data: postData,
				dataType: 'json',
				success: function(){
					$("#alertChgPsw").removeClass('alert-danger');
					$("#alertChgPsw").addClass('alert-success');
					$("#alertmsgChgPsw").html('Cambio password completato con successo!');
					$("#alertChgPsw").show();
					$("#btn_CancelChgPsw").html('Chiudi');
					$("#btn_OKChgPsw").hide();
					$("#remove-contentChgPsw").slideUp();
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '19Iscrizioni-setNewPsw");     
				}
			});
		}
	}

	function checkPassword (password){
		
		let returnA = new Array(2);
		let specialCharacters = /[_*'\^$.|?*+()#\[\]\s]/g;
		
		// Validate lowercase letters
		let lowerCaseLetters = /[a-z]/g;
		if(password.match(lowerCaseLetters)) {  
			letterelow = 1;
		} else {
			letterelow = 0;
		}
		//tolgo questo vincolo: le password possono non contenere lettere minuscole
		letterelow = 1;

		// Validate capital letters
		let upperCaseLetters = /[A-Z]/g;
		if(password.match(upperCaseLetters)) {  
			lettereUPP = 1;
		} else {
			lettereUPP= 0;
		}
		//tolgo questo vincolo: le password possono non contenere lettere Maiuscole
		lettereUPP = 1;

		// Validate numbers
		let numbers = /[0-9]/g;
		if(password.match(numbers)) {  
			numeri = 1;
		} else {
			numeri = 0;
		}
		//tolgo questo vincolo: le password possono non contenere numeri
		numeri = 1;

		// Validate length - lunghezza minima 7 caratteri
		if(password.length > 6) {
			lunghezza = 1;
		} else {
			lunghezza = 0;
		}

  		// Validate special Characters - non voglio che siano contenuti caratteri speciali
		//in verità già l'ho verificato più sopra
		if(!(password.match(specialCharacters))) {
			speciali = 1;
		} else {
			speciali = 0;
		}

		if ((letterelow*lettereUPP*numeri*lunghezza*speciali) != 0) {
			returnA[1]="OK";
		} else {
			if (letterelow == 0){
				addmsg ="Mancano lettere minuscole";
			}
			if (lettereUPP ==0) {
				addmsg ="Mancano lettere MAIUSCOLE";
			}
			if (numeri ==0) {
				addmsg ="Mancano numeri";
			}
			if (lunghezza ==0) {
				addmsg ="Password troppo breve";
			}
			if (speciali ==0) {
				addmsg ="Contiene Caratteri Speciali o spazi";
			}
			returnA[1]="NO";
			returnA[2]= addmsg + "<br>La password deve essere di almeno 7 caratteri e non può contenere nè caratteri speciali nè spazi";
		}
		return (returnA);
	}

</script>
		