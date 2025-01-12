<?include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	$ID_cov = $_POST ['ID_cov'];
	$annoscolastico_cla = $_POST['annoscolastico'];
    $classe_cla = $_POST['classe'];
    $sezione_cla = $_POST['sezione'];
    $codmat_cov = $_POST['codmat_cov'];
    $data_cov = $_POST['data_cov'];
    $tipo_cov = $_POST['tipo_cov'];
    $argomento_cov = $_POST['argomento_cov'];

	$ID_aluA = array();
	$nome_aluA = array();
	$cognome_aluA = array();
	$voto_vccA = array();



    ?>
    <div>Compito del: <?echo(timestamp_to_ggmmaaaa($data_cov));?></div>

    <table id="tabellaGiudizi" style="margin: auto; ">
        <thead>
            
            <tr>
                <th class="w40px">
                </th>
                <th>
                </th>
                <th>
                </th>
                <th>
                </th>
            </tr>
        </thead>
        <tbody id="tabellaGiudiziBody">
	
    <?
    $sql = "SELECT ID_alu, nome_alu, cognome_alu, giudizio_vcc 
    FROM (tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) LEFT JOIN tab_voticompitiverifiche ON ID_alu = ID_alu_vcc AND ID_cov_vcc = ?
    WHERE annoscolastico_cla = ? AND classe_cla = ? AND sezione_cla = ? AND listaattesa_cla = 0 ORDER BY cognome_alu, nome_alu";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "isss", $ID_cov, $annoscolastico_cla, $classe_cla, $sezione_cla);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $ID_alu, $nome_alu, $cognome_alu, $giudizio_vcc);
    $alunno = 1;
    while (mysqli_stmt_fetch($stmt)) {
        // $ID_aluA[$alunno] = $ID_alu;
        // $nome_aluA[$alunno] = $nome_alu;
		// $cognome_aluA[$alunno] = $cognome_alu;
        // $voto_vccA[$compito][$alunno] = $voto_vcc; //costruisco una matrice del tipo voto_vcc[progressivocompito] [progressivoalunno]

?>

        <tr>
			<td  class="h25 va-top">
				<button  style="width: 80%;" id="riga<?=$alunno?>" name="alu<?=$ID_alu;?>" disabled><?=$alunno;?></button>				
			</td>
			<td class="h25 va-top">
				<input class="tablecell3 disab" style="max-width:100px; " type="text" id="giu_nome_alu<?=$ID_alu?>" name="nome_alu" value = "<?=$nome_alu;?>" disabled>
			</td>
			<td class="h25 va-top">
				<input class="tablecell3 disab" style="max-width:100px;" type="text" id="giu_cognome_alu<?=$ID_alu?>" name="cognome_alu" value = "<?=$cognome_alu;?>" disabled>
			</td>
			<td class="h25">
				<textarea class="mini-font" style="min-height: 24px; height: 24px; width: 400px; resize: vertical;" maxlength="200" placeholder="max 200 caratteri" id="giudizio_vcc<?=$ID_alu?>" onchange="saveGiudizio(<?=$ID_cov?>, <?=$ID_alu?>)"><?=$giudizio_vcc;?></textarea>
			</td>
		</tr>

<?
        $alunno++;
    }
?>

    </tbody>
</table>	

