<? 
	include_once("database/databaseii.php");		


	$sql = "SELECT img_alu, nome_alu, cognome_alu FROM tab_anagraficaalunni WHERE ID_alu = 139";
	$stmt = mysqli_prepare($mysqli, $sql);
	//mysqli_stmt_bind_param($stmt, "i", $ID_alu);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $img_aluTMP, $nome_aluTMP, $cognome_aluTMP);
	//mysqli_stmt_store_result($stmt); //serve per contare i record
	//$query_num_rows = mysqli_stmt_num_rows($stmt);
	
	while (mysqli_stmt_fetch($stmt)) {
	
			$img_alu = $img_aluTMP;
			$nome_alu = $nome_aluTMP;
			$cognome_alu = $cognome_aluTMP;
	
	}
	if ($img_alu == "") { $img_alu = "bbjpg.png"; }


?>


<!DOCTYPE html>
<html>
<head>
	<!--RIGA PRESENTE IN PAGINA DOVE CROPPIE FUNZIONAVA -->
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/overcast/jquery-ui.css" type="text/css" rel="stylesheet">
	
	<title>ProvaCroppie</title>
	<script src="assets/jquery/jquery-3.3.1.js" type="text/javascript"></script>
    <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<script src="assets/bootstrap/bootstrap.min.js" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/solid.css" integrity="sha384-VGP9aw4WtGH/uPAOseYxZ+Vz/vaTb1ehm1bwx92Fm8dTrE+3boLfF1SpAtB1z7HW" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/fontawesome.css" integrity="sha384-1rquJLNOM3ijoueaaeS5m+McXPJCGdr5HcA03/VHXxcp2kX2sUrQDmFc3jR5i/C7" crossorigin="anonymous">


</head>


	
<body>


		<!--imgContainer contiene la foto trovata in db-->
		<img id="imgContainer" style="border 1px, black;" width="100" height="100" alt="" src="assets/photos/imgs/<?=$img_alu;?>" data-src="assets/photos/imgs/<?=$img_alu;?>" data-src-retina="assets/photos/imgs/<?=$img_alu;?>"> 
		
		
		
		<!--imgName è una input dove viene scritto il nome del file caricato-->
		<input class="form-control" id="imgName" style="border-radius: 10px; text-align:center; height:34px; padding:6px 12px;" name="imgName" maxlength="30" placeholder="immagine" value="<? if (isset($img_alu)){echo $img_alu;}  else { echo 'unknown.png';}?>" >
		
		<!--il bottone seguente lancia il form di Crop-->
		<button type="Button" data-toggle="modal" id="launchModalCrop" data-target="#modalFormCroppie" style=" background: grey; color:#FFF; width:100%; text-align:center; margin-top:10px;">
		launchModalCrop
		</button>

		<!--il bottone seguente lancia il caricamento in db dell'immagine croppata-->
		<!--<input type="submit" class="btn btn-primary btn-cons" value="Salva" style="border-radius:15px; background: grey;" onclick="uploadImgFirst();"></input>-->




<link rel="stylesheet" href="assets/croppie/croppie.css" />
<script src="assets/croppie/croppie.js"></script>



	
	
<!-- modalFormCroppie -->


<div class="modal" id="modalFormCroppie" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" style="width:435px;">
        	<div class="modal-header" style="padding-bottom:600px; text-align: center;">
				<span class="hashtags header_popup" >
						<img src="assets/img/icon-Crop.png" width="20px" style="margin-right:5px;"/>
						Selezione e Crop Immagine
				</span>
            	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>

            	<div class="col-md-12" style="text-align: center;">
					<div class="col-md-12 text-center" style="text-align: center;">
						<!--uploadCrop è la zona di oreview dentro Croppie-->
						<div class= "uploadCrop" id="uploadCrop" style="width:350px; text-align: center;">
	
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="col-md-12">
							
							<!-- la input dove viene scritto il nome del file estratto dal db nel modale-->
							<input class="form-control" id="filenametosave" style="border-radius: 10px; text-align:center; height:34px; padding:6px 12px;" name="filenametosave" value = "<?=$img_alu;?>" disabled> 
							
							<!-- di seguito la label carina usata per il bottone di caricamento upload-->
							<label for="imgSelezioneInModale" style=" background: grey; color:#FFF; width:100%; text-align:center; margin-top:10px;">imgSelezioneInModale</label>
							<input type="file" id="imgSelezioneInModale" accept="image/*" >
							
							<!-- la input dove viene scritto il nome del file nel form modale-->
							<input id="imgNameModal" name="imgNameModal" maxlength="30" placeholder="immagine"> 
							<br/>
							<button data-dismiss="modal" id="imgProcediconCrop" style=" background: grey; color:#FFF; width:100%; text-align:center; margin-top:10px;">imgProcediconCrop</button>	
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
							var num = Math.random();
							$uploadCrop.croppie('bind', {
							url: 'assets/photos/imgs/'+imgName+"?"+num,
							}).then(function(){
									//jQuery('.cr-image').css('opacity', '1'); //non mi ricordo cosa sia
									//enforceBoundary = true;
							});
						}

					});

					//Viene lanciata in fase di caricamento di "ALTRA" immagine rispetto a quella eventualmente già in database
					//viene lanciata in fase di change dell'input file #upload
					$('#imgSelezioneInModale').on('change', function () {
						fileName = $('#imgSelezioneInModale')[0].files[0].name;
						
						$("#imgNameModal").val(fileName);
						var reader = new FileReader();
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
		
					$('#imgProcediconCrop').on('click', function (ev) {
						

						fileName = $("#filenametosave").val();
						if (fileName == "bbjpg.png") {
							nome = '<?=$nome_alu?>';
							cognome = '<?=$cognome_alu?>';
							fileName = nome + cognome+".tmp";
						}
						
						//prepara l'immagine croppata in forma base64 e la mette nella variabile resp
						
						$uploadCrop.croppie('result', {
							type: 'base64',
							size: 'viewport'
						}).then(function (resp) {
							//la ajax che segue manda a croppieupload che EFFETTUA l'UPLOAD dell'immagine passata in base 64 con il nome fileName nella cartella assets/photos/imgs
							$.ajax({
								url: "croppieupload.php",
								type: "POST",
								data: {"image":resp, "filenametosave": fileName, "foldertoupload": 'assets/photos/imgs'},
								success: function (data) {
									fileName = fileName.split('.').slice(0, -1).join('.');
									//fileName = fileName.replace(/[^A-Za-z0-9]/g, '');				//elimina caratteri strani
									var imgtoupdate = document.getElementById('imgContainer');
									var num = Math.random(); 										//serve per caricare immagine indipendentemente dal fatto che sia già in cache
									imgtoupdate.src = "assets/photos/imgs/"+fileName+".png?"+num;  //riapplica estensione
									var imgNameElement = document.getElementById('imgName');
									imgNameElement.value = fileName+".png?"+num;
									
									//$('#modalFormCroppie').modal('hide');

								}
							});
						});
						
						//ora devo anche salvare in database il valore
					});
		
		
		
				function removeExtension(filename){
					var lastDotPosition = filename.lastIndexOf(".");
					if (lastDotPosition === -1) return filename;
					else return filename.substr(0, lastDotPosition);
				}
</script>


			</div>
        </div>
        <!-- /.modal-content -->
	</div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!---------------------------------------- FINE CROPPIE----------------------------------------------------------------->






</body>
</html>


<script>
		
		
		/*function uploadImgFirst(){

			//*****************Upload dell'immagine contact*****************
				var files = document.getElementById('imgFindButton').files; // Prendo tutti i file dell'id file-uploadcont
				var ajaxData2 = new FormData(); // Inizializzo un formData
				var file = files[0]; // prendo il primo soltanto dei file se ce ne sono più di uno
				
				if (file === undefined) {
					
				} else {
					
					var fileCont = file.name;
					fileCont = removeExtension (fileCont); 							//elimina estensione
					fileCont = fileCont.replace(/[^A-Za-z0-9]/g, '');				//elimina caratteri strani
					// num random serve a sovrascrivere la cache
					var num = Math.random();
					fileCont = fileCont+"?"+num;
			
					document.getElementById('imgName').value = fileCont;
					ajaxData2.append('imgFindButton', file, file.name);
					// debug
					//for (var pair of ajaxData2.entries()) {
					//	console.log(pair[0]+ ', ' + pair[1]+ ', ' + pair[2]); 
					//}
					
					$.ajax({
						url: "ajax/ajax_upload_file_cont.php",
						type: "POST",
						data: ajaxData2,
						contentType: false,
						cache: false,
						processData:false,
						success: function(data){
							//alert ("file caricato");
						}
					});
				}
				//*****************Fine upload dell'immagine shop*****************
		}*/
		

		
	/*function resetForm(form) {
    // clearing inputs
    var inputs = form.getElementsByTagName('input');
    for (var i = 0; i<inputs.length; i++) {
        switch (inputs[i].type) {
            // case 'hidden':
            case 'text':
                inputs[i].value = '';
                break;
            case 'radio':
            case 'checkbox':
                inputs[i].checked = false;
			case 'password':
                inputs[i].value = '';
        }
    }

    // clearing selects
    var selects = form.getElementsByTagName('select');
    for (var i = 0; i<selects.length; i++)
        selects[i].selectedIndex = 0;

    // clearing textarea
    var text= form.getElementsByTagName('textarea');
    for (var i = 0; i<text.length; i++)
        text[i].innerHTML= '';
	
	rndnum = Math.floor(Math.random() * 4) + 1; 
	document.getElementById("imgContainer").src ="assets/photos//unknown"+rndnum+".png";
	document.getElementById("imgFindButton").value ="";
	document.getElementById("imgName").value ="unknown"+rndnum+".png";
	
	
	var selects = document.forms["soloidcontact"].getElementsByTagName("select");
		for (var i = 0; i<selects.length; i++)
    selects[i].selectedIndex = 0;
	
    return false;
}*/
</script>
