<?//ora estraggo da tab_classialunnivoti le varie materie

//**************** per fase test e vedere se ci stanno le stringhe

function generateRandomString($testlength = 600) {

    $characters = '                    0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $testlength; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
//****************+ fine test

//per capire se devo mostrare i (+) degli obiettivi faccio una COUNT di quanti ID_mat_obi sono segnati pe ogni singola materia.
//questo va bene ma in teoria...e se per una materia non ho inserito gli obiettivi? Forse è giusto che oer quella singola non si veda il (+) come ad es per il comportamento....
$sql = "SELECT ID_cla, ID_alu_cla, ID_mat, aselme_mat, tipodoc_mat, codmat_mat, annoscolastico_cla, vot1_cla, giu1_cla, vot2_cla, giu2_cla, commento1_cla, commento2_cla, descmateria_mat, ord_mat, contaobiettivi.n
FROM (tab_materievoti LEFT JOIN tab_classialunnivoti 
ON codmat_mat = codmat_cla AND aselme_mat = aselme_cla AND ID_alu_cla = ? AND annoscolastico_cla = ? )

LEFT JOIN (SELECT ID_mat_obi, COUNT(*) AS n FROM tab_materievotiobiettivi GROUP BY ID_mat_obi) contaobiettivi ON tab_materievoti.ID_mat = contaobiettivi.ID_mat_obi

WHERE tipodoc_mat = ? AND aselme_mat = ? ORDER BY ord_mat";
//la LEFT JOIN contaobiettivi restituisce il conteggio degli eventuali sotto-obiettivi della singola materia (NULL dove non ce ne sono)

$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "isis", $ID_alu, $annoscolastico_cla,  $tipopagella,  $aselme_cla );
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $ID_cla, $ID_alu_det, $ID_mat, $aselme_mat_det, $tipodoc_mat_det, $codmat_cla_det, $annoscolastico_cla_det, $vot1_cla_det, $giu1_cla_det, $vot2_cla_det, $giu2_cla_det, $commento1_cla_det, $commento2_cla_det, $descmateria_mat_det, $ord_mat, $n_obiettivi);
mysqli_stmt_store_result($stmt);


$j =  0;

//C'è il tipo pagella tipodoc_mat che va da 1 (vecchia pagella) a 6. In tabella parametrixanno c'è questo valore sia per ME che per EL
//e poi c'è il tipo di voti che si trovano in una ulteriore colonna della stessa tabella. Teoricamente si potrebbe avere i voti letterali in una pagella di tipo 2 o numerici in una pagella di tipo 2 o qualsiasi combinazione...
//In generale la pagella di tipo 2 ha i voti di tipo 3 (Avanzato, Intermedio ecc.)
//e la pagella di tipo 1 ha i voti numerici ma non è obbligatorio
//In base al tipo di voti che sono stati trovati in tabella parametri per anno vado a scegliere cosa scrivere nelle varie combo
//e a dimensionare gli spazi e la dimensione dei font dell'interfaccia
switch ($tipovoti) {
    case 1:
        $CODtipovoto = array("idle", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10");
        $DESCtipovoto = array("idle", "-", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10");
        $w1 = 86;
        $fontS =  14;
    break;
    case 2:
        $CODtipovoto = array("idle", "0", "GI", "I", "S", "D", "B", "DT", "O");
        $DESCtipovoto = array("idle", "-", "Gr. Insufficiente", "Insufficiente", "Sufficiente", "Discreto", "Buono", "Distinto", "Ottimo");
        $w1 = 120;
        $fontS = 12;
    break;
    case 3:
        $CODtipovoto = array("idle", "0", "AC", "BA", "IN", "AV");
        $DESCtipovoto = array("idle", "-", "In Via di Acquisizione", "Base", "Intermedio", "Avanzato");
        $w1 = 120;
        $fontS = 12;
    break;
}

$CODtipovotoN = count($CODtipovoto) - 1 ;

if ($aselme_cla=="EL")  {
    $Hriga = '60px'; 
} else {
    $Hriga = '40px';
}
?>

<!-- ********************************************** TAB QUADRIMESTRE 1 **********************************************-->
<div class="tab-pane active" id="Quadrimestre1">
    <div class="col-md-12 center" style="margin-left: 20px; ">
        <div class="row mt10">
            <div class="col-md-3">
                <button class="btnBlu w200px" onclick="showModalSalvaPagella(1, <?=$tipopagella?>);">Salva 1^ Quadr.</button>
            </div>
            
            <div class="col-md-3">
                <?if ($tipopagella != 0) {?>
                    <button class="btnGreyBordoViola w200px" id="Pagelle"
                    onclick="scaricaPagellaPOST(event, <?=$ID_alu;?>, '<?=$annoscolastico_cla;?>', '<?=$classe_cla;?>', '<?=$sezione_cla;?>', 1, <?=$tipopagella?>);" title="Pagelle">Pagella</button>	
                <?}?>
            </div>
            <div class="col-md-3">
                <?if ($tipopagella2 != 0) {?>
                    <button class="btnGreyBordoBlu w200px" id="Pagelle"
                    onclick="scaricaPagellaPOST(event, <?=$ID_alu;?>, '<?=$annoscolastico_cla;?>', '<?=$classe_cla;?>', '<?=$sezione_cla;?>', 1, <?=$tipopagella2?>);" title="Doc. Valutazione ">Doc. Valutazione</button>
                <?}?>
            </div>
        </div>
        <table class="tabellaAlunniPagella1" style="width: 95%; margin-top: 10px;">
            <thead>
                <tr>
                    <td class="center w15">
                        Materia 
                    </td>
                    <td class="center w30">
                        Commento interno
                    </td>
                    <td class="center w5">
                        Voto
                    </td>
                    <td class="center w50">
                        Valutazione (<?=$nchar_paa?> caratteri)
                    </td>
                </tr>
            </thead>
            <tbody>
            <?
            while (mysqli_stmt_fetch($stmt)) {?>
                <tr>
                    <td>
                        <!--Nome Materia-->
                        <textarea class="tablecell6 voti materia ta" type="text" style="margin-bottom: -3px; font-size: 12px; height:<?=$Hriga?>" disabled><?//=$ID_alu."-".$annoscolastico_cla."-".$tipopagella."-".$aselme_cla;?> <?=$descmateria_mat_det; ?></textarea>
                        <input id ="mat_<?=$j?>_<?=$tipopagella?>" type="text"  value = "<?=$codmat_cla_det;?>" hidden>

                    </td>
                    <td>
                        <!--Commento Interno-->
                        <textarea class="tablecell6 voti ta" id ="com1_<?=$j?>_<?=$tipopagella?>" style="margin-bottom: -3px; font-size: 12px; height:<?=$Hriga?>" rows= "2" maxlength="255" oninput="setRunawayFalse()"><?=$commento1_cla_det;?></textarea>
                    </td>
                    <td  style="position: relative">
                        <!--Voto-->
                        <?if($n_obiettivi) {?>
                            <img title='Inserisci Obiettivi' class="iconaStd iconaAbsolute iconaTransparent" src='assets/img/Icone/circle-plus-blue.svg'' onclick="showModalAddObiettivi(<?=$ID_mat?>, <?if($ID_cla) { echo($ID_cla); } else { echo('0'); }?>, 1);">
                        <?} else { ?>
                            <?if ($descmateria_mat_det != "Comportamento") {?>
                                <!--Voto in una select costruita in base all'array di cui sopra, nel caso non sia Comportamento-->
                                <select  id ="vot1_<?=$j?>_<?=$tipopagella?>" class="votcellgiu" style="height:<?=$Hriga?>; font-size: <?=$fontS?>px;  width:<?=$w1?>px; margin-top: -2px; margin-left: 0px" oninput="modificaincorso('vot1_<?=$j?>_<?=$tipopagella?>');">
                                    <?for ($x = 1; $x <= $CODtipovotoN; $x++) {?>
                                        <option value="<?=$CODtipovoto[$x]?>" <? if($vot1_cla_det==$CODtipovoto[$x]) {echo ('selected');} ?>><?=$DESCtipovoto[$x]?></option>
                                    <?}
                                    ?>
                                </select>

                            <?} else {?>
                                <!--Voto nel caso sia comportamento-->
                                <select  id ="vot1_<?=$j?>_<?=$tipopagella?>" name="comportamento" class="votcellgiu" style=" height:<?=$Hriga?>;  font-size: <?=$fontS?>px;  width:<?=$w1?>px; margin-top: -2px; margin-left: 0px" oninput="modificaincorso('vot1_<?=$j?>_<?=$tipopagella?>');">
                                    <option value="0"  <? if($vot1_cla_det=="0") {echo ('selected');} ?>>-</option>
                                    <option value="GI" <? if($vot1_cla_det=="GI") {echo ('selected');} ?>>Gr.Insufficiente</option>
                                    <option value="I"  <? if($vot1_cla_det=="I") {echo ('selected');} ?>>Insufficiente</option>
                                    <option value="S"  <? if($vot1_cla_det=="S") {echo ('selected');} ?>>Sufficiente</option>
                                    <option value="D"  <? if($vot1_cla_det=="D") {echo ('selected');} ?>>Discreto</option>
                                    <option value="B"  <? if($vot1_cla_det=="B") {echo ('selected');} ?>>Buono</option>
                                    <option value="DT" <? if($vot1_cla_det=="DT") {echo ('selected');} ?>>Distinto</option>
                                    <option value="O"  <? if($vot1_cla_det=="O") {echo ('selected');} ?>>Ottimo</option>
                                </select>
                        <?}?>
                        <?}?>
                    </td>
                    <td>
                        <!--Valutazione descrittiva-->
                        <textarea class="tablecell6 voti ta" onkeyup="countCharGiu('giu1_<?=$j?>_<?=$tipopagella?>')" type="textarea" style=" margin-bottom: -3px; height:<?=$Hriga?>;" id ="giu1_<?=$j?>_<?=$tipopagella?>" rows= "2" oninput="modificaincorso('giu1_<?=$j?>_<?=$tipopagella?>');"><?=str_replace('\\','', (str_replace("\\n", "&#010;", $giu1_cla_det))); ?></textarea>
                        <div class="tablecell3 tmpCounterVoti"  style="display: none" id="CharNum_giu1_<?=$j?>_<?=$tipopagella?>" class="charNum"></div>


                        <!-- <img style="width: 20px; position: absolute; right:75px; cursor: pointer; display:none;" src='assets/img/Icone/pencil-edit-button2.svg' onclick="showEditGiudizio('giu1_<?//=$j;?>_<?//=$tipopagella?>' , '<?//=$classe_cla;?>','<?//=$codmat_cla_det;?>','1');"> -->
                        <? //echo (nl2br(stripcslashes($giu1_cla_det))); ?>
                    </td>
                </tr>
                <?
                $j++;
            }
            ?>
                <tr>
                    <td>
                        <textarea class="tablecell6 voti materia ta" type="text" style="font-size: 12px; height: 80px;" disabled>Rilevazione Progressi Sviluppo Personale e Sociale </textarea>
                    </td>
                    <td colspan="3">
                        <!--Voto Complessivo (immagine del maestro-->
                        <textarea input class="tablecell6 voti ta"  style=" height: 80px;" id ="giuquad1_cla_<?=$tipopagella?>" rows= "2" maxlength="1500" oninput="modificaincorso('giuquad1_cla_<?=$tipopagella?>');"><? echo (str_replace("\\n", "&#010;", $giuquad1_cla)); ?></textarea>

                    </td>
                </tr>
            </tbody>
        </table>
        <input id="numeromaterie_hidden_<?=$tipopagella?>" value="<?=$j;?>" hidden>
    </div>
</div>
<!-- ********************************************** TAB QUADRIMESTRE 2 **********************************************-->
<div class="tab-pane" id="Quadrimestre2" >
    <div class="col-md-12" class="center" style="margin-left: 20px;">
        <div class="row mt10">
            <div class="col-md-3">
                <button class="btnBlu w200px" onclick="showModalSalvaPagella(2, <?=$tipopagella?>);">Salva 2^ Quadr.</button>
            </div>
            <div class="col-md-3">
                <?if ($tipopagella != 0) {?>
                    <button class="btnGreyBordoViola w200px" id="Pagelle"
                    onclick="scaricaPagellaPOST(event, <?=$ID_alu;?>, '<?=$annoscolastico_cla;?>', '<?=$classe_cla;?>', '<?=$sezione_cla;?>', 2, <?=$tipopagella?>);" title="Pagella">Pagella</button>	
                <?}?>
            </div>
            <div class="col-md-3">
                <?if ($tipopagella2 != 0) {?>
                    <button class="btnGreyBordoBlu w200px" id="Pagelle"
                    onclick="scaricaPagellaPOST(event, <?=$ID_alu;?>, '<?=$annoscolastico_cla;?>', '<?=$classe_cla;?>', '<?=$sezione_cla;?>', 2, <?=$tipopagella2?>);" title="Doc. Valutazione ">Doc. Valutazione</button>
                <?}?>
            </div>
        </div>

        <table class="tabellaAlunniPagella1" style="width: 95%; margin-top: 10px;">
            <thead>
                <tr>
                    <td class="center w15">
                        Materia 
                    </td>
                    <td class="center w30">
                        Commento interno
                    </td>
                    <td class="center w5">
                        Voto
                    </td>
                    <td class="center w50">
                        Valutazione (<?=$nchar_paa?> caratteri)
                    </td>
                </tr>
            </thead>
            <tbody>
            <?
            $j = 0;
            mysqli_stmt_execute($stmt);
            while (mysqli_stmt_fetch($stmt)) {    
                ?>
                    <tr>
                        <td>
                            <!--Nome Materia-->
                            <textarea class="tablecell6 voti materia ta" type="text" style="margin-bottom: -3px; font-size: 12px; height:<?=$Hriga?>" disabled><?=$descmateria_mat_det;?></textarea>
                            <input class="tablecell voti materia" id ="mat_<?=$j?>_<?=$tipopagella?>" type="text"  value = "<?=$codmat_cla_det; ?>" hidden>
                        </td>
                        <td>
                            <!--Commento Interno-->
                            <textarea class="tablecell6 voti ta" id ="com2_<?=$j?>_<?=$tipopagella?>" style="margin-bottom: -3px; font-size: 12px; height:<?=$Hriga?>" rows= "2" maxlength="255"><?=$commento2_cla_det;?></textarea>
                        </td>
                        <td style="position: relative">
                            <?if($n_obiettivi) {?>
                                <img title='Inserisci Obiettivi' class="iconaStd iconaAbsolute iconaTransparent" src='assets/img/Icone/circle-plus-blue.svg'' onclick="showModalAddObiettivi(<?=$ID_mat?>, <?if($ID_cla) { echo($ID_cla); } else { echo('0'); }?>, 2);">
                            <?} else {?>
                                <!--Voto-->
                                <?if ($descmateria_mat_det != "Comportamento") {?>
                                    <!--Voto in una select costruita in base all'array di cui sopra, nel caso non sia Comportamento-->
                                    <select  id ="vot2_<?=$j?>_<?=$tipopagella?>" class="votcellgiu" style="height:<?=$Hriga?>; font-size: <?=$fontS?>px;  width:<?=$w1?>px; margin-top: -2px; margin-left: 0px" oninput="modificaincorso('vot2_<?=$j?>_<?=$tipopagella?>');">
                                        <?
                                        for ($x = 1; $x <= $CODtipovotoN; $x++) {?>
                                            <option value="<?=$CODtipovoto[$x]?>" <? if($vot2_cla_det==$CODtipovoto[$x]) {echo ('selected');} ?>><?=$DESCtipovoto[$x]?></option>
                                        <?}
                                        ?>
                                    </select>

                                <?} else {?>
                                    <!--Voto nel caso sia comportamento-->
                                    <select  id ="vot2_<?=$j?>_<?=$tipopagella?>" name="comportamento" class="votcellgiu" style="height:<?=$Hriga?>;  font-size: <?=$fontS?>px; width:<?=$w1?>px; margin-top: -2px; margin-left: 0px" oninput="modificaincorso('vot1_<?=$j?>_<?=$tipopagella?>');">
                                        <option value="0"  <? if($vot2_cla_det=="0") {echo ('selected');} ?>>-</option>
                                        <option value="GI" <? if($vot2_cla_det=="GI") {echo ('selected');} ?>>Gr.Insufficiente</option>
                                        <option value="I"  <? if($vot2_cla_det=="I") {echo ('selected');} ?>>Insufficiente</option>
                                        <option value="S"  <? if($vot2_cla_det=="S") {echo ('selected');} ?>>Sufficiente</option>
                                        <option value="D"  <? if($vot2_cla_det=="D") {echo ('selected');} ?>>Discreto</option>
                                        <option value="B"  <? if($vot2_cla_det=="B") {echo ('selected');} ?>>Buono</option>
                                        <option value="DT" <? if($vot2_cla_det=="DT") {echo ('selected');} ?>>Distinto</option>
                                        <option value="O"  <? if($vot2_cla_det=="O") {echo ('selected');} ?>>Ottimo</option>
                                    </select>
                                <?}?>
                            <?}?>
                        </td>
                        <td>
                            
                            <!--Valutazione descrittiva-->
                            <textarea class="tablecell6 voti ta" onkeyup="countCharGiu('giu2_<?=$j?>_<?=$tipopagella?>')" type="textarea" style="margin-bottom: -3px; height:<?=$Hriga?>;" id ="giu2_<?=$j?>_<?=$tipopagella?>" rows= "2"  oninput="modificaincorso('giu2_<?=$j?>_<?=$tipopagella?>');"><?=str_replace('\\','', (str_replace("\\n", "&#010;", $giu2_cla_det))); ?></textarea>
                            <div class="tablecell3 tmpCounterVoti" style="display: none"  id="CharNum_giu2_<?=$j?>_<?=$tipopagella?>" class="charNum"></div>

                            <!--PER FARE TEST USANDO LA FUNZIONE DI GENERAZIONE RANDOM DI STRINGHE-->
                            <!-- <textarea class="tablecell6 voti ta" type="textarea" style="border-bottom: 3px #1585b7 solid; margin-bottom: -3px; height:<?//=$Hriga?>;" id ="giu2_<?//=$j?>_<?//=$tipopagella?>" rows= "2" maxlength="<?//=$testlength?>" oninput="modificaincorso('giu2_<?//=$j?>_<?//=$tipopagella?>');"><?//=str_replace('\\','', (str_replace("\\n", "&#010;", generateRandomString()))); ?></textarea> -->

                            <!-- <img style="width: 20px; position: absolute; right:75px; cursor: pointer; display:none;" src='assets/img/Icone/pencil-edit-button2.svg' onclick="showEditGiudizio('giu2_<?//=$j;?>_<?//=$tipopagella?>' , '<?//=$classe_cla;?>','<?//=$codmat_cla_det;?>','2');"> -->
                            <? //echo (nl2br(stripcslashes($giu1_cla_det))); ?>
                        </td>
                    </tr>
                <?
                $j++ ;
            }?>
                <tr>
                    <td>
                        <textarea class="tablecell6 voti materia ta" type="text" style="font-size: 12px; height: 80px;" disabled>Rilevazione Progressi Sviluppo Personale e Sociale</textarea>
                    </td>
                    <td colspan="3">
                        <!--Voto Complessivo (immagine del maestro-->
                        <textarea input class="tablecell6 voti ta"  style="height: 80px;" id ="giuquad2_cla_<?=$tipopagella?>" rows= "2" maxlength="1500" oninput="modificaincorso('giuquad2_cla_<?=$tipopagella?>');"><? echo (str_replace("\\n", "&#010;", $giuquad2_cla)); ?></textarea>

                        <!-- <textarea input class="tablecell6 voti ta"  style="height: 80px;" id ="giuquad2_cla_1" rows= "2" maxlength="<?//=$testlength?>" oninput="modificaincorso('giuquad2_cla_1');"><?// echo (str_replace("\\n", "&#010;", generateRandomString())); ?></textarea> -->
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!--***************************************FORM MODALE INSERIMENTO OBIETTIVI **************************************************-->
<div class="modal" id="modalAddVotiObiettivi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px; width: 40%">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_AddVotiObiettivi" method="post">
						<span class="titoloModal">Inserimento Voti Obiettivi</span>
                        
						<div id="remove-contentVotiObiettivi" style="text-align: center; margin-top: 20px; "> <!-- START REMOVE CONTENT -->
							

						</div>
						<div class="alert alert-success" id="alertaggiungiVotiObiettivi" style="display:none; margin-top:10px;">
							<h4 id="alertmsgVotiObiettivi" style="text-align:center;"> 
							  Iscrizione completata con successo!
							</h4>
						</div>
						<div class="modal-footer" >

							<button type="button" id="btn_CancelModalObiettiviDescP" class="btnBlu" style="width:40%;" data-dismiss="modal">Annulla</button>
						<button type="button" id="btn_OKModalObiettiviDescP" class="btnBlu" style="width:40%;" onclick="salvaVotiObiettivi();">Salva</button>

						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<!--***************************************FINE FORM MODALE INSERIMENTO OBIETTIVI NELLE MATERIE **************************************************-->
<script>

    function setRunawayFalse() {
        //ogni volta che viene digitata una lettera la variabile che impedisce la chiusura accidentale viene valorizzata a false
        consentiRunAway = false;
    }


    function showModalAddObiettivi(ID_mat_obi, ID_cla, quad){
		//Mostro il form modale di inserimento degli obiettivi
		//Attenzione: potrebbe esistere già un ID_cla oppure potrebbe essere undefined
		//potrebbe non essere ancora stato creato il record in tab_classialunnivoti
		//Questo dovrà essere gestito nella routine!
		// console.log ("02det_IMieiAlunni.php - showModalInsertObiettivi - ID_mat e ID_cla");
		// console.log (ID_mat, ID_cla);
        if (ID_cla == 0) {
            $('#titolo01Msg_OK').html('INSERIMENTO OBIETTIVI'),
            $('#msg01Msg_OK').html("Questa pagella non è mai stata salvata prima<br>Per inserire gli obiettivi di questa pagella<br>è necessario (una tantum) <span style='color: red'>effettuare un salvataggio di questa pagella</span><br> con il pulsante disponibile in alto a sinistra"),
            $('#modal01Msg_OK').modal('show')
        } else {
            caricaObiettiviMateria(ID_mat_obi, ID_cla, quad);
            $("#alertaggiungiVotiObiettivi").hide();
            $("#remove-contentVotiObiettivi").show();
            $("#btn_OKModalObiettiviDescP").show();
            $("#btn_CancelModalObiettiviDescP").html('Annulla');
            
            $('#modalAddVotiObiettivi').modal({show: 'true'});
        }
	}

    function caricaObiettiviMateria(ID_mat_obi, ID_cla, quad) {
        classe_obd = $('#classe_cla_hidden').val();
		postData = { ID_mat_obi : ID_mat_obi, classe_obd: classe_obd, ID_cla : ID_cla, quad : quad};
		// console.log ("02inc_Pagella.php - caricaObiettiviMateria - postData a 02qry_ObiettiviVoti.php");
		// console.log (postData);
		$.ajax({
			type: 'POST',
			url: "02qry_ObiettiviVoti.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#remove-contentVotiObiettivi").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '02inc_Pagella caricaObiettiviMateria'");     
			}
		});

	}


    function salvaVotiObiettivi () {
        //Ho scritto in n_obiettivi_hidden questo numero
        n_obiettivi =   $('#n_obiettivi_hidden').val(); //Per ciclare sul numero di obiettivi che sono stati mostrati nel modal form. 
        quad =          $('#quad_hidden').val();        //Per sapere se devo salvare vot1_clo o vot2_clo
        ID_cla_clo =    $('#ID_cla_hidden').val();      //Finirà in ID_cla_clo: chiave esterna di ID_cla per legare gli obiettivi
        for (i = 1; i <= n_obiettivi; i++) {
            ID_clo = $('#ID_clo'+i).val();              //Finirà in ID_obi_clo: chiave esterna di ID_cla per legare questi record alla tabella delle descrizioni
            ID_obi_clo = $('#ID_obi'+i).val();              //Finirà in ID_obi_clo: chiave esterna di ID_cla per legare questi record alla tabella delle descrizioni
            vot1_clo = null;
            vot2_clo = null;
            if (quad == 1 ) { vot1_clo = $('#vot1_clo'+i).val();}            //=>vot1_clo
            if (quad == 2 ) { vot2_clo = $('#vot2_clo'+i).val();}            //=>vot1_clo
            //ora devo spedire alla funzione di set che farà una insert se ID_clo è nullo e una update se invece non lo è
            //Attenzione tutto dovrà essere condizionato a un pre salvataggio e refresh della pagella: DA FARE
            //salverò SOLO il voto che non è null, perchè quello dell'altro quadrimestre va lasciato stare com'è
            postData = { ID_clo: ID_clo, ID_cla_clo : ID_cla_clo, ID_obi_clo : ID_obi_clo, vot1_clo : vot1_clo, vot2_clo: vot2_clo, quad: quad};
            console.log ("02inc_Pagella.php - salvaVotiObiettivi - postData a 02qry_updateOinsertObiettivi.php");
            console.log (postData);
            $.ajax({
                type: 'POST',
                url: "02qry_setObiettivi.php",
                data: postData,
                dataType: 'json',
                success: function(data){
                    $("#alertmsgVotiObiettivi").html(data.msg);
                    $("#alertaggiungiVotiObiettivi").show();
                    $("#btn_CancelModalObiettiviDescP").html('Chiudi');
                    $("#btn_OKModalObiettiviDescP").hide();
                    $("#remove-contentVotiObiettivi").slideUp();
                    console.log(data.test);
                },
                error: function(){
                    alert("Errore: contattare l'amministratore fornendo il codice di errore '02inc_Pagella salvaVotiObiettivi'");     
                }
            });
        }
    }


    function countCharGiu(idToCount) {
        setRunawayFalse();
        //console.log(idToCount);
        var len = $('#'+idToCount).val().length;
        maxnchar = $('#nchar').val();
        if (len > maxnchar) {
            $('#'+idToCount).val( $('#'+idToCount).val().substring(0, maxnchar))
           //val.value = val.value.substring(0, 5000);
        } else {
            $('#CharNum_'+idToCount).show();
            $('#CharNum_'+idToCount).text((maxnchar - len)+ "\n caratteri rimanenti");
            setTimeout(function(){
                $('#CharNum_'+idToCount).hide();
            }, 3000);
        }
    };

</script>