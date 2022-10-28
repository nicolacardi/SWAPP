<?	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	$ID_mae = $_POST['ID_mae'];	
	$role_usr = $_SESSION['role_usr'];
	?>

	<div id="TabsSchedaMaestro" style="display: none; margin-top:5px;">

		<?
		//estraggo i dati da mostrare nella parte anagrafica
		$sql2 = "SELECT ID_mae, ID_usr_mae, socio_mae, login_usr, in_organico_mae, tipo_per, mf_mae, nome_mae, cognome_mae, datanascita_mae, comunenascita_mae, provnascita_mae, paesenascita_mae, cittadinanza_mae, cf_mae, indirizzo_mae, citta_mae, prov_mae, paese_mae, CAP_mae, titolo_mae, telefono_mae, altrotelefono_mae, email_mae, note_mae, img_mae, vede_mae,
		matricola_mae, matrinps_mae, matrinail_mae, certpencg_mae, dataass_mae, datalic_mae, tipocontr_mae, livello_mae, orecontr_mae, ud_mae, parttimeperc_mae, iban_mae, noterapporto_mae, ral_mae ".
		"FROM tab_anagraficamaestri LEFT JOIN tab_users ON ID_usr_mae = ID_usr ".
		"WHERE ID_mae = ?;";
		$stmt2 = mysqli_prepare($mysqli, $sql2);
		mysqli_stmt_bind_param($stmt2, "i", $ID_mae);
		mysqli_stmt_execute($stmt2);
		mysqli_stmt_bind_result($stmt2, $ID_mae_det, $ID_usr_mae_det, $socio_mae_det, $login_usr, $in_organico_mae_det, $tipo_per_det, $mf_mae_det, $nome_mae_det, $cognome_mae_det, $datanascita_mae_det, $comunenascita_mae_det, $provnascita_mae_det, $paesenascita_mae_det, $cittadinanza_mae_det, $cf_mae_det, $indirizzo_mae_det, $citta_mae_det, $prov_mae_det, $paese_mae_det, $CAP_mae_det, $titolo_mae_det, $telefono_mae_det, $altrotelefono_mae_det, $email_mae_det, $note_mae_det, $img_mae, $vede_mae, $matricola_mae, $matrinps_mae, $matrinail_mae, $certpencg_mae, $dataass_mae, $datalic_mae, $tipocontr_mae, $livello_mae, $orecontr_mae, $ud_mae, $parttimeperc_mae, $iban_mae, $noterapporto_mae, $ral_mae);
		$i=0;
		while (mysqli_stmt_fetch($stmt2)) {
		$i++;
		}
		?>	
		<!-- definizione labels del tab group-->
		<ul class="nav nav-tabs" id="TabsSchedaMaestroLabels">
			<? if ($role_usr == 0 || $role_usr == 1 || $role_usr ==4) {?>
				<li style="margin-left: 60px;">
					<a href="#DatiAnagrafici" data-toggle="tab" class="active">Dati Anagrafici</a>
				</li>
			<? } ?>
			<? if ($role_usr == 0 || $role_usr == 1 || $role_usr ==4) {?>
				<li>
					<a href="#DatiRapporto" data-toggle="tab">Dati Rapporto</a>
				</li>
			<? } ?>

			<? if ($role_usr == 0 || $role_usr == 1 || $role_usr ==4) {?>
				<li>
					<a href="#Formazione" class="hideonlessthan1280" data-toggle="tab">Formazione</a>
				</li>
			<? } ?>
			<li style="<? if ($role_usr == 3) { echo ("margin-left:60px");}?>">
					<a href="#Classi" <?if ($tipo_per_det!=0) {echo ("style='display: none'");} ?> data-toggle="tab">Classi di Insegnamento</a>
			</li>
		</ul>

		<div class="tab-content" id="TabsSchedaMaestroContent">

			<?//Tab Dati Anagrafici
			include_once ('08inc_DatiAnagrafici.php');?>

			<?//Tab Dati Contratto
			include_once ('08inc_DatiContratto.php');?>
	
			<?//Tab Dati Classi Assegnate
			include_once ('08inc_Classi.php');?>

			<?//Tab Formazione		
			include_once ('08inc_Formazione.php');?>
			
			
			
		</div>
	</div>	
	<div style="text-align: center;">
		<div class="alert alert-success" id="alertModificaAnagrafica" style="display: none; width: 500px; text-align: center; margin-top:10px; position: absolute; margin-left: -250px; left: 50% ">
			<h4 style="text-align:center;"> Aggiornamento anagrafica completato con successo!</h4>
		</div>
	</div>
	
<!--*************************************************FORM MODALE AGGIUNTA RECORD IN tab_classimaestri***************************************************  -->
	<div class="modal" id="modalAggiungiRecordcma" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_iscrizione" method="post">		

						<div id="remove-contentAggiungiRecordcma" style="text-align: center; margin-top: 20px; "> <!-- START REMOVE CONTENT -->
							<span>INSERIMENTO DI UNA NUOVA COMBINAZIONE MATERIA-CLASSE</span>
							<br>
							<span style="width:50%; ">per il maestro </span>
							<h4> <?=$nome_mae_det?> <?=$cognome_mae_det?></h4>
							<div class="row" style="margin-bottom:20px;">
								<div class="col-md-4">
									Anno scolastico
									<br>	
									<select name="selectannoscolastico_modal" id="selectannoscolastico_modal" >
										<? $sql4 = "SELECT annoscolastico_asc FROM tab_anniscolastici";
										$stmt4 = mysqli_prepare($mysqli, $sql4);
										mysqli_stmt_execute($stmt4);
										mysqli_stmt_bind_result($stmt4, $annoscolastico_asc);
										while (mysqli_stmt_fetch($stmt4)) {
										?> <option value="<?=($annoscolastico_asc) ?>" <? if ($annoscolastico_asc == $_SESSION['anno_corrente']) {echo ('selected');}?>><? echo ($annoscolastico_asc) ?></option><?
										}?>
									</select>
								</div>
								<div class="col-md-4">
								Classe
								<br>
								<select name="selectclasse_modal"  id="selectclasse_modal" onchange="aggiornaListaMaterie();">
									<? $sql5 = "SELECT classe_cls FROM tab_classi";
										$stmt5 = mysqli_prepare($mysqli, $sql5);
										mysqli_stmt_execute($stmt5);
										mysqli_stmt_bind_result($stmt5, $classe_cls);
										while (mysqli_stmt_fetch($stmt5)) {
										?> <option value="<?=($classe_cls) ?>"><?=($classe_cls) ?></option><?
										}?>
								</select>
								</div>
								<div class="col-md-4">
									Sezione
									<br>
									<select name="selectsezione_modal" id="selectsezione_modal">
										<option value="A">A</option>
										<option value="B">B</option>
										<option value="C">C</option>
									</select>
								</div>
							</div>
							<div class="row" style="margin-bottom:20px;">
								<div class="col-md-6">
									Insegnante di classe o di materia?
									<br>
									<select name="selectCLAMAT_modal" id="selectCLAMAT_modal"  >
										<option value="CLA">CLA</option>
										<option value="MAT">MAT</option>
									</select>
									<br>
									<span style="display: block; font-size: 10px; line-height: 14px;">L'insegnante di classe compila</span>
									<span style="display: block; font-size: 10px; line-height: 14px;">Cert.Competenze e Cons. Orientativo</span>

								</div>
								<div class="col-md-6" id ="divSelectMAT_modal" >
									Selezionare la materia
									<br>
									<select name="selectMAT_modal"  id="selectMAT_modal">
										<? $sql6 = "SELECT codmat_mtt, descmateria_mtt FROM tab_materie ORDER BY descmateria_mtt";
										$stmt6 = mysqli_prepare($mysqli, $sql6);
										mysqli_stmt_execute($stmt6);
										mysqli_stmt_bind_result($stmt6, $codmat_mtt, $descmateria_mtt );
										while (mysqli_stmt_fetch($stmt6)) {
										?> <option value="<?=($codmat_mtt) ?>"><?=($descmateria_mtt)?></option><?
										}?>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-md-2">
									
								</div>
								<div class="col-md-8">
								Tutor di questo maestro in questa classe e materia
								<br>
								(selezionare solo se presente)
								<br>
								<select name="selecttutor_modal"  id="selecttutor_modal">
									<? $sql7 = "SELECT id_mae, nome_mae, cognome_mae FROM tab_anagraficamaestri WHERE tipo_per = 0 ORDER BY cognome_mae"; //tipo_per = 0 sono i maestri
										$stmt7 = mysqli_prepare($mysqli, $sql7);
										mysqli_stmt_execute($stmt7);
										mysqli_stmt_bind_result($stmt7, $IDtutor_mae, $nometutor_mae, $cognometutor_mae);?>
										<option value="0">-</option>
										<?while (mysqli_stmt_fetch($stmt7)) {
										?> <option value="<?= ($IDtutor_mae) ?>"><?=$cognometutor_mae." ".$nometutor_mae ?></option><?
										}?>
								</select>
								</div>
								
							</div>
							<br>
						</div> <!-- END REMOVE CONTENT -->
						<div class="alert alert-success" id="alertaggiungiAS" style="display:none; margin-top:10px;">
							<h4 style="text-align:center;"> Inserimento materia di insegnamento <br> completato con successo!</h4>
						</div>
						<div class="modal-footer">
							<button type="button" id="btn_cancelAggiungiRecordcma" class="btnBlu pull-left" style="width:40%;" data-dismiss="modal" onclick="requery();">Annulla</button>
							<button type="button" id="btn_OKAggiungiRecordcma" class="btnBlu pull-right" style="width:40%;" onclick="aggiungiRecordcma();">Procedi</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

<!--************************************************* FINE FORM MODALE AGGIUNTA RECORD IN tab_classimaestri*********************************************  -->


<!--*************************************************FORM MODALE AGGIUNTA RECORD IN tab_titolimaestri***************************************************  -->
	<div class="modal" id="modalAggiungiFormazione" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_formazione" method="post">		
						<span>INSERIMENTO DI UN NUOVO CORSO DI FORMAZIONE</span>
						<br>
						<span style="width:50%; ">per il maestro</span>
						<h4> <?=$nome_mae_det?> <?=$cognome_mae_det?></h4>
						<div id="remove-content-tag" style="text-align: center; margin-top: 20px; "> <!-- START REMOVE CONTENT -->
							<div class="row" style="margin-bottom:20px;">
								<select name="selectcat_tit"  style="margin-left: 0px"  id="selectcat_tit" onchange="ShowHideSelect2()">
										<option value="Diploma">Diploma</option>
										<option value="Laurea">Laurea</option>
										<option value="Seminario Waldorf">Seminario Waldorf</option>
										<option value="Aggiornamenti Waldorf">Aggiornamenti Waldorf</option>
										<option value="Altra Formazione Pedagogica">Altra Formazione Pedagogica</option>
										<option value="Privacy">Privacy</option>
										<option value="Sicurezza">Sicurezza</option>
										<option value="Altro">Altro</option>
								</select>
							</div>
							<div class="row" style="margin-bottom:20px;">
								<select name="selectcatsic_tit"  style="margin-left: 0px;"  id="selectcatsic_tit" onchange="FillHours(); CalcolaScadenza();">
										<option value="Lavoratori Rischio Medio">Lavoratori Rischio Medio</option>
										<option value="Addetti Squadra Antincendio">Addetti Squadra Antincendio</option>
										<option value="Addetti Primo Soccorso">Addetti Primo Soccorso</option>
										<option value="Rappresentante Lavoratori Sicurezza">Rappresentante Lavoratori Sicurezza</option>
								</select>
							</div>
							<div class="col-md-12" id="optionsformazioneaggiornamento" style="padding-bottom: 2px;">
								<div class="col-md-4 col-sm-6 col-xs-6 col-md-offset-2" style="z-index: 100; text-align: center;">
									<input type="radio" class="ckformagg_tit" name="ckformagg_tit" value="F" checked>&nbsp;Formazione
								</div>
								<div class="col-md-4 col-sm-6 col-xs-6" style="z-index: 100; text-align: center;">
									<input type="radio" class="ckformagg_tit" name="ckformagg_tit" value="A">&nbsp;Aggiornamento
								</div>
							</div>
							<div class="row" style="margin-bottom:20px;">
								<div class="col-md-3">
								</div>
								<div class="col-md-6" id="titoloText">
									Titolo
									<br>
									<input class="tablecell5" type="text"  id="nome_tit_modal" name="nome_tit_modal">
								</div>
							</div>
							<div class="row" style="margin-bottom:20px;">
								<div class="col-md-3">
								</div>
								<div class="col-md-6">
									Descrizione Titolo
									<br>
									<textarea style="height: 72px;" class="tablecell5" type="text"  id="desc_tit_modal" name="desc_tit_modal"></textarea>
								</div>
							</div>
							<div class="row" style="margin-bottom:20px;">
								<div class="col-md-4">
								</div>
								<div class="col-md-4">
									Data di conseguimento
									<br>
									<input style="text-align: center; width: 50%" class="tablecell3 dpd" type="text"  id="data_tit_modal" name="data_tit_modal" onchange="CalcolaScadenza();">
								</div>
							</div>
							<div class="row" style="margin-bottom:20px;">
								<div class="col-md-4">
								</div>
								<div class="col-md-4">
									Data di Scadenza
									<br>
									<input style="text-align: center; width: 50%" class="tablecell3 dpd" type="text"  id="scad_tit_modal" name="scad_tit_modal">

								</div>
							</div>
							<br>
						</div> <!-- END REMOVE CONTENT -->
						<div class="alert alert-success" id="alertaggiungiFO" style="display:none; margin-top:10px;">
							<h4 style="text-align:center;"></i> Inserimento Corso completato con successo!</h4>
						</div>
						<div class="modal-footer">
							<button type="button" id="btn_cancel" class="btnBlu pull-left" style="width:40%;" data-dismiss="modal" >Annulla</button>
							<button type="button" id="btn_OK" class="btnBlu pull-right" style="width:40%;" onclick="aggiungiFormazione();">Procedi</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

<!--************************************************* FINE FORM MODALE AGGIUNTA RECORD IN tab_titolimaestri*********************************************  -->

<!-- ********************************************************************** CROPPIE con tutte le sue FUNZIONI ******************************************  -->
<div class="modal" id="modalFormCroppie" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width:450px;">
		<div class="modal-content">
        	<div class="modal-header" style="text-align: center; border-bottom: 0px;">
				<span class="titoloModal" >
						Selezione e ritaglio Immagine
						<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> -->
				</span>
			</div>
			<div class="modal-body" style="padding-bottom:500px;">
            	<div class="col-md-12">
					<!--uploadCrop è la zona di overview dentro Croppie-->
					<div class= "uploadCrop" id="uploadCrop">
					</div>
				</div>
				<div class="col-md-12">
					<div class="col-md-12">
							<!-- la input dove viene scritto il nome del file estratto dal db nel modale-->
							<!--<input class="form-control" id="filenametosave" style="  border-radius: 10px; text-align:center; height:34px; padding:6px 12px;" name="filenametosave" value = "<?//=$img_alu;?>" disabled> -->
							<!-- di seguito la label carina usata per il bottone di caricamento upload-->
							<label class="btnBlu" for="imgSelezioneInModale" style="width:100%;">Cerca Immagine nel Computer</label>
							<input type="file" id="imgSelezioneInModale" accept="image/*" style="display: none;">
							<!-- la input dove viene scritto il nome del file nel form modale-->
							<input id="imgNameModal" name="imgNameModal" maxlength="30" placeholder="immagine" style="display: none;"> 
							<br/>
							<button class="btnBlu" data-dismiss="modal" id="imgProcediconCrop" style="width:100%;">Ritaglia Immagine</button>	
					</div>
				</div>
<!----------------------------------------FUNZIONI DI CROPPIE----------------------------------------------------------------->			
				<script>
					
					//setta le caratteristiche del plugin per la visualizzazione di Croppie agendo su uploadCrop
					$uploadCrop = $('#uploadCrop').croppie({
						enableExif: true,
						viewport: {
							width: 200,
							height: 200,
							type: 'square'
						},
						boundary: {
							width: 350,
							height: 350
						}
					});
					//Viene lanciata al primo caricamento di croppie, o
					//al lancio del form modale
					//serve a caricare nel form modale l'immagine che si trova in database
					$('#launchModalCrop').click(function() {		
						imgName = document.getElementById('imgName').value;
						$("#imgNameModal").val(imgName);
						if (imgName) {
							let num = Math.random();
							$uploadCrop.croppie('bind', {
							url: 'assets/photos/imgs/'+imgName+"?"+num,
							});
						} else {
							$(".cr-image").css("display", "none"); //altrimenti si vede "preview" L'importante è poi rimostrarla quando si fa il caricamento di una nuova immagine
						}
					});
					//Viene lanciata in fase di caricamento di "ALTRA" immagine rispetto a quella eventualmente già in database
					//viene lanciata in fase di change dell'input file #upload
					$('#imgSelezioneInModale').on('change', function () {
						fileName = $('#imgSelezioneInModale')[0].files[0].name;
						$(".cr-image").css("display", "block");
						fileName = fileName.replace(/[\|&;\$%@"<>\(\)\+,]/g, "");
						fileName = fileName.replace ("-", "");
						$("#imgNameModal").val(fileName);
						let reader = new FileReader();
						reader.onload = function (e) {
							$uploadCrop.croppie('bind', {
								url: e.target.result
							}).then(function(){
								console.log('jQuery bind complete');
							});
						};
						reader.readAsDataURL(this.files[0]);
					});
					//da qui avviene il crop ed il conseguente caricamento/upload ecc
					$('#imgProcediconCrop').on('click', function () {
						nome = $('#nome_mae').val();
						cognome = $('#cognome_mae').val();
						fileName = nome + cognome;
						fileName = fileName.replace(/[\|&;\$%@"<>\(\)\+,]/g, "");
						fileName = fileName.replace ("'", "");
						fileName = fileName.replace (" ", "");
						fileName = fileName.replace ("-", "");
						//prepara l'immagine croppata in forma base64 e la mette nella variabile resp
						console.log ("++"+fileName);
						$uploadCrop.croppie('result', {
							type: 'base64',
							size: 'viewport'
						}).then(function (resp) {
							//la ajax che segue manda a croppieupload che EFFETTUA l'UPLOAD dell'immagine passata in base 64 con il nome fileName nella cartella assets/photos/imgs
							$.ajax({
								url: "croppieupload.php",
								type: "POST",
								data: {"image":resp, "filenametosave": fileName, "foldertoupload": 'assets/photos/imgs'},
								success: function () {
									let imgtoupdate = document.getElementById('imgContainerx');
									let num = Math.random(); 								//serve per caricare immagine indipendentemente dal fatto che sia già in cache
									imgtoupdate.src = "assets/photos/imgs/"+fileName+".png?"+num;  		//riapplica estensione
									let imgNameElement = document.getElementById('imgName');
									imgNameElement.value = fileName+".png?"+num;
								},
								error: function(){
									alert("Errore: contattare l'amministratore fornendo il codice di errore '08qry_SchedaMaestro ##fname##'");      
								}
							});
						});
					});
				/*function removeExtension(filename){
					let lastDotPosition = filename.lastIndexOf(".");
					if (lastDotPosition === -1) return filename;
					else return filename.substr(0, lastDotPosition);
				}*/
				</script>
			</div>
		</div>
	</div>
</div>
<!-- ********************************************************************** FINE CROPPIE ***************************************************************  -->
<? include("CodiceFiscale.php")?>
<script>
	
	$(document).ready(function(){
		moment.locale('en', {
          week: { dow: 1 }
        });
		$('.dpd').datetimepicker({
			pickTime: false, 
			format: "DD/MM/YYYY",
            weekStart: 1
		});
		let ID_mae = $("#ID_mae_det_hidden").val();
		if (ID_mae != "") { 
			$("#TabsSchedaMaestro").css('display','block');
			let pagtoshow = $("#pagtoshow_hidden").val();
			//$('#TabsSchedaMaestro a:'+pagtoshow).tab('show');
			$("#TabsSchedaMaestro a[href='#"+pagtoshow+"']").tab('show');

		}
		ShowHideSelect2();
		aggiornaListaMaterie();
	});
	
	// function controllaDataNascita (data, annomin, annomax) {
	// 	if ((data != "") && (data != null)) {
	// 		let datam = moment(data, "DD-MM-YYYY" );
	// 		let annom = moment(datam).year();
	// 		console.log (data);
	// 		if ((datam.isValid()) && (annom > annomin) && (annom < annomax) ) { return true; } else { return false;}
	// 	} else {
	// 		return true;
	// 	}
	// }
	
	function aggiornaAnagrafica (pagina) {
		let img_mae = $('#imgName').val();
		//estraggo tutti i valori da salvare
		let ID_mae = $('#ID_mae_det_hidden').val();
		let ID_usr_mae = $('#ID_usr_mae_det_hidden').val();

		let socio_mae = $("#socio_mae_det").is(":checked");
		if (socio_mae == false) {socio_mae = 0;} else {socio_mae =1;}

		let nome_mae = $('#nome_mae_det').val();
		let cognome_mae = $('#cognome_mae_det').val();
		let mf_mae = $('#mf_mae_det').val();

		if (img_mae != "") {
			fileName = nome_mae + cognome_mae;
			fileName = fileName.replace(/[\|&;\$%@"<>\(\)\+,]/g, "");
			fileName = fileName.replace ("'", "");
			fileName = fileName.replace (" ", "");
			fileName = fileName.replace ("-", "");
			img_mae = fileName+".png";
		}
		let indirizzo_mae = $('#indirizzo_mae_det').val();
		let citta_mae = $('#citta_mae_det').val();
		let CAP_mae = $('#CAP_mae_det').val();
		let prov_mae = $('#prov_mae_det').val();
		let paese_mae = $('#paese_mae_det').val();
		let cf_mae = $('#cf_mae_det').val();
		let datanascita_mae = $('#datanascita_mae_det').val();
		if (controllaDataNascita(datanascita_mae, 1940, 2000)){
		} else {
			$('#titolo01Msg_OK').html('AGGIORNAMENTO ANAGRAFICA');
			$('#msg01Msg_OK').html("Verificare la data di nascita");
			$('#modal01Msg_OK').modal('show');
			return;
		}
		let comunenascita_mae = $('#comunenascita_mae_det').val();
		let provnascita_mae = $('#provnascita_mae_det').val();
		let paesenascita_mae = $('#paesenascita_mae_det').val();
		let cittadinanza_mae = $('#cittadinanza_mae_det').val();
		let telefono_mae = $('#telefono_mae_det').val();
		let altrotelefono_mae = $('#altrotelefono_mae_det').val();
		let titolo_mae = $('#titolo_mae_det').val();
		let note_mae = $('#note_mae_det').val();
		let vede_mae = $("input[name='vede_mae']:checked").val();
		let email_mae = $('#email_mae_det').val();
		let in_organico_mae =  1;
		if($("#in_organico_mae").is(':checked')) {
			in_organico_mae =  1;
		} else {
			in_organico_mae =  0;
		}
		
		let tipo_per =  $("#selectTipoPer").val();
		let login_usr = $("#login_usr").val();

		let matricola_mae = $("#matricola_mae").val();
		let matrinps_mae = $("#matrinps_mae").val();
		let matrinail_mae = $("#matrinail_mae").val();
		let certpencg_mae = $("#certpencg_mae").val();
		let dataass_mae = $("#dataass_mae").val();
		let datalic_mae = $("#datalic_mae").val();
		let tipocontr_mae = $("#selectTipocontr_mae").val();
		let livello_mae = $("#selectLivello_mae").val();
		let orecontr_mae = $("#orecontr_mae").val();
		let ud_mae = $("#ud_mae").val();
		let parttimeperc_mae = $("#parttimeperc_mae").val();
		let iban_mae = $("#iban_mae").val();
		let noterapporto_mae = $("#noterapporto_mae").val();
		let ral_mae = $("#ral_mae").val();



		postData = { ID_mae: ID_mae, socio_mae: socio_mae, nome_mae: nome_mae, cognome_mae: cognome_mae, indirizzo_mae: indirizzo_mae, citta_mae: citta_mae, CAP_mae: CAP_mae, prov_mae: prov_mae, paese_mae: paese_mae, mf_mae: mf_mae, cf_mae: cf_mae, datanascita_mae: datanascita_mae, comunenascita_mae: comunenascita_mae, provnascita_mae: provnascita_mae, paesenascita_mae: paesenascita_mae, cittadinanza_mae: cittadinanza_mae, telefono_mae: telefono_mae, altrotelefono_mae: altrotelefono_mae, titolo_mae: titolo_mae, note_mae: note_mae, email_mae: email_mae, img_mae: img_mae, vede_mae: vede_mae, in_organico_mae: in_organico_mae, tipo_per: tipo_per, login_usr: login_usr, ID_usr_mae: ID_usr_mae, matricola_mae: matricola_mae, matrinps_mae: matrinps_mae, matrinail_mae: matrinail_mae, certpencg_mae: certpencg_mae, dataass_mae: dataass_mae, datalic_mae: datalic_mae, tipocontr_mae: tipocontr_mae, livello_mae: livello_mae, orecontr_mae: orecontr_mae, ud_mae: ud_mae, parttimeperc_mae: parttimeperc_mae, iban_mae: iban_mae, noterapporto_mae: noterapporto_mae, ral_mae: ral_mae, padremadre: "maestro"};
		console.log ("08qry_SchedaMaestro.php - aggiornaAnagrafica - postData a 08qry_updateAnagraficaMaestro.php") ;
		console.log (postData) ;
		$.ajax({
			type: 'POST',
			url: "08qry_updateAnagraficaMaestro.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				console.log (data.test);
				$('#alertModificaAnagrafica').html(data.msg);
				$("#alertModificaAnagrafica").show();
				$("#pagtoshow_hidden").val(pagina);
				setTimeout(function(){requery(); }, 1000);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '08qry_SchedaMaestro ##fname##'");      
			}
		});

		$.ajax({
			type: 'POST',
			url: "21qry_updateAnagraficaSocio.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				console.log (data);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '21qry_updateAnagraficaSocio'");      
			}
		});


	}

	function MostraModalAggiungiRecordcma (){
		$("#modalAggiungiRecordcma .alert").hide();
		$('#btn_cancelAggiungiRecordcma').html('Annulla');
		$('#btn_cancelAggiungiRecordcma').addClass('pull-left');
		$('#btn_OKAggiungiRecordcma').show();
		$("#pagtoshow_hidden").val("Classi");
		$('#modalAggiungiRecordcma').modal('show');
	}
	
	function MostraModalAggiungiFormazione (){
		//$('#btn_cancelIscrizione').html('Annulla');
		//$('#btn_cancelIscrizione').addClass('pull-left');
		//$('#btn_OKIscrizione').show();
		$('#modalAggiungiFormazione').modal('show');
	}
	
	function aggiungiRecordcma() {
		//si tratta dell'aggiunta di una classe per un maestro
		let ID_mae_cma = $('#ID_mae_det_hidden').val();
		let annoscolastico_cma =  $("#selectannoscolastico_modal").val();
		let classe_cma =  $("#selectclasse_modal").val();
		let sezione_cma =  $("#selectsezione_modal").val();
		let ruolo_cma =  $("#selectCLAMAT_modal").val();
		let codmat_cma =  $("#selectMAT_modal").val();
		let tutor_cma = $('#selecttutor_modal').val();
		if (ID_mae_cma == tutor_cma ){
			$("#alertaggiungiAS").removeClass('alert-success');
			$("#alertaggiungiAS").addClass('alert-danger');
			$("#alertaggiungiAS").html( "Non si può inserire un maestro come tutor di se stesso");
			$("#modalAggiungiRecordcma .alert").show();
		} else {
			postData = { ID_mae_cma: ID_mae_cma, annoscolastico_cma: annoscolastico_cma, classe_cma: classe_cma, sezione_cma: sezione_cma, ruolo_cma: ruolo_cma, codmat_cma: codmat_cma, tutor_cma: tutor_cma};
			console.log ("08qry_SchedaMaestro.php - aggiungiRecordcma -  post a 08qry_checkRecordCma.php");
			console.log (postData);
			$.ajax({
				url : "08qry_checkRecordCma.php",
				type: "POST",
				data : postData,
				dataType: "json",
				success:function(data1) {
					//console.log (postData);
					if (data1.recordcmaGiaPresente) {
						$("#alertaggiungiAS").removeClass('alert-success');
						$("#alertaggiungiAS").addClass('alert-danger');
						$("#alertaggiungiAS").html(data1.msg);
						$("#alertaggiungiAS").show();
					} else {
						$.ajax({
							type: 'POST',
							url: "08qry_insertRecordcma.php",
							data: postData,
							dataType: 'json',
							success: function(data){
								//console.log ("08qry_SchedaMaestro.php - aggiungiRecordcma -  ritorno da 08qry_checkRecordCma.php");
								//console.log (data.sql2);
								$("#alertaggiungiAS").removeClass('alert-danger');
								$("#alertaggiungiAS").addClass('alert-success');
								$('#alertaggiungiAS').html(data.msg);
								$("#modalAggiungiRecordcma .alert").show();
								$("#remove-contentAggiungiRecordcma").slideUp();
								$('#btn_OKAggiungiRecordcma').hide();
								$('#btn_cancelAggiungiRecordcma').html('Chiudi');
								$('#btn_cancelAggiungiRecordcma').removeClass('pull-left');
								//$('#modalAggiungiRecordcma').modal('hide');
								//requery(); requery non va lanciato qui, perchè altrimenti si vede lo schermo nero in quanto c'è il form modale. requery va lanciato su click del pulsante annulla
							},
							error: function(){
								alert("Errore: contattare l'amministratore fornendo il codice di errore '08qry_SchedaMaestro ##fname##'");      
							}
						});
					}
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '08qry_SchedaMaestro ##fname##'");      
				}
			});
		}

	}
	
	function aggiungiFormazione() {
		let ckformagg_tit = $(".ckformagg_tit:checked").val();
		let ID_mae_tit = $('#ID_mae_det_hidden').val();
		let cat_tit = $('#selectcat_tit').val();
		console.log (cat_tit);
		let nome_tit = "";
		if ($('#selectcat_tit').val() ==  'Sicurezza') {
			nome_tit =  $('#selectcatsic_tit').val();
		} else {
			nome_tit =  $("#nome_tit_modal").val();
		}
		let desc_tit =  $("#desc_tit_modal").val();
		let data_tit =  $("#data_tit_modal").val();
		let scad_tit =  $("#scad_tit_modal").val();
		postData = { ID_mae_tit: ID_mae_tit, cat_tit: cat_tit, nome_tit: nome_tit, desc_tit: desc_tit, data_tit: data_tit, scad_tit: scad_tit, ckformagg_tit: ckformagg_tit};
			console.log (postData);
			$.ajax({
			type: 'POST',
			url: "16qry_insertFormazione.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				document.getElementById('alertaggiungiFO').innerHTML = data.msg;
				$("#modalAggiungiFormazione .alert").show();
				//console.log (data.sql2);
				$('#modalAggiungiFormazione').modal('hide');
				requery();
				//$("#pagtoshow_hidden").val("last");
				$("#pagtoshow_hidden").val("Formazione");
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '08qry_SchedaMaestro ##fname##'");     
			}
			
		});

	}
	
	function salvaFormazione(ID_tit) {
		//si tratta dell'update di un titolo
		//let ID_mae_tit = $('#ID_mae_det_hidden').val();
		
		let nome_tit =  $("#nome_tit"+ID_tit).val();
		let desc_tit =  $("#desc_tit"+ID_tit).val();
		let data_tit =  $("#data_tit"+ID_tit).val();
		let scad_tit =  $("#scad_tit"+ID_tit).val();
		let ckformagg_tit = $('#formagg_tit'+ID_tit).val();
		postData = { ID_tit: ID_tit, nome_tit: nome_tit, desc_tit: desc_tit, data_tit: data_tit, scad_tit: scad_tit, ckformagg_tit: ckformagg_tit};
			console.log (postData);
			$.ajax({
			type: 'POST',
			url: "08qry_updateFormazione.php",
			data: postData,
			dataType: 'json',
			success: function(){
				//document.getElementById('alertaggiungiFO').innerHTML = data.msg;
				//$("#modalAggiungiFormazione .alert").show();
				//console.log (data.sql2);
				requery();
				$("#pagtoshow_hidden").val("Formazione");
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '08qry_SchedaMaestro ##fname##'");      
			}
		});
		//$('#modalAggiungiFormazione').modal('hide');
		
		//$("#pagtoshow_hidden").val("last");
		
	}
	

	function showModalDeleteThisRecord(ID_cma) {
		$('#titolo02Msg_OKCancel').html('ELIMINA MATERIA DI INSEGNAMENTO');
		$('#msg02Msg_OKCancel').html("Sei sicuro di voler cancellare questa materia di insegnamento in questa classe?");
		$("#btn_OK02Msg_OKCancel").html("Cancella");
		$("#btn_OK02Msg_OKCancel").attr("onclick","deleteThisRecord("+ID_cma+");");
		$('#modal02Msg_OKCancel').modal('show');
	}


	function deleteThisRecord(ID_cma) {
		postData = { ID_cma: ID_cma};
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "08qry_deleteRecordcma.php",
			data: postData,
			dataType: 'json',
			success: function(){
				requery();
				//$("#pagtoshow_hidden").val("last");
				$("#pagtoshow_hidden").val("Classi");
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '08qry_SchedaMaestro ##fname##'");     
			}
		});
	}

	function showModalDeleteThisFormazione(ID_tit) {
		$('#titolo02Msg_OKCancel').html('ELIMINA FORMAZIONE');
		$('#msg02Msg_OKCancel').html("Sei sicuro di voler cancellare questo corso di formazione per questo maestro?");
		$("#btn_OK02Msg_OKCancel").html("Cancella");
		$("#btn_OK02Msg_OKCancel").attr("onclick","deleteThisFormazione("+ID_tit+");");
		$('#modal02Msg_OKCancel').modal('show');
	}

	function deleteThisFormazione(ID_tit) {
		postData = { ID_tit: ID_tit};
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "16qry_deleteFormazioneMaestro.php",
			data: postData,
			dataType: 'json',
			success: function(){
				requery();
				//$("#pagtoshow_hidden").val("last");
				$("#pagtoshow_hidden").val("Formazione");
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '08qry_SchedaMaestro ##fname##'");      
			}
		});
	}
	
	$('.search-comune').on("keyup input", function(){
		campo = $(this).attr("name");
		// Get input value on change
		let inputVal = $(this).val();
		switch (campo) {
			case "comunenascita_mae_new":
				resultDropdown = $("#showComuneNascita_new");
			break;
			case "citta_mae_new":
				resultDropdown = $("#showComuneResidenza_new");
			break;
			case "comunenascita_mae_det":
				resultDropdown = $("#showComuneNascita_det");
			break;
			case "citta_mae_det":
				resultDropdown = $("#showComuneResidenza_det");
			break;
		}
		if(inputVal.length>2){
			$.get("06qry_DropDownComune.php", {inputVal: inputVal}).done(function(data){
			// Display the returned data in browser
			resultDropdown.html(data);
			});
		} else {
			resultDropdown.empty();
		}
	});
	
	function ShowHideSelect2 () {
		
		if ($('#selectcat_tit').val() ==  'Sicurezza') {
			$('#selectcatsic_tit').css("visibility","visible");
			$('#titoloText').css("visibility","hidden");
		} else {
			$('#selectcatsic_tit').css("visibility","hidden");
			$('#titoloText').css("visibility","visible");
		}
		FillHours();
		CalcolaScadenza();
	}
	
	$(".ckformagg").keypress(function(e){
        let inputValue = event.which;
        // 65 = A, 70 = F
		if((inputValue != 65) && (inputValue != 70) ){ 
            e.preventDefault(); 
        }
    });
	
	
	function FillHours() {
		if ($('#selectcat_tit').val() ==  'Sicurezza') {
			var OreSic = {LavoratoriRischioMedio:"6 Ore", AddettiSquadraAntincendio:"5 Ore", AddettiPrimoSoccorso: "5 Ore", RappresentanteLavoratoriSicurezza: "4 Ore" };
			Corso = $('#selectcatsic_tit').val();
			//console.log (Corso);
			CorsoIndex = Corso.replace(/\s+/g, '');
			console.log (OreSic[CorsoIndex]);
			$("#desc_tit_modal").html(OreSic[CorsoIndex]);			
		} else {
			$("#desc_tit_modal").html("");
		}
	}
	
	function CalcolaScadenza() {
		if ($('#selectcat_tit').val() ==  'Sicurezza') { //deve però oltre a essere 'Sicurezza' anche  essere 'Aggiornamento' let ckformagg_tit = $(".ckformagg_tit:checked").val();
			var Scadenze = {LavoratoriRischioMedio:5, AddettiSquadraAntincendio:3, AddettiPrimoSoccorso: 3, RappresentanteLavoratoriSicurezza: 1 };
			Corso = $('#selectcatsic_tit').val();
			console.log(Corso);
			CorsoIndex = Corso.replace(/\s+/g, '');
			console.log(CorsoIndex);
			console.log (Scadenze[CorsoIndex]);
			datacons = $("#data_tit_modal").val();
			console.log (datacons);
			if (datacons != "") {
				annocons = datacons.substring(6,10);
				console.log (annocons);
				annoscad = parseInt(annocons) + parseInt(Scadenze[CorsoIndex]);
				console.log(annoscad);
				datascad = datacons.substring(0,6)+annoscad;
				console.log (datascad);
				$("#scad_tit_modal").val(datascad);
			}
		} else {
			$("#scad_tit_modal").val("");
		}
	}
	
	function aggiornaListaMaterie() {
		classe_cls = $( "#selectclasse_modal option:selected" ).val();
		postData = { classe_cls: classe_cls};
		//console.log ("08qry_SchedaMaestro - aggiornaListaMaterie - postData a 08qry_getComboMaterie.php")
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "08qry_getComboMaterie.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#selectMAT_modal").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '08qry_SchedaMaestro ##fname##'");      
			}
		});
	}
		
	$("#mf_mae_det").keypress(function(e){
		let inputValue = event.which;
		// F = 70, M = 77
		if((inputValue != 70) && (inputValue != 77)){ 
			e.preventDefault(); 
		}
	});
</script>

