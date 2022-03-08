<?  
    //questa pagina carica la tabella da mostrare nel form modale di inserimento Pagamento

    include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");

    $ID_ret = $_POST['ID_ret'];

    //provo ad usare la stessa routine per caricare i pagamenti per le rette e gli 'altripagamenti'
    //se ho ID_ret estraggo ID_alu_ret tramite questo, così come le altre info che interessano

    //se non ho un ID_ret allora significa che si tratta di 'altripagamenti'
    //in questo caso devo aver passato a questa routine anche ID_alu_pag, ma anche l'anno scolastico

    $ID_alu = $_POST['ID_alu'];
    $annoscolastico = $_POST['annoscolastico'];

    if ($ID_ret == 0) {$altripagamenti = true;} else {$altripagamenti = false;} 

    include_once("04inc_GetCausaliPagamento.php");
    //$causali_pagA = ["non rilevata", "retta", "iscrizione", "donazione", "spese didattiche", "quota associativa", "cauzione"];
    $mesiA = ["idle", "Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"];
    $tipi_pagA = ["non rilevato", "bonifico", "contante", "carta di credito", "altro"];

    if ($altripagamenti) {
        //non ho ID_ret e ho già ID_alu
        $sql0 = "SELECT nome_alu, cognome_alu 
        FROM tab_anagraficaalunni 
        WHERE ID_alu = ?";
        $stmt0 = mysqli_prepare($mysqli, $sql0);
        mysqli_stmt_bind_param($stmt0,  "i", $ID_alu);
        mysqli_stmt_execute($stmt0);
        mysqli_stmt_bind_result($stmt0, $nome_alu, $cognome_alu);
        while (mysqli_stmt_fetch($stmt0)) {
        }


        $sql = "SELECT ID_pag, importo_pag, data_pag, causale_pag, tipo_pag, soggetto_pag
        FROM tab_pagamenti
        LEFT JOIN tab_mensilirette ON ID_ret = ID_ret_pag
        WHERE ID_alu_pag = ? AND causale_pag <> 1  AND annoscolastico_pag = ?";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt,  "is", $ID_alu, $annoscolastico);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $ID_pag, $importo_pag, $data_pag, $causale_pag, $tipo_pag, $soggetto_pag);
        while (mysqli_stmt_fetch($stmt)) {
        }


    } else {
        //ho ID_ret
        $sql0 = "SELECT ID_alu_ret, mese_ret, anno_ret, nome_alu, cognome_alu 
        FROM tab_mensilirette 
        LEFT JOIN tab_anagraficaalunni ON ID_alu = ID_alu_ret
        WHERE ID_ret = ?";
        $stmt0 = mysqli_prepare($mysqli, $sql0);
        mysqli_stmt_bind_param($stmt0,  "i", $ID_ret);
        mysqli_stmt_execute($stmt0);
        mysqli_stmt_bind_result($stmt0, $ID_alu, $mese_ret, $anno_ret, $nome_alu, $cognome_alu);
        while (mysqli_stmt_fetch($stmt0)) {
        }

        $sql = "SELECT ID_pag, importo_pag, data_pag, causale_pag, tipo_pag, soggetto_pag
        FROM tab_pagamenti
        LEFT JOIN tab_mensilirette ON ID_ret = ID_ret_pag
        WHERE ID_ret_pag = ? AND causale_pag = 1 ";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt,  "i", $ID_ret);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $ID_pag, $importo_pag, $data_pag, $causale_pag, $tipo_pag, $soggetto_pag);
        while (mysqli_stmt_fetch($stmt)) {
        }
    }
    ?>

    <input class="tablecell5" style="text-align: center;" type="text"  id="ID_ret2_hidden" value="<?=$ID_ret?>" hidden>
    <input class="tablecell5" style="text-align: center;" type="text"  id="ID_alu_ret_hidden" value="<?=$ID_alu?>" hidden>
    <input class="tablecell5" style="text-align: center;" type="text"  id="tipo_pag_obbligatorio_hidden" value="<?=$_SESSION['tipo_pag_obbligatorio']?>" hidden>
    <div class="row">
        <div class="col-md-2">
            <?=$causali_pagA[5]?>
        </div>
        <div class="col-md-4" style="text-align: center;">
            Nome Alunno 
        </div>
        <div class="col-md-4" style="text-align: center;">
            Cognome Alunno
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-4" style="text-align: center;">
            <input class="tablecell5" style="text-align: center;" type="text"  value="<?=$nome_alu?>" disabled>
        </div>
        <div class="col-md-4" style="text-align: center;">
            <input class="tablecell5" style="text-align: center;" type="text"  value="<?=$cognome_alu?>" disabled>
        </div>
    </div>

    <div class="row" <?if ($altripagamenti) { echo("style = 'display: none'");}?>>
        <div class="col-md-2">	
        </div>
        <div class="col-md-4" style="text-align: center;">
            Mese
        </div>
        <div class="col-md-4" style="text-align: center;">
            Anno
        </div>
    </div>
    <div class="row" <?if ($altripagamenti) { echo("style = 'display: none'");}?>>
        <div class="col-md-2">	
        </div>
        <div id="Modalmese_ret" class="col-md-4" style="text-align: center;">
            <input class="tablecell5" style="text-align: center;" type="text"  value="<?=$mesiA[$mese_ret]?>" disabled>
        </div>
        <div id="Modalanno_ret" class="col-md-4" style="text-align: center;">
            <input class="tablecell5" style="text-align: center;" type="text"  value="<?=$anno_ret?>" disabled>
        </div>
    </div>



    <table id="tabellaPagamentiEstratti" style="w100;  margin-top: 20px;">
        <thead style="font-size: 10px;">
            <tr>
                <th style="width: 48px">
                </th>
                <th style="width:115px">
                    <input class="tablelabel0 w100" type="text" value = "Causale" readonly>
                </th>
                <th style="width:115px">
                    <input class="tablelabel0 w100" type="text" value = "Data" readonly>
                </th>
                <th style="width:115px">
                    <input class="tablelabel0 w100" type="text" value = "Importo" readonly>
                </th>
                <th style="width:115px">
                    <input class="tablelabel0 w100" type="text" value = "Autore" readonly>
                </th>
                <th style="width:115px">
                    <input class="tablelabel0 w100" type="text" value = "Tipo" readonly>
                </th>

                <th style="width: 25px">
                </th>
                <th style="width: 48px">
                </th>
            </tr>
        </thead>

        <tbody>	
            
            <? mysqli_stmt_execute($stmt);
            $n =0 ;
            
            $soggetto_pagA = ["non rilevato", "padre", "madre", "altro"];
            $tipi_pagA = ["non rilevato", "bonifico", "contante", "carta di credito", "altro"];
            while (mysqli_stmt_fetch($stmt)) {
                $n++ ;
                ?>
                <tr id="riga_<?=$ID_pag?>">
                    <td>
                    <?//=$ID_pag?>
                        <!-- icona eliminazione -->
                        <img title="Elimina Pagamento" style="width: 20px; cursor: pointer;" src="assets/img/Icone/times-circle-solid.svg" onclick = "eliminaIDPag(<?=$ID_pag?>, <?=$ID_ret?>, <?=$causale_pag?>, <?=$ID_alu?>);">
                    </td>
                    <td>
                        <!-- causale pagamento -->
                        <input class="tablecell6" type="text" id="causale<?=$ID_pag?>" value="<?=$causali_pagA[$causale_pag]?>" readonly>
                    </td>
                    <td>
                        <!-- data pagamento -->
                        <input class="tablecell6" type="text" id="data<?=$ID_pag?>" value="<?=timestamp_to_ggmmaaaa($data_pag)?>" readonly>
                    </td>
                    <td>
                        <!-- importo pagamento -->
                        <input class="tablecell6" type="text" id="importo<?=$ID_pag?>" value = "<?=$importo_pag?>" readonly>
                    </td>
                    <td>
                        <!-- autore pagamento -->
                        <input class="tablecell6" type="text" id="soggetto<?=$ID_pag?>" value="<?=$soggetto_pagA[$soggetto_pag]?>" readonly>
                    </td>
                    <td>
                        <!-- tipo pagamento -->
                        <input class="tablecell6" type="text" id="soggetto<?=$ID_pag?>" value="<?=$tipi_pagA[$tipo_pag]?>" readonly>
                    </td>

                    <td>
                        <button class="w35px h28px ml5" title="Stampa ricevuta" onclick="downloadRicevuta(<?=$ID_pag?>)"><img class="iconaStd" src='assets/img/Icone/pdf.svg'></button>
                    </td>
                    <td>
                        <?if ($_SESSION['inviodatirette_altrisistemi'] == 1) {?>    
                            <button class="btnGrey w30px h28px" title="Esporta Singolo valore a Sistema Contabilità" onclick="downloadFilePagamenti(<?=$ID_pag?>)"><img class="iconaStd" src='assets/img/Icone/export.svg'></button>
                        <?}?>
                    </td>
                </tr>
            <?}?>
            <tr>
                <td>
                    &nbsp
                </td>
            </tr>
            <tr>
                <td style="font-size: 9px;">
                    Nuovo >><br>Pagamento
                </td>
                <td>
                    <!-- causale pagamento -->

                    <select class="w100" name="selectcausale"  style="margin-left: 0px; font-size: 13px;"  id="selectcausale_new"
                        <?if (!($altripagamenti)) {echo('disabled');} ?>
                    >
                        <?if (!($altripagamenti)) {
                              ?><option value="1" >retta</option>
                        <?} else {?>

                         <? 	//$causali_pagA = ["non rilevato", "retta", "iscrizione", "donazione", "spese didattiche", "quota associativa", "cauzione"]; 
                            foreach ($causali_pagA as $cod_causale) {
                                //devo estrarre il valore di ord_pca (che è l'id da scrivere) che si trova "nella stessa posizione in cui si trova $cod_causale dentro $causali_pagA"
                                $pos = array_search($cod_causale, $causali_pagA);
                                //ATTENZIONE: non devo QUI mostrare "retta" in quanto trattasi di "altri pagamenti"!
                                if ($cod_causale != "retta") {?>
                                    <option value ="<?=$ord_pcaA[$pos]?>"><?=$cod_causale?></option>
                                <?}?>
                            <?}?>
                        <?}?>
                    </select>
                </td>
                <td>
                    <input class='tablecell6 dpd' type='text' id='data_new' >
                </td>
                <td>
                    <input class='tablecell6' type='text' id='importo_new' >
                </td>
                <td>
                    <select class='w100' name='selectsoggetto'  style='margin-left: 0px; font-size: 13px;'  id='selectsoggetto_new'>
                        <option value='0' selected>non rilevato</option>
                        <option value='1' >padre</option>
                        <option value='2' >madre</option>
                        <option value='3' >altro</option>
                    </select>
                </td>
                <td>
                    <select class='w100' name='selecttipo'  style='margin-left: 0px; font-size: 13px;'  id='selecttipo_new'>
                        <option value='0' selected>non rilevato</option>
                        <option value='1' >bonifico</option>
                        <option value='2' >contanti</option>
                        <option value='3' >carta di credito</option>
                        <option value='4' >altro</option>
                    </select>
                </td>



            </tr>

            <!-- <tr id="aggiungihtml">
                <td>
                    <img id="plusaggiungi" title="Aggiungi nuovo Pagamento" style="width: 20px; cursor: pointer" src='assets/img/Icone/circle-plus.svg' onclick="aggiungiPagamento(<?//=$n?>);">
                </td>
            </tr> -->
        </tbody>
    </table>


<script>

    $(function () {
            moment.locale('en', {
            week: { dow: 1 }
            });
            
            $('.bootstrap-datetimepicker-widget').remove();
            $('.dpd').datetimepicker({
                pickTime: false, 
                format: "DD/MM/YYYY",
                weekStart: 1
            });


    });




    // function aggiungiPagamento() {
    //     //non viene usata, serviva per creare una nuova riga
	// 	appendhtml = "<td>";
    //     appendhtml = appendhtml + "<input class='tablecell6' type='text' id='data_new' >";
    //     appendhtml = appendhtml + "</td>";
    //     appendhtml = appendhtml + "<td>";
    //     appendhtml = appendhtml + "<input class='tablecell6' type='text' id='importo_new' >";
    //     appendhtml = appendhtml + "</td>";
    //     appendhtml = appendhtml + "<td>";
    //     appendhtml = appendhtml + "<select class='w100' name='selectsoggetto'  style='margin-left: 0px; font-size: 13px;'  id='selectsoggetto_new'><option value='0' selected>non rilevato</option> <option value='1' >padre</option> <option value='2' >madre</option> <option value='3' >altro</option> </select>";
    //     appendhtml = appendhtml + "</td>";
    //     appendhtml = appendhtml + "<td>";
    //     appendhtml = appendhtml + "<select class='w100' name='selecttipo'  style='margin-left: 0px; font-size: 13px;'  id='selecttipo_new'><option value='0' selected>non rilevato</option> <option value='1' >bonifico</option> <option value='2' >contanti</option> <option value='3' >carta di credito</option> <option value='4' >altro</option> </select>";
    //     appendhtml = appendhtml + "</td>";

	// 	$('#aggiungihtml').append(appendhtml);
	// 	//$('#inmodifica').val("1");
	// 	$('#plusaggiungi').css('visibility','hidden');
	// }



    function salvaNuovoPagamento() {
        
        let tipo_pag_obbligatorio = $('#tipo_pag_obbligatorio_hidden').val();
        let ID_ret_pag = $('#ID_ret2_hidden').val();
        let ID_alu_pag = $('#ID_alu_ret_hidden').val();

        let dataDDMMYYYY = $('#data_new').val();
        let datamoment = moment(dataDDMMYYYY, "DD/MM/YYYY");
        let data_pag = moment(datamoment).format("YYYY-MM-DD");

        let importo_pag = $('#importo_new').val();
        let causale_pag = $('#selectcausale_new').val();
        let tipo_pag = $('#selecttipo_new').val();
        let soggetto_pag = $('#selectsoggetto_new').val();

        annoscolastico = $("#selectannoscolastico").val();

        if (dataDDMMYYYY == '' || importo_pag == '' || causale_pag == 0) {
            $('#alertModalPagamenti').addClass('alert-danger');
            $('#alertModalPagamenti').removeClass('alert-success');
            $('#alertmsgModalPagamenti').html('Per inserire un pagamento valorizzare Data, Importo<br> e scegliere una causale');
            $("#alertModalPagamenti").show();
            return;
        }

        if (tipo_pag_obbligatorio ==  1 && tipo_pag == 0) {
            $('#alertModalPagamenti').addClass('alert-danger');
            $('#alertModalPagamenti').removeClass('alert-success');
            $('#alertmsgModalPagamenti').html('Il tipo di pagamento va indicato');
            $("#alertModalPagamenti").show();
            return;
        }



        postData = { ID_ret_pag: ID_ret_pag, ID_alu_pag: ID_alu_pag, data_pag: data_pag, importo_pag: importo_pag, causale_pag: causale_pag, tipo_pag: tipo_pag, soggetto_pag : soggetto_pag, annoscolastico_pag: annoscolastico};
        
        // console.log ("04qry_getPagamenti.php - salvaNuovoPagamento - postData a 04qry_insertNuovoPagamento.php")
        // console.log (postData);

        $.ajax({
            type: 'POST',
            url: "04qry_insertNuovoPagamento.php",
            data: postData,
            dataType: 'json',
            success: function(data){


                // console.log ("04qry_getPagamenti.php - salvaNuovoPagamento - ritorno da 04qry_insertNuovoPagamento.php")
                // console.log (data.test);
                //ora aggiorna i totali
                updateTotPagamenti (ID_ret_pag, causale_pag, ID_alu_pag, annoscolastico);
                $('#alertModalPagamenti').removeClass('alert-danger');
                $('#alertModalPagamenti').addClass('alert-success');
                $('#alertmsgModalPagamenti').html('Inserimento pagamento completato');
                $("#alertModalPagamenti").show();
                $("#btn_CancelModalPagamenti").html('Chiudi');
                $("#btn_OKModalPagamenti").hide();
                $("#remove-contentModalPagamenti").slideUp();

                

            },
            error: function(){
                alert("Errore: contattare l'amministratore fornendo il codice di errore '04qry_getPagamenti ##salvaNuovoPagamento##'");      
            }
        });
        

    }


	function eliminaIDPag(ID_pag, ID_ret_pag, causale_pag, ID_alu) {

        annoscolastico = $("#selectannoscolastico").val();
        $("#alertModalPagamenti").hide();
        postData = { ID_pag: ID_pag};
        // console.log ("04qry_getPagamenti.php - eliminaIDpagamento postData a 04qry_deletePagamento.php")
        // console.log (postData);
        $.ajax({
            type: 'POST',
            //url: "07qry_deleteUlterioreMaestro.php",
            url: "04qry_deletePagamento.php",
            data: postData,
            dataType: 'json',
            success: function(data){
                // console.log ("04qry_getPagamenti.php - eliminaIDpagamento ritorno da 04qry_deletePagamento.php")
                // console.log (data.test);
                //ora aggiorna i totali
                updateTotPagamenti (ID_ret_pag, causale_pag, ID_alu, annoscolastico);
                //$("#riga_"+ID_pag).remove();
                $('#alertModalPagamenti').removeClass('alert-danger');
                $('#alertModalPagamenti').addClass('alert-success');
                $('#alertmsgModalPagamenti').html('Eliminazione pagamento completata');
                $("#alertModalPagamenti").show();
                $("#btn_CancelModalPagamenti").html('Chiudi');
                $("#btn_OKModalPagamenti").hide();
                $("#remove-contentModalPagamenti").slideUp();
            },
            error: function(){
                alert("Errore: contattare l'amministratore fornendo il codice di errore '04qry_getPagamenti ##eliminaIDpagamento##'");      
            }
        });
    }

    function updateTotPagamenti(ID_ret_pag, causale_pag, ID_alu, annoscolastico) {
        postData = { ID_ret_pag: ID_ret_pag, causale_pag: causale_pag, ID_alu: ID_alu, annoscolastico: annoscolastico};
        console.log ("04qry_getPagamenti.php - updateTotPagamenti postData a 04qry_updateTotPagamenti.php")
        console.log (postData);
        $.ajax({
            type: 'POST',
            url: "04qry_updateTotPagamenti.php",
            data: postData,
            dataType: 'json',
            success: function(data){
                console.log ("04qry_getPagamenti.php - updateTotPagamenti ritorno da 04qry_updateTotPagamenti.php")
                console.log (data.test);
            },
            error: function(){
                alert("Errore: contattare l'amministratore fornendo il codice di errore '04qry_getPagamenti ##updateTotPagamenti##'");      
            }
        });
        
    }

    function downloadRicevuta(ID_pag) {
        url ="04downloadRicevutaPagamento.php";

        let form = $('<form target="_blank" action="' + url + '"method="post"></form>');

        let input_ID_pag = $("<input>")
        .attr("type", "text")
        .attr("name", "ID_pag")
        .val(ID_pag);
        $(form).append($(input_ID_pag));

        form.appendTo( document.body );

        $(form).submit();
        $(form).remove();

    }

</script>