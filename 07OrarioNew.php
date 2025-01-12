<?
	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("assets/functions/ifloggedin.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Orario Settimanale</title>
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
	<? $_SESSION['page'] = "OrarioNew";?>
	<? $asiliorario = $_SESSION['asiliorario']?>
</head>

<body>
	<? include("NavBar.php"); ?>
	<div id="main">
		<? include_once("assets/functions/lowreswarning.html"); ?>
		<div class="upper highres">
			<div class="frameTopLeft">
				<div class="row">
					<img style="width: 20px;" src="assets/img/Icone/user-check-solid-red.svg">
					<span style="font-size: 12px;"> da firmare</span>
				</div>
				<div class="row">
					<img style="width: 20px;" src="assets/img/Icone/user-check-solid-yellow.svg">
					<span><span style="font-size: 12px;"> firmata senza Argomento</span>
				</div>
				<div class="row">
					<img style="width: 20px;" src="assets/img/Icone/user-check-solid-green.svg">
					<span><span style="font-size: 12px;"> firmata</span>
				</div>
			</div>
			<div class="titoloPagina" style="margin-bottom: 20px;">
				Orario Settimanale per classe
			</div>
			<div class="ml50">
				<input id="ore_orario_hidden" value = "<?=$_SESSION['ore_orario']?>" hidden>
				<input id="pswOperazioni2" value="<?=$_SESSION['pswOperazioni2']?>" hidden>
			</div>


			<div class="frameXlDownload">
				<div class="row center">
					download excel
				</div>
				<div>
					<select class="selectXl" id="selectDownloadExcel">
						<? if ($_SESSION['role_usr'] != 2)  { ?>
							<option value="DownloadExcelOrarioMese">Mese con Firme</option>
						<?}?>
						<option value="DownloadExcelOrarioSettimana">Orario della Settimana</option>
					</select>
					<img onclick="DownloadExcel()" class="miniButtonXl" src='assets/img/Icone/logoexcel2019.svg'>
				</div>
			</div>

			<div class="col-md-12 center">
				<table id="tabellaOrario" class="center">
					<thead>
						<tr>
							<td>
							</td>
							<td>
							</td>
							<td>
								classe
								<select name="selectclasse"  style="margin-left: 0px"  id="selectclasse" onchange="requery();">
									<?
									$sql = "SELECT ID_cls, classe_cls, desc_cls, aselme_cls FROM tab_classi ORDER BY ord_cls ";
									$stmt = mysqli_prepare($mysqli, $sql);
									mysqli_stmt_execute($stmt);
									mysqli_stmt_bind_result($stmt, $ID_cls, $classe_cls, $desc_cls, $aselme_cls);
									while (mysqli_stmt_fetch($stmt)) {
										if (($aselme_cls != "AS" && $aselme_cls != "NI") || $asiliorario == 1) { //***************  INIBIRE QUI PER INSERIRE ANCHE LA MATERNA?>
											<option value="<?=$classe_cls?>"><?=$desc_cls?></option><?
										}
									}?>
								</select>
							</td>
							<td>
								sezione
								<select name="selectsezione"  style="margin-left: 0px"  id="selectsezione" onchange="requery();">
									<? $sql = "SELECT DISTINCT sezione_cla FROM tab_classialunni ORDER BY sezione_cla ";
									$stmt = mysqli_prepare($mysqli, $sql);
									mysqli_stmt_execute($stmt);
									mysqli_stmt_bind_result($stmt, $sezione_cla);
									while (mysqli_stmt_fetch($stmt)) {
									?>
									<option value="<?=$sezione_cla?>"><?=$sezione_cla?></option><?
									}?>
								</select>
							</td>
							<td>
							</td>
							<td>
								<img title="Settimana Precedente" style="width: 10px; cursor: pointer; margin-top: -5px;" src='assets/img/Icone/caret-left-solid.svg' onclick="moveOneWeek(-1);">
								<input class="tablecell3" type='text' id='weeklyDatePicker' placeholder="Seleziona la settimana" style="width: 70%; text-align: center;" readonly>
								<img title="Settimana Successiva" style="width: 10px; cursor: pointer; margin-top: -5px;" src='assets/img/Icone/caret-right-solid.svg' onclick="moveOneWeek(1);">
							</td>
						</tr>
						<tr>
							<td colspan="7" style="height: 10px"></td>
						</tr>
						<tr>
							<th style="text-align: center;" >
								<button class="btnBlu" style="width: 98%; <? if($_SESSION['role_usr'] == 2) {echo ("display:none; ");}?>" onclick="showModalManut();">Modifica sett.</button>
								<br>
							</th>
							<th>
								<input class="tablecell5 center" id="data1Show" type="text" value = "" disabled>
								<input class="tablecell5 center" id="data1" type="text" value = "" hidden>
							</th>
							<th>
								<input class="tablecell5 center" id="data2Show" type="text" value = "" disabled>
								<input class="tablecell5 center" id="data2" type="text" value = "" hidden>
							</th>
							<th>
								<input class="tablecell5 center" id="data3Show" type="text" value = "" disabled>
								<input class="tablecell5 center" id="data3" type="text" value = "" hidden>
							</th>
							<th>
								<input class="tablecell5 center" id="data4Show" type="text" value = "" disabled>
								<input class="tablecell5 center" id="data4" type="text" value = "" hidden>
							</th>
							<th>
								<input class="tablecell5 center" id="data5Show" type="text" value = "" disabled>
								<input class="tablecell5 center" id="data5" type="text" value = "" hidden>
							</th>
						</tr>
						<tr>
							<th>

							</th>
							<th>
								<input class="tablelabel3" style="z-index: 1" type="text" value = "LUNEDI" disabled>
								<img title="Cancella lezioni del giorno" class="btnCancellaGiornoOrario" 
								style="<? if($_SESSION['role_usr'] == 2) {echo ("display:none; ");}?>" 
								src="assets/img/Icone/eraser-solid.svg" onclick="showModalCancellaGiorno(1);">
							</th>
							<th>
								<input class="tablelabel3" type="text" value = "MARTEDI" disabled>
								<img title="Cancella lezioni del giorno" class="btnCancellaGiornoOrario" 
								style="<? if($_SESSION['role_usr'] == 2) {echo ("display:none; ");}?>" 
								src="assets/img/Icone/eraser-solid.svg" onclick="showModalCancellaGiorno(2);">
							</th>
							<th>
								<input class="tablelabel3" type="text" value = "MERCOLEDI" disabled>
								<img title="Cancella lezioni del giorno" class="btnCancellaGiornoOrario"
								style="<? if($_SESSION['role_usr'] == 2) {echo ("display:none; ");}?>" 
								src="assets/img/Icone/eraser-solid.svg" onclick="showModalCancellaGiorno(3);">
							</th>
							<th>
								<input class="tablelabel3" type="text" value = "GIOVEDI" disabled>
								<img title="Cancella lezioni del giorno" class="btnCancellaGiornoOrario"
								style="<? if($_SESSION['role_usr'] == 2) {echo ("display:none; ");}?>" 
								src="assets/img/Icone/eraser-solid.svg" onclick="showModalCancellaGiorno(4);">
							</th>
							<th>
								<input class="tablelabel3" type="text" value = "VENERDI" disabled>
								<img title="Cancella lezioni del giorno" class="btnCancellaGiornoOrario"
								style="<? if($_SESSION['role_usr'] == 2) {echo ("display:none; ");}?>" 
								src="assets/img/Icone/eraser-solid.svg" onclick="showModalCancellaGiorno(5);">
							</th>
						</tr>
					</thead>
					<tbody id="maintable">
					</tbody>
				</table>
			</div>
			<!-- <div class="row" style="font-size:16px; margin-top:50px; text-align: center;">
				<div class="col-sm-12">
					<button class="btnBlu" style=" width: 30%; margin-top: 10px; <?// if($_SESSION['role_usr'] == 2) {echo ("display:none; ");} ?>" onclick="salvaOrario();">Salva Orario Settimanale</button>
				</div>
			</div> -->
			<div class="row" style="font-size:16px; text-align: center;">
				<div class="col-sm-12">
					<button class="btnBlu" style=" width: 30%; margin-top: 10px; <? if($_SESSION['role_usr'] == 2) {echo ("display:none; ");} ?>" onclick="showModalSetupAnno();">Impostazioni Anno e Quadrimestri</button>
				</div>
			</div>
		</div>
	</div>
	
	
	
	<!--*******************************************MODAL FORM IMPOSTAZIONI ANNO E QUADRIMESTRI-->
	<div class="modal" id="modalSetupAnno" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
		<div class="modal-dialog" style="font-size:14px; width: 50%">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_SetupAnno" method="post">
						<span class="titoloModal">Impostazioni Anno e Quadrimestri</span>
						<div class="alert alert-success" id="alertaggiungi" style="display:none; margin-top:10px; padding: 10px;">
							<h5 id="alertmsg" style="text-align:center;"> 
							  Modifica Anno completata con successo!
							</h5>
						</div>
						<div id="remove-content" style="text-align: center; margin-top: 10px; "> <!-- START REMOVE CONTENT -->
							<div class="row" style="margin-bottom:20px;">
								<div class="col-md-4">
								</div>
								<div class="col-md-4">
									anno scolastico di DEFAULT
									<br>
									non modificare se non sicuri
									<select name="selectannoscolastico"  style="margin-left: 0px"  id="selectannoscolastico" onchange="updateYearDates();">
									<? $sql = "SELECT annoscolastico_asc FROM tab_anniscolastici ORDER BY ID_asc ";
									$stmt = mysqli_prepare($mysqli, $sql);
									mysqli_stmt_execute($stmt);
									mysqli_stmt_bind_result($stmt, $annoscolastico_asc);
									while (mysqli_stmt_fetch($stmt)) {
										?>
										<option value="<?=$annoscolastico_asc?>"
										<? if ($annoscolastico_asc == $_SESSION['anno_corrente']) { echo 'selected';}?>><?=$annoscolastico_asc?></option><?
									}?>
									</select>
								</div>
							</div>
							

							
							<?$sql = "SELECT datainizio_asc, datafinequadrimestre1_asc, datafine_asc FROM tab_anniscolastici WHERE annoscolastico_asc = ? ";
							$stmt = mysqli_prepare($mysqli, $sql);
							mysqli_stmt_bind_param($stmt, "s", $_SESSION['anno_corrente']);
							mysqli_stmt_execute($stmt);
							mysqli_stmt_bind_result($stmt, $datainizio_asc, $datafinequadrimestre1_asc, $datafine_asc);
							while (mysqli_stmt_fetch($stmt)) {
							}?>
							<div class="row" style="margin-bottom:20px;">
								<div class="col-md-4">
								</div>
								<div class="col-md-4">
									Data Inizio Primo Quadrimestre
									<br>
									<input class="datepicker tablecell2 dpd" type="text" id="datainizio_asc" name="datainizio_asc" value="<?=timestamp_to_ggmmaaaa($datainizio_asc)?>" style="text-align: center;" required onkeydown="return false;">
								</div>
							</div>
							<div class="row" style="margin-bottom:20px;">
								<div class="col-md-4">
								</div>
								<div class="col-md-4">
									Data Fine Primo Quadrimestre
									<br>
									(ultimo giorno del primo Q)
									<input class="datepicker tablecell2 dpd" type="text" id="datafinequadrimestre1_asc" name="datafinequadrimestre1_asc" value="<?=timestamp_to_ggmmaaaa($datafinequadrimestre1_asc)?>" style="text-align: center;" required onkeydown="return false;">
								</div>
							</div>
							<div class="row" style="margin-bottom:20px;">
								<div class="col-md-4">
								</div>
								<div class="col-md-4">
									Data Fine Secondo Quadrimestre
									<br>
									<input class="datepicker tablecell2 dpd" type="text" id="datafine_asc" name="datafine_asc" value="<?=timestamp_to_ggmmaaaa($datafine_asc)?>" style="text-align: center;" required onkeydown="return false;">
								</div>
							</div>

						</div> <!-- END REMOVE CONTENT -->
						<div class="modal-footer">
							<button type="button" id="btn_cancel1" class="btnBlu pull-left" style="width:40%;" data-dismiss="modal">Annulla</button>
							<button type="button" id="btn_OK1" class="btnBlu pull-right" style="width:40%;" onclick="salvaSetup();">Salva Impostazioni</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!--*******************************************FINE MODAL FORM IMPOSTAZIONI ANNO E QUADRIMESTRI-->
	<!--*******************************************MODAL CHECK IF PLURICLASSE**********************-->
	<div class="modal" id="modalCheckIfPluriclasse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<span class="titoloModal">ATTENZIONE</span>
					<div id="msgPluriclasse" style="text-align: center; margin-top: 10px; "> <!-- START REMOVE CONTENT -->
						<br>
						
					</div> <!-- END REMOVE CONTENT -->

					<div class="modal-footer">
						<button type="button" id="btn_cancelPluriclasse" class="btnBlu" style="width:40%;" data-dismiss="modal" onclick="Restorenomat();">Annulla</button>
						<button type="button" id="btn_OKPluriclasse" class="btnBlu" style="width:40%;" data-dismiss="modal" onclick="">Procedi</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--*******************************************FINE MODAL CHECK IF PLURICLASSE****************-->	
	<!--*******************************************MODAL GESTIONE MATERIE, TUTOR ECC**************-->
		<div class="modal" id="modalTutor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" style="font-size:14px;">
				<div class="modal-content">
				<div class="modal-body white">           
					<span class="titoloModal" style="width:100%; ">INSERIMENTO MATERIA, TUTORAGGIO, COPRESENZA</span>
					<div id="remove-contentModalTutor" style="text-align: center; margin-top: 10px; ">
						
						<?$sql7 = "SELECT codmat_mtt, descmateria_mtt FROM tab_materie ORDER BY ord_mtt";
						$stmt7 = mysqli_prepare($mysqli, $sql7);
						mysqli_stmt_execute($stmt7);
						mysqli_stmt_bind_result($stmt7, $codmat_mtt2, $descmateria_mtt2);
						$nummaterie2 = 1;
						//$numore2 = $ore_orario;
						while (mysqli_stmt_fetch($stmt7)) {
							$codmat_mttA2[$nummaterie2] = $codmat_mtt2;
							$descmateria_mttA2[$nummaterie2] =$descmateria_mtt2;
							$nummaterie2++;
						}?>
						<div class="row">
							<div class="col-md-2">
							</div>
							<div class="col-md-4" style="text-align: center;">
								classe
							</div>
							<div class="col-md-4" style="text-align: center;">
								sezione
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
							</div>
							<div class="col-md-4" style="text-align: center;">
								<input class="tablecell5" style="text-align: center;" type="text"  id="classe2_new" disabled>
							</div>
							<div class="col-md-4" style="text-align: center;">
								<input class="tablecell5" style="text-align: center;" type="text"  id="sezione2_new" disabled>
							</div>
						</div>

						<div class="row">
							<div class="col-md-2">	
							</div>
							<div class="col-md-4" style="text-align: center;">
								data
							</div>
							<div class="col-md-4" style="text-align: center;">
								ora
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">	
							</div>
							<div class="col-md-4" style="text-align: center;">
								<input class="tablecell5" style="text-align: center;" type="text"  id="data2_new" disabled>
							</div>
							<div class="col-md-4" style="text-align: center;">
								<input class="tablecell5" style="text-align: center;" type="text"  id="ora2_new" disabled>
							</div>
						</div>

						<div id="MaterieEMaestriContainer">
						</div>
									

					</div>
					<div class="alert alert-success" id="alertModalTutor" style="display:none; margin-top:10px;">
						<h4 id="alertmsgModalTutor" style="text-align:center;"> 
							Modifica altri maestri<br>completata con successo
						</h4>
					</div>
					<div class="modal-footer">

						<? if($_SESSION['role_usr'] == 2) {
							//A COSA SERVE??? TODO?>
							<button type="button" id="btn_CancelModalTutorrole2" class="btnBlu pull-left" style="width:40%; margin-left: 30%;" data-dismiss="modal">Chiudi</button>
						<?} else {?>
							<button type="button" id="btn_CancelModalTutor" class="btnBlu" style="width:40%;" data-dismiss="modal" onclick="requery();">Chiudi</button>
						<?}?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--*******************************************FINE MODAL GESTIONE MATERIE**************-->
	<!--*************************************** FORM MODALE MANUTENZIONE *******************-->
	<div class="modal" id="modalManut" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<span class="titoloModal">MODIFICA ORARIO PER SETTIMANE</span>
					
					<div id="remove-contentmodalManut" style="text-align: center;"> <!-- START REMOVE CONTENT -->
						<div class="row mt20">
							<div class="col-md-2">
							</div>
							<div class="col-md-8" style="text-align: center;">
								<button class="btnBlu" style="width:100%;" onclick="propagaEpoca();">Propaga Materie di Epoca del lunedì agli altri giorni</button>
							</div>
						</div>
						<div class="row mt20">
							<div class="col-md-2">
							</div>
							<div class="col-md-8" style="text-align: center;">
								<button title="Cancella anche le firme, gli argomenti, i compiti assegnati" class="btnBlu" style="width:100%;" onclick="cancellaSett();">Cancella orario della settimana corrente:</button>
							</div>
						</div>						
						<div class="row">
							<div class="col-md-4">
							</div>
							<div class="col-md-4" style="text-align: center;">
								Settimana corrente
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
							</div>
							<div class="col-md-4" style="text-align: center;">
								<input class="tablecell3" type='text' id='data1Copia' value ="" style="width: 100%; text-align: center;" readonly>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12" style="text-align: center;">
								<span class="smalltext">(la cancellazione -irreversibile- include Firme, argomenti trattati, compiti assegnati)</span>
							</div>
						</div>
						<hr class="mt10 mb10">
						<div class="row">
							<div class="col-md-2">
							</div>
							<div class="col-md-8" style="text-align: center;">
								<button class="btnBlu" style="width:100%;" onclick="copiaOrarioDaSett();">Copia alla settimana corrente orario della settimana:</button>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">

							</div>
							<div class="col-md-4" style="text-align: center; margin-top: 10px;">
								<input class="tablecell3" type='text' id='weeklyDatePickerCopiaDa' placeholder="Seleziona la settimana" style="width: 100%; text-align: center;" readonly>
							</div>
						</div>


						<div class="row">
							<div class="col-md-4">

							</div>
							<div class="col-md-4" style="text-align: center; margin-top: 10px;">
								<select name="selectclasse"  style="margin-left: 0px"  id="selectclasseCopiaDaA">
									<option value="0">Tutte le Classi</option>
									<? $sql = "SELECT ID_cls, classe_cls, desc_cls, aselme_cls FROM tab_classi ORDER BY ord_cls ";
									$stmt = mysqli_prepare($mysqli, $sql);
									mysqli_stmt_execute($stmt);
									mysqli_stmt_bind_result($stmt, $ID_cls, $classe_cls, $desc_cls, $aselme_cls);
									while (mysqli_stmt_fetch($stmt)) {
										if ($aselme_cls != "AS" && $aselme_cls != "NI") {?>
											<option value="<?=$classe_cls?>"><?=$desc_cls?></option><?
										}
									}?>
								</select>
								
								<select name="selectsezione"  style="margin-left: 0px"  id="selectsezioneCopiaDaA">
									<option value="0" selected>-</option>
									<option value="A" >A</option>
									<option value="B" >B</option>
									<option value="C" >C</option>
								</select>
							</div>

						</div>
						<div class="row">
							<div class="col-md-12" style="text-align: center;">
								<span class="smalltext">(la copiatura -irreversibile- sovrascrive l'orario della settimana corrente)</span>
							</div>
						</div>

						<hr class="mt10 mb10">
						<div class="row">
							<div class="col-md-2">
							</div>
							<div class="col-md-8" style="text-align: center;">
								<button class="btnBlu" style="width:100%;" onclick="copiaOrarioFinoASett();">Copia orario della settimana corrente fino alla settimana:</button>

							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
							</div>
							<div class="col-md-4" style="text-align: center; margin-top: 10px;">
								<input class="tablecell3" type='text' id='weeklyDatePickerCopiaFinoA' placeholder="Seleziona la settimana" style="width: 100%; text-align: center;" readonly>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4">

							</div>
							<div class="col-md-4" style="text-align: center; margin-top: 10px;">
								<select name="selectclasse"  style="margin-left: 0px"  id="selectclasseCopiaFinoA">
									<option value="0">Tutte le Classi</option>
									<? $sql = "SELECT ID_cls, classe_cls, desc_cls, aselme_cls FROM tab_classi ORDER BY ord_cls ";
									$stmt = mysqli_prepare($mysqli, $sql);
									mysqli_stmt_execute($stmt);
									mysqli_stmt_bind_result($stmt, $ID_cls, $classe_cls, $desc_cls, $aselme_cls);
									while (mysqli_stmt_fetch($stmt)) {
										if ($aselme_cls != "AS" && $aselme_cls != "NI") {?>
											<option value="<?=$classe_cls?>"><?=$desc_cls?></option><?
										}
									}?>
								</select>
								<select name="selectsezione"  style="margin-left: 0px"  id="selectsezioneCopiaFinoA">
									<option value="0" selected>-</option>
									<option value="A" >A</option>
									<option value="B" >B</option>
									<option value="C" >C</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12" style="text-align: center;">
								<span class="smalltext">(la copiatura -irreversibile- sovrascrive l'orario delle settimane di destinazione)</span>
							</div>
						</div>
						<hr class="mt10 mb10">
						<div id="passwordContainer" style="margin-top: 15px;">
							Queste operazioni sono riservate al Coordinatore Didattico.<br>
							Per qualsiasi di queste inserire qui di seguito la password:<br>
							<input type="password" class="mt10" id="passwordEdit">
						</div>
						<div class="alert alert-success" id="messageModalManutContainer" style="display:none; margin-top:10px; margin-bottom: 0px;">
							<h4 id="messageModalManut" style="text-align:center;"> 
							  Iscrizione completata con successo!
							</h4>
						</div>
						<br>
					</div> <!-- END REMOVE CONTENT -->
					<div class="modal-footer mt5" >
						<button type="button" id="btn_CancelModalManut" class="btnBlu" style="width:40%;" data-dismiss="modal" onclick="">Chiudi</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--*************************************** FINE FORM MODALE MANUTENZIONE *******************-->


</body>
</html>
<script>

	$(document).ready(function(){
		moment.locale('en', {
		  week: { dow: 1 } // Monday is the first day of the week
		});
		
		$('.dpd').datetimepicker({
			pickTime: false, 
			format: "DD/MM/YYYY",
			weekStart: 1
			//format: "DD/MM"
		});
				
		$("#weeklyDatePicker").datetimepicker({
			pickTime: false, 
			format: 'YYYY-MM-DD'
		});

		$("#weeklyDatePickerCopiaDa").datetimepicker({
			pickTime: false, 
			format: 'YYYY-MM-DD'
		});

		$("#weeklyDatePickerCopiaFinoA").datetimepicker({
			pickTime: false, 
			format: 'YYYY-MM-DD'
		});

		let todayDate = new Date().toISOString().slice(0,10);
		let today = new Date();
		let thisWeekDate = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 7).toISOString().slice(0,10);
		let lastWeekDate = new Date(today.getFullYear(), today.getMonth(), today.getDate() - 7).toISOString().slice(0,10);

		$("#weeklyDatePicker").val(todayDate);
		$("#weeklyDatePickerCopiaDa").val(lastWeekDate);
		$("#weeklyDatePickerCopiaFinoA").val(thisWeekDate);
	   //Imposta le date di inizio e fine settimana
		setdates();
		setdatesCopiaDa(); 		//scrivo anche nel form di manutenzione
		setdatesCopiaFinoA();	//scrivo anche nel form di manutenzione
	});
	
	function moveOneWeek (n) {
		firstDate = $("#data1").val();
		let date = new Date(firstDate);
		date.setDate(date.getDate() + 7*n);
		datePublish = date.toISOString().slice(0,10);
		$("#weeklyDatePicker").val(datePublish);
		setdates();
	}
	
	function setdates () {
		let value = $("#weeklyDatePicker").val();
		let firstDate = moment(value, "YYYY-MM-DD").day(1).format("YYYY-MM-DD");
		let firstDateShow = moment(value, "YYYY-MM-DD").day(1).format("DD/MM/YYYY");
		$("#data1").val(firstDate);
		$("#data1Show").val(firstDateShow);
		$("#data1Copia").val(firstDate);	//scrivo la data iniziale anche nel form di manutenzione
		let date = new Date(firstDate);
		for (i = 2; i < 6; i++) {
			date.setDate(date.getDate() + 1);
			datePublish = date.toISOString().slice(0,10);
			datePublishShow = moment(datePublish).format("DD/MM/YYYY");
			$("#data"+i).val(datePublish);
			$("#data"+i+"Show").val(datePublishShow);
		}
		let m = moment(firstDate, 'YYYY-MM-DD');
		let settimana = m.format('W');
		$("#weeklyDatePicker").val("settimana: "+settimana);
		requery();
	}
	
	function setdatesCopiaDa () {
		let valueCopiaDa = $("#weeklyDatePickerCopiaDa").val();
		let firstDateCopiaDa = moment(valueCopiaDa, "YYYY-MM-DD").day(1).format("YYYY-MM-DD");
		//210208 let mCopiaDa = moment(firstDateCopiaDa, 'YYYY-MM-DD');
		$("#weeklyDatePickerCopiaDa").val(firstDateCopiaDa);
	}

	function setdatesCopiaFinoA () {
		let valueCopiaFinoA = $("#weeklyDatePickerCopiaFinoA").val();
		let firstDateCopiaFinoA = moment(valueCopiaFinoA, "YYYY-MM-DD").day(1).format("YYYY-MM-DD");
		//210208 let mCopiaFinoA = moment(firstDateCopiaFinoA, 'YYYY-MM-DD');
		$("#weeklyDatePickerCopiaFinoA").val(firstDateCopiaFinoA);
	}


	$('#weeklyDatePicker').on('dp.change', function () {
		setdates();
	});
	
	$('#weeklyDatePickerCopiaDa').on('dp.change', function () {
		setdatesCopiaDa();
	});

	$('#weeklyDatePickerCopiaFinoA').on('dp.change', function () {
		setdatesCopiaFinoA();
	});

	function requery(){
		let classe_ora = $( "#selectclasse option:selected" ).val();
		let sezione_ora= $( "#selectsezione option:selected" ).val();
		let datalunedi = $( "#data1" ).val();
		postData = { classe_ora : classe_ora, sezione_ora: sezione_ora, datalunedi: datalunedi};
		//console.log ("07OrarioNew.php - requery - postData a 07qry_OrarioNew.php")
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "07qry_OrarioNew.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				//console.log ("07OrarioNew.php - requery - ritorno da 07qry_OrarioNew.php")
				$("#maintable").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '07Orario ##fname##'");      
			}
		});
	}

	
	function copiaOrarioDaSett() {
		classe = $('#selectclasseCopiaDaA').val();
		sezione = $('#selectsezioneCopiaDaA').val();
		let psw = $("#passwordEdit").val();
		let pswOperazioni2 = $("#pswOperazioni2").val();
		if (psw == null || psw == "" || psw !=pswOperazioni2 ) {
			$("#messageModalManutContainer").removeClass('alert-success');
			$("#messageModalManutContainer").addClass('alert-danger');
			$("#messageModalManut").html('Password errata o mancante!');
			$("#messageModalManutContainer").show();
		} else {
			copiaA = $("#data1").val(); //data/settimana dove incollare
			copiaDa = $('#weeklyDatePickerCopiaDa').val(); //data/settimana dalla quale copiare
			classe = $('#selectclasseCopiaDaA').val();
			postData = { copiaA: copiaA, copiaDa: copiaDa, classe: classe, sezione: sezione};
			// console.log("07Orario.php - copiaOrarioDaSett -  postData a 07qry_UpdateCopiaOrarioDaSett.php")
			// console.log (postData);
			$.ajax({
				type: 'POST',
				url: "07qry_UpdateCopiaOrarioDaSett.php",
				data: postData,
				dataType: 'json',
				success: function(data){
					// console.log("07Orario.php - copiaOrarioDaSett -  ritorno da 07qry_UpdateCopiaOrarioDaSett.php");
					// console.log (data.test0);
					// console.log (data.test);
					// console.log (data.test2);
					$("#messageModalManutContainer").removeClass('alert-danger');
					$("#messageModalManutContainer").addClass('alert-success');
					$("#messageModalManut").html('Orario copiato dalla settimana che inizia il '+copiaDa+'<br> alla settimana che inizia il '+copiaA);
					$("#messageModalManutContainer").show();
					requery();
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '07Orario ##fname##'");      
				}
			});
		}	
	}

	function propagaEpoca() {
		let psw = $("#passwordEdit").val();
		let pswOperazioni2 = $("#pswOperazioni2").val();
		if (psw == null || psw == "" || psw !=pswOperazioni2 ) {
			$("#messageModalManutContainer").removeClass('alert-success');
			$("#messageModalManutContainer").addClass('alert-danger');
			$("#messageModalManut").html('Password errata o mancante!');
			$("#messageModalManutContainer").show();
		} else {
			lunediPropaga = $("#data1").val(); //data/settimana da propagare
			classe = $( "#selectclasse option:selected" ).val();
			postData = { lunediPropaga: lunediPropaga, classe: classe};
			//console.log("07Orario.php - propagaEpoca -  postData a 07qry_PropagaEpocaSett.php")
			//console.log (postData);
			$.ajax({
				type: 'POST',
				url: "07qry_PropagaEpocaSett.php",
				data: postData,
				dataType: 'json',
				success: function(data){
					//inserire un log delle cancellazioni
					console.log("07Orario.php - propagaEpoca -  ritorno da 07qry_PropagaEpocaSett.php")
					console.log(data.test);
					console.log(data.test2);
					$("#messageModalManutContainer").removeClass('alert-danger');
					$("#messageModalManutContainer").addClass('alert-success');
					$("#messageModalManut").html('Orario di epoca del lunedì propagato agli altri giorni della settimana');
					$("#messageModalManutContainer").show();
					requery();
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '07Orario propagaEpoca'");      
				}
			});
		}
	}

	function copiaOrarioFinoASett() {
		classe = $('#selectclasseCopiaFinoA').val();
		sezione = $('#selectsezioneCopiaFinoA').val();
		let psw = $("#passwordEdit").val();
		let pswOperazioni2 = $("#pswOperazioni2").val();
		if (psw == null || psw == "" || psw !=pswOperazioni2 ) {
			$("#messageModalManutContainer").removeClass('alert-success');
			$("#messageModalManutContainer").addClass('alert-danger');
			$("#messageModalManut").html('Password errata o mancante!');
			$("#messageModalManutContainer").show();
		} else {
			//devo eseguire un ciclo for per tante settimane quante ne servono
			//prima però verifico che la settimana sia successiva a quella corrente e che sia diversa almeno di una 
			//(copiare su se stessa la settimana corrente oltre a non aver senso cancellerebbe solo dati)

			copiaDa = $("#data1").val(); //data/settimana da copiare
			copiaFinoA = $('#weeklyDatePickerCopiaFinoA').val(); //data/settimana alla quale copiare: dinamica

			if (copiaFinoA > copiaDa) {

				//poichè si tratta di una operazione molto "aggressiva" sul database faccio una verifica non molto efficiente prima di operare
				//metto intanto un massimo di 30 iterazioni (cioè non consento di copiare per più di 30 settimane in avanti)
				let copiaA = moment(copiaDa, "YYYY-MM-DD");
				i = 0
				maxiterazioni = 25;
				while ((i != (maxiterazioni + 1)) && (moment(copiaDa, "YYYY-MM-DD").add(i*7, 'days').format('YYYY-MM-DD') != copiaFinoA ))
				{
					i = i + 1;
					let copiaA = moment(copiaDa, "YYYY-MM-DD").add(i*7, 'days');
					//console.log ("copiaA", moment(copiaA).format('YYYY-MM-DD'));
				} 
				if (i >= maxiterazioni ) {
					$("#messageModalManutContainer").removeClass('alert-success');
					$("#messageModalManutContainer").addClass('alert-danger');
					$("#messageModalManut").html("Si può impostare fino alla copia su un massimo di " + maxiterazioni + " settimane").show();
					$("#messageModalManutContainer").show();
				} else {

					//console.log ("iterazioni=" , i);
					//a questo punto sono sicuro che o le iterazioni sono meno di 25 o ha trovato dopo i iterazioni la data
					for (j = 1; j <= i; j++) {
						let copiaAM = moment(copiaDa, "YYYY-MM-DD").add(j*7, 'days');
						copiaA = copiaAM.format('YYYY-MM-DD');
						postData = { copiaA: copiaA, copiaDa: copiaDa, classe: classe, sezione: sezione};
						//console.log("07Orario.php - copiaOrarioDaSett -  postData a 07qry_UpdateCopiaOrarioDaSett.php")
						//console.log (postData);
						$.ajax({
							type: 'POST',
							url: "07qry_UpdateCopiaOrarioDaSett.php",
							data: postData,
							dataType: 'json',
							success: function(data){
								//console.log("07Orario.php - copiaOrarioFinoASett -  ritorno da 07qry_UpdateCopiaOrarioDaSett.php");
								//console.log (data.test0);
								//console.log (data.test);
								//console.log (data.test2);
								$("#messageModalManutContainer").removeClass('alert-danger');
								$("#messageModalManutContainer").addClass('alert-success');
								$("#messageModalManut").html('Orario copiato dalla settimana che inizia il '+copiaDa+'<br> a tutte le settimane fino a quella che inizia il '+copiaFinoA);
								$("#messageModalManutContainer").show();

							},
							error: function(){
								alert("Errore: contattare l'amministratore fornendo il codice di errore '07Orario ##fname##'");      
							}
						});
					}
				}
			} else {
				$("#messageModalManutContainer").removeClass('alert-success');
				$("#messageModalManutContainer").addClass('alert-danger');
				$("#messageModalManut").html("L'ultima data di destinazione deve essere almeno la settimana successiva di quella da cui si copia");
				$("#messageModalManutContainer").show();
			}
		}
		
	}

	function cancellaSett(){

		let psw = $("#passwordEdit").val();
		let pswOperazioni2 = $("#pswOperazioni2").val();
		if (psw == null || psw == "" || psw !=pswOperazioni2 ) {
			$("#messageModalManutContainer").removeClass('alert-success');
			$("#messageModalManutContainer").addClass('alert-danger');
			$("#messageModalManut").html('Password errata o mancante!');
			$("#messageModalManutContainer").show();
		} else {
			lunediCancella = $("#data1").val(); //data/settimana da cancellare
			postData = { lunediCancella: lunediCancella};
			// console.log("07Orario.php - cancellaSett -  postData a 07qry_DeleteOrarioSett.php")
			// console.log (postData);
			$.ajax({
				type: 'POST',
				url: "07qry_DeleteOrarioSett.php",
				data: postData,
				dataType: 'json',
				success: function(data){
					//inserire un log delle cancellazioni
					$("#messageModalManutContainer").removeClass('alert-danger');
					$("#messageModalManutContainer").addClass('alert-success');
					$("#messageModalManut").html('Orario della settimana che inizia il '+lunediCancella+'<br> cancellato con successo');
					$("#messageModalManutContainer").show();
					requery();
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '07Orario ##fname##'");      
				}
			});
		}
	}

	function showModalManut() {
		$("#passwordEdit").val("");
		$("#messageModalManutContainer").removeClass('alert-danger');
		$("#messageModalManutContainer").addClass('alert-success');
		$("#messageModalManutContainer").hide();
		$("#selectclasseCopiaDaA").val(0);
		$("#selectclasseCopiaFinoA").val(0);
		$('#modalManut').modal('show');
	}

	function showModalCancellaGiorno(n) {
		$('#msg03Msg_OKCancelPsw').html("Sei sicuro di voler eliminare l'orario di questo giorno? <br>Verranno eliminate anche le firme, gli argomenti ed i compiti assegnati.<br><br> Per procedere digitare la password del Coordinatore Didattico e confermare");
		$("#btn_OK03Msg_OKCancelPsw").attr("onclick","cancellaGiorno("+n+");");
		$("#btn_OK03Msg_OKCancelPsw").show();
		$("#titolo03Msg_OKCancelPsw").html('CANCELLAZIONE ORARIO DEL GIORNO');
		$("#btn_cancel03Msg_OKCancelPsw").html('Annulla');
		$("#remove-content03Msg_OKCancelPsw").show();
		$("#alertCont03Msg_OKCancelPsw").removeClass('alert-success');
		$("#alertCont03Msg_OKCancelPsw").addClass('alert-danger');
		$("#alertCont03Msg_OKCancelPsw").hide();
		$("#passwordDelete").val("");
		$('#modal03Msg_OKCancelPsw').modal('show');
	}

	function cancellaGiorno(n) {
		// let numore = $('#ore_orario_hidden').val();
		// for (i = 1; i <= numore; i++) {
		// 	$("#GH"+day+i).val("nomat");
		// }
		let psw = $("#passwordDelete").val();
		let pswOperazioni2 = $("#pswOperazioni2").val();
		if (psw == null || psw == "" || psw !=pswOperazioni2 ) {
			$("#alertCont03Msg_OKCancelPsw").removeClass('alert-success');
			$("#alertCont03Msg_OKCancelPsw").addClass('alert-danger');
			$("#alertMsg03Msg_OKCancelPsw").html('Password Errata!');
			$("#alertCont03Msg_OKCancelPsw").show();
		}	else  {
			let data_ora = $("#data"+n).val();
			let classe_ora = $( "#selectclasse option:selected" ).val();
			postData = { data_ora: data_ora, classe_ora: classe_ora};
			//console.log("07Orario.php - resetDay -  postData a 07qry_DeleteOrarioGiornoClasse.php")
			//console.log (postData);
			$.ajax({
				type: 'POST',
				url: "07qry_DeleteOrarioGiornoClasse.php",
				data: postData,
				dataType: 'json',
				success: function(data){
					//inserire un log delle cancellazioni
					$("#remove-content03Msg_OKCancelPsw").slideUp();
					$("#alertMsg03Msg_OKCancelPsw").html('Orario del giorno '+data_ora+'<br> per la classe '+classe_ora+' cancellato con successo');
					$("#alertCont03Msg_OKCancelPsw").removeClass('alert-danger');
					$("#alertCont03Msg_OKCancelPsw").addClass('alert-success');
					$("#alertCont03Msg_OKCancelPsw").show();
					$("#btn_cancel03Msg_OKCancelPsw").html('Chiudi');
					$("#btn_OK03Msg_OKCancelPsw").hide();
					requery();
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '07Orario ##fname##'");      
				}
			});
			
		}


	}
	
	function DownloadExcel() {
		let downloadType = $( "#selectDownloadExcel option:selected" ).val();
		window[downloadType]();
	}

	function DownloadExcelOrarioMese() {
		firstDate = $("#data1").val();
		firstDayofMonth = firstDate.substring(0,8)+"01";
		firstDayofMonthm = moment(firstDayofMonth, "YYYY-MM-DD" );
		lastDayofMonthm = firstDayofMonthm.clone().endOf('month');
		lastDayofMonth = moment(lastDayofMonthm).format('YYYY-MM-DD');
		window.location.href='07downloadOrarioMese.php?datefrom='+firstDayofMonth+'&dateto='+lastDayofMonth;
	}
	
	function DownloadExcelOrarioSettimana() {
		firstDate = $("#data1").val();
		let date = new Date(firstDate);
		date.setDate(date.getDate() + 4);
		lastDate = date.toISOString().slice(0,10);
		window.location.href='07downloadOrarioSettimana.php?datefrom='+firstDate+'&dateto='+lastDate;
	}
	
	
	function showModalSetupAnno (){
		$("#alertaggiungi").hide();
		$("#btn_cancel1").html('Annulla');
		$("#btn_cancel1").addClass('pull-left');
		$("#btn_OK1").show();
		$("#remove-content").show();
		$('#modalSetupAnno').modal({show: 'true'});
	}
	
	function updateYearDates() {
		annoscolastico = $("#selectannoscolastico").val();
		postData = { annoscolastico: annoscolastico};
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "07qry_getYearDates.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				$("#datainizio_asc").val(data.datainizio_asc);
				$("#datafinequadrimestre1_asc").val(data.datafinequadrimestre1_asc);
				$("#datafine_asc").val(data.datafine_asc);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '07Orario ##fname##'");     
			}
		});
	}
	
	function salvaSetup() {
		annoscolastico = $("#selectannoscolastico").val();
		datainizio_asc = $("#datainizio_asc").val();
		datafinequadrimestre1_asc = $("#datafinequadrimestre1_asc").val();
		datafine_asc = $("#datafine_asc").val();
		postData = { annoscolastico: annoscolastico, datainizio_asc: datainizio_asc, datafinequadrimestre1_asc: datafinequadrimestre1_asc, datafine_asc: datafine_asc};
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "07qry_UpdateDefaultYearAndSetDates.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				
				requery();
				$("#alertaggiungi").show();
				$("#btn_cancel1").html('Chiudi');
				$("#btn_cancel1").removeClass('pull-left');
				$("#btn_OK1").hide();
				$("#remove-content").slideUp();
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '07Orario ##fname##'");     
			}
		});
	}

	






//SEGUONO 4 ROUTINE DI BONIFICA DEGLI ORARI...DA ELIMINARE FRA QUALCHE SETTIMANA
	function BONIFICATMP() {

		$.ajax({
			type: 'POST',
			url: "07qry_BONIFICA.php",
			dataType: 'json',
			success: function(data){
				// console.log ("SISTEMO LA COERENZA INTERNA DI TAB_ORARIO PER IL FUTURO ELIMINANDO RECORD NON COERENTI");
				// console.log ("quelli che hanno zero in IDfirmatutor_ora: quindi i corrispondenti TUX non dovrebbero esistere");
				// console.log (data.test0);
				// console.log ("quelli che hanno valori diversi da zero in IDfirmatutor_ora");
				// console.log (data.test1);
				// console.log ("ID firma tutor raccolti nei casi in cui non siano zero");
				// console.log (data.test2);
				// console.log ("verifica che quelli da cancellare siano tutti TUX");
				// console.log (data.test3);
				// console.log ("Sto per cancellare questi");
				// console.log (data.test4);
				// console.log ("Che per verifica hanno questa materia");
				// console.log (data.test5);
				// console.log ("Vediamo se sono firmate");
				// console.log (data.test6);
				// console.log ("Argomento");
				// console.log (data.test7);
				// console.log ("Compiti");
				// console.log (data.test8);
				//POICHE' MOLTISSIMI SONO FIRMATI NON POSSO CANCELLARLI: LI TENGO LI' E D'ORA IN AVANTI
				// FACCIO SI' CHE LA COPIATURA NON CREI QUESTI PROBLEMI!

			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '07Orario ##fname##'");      
			}
		});
	}
	
	function BONIFICAPREGRTMP() {

		$.ajax({
			type: 'POST',
			url: "07qry_BONIFICAPREGR.php",
			dataType: 'json',
			success: function(data){
				// console.log ("SISTEMO LA COERENZA PASSATA DI TAB_ORARIO PER IL FUTURO ELIMINANDO RECORD NON COERENTI MA SOLO SE NON FIRMATI, ");
				// console.log ("SE FIRMATI SISTEMO LA COERENZA DI ID TUTOR");
				// console.log ("IDoraTUXZEROA: questi sono i TUX i cui principali hanno zero in IDfirmatutor");
				// console.log (data.test05);
				// console.log ("IDoraZEROA: prinicpali che hanno zero in IDfirmatutor_ora: non dovrebbero");
				// console.log (data.test0);
				// console.log ("____________________________________________________________________________");
				// console.log ("IDoraTUXNONZEROA: questi sono i TUX i cui principali NON hanno zero in IDfirmatutor");
				// console.log (data.test15);
				// console.log ("IDoraNONZEROA prinicpali che NON hanno zero in IDfirmatutor_ora: come dovrebbero essere sempre");
				// console.log (data.test1);
				// console.log ("IDfirmatutor_oraA ID firme tutor raccolti nei casi in cui non siano zero");
				// console.log (data.test2);
				// console.log ("____________________________________________________________________________");
				// console.log ("verificaA verifica che quelli da cancellare siano tutti TUX");
				// console.log (data.test3);
				// console.log ("verificaCancIDOraA Sto per cancellare questi");
				// console.log (data.test4);
				// console.log ("verificaCancMateriaA Che per verifica hanno questa materia");
				// console.log (data.test5);
				// console.log ("firma_mae_oraA Vediamo se sono firmate");
				// console.log (data.test6);
				// console.log ("argomento_oraA Argomento");
				// console.log (data.test7);
				// console.log ("compitiassegnati_oraA Compiti");
				// console.log (data.test8);
				// console.log ("____________________________________________________________________________");
				// console.log ("eseguofirmaA questi gli ID dei record TUX che vado a inserire in IDfirmatutor_ora");
				// console.log (data.test9);
				//POICHE' MOLTISSIMI SONO FIRMATI NON POSSO CANCELLARLI: LI TENGO LI' E D'ORA IN AVANTI
				// FACCIO SI' CHE LA COPIATURA NON CREI QUESTI PROBLEMI!

			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '07Orario ##fname##'");      
			}
		});
	}

	function BONIFICAMAESTRITUTOR() {

		$.ajax({
			type: 'POST',
			url: "07qry_BONIFICACLASSIMAESTRI.php",
			dataType: 'json',
			success: function(data){
				// console.log ("SISTEMO LA COERENZA INTERNA DI TAB_CLASSIMAESTRI");
				// console.log ("mancaTutorA: classi maestri con tutor_cma <>0 ma di cui manca il tutor: tutordi_cma");
				// console.log (data.test0);
				// console.log ("TutordiA: inseritò tutordi:");
				// console.log (data.test05);
				// console.log ("tutorMancanteA: vado a inserire questo tutor");
				// console.log (data.test1);
				// console.log ("codmat_cmaA: record di tutor mancanti in classimaestri");
				// console.log (data.test2);
				// console.log ("classe_cmaA: record di tutor mancanti in classimaestri");
				// console.log (data.test3);
				// console.log ("sezione_cmaA: record di tutor mancanti in classimaestri");
				// console.log (data.test4);
				// console.log ("ruolo_cmaA: record di tutor mancanti in classimaestri");
				// console.log (data.test5);
				// console.log ("annoscolastico_cmaA: record di tutor mancanti in classimaestri");
				// console.log (data.test6);



				//POICHE' MOLTISSIMI SONO FIRMATI NON POSSO CANCELLARLI: LI TENGO LI' E D'ORA IN AVANTI
				// FACCIO SI' CHE LA COPIATURA NON CREI QUESTI PROBLEMI!

			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '07Orario ##fname##'");      
			}
		});
	}

	function BONIFICACLASSIMAESTRICOERENZA() {

		$.ajax({
			type: 'POST',
			url: "07qry_BONIFICACLASSIMAESTRICOERENZA.php",
			dataType: 'json',
			success: function(data){
				// console.log ("ID_mae_oraPrA: ID Maestri principali");
				// console.log (data.test);
				// console.log ("ID_mae_tutorA: ID tutor trovati in tab_orario");
				// console.log (data.test03);
				// console.log ("annoscolstico");
				// console.log (data.test05);
				// console.log ("record coerenti");
				// console.log (data.test0);
				// console.log ("record non coerenti in classi maestri");
				// console.log (data.test1);
				//POICHE' MOLTISSIMI SONO FIRMATI NON POSSO CANCELLARLI: LI TENGO LI' E D'ORA IN AVANTI
				// FACCIO SI' CHE LA COPIATURA NON CREI QUESTI PROBLEMI!

			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '07Orario ##fname##'");     
			}
		});
	}
</script>
