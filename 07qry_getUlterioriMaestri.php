<?  include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");

    $data = $_POST['data'];
    $ora = $_POST['ora'];
    $classe = $_POST['classe'];
    $sezione = $_POST['sezione'];
    $j = $_POST['j'];
    $x = $_POST['x'];
    ?>
    <table id="tabellaUlterioriMaestri" style="display: inline-block; margin-top: 20px;">
        <thead style="font-size: 10px;">
            <tr>
                <th style="width: 25px">
                </th>
                <th style="width:180px">
                    <input class="tablelabel0 w100" type="text" value = "MATERIA ulteriore" readonly>
                </th>
                <th style="width:180px">
                    <input class="tablelabel0 w100" type="text" value = "Maestro" readonly>
                </th>
                <th style="width: 45px">
                    
                </th>
                <th style="width:180px">
                    <input class="tablelabel0 w100" type="text" value = "Tutor Materia/Classe/Maestro" readonly>
                </th>
                <th style="width: 80px">
                    <input class="tablelabel0 w100" type="text" value = "Firma Tutor" readonly>
                </th>

            </tr>
        </thead>


        <tbody>	
            
            <?

            $sql3 = "SELECT codmat_mtt, descmateria_mtt FROM tab_materie ORDER BY ord_mtt";
            $stmt3 = mysqli_prepare($mysqli, $sql3);
            mysqli_stmt_execute($stmt3);
            mysqli_stmt_bind_result($stmt3, $codmat_mtt, $descmateria_mtt);
            $nummaterie = 1;
            while (mysqli_stmt_fetch($stmt3)) {
                $codmat_mttA[$nummaterie] = $codmat_mtt;
                $descmateria_mttA[$nummaterie] =$descmateria_mtt;
                $nummaterie++;
            }


            $sql3 = "SELECT annoscolastico_asc FROM tab_anniscolastici WHERE datainizio_asc <= ? AND datafine_asc > ?";
            //attenzione: d'estate questa query non darà risultati! ci vorrebbe anche una datafineanno diversa da datafine_asc!
            $stmt3 = mysqli_prepare($mysqli, $sql3);
            mysqli_stmt_bind_param($stmt3,  "ss", $data, $data);
            mysqli_stmt_execute($stmt3);
            mysqli_stmt_bind_result($stmt3, $annoscolastico_asc);
            while (mysqli_stmt_fetch($stmt3)) {
            }
        


            $sql2 = "SELECT ID_ora, data_ora, ora_ora, IDfirmatutor_ora, codmat_ora, ID_mae, nome_mae, cognome_mae, firma_mae_ora, argomento_ora, assente_ora, secondomaestro_ora  FROM tab_orario LEFT JOIN tab_anagraficamaestri ON ID_mae = ID_mae_ora WHERE data_ora = ? AND ora_ora = ? AND classe_ora = ? AND sezione_ora= ? AND secondomaestro_ora = 1 AND codmat_ora <> 'TUX'";
            $stmt2 = mysqli_prepare($mysqli, $sql2);
            mysqli_stmt_bind_param($stmt2,  "siss", $data, $ora, $classe, $sezione);
            mysqli_stmt_execute($stmt2);
            mysqli_stmt_bind_result($stmt2, $ID_ora,  $data_ora, $ora_ora, $IDfirmatutor_ora, $codmat_ora, $ID_mae, $nome_mae, $cognome_mae, $firma_mae_ora, $argomento_ora, $assente_ora, $secondomaestro_ora);
            mysqli_stmt_store_result($stmt2);
            $n =0 ;
            while (mysqli_stmt_fetch($stmt2)) {
                //estraggo anche il tutor eventuale
                // 210207 $sql3 = "SELECT ID_mae, nome_mae, cognome_mae FROM tab_classimaestri LEFT JOIN tab_anagraficamaestri ON ID_mae = tutor_cma WHERE ID_mae_cma = ? AND classe_cma = ? AND sezione_cma = ? AND codmat_cma = ? AND annoscolastico_cma = ?";
                $sql3 = "SELECT ID_mae, nome_mae, cognome_mae FROM tab_classimaestri LEFT JOIN tab_anagraficamaestri ON ID_mae = ID_mae_cma WHERE tutordi_cma = ? AND classe_cma = ? AND sezione_cma = ? AND codmat_cma = ? AND annoscolastico_cma = ?";
                $stmt3 = mysqli_prepare($mysqli, $sql3);
                mysqli_stmt_bind_param($stmt3,  "issss", $ID_mae, $classe, $sezione, $codmat_ora, $annoscolastico_asc);
                mysqli_stmt_execute($stmt3);
                mysqli_stmt_bind_result($stmt3, $ID_tutor, $nometutor_mae, $cognometutor_mae);
                $tutor = 0;
                while (mysqli_stmt_fetch($stmt3)) {
                    if($nometutor_mae != "") {$tutor = 1;};
                }
                $n++;
                ?>
                <tr id="riganew<?=$ID_ora?>">
                    <td>
                        
                        <img title="Elimina Maestro" style="width: 20px; cursor: pointer; <? if($_SESSION['role_usr'] == 2) {echo ("display:none;");}?>" src="assets/img/Icone/times-circle-solid.svg" onclick = "eliminaIDora(<?=$ID_ora?>);">
                    </td>
                    <td>
                        <input id="IDora2_new<?=$n?>" value ="<?=$ID_ora?>" type="text" hidden>
                        <select name="selectmateria"  style="width: 100%; margin-left: 0px"  id="<?echo ("GH".$j.$x.$n."new")?>"
                        onchange="verificaMaestroNew(<?=$n?>,<?=$j?>, '<?=$data?>', <?=$x?> )" <? if($_SESSION['role_usr'] == 2) {echo ("disabled");}?>>
							<option value="nomat">-</option>
							<?for ($k = 1; $k < $nummaterie; $k++) {?>
								<option value="<?=$codmat_mttA[$k]?>" <?if ($codmat_mttA[$k] == $codmat_ora) {echo ("selected");}?>><?=$descmateria_mttA[$k]?></option><?
							}?>
                        </select>
                    </td>
                    <td>
                        <input class="tablecell6" type="text" id="nome_cognome_maenew<?=$n?>" value = "<?=$nome_mae?> <?=$cognome_mae?>" readonly>
                        <input type="text" id="ID_mae_hidden2_new<?=$n?>" hidden>
                    </td>
                    <td>
                        <img id="firmatonew" title="<?=$argomento_ora?>" style="width: 15px;" 
							src="<?switch ($firma_mae_ora){
								case 0:echo 'assets/img/Icone/user-check-solid-red.svg';break;
								case 1:echo 'assets/img/Icone/user-check-solid-green.svg';break;
								case 2:echo 'assets/img/Icone/user-check-solid-yellow.svg';break;}?>">

                    </td>
                    <td>
                        <input class="tablecell6" type="text" id="nome_cognome_maenew<?=$n?>" value = "<?=$nometutor_mae?> <?=$cognometutor_mae?>" readonly>
                    </td>
                    <td>
                        <input class="tablecell6" type="checkbox" id="firmatutorCk<?=$n?>" onclick="firmaTutor(<?=$ID_ora?>, <?=$n?>, <?=$ID_tutor?>)" style="font-size: 14px" <?if ( $tutor==0 ) {echo('disabled');}?> <?if ( $IDfirmatutor_ora!=0 ) {echo('checked');} ?>>
                    </td>

                </tr>
            <?}?>



            <tr id="aggiungihtml">
                <td>
                <img id="plusaggiungi" title="Aggiungi nuovo Maestro Ulteriore" style="<? if($_SESSION['role_usr'] == 2) {echo ("display:none;");}?>  width: 20px; cursor: pointer" src='assets/img/Icone/circle-plus.svg' onclick="aggiungiMaestroUlteriore(<?=$j?>, <?=$x?>, <?=($n+1)?>, '<?=$data?>', <?=$nummaterie?>);">
                </td>
            </tr>
        </tbody>
    </table>


<script>

    function aggiungiMaestroUlteriore(j,x,n, data, nummaterie) {

        codmttA = <? echo '["' . implode('", "', $codmat_mttA) . '"]' ?>;
        descmateria_mttA= <? echo '["' . implode('", "', $descmateria_mttA) . '"]' ?>;
        codmttA.unshift("nomat");
        descmateria_mttA.unshift("-");
		appendhtml = "<td>"
        appendhtml = appendhtml + "<input id='IDora2_new"+n+"' value ='0' type='text' hidden>";
        appendhtml = appendhtml + "<select name='selectmateria'  style='margin-left: 0px'  id='GH"+j+x+n+"new' onchange=\"verificaMaestroNew("+n+","+j+", \'"+data+"\', "+x+")\">";


        for(var i=0; i<nummaterie; i++){
            appendhtml = appendhtml + "<option value='"+codmttA[i]+"'>"+descmateria_mttA[i]+"</option>"
        }

        appendhtml = appendhtml + "</select></td><td><input class='tablecell6' type='text' id='nome_cognome_maenew"+n+"' value = ''>"
        appendhtml = appendhtml + "<input type='text' id='ID_mae_hidden2_new"+n+"' hidden>";
        appendhtml = appendhtml + "</td><td id='pulsantinosalva'><img  title='salva nuovo maestro' style='width: 18px; cursor: pointer' src='assets/img/Icone/save-regular.svg' onclick=\"saveMaestroUlteriore("+n+","+j+", \'"+data+"\', "+x+");\"></td>";






		$('#aggiungihtml').append(appendhtml);
		$('#inmodifica').val("1");
		$('#plusaggiungi').css('visibility','hidden');
		//$('#scrittaaggiungi').hide();
	}


    function verificaMaestroNew (n, j, dataGG, x) {
        //a differenza di verificaMaestro qui ho anche n che mi dice quale degli ulteriori maestri sto guardando
		let codmat_mtt = $( "#GH"+j+x+n+"new option:selected" ).val();		
		//if (codmat_mtt != 'nomat' && codmat_mtt !='XX1' && codmat_mtt != 'XX2' ) {
		
		if (codmat_mtt != 'nomat' && codmat_mtt != 'XX1' && codmat_mtt != 'XX3') {
			let classe_ora = $( "#classe2_new" ).val();
			let sezione_ora= $( "#sezione2_new" ).val();
			postData = { codmat_mtt : codmat_mtt, classe_ora: classe_ora, sezione_ora: sezione_ora, dataGG: dataGG, ora: x };
            //console.log ("07qry_getUlterioriMaestri.php - verificaMaestroNew - postaData a 07qry_checkMaestro");	
			//console.log (postData);
			let $select = $('#GH'+j+x+n+"new");
			$.ajax({
				type: 'POST',
				url: "07qry_checkMaestro.php",
				data: postData,
				dataType: 'json',
				success: function(data){
                     console.log ("07qry_getUlterioriMaestri.php - verificaMaestroNew - risposta da 07qry_checkMaestro");	
					 console.log ("responso=>"+ data.responso);
					 console.log ("msg=>"+data.msg);
					 console.log ("nome_cognome_mae=>"+data.nome_cognome_mae);
					 console.log ("test=>"+data.test);
                     console.log ("ID_mae_cma=>"+data.ID_mae_ora);
                    
					if (data.responso =='OK') {
						$('#nome_cognome_maenew'+n).val(data.nome_cognome_mae);
						$('#ID_mae_hidden2_new'+n).val(data.ID_mae_ora);
					} else if (data.responso == 'NO_1'){
						//caso NO_1=non c'è maestro per la materia selezionata in quella classe
                        $('#alertModalTutor').removeClass('alert-success');
                        $('#alertModalTutor').addClass('alert-danger');
                        $('#alertmsgModalTutor').html(data.msg);
                        $("#alertModalTutor").show();
						$select.val("nomat").change();
						$('#nome_cognome_maenew'+n).val("");
						$('#ID_mae_hidden2_new'+n).val("");
					} else {
                        //ATTENZIONE QUESTO CHECK NON FUNZIONA
                        //nel caso uno inserisca lo stesso maesro del maestro principale
                        //o se inserisce più volte lo stesso ulteriore maestro

						//caso NO_2=il maestro è già impegnato

                        $select.val("nomat").change();
						$('#nome_cognome_maenew'+n).val("");
                        $('#alertModalTutor').removeClass('alert-success');
                        $('#alertModalTutor').addClass('alert-danger');
                        $('#alertmsgModalTutor').html(data.msg);
                        $("#alertModalTutor").show();
                        //$("#jx_torestore_hidden").val(String(j)+String(x));
						$('#ID_mae_hidden2_new'+n).val("");
						//$('#msgPluriclassenew').html(data.msg);
						//$('#modalCheckIfPluriclasse').modal('show');
					}
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '07qry_getUlterioriMaestri ##fname##'");      
				}
			});
		}
	}



    function saveMaestroUlteriore(n, j, dataGG, x) {
        let IDora2 = $('#IDora2_new'+n).val();

        let materia2 = $('#GH'+j+x+n+'new').val();
        let ID_mae2 = $('#ID_mae_hidden2_new'+n).val();

        let data2 = $('#data2_new').val();
        let ora2 = $('#ora2_new').val();
        let classe2 = $('#classe2_new').val();
        let sezione2 = $('#sezione2_new').val();

        //verifico se per caso sto inserendo un maestro uguale a quello della stessa classe
        let jx_current = $("#jx_current").val(); //qui ho scritto l'indice j-x della lezione corrente nella quale l'utente ha cliccato sull'icona del secondo maestro
        if ($('#nome_cognome_mae'+j+x).val() == $('#nome_cognome_maenew'+n).val()) {
            console.log ("07qry_getUlterioriMaestri.php - saveMaestroUlteriore - verifica")
            console.log ("#nome_cognome_mae"+j+x, $('#nome_cognome_mae'+j+x).val());
            console.log ("#nome_cognome_maenew"+n, $('#nome_cognome_maenew'+n).val());
            $('#alertModalTutor').removeClass('alert-success');
            $('#alertModalTutor').addClass('alert-danger');
            $('#alertmsgModalTutor').html('Non si può inserire lo stesso maestro come primo e secondo');
            $("#alertModalTutor").show();
            $('#GH'+j+x+n+"new").val("nomat").change();
            $('#nome_cognome_maenew'+n).val("");
			$('#ID_mae_hidden2_new'+n).val("");

        } else {
            postData = { IDora2: IDora2, materia2: materia2, ID_mae2: ID_mae2, data2: data2, ora2: ora2, classe2: classe2, sezione2 : sezione2};

            console.log ("07qry_getUlterioriMaestri.php - saveMaestroUlteriore - postData a 07qry_updateOrarioSingolo.php")
            console.log (postData);
            $.ajax({
                type: 'POST',
                url: "07qry_updateOrarioSingolo.php",
                data: postData,
                dataType: 'json',
                success: function(data){
                    $('#alertModalTutor').removeClass('alert-danger');
                    $('#alertModalTutor').addClass('alert-success');
                    $('#alertmsgModalTutor').html('Inserimento Secondo Maestro<br>completato con successo');
                    $("#alertModalTutor").show();
                    $("#btn_CancelModalTutor").html('Chiudi');
                    $("#btn_CancelModalTutor").removeClass('pull-left');
                    $("#btn_OKModalTutor").hide();
                    $("#remove-contentModalTutor").slideUp();
                    console.log (data.test);
                    //requery();
                },
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '07qry_getUlterioriMaestri ##fname##'");      
				}
            });
        }
    }





</script>