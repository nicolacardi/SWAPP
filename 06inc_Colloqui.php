		<!-- ********************************************** TAB LISTA D'ATTESA **********************************************-->
		<div class="tab-pane" id="Colloqui">
			<div id="DatiColloqui" style="text-align: center; min-height: 1000px;" >
                <table id="tabellaColloqui" style="display: inline-block;">

                    <thead>
                        <tr>
                            <?//=$ID_fam_alu?>
							<td colspan="9" style="height: 40px; font-size: 16px;">- COLLOQUI -</td>
						</tr>
                        <tr>
                            <th class="w50px">
                                
                            </th>
                            <th class="w80px">
                                <input class="tablelabel4" type="text" value = "visibile a" disabled>
                            </th>
                            <th class="w100px">
                                <input class="tablelabel4" type="text" value = "data Colloquio" disabled>
                            </th>
                            <th class="w100px">
                                <input class="tablelabel4" type="text" value = "tipo Colloquio" disabled>
                            </th>
                            <th class="w80px">
                                <input class="tablelabel4" type="text" value = "richiesto da" disabled>
                            </th>
                            <th class="w120px">
                                <input class="tablelabel4" type="text" value = "Per la scuola" disabled>
                            </th>
                            <th class="w80px">
                                <input class="tablelabel4" type="text" value = "Per famiglia" disabled>
                            </th>
                            <th class="w200px">
                                <input class="tablelabel4" type="text" value = "Note" disabled>
                            </th>
                            <th style="width: 25px">

                            </th>
                        </tr>
                    </thead>
                    <tbody>

                    <?

                    if ($_SESSION['page']== "Scheda Alunno") {
                        $wherePage = " AND visibileda_clq <> 1 ";
                        $page = "CDA";
                    }

                    if ($_SESSION['page']== "I miei Alunni") {
                        $wherePage = " AND visibileda_clq <> 2 ";
                        $page = "COL";
                    }

                    // echo($_SESSION['page']);                    
                    // echo("wherePage".$wherePage."<br>");
                    // echo("page".$page."<br>");
                    // echo("         ID_fam".$ID_fam_alu);
                    //Get colloqui esistenti
                    $sql = "SELECT ID_clq, data_clq, incontrocon_clq, note_clq, ckpadre_clq, ckmadre_clq, richiestoda_clq, tipo_clq, visibileda_clq FROM tab_colloquifam WHERE ID_fam_clq = ? ".$wherePage." ORDER BY data_clq DESC";
                    $stmt = mysqli_prepare($mysqli, $sql);
                    mysqli_stmt_bind_param($stmt, "i", $ID_fam_alu);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $ID_clq, $data_clq, $incontrocon_clq, $note_clq, $ckpadre_clq, $ckmadre_clq, $richiestoda_clq, $tipo_clq, $visibileda_clq);
                    $n = 0;
                    while (mysqli_stmt_fetch($stmt)) {
                        $n++;
                        ?>
                        
                        <tr style="border-bottom: solid 1px grey">
                            <td>

                                <img title="Elimina Colloquio" class="iconaStd" src="assets/img/Icone/times-circle-solid.svg" onclick = "showModalDeleteColloquio(<?=$ID_clq?>);">
                            </td>
                            <td style="text-align: left;  padding-left: 10px;">
                                <?if ($page == "COL"){?>
                                    <input id="ckviscollegio_clq<?=$n?>" value="1" type="radio" name="visibileda_clq<?=$n?>" <?if($visibileda_clq == 1) {echo ('checked');}?> > Collegio<br>
                                <?}?>
                                <?if ($page == "CDA"){?>
                                    <input id="ckvisCDA_clq<?=$n?>" value="2" type="radio" name="visibileda_clq<?=$n?>" <?if($visibileda_clq == 2) {echo ('checked');}?> > Amm.ne<br>
                                <?}?>
                                <input id="ckvistutti_clq<?=$n?>" value="3" type="radio" name="visibileda_clq<?=$n?>" <?if($visibileda_clq == 3) {echo ('checked');}?> > Tutti
                            </td>
                            <td>
                                <input id="data_clq<?=$n?>" class="tablecell6 dpd center" style="border-radius: 3px;" value="<?=timestamp_to_ggmmaaaa($data_clq)?>" type="text">
                            </td>
                            <td>
                                <select  id ="selectTipo_clq<?=$n?>">
                                    <option value="1" <?if ($tipo_clq== 1) {echo('selected');}?>>Pedagogico</option>
                                    <option value="2" <?if ($tipo_clq== 2) {echo('selected');}?>>Amministrativo</option>
                                    <option value="3" <?if ($tipo_clq== 3) {echo('selected');}?>>Medico</option>
                                    <option value="5" <?if ($tipo_clq== 5) {echo('selected');}?>>Informativo</option>
                                    <option value="4" <?if ($tipo_clq== 4) {echo('selected');}?>>Altro</option>
                                </select>
                            </td>
                            <td style="text-align: left;  padding-left: 10px;">
                                <input id="ckscuola_clq<?=$n?>" value="1" type="radio" name="richiestoda_clq<?=$n?>" <?if($richiestoda_clq == 1) {echo ('checked');}?> > scuola<br>
                                <input id="ckfamiglia_clq<?=$n?>" value="2" type="radio" name="richiestoda_clq<?=$n?>" <?if($richiestoda_clq == 2) {echo ('checked');}?> > famiglia
                            </td>
                            <td>
                                <input id="hidden_incontroCon<?=$n?>" value="<?=$incontrocon_clq?>" hidden>
                                <div id="PersonalePresenteCombo<?=$n?>">
                                
                                </div>
                            </td>
                            <td style="text-align: left; padding-left: 10px;">
                                <input id="ckpadre_clq<?=$n?>" type="checkbox" <?if($ckpadre_clq == 1) {echo ('checked');}?> > padre<br>
                                <input id="ckmadre_clq<?=$n?>" type="checkbox" <?if($ckmadre_clq == 1) {echo ('checked');}?> > madre
                             </td>
                            <td >
                                <textarea class="tablecell6" id="note_clq<?=$n?>" type="text" style="border-radius: 3px; overflow-x: hidden; margin-top: 3px; height:55px; min-height: 55px; resize: vertical;"><?=$note_clq?></textarea>
                            </td>
                            <td>
                                <img id="update<?=$n?>" title="Salva Modifiche a Colloquio"  class="iconaStd" src='assets/img/Icone/save-regular.svg' onclick="updateColloquio(<?=$ID_clq?>, <?=$n?>);">
                            </td>   
                            <td style="width: 25px;">
                                <img class="iconaStd" src='assets/img/Icone/pdf.svg' onclick="scaricaColloquioPOST(<?=$ID_clq?>)"></button>
                            </td>
                        </tr>
                        
                    <?
                    
                    }
                    //Infine il record di aggiunta nuovo colloquio
                    ?>
                    <tr>
                        <td>
                           <input id="hidden_ncolloqui" value="<?=$n?>" hidden>
                        </td>
                        <td style="text-align: left;  padding-left: 10px;">
                            <?if ($page == "COL"){?>
                                <input id="ckviscollegio_clq_new" value="1" type="radio" name="visibileda_clqnew" > Collegio<br>
                            <?}?>
                            <?if ($page == "CDA"){?>
                                <input id="ckvisCDA_clq_new" value="2" type="radio" name="visibileda_clqnew" > Amm.ne<br>
                            <?}?>
                            <input id="ckvistutti_clq_new" value="3" type="radio" name="visibileda_clqnew" checked> Tutti
                        </td>
                        <td>
                            <input id="data_clq_new" class="tablecell6 dpd center" style="border-radius: 3px;" type="text">
                        </td>
                        <td>
                            <select  id ="selectTipo_clq_new">
                                <option value="1" >Pedagogico</option>
                                <option value="2" >Amministrativo</option>
                                <option value="3" >Medico</option>
                                <option value="5" >Informativo</option>
                                <option value="4" selected>Altro</option>
                            </select>
                        </td>
                        <td style="text-align: left;  padding-left: 10px;">
                            <input id="ckscuola_clq_new" value="1" type="radio" name="richiestoda_clqnew" checked> scuola<br>
                            <input id="ckfamiglia_clq_new" value="2" type="radio" name="richiestoda_clqnew" > famiglia
                        </td>
                        <td>
                            
                            <div id="PersonalePresenteComboNew">
                                
                            </div>
                        </td>
                        <td style="text-align: left;  padding-left: 10px;">
                            <input id="ckpadre_clq_new" type="checkbox" > padre<br>
                            <input id="ckmadre_clq_new" type="checkbox" > madre
                        </td>
                        <td style="padding-top: 5px;">
                            <textarea class="tablecell6" onkeyup="countChar(this)" id="note_clq_new" type="text" style="border-radius: 3px;  overflow-x: hidden;  height:85px; min-height: 85px; resize: vertical;"></textarea>
                            <div id="charNum" class="charNum"></div>
                        </td>
                        <td>
                            <img id="salva" title="Aggiungi nuovo Colloquio"  class="iconaStd" src='assets/img/Icone/circle-plus.svg' onclick="aggiungiColloquio();">
                        </td>
                    </tr>

                </tbody>
            </table>
			</div>
		</div>

<script>
    $(document).ready(function(){
        PopolaPersonaleCombo ("New", "");
        ncolloqui = $("#hidden_ncolloqui").val();
        for (colloquio = 1; colloquio <= ncolloqui; colloquio++) {
            // console.log ("06inc_ListadAttesaeColloqui.php - document ready colloquio n-esimo chiamata a PopolaPersonalePresente");
            // console.log (colloquio);
            PopolaPersonaleCombo(colloquio, $('#hidden_incontroCon'+colloquio).val())
        }

    })

    function PopolaPersonaleCombo(colloquio, idpersonale_ver) {
		postData = { step: colloquio, idpersonale_ver: idpersonale_ver};
		$.ajax({
			type: 'POST',
			url: "06qry_getPersonale.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#PersonalePresenteCombo"+colloquio).html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '06qry_SchedaAlunno ##fname##'");      
			}
			
		});
	}

    function aggiungiColloquio() {
        ID_fam = $("#hidden_ID_fam").val();             //c'è anche in 02det_IMieiAlunni
        data_clq = $("#data_clq_new").val();
        incontrocon_clq = $("#selectPersonaleNew").val();
        note_clq = $("#note_clq_new").val();
        if( $('#ckpadre_clq_new').is(":checked") ) { ckpadre_clq = 1} else {ckpadre_clq = 0}
        if( $('#ckmadre_clq_new').is(":checked") ) { ckmadre_clq = 1} else {ckmadre_clq = 0}
        richiestoda_clq = $("input[name='richiestoda_clqnew']:checked").val();
        tipo_clq = $('#selectTipo_clq_new').val();
        visibileda_clq = $("input[name='visibileda_clqnew']:checked").val();

        postData = { ID_fam: ID_fam, data_clq: data_clq, incontrocon_clq: incontrocon_clq, note_clq: note_clq, ckpadre_clq: ckpadre_clq, ckmadre_clq: ckmadre_clq, richiestoda_clq: richiestoda_clq, tipo_clq: tipo_clq, visibileda_clq : visibileda_clq };
        
        //console.log('06inc_Colloqui.php - aggiungiColloquio - postData a 06qry_insertColloquio');
        //console.log(postData);
        if (!controllaData(data_clq)) {
            $('#titolo01Msg_OK').html('DATA NON CORRETTA');
            $('#msg01Msg_OK').html("La data ha un formato non valido");
            $('#modal01Msg_OK').modal('show');
            return;
        }
        if (data_clq == "" || incontrocon_clq == "" || note_clq == "" || (ckpadre_clq == 0 && ckmadre_clq == 0)) {
            $('#titolo01Msg_OK').html('INSERIMENTO COLLOQUIO');
            $('#msg01Msg_OK').html("Alcuni dati sono mancanti");
            $('#modal01Msg_OK').modal('show');
            return;
        }
        if (note_clq.length > 4999) {
            $('#titolo01Msg_OK').html('INSERIMENTO COLLOQUIO');
            $('#msg01Msg_OK').html("Il testo delle note non deve superare i 5000 caratteri");
            $('#modal01Msg_OK').modal('show');
            return;
        }
        // console.log ("06inc_ListadAttesaeColloqui.php - aggiungiColloquio: postData a 06qry_insertColloquio.php");
        // console.log (postData);
        $.ajax({
            type: 'POST',
            url: "06qry_insertColloquio.php",
            data: postData,
            dataType: 'json',
            success: function(data){
                //console.log(data.test);
                $("#pagtoshow_hidden").val("Colloqui"); //c'è anche in 02det_IMieiAlunni!!!
                qualeRequery();
            },
            error: function(){
                alert("Errore: contattare l'amministratore fornendo il codice di errore '06inc_ListadAttesaeColloqui aggiungiColloquio'"); 
            }
        });
        
        
    }

    // $(document).keydown(function(e) {
    //     if ('#modal01Msg_OK').hasClass('in') return;
    // // handle keydown event
    // } 

    function updateColloquio(ID_clq, n) {

        data_clq = $("#data_clq"+n).val();
        console.log(data_clq);
        incontrocon_clq = $("#selectPersonale"+n).val();
        note_clq = $("#note_clq"+n).val();
        if( $('#ckpadre_clq'+n).is(":checked") ) { ckpadre_clq = 1} else {ckpadre_clq = 0}
        if( $('#ckmadre_clq'+n).is(":checked") ) { ckmadre_clq = 1} else {ckmadre_clq = 0}

        richiestoda_clq = $("input[name='richiestoda_clq"+n+"']:checked").val();
        tipo_clq = $('#selectTipo_clq'+n).val();
        visibileda_clq = $("input[name='visibileda_clq"+n+"']:checked").val();
        postData = { ID_clq: ID_clq, data_clq: data_clq, incontrocon_clq: incontrocon_clq, note_clq: note_clq, ckpadre_clq: ckpadre_clq, ckmadre_clq: ckmadre_clq, richiestoda_clq: richiestoda_clq, tipo_clq: tipo_clq, visibileda_clq: visibileda_clq};
        console.log('06inc_Colloqui.php - updateColloquio - postData a 06qry_updateColloquio');
        console.log(postData);
        if (!controllaData(data_clq)) {
            $('#titolo01Msg_OK').html('DATA NON CORRETTA');
            $('#msg01Msg_OK').html("La data ha un formato non valido");
            $('#modal01Msg_OK').modal('show');
            return;
        }
        if (data_clq == "" || incontrocon_clq == "" || note_clq == "" || (ckpadre_clq == 0 && ckmadre_clq == 0)) {
            $('#titolo01Msg_OK').html('INSERIMENTO COLLOQUIO');
            $('#msg01Msg_OK').html("Alcuni dati sono mancanti");
            $('#modal01Msg_OK').modal('show');
            return;
        }
        if (note_clq.length > 4999) {
            $('#titolo01Msg_OK').html('INSERIMENTO COLLOQUIO');
            $('#msg01Msg_OK').html("Il testo delle note non deve superare i 5000 caratteri");
            $('#modal01Msg_OK').modal('show');
            return;
        }
        $.ajax({
            type: 'POST',
            url: "06qry_updateColloquio.php",
            data: postData,
            dataType: 'json',
            success: function(data){
                //console.log(data.test);
                $("#pagtoshow_hidden").val("Colloqui");//C'è anche in 02det_IMieiAlunni!!!
                qualeRequery();
            },
            error: function(){
                alert("Errore: contattare l'amministratore fornendo il codice di errore '06inc_ListadAttesaeColloqui aggiungiColloquio'"); 
            }
        });

    }

    function showModalDeleteColloquio(ID_clq) {
		$('#msg03Msg_OKCancelPsw').html("Sei sicuro di voler eliminare questo colloquio?");
		$("#btn_OK03Msg_OKCancelPsw").attr("onclick","deleteColloquio("+ID_clq+");");
		$("#btn_OK03Msg_OKCancelPsw").show();
		$("#titolo03Msg_OKCancelPsw").html('ELIMINAZIONE COLLOQUIO');
		$("#btn_cancel03Msg_OKCancelPsw").html('Annulla');
		$("#remove-content03Msg_OKCancelPsw").show();
		$("#alertCont03Msg_OKCancelPsw").removeClass('alert-success');
		$("#alertCont03Msg_OKCancelPsw").addClass('alert-danger');
		$("#alertCont03Msg_OKCancelPsw").hide();
		$("#passwordDelete").val("");
		$('#modal03Msg_OKCancelPsw').modal('show');
    }

    function deleteColloquio(ID_clq) {
        let psw = $("#passwordDelete").val();
		let pswOperazioni1 = $("#pswOperazioni1").val();
		if (psw == null || psw == "" || psw !=pswOperazioni1 ) {
			$("#alertMsg03Msg_OKCancelPsw").html('Password Errata!');
			$("#alertCont03Msg_OKCancelPsw").show();
		}	else  {
            postData = { ID_clq: ID_clq };
            // console.log ("06inc_ListadAttesaeColloqui.php - deleteColloquio: postData a 06qry_deleteColloquio.php");
            // console.log (postData);
            $.ajax({
                type: 'POST',
                url: "06qry_deleteColloquio.php",
                data: postData,
                dataType: 'json',
                success: function(data){
                    $("#remove-content03Msg_OKCancelPsw").slideUp();
					$("#alertMsg03Msg_OKCancelPsw").html('Colloquio eliminato!');
					$("#alertCont03Msg_OKCancelPsw").removeClass('alert-danger');
					$("#alertCont03Msg_OKCancelPsw").addClass('alert-success');
					$("#alertCont03Msg_OKCancelPsw").show();
					$("#btn_cancel03Msg_OKCancelPsw").html('Chiudi');
					$("#btn_OK03Msg_OKCancelPsw").hide();

                    $("#pagtoshow_hidden").val("Colloqui");//C'è anche in 02det_IMieiAlunni!!!
                    qualeRequery();
                },
                error: function(){
                    alert("Errore: contattare l'amministratore fornendo il codice di errore '06inc_ListadAttesaeColloqui deleteColloquio'"); 
                }
            });
        }
    }

    function qualeRequery() {
        page = $("#hidden_page").val();
        //console.log(page);
        if (page == "SchedaAlunno") {
            requery();
        }
        if (page == "IMieiAlunni") {
            let ID_alu_cla = $('#hidden_ID_alu').val();
            requeryDettaglio(ID_alu_cla);
        }

    }
	function scaricaColloquioPOST (ID_clq){

		let url = "06downloadColloquio.php";
		let form = $('<form target="_blank" action="' + url + '"method="post"></form>');
		
		let input = $("<input>")
		.attr("type", "text")
		.attr("name", "ID_clq")
		.val(ID_clq);
		$(form).append($(input));
		
		form.appendTo( document.body );
		$(form).submit();
	}

    function countChar(val) {
        var len = val.value.length;
        if (len > 5000) {
          val.value = val.value.substring(0, 5000);
        } else {
          $('#charNum').text((5000 - len)+ "\n car. rimanenti");
        }
      };
</script>