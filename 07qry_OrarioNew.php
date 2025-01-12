<?	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
    
	$datagg[1] = $_POST['datalunedi'];
	$datagg[2] = date('Y-m-d',strtotime("+1 day", strtotime($datagg[1])));
	$datagg[3] = date('Y-m-d',strtotime("+2 day", strtotime($datagg[1])));
	$datagg[4] = date('Y-m-d',strtotime("+3 day", strtotime($datagg[1])));
	$datagg[5] = date('Y-m-d',strtotime("+4 day", strtotime($datagg[1])));
	$classe_ora = $_POST['classe_ora'];
	$sezione_ora = $_POST['sezione_ora'];
	$numore = intval($_SESSION['ore_orario']);
	$codmat_mttA = array();
	$descmateria_mtt = array();
	$giorni = array("lun", "mar", "mer", "gio", "ven");

	//Metto in un array $orariA le stringhe delle ore ("dalle... alle...")
	$sql = "SELECT ID_ore, orainizio_ore, orafine_ore FROM tab_ore ORDER BY N_ore";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_ore, $orainizio_ore, $orafine_ore);
	$orariA = array("idle");
	while (mysqli_stmt_fetch($stmt)) {
		$orainizio_ore = substr($orainizio_ore, 0, strlen($orainizio_ore)-3);
		$orafine_ore = substr($orafine_ore, 0, strlen($orafine_ore)-3);
		array_push($orariA, $orainizio_ore."-".$orafine_ore) ;
	}

	$materiaGGHH = array();
    $descmateriaGGHH = array();
	$secondomaestroA = array();
	$dateSeq = array("idle", $datagg[1], $datagg[2], $datagg[3], $datagg[4], $datagg[5]);
	$nome_cognome_mae = array();
	$firma_mae_oraA = array();
	$ID_maeA = array();
	$assente_oraA = array();
	$epocaA = array();


	//inizializzo la matrice delle ore
	//5 giorni
	for ($j = 1; $j <= 5; $j++) {
		for ($x = 1; $x <= $numore; $x++) {
			$materiaGGHH[$j*10+$x] = '-';
			$secondomaestroA[$j*10+$x] = 0; 										//per default metto 0, poi modifico con la query successiva
		}
	}

                    //PER LA DAD: estraggo l'annoscolastico (è sempre lo stesso in tutte le varie query, una per ogni ora, in ogni classe)
                    $sql = "SELECT annoscolastico_asc FROM tab_anniscolastici WHERE datainizio_asc <= ? AND datafine_asc >= ?";
                        
                    $stmt = mysqli_prepare($mysqli, $sql);
                    mysqli_stmt_bind_param($stmt, "ss", $datagg[1], $datagg[1]);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $annoscolastico_asc );
                    while (mysqli_stmt_fetch($stmt)) {
                    }

                    //PER LA DAD, per dire quanti su quanti: estraggo il numero di alunni (è sempre lo stesso per una certa classe)
                    $ID_aluA = array();

                    $sql = "SELECT ID_alu_cla FROM tab_classialunni WHERE ritirato_cla = 0 AND listaattesa_cla = 0 AND annoscolastico_cla =  ? AND classe_cla = ? AND sezione_cla = ? ";
                    
                    $stmt = mysqli_prepare($mysqli, $sql);
                    mysqli_stmt_bind_param($stmt, "sss", $annoscolastico_asc, $classe_ora, $sezione_ora);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $ID_alu_cla );
                    $nAlunniClasse = 0;
                    while (mysqli_stmt_fetch($stmt)) {
                        $nAlunniClasse++;
                        array_push($ID_aluA, $ID_alu_cla);
                    }




	//le ore si trovano nella tab_orario. Da qui estraggo le info rilevanti e le inserisco nelle varie matrici
	$sql = "SELECT ID_ora, epoca_ora, data_ora, ora_ora, codmat_ora, ID_mae, nome_mae, cognome_mae, firma_mae_ora, argomento_ora, assente_ora, secondomaestro_ora, descmateria_mtt 
    FROM (tab_orario LEFT JOIN tab_anagraficamaestri ON ID_mae = ID_mae_ora ) 
    LEFT JOIN tab_materie ON codmat_mtt = codmat_ora 
    WHERE (data_ora BETWEEN ? AND ?) 
    AND classe_ora = ? AND sezione_ora = ?
    ORDER BY data_ora, ora_ora, secondomaestro_ora";
	
    $stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ssss", $datagg[1], $datagg[5], $classe_ora, $sezione_ora);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_ora, $epoca_ora, $data_ora, $ora_ora, $codmat_ora, $ID_mae, $nome_mae, $cognome_mae, $firma_mae_ora, $argomento_ora, $assente_ora, $secondomaestro_ora, $descmateria_mtt);
	mysqli_stmt_store_result($stmt);
	while (mysqli_stmt_fetch($stmt)) {
		$j = array_search($data_ora, $dateSeq);		                //l'indice j da qui in avanti rappresenterà il giorno
		$x = $ora_ora;								                //x invece sarà l'ora
        if ($ora_ora == $ora_oraprev && $data_ora == $data_oraprev) {$k++;} else {$k= 1;}        //$k indica è il progressivo della materia
        $numMaterieA[$j*10+$x] = $k;                                //indice = 100*materia + 10*giorno + ora
        $epocaA[$j*10+$x] = $epoca_ora;                             //se è epoca


        //quelle che seguono sono relative a ciascuna materia/maestro
        $materiaGGHH			[$k*100+$j*10+$x] = $codmat_ora;						        //codice della materia (MAT, ITA ecc.)
        $descmateriaGGHH		[$k*100+$j*10+$x] = $descmateria_mtt;					        //desc materia (Italiano, matematica ecc.)
        $nome_cognome_mae		[$k*100+$j*10+$x] = substr($nome_mae, 0, 1).". ".$cognome_mae;	//N. Cognome maestro
        $firma_mae_oraA			[$k*100+$j*10+$x] = $firma_mae_ora;						        //se ha firmato
        $assente_oraA			[$k*100+$j*10+$x] = $assente_ora;					            //se è assente
        
        $ora_oraprev =  $ora_ora;   //essendo ORDERED BY ora_ora, se cambia quella devo azzerare il computo delle materie dell'ora
        $data_oraprev = $data_ora;
    }

	//una riga per ogni ora di lezione
	for ($x = 1; $x <= $numore; $x++) { ?>
	<tr>
		<td>
			<input class="tablelabel0" style="height: 60px; background-image: url('assets/img/backgroundcell2.jpg') !important; margin-bottom: 1px; " type="text" value = "<?=$x?>^ ora  [<?=$orariA[$x]?>]" disabled>
		</td>
		<?
		//una colonna per ogni giorno
		for ($j = 1; $j <= 5; $j++) { ?>
			<td style="width: 180px; border-bottom: 1px grey solid; height: 60px; overflow: hidden; overflow-y: auto; padding:0px; position: relative; border-right: 1px grey solid ">
                
                <!-- checkbox epoca -->
                <?if ($numMaterieA[$j*10+$x]) {?>
                <div style="position: absolute; left: 2px; top: 0px; z-index: 1000;">
                    <input class="epocacheckbox"
                    title="Epoca"
                    type="checkbox"
                    id="epoca<?echo ($j.$x)?>"
                    name="epoca"
                    style="width: 15px; padding: 0px; outline: none;
                    <?if($_SESSION['role_usr'] == 2 && $epocaA[$j*10+$x] == 0) {echo("display: none;");}?>" 
                    onclick="setEpoca('<?=$dateSeq[$j]?>', '<?=$x?>', '<?=$classe_ora?>', '<?=$sezione_ora?>', '<?=$j?><?=$x?>', <?=$j?>, <?=$x?>);"
                    <?if ($epocaA[$j*10+$x] == 1) { echo(" checked");}?>
                    <?if($_SESSION['role_usr'] == 2 && $epocaA[$j*10+$x] != 0) {echo(" onclick='return false;' onkeydown='return false;'");}?>
                    >
                </div>
                <?}?>

                <!-- search icon per aprire Modale-->
                <div style="position: absolute; left: -3px; bottom: 0px; z-index: 1000">
                    <? if($_SESSION['role_usr'] != 2) {?> 
                        <img src="assets/img/Icone/search-plus-solid.svg"
                        style="width: 15px; margin-left: 5px; cursor: pointer; z-index: 1000"
                        onclick="showModalTutor('<?=$dateSeq[$j]?>', '<?=$x?>', '<?=$classe_ora?>', '<?=$sezione_ora?>', '<?=$j?><?=$x?>', <?=$j?>, <?=$x?>);"
                        >
                    <?}?>
                </div>
                <?if($numMaterieA[$j*10+$x] != 0) {?>
                    <div style="position: absolute; right: 5px; top: -3px; z-index: 1000; ">



                        <!--CONTO QUANTI SONO IN DAD DI QUELLI DELLA CLASSE, NELL'ORA-->
                        <?$sql = "SELECT ID_ass, tipo_ass FROM `tab_assenze` LEFT JOIN tab_classialunni ON ID_alu_ass = ID_alu_cla 
                            WHERE 
                            
                            data_ass = ? 
                            AND ora_ass = ?
                            AND classe_cla = ?
                            AND sezione_cla = ?
                            AND annoscolastico_cla = ?
                            ";
                            $stmt = mysqli_prepare($mysqli, $sql);
                            mysqli_stmt_bind_param($stmt, "sisss", $dateSeq[$j], $x, $classe_ora, $sezione_ora, $annoscolastico_asc);	
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_bind_result($stmt, $ID_ass, $tipo_ass );
                            $alunniInDAD = 0;
                            $alunniAss = 0;
                            while (mysqli_stmt_fetch($stmt)) {
                                if ($tipo_ass == 2) {$alunniInDAD++;}
                                if ($tipo_ass == 0) {$alunniAss++;}

                            }?>



                        <button title="imposta DAD per tutti i presenti" 
                            class="btnDAD 
                            <?
                            $quantiDAD = 'None';

                            if ($nAlunniClasse == ($alunniInDAD + $alunniAss) && $nAlunniClasse != 0) {
                                $quantiDAD = 'All';
                                echo('btnDADAll');
                            }
                            else if ($alunniInDAD == 0) {
                                $quantiDAD = 'None';
                                echo('btnDADNone');
                            }
                            else {
                                $quantiDAD = 'Some';
                                echo('btnDADSome');
                            }

                            ?>
                            " 
                            onclick="setDAD('<?=$dateSeq[$j]?>', '<?=$x?>', '<?=$classe_ora?>', '<?=$sezione_ora?>', '<?=$j?><?=$x?>', <?=$j?>, <?=$x?>, '<?=$quantiDAD?>')" >
                        </button>
                    </div>

                <?}?>
                
                <?for ($k = 1; $k <= $numMaterieA[$j*10+$x]; $k++) {?>
                    <div class="row g-0" style="z-index: 100; position: relative">
                    <!-- descrizione materia -->
                    <input type="text"
                    style="margin-left: 12px; width: 72px; height: 20px; line-height:1; font-size: 10px;"
                    value ="<?=$descmateriaGGHH[$k*100+$j*10+$x]?>"
                    disabled>
                    <!-- N.Cognome maestro -->
                    <input type="text"
                    style="width: 72px; height: 20px; line-height:1; font-size: 10px"
                    value ="<?=$nome_cognome_mae[$k*100+$j*10+$x]?>"
                    disabled>


                    <!-- icona firmato e supplenza-->
                    <? if ($materiaGGHH[100+$j*10+$x] != '-' && $materiaGGHH[100+$j*10+$x] != 'nomat' && $materiaGGHH[100+$j*10+$x] != 'XX1' && $materiaGGHH[100+$j*10+$x] != 'XX3' && $materiaGGHH[100+$j*10+$x] != 'XX4' && $materiaGGHH[100+$j*10+$x] != 'XX5' ){?>
                        <img id="firmato" style="position: absolute; right: 28px; top: 6px; width: 15px; <? if ($nome_cognome_mae[$k*100+$j*10+$x] == ' ') {echo ('display: none');}?>" 
                        src="<?switch ($firma_mae_oraA[$k*100+$j*10+$x]){
                            case 0:echo 'assets/img/Icone/user-check-solid-red.svg';break;
                            case 1:echo 'assets/img/Icone/user-check-solid-green.svg';break;
                            case 2:echo 'assets/img/Icone/user-check-solid-yellow.svg';break;}?>">
                        <img title="Supplenza" 
                        src="assets/img/Icone/sync-alt-solid.svg"
                        style="<? if ($assente_oraA[$k*100+$j*10+$x]!=1) {echo (' display: none;');}?> width: 8px;" >
                    <?}?>
                    </div>
                <?}?>

                <input style="display:none" name="ID_mae_hidden" id="<? echo ("ID_mae_hidden".$j.$x) ?>" value ="<?=$ID_maeA[100+$j*10+$x]?>">
			</td>
		<?}?>
	</tr>
	<? } ?>
	
<script>

	function showModalTutor(data, ora, classe, sezione, indiceora_jx, j, x){
        //questa funzione mostra il modale di scelta della materia per l'ora selezionata.
        //si attiva su click della lente d'ingrandimento

        //Impostazione valori di testata nel modale
        let dataDDMMYYYY = moment(data).format("DD/MM/YYYY");
        $('#data2_new').val(dataDDMMYYYY);
        $('#ora2_new').val(ora);
        $('#classe2_new').val(classe);
        $('#sezione2_new').val(sezione);
        
        $("#remove-contentModalTutor").show();
        
        postData = {data: data, ora: ora, classe: classe, sezione: sezione, j: j, x: x};
        //vado a popolare la tabella materie e maestri a partire da data, ora, classe, sezione

        //console.log ("07OrarioNew.php - showModalTutor - postData a 07qry_getMaterieEMaestriNew.php")
		//console.log (postData);
        $.ajax({
            type: 'POST',
            url: "07qry_getMaterieEMaestriNew.php",
            data: postData,
            dataType: 'html',
            success: function(html){
                // console.log ("07OrarioNew.php - showModalTutor - ritorno da 07qry_getMaterieEMaestriNew.php")
		        // console.log (html);

                $("#MaterieEMaestriContainer").html(html);
                $('#alertModalTutor').removeClass('alert-danger');
                $('#alertModalTutor').addClass('alert-success');
                $("#alertModalTutor").hide();
                $("#btn_CancelModalTutor").html('Chiudi');
                $("#btn_OKModalTutor").show();
                $('#modalTutor').modal({show: 'true'});
            },
            error: function(){
                alert("Errore: contattare l'amministratore fornendo il codice di errore '07qry_OrarioNew ShowModalTutor'");      
            }
        });


	}

    function setEpoca(data, ora, classe, sezione, indiceora_jx, j, x) {

        let epoca = $('#epoca'+indiceora_jx).prop("checked");
        postData = {data: data, ora: ora, classe: classe, sezione: sezione, epoca: epoca};
        // console.log ("07OrarioNew.php - setEpoca - postData a 07qry_setEpocaNew.php")
		// console.log (postData);
        $.ajax({
            type: 'POST',
            url: "07qry_setEpocaNew.php",
            data: postData,
            dataType: 'json',
            success: function(data){
                console.log (data.test);
            },
            error: function(){
                alert("Errore: contattare l'amministratore fornendo il codice di errore '07qry_OrarioNew setEpoca'");      
            }
        });
    }


    function setDAD (data, ora, classe, sezione, indiceora_jx, j, x, quantiDAD) {
       
        postData = {data: data, ora: ora, classe: classe, sezione: sezione, quantiDAD: quantiDAD};
        console.log ("07OrarioNew.php - setDAD - postData a 07qry_setDAD.php")
        console.log (postData);
        $.ajax({
            type: 'POST',
            url: "07qry_setDAD.php",
            data: postData,
            dataType: 'json',
            success: function(data){
                console.log (data.test);
                requery();
            },
            error: function(){
                alert("Errore: contattare l'amministratore fornendo il codice di errore '07qry_OrarioNew setDAD'");      
            }
        });
    }

</script>
