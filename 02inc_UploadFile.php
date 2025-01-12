
			
<!-- ********************************************** TAB UPLOAD FILE **********************************************-->
<div class="tab-pane active" id="UploadFile">
	<div class="col-md-12 center" style="margin-left: 20px; margin-bottom: 20px;">
		<div class="row mt10">
			<div class="col-md-3">
				<button class="btnBlu w200px" onclick="showModalUploadFile();">Carica Nuovo Documento</button>
			</div>
		</div>
	</div>


	<div style="text-align:center; margin-top: 20px;">
		<table id="tabellaSetDocumenti" style="display: inline-block">
			<thead>
				<tr>
					<th style="width:22px;">
					</th>
					<th style="width:25px;">
					</th>
					<th style="width:45px;">
					</th>
					<th>
						<input class="tablelabel0 w200px" type="text" value ="Nome File" disabled>
					</th>
					<th>
						<input class="tablelabel0 w100px" type="text" value="Tipo" disabled>
					</th>
					<th>
						<input class="tablelabel0 w300px" type="text" value="Descrizione" disabled>
					</th>
					<th>
						<input class="tablelabel0 w100px" type="text" value="Data" disabled>
					</th>
					<th style="width:50px;">
            			<input class="tablelabel0 w50px" type="text" value="Scarica" disabled>
        			</th>
				<tr>
					<th style="width:22px;">
					</th>
					<th style="width:25px;">
					</th>
					<th style="width:45px;">
					</th>
					<th>
						<button id="ordinacampo1Doc" class="ordinabutton" onclick="ordinaDoc(1);" >--</button>
					</th>
					<th>
						<button id="ordinacampo2Doc" class="ordinabutton" onclick="ordinaDoc(2);" >--</button>
					</th>
					<th>
						<button id="ordinacampo3Doc" class="ordinabutton" onclick="ordinaDoc(3);" >--</button>
					</th>
					<th>
						<button id="ordinacampo4Doc" class="ordinabutton" onclick="ordinaDoc(4);" >--</button>
					</th>

			</thead>
			<tbody class="scroll" id="maintableDoc">

			<?include_once ('02qry_SetDocumenti.php');?>
			</tbody>
		</table>
	</div>
</div>

<script>



	function ordinaDoc(x) {
		let az_za_ord = $('#ordinacampo'+x+'Doc').text();
		if (az_za_ord == 'az') { $('#ordinacampo'+x+'Doc').text('za'); }
		if (az_za_ord == 'za') { $('#ordinacampo'+x+'Doc').text('--'); }
		if (az_za_ord == '--') { $('#ordinacampo'+x+'Doc').text('az');}
		requerySetDocumenti();
	}

	function requerySetDocumenti(){

		let ord1 = $('#ordinacampo1Doc').text();
		let ord2 = $('#ordinacampo2Doc').text();
		let ord3 = $('#ordinacampo3Doc').text();
		let ord4 = $('#ordinacampo4Doc').text();
		let ID_alu_doc = $("#hidden_ID_alu").val();
		postData = {ord1: ord1, ord2: ord2, ord3: ord3, ord4: ord4, ID_alu_doc: ID_alu_doc};
		console.log ("*********02inc_UploadFile.php - requerySetDocumenti - postData a 02qry_SetDocumenti.php");
		console.log (postData);
		$.ajax({
			type: 'POST',
			url: "02qry_SetDocumenti.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#maintableDoc").html(html);
				console.log ("##########02inc_UploadFile.php - requerySetDocumenti - ritorno da 02qry_SetDocumenti.php");
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '15AdmTools ##requerySetDocumenti##'");     
			}
		});
	}


	function convertandupload() {
		let fileInput = document.getElementById('fileInput');
		let file = fileInput.files[0];
		descrizione_doc =  $('#descrizione_doc').val();
		let ID_alu_doc = $("#hidden_ID_alu").val();

		if (!descrizione_doc) {
			descrizione_doc = "###";
		}

		if (!file) {
			alert('Seleziona un file PDF prima di procedere.');
			return;
		}

		// // Verifica che il file sia un PDF
		// if (file.type !== 'application/pdf') {
		// 	alert('Il file selezionato non è un PDF.');
		// 	return;
		// }


		const allowedExtensions = ['pdf', 'p7m'];
		const fileExtension = file.name.split('.').pop().toLowerCase();

		if (!allowedExtensions.includes(fileExtension)) {
			alert('Il file selezionato non è supportato. Carica un file PDF o .p7m.');
			return;
		}




		const maxFileSize = 2000 * 1024; // 2000KB in byte
		if (file.size > maxFileSize) {
			alert('Il file selezionato supera la dimensione massima di 1Mb.');
			return;
		}

		// Converti il file in Base64
		let reader = new FileReader();
		reader.onload = function(event) {
			let contenuto_doc = event.target.result.split(',')[1];
			let titolo_doc = file.name;
			let tipo_doc =  $('#tipo_doc').val();
			let uploadDateLong = new Date().toISOString();
			let data_doc = timestampToDate(uploadDateLong);

			postData = {
				ID_alu_doc : ID_alu_doc,
				titolo_doc: titolo_doc,
				tipo_doc: tipo_doc,
				descrizione_doc: descrizione_doc,
				contenuto_doc: contenuto_doc,
				data_doc: data_doc
			};

			console.log ("15AdmTools.php - convertandupload - postData a 15qry_convertandupload.php");
			console.log (postData);

			$.ajax({
				type: 'POST',
				url: '15qry_convertandupload.php',
				data: postData,
				dataType: 'json',
				success: function(data) {
					
					//alert('File caricato con successo!');
					$("#remove-contentFU").slideUp();
					$("#alertaggiungiFU").html(data.msg);
					$("#alertaggiungiFU").show();
					$("#btn_cancelUploadFile").removeClass('pull-left');
					$("#btn_cancelUploadFile").html('Chiudi');
					$("#btn_OKUploadFile").hide();
					requerySetDocumenti();
					
				},
				error: function() {
					alert("Errore: contattare l'amministratore fornendo il codice di errore '15AdmTools ##convertandupload##'");
				}
			});
		};

		reader.onerror = function() {
			alert('Errore nella lettura del file. Riprova.');
		};

		reader.readAsDataURL(file);

	}

	// Aggiunge un listener per l'input file
	if (typeof fileInputEl === 'undefined') {
    const fileInputEl = document.getElementById('fileInput');
    fileInputEl.addEventListener('change', convertandupload);
}

	function showModalUploadFile() {
		document.getElementById("form_FileUpload").reset();
		$("#remove-contentFU").show();
		$("#alertaggiungiFU").hide();
		$("#btn_cancelUploadFile").html('Annulla');
		$("#btn_OKUploadFile").show();
		$('#btn_cancelUploadFile').addClass("pull-left");
		$('#modalFileUpload').modal({show: 'true'});
	}


	function setValoreDoc(ID_doc) {

		let descrizione_doc = $('#descrizione_doc'+ID_doc).val();

		postData = { ID_doc: ID_doc, descrizione_doc: descrizione_doc};
		 console.log ("02inc_UploadFile.php - setValoreDoc - postData a 02qry_updateDocumento.php");
		 console.log (postData);
		$.ajax({
			type: 'POST',
			url: "02qry_updateDocumento.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				 console.log ("02inc_UploadFile.php - setValoreDoc - ritorno da 02qry_updateDocumento.php");
                 console.log (data.test);

			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '02qry_SetDocumenti ##setValoreDoc##'");     
			}
		});
	}



	function showModalDeleteThisRecord(ID_doc) {
		$('#msg03Msg_OKCancelPsw').html("Sei sicuro di voler eliminare questo documento?");
		$("#btn_OK03Msg_OKCancelPsw").attr("onclick","deleteThisRecord("+ID_doc+");");
		$("#btn_OK03Msg_OKCancelPsw").show();
		$("#titolo03Msg_OKCancelPsw").html('ELIMINAZIONE DOCUMENTO');
		$("#btn_cancel03Msg_OKCancelPsw").html('Annulla');
		$("#remove-content03Msg_OKCancelPsw").show();
		$("#alertCont03Msg_OKCancelPsw").removeClass('alert-success');
		$("#alertCont03Msg_OKCancelPsw").addClass('alert-danger');
		$("#alertCont03Msg_OKCancelPsw").hide();
		$("#passwordDelete").val("");
		$('#modal03Msg_OKCancelPsw').modal('show');
	}

	function deleteThisRecord(ID_doc) {
		let psw = $("#passwordDelete").val();
		let pswOperazioni1 = $("#pswOperazioni1").val();
		if (psw == null || psw == "" || psw !=pswOperazioni1 ) {
			$("#alertMsg03Msg_OKCancelPsw").html('Password Errata!');
			$("#alertCont03Msg_OKCancelPsw").show();
		}	else  {
			$('.upper').css('height', '100%');
			$('.lower').css('height', '0%');
			$('#mat_icon_det').removeClass('fa-angle-double-up');
			$('#mat_icon_det').addClass('fa-angle-double-down');
			postData = { ID_doc: ID_doc};
			$.ajax({
				type: 'POST',
				url: "02qry_deleteDocumento.php",
				data: postData,
				dataType: 'json',
				success: function(){
					$("#remove-content03Msg_OKCancelPsw").slideUp();
					$("#alertMsg03Msg_OKCancelPsw").html('Documento eliminato!');
					$("#alertCont03Msg_OKCancelPsw").removeClass('alert-danger');
					$("#alertCont03Msg_OKCancelPsw").addClass('alert-success');
					$("#alertCont03Msg_OKCancelPsw").show();
					$("#btn_cancel03Msg_OKCancelPsw").html('Chiudi');
					$("#btn_OK03Msg_OKCancelPsw").hide();
					requerySetDocumenti();
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '02inc_UploadFile ##deleteThisRecord##'");      
				}
			});
		}
	}

	function downloadFile(ID_doc) {
		postData = { ID_doc: ID_doc};
		console.log ("02inc_UploadFile.php - downloadFile - postData a  02qry_downloadFile.php");
		console.log (postData);
		$.ajax({
			type: 'POST',
			url: '02qry_downloadFile.php',
			data: postData,
			dataType: 'json',
			success: function(data) {
				console.log ("02inc_UploadFile.php - downloadFile - ritorno da 02qry_downloadFile.php");
				console.log (data);
				if (data.success) {
					// Creare un blob dal contenuto Base64

					let mimeType = 'application/pdf'; // Default per PDF
					if (data.titolo_doc.endsWith('.p7m')) {
						mimeType = 'application/octet-stream'; // Tipo generico per file binari
					}

					const byteCharacters = atob(data.contenuto_doc);
					const byteNumbers = new Array(byteCharacters.length).fill().map((_, i) => byteCharacters.charCodeAt(i));
					const byteArray = new Uint8Array(byteNumbers);
					const blob = new Blob([byteArray], { type: mimeType });

					// Creare un link per il download
					const link = document.createElement('a');
					link.href = window.URL.createObjectURL(blob);
					link.download = data.titolo_doc;
					link.click();

					// Liberare la memoria
					window.URL.revokeObjectURL(link.href);
					// Messaggio per file .p7m
					if (data.titolo_doc.endsWith('.p7m')) {
						alert('Hai scaricato un file .p7m. Per aprirlo, utilizza un software per la verifica delle firme digitali.');
					}
				} else {
					alert('Errore durante il download del file. Contatta l\'amministratore.');
				}
			},
			error: function() {
				alert('Errore: contattare l\'amministratore fornendo il codice di errore "02qry_getFileContent ##downloadFile##".');
			}
		});
	}

</script>


						



			