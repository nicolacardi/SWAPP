<?	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	/* ora costruisco la clasuola ORDER BY sulla base di tutti i valori di ord */
	if (isset ($_POST['ord1'])){
		$ord1 = $_POST['ord1'];
		$ordsql = orderbysql( $ord1, 'titolo_doc', $ordsql);
	} 
	if (isset ($_POST['ord2'])){
		$ord2 = $_POST['ord2'];
		$ordsql = orderbysql( $ord2, 'descrizione_doc', $ordsql);
	} 

	function orderbysql ($ord, $campo, $ordsq) {
		switch ($ord) {
			case '--' :
				break;
			case 'az' :
				$ordsq = $ordsq . ' , '. $campo. ' '. 'ASC ' ;
				break;
			case 'za':
				$ordsq = $ordsq . ' , '. $campo. ' '. 'DESC ' ;
				break;
		}
		return $ordsq;
	}
	if ($ordsql == '') {
		$ordsql = ' ORDER BY ID_doc';
	} else {
		$ordsql = ' ORDER BY ' .  substr($ordsql, 2) ;
	}
	$sql = "SELECT ID_doc, titolo_doc, descrizione_doc FROM tab_documenti ".$ordsql;
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_doc, $titolo_doc, $descrizione_doc );
	$riga =  0;
	while (mysqli_stmt_fetch($stmt))
	{ 	$riga++;?>
		<tr>
			<td style="width:22px;">
				<img title='Cancella Documento <?=$ID_doc?>' style="width: 20px; cursor: pointer" src='assets/img/Icone/times-circle-solid.svg'' onclick="deleteDoc(<?=$ID_doc?>);">
			</td>
			<td style="width:22px;">
			</td>
			<td style="width:45px;">
				<button  id="goto<?=$ID_doc?>" style="width: 30px; font-size: 12px;" onclick="mostraInTinyMCE(<?=$ID_doc?>, '<?=$titolo_doc?>')"><?=$riga?></button>
			</td>
			<td>
				<input class="tablecell6 disab w200px" type="text"  id="titolo_doc<?=$ID_doc?>" value = "<?=$titolo_doc?>" disabled>
			</td>
			<td>
				<input class="tablecell6 disab" style="padding-left: 4px; padding-right: 5px; text-align: left; width: 300px; font-size: 10px; height: 24px;" type="text" id="descrizione_doc<?=$ID_doc?>" title = "<?=utf8_decode($descrizione_doc)?>" value = "<?=utf8_decode($descrizione_doc)?>" onchange="setValoreDoc(<?=$ID_doc?>)">
				
			</td>
		</tr>
	<?}?>
<script>

	function setValoreDoc(ID_doc) {
		let descrizione_doc = $('#descrizione_doc'+ID_doc).val();
		let titolo_doc = $('#titolo_doc'+ID_doc).val();
		postData = { ID_doc: ID_doc, titolo_doc: titolo_doc, descrizione_doc: descrizione_doc};
		//  console.log ("15qry_SetDocumenti.php - setValoreDoc - postData a 15qry_updateDocumento.php");
		//  console.log (postData);
		$.ajax({
			type: 'POST',
			url: "15qry_updateDocumento.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				//  console.log ("15qry_SetDocumenti.php - setValoreDoc - ritorno da 15qry_updateDocumento.php");
                //  console.log (data.test);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '15qry_SetParametri ##fname##'");     
			}
		});
	}

    function mostraInTinyMCE (ID_doc, titolo_doc) {
        $("#ID_doc_hidden").val(ID_doc);
        $("#titolo_doc").val(titolo_doc);
		postData = { ID_doc: ID_doc};
        //  console.log ("15qry_SetDocumenti.php - mostraInTinyMCE - postData a 15qry_getContenutoDoc.php");
		//  console.log (postData);
        $.ajax({
			type: 'POST',
			url: "15qry_getContenutoDoc.php",
			data: postData,
			dataType: 'json',
			success: function(data){
    			// console.log ("15qry_SetDocumenti.php - mostraInTinyMCE - ritorno da 15qry_getContenutoDoc.php");
                // console.log (data);

                tinymce.get("editor").setContent(data.contenuto_doc);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '15qry_SetParametri ##fname##'");     
			}
		});
        
    }

    function salvaTinyMCE(){
		tinyMCE.triggerSave();
		contenuto_doc = $("textarea#editor").val();  
        ID_doc = $("#ID_doc_hidden").val();
        postData = { ID_doc: ID_doc, contenuto_doc: contenuto_doc};
		console.log ("15qry_SetDocumenti.php - salvaTinyMCE - post a 15qry_setContenutoDoc.php");
        console.log (postData);
		$.ajax({
			type: 'POST',
			url: "15qry_setContenutoDoc.php",
			data: postData,
			dataType: 'json',
			success: function(data){
    			// console.log ("15qry_SetDocumenti.php - salvaTinyMCE - ritorno da 15qry_getContenutoDoc.php");
                // console.log (data);
                $("#alertModificaDocumento").show();
                setTimeout(function(){$("#alertModificaDocumento").hide();; }, 1000);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '15qry_SetParametri ##fname##'");     
			}
		});
	}


</script>
