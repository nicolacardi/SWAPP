<?  
    //questa pagina carica la tabella da mostrare nel form modale di inserimento della materia/maestro
    //comprende il thead della tabella, e poi il tobody con le righe dei record già presenti
    //inoltre comprende la riga nuova con tutte le funzioni di inserimento e cancellazione necessarie
    //NON E' CONTEMPLATO L'UPDATE DELLA RIGA MA SOLO LA CANCELLAZIONE E IMPOSTAZIONE

    include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");

    $data = $_POST['data'];
    $ora = $_POST['ora'];
    $classe = $_POST['classe'];
    $sezione = $_POST['sezione'];
    $j = $_POST['j'];
    $x = $_POST['x'];
    ?>
    <table id="tabellaMaterieEMaestri" style="display: inline-block; margin-top: 20px;">
        <thead style="font-size: 10px;">
            <tr>
                <th style="width: 25px">
                </th>
                <th style="width:180px">
                    <input class="tablelabel0 w100" type="text" value = "MATERIA" readonly>
                </th>
                <th style="width:180px">
                    <input class="tablelabel0 w100" type="text" value = "Maestro" readonly>
                </th>
                <th style="width: 35px">
                    
                </th>
                <th style="width:180px">
                    <input class="tablelabel0 w100" type="text" value = "Tutor" readonly>
                </th>
                <th style="width: 80px">
                    <input class="tablelabel0 w100" type="text" value = "Firma Tutor" readonly>
                </th>

            </tr>
        </thead>

        <tbody>	
            
            <?
            $annoscolastico_asc = getAnnoScolastico($data);

            //estraggo tutte le materie che PER LA CLASSE, LA SEZIONE e L'ANNO SCOLASTICO sono state assegnate a qualche maestro
            $sql3 = "SELECT DISTINCT codmat_cma, descmateria_mtt, ord_mtt FROM tab_classimaestri LEFT JOIN tab_materie ON codmat_cma = codmat_mtt WHERE annoscolastico_cma = ? AND classe_cma = ?  AND sezione_cma = ? ORDER BY descmateria_mtt, ord_mtt";
            $sql3xx = "SELECT DISTINCT codmat_cma, descmateria_mtt, ord_mtt FROM tab_classimaestri LEFT JOIN tab_materie ON codmat_cma = codmat_mtt WHERE annoscolastico_cma = '".$annoscolastico_asc."' AND classe_cma = '".$classe."'  AND sezione_cma = '".$sezione."' ORDER BY descmateria_mtt, ord_mtt";
            $stmt3 = mysqli_prepare($mysqli, $sql3);
            mysqli_stmt_bind_param($stmt3,  "sss", $annoscolastico_asc, $classe, $sezione);
            mysqli_stmt_execute($stmt3);
            mysqli_stmt_bind_result($stmt3, $codmat_mtt, $descmateria_mtt, $ord_mtt);
            $nummaterie = 1;
            $codmat_mttA[0] = 'nomat';
            $descmateria_mttA[0] = '-';
            while (mysqli_stmt_fetch($stmt3)) {
                $codmat_mttA[$nummaterie] = $codmat_mtt;
                $descmateria_mttA[$nummaterie] =$descmateria_mtt;
                $nummaterie++;
            }

            //bisogna in questa fase AGGIUNGERE l'intervallo e la pausa pranzo perchè non sono tra le materie assegnate ad alcun maestro
            array_push($codmat_mttA,"XX1","XX3","XX4", "XX5");
            array_push($descmateria_mttA,"[PRANZO]","[INTERVALLO]", "[USCITA DID.]", "[PCTO.EST]");
            $nummaterie = $nummaterie + 4;
            ?>
            <!-- <tr>
                <td>
                    debug <?//=$sql3xx?>
                </td>
            </tr> -->
            
            <?

            //estraggo le materie/maestri già assegnati all'ora/data di questa classe/sezione. Estraggo prima solo le ore NON di tutoring.
            $sql2 = "SELECT ID_ora, data_ora, ora_ora, IDfirmatutor_ora, codmat_ora, ID_mae, nome_mae, cognome_mae, firma_mae_ora, assente_ora, secondomaestro_ora, descmateria_mtt  FROM tab_orario LEFT JOIN tab_anagraficamaestri ON ID_mae = ID_mae_ora LEFT JOIN tab_materie ON codmat_ora = codmat_mtt WHERE data_ora = ? AND ora_ora = ? AND classe_ora = ? AND sezione_ora= ? AND codmat_ora <> 'TUX' ORDER BY secondomaestro_ora";
            $stmt2 = mysqli_prepare($mysqli, $sql2);
            mysqli_stmt_bind_param($stmt2,  "siss", $data, $ora, $classe, $sezione);
            mysqli_stmt_execute($stmt2);
            mysqli_stmt_bind_result($stmt2, $ID_ora,  $data_ora, $ora_ora, $IDfirmatutor_ora, $codmat_ora, $ID_mae, $nome_mae, $cognome_mae, $firma_mae_ora, $assente_ora, $secondomaestro_ora, $descmateria_mtt);
            mysqli_stmt_store_result($stmt2);
            $n =0 ;
            while (mysqli_stmt_fetch($stmt2)) {
                
                //estraggo ora il tutor eventuale per questo ID_mae in questa classe, sezione, materia, annoscolastico
                $sql3 = "SELECT ID_mae, nome_mae, cognome_mae FROM tab_classimaestri LEFT JOIN tab_anagraficamaestri ON ID_mae = ID_mae_cma WHERE tutordi_cma = ? AND classe_cma = ? AND sezione_cma = ? AND codmat_cma = ? AND annoscolastico_cma = ?";
                $stmt3 = mysqli_prepare($mysqli, $sql3);
                mysqli_stmt_bind_param($stmt3,  "issss", $ID_mae, $classe, $sezione, $codmat_ora, $annoscolastico_asc);
                mysqli_stmt_execute($stmt3);
                mysqli_stmt_bind_result($stmt3, $ID_tutor, $nometutor_mae, $cognometutor_mae);
                $tutor = 0;
                while (mysqli_stmt_fetch($stmt3)) {
                    $tutor = 1;
                }
                $n++;
                ?>
                <tr id="riganew<?=$ID_ora?>">
                    <td>
                        <!-- icona eliminazione -->
                        <img title="Elimina Maestro" style="width: 20px; cursor: pointer; <? if($_SESSION['role_usr'] == 2) {echo ("display:none;");}?>" src="assets/img/Icone/times-circle-solid.svg" onclick = "eliminaIDora(<?=$ID_ora?>);">
                        
                    </td>
                    <td>
                        <!-- descmateria -->
                        <input id="IDora2_new<?=$n?>" value ="<?=$ID_ora?>" type="text" hidden>
                        <input class="tablecell6" type="text" id="<?echo ("GH".$j.$x.$n."new")?>" value="<?=$descmateria_mtt?>" readonly>
                    </td>
                    <td>
                        <!-- questa riga non servirebbe ma la inserisco per omogeneità con la riga di inserimento -->
                        <input type="text" id="ID_mae_hidden2_new<?=$n?>" value="<?=$ID_mae?>" hidden>
                        <!-- nome maestro -->
                        <input class="tablecell6" type="text" id="nome_cognome_maenew<?=$n?>" value = "<?=$nome_mae?> <?=$cognome_mae?>" readonly>
                    </td>
                    <td>
                    </td>
                    <td>
                        <?if ( $tutor!=0 ) {?>
                            <!-- se c'è il tutor di questa materia qui compare -->
                            <input class="tablecell6" type="text" id="nome_cognome_tutornew<?=$n?>" value = "<?=$nometutor_mae?> <?=$cognometutor_mae?>" readonly>
                        <?}?>
                    </td>
                    <td>
                        <?if ( $tutor!=0 ) {?>
                            <!-- checkbox selezione tutor -->
                            <!-- ovviamente se la checkbox è selezionata o no lo capisco da tab_orario.IDfirmatutor_ora -->
                            <input class="tablecell6" type="checkbox" id="firmatutorCk<?=$n?>" 
                            onclick="firmaTutor(<?=$ID_ora?>, <?=$n?>, <?=$ID_tutor?>, '<?=$data?>')"
                            style="font-size: 14px" 
                            <?if ( $IDfirmatutor_ora!=0 ) {echo('checked');} ?>>
                        <?}?>
                        
                    </td>
                    

                </tr>
            <?}?>



            <tr id="aggiungihtml">
                <td>
                <img id="plusaggiungi" title="Aggiungi nuovo Maestro Ulteriore" style="<? if($_SESSION['role_usr'] == 2) {echo ("display:none;");}?>  width: 20px; cursor: pointer" src='assets/img/Icone/circle-plus.svg' onclick="aggiungiMaestroUlteriore(<?=$j?>, <?=$x?>, <?=($n+1)?>, '<?=$data?>', <?=$nummaterie?>);">
                </td>
                <!-- <td><?//=$sezione?></td> -->
            </tr>
        </tbody>
    </table>


<script>

    function aggiungiMaestroUlteriore(j,x,n, data, nummaterie) {
        //aggiunge una riga alla tabella con tanto di select per la scelta della materia e pulsante save
        //nel caso i due array siano vuoti SOLO ONLINE non funziona
        // console.log ("07qry_getMaterieEMaestriNew.php -  aggiungiMaestroUlteriore - codmttA");
        // console.log ("07qry_getMaterieEMaestriNew.php -  aggiungiMaestroUlteriore - descmateria_mttA");

        //devo ora estrarre i valori dai due array che sono stati popolati da php!
        codmttA =               <? echo '["' . implode('", "', $codmat_mttA) . '"]' ?>;
        descmateria_mttA=       <? echo '["' . implode('", "', $descmateria_mttA) . '"]' ?>;

        //codmttA.unshift("nomat"); //aggiungeva un elemento in prima posizione
        //descmateria_mttA.unshift("-"); //aggiungeva un elemento in prima posizione
		appendhtml = "<td>"
        appendhtml = appendhtml + "<input id='IDora2_new"+n+"' value ='0' type='text' hidden>";
        appendhtml = appendhtml + "<select name='selectmateria'  style='margin-left: 0px; width: 100%'  id='GH"+j+x+n+"new' onchange=\"verificaMaestroNew("+n+","+j+", \'"+data+"\', "+x+")\">";


        for(var i=0; i<nummaterie; i++){
            appendhtml = appendhtml + "<option value='"+codmttA[i]+"'>"+descmateria_mttA[i]+"</option>"
        }

        appendhtml = appendhtml + "</select></td><td><input class='tablecell6' type='text' id='nome_cognome_maenew"+n+"' value = ''>"
        appendhtml = appendhtml + "<input type='text' id='ID_mae_hidden2_new"+n+"' hidden>";
        appendhtml = appendhtml + "</td><td id='pulsantinosalva'><img  title='salva nuovo maestro' style='width: 18px; cursor: pointer' src='assets/img/Icone/save-regular.svg' onclick=\"saveMateriaMaestro("+n+","+j+", \'"+data+"\', "+x+");\"></td>";

		$('#aggiungihtml').append(appendhtml);
		$('#inmodifica').val("1");
		$('#plusaggiungi').css('visibility','hidden');

        //console.log ("07qry_getUlterioriMaestri.php - aggiungiMaestroUlteriore - descmateria_mttA");	
        //console.log (descmateria_mttA);	
	}


    function verificaMaestroNew (n, j, dataGG, x) {
        //verifica se il maestro scelto non sia già impegnato: usa 07qry_checkMaestroNew 

        //n dice quale riga sto verificando di quelle presenti
        //j dice quale giorno della settimana
        //dataGG dice la data
        //x dice quale ora

        $("#alertModalTutor").hide();

		let codmat_mtt = $( "#GH"+j+x+n+"new option:selected" ).val();		
		
		if (codmat_mtt != 'nomat' && codmat_mtt != 'XX1' && codmat_mtt != 'XX3' && codmat_mtt != 'XX4' && codmat_mtt != 'XX5') {  //in teoria non serve questo if
			let classe_ora = $( "#classe2_new" ).val();                             //campo del modale dove ho scritto la classe
			let sezione_ora= $( "#sezione2_new" ).val();                            //campo del modale dove ho scritto la sezione
			postData = { codmat_mtt : codmat_mtt, classe_ora: classe_ora, sezione_ora: sezione_ora, dataGG: dataGG, ora: x };
            // console.log ("07qry_getUlterioriMaestri.php - verificaMaestroNew - postaData a 07qry_checkMaestroNew");	
			// console.log (postData);
			let $select = $('#GH'+j+x+n+"new");
			$.ajax({
				type: 'POST',
				url: "07qry_checkMaestroNew.php",
				data: postData,
				dataType: 'json',
				success: function(data){
                          console.log ("07qry_getUlterioriMaestri.php - verificaMaestroNew - risposta da 07qry_checkMaestroNew");	
                          console.log ("responso=>           "+data.responso);
                          console.log ("msg=>                "+data.msg);
                          console.log ("nome_cognome_mae=>   "+data.nome_cognome_mae);
                          console.log ("test=>               "+data.test);
                          console.log ("ID_mae_cma=>         "+data.ID_mae_ora);
					if (data.responso =='NO_1') {
                        //caso NO_1=Maestro non ancora assegnato alla materia selezionata in questa classe
                        //questo caso non dovrebbe accadere mai in quanto ora le materie mostrate sono solo quelle assegnate
                        $('#alertModalTutor').removeClass('alert-success');
                        $('#alertModalTutor').addClass('alert-danger');
                        $('#alertmsgModalTutor').html(data.msg);
                        $("#alertModalTutor").show();
						$select.val("nomat").change();
						$('#nome_cognome_maenew'+n).val("");
						$('#ID_mae_hidden2_new'+n).val("");
					} else if (data.responso == 'NO_2'){
                        //caso NO_2=Il maestro è già impegnato in altra classe o nella stessa classe
                        //qui ipotrebbe essere una pluriclasse: va avvisato l'utente
                        //$select.val("nomat").change(); //commentato perchè implementazione PLURICLASSE
						//$('#nome_cognome_maenew'+n).val(""); //commentato perchè implementazione PLURICLASSE
                        $('#nome_cognome_maenew'+n).val(data.nome_cognome_mae);  //implementazione PLURICLASSE
                        $('#alertModalTutor').removeClass('alert-success'); 
                        $('#alertModalTutor').addClass('alert-danger'); 
                        $('#alertmsgModalTutor').html(data.msg); 
                        $("#alertModalTutor").show(); 
                        //$("#jx_torestore_hidden").val(String(j)+String(x));
						//$('#ID_mae_hidden2_new'+n).val(""); //commentato perchè implementazione PLURICLASSE
                        $('#ID_mae_hidden2_new'+n).val(data.ID_mae_ora);
						//$('#msgPluriclassenew').html(data.msg);
						//$('#modalCheckIfPluriclasse').modal('show');
                    } else if (data.responso == 'NO_3'){
                        //Il maestro già sta nella stessa classe va bloccato
                        $select.val("nomat").change();
						$('#nome_cognome_maenew'+n).val("");
                        $('#alertModalTutor').removeClass('alert-success'); 
                        $('#alertModalTutor').addClass('alert-danger'); 
                        $('#alertmsgModalTutor').html(data.msg); 
                        $("#alertModalTutor").show(); 
						$('#ID_mae_hidden2_new'+n).val("");
                    } else if (data.responso == 'NO_4'){
                        //Si sta provando a duplicare un tutorato, NO WAY
                        $select.val("nomat").change();
						$('#nome_cognome_maenew'+n).val("");
                        $('#alertModalTutor').removeClass('alert-success'); 
                        $('#alertModalTutor').addClass('alert-danger'); 
                        $('#alertmsgModalTutor').html(data.msg); 
                        $("#alertModalTutor").show(); 
						$('#ID_mae_hidden2_new'+n).val("");
					} else {
                        //quando il responso è OK:
						$('#nome_cognome_maenew'+n).val(data.nome_cognome_mae);
						$('#ID_mae_hidden2_new'+n).val(data.ID_mae_ora);
					}
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '07qry_getUlterioriMaestri ##fname##'");      
				}
			});
		}
	}



    function saveMateriaMaestro(n, j, dataGG, x) {
        //salva la materia selezionata in tab_orario
        let materia2 = $('#GH'+j+x+n+'new').val();
        if (materia2 == '-' || materia2 == 'nomat')  return; //non ho ancora eseguito una selezione, quindi return

        let IDora2 = $('#IDora2_new'+n).val();

        let ID_mae2 = $('#ID_mae_hidden2_new'+n).val();
        
        let dataDDMMYYYY = $('#data2_new').val();
        let datamoment = moment(dataDDMMYYYY, "DD/MM/YYYY");
        let data2 = moment(datamoment).format("YYYY-MM-DD");

        let ora2 = $('#ora2_new').val();
        let classe2 = $('#classe2_new').val();
        let sezione2 = $('#sezione2_new').val();

        postData = { IDora2: IDora2, materia2: materia2, ID_mae2: ID_mae2, data2: data2, ora2: ora2, classe2: classe2, sezione2 : sezione2};

         //console.log ("07qry_getMaterieEMaestriNew.php - saveMateriaMaestro - postData a 07qry_updateOrarioSingoloNew.php")
         //console.log (postData);
        $.ajax({
            type: 'POST',
            url: "07qry_updateOrarioSingoloNew.php",
            data: postData,
            dataType: 'json',
            success: function(data){
                console.log (data.test);
                $('#alertModalTutor').removeClass('alert-danger');
                $('#alertModalTutor').addClass('alert-success');
                $('#alertmsgModalTutor').html('Inserimento firma maestro completato');
                $("#alertModalTutor").show();
                $("#btn_CancelModalTutor").html('Chiudi');
                $("#btn_CancelModalTutor").removeClass('pull-left');
                $("#btn_OKModalTutor").hide();
                $("#remove-contentModalTutor").slideUp();
            },
            error: function(){
                alert("Errore: contattare l'amministratore fornendo il codice di errore '07qry_getUlterioriMaestri ##fname##'");      
            }
        });

    }


	function eliminaIDora(ID_ora) {
        $("#alertModalTutor").hide();
        postData = { ID_ora: ID_ora};
        // console.log ("07qry_Orario.php - eliminaIDora postData a 07qry_deleteUlterioreMaestro.php")
        // console.log (ID_ora);
        $.ajax({
            type: 'POST',
            url: "07qry_deleteUlterioreMaestro.php",
            data: postData,
            dataType: 'json',
            success: function(data){
                // console.log (data.test);
                $("#riganew"+ID_ora).remove();
                $('#alertModalTutor').removeClass('alert-danger');
                $('#alertModalTutor').addClass('alert-success');
                $('#alertmsgModalTutor').html('Eliminazione firma maestro completata');
                $("#alertModalTutor").show();
                //$("#btn_CancelModalTutor").html('Chiudi');
                //$("#btn_CancelModalTutor").removeClass('pull-left');
                //$("#btn_OKModalTutor").hide();
                //$("#remove-contentModalTutor").slideUp();
            },
            error: function(){
                alert("Errore: contattare l'amministratore fornendo il codice di errore '07qry_Orario ##fname##'");      
            }
        });
    }

	function firmaTutor(ID_ora, n, ID_tutor, dataGG){

                
        //ID_ora potrebbe essere = IDora_new_hidden se si tratta del tutor del maestro principale
        //oppure potrebbe essere = a un valore che deve essere passato alla presente routine (quando non si tratta del tutor del maestro principale)

        //if (ID_ora == 0) { ID_ora = $("#IDora_new_hidden").val();} //caso tutor maestro principale}
        //ora che io stia lavorando sul tutor del maestro principale oppure no, ho l'ID del record giusto	
        //if (ID_tutor == 0 ) { ID_tutor = $("#IDtutor_hidden").val(); }
        //ora che io stia lavorando sul tutor del maestro principale oppure no, ho l'ID del tutor giusto


        
        let ora = $('#ora2_new').val();
        let classe = $('#classe2_new').val();
        let sezione = $('#sezione2_new').val();
        let ID_mae = $('#ID_mae_hidden2_new').val();
        firmatutorCk = $("#firmatutorCk"+n).prop("checked");


        if (!firmatutorCk) {
            //delete
            postData = { ID_ora: ID_ora};
            // console.log ("07qry_getMaterieEMaestriNew.php - firmaTutor - postData a 07qry_deleteTutor.php")
            // console.log ("sto per cancellare",postData); //passo alla deleteTutor l'ID principale. la routine andrà a cercarsi l'IDfirmatutor da cancellare
            $.ajax({
                type: 'POST',
                url: "07qry_deleteTutor.php",
                data: postData,
                dataType: 'json',
                success: function(data){
                    //console.log ("07qry_getMaterieEMaestriNew.php - firmaTutor - ritorno da 07qry_deleteTutor.php")
                    //console.log (data.test);
                    $('#alertModalTutor').removeClass('alert-danger');
                    $('#alertModalTutor').addClass('alert-success');
                    $('#alertmsgModalTutor').html('Eliminazione firma Tutor completata');
                    $("#alertModalTutor").show();
                    //$("#btn_CancelModalTutor").html('Chiudi');
                    //$("#btn_CancelModalTutor").removeClass('pull-left');
                    //$("#btn_OKModalTutor").hide();
                    //$("#remove-contentModalTutor").slideUp();
                },
                error: function(){
                    alert("Errore: contattare l'amministratore fornendo il codice di errore '07Orario ##fname##'");      
                }
            });
        } else {

            //verifico che il tutor non sia già impegnato altrove in altra lezione
            //*****USO UNA ROUTINE AD HOC SIMILE A 07qry_ChecMaestro che si chiama 07qry_checkTutor */


            postData = { ID_ora: ID_ora, ID_mae: ID_tutor, data: dataGG, ora: ora, classe: classe, sezione : sezione};
            // console.log ("07qry_getMaterieEMaestriNew.php - firmaTutor - postaData a  07qry_checkTutorNew.php")
            // console.log (postData);
            $.ajax({
                type: 'POST',
                url: "07qry_checkTutorNew.php",
                data: postData,
                dataType: 'json',
                success: function(data){
                    // console.log ("07qry_getMaterieEMaestriNew.php - firmaTutor - ritorno da  07qry_checkTutorNew.php");	
                    // console.log ("responso=>"+ data.responso);
                    // console.log ("msg=>"+data.msg);
                    // console.log ("test=>"+data.test);
                    if (data.responso == 'OK') {

                        materia = "TUX"; //inserisco la materia TUX e vado ad aggiornare ID_ora principale
                        postData = { ID_ora: ID_ora, materia: materia, ID_mae: ID_tutor, data: dataGG, ora: ora, classe: classe, sezione : sezione};
                        //console.log ("07qry_getMaterieEMaestriNew.php - firmaTutor - postData a 07qry_setFirmaTutorNew.php")
                        //console.log(postData);

                        $.ajax({
                            type: 'POST',
                            url: "07qry_setFirmaTutorNew.php",
                            data: postData,
                            dataType: 'json',
                            success: function(data){
                                //console.log ("07qry_getMaterieEMaestriNew.php - firmaTutor - ritorno da 07qry_setFirmaTutorNew.php")
                                //console.log (data.test);
                                $('#alertModalTutor').removeClass('alert-danger');
                                $('#alertModalTutor').addClass('alert-success');
                                $('#alertmsgModalTutor').html('Inserimento firma Tutor completato');
                                $("#alertModalTutor").show();
                                $("#btn_CancelModalTutor").html('Chiudi');
                                $("#btn_CancelModalTutor").removeClass('pull-left');
                                $("#btn_OKModalTutor").hide();
                                $("#remove-contentModalTutor").slideUp();

                                //requery();
                            },
                            error: function(){
                                alert("Errore: contattare l'amministratore fornendo il codice di errore '07Orario ##fname##'");      
                            }
                        });
                    } else {
                        //caso NO_2=Il maestro è già impegnato in altra classe o nella stessa

                        $('#alertModalTutor').removeClass('alert-success');
                        $('#alertModalTutor').addClass('alert-danger');
                        $('#alertmsgModalTutor').html(data.msg);
                        $("#alertModalTutor").show();

                    }
                },
                error: function(){
                    alert("Errore: contattare l'amministratore fornendo il codice di errore '07Orario ##fname##'");      
                }
            });
        }


    }

</script>