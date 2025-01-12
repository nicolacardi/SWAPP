<?	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	$ID_soc = $_POST['ID_soc'];	
	$role_usr = $_SESSION['role_usr'];
	?>

	<div id="TabsSchedaSocio" style="display: none; margin-top:5px;">

		<?
		//estraggo i dati da mostrare nella parte anagrafica
		$sql2 = "SELECT ID_soc, ID_fam_soc, ID_mae_soc, padremadre_soc, tipo_soc, datarichiestaiscrizione_soc, dataiscrizione_soc, quotapagata_soc, datadisiscrizione_soc, datarestituzionequota_soc, ckrinunciaquota_soc, motivocessazione_soc, mf_soc, nome_soc, cognome_soc, datanascita_soc, comunenascita_soc, provnascita_soc, paesenascita_soc, cittadinanza_soc, cf_soc, indirizzo_soc, comune_soc, prov_soc, paese_soc, CAP_soc, telefono_soc, altrotel_soc, email_soc, note_soc, img_soc ".
		"FROM tab_anagraficasoci ".
		"WHERE ID_soc = ?;";
		$stmt2 = mysqli_prepare($mysqli, $sql2);
		mysqli_stmt_bind_param($stmt2, "i", $ID_soc);
		mysqli_stmt_execute($stmt2);
		mysqli_stmt_bind_result($stmt2, $ID_soc_det, $ID_fam_soc, $ID_mae_soc, $padremadre_soc, $tipo_soc_det, $datarichiestaiscrizione_soc_det, $dataiscrizione_soc_det, $quotapagata_soc_det,  $datadisiscrizione_soc_det, $datarestituzionequota_soc_det, $ckrinunciaquota_soc_det, $motivocessazione_soc_det, $mf_soc_det, $nome_soc_det, $cognome_soc_det, $datanascita_soc_det, $comunenascita_soc_det, $provnascita_soc_det, $paesenascita_soc_det, $cittadinanza_soc_det, $cf_soc_det, $indirizzo_soc_det, $comune_soc_det, $prov_soc_det, $paese_soc_det, $CAP_soc_det, $telefono_soc_det, $altrotel_soc_det, $email_soc_det, $note_soc_det, $img_soc);
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
			

			
		</ul>

		<div class="tab-content" id="TabsSchedaMaestroContent">

			<?//Tab Dati Anagrafici
			include_once ('21inc_DatiAnagrafici.php');?>


	
			
			
		</div>
	</div>	
	<div style="text-align: center;">
		<div class="alert alert-success" id="alertModificaAnagrafica" style="display: none; width: 500px; text-align: center; margin-top:10px; position: absolute; margin-left: -250px; left: 50% ">
			<h4 style="text-align:center;"> Aggiornamento anagrafica completato con successo!</h4>
		</div>
	</div>
	


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
						nome = $('#nome_soc').val();
						cognome = $('#cognome_soc').val();


						fileName =normalizeName(nome, cognome);

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
		let ID_soc = $("#ID_soc_det_hidden").val();
		if (ID_soc != "") { 
			$("#TabsSchedaSocio").css('display','block');
			let pagtoshow = $("#pagtoshow_hidden").val();
			//$('#TabsSchedaMaestro a:'+pagtoshow).tab('show');
			$("#TabsSchedaSocio a[href='#"+pagtoshow+"']").tab('show');

		}


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

		let img_soc = $('#imgName').val();
		//estraggo tutti i valori da salvare
		let ID_soc = $('#ID_soc_det_hidden').val();
		let nome_soc = $('#nome_soc_det').val();
		let cognome_soc = $('#cognome_soc_det').val();
		let mf_soc = $('#mf_soc_det').val();
		let ID_fam_soc = $('#ID_fam_hidden').val();


		if (img_soc != "") {
			fileName = nome_soc + cognome_soc;
			fileName = fileName.replace(/[\|&;\$%@"<>\(\)\+,]/g, "");
			fileName = fileName.replace ("'", "");
			fileName = fileName.replace (" ", "");
			fileName = fileName.replace ("-", "");
			img_soc = fileName+".png";
		}
		let indirizzo_soc = $('#indirizzo_soc_det').val();
		let comune_soc = $('#comune_soc_det').val();
		let CAP_soc = $('#CAP_soc_det').val();
		let prov_soc = $('#prov_soc_det').val();
		let paese_soc = $('#paese_soc_det').val();
		let cf_soc = $('#cf_soc_det').val();
		let datanascita_soc = $('#datanascita_soc_det').val();
		if (controllaDataNascita(datanascita_soc, 1940, 2010)){
		} else {
			$('#titolo01Msg_OK').html('AGGIORNAMENTO ANAGRAFICA');
			$('#msg01Msg_OK').html("Verificare la data di nascita");
			$('#modal01Msg_OK').modal('show');
			return;
		}
		let comunenascita_soc = $('#comunenascita_soc_det').val();
		let provnascita_soc = $('#provnascita_soc_det').val();
		let paesenascita_soc = $('#paesenascita_soc_det').val();
		let cittadinanza_soc = $('#cittadinanza_soc_det').val();
		let telefono_soc = $('#telefono_soc_det').val();
		let altrotel_soc = $('#altrotel_soc_det').val();
		let note_soc = $('#note_soc_det').val();
		let email_soc = $('#email_soc_det').val();

		
		let tipo_soc =  $("#selectTipoSoc").val();


		let dataiscrizione_soc = $('#dataiscrizione_soc_det').val();
		if (dataiscrizione_soc == undefined) {dataiscrizione_soc = ''}
		if (dataiscrizione_soc == '' || controllaDataNascita(dataiscrizione_soc, 2015, 2035)){
		} else {
			$('#titolo01Msg_OK').html('AGGIORNAMENTO ANAGRAFICA');
			$('#msg01Msg_OK').html("Verificare la data di iscrizione");
			$('#modal01Msg_OK').modal('show');
			return;
		}

		let datadisiscrizione_soc = $('#datadisiscrizione_soc_det').val();
		if (datadisiscrizione_soc == undefined) {datadisiscrizione_soc = ''}
		if (datadisiscrizione_soc == '' ||  controllaDataNascita(datadisiscrizione_soc, 2015, 2035)){
		} else {
			$('#titolo01Msg_OK').html('AGGIORNAMENTO ANAGRAFICA');
			$('#msg01Msg_OK').html("Verificare la data di disiscrizione");
			$('#modal01Msg_OK').modal('show');
			return;
		}

		let datarichiestaiscrizione_soc = $('#datarichiestaiscrizione_soc_det').val();
		if (datarichiestaiscrizione_soc == undefined) {datarichiestaiscrizione_soc = ''}
		if (datarichiestaiscrizione_soc == '' ||  controllaDataNascita(datarichiestaiscrizione_soc, 2015, 2035)){
		} else {
			$('#titolo01Msg_OK').html('AGGIORNAMENTO ANAGRAFICA');
			$('#msg01Msg_OK').html("Verificare la data di richiesta iscrizione");
			$('#modal01Msg_OK').modal('show');
			return;
		}

		let datarestituzionequota_soc = $('#datarestituzionequota_soc_det').val();
		if (datarestituzionequota_soc == undefined) {datarestituzionequota_soc = ''}
		if (datarestituzionequota_soc == '' ||  controllaDataNascita(datarestituzionequota_soc, 2015, 2035)){
		} else {
			$('#titolo01Msg_OK').html('AGGIORNAMENTO ANAGRAFICA');
			$('#msg01Msg_OK').html("Verificare la data di restituzione quota");
			$('#modal01Msg_OK').modal('show');
			return;
		}

		let motivocessazione_soc = $('#motivocessazione_soc_det').val();

		let quotapagata_soc = $('#quotapagata_soc_det').val();

		let ckrinunciaquota_soc = $("#ckrinunciaquota_soc_det").is(":checked");
		if (ckrinunciaquota_soc == false) {ckrinunciaquota_soc = 0;} else {ckrinunciaquota_soc =1;}


		postData = { ID_fam_soc: ID_fam_soc, ID_soc: ID_soc, nome_soc: nome_soc, cognome_soc: cognome_soc, indirizzo_soc: indirizzo_soc, comune_soc: comune_soc, CAP_soc: CAP_soc, prov_soc: prov_soc, paese_soc: paese_soc, mf_soc: mf_soc, cf_soc: cf_soc, datanascita_soc: datanascita_soc, comunenascita_soc: comunenascita_soc, provnascita_soc: provnascita_soc, paesenascita_soc: paesenascita_soc, cittadinanza_soc: cittadinanza_soc, telefono_soc: telefono_soc, altrotel_soc: altrotel_soc, note_soc: note_soc, email_soc: email_soc, img_soc: img_soc, tipo_soc: tipo_soc, dataiscrizione_soc: dataiscrizione_soc, datadisiscrizione_soc: datadisiscrizione_soc, datarichiestaiscrizione_soc: datarichiestaiscrizione_soc, datarestituzionequota_soc: datarestituzionequota_soc, quotapagata_soc: quotapagata_soc, ckrinunciaquota_soc: ckrinunciaquota_soc, motivocessazione_soc: motivocessazione_soc};
		console.log ("21qry_SchedaSocio.php - aggiornaAnagrafica - postData a 21qry_updateAnagraficaSocio.php") ;
		console.log (postData) ;
		$.ajax({
			type: 'POST',
			url: "21qry_updateAnagraficaSocio.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				console.log (data);
				$('#alertModificaAnagrafica').html(data.msg);
				$("#alertModificaAnagrafica").show();
				$("#pagtoshow_hidden").val(pagina);
				setTimeout(function(){requery(); }, 1000);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '21qry_SchedaSocio ##aggiornaAnagrafica##'");      
			}
		});
	}


	

	

	
	$('.search-comune').on("keyup input", function(){
		campo = $(this).attr("name");
		// Get input value on change
		let inputVal = $(this).val();
		switch (campo) {
			case "comunenascita_soc_new":
				resultDropdown = $("#showComuneNascita_new");
			break;
			case "comune_soc_new":
				resultDropdown = $("#showComuneResidenza_new");
			break;
			case "comunenascita_soc_det":
				resultDropdown = $("#showComuneNascita_det");
			break;
			case "comune_soc_det":
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

	
	
		
	$("#mf_soc_det").keypress(function(e){
		let inputValue = event.which;
		// F = 70, M = 77
		if((inputValue != 70) && (inputValue != 77)){ 
			e.preventDefault(); 
		}
	});
</script>

